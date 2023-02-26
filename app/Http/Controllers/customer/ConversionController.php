<?php

namespace App\Http\Controllers\customer;

use App\Events\testEvent;
use App\Http\Controllers\Controller;
use App\Models\Conversion;
use Illuminate\Http\Request;

class ConversionController extends Controller
{
    /*
     * when open conversion click
     */
    public function conversionOpen($id){
      //  return $id;
        $conversion = Conversion::where('id', $id)->with('customer')->first();
        $conversions = Conversion::where('ticket_id', $conversion->ticket_id)->get(); //get all stored message stored by ticket id

        return view('customer.conversion', ['conversion' => $conversion, 'conversions' => $conversions]);
    }

    public function receiveMessage(){

        return view('customer.conversion');
    }
    /*
     * customer message send to admin
     */
    public function sendMessage(Request $request){

        broadcast(new testEvent($request->message, $request->adminId)); //admin receive by event

        $conversion = Conversion::create([
            'message'=> $request->message,
            'ticket_id'=> $request->ticketId,
            'type'=> 'customer',

        ]);
        $dateTime = date('d-m-Y | H:i A ', strtotime($conversion->created_at));

        return response()->json(['success' => 'message send success', 'message'=> $request->message, 'dateTime' => $dateTime]);
    }

}
