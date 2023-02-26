<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaypalColtroller extends Controller
{

    public function paypalPayment(){
            $customer_id = auth::guard('customer')->user()->id;
            $cartProdcut = json_decode(Cart::where('customer_id', $customer_id)->get());
            return view('customer.payment.paypal', compact('cartProdcut'));
        }
    
   
}
                                        