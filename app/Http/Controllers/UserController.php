<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user_logout(){
        auth()->guard('web')->logout();
        return redirect()->route('admin.login');
    }
}
