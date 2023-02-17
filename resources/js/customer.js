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
        }
    })
        .then(res=>{
            console.log(res.data);
            message_input.value ='';
            showChat.innerHTML +=`
            <div class="bg-light m-3 d-flex flex-row-reverse p-1 rounded">
                    <div>
                        <img class="" style="width: 30px" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="">
                    </div>
                <div>
                    <p class="user w-75 mb-1">${res.data.message}</p>
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
                <div class="bg-secondary m-3 d-flex p-1 rounded">
                        <div>
                            <img class="" style="width: 30px" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="">
                        </div>
                    <div>
                        <p class="user w-75 mb-1">${e.message}</p>
                    </div>

                    </div>
                `
           // }
    });

