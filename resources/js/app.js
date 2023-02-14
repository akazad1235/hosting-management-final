require('./bootstrap');
// alert('okkkkxxxx');
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

window.Echo.private('TestApp.'+6)
.listen('testEvent',(e)=>{
    console.log(e);
  //  message_input.value='';
  //   message_el.innerHTML +='<div class="message"><strong style="color:red">'+e.message +'</strong>'+ e.message+'</div>'
});


