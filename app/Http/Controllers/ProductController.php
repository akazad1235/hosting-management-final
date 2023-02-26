<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables; 

class ProductController extends Controller
{
    // public function products(){
    //     $data = json_decode(Product::get());
    //     $categories = json_decode(Category::get());
    //     $discounts = json_decode(Discount::get());
    //     return view('admin.products.manage_products');
    // }
    public function adminProducts(Request $req){
        $categories = json_decode(Category::get());
        $discounts = json_decode(Discount::get());
        $data = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('discounts', 'products.discount_id', '=', 'discounts.id')
            ->select('products.*','categories.name as cat_name','discounts.name as disc_name')
            ->get();
        // $data = Product::query();
        if ($req->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPost">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        // return view('admin.products.manage_products');
        return view('admin.products.manage_Products', compact('data', 'categories', 'discounts'));
    }

    public function editProduct($id)
    {
        $Product = Product::find($id);
        return response()->json($Product);
    }

    public function updateProduct(Request $req){
        // dd($req);
        $password = Hash::make($req->password);
        $name = $req->name;
        $category_id = $req->category_id;
        $discount_id = $req->discount_id;
        $description = $req->description;
        $purchase_type = $req->purchase_type;
        $image = $req->image;
        $price = $req->price;

        $Product = Product::find($req->id);
        if($Product){
            $checkThis = [
                'name' => 'required|string',
                'category_id' => 'required',
                'discount_id' => 'required',
                'price' => 'required',
            ];
            $this->validate($req, $checkThis);
            
            $Product->name = $name;
            $Product->category_id = $category_id;
            $Product->discount_id = $discount_id;
            $Product->price = $price;
            $Product->description = $description;
            $Product->purchase_type = $purchase_type;
            // $Product->image = $image;
            $Product->save();
            return response()->json(['success'=>'Product updated successfully.']);
        } else {
            $checkThis = [
                'name' => 'required|string',
                'category_id' => 'required',
                'discount_id' => 'required',
                'price' => 'required',
            ];
    
            $this->validate($req, $checkThis);
            $Product = new Product;
            $Product->name = $name;
            $Product->category_id = $category_id;
            $Product->discount_id = $discount_id;
            $Product->price = $price;
            $Product->description = $description;
            $purchase_type = $req->purchase_type;
            // $Product->image = $image;
            $Product->save();
            return response()->json(['success'=>'Product created successfully.']);
        }

    }

    public function deleteProduct($id)
    {
        Product::find($id)->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
