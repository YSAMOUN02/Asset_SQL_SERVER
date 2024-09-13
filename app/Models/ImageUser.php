<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageUser extends Model
{
    use HasFactory;
    protected $table = "image_user";

    public function storedAsset(){
        return $this->belongsTo(StoredAssetsUser::class, 'asset_id', 'id');
    }
}
