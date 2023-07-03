<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumer extends Model
{
    const ANONYMOUS_ID = 1;

    protected $fillable = [
        'name',
    ];
}
