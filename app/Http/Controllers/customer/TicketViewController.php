<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Conversion;
use Illuminate\Http\Request;

class TicketViewController extends Controller
{
    public function viewTicket($id){
       $conversions = Conversion::where('ticket_id', $id)->with('customer','admin:id,name')->get();

        return view('admin.ticket.viewTickets', ['ticketId' => $id, 'conversions' => $conversions]);
    }
}
