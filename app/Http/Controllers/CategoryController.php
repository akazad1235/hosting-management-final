<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;


class CategoryController extends Controller
{
    public function category(Request $req){
       $data = DB::table('categories')
            ->join('discounts', 'categories.discount_id', '=', 'discounts.id')
            ->select('categories.id','categories.name','discounts.name as discname')
            ->get();
        // dd($data);
        $discounts = Discount::get();
        if ($req->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    //    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPost">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        // return view('admin.category.manage_categories');
        return view('admin.category.manage_categories', compact('data', 'discounts'));
    }

    public function editCategory($id)
    {
        // return $id;
        $category = Category::find($id);
        return response()->json($category);
    }

    public function updateaCategory(Request $req){
        $name = $req->name;
        $discount_id = $req->discount_id;
        $category = Category::find($req->id);
        if($category){
            $checkThis = [
                'name' => 'required|string',
            ];
            $this->validate($req, $checkThis);
            
            $category->name = $name;
            $category->discount_id = $discount_id;
            $category->save();
            return response()->json(['success'=>'Updated successfully.']);
        } else {
            $checkThis = [
                'name' => 'required|string',
            ];
    
            $this->validate($req, $checkThis);
            $createCategory = new Category;
            $createCategory->name = $name;
            $createCategory->discount_id = $discount_id;  
            $createCategory->save();
            return response()->json(['success'=>'Created successfully.']);
        }        
    }

    public function deleteCategory($id)
    {
        Category::find($id)->delete();
        return response()->json(['success'=>'Deleted successfully.']);
    }
}
