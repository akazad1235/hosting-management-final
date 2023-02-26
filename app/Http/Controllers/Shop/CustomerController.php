<?php

namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Cuppon;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function dashboard(){
        return view('customer.dashboard');
    }

    public function loginFromCheckout(Request $req){
        $paymentMethod = $req->paymentMethod;
        if($paymentMethod == "paypal_payment"){
            $paymentRoute = "paypal.payment";
        } elseif($paymentMethod == "stripte_payment"){
            $paymentRoute = "make.payment";
        } elseif($paymentMethod == "bank_transfer"){
            $paymentRoute = "bank.transfer";
        }
        // return $req;
        $product_id = $req->product_id;
        $company = $req->company;
        $country = $req->country;
        $address = $req->address;
        $state = $req->state;
        $city = $req->city;
        $zip_code = $req->zip;
        $subscription_type = $req->subscription_type;
        $product_discounted_price = $req->product_discounted_price;
        $cuppon_discounted_price = $req->cuppon_discounted_price;
        $total_discounted_price = $req->total_discounted_price;
        
        $checkThis = [
            'email' => 'required|email',
            'password' => 'required|min:4|max:8'
        ];

        $this->validate($req, $checkThis);  

        if(Auth::guard('customer')->attempt(['email' => $req->email, 'password' => $req->password], $req->get('remember'))){
            $customer_id = auth::guard('customer')->user()->id;
            $address_id = Address::where('customer_id', $customer_id)->get();
            $product_id = $req->product_id;

            $addToCart = new Cart;
            $addToCart->customer_id = $customer_id;
            $addToCart->product_id = $product_id;
            $addToCart->address_id = $address_id[0]->id;
            $addToCart->subscription_type = $subscription_type;
            $addToCart->product_discounted_price = preg_replace('/[^0-9]/', '', $product_discounted_price);
            $addToCart->cuppon_discounted_price = preg_replace('/[^0-9]/', '', $cuppon_discounted_price);
            $addToCart->total_discounted_price = preg_replace('/[^0-9]/', '', $total_discounted_price);
            $addToCart->save();

            return redirect()->route($paymentRoute, ["cartId" => $addToCart->id]);
        } else {
            session()->flash('loginError', 'Email/Password is incorrect!');
            return back()->withInput($req->only('email'));
        }
    }

    // public function authenticate(Request $req){
    //     $checkThis = [
    //         'email' => 'required|email',
    //         'password' => 'required|min:4|max:8'
    //     ];

    //     $this->validate($req, $checkThis);

    //     if(Auth::guard('customer')->attempt(['email' => $req->email, 'password' => $req->password], $req->get('remember'))){
    //         return redirect()->route('customer.dashboard');
    //     } else {
    //         session()->flash('error', 'Email/Password is incorrect!');
    //         return back()->withInput($req->only('email'));
    //     }
    // }

    public function register(Request $req){
        $product_id = $req->product_id;
        $company = $req->company;
        $country = $req->country;
        $address = $req->address;
        $state = $req->state;
        $city = $req->city;
        $zip_code = $req->zip;
        $subscription_type = $req->subscription_type;
        $product_discounted_price = $req->product_discounted_price;
        $cuppon_discounted_price = $req->cuppon_discounted_price;
        $total_discounted_price = $req->total_discounted_price;

        $paymentMethod = $req->paymentMethod;
        if($paymentMethod == "paymentMethod"){
            $paymentRoute = "paypal.payment";
        } elseif($paymentMethod == "stripte_payment"){
            $paymentRoute = "make.payment";
        } elseif($paymentMethod == "bank_transfer"){
            $paymentRoute = "bank.transfer";
        }

        $customerCreate  = array(
            "name"          =>  $req->firstName . ' '. $req->firstName,
            "email"         =>  $req->email,
            "number"         =>  $req->number,
            'password' => Hash::make($req->password),
        );
        $customer = Customer::create($customerCreate);

        if(Auth::guard('customer')->attempt(['email' => $req->email, 'password' => $req->password], $req->get('remember'))){
            // return redirect()->route('make.payment');  

        if(!is_null($customer)) {

            Auth::login($customer);
            $customer_id = $customer->id;
            $adAaddress = new Address;
            $adAaddress->customer_id = $customer_id;
            $adAaddress->country = $country;
            $adAaddress->company = $company;
            $adAaddress->address = $address;
            $adAaddress->state = $state;
            $adAaddress->city = $city;
            $adAaddress->zip_code = $zip_code;
            $adAaddress->save();

            if($adAaddress){
                $addToCart = new Cart;
            
            $addToCart->customer_id = $customer_id;
            $addToCart->product_id = $product_id;
            $addToCart->address_id = $adAaddress->id;
            $addToCart->subscription_type = $subscription_type;
            $addToCart->product_discounted_price = preg_replace('/[^0-9]/', '', $product_discounted_price);
            $addToCart->cuppon_discounted_price = preg_replace('/[^0-9]/', '', $cuppon_discounted_price);
            $addToCart->total_discounted_price = preg_replace('/[^0-9]/', '', $total_discounted_price);
            $addToCart->save();
            
            return redirect()->route($paymentRoute)->with("success", "Success! Registration completed");
        }
        else {
            return back()->with("failed", "Alert! Failed to register");
        }
            
        }
        else {
            return back()->with("failed", "Alert! Failed to register");
        }

    } 
    }

    public function logout(){
        auth()->guard('customer')->logout();
        return view('home');
    }

    public function customerProfile(){
        // $customer_id = Auth::guard('customer')->user()->id;
        // $customer = Customer::find($customer_id);
        return view('customer.customer_profile');
    }

    public function verifyCuppon(Request $req){
        $cuppon_code = $req->cuppon_code;
        // $total_price = $req->total_price;
        $verifyCuppon = Cuppon::where('cuppon_code', $cuppon_code)->where('status', 'active')->get();
        if ($verifyCuppon) {
            $discount = Discount::find($verifyCuppon[0]->discount_id);
            return $discount;
        } else {
            return false;
        }
    }
}
