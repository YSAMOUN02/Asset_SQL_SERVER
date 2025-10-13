<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Asset_code;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Department;
use App\Models\Division;
use App\Models\Section;
use App\Models\Group;
use App\Models\Mamnual_code;
use App\Models\User;
use App\Models\UserUnit;
use Illuminate\Support\Facades\DB;
class Data_setupController extends Controller
{


    public function hierarchical()
    {
        $companies = Company::with('departments.divisions.sections.groups')->get();

        $companies->map(function ($comp) {
            $comp->canDelete = $this->isNodeDeletable('company', $comp->id);
            return $comp;
        });
        $departments = Department::all();
        $divisions = Division::all();
        $sections = Section::all();
        $groups = Group::all();

        return view('backend.hierarchical', ['company' => $companies, 'departments' => $departments, 'divisions' => $divisions, 'sections' => $sections, 'groups' => $groups]);
    }

    /**
     * Check recursively if a node and its subtree has no users.
     */
    private function isNodeDeletable($type, $id)
    {
        // Check if this node has any users
        $hasUsers = UserUnit::where("{$type}_id", $id)->exists();
        if ($hasUsers) return false;

        // Get children depending on type
        $children = match ($type) {
            'company'    => Department::where('company_id', $id)->get(),
            'department' => Division::where('department_id', $id)->get(),
            'division'   => Section::where('division_id', $id)->get(),
            'section'    => Group::where('section_id', $id)->get(),
            default      => collect(),
        };

        foreach ($children as $child) {
            if (!$this->isNodeDeletable($child->getTable(), $child->id)) {
                return false;
            }
        }

        return true;
    }
    public function children($type, $id)
    {
        try {
            $data = collect();

            switch ($type) {
                case 'company':
                    $departments = \App\Models\Department::where('company_id', $id)->get();
                    $data = $departments->map(fn($d) => [
                        'id' => $d->id,
                        'code' => $d->code,
                        'name' => $d->name,
                        'type' => 'department',
                        'total_users' => UserUnit::where('department_id', $d->id)->count()
                    ]);
                    break;

                case 'department':
                    $divisions = \App\Models\Division::where('department_id', $id)->get();
                    $data = $divisions->map(fn($d) => [
                        'id' => $d->id,
                        'code' => $d->code,
                        'name' => $d->name,
                        'type' => 'division',
                        'total_users' => UserUnit::where('division_id', $d->id)->count()
                    ]);
                    break;

                case 'division':
                    $sections = \App\Models\Section::where('division_id', $id)->get();
                    $data = $sections->map(fn($s) => [
                        'id' => $s->id,
                        'code' => $s->code,
                        'name' => $s->name,
                        'type' => 'section',
                        'total_users' => UserUnit::where('section_id', $s->id)->count()
                    ]);
                    break;

                case 'section':
                    $groups = \App\Models\Group::where('section_id', $id)->get();
                    $data = $groups->map(fn($g) => [
                        'id' => $g->id,
                        'code' => $g->code,
                        'name' => $g->name,
                        'type' => 'group',
                        'total_users' => UserUnit::where('group_id', $g->id)->count()
                    ]);
                    break;
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Fetch users for any node
    public function users($type, $id)
    {
        try {
            $query = UserUnit::query();

            switch ($type) {
                case 'company':
                    $query->where('company_id', $id);
                    break;
                case 'department':
                    $query->where('department_id', $id);
                    break;
                case 'division':
                    $query->where('division_id', $id);
                    break;
                case 'section':
                    $query->where('section_id', $id);
                    break;
                case 'group':
                    $query->where('group_id', $id);
                    break;
            }



            $users = $query->with('user:id,name,email')
                ->get()
                ->map(fn($u) => $u->user)
                ->filter()
                ->unique('id')
                ->values();


            // Append readable location for each user
            $users->transform(function ($user) {
                $parts = [];
                if ($user->company) $parts[] = $user->company->name;
                if ($user->department) $parts[] = $user->department->name;
                if ($user->division) $parts[] = $user->division->name;
                if ($user->section) $parts[] = $user->section->name;
                if ($user->group) $parts[] = $user->group->name;

                $user->location_path = implode(' / ', $parts);
                $user->full_name = trim($user->fname . ' ' . $user->lname);
                return $user;
            });






            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function moveUser(Request $request)
    {
        $request->validate([
            'userId' => 'required|integer|exists:user_unit,user_id',
            'targetType' => 'required|string|in:company,department,division,section,group',
            'targetId' => 'required|integer'
        ]);

        $userUnit = DB::table('user_unit')->where('user_id', $request->userId)->first();

        if (!$userUnit) {
            return response()->json(['success' => false, 'message' => 'User unit not found']);
        }

        $data = [
            'company_id' => null,
            'department_id' => null,
            'division_id' => null,
            'section_id' => null,
            'group_id' => null,
        ];

        switch ($request->targetType) {
            case 'company':
                $data['company_id'] = $request->targetId;
                break;
            case 'department':
                $dept = DB::table('department')->where('id', $request->targetId)->first();
                $data['company_id'] = $dept->company_id;
                $data['department_id'] = $dept->id;
                break;
            case 'division':
                $div = DB::table('division')->where('id', $request->targetId)->first();
                if (!$div) return response()->json(['success' => false, 'message' => 'Division not found']);

                $dept = DB::table('department')->where('id', $div->department_id)->first();
                if (!$dept) return response()->json(['success' => false, 'message' => 'Department not found']);

                $data['company_id'] = $dept->company_id; // get from department
                $data['department_id'] = $div->department_id;
                $data['division_id'] = $div->id;
                break;

            case 'section':
                $sec = DB::table('section')->where('id', $request->targetId)->first();
                if (!$sec) return response()->json(['success' => false, 'message' => 'Section not found']);

                $div = DB::table('division')->where('id', $sec->division_id)->first();
                if (!$div) return response()->json(['success' => false, 'message' => 'Division not found']);

                $dept = DB::table('department')->where('id', $div->department_id)->first();
                if (!$dept) return response()->json(['success' => false, 'message' => 'Department not found']);

                $data['company_id'] = $dept->company_id;
                $data['department_id'] = $dept->id;
                $data['division_id'] = $div->id;
                $data['section_id'] = $sec->id;
                break;

            case 'group':
                $grp = DB::table('group')->where('id', $request->targetId)->first();
                if (!$grp) return response()->json(['success' => false, 'message' => 'Group not found']);

                $sec = DB::table('section')->where('id', $grp->section_id)->first();
                $div = DB::table('division')->where('id', $sec->division_id)->first();
                $dept = DB::table('department')->where('id', $div->department_id)->first();

                $data['company_id'] = $dept->company_id;
                $data['department_id'] = $dept->id;
                $data['division_id'] = $div->id;
                $data['section_id'] = $sec->id;
                $data['group_id'] = $grp->id;
                break;
        }

        DB::table('user_unit')->where('user_id', $request->userId)->update($data);

        return response()->json(['success' => true]);
    }
    // Add child node
    public function addChild(Request $request, $type, $parentId)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string'
        ]);

        switch ($type) {
            case 'company':
                $child = Department::create([
                    'company_id' => $parentId,
                    'name' => $request->name,
                    'code' => $request->code
                ]);
                break;

            case 'department':
                $child = Division::create([
                    'department_id' => $parentId,
                    'name' => $request->name,
                    'code' => $request->code
                ]);
                break;

            case 'division':
                $child = Section::create([
                    'division_id' => $parentId,
                    'name' => $request->name,
                    'code' => $request->code
                ]);
                break;

            case 'section':
                $child = Group::create([
                    'section_id' => $parentId,
                    'name' => $request->name,
                    'code' => $request->code
                ]);
                break;

            default:
                return response()->json(['success' => false, 'message' => 'Cannot add child here']);
        }

        return response()->json(['success' => true, 'child' => $child]);
    }
    public function addCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string'
        ]);

        $company = Company::create([
            'name' => $request->name,
            'code' => $request->code
        ]);

        return response()->json(['success' => true, 'node' => $company]);
    }
    // Data_setupController.php

    public function updateNode(Request $request, $type, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string',
        ]);

        try {
            switch ($type) {
                case 'company':
                    $node = \App\Models\Company::findOrFail($id);
                    break;

                case 'department':
                    $node = \App\Models\Department::findOrFail($id);
                    break;

                case 'division':
                    $node = \App\Models\Division::findOrFail($id);
                    break;

                case 'section':
                    $node = \App\Models\Section::findOrFail($id);
                    break;

                case 'group':
                    $node = \App\Models\Group::findOrFail($id);
                    break;

                default:
                    return response()->json(['success' => false, 'message' => 'Invalid type']);
            }

            $node->name = $request->name;
            $node->code = $request->code;
            $node->save();

            return response()->json(['success' => true, 'node' => $node]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function code_setup()
    {
        $Asset_code = Asset_code::all();
        return view('backend.oganization_code', ['Asset_code' => $Asset_code]);
    }
    public function code_new_submit(Request $request)
    {

        $assetCode = new Asset_code();
        $assetCode->code = $request->code;
        $assetCode->name = $request->name;
        $assetCode->save();

        return redirect()->back()->with('success', 'New asset code added successfully.');
    }
    public function code_update_submit(Request $request)
    {
        // return $request->all();

        $assetCode = Asset_code::where('id', ($request->id))->first();
        if ($assetCode) {
            $assetCode->name = $request->name;
            $assetCode->code = $request->code;
            $assetCode->save();

            return redirect()->back()->with('success', 'Asset code updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Asset code not found.');
        }
    }
    public function code_delete_submit(Request $request)
    {

        $assetCode = Asset_code::where('id', ($request->id))->first();
        if ($assetCode) {
            $assetCode->delete();
            return redirect()->back()->with('success', 'Asset code deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Asset code not found.');
        }
    }

    public function reference_setup()
    {
        $references = \App\Models\Reference::all();

        return view('backend.reference', ['references' => $references]);
    }

    public function reference_new_submit(Request $request)
    {
        // return $request->all();


        $reference = new \App\Models\Reference();
        $reference->code = $request->code;
        $reference->no = $request->no;
        $reference->name = $request->name;
        $reference->type = $request->type;
        $reference->start = $request->start;
        $reference->end = $request->end;
        $reference->save();

        return redirect()->back()->with('success', 'New reference added successfully.');
    }

    public function reference_update_submit(Request $request)
    {
        $request->validate([
            'id'    => 'required|exists:references,id',
            'code'  => 'required|string|max:50',
            'no'    => 'required|integer',
            'name'  => 'required|string|max:100',
            'type'  => 'required|string|max:50',
            'start' => 'required|date',
            'end'   => 'required|date|after_or_equal:start',
        ]);

        $reference = \App\Models\Reference::findOrFail($request->id);

        $reference->code  = $request->code;
        $reference->no    = $request->no;
        $reference->name  = $request->name;
        $reference->type  = $request->type;
        $reference->start = $request->start;
        $reference->end   = $request->end;

        $reference->save();

        return redirect()->back()->with('success', 'Reference updated successfully.');
    }
    public function reference_delete_submit(Request $request)
    {


        $reference = \App\Models\Reference::where('id', $request->id)->first();
        $reference->delete();

        return redirect()->back()->with('success', 'Reference deleted successfully.');
    }

    public function search_user_hierarchy(Request $request)
    {
        $type = $request->query('type');  // from dropdown
        $query = $request->query('query');

        $users = User::query()
            ->when($type === 'name', fn($q) => $q->whereRaw("CONCAT(fname,' ',lname) LIKE ?", ["%{$query}%"]))
            ->when($type === 'id_card', fn($q) => $q->where('id_card', 'like', "%{$query}%"))
            ->when($type === 'email', fn($q) => $q->where('email', 'like', "%{$query}%"))
            ->when($type === 'role', fn($q) => $q->where('role', 'like', "%{$query}%"))
            ->when($type === 'position', fn($q) => $q->where('position', 'like', "%{$query}%"))
            ->when($type === 'phone', fn($q) => $q->where('phone', 'like', "%{$query}%"))
            ->when(
                in_array($type, ['company', 'department', 'division', 'section', 'group']),
                fn($q) =>
                $q->whereHas($type, fn($q2) => $q2->where('name', 'like', "%{$query}%"))
            )
            ->limit(20)
            ->get(['id', 'fname', 'lname', 'email']);



        return response()->json($users);
    }
    public function searchDatalist(Request $request)
    {
        $type = $request->query('type');
        $query = $request->query('query', '');

        $options = [];

        if (in_array($type, ['company', 'department', 'division', 'section', 'group'])) {
            $modelMap = [
                'company' => Company::class,
                'department' => Department::class,
                'division' => Division::class,
                'section' => Section::class,
                'group' => Group::class,
            ];

            $options = $modelMap[$type]::where('name', 'like', "%{$query}%")
                ->limit(10)
                ->pluck('name')
                ->toArray();
        } elseif (in_array($type, ['id_card', 'email', 'role', 'position', 'phone'])) {
            $options = User::where($type, 'like', "%{$query}%")
                ->limit(10)
                ->pluck($type)
                ->filter() // remove nulls
                ->unique()
                ->toArray();
        } elseif ($type == 'user') {
            // Search by full name (fname + lname)
            $options = User::whereRaw("CONCAT(fname,' ',lname) LIKE ?", ["%{$query}%"])
                ->limit(10)
                ->pluck(DB::raw("CONCAT(fname,' ',lname) AS full_name"))
                ->toArray();
        }

        return response()->json($options);
    }




     public function code_mamnual_setup()
    {
        $mamnual_code = Mamnual_code::all();


        return view('backend.mamnual-code', [
            'mamnual_code' => $mamnual_code


        ]);
    }
    public function code_mamnual_submit(Request $request)
    {
    // return $request->all();


        $Mamnual_code = new Mamnual_code();
        $Mamnual_code->code = $request->code;
        $Mamnual_code->no = $request->no;
        $Mamnual_code->name = $request->name;
        $Mamnual_code->type = "Assets";
        $Mamnual_code->start = $request->start;
        $Mamnual_code->end = $request->end;
        $Mamnual_code->save();

        return redirect()->back()->with('success', 'New Mamnual Code added successfully.');
    }
    public function code_mamnual_update_submit(Request $request)
    {


        $Mamnual_code = Mamnual_code::where('id',$request->id)->first();

        $Mamnual_code->code  = $request->code;
        $Mamnual_code->no    = $request->no;
        $Mamnual_code->name  = $request->name;
        $Mamnual_code->start = $request->start;
        $Mamnual_code->end   = $request->end;

        $Mamnual_code->save();

        return redirect()->back()->with('success', 'Mamnual code updated successfully.');
    }
    public function code_mamnual_delete_submit(Request $request)
    {

        $assetCode = Mamnual_code::where('id', ($request->id))->first();
        if ($assetCode) {
            $assetCode->delete();
            return redirect()->back()->with('success', 'Mamnual code deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Mamnual code not found.');
        }
    }
}
