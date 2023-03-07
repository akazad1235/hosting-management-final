<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Conversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketViewController extends Controller
{
    public function viewTicket($id){
       $conversions = Conversion::where('ticket_id', $id)->with('customer','admin:id,name')->get();

        return view('admin.ticket.viewTickets', ['ticketId' => $id, 'conversions' => $conversions]);
    }
    /*
    * Customer replay to Support team
    */
    public function replayCustomer(Request $request, $id){
        Validator::make($request->all(), [
            'message' => ['required'],
            'file' => ['mimes:jpeg,png,jpg,gif', 'max:2048'],
        ])->validate();
        try {
            $conversion = Conversion::create([
                'message'=> $request->message,
                'ticket_id'=> $id,
                'type'=> 'customer',
                'customer_id' => Auth::guard('customer')->user()->id
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
            // return  $conversions = Conversion::where('ticket_id', $id)->with('admin')->get();

            //  return redirect()->route('customer.view.ticket', $id)->with(['message' => 'Data Successfully Send','conversions'=> $conversions ]);
            return redirect()->route('customer.view.ticket', $id)->with(['message' => 'Data Successfully Send']);
        }catch (\Exception $ex){
            return redirect()->route('admin.view.ticket', $id)->with(['error' => $ex->messsage]);
        }

    }
}
