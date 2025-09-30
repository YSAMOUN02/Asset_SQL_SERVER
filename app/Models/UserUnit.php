<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\Division;
use App\Models\Section;
use App\Models\Group;
class UserUnit extends Model
{
        use HasFactory;
        protected $table = 'user_unit';
        protected $fillable = [
            'user_id',
            'company_id',
            'department_id',
            'division_id',
            'section_id',
            'group_id'
        ];

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function company()
        {
            return $this->belongsTo(Company::class);
        }

        public function department()
        {
            return $this->belongsTo(Department::class);
        }

        public function division()
        {
            return $this->belongsTo(Division::class);
        }

        public function section()
        {
            return $this->belongsTo(Section::class);
        }

        public function group()
        {
            return $this->belongsTo(Group::class);
        }
}
