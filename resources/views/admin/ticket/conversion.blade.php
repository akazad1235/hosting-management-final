@extends('layouts.admin_app')

@section('title', 'Manage Tickets')
@section('content')
     <!-- /.card -->
      <div class="row justify-content-center">
        <div class="col-md-8 card mt-5 mx-auto">
            <div class="chat-box" id="show-chat" style="overflow-y: scroll; height:400px;">
                <div class="bg-secondary m-3 d-flex p-1 rounded">
                    <div>
                        <img class="" style="width: 30px" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="">
                    </div>
                  <div>
                    <p class=" user w-75 mb-1">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tenetur consequatur repellat iusto, nostrum debitis aut perspiciatis maiores odit reprehenderit beatae suscipit nulla nemo facilis, cumque ipsam quis, unde sed nisi sit perferendis tempora est ad ratione ullam? Nemo distinctio laudantium non, vero minima optio cumque, asperiores suscipit facilis error hic!</p>
                  </div>

                </div>
                <div class="bg-secondary m-3 d-flex p-1 rounded">
                    <div>
                        <img class="" style="width: 30px" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="">
                    </div>
                  <div>
                    <p class=" user w-75 mb-1">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tenetur consequatur repellat iusto, nostrum debitis aut perspiciatis maiores odit reprehenderit beatae suscipit nulla nemo facilis, cumque ipsam quis, unde sed nisi sit perferendis tempora est ad ratione ullam? Nemo distinctio laudantium non, vero minima optio cumque, asperiores suscipit facilis error hic!</p>
                  </div>

                </div>
                <div class="bg-secondary m-3 d-flex p-1 rounded">
                    <div>
                        <img class="" style="width: 30px" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="">
                    </div>
                  <div>
                    <p class=" user w-75 mb-1">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tenetur consequatur repellat iusto, nostrum debitis aut perspiciatis maiores odit reprehenderit beatae suscipit nulla nemo facilis, cumque ipsam quis, unde sed nisi sit perferendis tempora est ad ratione ullam? Nemo distinctio laudantium non, vero minima optio cumque, asperiores suscipit facilis error hic!</p>
                  </div>

                </div>
                <div class="bg-secondary m-3 d-flex p-1 rounded">
                    <div>
                        <img class="" style="width: 30px" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="">
                    </div>
                  <div>
                    <p class=" user w-75 mb-1">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tenetur consequatur repellat iusto, nostrum debitis aut perspiciatis maiores odit reprehenderit beatae suscipit nulla nemo facilis, cumque ipsam quis, unde sed nisi sit perferendis tempora est ad ratione ullam? Nemo distinctio laudantium non, vero minima optio cumque, asperiores suscipit facilis error hic!</p>
                  </div>

                </div>
                <div class="bg-light m-3 d-flex flex-row-reverse p-1 rounded">
                    <div>
                        <img style="width:30px" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="">
                    </div>
                    <div>
                        <p class="float-right support w-75 mb-1">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Optio sit omnis fugiat aut nam dolor blanditiis incidunt eveniet in temporibus odio eius expedita sunt exercitationem fuga ipsa, eaque quis minus aliquid sapiente! Autem modi animi excepturi quas aliquam sunt dolore cupiditate aspernatur, itaque odio quos unde perspiciatis error possimus maxime.</p>
                    </div>
                </div>
                <div class="bg-light m-3 d-flex flex-row-reverse p-1 rounded">
                    <div>
                        <img style="width:30px" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="">
                    </div>
                    <div>
                        <p class="float-right support w-75 mb-1">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Optio sit omnis fugiat aut nam dolor blanditiis incidunt eveniet in temporibus odio eius expedita sunt exercitationem fuga ipsa, eaque quis minus aliquid sapiente! Autem modi animi excepturi quas aliquam sunt dolore cupiditate aspernatur, itaque odio quos unde perspiciatis error possimus maxime.</p>
                    </div>
                </div>
                <div class="bg-light m-3 d-flex flex-row-reverse p-1 rounded">
                    <div>
                        <img style="width:30px" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="">
                    </div>
                    <div>
                        <p class="float-right support w-75 mb-1">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Optio sit omnis fugiat aut nam dolor blanditiis incidunt eveniet in temporibus odio eius expedita sunt exercitationem fuga ipsa, eaque quis minus aliquid sapiente! Autem modi animi excepturi quas aliquam sunt dolore cupiditate aspernatur, itaque odio quos unde perspiciatis error possimus maxime.</p>
                    </div>
                </div>
            </div>

            <form id="submit-chat">
                <div class="d-flex w-100">
                    <input type="text" class="w-100" name="message" id="message" placeholder="please write your text">
                    <button type="submit">Send</button>
                </div>
            </form>
        </div>
      </div>


</div>

@push('page-script')
<script>
        var scrollDiv = document.getElementById("show-chat").offsetTop;
        window.scrollTo({ top: scrollDiv, behavior: 'smooth'});

        

</script>
@endpush


@endsection
