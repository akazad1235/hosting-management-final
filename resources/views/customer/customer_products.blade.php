@extends('layouts.customer_app')

@section('title', 'My Orders')
@section('content')
<!-- /.card -->

<div class="row justify-content-center">
  <div class="col-md-10">
    
    <!-- /.card-header -->
    <div class="card-body">
      <table id="" class="table table-bordered table-striped user_datatable">
        <thead>
        <tr>
          <th>#</th>
          <th>Product Name</th>
          <th>Product Category</th>
          <th>Subscription Duration</th>
          <th>Product Status</th>
          <th>Manage Prodcut</th>
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
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="modelHeading">Manage Product</h4>
          </div>
          <div class="modal-body">
            <div>
              <h2 class="text-center mb-2">Prodcut Details</h2>
              <hr>
              <div class="row justify-content-around">
                <div class="col-md-4">
                  <p>Product Name: </p>
                  <p>Purchase Category: </p>
                  <p>Prodcut Status: </p>
                </div>
                <div class="col-md-4">
                  <p>Product Description: </p>
                  <p>Purchase Type: </p>
                </div>
              </div>
              <hr>
            </div>

            <div>
              <h2 class="text-center mb-2">Subscription Status</h2>
              <hr>
              <div class="row justify-content-around">
                <div class="col-md-4">
                  <p>Subscription Duratino: </p>
                  <p>Subscription Status: </p>
                </div>
                <div class="col-md-4">
                  <p>Start Date: </p>
                  <p>End Date: </p>
                </div>
              </div>
              <hr>
            </div>

            <div>
              <h2 class="text-center mb-2">Hosting Details(Admin Provided)</h2>
              <hr>
              <div class="row justify-content-around" id="hosting_details">
                <div class="col-md-4">
                  <p>Name: </p>
                  <p>Server: </p>
                  <p>No: </p>
                </div>
              </div>
              <hr>
            </div>

            <div>
              <h2 class="text-center mb-2">VPS/VDS/SERVER Details(Admin Provided)</h2>
              <hr>
              <div class="row justify-content-around" id="hosting_details">
                <div class="col-md-4">
                  <p>Ip: </p>
                  <p>Username: </p>
                  <p>Password: </p>
                  <hr>
                  <p>Prodcut Link: </p>
                </div>
              </div>
              <hr>
            </div>

            <div>
              <h2 class="text-center mb-2">Customer Actions</h2>
              <hr>
              <div class="row justify-content-center">
                <div class="col-md-10 text-center">
                  <div>
                    <a class="btn btn-danger" href="">Reboot</a>
                    <a class="btn btn-danger" href="">Suspend</a>
                    <a class="btn btn-danger" href="">Terminate</a>
                  </div>
                </div>
              </div>
              <hr>
            </div>



              {{-- <form id="postForm" name="postForm" class="form-horizontal">
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
                          <option value="No Discount">No Discount</option>
                          @foreach ($discounts as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                          @endforeach 
                        </select>
                      </div>
                    </div>
                  </div>
    
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Post
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
              </form> --}}
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Post
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
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
          ajax: "{{ route('customer.products') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'product_name', name: 'product_name'},
              {data: 'product_category_name', name: 'product_category_name'},
              {data: 'subscription_month', name: 'subscription_month'},
              {data: 'status', name: 'status'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });

  //edit data
  $('body').on('click', '.editPost', function () {
    $('#ajaxModelexa').modal('show');

    var id = $(this).data('id');
    let url = "{{ route('service.detailsinfo',':id') }}";
    url = url.replace(':id', id);
    // console.log(url);
    $.get(url, function (data) {
      // console.log(data);
      console.log(data)
      // $('#modelHeading').html("Edit User");
      // $('#savedata').html("Update");
      // $('#ajaxModelexa').modal('show');
      // $('#name').val(data.name);
      // $('#discount_id').val(data.discount_id);
      // $('#id').val(data.id);
    })
  });

  $('#savedata').click(function (e) {
    e.preventDefault();
    // $(this).html('Sending..');
    $('.errorMessage').remove();  
    console.log($('#postForm').serialize());

    $.ajax({
      "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
      url: "{{route('update.category')}}",
      type: "POST",
      dataType: 'json',
      data: $('#postForm').serialize(),
      success: function (data) {
        console.log(data)
          customAlert('success', data.success);
          $('#postForm').trigger("reset");
          $('#ajaxModelexa').modal('hide');
          table.draw();
      },
      error: function (err) {
          console.log('Error:', err);
          customAlert('error','Update Failed!!!');
          if (err.status == 422) { // when status code is 422, it's a validation issue
                console.log(err.responseJSON);
                $('#success_message').fadeIn().html(err.responseJSON.message);
                // you can loop through the errors object and show it to the user
                console.warn(err.responseJSON.errors);
                // display errors on each form field
                $.each(err.responseJSON.errors, function (i, error) {
                    var el = $(document).find('[name="'+i+'"]');
                    el.after($('<span style="color: red;" class="errorMessage">'+error[0]+'</span>'));
                });
            }
          // $('#savedata').html('Save Changes');
      }
  });
});  

});

</script>
@endpush

   
    
@endsection