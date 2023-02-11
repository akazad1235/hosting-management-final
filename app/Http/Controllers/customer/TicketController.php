<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Conversion;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\ImagesTrait;


class TicketController extends Controller
{
    use ImagesTrait;
    //
    public function ticket(){
        $products = Product::get();
        return view('customer.generate_ticket', ['products' => $products]);
    }

    public function generateTicket(Request $request){
        //return $request->all();
        Validator::make($request->all(), [
            'product_id' => ['required'],
            'support_team' => ['required'],
            'priority' => ['required'],
            'message' => ['required'],
            'image' => ['mimes:jpeg,png,jpg,gif', 'max:2048'],
        ])->validate();


        try {
            DB::beginTransaction();
            $user = Customer::find(Auth::guard('customer')->user()->id);
            if($user){
                $ticket = Ticket::create([
                    'customer_id' => $user->id,
                    'order_id' => 1,
                    'support_team' => $request->support_team,
                    'ticket_code' => 327923,
                    'priority' => $request->priority,
                ]);
                if($ticket){
                    $conversation = Conversion::create([
                        'customer_id' => $ticket->customer_id,
                        'ticket_id' => $ticket->id,
                        'message' => $request->message,
                    ]);
                    if(!empty($conversation) && $request->hasFile('image')){
                       // return  'dsfsfsd';
                        $imagePath = $this->uploadImage($request->file('image'), 'conversation');
                        $conversation->update([
                            'file' => $imagePath,
                        ]);
                        DB::commit();
                    }
                    DB::commit();
                }else{
                    throw new \Exception('Invalid Information, Please Try again');
                }
            }else{
                throw new \Exception('Your are not authentic user, please contact to admin');
            }


        }catch (\Exception $ex){
            return $ex->getMessage();
        }

        return 'successfully done';
    }
}
