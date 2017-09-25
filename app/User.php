<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    use SoftDeletes;

      /**
       * The attributes that should be mutated to dates.
       *
       * @var array
       */
    protected $dates = ['deleted_at'];

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    /**
    * Get the identifier that will be stored in the subject claim of the JWT.
    *
    * @return mixed
    */
     public function getJWTIdentifier()
     {
         return $this->getKey();
     }
     /**
      * Return a key value array, containing any custom claims to be added to the JWT.
      *
      * @return array
      */
     public function getJWTCustomClaims()
     {
         return [];
     }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function menus()
    {
      return $this->belongsToMany('App');
    }

    public function userRoles()
    {
      return $this->hasMany('App\UserRole', 'user_id', 'user_id');
    }

    public function articles()
    {
      return $this->belongsToMany('App\Article', 'article_permissions', 'user_id', 'article_id');
    }

    public function roles()
    {
      return $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id');
    }

    public function rolesByRoleId($role_id)
    {
      return $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id')->wherePivot('role_id', $role_id);
    }

    public function menusByRole()
    {
      $roles = $this->roles;

      $menus = []; $i = 0;

      foreach ($roles as $key => $value) {

        foreach ($value->menus as $key => $val2) {

          $menus[$i] = $val2;

          $i++;
        }
      }

      return $menus;
    }
}