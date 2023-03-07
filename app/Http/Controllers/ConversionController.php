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
   public function adminReply(Request $request, $id){

       $conversion = Conversion::create([
           'message'=> $request->message,
           'ticket_id'=> $id,
           'type'=> 'admin',
           'admin_id' => Auth::guard('admin')->user()->id
       ]);

       if(!empty($conversion) && $request->hasFile('file')){
           $imagePath = $this->uploadImage($request->file('file'), 'conversion');
           $conversion->update([
               'file' => $imagePath,
           ]);
       }
       // return  $conversions = Conversion::where('ticket_id', $id)->with('admin')->get();

       //  return redirect()->route('customer.view.ticket', $id)->with(['message' => 'Data Successfully Send','conversions'=> $conversions ]);
       return redirect()->route('admin.view.ticket', $id)->with(['message' => 'Data Successfully Send']);
   }









    public function index($id)
    {

      // dd(DB::table('notifications')->where('notifiable_id', Auth::guard('admin')->user()->id)->first());
     //  return Auth::guard('admin')->user()->notifications->data['conversion_id']->where('');

      $conversion = Conversion::with('ticket')->where('ticket_id', $id)->first();

      $conversions = Conversion::where('ticket_id', $id)->with('admin:id,name')->get(); //get all stored message stored by ticket id


      $ticket = Ticket::find($conversion->ticket_id);
      $ticket->update([
          'read_at' => date('d-m-y h:i:s'),
          'status' => 'connected',

          'supported_by' => Auth::guard('admin')->user()->id
      ]);

       $conversion->update([
           'admin_id' => Auth::guard('admin')->user()->id
       ]);

       return view('admin.ticket.conversion', ['customer' => $conversion, 'conversions' => $conversions]);
    }
    public function chatRoom(){
       $admin = Auth::guard('admin')->user();
        $id = $admin->id;
    return view('index', compact('id'));
    }

    public function sendMessage(Request $request){
      // $admin =  Auth::guard('admin')->user();


        $conversion = Conversion::create([
            'message'=> $request->message,
            'ticket_id'=> $request->ticketId,
            'type'=> 'admin',
            'admin_id' => Auth::guard('admin')->user()->id

        ]);
        $dateTime = date('d-m-Y | H:i A ', strtotime($conversion->created_at));
        $adminName = Auth::guard('admin')->user()->name;
        broadcast(new AdminMessage($request->message, $request->userId, $dateTime, $adminName));

        return response()->json(['success' => 'message send success', 'message'=> $request->message]);
    }
}
