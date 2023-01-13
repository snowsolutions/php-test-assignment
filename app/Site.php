<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'name',
        'airtable_access_key',
        'airtable_base_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
