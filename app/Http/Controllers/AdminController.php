<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function authenticate(Request $req){
        $checkThis = [
            'email' => 'required|email',
            'password' => 'required|min:4|max:8'
        ];

        $this->validate($req, $checkThis);

        if(Auth::guard('admin')->attempt(['email' => $req->email, 'password' => $req->password], $req->get('remember'))){
            return redirect()->route('admin.dashboard');
        } else {
            session()->flash('error', 'Email/Password is incorrect!');
            return back()->withInput($req->only('email'));
        }
    }

    public function register(Request $req){
        $checkThis = [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        $this->validate($req, $checkThis);

        $dataArray  = array(
            "name"          =>          $req->name,
            "email"         =>          $req->email,
            'password' => Hash::make($req->password),
        );

        $admin = Admin::create($dataArray);
        if(!is_null($admin)) {
            return back()->with("success", "Success! Registration completed");
        }

        else {
            return back()->with("failed", "Alert! Failed to register");
        }
    }

    public function logout(){
        auth()->guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
