<?php

namespace App\Http\Controllers\customer;

use App\Events\CustomerTicket;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Order;
use App\Models\Admin;
use App\Models\Conversion;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Order as OrderModel;
use App\Notifications\AdminFollowNotification;
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


    /*
     * all ticket list show live chatting
     */
    public function index(Request $req){
        $data = Ticket::where('customer_id', Auth::guard('customer')->user()->id)->with('conversion','product:id,name')->orderBy('id', 'asc')->get();
        if ($req->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function($row){
                     //Carbon::createFromFormat('m/d/Y', $row->created_at);
                    return date('d-m-Y | H:i A', strtotime($row->created_at));

                })
                ->addColumn('ticket_status', function($row){
                    return '<span class="badge badge-'.randomStatusColor($row->status).'">'.$row->status.'</span>';
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
                ->rawColumns(['created_at','ticket_status','action'])
                ->make(true);
        }
        return view('customer.ticket_list',compact('data'));
    }

    public function allTicket(Request $req){
        $data = Ticket::where('customer_id', Auth::guard('customer')->user()->id)->with('conversion','product:id,name')->orderBy('id', 'asc')->get();
        if ($req->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function($row){
                    //Carbon::createFromFormat('m/d/Y', $row->created_at);
                    return date('d-m-Y | H:i A', strtotime($row->created_at));

                })
                ->addColumn('ticket_status', function($row){
                    return '<span class="badge badge-'.randomStatusColor($row->status).'">'.$row->status.'</span>';
                })
                ->addColumn('action', function($row){
                        return '<a href="'.route('customer.view.ticket', $row->id).'" class="edit btn  btn-danger btn-sm">Open Conversions</a>';
                })
                ->rawColumns(['created_at','ticket_status','action'])
                ->make(true);
        }
        return view('customer.ticket_all',compact('data'));
    }

    //redirect ticket view page with product details info send
    public function ticket(){
        $orders = OrderModel::where('customer_id', Auth::guard('customer')->user()->id)->with('products:id,name')->get();
        return view('customer.generate_ticket', ['orders' => $orders]);
    }
    /*
     * created ticket
     */
    public function generateTicket(Request $request){
//        return $request->all();
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
           $order = OrderModel::find($request->order_id);

            if($user){
                //ticket create
                $ticket = Ticket::create([
                    'customer_id' => $user->id,
                    'product_id' => $request->product_id,
                    'support_team' => $request->support_team,
                    'subject' => $request->subject,
                    'ticket_code' => random_int(100000, 999999),
                    'priority' => $request->priority,
                ]);
                if($ticket){
                    //conversion create according to ticket
                    $conversation = Conversion::create([
                        'customer_id' => $ticket->customer_id,
                        'ticket_id' => $ticket->id,
                        'message' => $request->message,
                        'type' => 'customer',
                    ]);
                    //if have ticket image then update image according to conversion
                    if(!empty($conversation) && $request->hasFile('image')){
                        $imagePath = $this->uploadImage($request->file('image'), 'conversation');
                        $conversation->update([
                            'file' => $imagePath,
                        ]);
                    }
                  //  auth()->user()->notify(new TicketNotification($user));
                    //notification to all admin user
                    $user['conversion_id'] = $conversation->id;

                    // $admin = Admin::limit(10)->get();
                    // Notification::send($admin, new AdminFollowNotification($user));

                    $nowDate = date('d-m-y h:i:s');//send current date send to customer chat box through customer event
                    $convertDate =  Carbon::createFromFormat('d-m-y h:i:s', $nowDate)->diffForHumans();
                     event(new CustomerTicket($user->name, $user->email, $ticket->id, $convertDate));
                    DB::commit();
                    return redirect()->route('customer.ticket.all')->with('message','Data added Successfully');
                }else{
                    throw new \Exception('Invalid Information, Please Try again');
                }
            }else{
                throw new \Exception('Your are not authentic user, please contact to admin');
            }


        }catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('customer.ticket.list')->with('error',$ex->getMessage());
        }


    }
}
