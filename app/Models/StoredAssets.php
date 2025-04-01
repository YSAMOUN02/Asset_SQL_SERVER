<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoredAssets extends Model
{
    use HasFactory;

    protected $table = 'assets';



    public function images()
    {
           return $this->hasMany(Image::class, 'asset_id', 'assets_id');


    }
    public function files()
    {
        return $this->hasMany(File::class, 'asset_id', 'assets_id');

    }

    public function movements(){
        return $this->hasMany(service_categories::class,'assets_id','id');
      }
}
