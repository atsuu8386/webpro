<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name', 'color', 'created_by', 'updated_by'
    ];

    protected $casts = [
        'color' => 'string',
    ];
}
