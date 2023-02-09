<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

// $data = DB::table('orders')
//     ->join('subscriptions', 'orders.subscription_id', '=', 'subscriptions.id')
//     ->join('order_details', 'orders.order_details_id', '=', 'order_details.id')
//     ->leftJoin('uesrs', 'orders.user_id', '=', 'uesrs.id')
//     ->leftJoin('products', 'order_details.product_id', '=', 'products.id')
//     ->leftJoin('categories', 'products.discount_id', '=', 'discounts.id')
//     ->leftJoin('discount', 'products.discount_id', '=', 'discounts.id')
//     ->select('products.*','categories.name as cat_name','discounts.name as disc_name')
//     ->get();

class OrderController extends Controller
{
    public function orders(Request $req){
    $testdata = DB::table('orders')
        ->join('order_details', 'orders.order_details_id', '=', 'order_details.id')
        ->leftJoin('subscriptions', 'orders.subscription_id', '=', 'subscriptions.id') 
        ->leftJoin('users', 'orders.user_id', '=', 'users.id')
        ->leftJoin('subscription_type', 'subscriptions.subscription_type_id', '=', 'subscription_type.id')
        ->select('orders.*','subscriptions.*', 'orders.status as order_status', 'users.name as user_name', 'subscription_type.type as subs_type', 'subscription_type.value as subs_value')
    ->get();
    // dd($testdata);
         if ($req->ajax()) {
             return DataTables::of($testdata)
                 ->addIndexColumn()
                 ->addColumn('action', function($row){
                     //    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                     $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm manageOrder">Manage Order</a>';
 
                    //  $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';
                     return $btn;
                 })
                 ->rawColumns(['action'])
                 ->make(true);
         }
         // return view('admin.category.manage_categories');
         return view('admin.orders.manage_orders', compact('testdata'));
     }
 
 
     public function deleteOrder($id)
     {
        Order::find($id)->delete();
         return response()->json(['success'=>'Deleted successfully.']);
     }

    
}
