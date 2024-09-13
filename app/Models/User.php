<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
    public function Permission(){
        return $this->hasOne(Permission::class, 'id');
    }
   // Define the relationship with the Permission model
   public function permissions()
   {
       return $this->hasOne(Permission::class);
   }

   // Check if a user has a specific permission for users
   public function hasUserPermission($permission)
   {
       return $this->permissions->$permission === '1';
   }

   // Check if a user has a specific permission for assets
   public function hasAssetPermission($permission)
   {
       return $this->permissions->$permission === '1';
   }

   // Helper methods for user permissions
   public function canUserRead()
   {
       return $this->hasUserPermission('user_read');
   }

   public function canUserWrite()
   {
       return $this->hasUserPermission('user_write');
   }

   public function canUserExecute()
   {
       return $this->hasUserPermission('user_execute');
   }

   public function canUserUpdate()
   {
       return $this->hasUserPermission('user_update');
   }

   // Helper methods for asset permissions
   public function canAssetsRead()
   {
       return $this->hasAssetPermission('assets_read');
   }

   public function canAssetsWrite()
   {
       return $this->hasAssetPermission('assets_write');
   }

   public function canAssetsExecute()
   {
       return $this->hasAssetPermission('assets_execute');
   }

   public function canAssetsUpdate()
   {
       return $this->hasAssetPermission('assets_update');
   }
}
