<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $table = "customers";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
		'id',
		'name',

    ];

    public static $rules = [
        // create rules
    ];

    // Customer 
}
