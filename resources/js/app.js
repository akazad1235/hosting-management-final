require('./bootstrap');
 alert('okkkkxxxx');
// const message_el = document.getElementById('display-message');
// const username_input =document.getElementById('username');
// const message_input =document.getElementById('username_input');
// const message_form =document.getElementById('message_form');
// const user_id =document.getElementById('user-id').value;


// message_form.addEventListener('submit', function(e){
//     e.preventDefault();
//     alert('okkkk');
//     let has_errors = false;
//     if(username_input.value ==''){
//         alert('please enter your user name');
//         has_Errors = true;
//     }
//     if(message_input.value ==''){
//         alert('please enter your message');
//         has_Errors = true;
//     }
//     if(has_errors){
//         return;
//     }

//     axios({
//         method: 'post',
//         url: '/admin/send-message',
//         data: {
//             username: username_input.value,
//             message: message_input.value,
//         }
//     })
//         .then(res=>{
//             console.log(res);
//         })
//         .catch(function (error) {
//             console.log(error);
//         });

// })
//var convertId = parseInt(user_id);

const submit_message_form =document.getElementById('submit_message_form');
const message_input =document.getElementById('message_input');
const admin_id =document.getElementById('admin_id');
const user_id =document.getElementById('user_id');
let showChat = document.getElementById('show-chat');

submit_message_form.addEventListener('submit', function(e){
    e.preventDefault();

        axios({
        method: 'post',
        url: '/admin/send-message',
        data: {
            message: message_input.value,
            userId: user_id.value,
        }
    })
        .then(res=>{
            console.log(res.data);

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

 let id = parseInt(admin_id)
window.Echo.private('TestApp.'+id)
.listen('testEvent',(e)=>{
    console.log(e);
  //  message_input.value='';
  //   message_el.innerHTML +='<div class="message"><strong style="color:red">'+e.message +'</strong>'+ e.message+'</div>'
});


