<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Stripe; 
     
class StripePaymentController extends Controller
{

  public function stripe()
    {
        return view('customer.stripe');
    }

  public function stripePost(Request $request)
  {
      Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

      $customer_id = auth::guard('customer')->user()->id;
      $cart = Cart::where('customer_id', $customer_id)->orderBy('created_at', 'desc')->get();
      $product = Product::find($cart[0]->product_id);
      $address = Address::find($cart[0]->address_id);
  
      $customer = Stripe\Customer::create(array(
              "address" => [
  
                      "line1" => "",
  
                      "postal_code" => "360001",
  
                      "city" => "Rajkot",
  
                      "state" => "GJ",
  
                      "country" => "IN",
  
                  ],
              "email" => "demo@gmail.com",
              "name" => "Hardik Savani",
              "source" => $request->stripeToken
           ));
  
    
  
      Stripe\Charge::create ([
              "amount" => 100 * 100,
              "currency" => "usd",
              "customer" => $customer->id,
              "description" => "Test payment from itsolutionstuff.com.",  
              "shipping" => [  
                "name" => "Jenny Rosen", 
                "address" => [  
                  "line1" => "510 Townsend St", 
                  "postal_code" => "98140", 
                  "city" => "San Francisco", 
                  "state" => "CA",
                  "country" => "US", 
                ],
  
              ]
      ]); 
  
      return back()->with('success', 'Payment successful!');
  }
}





