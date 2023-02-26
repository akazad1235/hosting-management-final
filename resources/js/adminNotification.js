require('./bootstrap');



window.Echo.private('AdminNotifications')
.listen('CustomerTicket',(e)=>{
    let notifications = document.getElementById("ticket-notifications");
    let ticketCount = document.getElementById("ticket-notification-count")
    let existingCount = ticketCount.textContent

    ticketCount.innerHTML = parseInt(existingCount)+1;


   // let testRouote = "ticket.readAs.notification,$e.conversion_id";
    notifications.innerHTML +='<a href="/admin/conversation/'+e.ticket_id+'"  class="dropdown-item"><i class="fas fa-envelope mr-2"></i>'+e.name+'<span class="float-right text-muted text-sm">'+e.time+'</span></a>'

    console.log(e);
});
