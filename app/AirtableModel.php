<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirtableModel extends Model
{
    protected $fillable = [
        'number',
        'description',
        'unit',
        'note',
        'parents',
        'children',
        'services',
    ];
}
