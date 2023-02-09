<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables; 

class DiscountController extends Controller
{

    public function discounts(Request $req){
        $data = Discount::query();
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
        return view('admin.discounts.manage_discounts', compact('data'));
    }

    public function editDiscount($id)
    {
        // return $id;
        $discount = Discount::find($id);
        return response()->json($discount);
    }

    public function updateDiscount(Request $req){
        $name = $req->name;
        $discount_type = $req->discount_type;
        $value = $req->value;
        $data = Discount::find($req->id);
        if($data){
            $checkThis = [
                'name' => 'required|string',
                'discount_type' => 'required',
                'value' => 'required',
            ];
            $this->validate($req, $checkThis);
            $data->name = $name;
            $data->discount_type = $discount_type;
            $data->value = $value;
            $data->save();
            return response()->json(['success'=>'Updated successfully.']);
        } else {
            $checkThis = [
                'name' => 'required|string',
                'discount_type' => 'required',
                'value' => 'required',
            ];
    
            $this->validate($req, $checkThis);
            $insertData = new Discount;
            $insertData->name = $name;
            $insertData->discount_type = $discount_type;
            $insertData->value = $value;
            $insertData->save();
            return response()->json(['success'=>'Created successfully.']);
        }        
    }

    public function deleteDiscount($id)
    {
        Discount::find($id)->delete();
        return response()->json(['success'=>'Deleted successfully.']);
    }
}
