@extends('layouts.admin_app')

@section('title', 'Manage Categories')
@section('content')
<!-- /.card -->

<div class="row justify-content-center">
  <div class="col-md-12">
    <div class="card-header">
      <h3 class="card-title">Manage Categories</h3> <br>
      <a class="btn btn-dark" href="javascript:void(0)" id="createNewUser">Add New Category</a>
    </div>
    
    <!-- /.card-header -->
    <div class="card-body">
      <table id="" class="table table-bordered table-striped user_datatable">
        <thead>
        <tr>
          <th>#</th>
          <th>Invoice</th>
          <th>User</th>
          <th>Total</th>
          <th>Payment</th>
          <th>Subscription</th>
          <th>Order Status</th>
          <th>Manage Order</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        
        
      </table>
    </div>
  </div>
</div>



{{-- modal --}}
<div class="modal fade" id="ajaxModelexa" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="modelHeading"></h4>
          </div>
          <div class="modal-body">
              <form id="postForm" name="postForm" class="form-horizontal">
                @csrf
                <input type="text" name="id" id="id" hidden>
                  <div class="form-group">
                      <label for="title" class="col-sm-2 control-label">Name</label>
                      <div class="col-sm-12">
                          <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category Name" required>
                      </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="status">Add Discount</label>
                        <select class="form-control" id="discount_id" name="discount_id">
                          <option value="null">No Discount</option>
                          
                            <option value="#"></option>
                          
                        </select>
                      </div>
                    </div>
                  </div>
    
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Post
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>
<!-- /.card -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> --}}
@push('page-script')

<script type="text/javascript">
  $(function () {
    var table = $('.user_datatable').DataTable({
    "processing":true,
    "serverSide":true,
    "responsive": true,
    "dom":'lBfrtip',
          ajax: "{{ route('product.orders') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'invoice', name: 'invoice'},
              {data: 'user_name', name: 'user_name'},
              {data: 'total', name: 'total'},
              {data: 'payment_status', name: 'payment_status'},
              {data: 'subs_type', name: 'subs_type'},
              {data: 'order_status', name: 'order_status'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });



});

</script>
@endpush

   
    
@endsection