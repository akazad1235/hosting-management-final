@extends('layouts.customer_app')

@section('title', 'Customer Conversion')
@section('content')
     <!-- /.card -->
      <div class="row justify-content-center body-color">
        <div class="col-md-8 card mt-5 mx-auto">
            <div class="chat-box" id="show-chat" style="overflow-y: scroll; height:400px;">
                @foreach ($conversions as $item)
                    @if($item->type === 'admin')
                    <div class="bg-secondary m-3 d-flex p-1 rounded">
                        <div>
                            <img class="" style="width: 30px" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="">
                        </div>
                    <div>
                        <p class="user mb-1">{{ $item->type }}</p>
                    </div>
                    </div>
                    @else
                    <div class="bg-light m-3 d-flex flex-row-reverse p-1 rounded">
                        <div>
                            <img class="" style="width: 30px" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="">
                        </div>
                    <div>
                        <p class="user mb-1">{{ $item->type }}</p>
                    </div>
                    </div>
                    @endif

                @endforeach

            </div>
            <input type="text" id="admin_id" hidden value="{{$conversion->admin_id}}">
            <input type="text" id="customer_id" hidden value="{{ Auth::guard('customer')->user()->id }}">
            <input type="text" id="ticket_id" hidden value="{{$conversion->ticket_id}}">
            <form id="submit_message_form">
                <div class="d-flex w-100">
                    <input type="text" class="w-100" name="message" id="message_input" placeholder="please write your text">
                    <button type="submit">Send</button>
                </div>
            </form>
        </div>
      </div>


</div>

@push('page-script')
    <script src="{{asset('js/customer.js')}}"></script>

@endpush


@endsection
