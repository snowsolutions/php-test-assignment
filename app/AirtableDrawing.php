<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirtableDrawing extends Model
{
    protected $fillable = [
        'name',
        'model_model'
    ];
}
