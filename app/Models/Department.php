<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\locations;
use Illuminate\Support\Facades\DB;
class Department extends Model
{
    use HasFactory;
    protected $table = 'department';


 public function departments()
    {
        return $this->hasMany(Department::class, 'company_id', 'id');
    }


}
