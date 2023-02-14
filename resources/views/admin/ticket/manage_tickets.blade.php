@extends('layouts.admin_app')

@section('title', 'Manage Tickets')
@section('content')
     <!-- /.card -->

        
      
      <div class="row justify-content-center">
        <div class="col-md-8 card mt-5">
          <div class="card-header">
            <h3 class="card-title">Manage Tickets</h3>
          </div>
            <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>#</th>
              <th>User_id</th>
              <th>Order_id</th>
              <th>Ticket Code</th>
              <th>Status</th>
              <th>Conversation</th>
            </tr>
            </thead>
            <tbody>
            
              @foreach ($data as $index => $item)
              <tr>
                  <td> {{$index+1}} </td>
                  <td> {{$item->user_id}} </td>
                  <td> {{$item->order_id}} </td>
                  <td> {{$item->ticket_code}} </td>
                  <td> <span class="text-primary">{{$item->status ? $item->status: 'open'  }}</span> </td>
                  {{-- <td> {{$item->status ? $item->status : 'open'}} </td> --}}
                  {{-- <td> <a class="btn btn-primary" href="{{route('add.product', ['id' => $item->id])}}">Edit</a> </td> --}}
                  <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#manageOrder">
                    View Conversations
                  </button></td>
                 
                </tr>
              @endforeach
            
            
          </table>
        </div>
        <!-- /.card-body -->
        </div>
      </div>

      
<div class="modal" id="manageOrder">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('update.users') }}">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Conversatons</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <p>Conversatons</p>

      {{-- <!-- Modal body -->
      <div class="modal-body">
        
          @csrf
          <div class="input-group mb-3">
            <input id="name" type="text" value="" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus placeholder="Name"> 
          </div>
      </div> --}}

      <!-- Modal footer -->
      <div class="modal-footer">
        <div class="col-4">
          <button type="submit" class="btn btn-primary btn-block">Send</button>
        </div>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </form>

    </div>
  </div>
</div>

    
@endsection