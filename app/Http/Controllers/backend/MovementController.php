<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\movement;
use App\Models\QuickData;
use App\Models\StoredAssets;
use App\Models\StoredAssetsUser;
use App\Models\User;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovementController extends Controller
{
    public function movement($id)
    {

        $last_assets = movement::where('assets_id', $id)
            ->where('status', 1)
            ->orderby('transaction_date', 'desc')
            ->first();

        if (!$last_assets) {
            return redirect()->back()->with('error', 'Asset can not be movement.');
        }
        return view('backend.add-movement', [
            'asset' => $last_assets
        ]);
    }
    public function movement_add_submit(request $request)
    {
        // 1. Validate form
        $request->validate([
            'last_assets_id' => 'required|integer',
            'assets2'        => 'nullable|string',
            'department'     => 'required|string',
            'company'        => 'required|string',
        ]);

        // 2. Find last asset by hidden ID
        $lastAsset = movement::with(['images', 'files'])
            ->where('assets_id', $request->last_assets_id)
            ->where('deleted', 0)
            ->first();

        if (!$lastAsset) {
            return back()->with('error', 'Asset not found.');
        }

        // 3. Duplicate base asset
        $newAsset = $lastAsset->replicate();
        $newAsset->assets1        = $lastAsset->assets1;
        $newAsset->assets2        = $request->assets2 ?? $lastAsset->assets2;
        $newAsset->reference      = $request->ref_movement ?? $lastAsset->reference;
        $newAsset->transaction_date = $request->transaction_date
            ? \Carbon\Carbon::parse($request->transaction_date)->format('Y-m-d')
            : $lastAsset->transaction_date;

        // Override holder/location/department/company/purpose
        $newAsset->asset_holder   = $request->holder ?? $lastAsset->asset_holder;
        $newAsset->holder_name    = $request->holder_name ?? $lastAsset->holder_name;
        $newAsset->location       = $request->location ?? $lastAsset->location;
        $newAsset->department     = $request->department ?? $lastAsset->department;
        $newAsset->company        = $request->company ?? $lastAsset->company;
        $newAsset->purpose        = $request->purpose ?? $lastAsset->purpose;
        $newAsset->status_recieved = $request->status_recieved ?? $lastAsset->status_recieved;
        $newAsset->initial_condition = $request->initial_condition ?? $lastAsset->initial_condition;

        // Backend state
        $newAsset->variant        = 1;
        $newAsset->last_varaint   = 1;
        $newAsset->deleted        = 0;
        $newAsset->deleted_at     = null;

        $newAsset->save();

        // 4. Copy related images to new variant
        foreach ($lastAsset->images as $image) {
            $newImage = $image->replicate();
            $newImage->asset_id = $newAsset->assets_id;
            $newImage->variant  = $newAsset->variant;
            $newImage->save();
        }

        // 5. Copy related files to new variant
        foreach ($lastAsset->files as $file) {
            $newFile = $file->replicate();
            $newFile->asset_id = $newAsset->assets_id;
            $newFile->variant  = $newAsset->variant;
            $newFile->save();
        }

        return redirect()->back()->with('success', 'Movement created successfully with images & files.');
    }
}

// $this->Change_log($asset_user->id, 0, "Insert", "Asset Record", Auth::user()->fname . " " . Auth::user()->name, Auth::user()->id);
