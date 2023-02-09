<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;


class ManageUsersController extends Controller
{
    public function manageUsers(Request $req){
        // return User::whereEmail('akash@gmail.com')->count();
        if ($req->ajax()) {
            $data = User::query()->latest();
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
        return view('admin.manage_users.manage_users');
        // return view('admin.manage_users.manage_users', compact('data'));
    }

    public function editUsers($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function updateUsers(Request $req){
        $password = Hash::make($req->password);
        $name = $req->name;
        $email = $req->email;
        $status = $req->status;

        $user = User::find($req->id);
        if($user){
            $checkThis = [
                'name' => 'required|string',
                'email' => 'required|email',
            ];
            $this->validate($req, $checkThis);
            
            $user->name = $name;
            $user->email = $email;
            $user->status = $status;
            $user->password = $password;
            $user->save();
            return response()->json(['success'=>'User updated successfully.']);
        } else {
            $checkThis = [
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|min:8',
            ];
    
            $this->validate($req, $checkThis);
            $createUser = new User;
            $createUser->name = $name;
            $createUser->email = $email;
            $createUser->status = $status;
            $createUser->password = $password;
            $createUser->save();
            return response()->json(['success'=>'User created successfully.']);
        }

        // User::updateOrCreate(['id' => $req->id],
        //         ['name' => $req->name, 'email' => $req->email, 'status' => $req->status, 'password' => $req->password]);        
   
        // return response()->json(['success'=>'User saved successfully.']);
    }

    public function deleteUser($id)
    {User::find($id)->delete();
        return response()->json(['success'=>'User deleted successfully.']);
    }

    // public function updateUser(Request $req){
    //     $checkThis = [
    //         'name' => 'required|string',
    //         'email' => 'required|email',
    //         'password' => 'required|min:6',
    //     ];

    //     $this->validate($req, $checkThis);

    //     $user = User::find(3);
    //     $user->name = "Updated title";
    //     $user->email = "Updated title";
    //     if($user->password){
    //         $user->password = Hash::make($req->password);
    //     }
    //     $user->save();

    //     if(!is_null($user)) {
    //         return back()->with("success", "Success! update completed");
    //     }

    //     else {
    //         return back()->with("failed", "Alert! Failed to update");
    //     }
    // }


    // public function updateUsers(){
    //     dd("hello");
    // }



}
