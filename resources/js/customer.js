require('./bootstrap');


// const submit_message_form =document.getElementById('submit_message_form');
// const message_input =document.getElementById('message_input');
// const admin_id =document.getElementById('admin_id');


// submit_message_form.addEventListener('submit', function(e){
//     e.preventDefault();

//         axios({
//         method: 'post',
//         url: '/admin/send-message',
//         data: {
//             message: message_input.value,
//             userId: user_id.value,
//         }
//     })
//         .then(res=>{
//             console.log(res.data);
//         })
//         .catch(function (error) {
//             console.log(error);
//         });

//  })

const submit_message_form =document.getElementById('submit_message_form');
const message_input =document.getElementById('message_input');
const ticket_id =document.getElementById('ticket_id');
const admin_id =document.getElementById('admin_id');

let showChat = document.getElementById('show-chat');

submit_message_form.addEventListener('submit', function(e){
    e.preventDefault();

        axios({
        method: 'post',
        url: '/customer/send-message',
        data: {
            message: message_input.value,
            adminId: admin_id.value,
            ticketId: ticket_id.value,
        }
    })
        .then(res=>{
            console.log(res.data);
            message_input.value ='';
            showChat.innerHTML +=`
            <p class="text-center" style="margin-bottom: -10px; color:rgb(167, 158, 158); font-size:10px">${res.data.dateTime}</p>
            <div class="bg-light align-items-center m-3 d-flex flex-row-reverse p-1 rounded">
                    <div>
                            <p style="margin-bottom: 0px" class="font-weight-bold">${res.data?.customerName}</p>
                            <img class="rounded-circle" style="width: 40px; float:right" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="">
                    </div>
                <div>
                    <p class="user p-2 mb-1">${res.data.message}</p>
                </div>
                </div>
            `
        })
        .catch(function (error) {
            console.log(error);
        });

 })

    var customer_id =document.getElementById('customer_id').value;

    var id = parseInt(customer_id);
    console.log(customer_id);

        window.Echo.private('customer.'+id)
        .listen('AdminMessage',(e)=>{
            console.log(e);

        //  message_input.value='';
        //   message_el.innerHTML +='<div class="message"><strong style="color:red">'+e.message +'</strong>'+ e.message+'</div>'
           // if(e.customer_id == id){
                showChat.innerHTML +=`
                <p class="text-center" style="margin-bottom: -10px; color:rgb(167, 158, 158); font-size:10px">${e.dateTime}</p>
                <div class="bg-secondary align-items-center m-3 d-flex p-1 rounded">
                        <div>
                            <p style="margin-bottom: 0px" class="font-weight-bold">${e.adminName}</p>
                            <img class="rounded-circle" style="width: 40px; float:right" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="">
                        </div>
                    <div>
                        <p class="user mb-1 p-2">${e.message}</p>
                    </div>

                    </div>
                `
           // }
    });

