<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Conversion;
use App\Models\conversionFile;
use App\Traits\ImagesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TicketViewController extends Controller
{
    use ImagesTrait;
    public function viewTicket($id){
       $conversions = Conversion::where('ticket_id', $id)->with('customer','ticket:id,ticket_code,subject','admin:id,name')->get();

        return view('customer.viewTickets', ['ticketId' => $id, 'conversions' => $conversions]);
    }
    /*
    * Customer replay to Support team
    */
    public function replayCustomer(Request $request, $id){
      // return $request->file('files');
        Validator::make($request->all(), [
            'message' => ['required'],
            'file' => ['mimes:jpeg,png,jpg,gif', 'max:2048'],
        ])->validate();
        try {
            DB::beginTransaction();
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
            if(!empty($conversion) && $request->hasFile('files')){
                 foreach ($request->file('files') as $file){
                      $imagePath = $this->uploadImage(($file), 'conversion');
                      //array_push($arr, $imagePath);
                     conversionFile::create([
                         'conversion_id' => $conversion->id,
                         'file' => $imagePath
                     ]);
                 }
                DB::commit();
            }
            DB::commit();
            return redirect()->route('customer.view.ticket', $id)->with(['message' => 'Data Successfully Send']);
        }catch (\Exception $ex){
            DB::rollBack();
           // return redirect()->route('admin.view.ticket', $id)->with(['error' => $ex->messsage]);
            return $ex->getMessage();
        }

    }
}
