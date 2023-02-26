@extends('layouts.customer_app')

@section('title', 'My Orders')
@section('content')
<!-- /.card -->

<div class="row justify-content-center">
  <div class="col-md-12">
    
    
    <!-- /.card-header -->
    <div class="card-body">
      <table id="" class="table table-bordered table-striped user_datatable">
        <thead>
        <tr>
          <th>#</th>
          <th>Invoice Id</th>
          <th>Product Name</th>
          <th>Price</th>
          <th>Subscription/Product</th>
          <th>Order Status</th>
          <th>Payment Status</th>
          <th>View Invoice</th>
        </tr>
        </thead>
        <tbody>
        </tbody>

      </table>
    </div>
  </div>
</div>



{{-- modal --}}
{{-- <div class="modal fade" id="ajaxModelexa" aria-hidden="true">
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
</div> --}}
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
          ajax: "{{ route('customer.order') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'invoice', name: 'invoice'},
              {data: 'product_name', name: 'product_name'},
              {data: 'total', name: 'total'},
              {data: 'subscription_month', name: 'subscription_month'},
              {data: 'status', name: 'status'},
              {data: 'payment_status', name: 'payment_status'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });

});

</script>
@endpush

   
    
@endsection