<?php

namespace App\Http\Controllers;

use App\Models\ChangeLog;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    public function Change_log($id, $varaint, $change, $section, $change_by, $user_id)
    {

        $new_change = new ChangeLog();
        $new_change->key = $id;
        $new_change->varaint = $varaint;
        $new_change->change = $change;
        $new_change->section = $section;
        $new_change->change_by = $change_by;
        $new_change->user_id = $user_id;
        $new_change->save();
    }

    public function upload_image($image, $thumbnail = null, $var, $no)
    {
        $year = date('Y');
        $month = date('m');

        // Ensure the directory exists
        $path = public_path("storage/uploads/image/{$year}/{$month}");
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // Get the original extension
        $extension = $image->getClientOriginalExtension();

        // Ensure the filename has an extension
        if (!$thumbnail) {
            $thumbnail = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        }
        $name = $thumbnail . '-V' . $var . '-NO' . $no . '.' . $extension;

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


    public static function storeChangeLog($record, $action = 'created', $section = 'General', $reason = null, $old_values = null)
    {
        return ChangeLog::create([
            'action'      => $action,
            'record_id'   => $record->id,
            'record_no'   => ($record->assets1 ?? '') . ($record->assets2 ?? ''),
            'user_id'     => Auth::id() ?? null,
            'change_by'   => Auth::user()->name ?? 'System',
            'section'     => $section,
            'old_values'  => $old_values ? json_encode($old_values) : null,
            'new_values'  => json_encode($record),
            'reason'      => $reason,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
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
