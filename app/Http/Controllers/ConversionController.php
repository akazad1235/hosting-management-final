<?php

namespace App\Http\Controllers;

use App\Events\AdminMessage;
use App\Events\Message;
use App\Models\Conversion;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConversionController extends Controller
{
    public function index($id)
    {
      // dd(DB::table('notifications')->where('notifiable_id', Auth::guard('admin')->user()->id)->first());
     //  return Auth::guard('admin')->user()->notifications->data['conversion_id']->where('');

      $conversion = Conversion::with('ticket')->where('ticket_id', $id)->first();

      $ticket = Ticket::find($conversion->ticket_id);
      $ticket->update([
          'read_at' => date('d-m-y h:i:s'),
          'supported_by' => Auth::guard('admin')->user()->id
      ]);

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
