<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class movement extends Model
{
    use HasFactory;
    protected $table = 'movement';

    public function assets()
    {
        return $this->belongsTo(StoredAssets::class, 'assets_no');
    }
    
    
}
