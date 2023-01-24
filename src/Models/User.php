<?php

namespace Administration\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Administration\Traits\ActivityLogOptionsTrait;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, LogsActivity, HasRoles, HasApiTokens, ActivityLogOptionsTrait;
    protected $guard_name = 'web';
    protected static $logName = 'users';
    protected static $logAttributes = ['name', 'email'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'last_login', 'password_changed_at', 'login_attempts', 'is_api', 'landing_page', 'password', 'created_by', 'updated_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeTableData($query, $order_column, $order_by_str, $start, $length)
    {
        return $query->orderBy($order_column, $order_by_str)
            ->offset($start)
            ->limit($length);
    }

    public function menu()
    {
        return $this->belongsTo('Administration\Models\Menu', 'landing_page');
    }

    public function scopeSearchData($query, $term)
    {
        return $query
            ->Where('id', 'like', "%" . $term . "%")
            ->orWhere('name', 'like', "%" . $term . "%")
            ->orWhere('email', 'like', "%" . $term . "%")
            ->orWhereHas('menu', function ($query) use ($term) {
                $query->where('title', 'like', "%$term%");
            });
    }

//    public function hasAnyAccess($permission = [], $isId = false)
//    {
////        if (!Auth::user()) {
////            abort(403);
////        }
//
//        $user = User::with('roles')->find($this->id);
//        $roles = $user->roles;
//
//        $is_super_admin = $user->hasRole('Super Admin') ? true : false;
//        $is_admin = $user->hasRole('Admin') ? true : false;
//
//        if (($is_super_admin || $is_admin)) {
//            return true;
//        }
//
//        $permissions = is_array($permission) ? $permission : $permission->toArray();
//
//
//        if ($isId) {
//            $rolePermissions = Role::whereName($roles[0]->name)->first()->permissions->pluck('id')->toArray();
//        } else {
//            $rolePermissions = Role::whereName($roles[0]->name)->first()->permissions->pluck('name')->toArray();
//        }
////dd($permission->toArray());
////dd(array_intersect($permission->toArray(), $rolePermissions));
////dd($rolePermissions);
//        $intersects = array_intersect($permissions, $rolePermissions);
//        return !empty($intersects) ? true : false;
//    }

    public function generateMenu(){
        $user = $this;
        $roots = Menu::roots()->get();
        File::put(resource_path() . '/views/user_menu/' . $user->id . '.blade.php', View::make('Administration::menu.menu', compact('user','roots')));
    }

    public function scopeIsAdmin($query){
        return $query->hasRole(['Super Admin', 'Admin'])?1:0;
    }
}
