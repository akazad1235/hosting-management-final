<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Conversion;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class TicketController extends Controller
{
    public function tickets(Request $req){
        //randomStatusColor('pending');
     // return count( readAsTickets());

//        $data = DB::table('tickets')->select('tickets.*', 'customers.email')->leftJoin('customers',  'tickets.customer_id', '=', 'customers.id')->orderBy('id', 'desc')->get();
        $data = Ticket::with('conversion','customer:id,email','product:id,name')->orderBy('id', 'asc')->get();

        if ($req->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('ticket_status', function($row){
                    //Carbon::createFromFormat('m/d/Y', $row->created_at);
                   // return date('d-m-Y | H:i A', strtotime($row->created_at));
                   return '<span class="badge badge-'.randomStatusColor($row->status).'">'.$row->status.'</span>';

                })
                ->addColumn('created_at', function($row){
                    //Carbon::createFromFormat('m/d/Y', $row->created_at);
                    return date('d-m-Y | H:i A', strtotime($row->created_at));

                })
                ->addColumn('action', function($row){
                    //    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    $btn = '<a href="'. route('conversation', $row->id).'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn  btn-danger btn-sm manageOrder">Open Conversion</a>';
                    return $btn;
                })
                ->rawColumns(['action','ticket_status','created_at'])
                ->make(true);
        }
        return view('admin.ticket.manage_tickets',compact('data'));
    }
    //admin support notification received
    public function readAsNotification($uuid){
        return $uuid;
       //return Auth::guard('admin')->user()->Notifications->find($uuid);
        try {
            if($uuid){
                $admin = Auth::guard('admin')->user()->unreadNotifications->find($uuid);
                $checkAdminRead = Conversion::where('id', $admin ? $admin->data['conversion_id'] : '')->whereNull('admin_id')->first();
                if($checkAdminRead && $admin){
                    $admin->markAsRead();
                }else{
                    throw new \Exception('already marked');
                }
            }else{
                throw new \Exception('invalid notificaion');
            }
            return 'done';
        }catch (\Exception $ex){
            return $ex->getMessage();
        }
    }
}
