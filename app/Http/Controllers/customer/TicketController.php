<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    //
    public function ticket(){
        $products = Product::get();
        return view('customer.generate_ticket', ['products' => $products]);
    }
}
