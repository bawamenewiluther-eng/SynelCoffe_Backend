<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $fillable = [

        'name',

        'category',

        'origin',

        'price',

        'description',

        'full_description',

        'image',

        'temperature',

        'is_popular',

        'is_new'

    ];

}
