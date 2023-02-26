<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CustomerOrderController extends Controller
{
    public function CustomerOrder(Request $req){
        $customer_id = auth::guard('customer')->user()->id;
        // $data = Order::where('customer_id', $customer_id)->get();

        $data = DB::table('orders')
        ->where('customer_id', $customer_id)
        ->join('products', 'orders.product_id', '=', 'products.id')
        ->select('orders.*','products.name as product_name')
        ->get();

        if ($req->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    //    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPost">View</a>';

                    // $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        // return view('admin.category.manage_categories');
        return view('customer.customer_orders', compact('data'));
    }
}
