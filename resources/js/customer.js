require('./bootstrap');

window.Echo.private('customer.'+50)
.listen('AdminMessage',(e)=>{
    console.log(e);
  //  message_input.value='';
  //   message_el.innerHTML +='<div class="message"><strong style="color:red">'+e.message +'</strong>'+ e.message+'</div>'
});
