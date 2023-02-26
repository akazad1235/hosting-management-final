<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class CustomerProductsController extends Controller
{
    public function CustomerProducts(Request $req){
        $customer_id = auth::guard('customer')->user()->id;
        $data = DB::table('orders')
                ->where('customer_id', $customer_id)
                ->join('products', 'orders.product_id', '=', 'products.id')
                ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->select('orders.*', 'products.name as product_name', 'products.category_id as product_category_id', 'products.description as product_description', 'products.purchase_type as product_purchase_type', 'categories.name as product_category_name')
                ->get();
        //  dd($data);
         if ($req->ajax()) {
             return DataTables::of($data)
                 ->addIndexColumn()
                 ->addColumn('action', function($row){
                     //    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                     $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPost">Manage Prodcut</a>';
 
                    //  $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';
                     return $btn;
                 })
                 ->rawColumns(['action'])
                 ->make(true);
         }
         // return view('admin.category.manage_categories');
         return view('customer.customer_products', compact('data'));
     }
 
     public function ServiceInfo($id)
     {
         // return $id;
        //  $serviceInfo = DB::table('orders')
        //         ->where('id', $id)
        //         ->join('products', 'orders.product_id', '=', 'products.id')
        //         ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
        //         ->select('orders.*', 'products.name as product_name', 'products.category_id as product_category_id', 'products.description as product_description', 'products.purchase_type as product_purchase_type', 'categories.name as product_category_name')
        //         ->get();
        $serviceInfo = Order::find($id);
         return response()->json($serviceInfo);
     }
 
    //  public function updateCategory(Request $req){
    //      $name = $req->name;
    //      $discount_id = $req->discount_id;
    //      $category = Category::find($req->id);
    //      if($category){
    //          $checkThis = [
    //              'name' => 'required|string',
    //          ];
    //          $this->validate($req, $checkThis);
             
    //          $category->name = $name;
    //          $category->discount_id = $discount_id;
    //          $category->save();
    //          return response()->json(['success'=>'Updated successfully.']);
    //      } else {
    //          $checkThis = [
    //              'name' => 'required|string',
    //          ];
     
    //          $this->validate($req, $checkThis);
    //          $createCategory = new Category;
    //          $createCategory->name = $name;
    //          $createCategory->discount_id = $discount_id;  
    //          $createCategory->save();
    //          return response()->json(['success'=>'Created successfully.']);
    //      }        
    //  }
 
    //  public function deleteCategory($id)
    //  {
    //      Category::find($id)->delete();
    //      return response()->json(['success'=>'Deleted successfully.']);
    //  }
}
