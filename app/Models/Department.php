<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\locations;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
class Department extends Model
{
    use HasFactory;
      protected $table = 'department';
    protected $fillable = ['company_id', 'code', 'name'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }


}
