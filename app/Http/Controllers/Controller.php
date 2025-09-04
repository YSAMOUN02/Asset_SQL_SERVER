<?php

namespace App\Http\Controllers;

use App\Models\ChangeLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

abstract class Controller
{


    public function upload_image($image, $thumbnail = null, $var, $no)
    {
        $year = date('Y');
        $month = date('m');

        // Ensure the directory exists
        $path = public_path("storage/uploads/image/");
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // Get the original extension
        $extension = $image->getClientOriginalExtension();

        // Ensure the filename has an extension
        if (!$thumbnail) {
            $thumbnail = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        }
        $name = $thumbnail . '-NO' . $no . '.' . $extension;

        // Move the file to the correct path
        $image->move($path, $name);

        return $name;
    }

    public function upload_file($file)
    {
        // Generate a random name to avoid conflicts
        $FileName = $file->getClientOriginalName();

        // Move the uploaded file to the desired directory
        $file->move(public_path('uploads/files'), $FileName);

        return $FileName;
    }


    public function storeChangeLog($record_id, $record_no, $oldValues, $newValues, $action, $table, $reason)
    {
        ChangeLog::create([
            'record_id'   => $record_id,
            'record_no' => $record_no,
            'old_values' => $oldValues ?? '',
            'new_values' => $newValues ?? '',
            'action'     => $action,
            'section' => $table,
            'reason'     => $reason,
            'user_id'    => Auth::id(),
            'change_by'  => Auth::user()->name
        ]);
    }

    public function permission_alert($message)
    {

        return redirect()->back()->with('error', 'You do not has permission on ' . $message);
    }
    protected function parseDateOrDefault($date, $default = '1900-01-01')
    {
        try {
            if (!empty($date)) {
                return \Carbon\Carbon::parse($date)->format('Y-m-d');
            }
        } catch (\Exception $e) {
            // Invalid date, return default
        }
        return $default;
    }
}
