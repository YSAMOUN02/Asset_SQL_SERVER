<?php

namespace App\Http\Controllers;

use App\Models\ChangeLog;

abstract class Controller
{
    public function Change_log($id,$varaint,$change,$section,$change_by,$user_id){

        $new_change = new ChangeLog();
        $new_change->key = $id;
        $new_change->varaint = $varaint;
        $new_change->change = $change;
        $new_change->section = $section;
        $new_change->change_by = $change_by;
        $new_change->user_id = $user_id;
        $new_change->save();
    }

    public function upload_image($image, $thumbnail = null,$var,$no)
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
        $name = $thumbnail.'-V'.$var.'-NO'.$no.'.'.$extension;

        // Move the file to the correct path
        $image->move($path,$name);

        return $name ;
    }

    public function upload_file($file) {
        // Generate a random name to avoid conflicts
        $FileName = $file->getClientOriginalName();

        // Move the uploaded file to the desired directory
        $file->move(public_path('uploads/files'), $FileName);

        return $FileName;
    }




}
