@extends('layouts.customer_app')

@section('title', 'Customer Address')

@section('content')
<!-- /.card -->

<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card-header">
      <h3 class="card-title">Manage Address</h3> <br>
      <a class="btn btn-dark" href="javascript:void(0)" id="createNewUser">Add New Address</a>
    </div>
    
    <!-- /.card-header -->
    <div class="card-body">
      <table id="" class="table table-bordered table-striped user_datatable">
        <thead>
        <tr>
          <th>#</th>
          <th>Company</th>
          <th>Country</th>
          <th>Address</th>
          <th>State</th>
          <th>City</th>
          <th>Zip</th>
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
                      <label for="title" class="col-sm-2 control-label">Company</label>
                      <div class="col-sm-12">
                          <input type="text" class="form-control" id="company" name="company" placeholder="Enter Company" required>
                      </div>
                  </div>

                  <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Country</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="country" name="country" placeholder="Enter country" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">State</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="state" name="state" placeholder="Enter state" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">City</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="city" name="city" placeholder="Enter city" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Zip_code</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Enter zip_code" required>
                    </div>
                </div>
                  {{-- <div class="form-group">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="status">Discount Type</label>
                        <select class="form-control" id="discount_type" name="discount_type">
                          <option value="amount">amount</option>
                          <option value="percent">percent</option>
                          
                        </select>
                      </div>
                    </div>
                  </div> --}}


                {{-- <div class="form-group">
                  <label for="title" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-12">
                      <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category Name" required>
                  </div>
              </div> --}}
    
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
          ajax: "{{ route('customer.address') }}",
          columns: [
              {data: 'company', name: 'company'},
              {data: 'country', name: 'country'},
              {data: 'address', name: 'address'},
              {data: 'state', name: 'state'},
              {data: 'city', name: 'city'},
              {data: 'zip_code', name: 'zip_code'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });

  $('#createNewUser').click(function () {
      $('.errorMessage').remove();  
      $('#savedata').html("Create");
      $('#id').val('');
      $('#postForm').trigger("reset");
      $('#modelHeading').html("Create New Address");
      $('#savedata').html('Create');
      $('#ajaxModelexa').modal('show');
  });

  //edit data
  $('body').on('click', '.editPost', function () {
    // $('.errorMessage').remove();  
    var id = $(this).data('id');
    let url = "{{ route('edit.address',':id') }}";
    url = url.replace(':id', id);
    // console.log(url);
    $.get(url, function (data) {
      // console.log(data);
      console.log(data)
      $('#modelHeading').html("Edit Address");
      $('#savedata').html("Update");
      $('#ajaxModelexa').modal('show');
      $('#company').val(data.company);
      $('#country').val(data.country);
      $('#address').val(data.address);
      $('#state').val(data.state);
      $('#city').val(data.city);
      $('#zip_code').val(data.zip_code);
      $('#id').val(data.id);
    })
  });

  $('#savedata').click(function (e) {
    e.preventDefault();
    // $(this).html('Sending..');
    $('.errorMessage').remove();  

    $.ajax({
      "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
      url: "{{route('update.address')}}",
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

$('body').on('click', '.deletePost', function () {
    var id = $(this).data('id');
    let deleteUrl = "{{ route('delete.address',':id') }}";
    deleteUrl = deleteUrl.replace(':id', id);
    confirm("Are You sure want to delete!");
  
    $.ajax({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
        url: deleteUrl,
        success: function (data) {
          // console.log(data);
          customAlert('success', data.success);
          table.draw();
        },
        error: function (data) {
          customAlert('error', data);
            // console.log('Error:', data);
        }
    });
});
  

});

</script>
@endpush

   
    
@endsection