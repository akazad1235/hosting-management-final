@extends('layouts.customer_app')

@section('title', 'Customer Address')

@section('content')
<!-- /.card -->

<div class="row">
  <div class="col-md-12">
    <div class="border-bottom p-3 d-flex justify-content-between align-items-center">
      <div><h3 class="card-title float-left">Ticket List</h3></div>
      <div><a class="btn btn-dark float-right" href="{{ route('customer.ticket') }}">Create New Ticket</a></div>
    </div>

    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped ticketList_datatable">
        <thead>
        <tr>
          <th>Ticket NO</th>
          <th>Priority</th>
          <th>support team</th>
          <th>Status</th>
          <th>Created At</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- /.card -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> --}}
@push('page-script')

<script type="text/javascript">
  $(function () {
    var table = $('#example1').DataTable({
    "processing":true,
    "serverSide":true,
    //"order": [[ 3, "desc" ]],
    "responsive": true,
          ajax: "{{ route('customer.ticket.list') }}",
          columns: [
              {data: 'ticket_code', name: 'ticket_code'},
              {data: 'priority', name: 'priority'},
              {data: 'support_team', name: 'support_team'},
              {data: 'status', name: 'status'},
              {data: 'created_at', name: 'created_at'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });


});

</script>
@endpush



@endsection
