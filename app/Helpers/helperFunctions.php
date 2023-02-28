<?php
use App\Models\Ticket;

    /*
     * unread tickets get
     */
    function readAsTickets(){
       return Ticket::whereNull('read_at')->with(['conversion', 'customer'])->orderBy('id', 'desc')->get();
    }
    //all ticket count for notifications
    function countTicket(){
        $counts = Ticket::whereNull('read_at')->get();
        echo count($counts);
    }

    function randomStatusColor($status){

        $color = [
            'pending' => 'danger',
            'connected' => 'warning',
            'incomplete'  => 'secondary',
            'done'  => 'success',
        ];

        return $color[$status];
    }




