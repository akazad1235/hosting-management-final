<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function tickets (){
        $data = Ticket::get();
        return view('admin.ticket.manage_tickets', compact('data'));
    }
}
