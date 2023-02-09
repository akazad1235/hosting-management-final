@extends('layouts.admin_app')

@section('title', 'Manage Categories')
@section('content')
<!-- /.card -->

<div class="row justify-content-center">
  <div class="col-md-8">
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
          <th>Name</th>
          <th>Discount Name</th>
          <th>Action</th>
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
                          {{-- <option value="No Discount">No Discount</option> --}}
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
          ajax: "{{ route('product.category') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'discname', name: 'discname'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });

  $('#createNewUser').click(function () {
      $('.errorMessage').remove();  
      $('#savedata').html("Create User");
      $('#id').val('');
      $('#postForm').trigger("reset");
      $('#modelHeading').html("Create New Category");
      $('#savedata').html('Create');
      $('#ajaxModelexa').modal('show');
  });

  //edit data
  $('body').on('click', '.editPost', function () {
    var id = $(this).data('id');
    let url = "{{ route('edit.category',':id') }}";
    url = url.replace(':id', id);
    // console.log(url);
    $.get(url, function (data) {
      // console.log(data);
      console.log(data)
      $('#modelHeading').html("Edit User");
      $('#savedata').html("Update");
      $('#ajaxModelexa').modal('show');
      $('#name').val(data.name);
      $('#discount_id').val(data.discount_id);
      $('#id').val(data.id);
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

$('body').on('click', '.deletePost', function () {
    var id = $(this).data('id');
    let deleteUrl = "{{ route('delete.category',':id') }}";
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