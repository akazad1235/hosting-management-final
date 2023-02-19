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
     // return count( readAsTickets());

        $data = DB::table('tickets')->select('tickets.*', 'customers.email')->leftJoin('customers',  'tickets.customer_id', '=', 'customers.id')->get();
        if ($req->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    //    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    $btn = '<a href="'. route('conversation', $row->id).'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn  btn-danger btn-sm manageOrder">Open Conversion</a>';

                    //  $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
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
