<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConversionController extends Controller
{
    public function conversion(){

        return view('customer.conversion');
    }
}
