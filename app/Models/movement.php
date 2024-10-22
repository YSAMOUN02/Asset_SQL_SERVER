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
<<<<<<< HEAD
        return $this->belongsTo(StoredAssets::class, 'assets_id');
    }


=======
        return $this->belongsTo(StoredAssets::class, 'assets_no');
    }
    
    
>>>>>>> 7e8c0a5877d164739db0cb203f83f0f2a0f09149
}
