<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Order;

use App\Models\OrderItem;

class Controller
{
    use AuthorizesRequests, ValidatesRequests;
}