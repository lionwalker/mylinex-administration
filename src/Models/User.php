<?php

namespace Administration\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Traits\HasRoles;
use Administration\Traits\ActivityLogOptionsTrait;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasRoles, ActivityLogOptionsTrait;
    protected $guard_name = 'web';
    protected static $logName = 'users';
    protected static $logAttributes = ['name', 'email'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'created_by', 'updated_by',
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

    public function scopeSearchData($query, $term)
    {
        return $query
            ->Where('id', 'like', "%" . $term . "%")
            ->orWhere('name', 'like', "%" . $term . "%")
            ->orWhere('email', 'like', "%" . $term . "%");
    }

    public function generateMenu(){
        $user = $this;
        $roots = Menu::roots()->get();
        File::put(resource_path() . '/views/user_menu/' . $user->id . '.blade.php', View::make('Administration::menu.menu', compact('user','roots')));
    }

    public function scopeIsAdmin($query){
        return $query->hasRole(['Super Admin', 'Admin'])?1:0;
    }
}
