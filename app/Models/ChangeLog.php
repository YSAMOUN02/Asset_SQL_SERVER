<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    use HasFactory;

    protected $table = "change_log";
    protected $fillable = [
        'model',        // optional: e.g., App\Models\Movement
        'record_id',    // main record id
        'record_no',    // human-readable key
        'action',       // created, updated, deleted, import
        'user_id',      // who did the action
        'change_by',    // display name of user
        'section',      // section like 'Movement', 'Assets'
        'old_values',   // JSON before change
        'new_values',   // JSON after change
        'reason',       // optional reason.
        'old_values',
        'new_values',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
