<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    use HasFactory;

    protected $table = "change_log";


    function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
