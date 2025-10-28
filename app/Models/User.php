<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['key', 'varaint', 'change', 'section', 'change_by', 'user_id'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function Permission()
    {
        return $this->hasOne(Permission::class, 'user_id');
    }
    public function unit()
    {
        return $this->hasOne(UserUnit::class, 'user_id', 'id');
    }
    public function userUnit()
    {
        return $this->hasOne(UserUnit::class);
    }

    public function company()
    {
        return $this->hasOneThrough(Company::class, UserUnit::class, 'user_id', 'id', 'id', 'company_id');
    }

    public function department()
    {
        return $this->hasOneThrough(Department::class, UserUnit::class, 'user_id', 'id', 'id', 'department_id');
    }

    public function division()
    {
        return $this->hasOneThrough(Division::class, UserUnit::class, 'user_id', 'id', 'id', 'division_id');
    }

    public function section()
    {
        return $this->hasOneThrough(Section::class, UserUnit::class, 'user_id', 'id', 'id', 'section_id');
    }

    public function group()
    {
        return $this->hasOneThrough(Group::class, UserUnit::class, 'user_id', 'id', 'id', 'group_id');
    }
    public function notification()
    {
        return $this->hasOne(Noftify::class, 'user_id', 'id');
    }
}
