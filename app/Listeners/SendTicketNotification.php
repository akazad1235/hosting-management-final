<?php

namespace App\Listeners;

use App\Events\TicketProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTicketNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TicketProcessed  $event
     * @return void
     */
    public function handle(TicketProcessed $event)
    {
        //
    }
}
