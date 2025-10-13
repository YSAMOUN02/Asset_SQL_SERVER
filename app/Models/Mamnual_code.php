<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mamnual_code extends Model
{
    use HasFactory;

    protected $table = 'mamnual_code';

        protected $fillable = [
        'code',
        'name',
        'type',
        'start',
        'end',
        'no',
        'end_no',
    ];
}
