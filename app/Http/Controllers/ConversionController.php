<?php

namespace App\Http\Controllers;

use App\Events\AdminMessage;
use App\Events\Message;
use App\Models\Conversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversionController extends Controller
{
    public function index($id)
    {
       $conversion = Conversion::with('ticket')->where('ticket_id', $id)->first();
       $customerId = $conversion->customer_id;

       $conversion->update([
           'admin_id' => Auth::guard('admin')->user()->id
       ]);

       return view('admin.ticket.conversion', ['customer' => $conversion]);
    }
    public function chatRoom(){
       $admin = Auth::guard('admin')->user();
        $id = $admin->id;
    return view('index', compact('id'));
    }

    public function sendMessage(Request $request){
      // $admin =  Auth::guard('admin')->user();

       broadcast(new AdminMessage($request->message, $request->userId));

        return response()->json(['success' => 'message send success', 'message'=> $request->message]);
    }
}
