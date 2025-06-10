<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
class Company extends Model
{
    use HasFactory;

    protected $table = 'company';

    public function Departments(){
        return $this->hasMany(Department::class,'company_id','id');
      }
}
