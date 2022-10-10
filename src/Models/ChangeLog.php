<?php

namespace Administration\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Administration\Traits\ActivityLogOptionsTrait;

class ChangeLog extends Model
{
    //
    use LogsActivity, SoftDeletes, ActivityLogOptionsTrait;
    protected static $logName = 'change_log';
    protected static $logAttributes = ['*'];
    protected $table = 'doc_change_logs';
    protected $fillable = ['version', 'stability', 'description', 'created_by', 'updated_by'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($changelog) {
            $changelog->created_by = Auth::user()->id;
        });

        static::updating(function ($changelog) {
            $changelog->updated_by = Auth::user()->id;
        });

        static::deleting(function ($changelog) {
            $changelog->updated_by = Auth::user()->id;
        });
    }

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
            ->orWhere('version', 'like', "%" . $term . "%")
            ->orWhere('description', 'like', "%" . $term . "%")
            ->orWhere('stability', 'like', "%" . $term . "%");
    }

    public function scopeVersion($query)
    {
        return $query->distinct('version');
    }
}
