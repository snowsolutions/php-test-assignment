<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirtableService extends Model
{
    protected $fillable = [
        'service_id',
        'name',
        'instructions',
        'condition',
        'recurring',
        'calendar_interval',
        'calendar_interval_unit',
        'running_hour_interval',
        'alternative_interval',
        'alternative_interval_description',
        'service_group',
        'model',
    ];
}
