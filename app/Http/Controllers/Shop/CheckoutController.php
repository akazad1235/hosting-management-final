<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout($id){
        $getProduct = Product::find($id);
        $product = json_decode($getProduct);
        $discount = Discount::where('id',  $getProduct->discount_id)->get();
        if($discount[0]->discount_type == 'percent'){
            $discounted_ammount = ($discount[0]->value / 100) * $getProduct->price;
            // $('#discount_percent').html(`${discount_value}% ${discount_type} Discount`);
        } else {
            $discounted_ammount = $discount[0]->value;
        }
        return view('shop.checkout', compact('product', 'discounted_ammount'));
    }
}
