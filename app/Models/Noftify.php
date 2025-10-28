<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noftify extends Model
{
    use HasFactory;
    protected $table = 'noftify';

    protected $fillable = ['user_id', 'status'];
    public $timestamps = true; // ensure timestamps are enabled
}
