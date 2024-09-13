<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUser extends Model
{
    use HasFactory;
    protected $table = "file_user";

    public function storedAsset(){
        return $this->belongsTo(StoredAssetsUser::class, 'asset_id', 'id');
    }
}
