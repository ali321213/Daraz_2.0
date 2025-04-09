<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    protected $fillable = [
        'user_id',
        'address_line',
        'city',
        'state',
        'postal_code',
        'country',
        'type',
    ];
}