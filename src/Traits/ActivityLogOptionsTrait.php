<?php

namespace Administration\Traits;

use Spatie\Activitylog\LogOptions;

trait ActivityLogOptionsTrait
{
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(self::$logAttributes);
    }
}