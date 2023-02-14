@extends('layouts.admin_app')

@section('title', 'Manage Tickets')
@section('content')
     <!-- /.card -->
      <div class="row justify-content-center body-color">
        <div class="col-md-8 card mt-5 mx-auto">
            <div class="chat-box" id="show-chat" style="overflow-y: scroll; height:400px;">

            </div>
            <input type="text" id="admin_id" value="{{ Auth::guard('admin')->user()->id }}">
            <input type="text" id="user_id" value="{{$customer->customer_id}}">

            <input type="text" value="">
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
    <script src="{{asset('js/app.js')}}"></script>
@endpush


@endsection
