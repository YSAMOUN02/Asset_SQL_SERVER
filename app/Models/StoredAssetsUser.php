<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class StoredAssetsUser extends Model
{
    use HasFactory;

    protected $table = 'asset_user';

    public function images(){
        return $this->hasMany(ImageUser::class, 'asset_id', 'id');
    }
    public function files(){
        return $this->hasMany(FileUser::class, 'asset_id', 'id');
    }
}
