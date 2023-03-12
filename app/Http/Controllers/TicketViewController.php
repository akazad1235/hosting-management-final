<?php

namespace App\Http\Controllers;

use App\Models\Conversion;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

class TicketViewController extends Controller
{
    public function viewTicket($id){
        try {
            $conversions = Conversion::where('ticket_id', $id)->with('customer','ticket:id,ticket_code,subject','admin:id,name')->orderBy('id', 'desc')->get();
            $ticket = Ticket::findOrFail($id);
            if($ticket && $conversions){
                $ticket->update([
                    'read_at' => date('d-m-y h:i:s'),
                    'status' => 'connected',
                    'supported_by' => Auth::guard('admin')->user()->id
                ]);
            }else{
                throw  new \Exception('Something Wrong');
            }
            return view('admin.ticket.viewTickets', ['ticketId' => $id, 'conversions' => $conversions]);
        }catch (\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage());
        }

    }
    /*
     * Admin replay to customer
     */
    public function adminReply(Request $request, $id){

        Validator::make($request->all(), [
            'message' => ['required'],
            'file' => ['mimes:jpeg,png,jpg,gif', 'max:2048'],
        ])->validate();
        try {
            $conversion = Conversion::create([
                'message'=> $request->message,
                'ticket_id'=> $id,
                'type'=> 'admin',
                'admin_id' => Auth::guard('admin')->user()->id
            ]);
            if(empty($conversion)){
                throw new \Exception('someting wrong!, please try again');
            }
            //if customer input image(optional)
            if(!empty($conversion) && $request->hasFile('file')){
                $imagePath = $this->uploadImage($request->file('file'), 'conversion');
                $conversion->update([
                    'file' => $imagePath,
                ]);
            }
            return redirect()->route('admin.view.ticket', $id)->with(['message' => 'Replay Send Success']);
        }catch (\Exception $ex){
            return redirect()->route('admin.view.ticket', $id)->with(['error' => $ex->messsage]);
        }

    }

}
