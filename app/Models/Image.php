<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;



    protected $table = "image";
    

    public function storedAsset()
    {
        return $this->belongsTo(StoredAssets::class, 'asset_id','assets_id');
        
    }
}
