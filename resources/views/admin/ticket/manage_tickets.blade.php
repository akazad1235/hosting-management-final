@extends('layouts.admin_app')

@section('title', 'Manage Tickets')
@section('content')
     <!-- /.card -->



      <div class="row justify-content-center">
        <div class="col-md-12 card mt-5">
            notify-
            @foreach (auth()->user()->notifications as $notification)
                <li>{{ $notification->data['name'] }}</li>
            @endforeach
          <div class="card-header">
            <h3 class="card-title">Manage Tickets</h3>
          </div>
            <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped ticket_datatable">
            <thead>
            <tr>
              <th>#</th>
              <th>Customer Email</th>
              <th>Order Id</th>
              <th>Ticket Code</th>
              <th>Priority</th>
              <th>Status</th>
              <th>Conversation</th>
            </tr>
            </thead>
            <tbody>

              {{-- @foreach ($tickets as $index => $item)
              <tr>
                  <td> {{$index+1}} </td>
                  <td> {{$item->user_id}} </td>
                  <td> {{$item->order_id}} </td>
                  <td> {{$item->ticket_code}} </td>
                  <td> <span class="text-primary">{{$item->status ? $item->status: 'open'  }}</span> </td>
                  <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#manageOrder">
                    View Conversations
                  </button></td>

                </tr>
              @endforeach --}}
            </tbody>


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

@push('page-script')
    <script>
      var a = 1;
        $(function(){
            var table = $('.ticket_datatable').DataTable({
      columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
        }],
    "processing":true,
    "serverSide":true,
    "responsive": true,
   //    "dom":'lBfrtip',
          ajax: "{{ route('manage.tickets') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'email', name: 'email'},
              {data: 'order_id', name: 'order_id'},
              {data: 'ticket_code', name: 'ticket_code'},
              {data: 'priority', name: 'priority'},
              {data: 'status', name: 'status'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
        })
    </script>
@endpush


@endsection
