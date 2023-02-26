<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentTransaction;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class VerifyPayment extends Controller
{
      
    
    public function vefityPayment($cartId){
        //  generate inovice code
      function generateRandomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return strval( $randomString .'-'. date("d-m-Y"));
    }
        $invoice = generateRandomString(8);
        $update = Order::where('invoice', $invoice)->count();
         if($update){
            $invoice = generateRandomString(8);
         }
        $cartDetails = Cart::find($cartId);
        // dd($cartDetails->product_discounted_price);
        $newOrder = new Order;
        $newOrder->customer_id = $cartDetails->customer_id;
        $newOrder->address_id = $cartDetails->address_id;
        $newOrder->product_id = $cartDetails->product_id;
        $newOrder->cuppon_discounted_amount = $cartDetails->cuppon_discounted_price;
        $newOrder->product_discounted_amount = $cartDetails->product_discounted_price;
        $newOrder->status = "pending";
        $newOrder->invoice =  $invoice;
        $newOrder->subscription_month = $cartDetails->subscription_type;
        $newOrder->payment_status = "completed";
        $newOrder->total = $cartDetails->total_discounted_price;
        $newOrder->save();

        if($newOrder){
            $paymentTrack = new PaymentTransaction;
            $paymentTrack->order_id = $newOrder->id;
            $paymentTrack->payment_method = "paypal_payment";
            $paymentTrack->payment_details = "none";
            $paymentTrack->user_id = auth::guard('customer')->user()->id;
            $paymentTrack->save();
        }

        if($paymentTrack && $newOrder){
            $addSubscription = new Subscription;
            $addSubscription->subscription_month = $newOrder->id;
            $addSubscription->user_id = auth::guard('customer')->user()->id;
            $addSubscription->order_id = $newOrder->id;
            $addSubscription->start_date = $newOrder->user_id;
            $addSubscription->is_active = "Activated";
            $addSubscription->is_complete = "running";
            $addSubscription->start_date = date('Y-m-d H:i:s');
            $addSubscription->save();
        }
        return $newOrder;
    }
}
