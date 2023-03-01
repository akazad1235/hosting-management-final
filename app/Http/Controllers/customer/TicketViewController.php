<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketViewController extends Controller
{
    public function viewTicket($id){

        return view('customer.viewTickets', ['ticketId' => $id]);
    }
}
