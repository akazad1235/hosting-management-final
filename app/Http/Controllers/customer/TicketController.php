<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Conversion;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\ImagesTrait;
use Notification;
use Yajra\DataTables\DataTables;


class TicketController extends Controller
{
    use ImagesTrait;

    //
    public function index(Request $req){
       // $data = DB::table('customers')->select('tickets.*', 'customers.email')->leftJoin('customers',  'tickets.customer_id', '=', 'customers.id')->get();
        $data = Ticket::where('customer_id', Auth::guard('customer')->user()->id)->with('conversion')->get();
        if ($req->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function($row){
                     //Carbon::createFromFormat('m/d/Y', $row->created_at);
                    return date('d-m-Y | H:i A', strtotime($row->created_at));

                })
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('customer.conversion', $row->conversion->id).'" data-toggle="tooltip"  data-id="'.$row->conversion->id.'" data-original-title="Edit" class="edit btn  btn-danger btn-sm manageOrder">Open Conversion</a>';
                    if($row->conversion->admin_id != null){
                       return '<a href="'.route('customer.conversion', $row->conversion->id).'" class="edit btn  btn-danger btn-sm manageOrder">Open Conversion</a>';

                    }else{
                       return ' <button class="edit btn  btn-danger btn-sm manageOrder" disabled>Not Available </button>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('customer.ticket_list',compact('data'));
    }
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
            $user = Customer::findOrFail(Auth::guard('customer')->user()->id);

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
                    }
                  //  auth()->user()->notify(new TicketNotification($user));

                    // $admin = Admin::limit(10)->get();
                    // Notification::send($admin, new TicketNotification($user));
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
