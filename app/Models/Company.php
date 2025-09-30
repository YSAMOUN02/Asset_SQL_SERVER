<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\UserUnit;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';
    protected $fillable = ['code', 'name'];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, UserUnit::class, 'company_id', 'id', 'id', 'user_id');
    }
}
