<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ChangeLog;
use App\Models\Limit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChangeLogController extends Controller
{
    public function ChangeLog(Request $request, $page = 1)
    {
        $viewpoint = Limit::first();
        $limit = $viewpoint->limit ?? 50;

        // Base query with eager load
        $query = ChangeLog::with('users');

        // 🔹 Optional filters
        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        if ($request->filled('change_by')) {
            $query->where('change_by', $request->change_by);
        }

        // Get logs with pagination
        $changeLog = $query->latest('id')->paginate($limit, ['*'], 'page', $page);

        // Distinct values for filter dropdowns
        $change_by = ChangeLog::distinct()->pluck('change_by')->filter();
        $section   = ChangeLog::distinct()->pluck('section')->filter();

        return view("backend.list-change-log", [
            'changeLog'    => $changeLog,                 // already has pagination info
            'change_by'    => $change_by,                 // for dropdown filter
            'section'      => $section,                   // for dropdown filter
            'total_page'   => $changeLog->lastPage(),     // total pages
            'total_record' => $changeLog->total(),        // total records
            'page'         => $changeLog->currentPage(),  // current page
            'limit'        => $limit,
            'filters'      => $request->only(['section', 'change_by']), // pass active filters
        ]);
    }
}
