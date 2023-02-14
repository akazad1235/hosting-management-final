<?php

namespace App\Http\Controllers;

use App\Events\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversionController extends Controller
{
    public function chatRoom(){
       $admin = Auth::guard('admin')->user();
        $id = $admin->id;
    return view('index', compact('id'));
    }

    public function sendMessage(Request $request){
       $admin =  Auth::guard('admin')->user();
       $message = $request->message;
       $name = $admin->id;

      //  broadcast(new Message($admin, $message));

        return response()->json(['success' => 'message send success']);
    }
}
