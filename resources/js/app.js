require('./bootstrap');
// $(document).ready(function () {
//     const form = document.getElementById('submit-chat');
//         form.addEventListener('submit', function(event){
//             event.preventDefault();
//         axios({
//             method: 'post',
//             url: '/send-message',
//             data: {
//                 username:'azad121',
//                 message: 'ddddddddddsadd',
//             }
//         })
//             .then(res=>{
//                 console.log(res.data);
//             })
//             .catch(function (error) {
//                 console.log(error);
//             });
//     });
//     });

//     window.Echo.channel('chat')
//     .listen('.message', function(e){
//         $('#show-chat').append(e.userName);
//     })
