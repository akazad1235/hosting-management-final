@extends('layouts.admin_app')

@section('title', 'Manage Products')
@section('content')
<!-- /.card -->

<div class="card-header">
  <h3 class="card-title">Manage Products</h3> <br>
  <a class="btn btn-dark" href="javascript:void(0)" id="createNewUser">Add New Product</a>
</div>

<!-- /.card-header -->
<div class="card-body">
  <table id="" class="table table-bordered table-striped user_datatable">
    <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Category</th>
      {{-- <th>Status</th> --}}
      <th>Discount</th>
      <th>Price</th>
      <th>Action</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
    
    
  </table>
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
                          <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" required>
                      </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="status">Category</label>
                        <select class="form-control" id="category_id" name="category_id">
                          @foreach ($categories as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="status">Discount</label>
                        <select class="form-control" id="discount_id" name="discount_id">
                          <option value="null">No Discount</option>
                          @foreach ($discounts as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="price" name="price" placeholder="Enter price" required>
                    </div>
                </div>
    
                  <div class="form-group">
                      <label class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-12">
                        <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
                      </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="status">Purchase Type</label>
                        <select class="form-control" id="purchase_type" name="purchase_type">
                            <option value="Regular" selected>Regular</option>
                            <option value="Subscription">Subscription</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  {{-- <div>
                    <img src="#" alt="" name="preiImg" id="preiImg">
                  </div> --}}

                  {{-- <div class="custom-file mt-3 mb-3">
                    <input type="file" class="custom-file-input" id="image" name="image">
                    <label class="custom-file-label" for="customFile">Image Upload</label>
                  </div> --}}
    
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="savedata" value="create">Save
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
      columnDefs: [{
    "defaultContent": "-",
    "targets": "_all"
  }],
    "processing":true,
    "serverSide":true,
    "responsive": true,
    "dom":'lBfrtip',
          ajax: "{{ route('admin.products') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'cat_name', name: 'cat_name'},
              {data: 'disc_name', name: 'disc_name'},
              {data: 'price', name: 'price'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });

      $('#createNewUser').click(function () {
      $('.errorMessage').remove();  
      $('#savedata').html("Create User");
      $('#id').val('');
      $('#postForm').trigger("reset");
      $('#modelHeading').html("Create New Product");
      $('#savedata').html('Create');
      $('#ajaxModelexa').modal('show');
  });


  //edit data
  $('body').on('click', '.editPost', function () {
    $('.errorMessage').remove();  
    var id = $(this).data('id');
    let url = "{{ route('edit.product',':id') }}";
    url = url.replace(':id', id);
    // console.log(url);
    $.get(url, function (data) {
      // console.log(data);
      $('#modelHeading').html("Edit Prodcut");
      $('#savedata').html("Update");
      $('#ajaxModelexa').modal('show');
      $('#name').val(data.name);
      $('#description').val(data.description);
      $('#price').val(data.price);
      $('#purchase_type').val(data.purchase_type);
      $('#category_id').val(data.category_id);
      $('#discount_id').val(data.discount_id);
      $('#id').val(data.id);
      // $('div.status select').val(data.status);
    })
  });

  $('#savedata').click(function (e) {
    e.preventDefault();
    // $(this).html('Sending..');
    $('.errorMessage').remove();  

    $.ajax({
      "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
      data: $('#postForm').serialize(),
      url: "{{ route('update.product') }}",
      type: "POST",
      dataType: 'json',
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
    let deleteUrl = "{{ route('delete.product',':id') }}";
    deleteUrl = deleteUrl.replace(':id', id);
    confirm("Are You sure want to delete this Post!");
  
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