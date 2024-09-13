<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = "file";
    
    public function storedAsset(){
        return $this->belongsTo(StoredAssets::class, 'asset_id', 'assets_id');
    }
}
