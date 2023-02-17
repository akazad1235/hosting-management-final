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

        $conversion = Conversion::where('id', $id)->with('customer')->first();

        return view('customer.conversion', ['conversion' => $conversion]);
    }

    public function receiveMessage(){

        return view('customer.conversion');
    }
    public function sendMessage(Request $request){
        broadcast(new testEvent($request->message, $request->adminId));

        return response()->json(['success' => 'message send success', 'message'=> $request->message]);
    }

}
