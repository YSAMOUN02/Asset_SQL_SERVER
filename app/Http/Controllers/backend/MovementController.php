<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Asset_code;
use App\Models\Company;
use App\Models\Department;
use App\Models\movement;
use App\Models\Reference;
use Carbon\Carbon;
use Illuminate\Http\Request;


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

        $company = Company::all();
        $departments = Department::all();
        $assets2 = Asset_code::all();
        $today = Carbon::today()->toDateString();

        $references = Reference::where('type', 'Movement')
            ->whereDate('start', '<=', $today)
            ->whereDate('end', '>=', $today)
            ->select('code', 'no', 'name', 'id')
            ->get();
        return view('backend.add-movement', [
            'asset' => $last_assets,
            'company' => $company,
            'departments' => $departments,
            'assets2' => $assets2,
            'references' => $references,
        ]);
    }
    public function movement_add_submit(Request $request)
    {

        // return $request;
        $request->validate([
            'last_assets_id' => 'required|integer',
            'assets2'        => 'nullable|string',
            'department'     => 'required|string',
            'company'        => 'required|string',
        ]);

        if (!empty($request->input('reference_id'))) {
            $refernece = Reference::where('id', $request->reference_id)->first();
            if ($refernece) {
                $refernece->no = $refernece->no + 1;
                $refernece->save();
            }
        }

        $lastAsset = movement::where('assets_id', $request->last_assets_id)
            ->where('status', 1)
            ->orderby('transaction_date', 'desc')
            ->first();

        if (!$lastAsset) {
            return back()->with('error', 'Asset not found.');
        }

        $newAsset = $lastAsset->replicate();
        $newAsset->assets1          = $lastAsset->assets1;
        $newAsset->assets2          = $request->assets2 ?? $lastAsset->assets2;
        $newAsset->reference        = $request->ref_movement ?? $lastAsset->reference;
        $newAsset->transaction_date = $request->transaction_date
            ? \Carbon\Carbon::parse($request->transaction_date)->format('Y-m-d')
            : $lastAsset->transaction_date;

        $newAsset->asset_holder      = $request->holder ?? $lastAsset->asset_holder;
        $newAsset->holder_name       = $request->holder_name ?? $lastAsset->holder_name;
        $newAsset->location          = $request->location ?? $lastAsset->location;
        $newAsset->department        = $request->department ?? $lastAsset->department;
        $newAsset->company           = $request->company ?? $lastAsset->company;
        $newAsset->purpose           = $request->purpose ?? $lastAsset->purpose;
        $newAsset->status_recieved   = $request->status_recieved ?? $lastAsset->status_recieved;
        $newAsset->initial_condition = $request->initial_condition ?? $lastAsset->initial_condition;

        $newAsset->variant       = 1;
        $newAsset->last_varaint  = 1;
        $newAsset->deleted       = 0;
        $newAsset->deleted_at    = null;
        $newAsset->status        = 1;
        $newAsset->save();

        // Copy images
        $lastAsset->images()->where('variant', $lastAsset->variant)->get()->each(function ($image) use ($newAsset) {
            $newImage = $image->replicate();
            $newImage->asset_id = $newAsset->assets_id;
            $newImage->variant  = $newAsset->variant;
            $newImage->save();
        });

        // Copy files
        $lastAsset->files()->where('variant', $lastAsset->variant)->get()->each(function ($file) use ($newAsset) {
            $newFile = $file->replicate();
            $newFile->asset_id = $newAsset->assets_id;
            $newFile->variant  = $newAsset->variant;
            $newFile->save();
        });

        // Set old assets inactive
        movement::where('assets1', $lastAsset->assets1)
            ->where('assets_id', '<>', $newAsset->assets_id)
            ->update(['status' => 0]);

        // Fields to log
        $fieldsToLog = [
            'assets1'           => 'Asset',
            'reference'         => 'Reference / Movement',
            'transaction_date'  => 'Transaction Date',
            'holder_name'       => 'Holder Name',
            'asset_holder'      => 'Holder',
            'location'          => 'To Location',
            'department'        => 'To Department',
            'company'           => 'To Company',
            'initial_condition' => 'Current Initial Condition',
            'status_recieved'   => 'Status Received',
        ];

        foreach ($fieldsToLog as $field => $label) {
            if ($field == 'assets1') {
                $oldVal = $lastAsset->assets1 . (!empty($lastAsset->assets2) ? '-' . $lastAsset->assets2 : '');
                $newVal = $newAsset->assets1 . (!empty($newAsset->assets2) ? '-' . $newAsset->assets2 : '');
            } else {
                $oldVal = $lastAsset->$field ?? '-';
                $newVal = $newAsset->$field ?? '-';
                if ($field == 'transaction_date') {
                    $oldVal = $oldVal ? \Carbon\Carbon::parse($oldVal)->format('Y-m-d') : '-';
                    $newVal = $newVal ? \Carbon\Carbon::parse($newVal)->format('Y-m-d') : '-';
                }
            }

            $this->storeChangeLog(
                $newAsset->assets_id,
                $newAsset->assets1,
                "$label: $oldVal",
                "$label: $newVal",
                'Movement',
                'movement',
                $newAsset->purpose ?? 'Asset movement created'
            );
        }

        return redirect('/admin/assets/transaction/1')
            ->with('success', 'Movement created successfully, old assets set inactive.');
    }
}
