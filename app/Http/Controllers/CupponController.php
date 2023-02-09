<?php

namespace App\Http\Controllers;
use App\Models\Cuppon;
use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
// Use Illuminate\Support\Carbon;

class CupponController extends Controller
{
    public function cuppons(Request $req){
        $data = DB::table('cuppons')
             ->join('discounts', 'cuppons.discount_id', '=', 'discounts.id')
             ->select('cuppons.*','discounts.name as discount_name', 'discounts.value as discount_amount')
             ->get();
        //  dd($data);
         $discounts = Discount::get();
         if ($req->ajax()) {
             return DataTables::of($data)
                 ->addIndexColumn()
                 ->addColumn('action', function($row){
                     //    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    //  if($row->start_date){
                    //     return date('d-m-Y', strtotime($row->start_date));
                    //   }
                    //   if($row->end_date){
                    //     return date('d-m-Y', strtotime($row->end_date));
                    //   }
                     $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPost">Edit</a>';
 
                     $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';
                     return $btn;
                 })
                 ->addColumn('start_date', function ($row) {
                    if($row->start_date){
                      return date('d-m-Y', strtotime($row->start_date));
                    }else{
                        return "-";
                    }
                })
                ->addColumn('end_date', function ($row) {
                    if($row->end_date){
                      return date('d-m-Y', strtotime($row->end_date));
                    }else{
                        return "-";
                    }
                })
                 ->rawColumns(['action'])
                 ->make(true);
         }
         // return view('admin.category.manage_categories');
         return view('admin.discounts.manage_cuppons', compact('data', 'discounts'));
     }
 
     public function editCuppon($id)
     {
         // return $id;
         $category = Cuppon::find($id);
         return response()->json($category);
     }


 
     public function updateCuppon(Request $req){

            //  generate cuppon code
     function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

         $name = $req->name;
         $cuppon_code = generateRandomString(6);
         $discount_id = $req->discount_id;
         $status = $req->status;
        //  $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $req->start_date);
        
        //  $start_date =  Carbon::createFromFormat('d-m-Y h:i', $req->start_date);
        //  $end_date =  Carbon::createFromFormat('d-m-Y h:i', $req->end_date);

        $start_date = date($req->start_date);
        $end_date = date(($req->end_date));
         
         $update = Cuppon::find($req->id);
         if($update){
             $checkThis = [
                 'name' => 'required|string',
             ];
             $this->validate($req, $checkThis);
             
             $update->name = $name;
             $update->cuppon_code = $cuppon_code;
             $update->discount_id = $discount_id;
             $update->status = $status;
             if($start_date && $end_date){
                $update->start_date = $start_date;
                $update->end_date = $end_date;  
             }
             $update->save();
             return response()->json(['success'=>'Updated successfully.']);
         } else {
             $checkThis = [
                 'name' => 'required|string',
             ];
     
             $this->validate($req, $checkThis);
             $create = new Cuppon;
             $create->name = $name;
             $create->cuppon_code = $cuppon_code;
             $create->discount_id = $discount_id;
             $create->status = $status;
             if($start_date && $end_date){
                $create->start_date = $start_date;
                $create->end_date = $end_date;  
             }
             $create->save();
             return response()->json(['success'=>'Created successfully.']);
         }        
     }
 
     public function deleteCuppon($id)
     {
         Cuppon::find($id)->delete();
         return response()->json(['success'=>'Deleted successfully.']);
     }
}
