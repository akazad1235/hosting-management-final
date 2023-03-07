@extends('layouts.admin_app')

@section('title', 'Customer Conversion')
@section('content')
     <!-- /.card -->
      <div class="row content body-color">
        <div class="col-md-12 mt-5 mx-auto ">
            <div class="card">
                <div class="card-body">
                    <div class="header d-flex justify-content-between border-bottom border-gray">
                        <div class="p-3">
                          <p>View Ticket <span class="font-weight-bold">#9479798</span></p>
                          <p>Subject: <span class="font-weight-bold">Suerver Issues</span></p>
                        </div>
                        <div class="p-3">
                          <button class="btn btn-info">Replay</button>
                          <button class="btn btn-danger">Closed</button>
                        </div>
                      </div>
                      @foreach ($conversions as $conversion)
                      <div class="ticket-body">
                          <div class="sub-header d-flex justify-content-between pl-3 pr-3" style="background-color: #dddd">
                              @if($conversion->admin)
                                  <p>Supported by {{$conversion->admin->name}} {{date('d-m-Y | H:i A', strtotime($conversion->created_at))}}</p>
                                  <p><span class="badge badge-success">Owner</span></p>
                              @else
                                  <p>posted by {{$conversion->customer->name}} {{date('d-m-Y | H:i A', strtotime($conversion->created_at))}}</p>
                                  <p><span class="badge badge-primary">Customer</span></p>
                              @endif

                          </div>
                          <div class="ticket-info p-3">
                            <p>{!! $conversion->message !!}</p>
                          </div>
                        </div>
                      @endforeach

                      {{-- <div class="ticket-body">
                        <div class="sub-header d-flex justify-content-between pl-3 pr-3" style="background-color: #dddd">
                            <p>posted by md. azad hosen</p>
                            <p><span class="badge badge-primary">Operator</span></p>
                        </div>
                        <div class="ticket-info p-3">
                          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut laudantium accusantium id consequuntur, odio tenetur aperiam. Nisi eos nesciunt ut aut architecto accusamus sapiente voluptate ea dolorem ex consequuntur labore nam assumenda magni blanditiis doloremque, dolor repellendus, culpa esse deleniti! Amet enim aspernatur maxime at veritatis eveniet, aut ea sunt reiciendis molestias vitae ipsum. Voluptatum est omnis minus voluptates sed a, id commodi! Adipisci voluptatibus sequi illo totam, fugiat, quibusdam quidem aliquid fugit similique placeat neque at minus eaque vel id reiciendis ut officia nihil doloribus. Porro doloribus repellendus, architecto repellat, reprehenderit, rem illo commodi provident exercitationem ipsam obcaecati dolorum?</p>
                        </div>
                      </div> --}}
                </div>
            </div>
        </div>
        <div class="replay col-md-12 card mt-1 mx-auto p-3">
            <p class="font-weight-bold">Reply</p>
            <div class="user-info d-flex">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->name }}">
                  </div>
                  <div class="form-group ml-5">
                    <label for="email">Email</label>
                    <input type="email" class="form-control"  value="{{ Auth::guard('admin')->user()->email }}">
                  </div>

            </div>
            <form action="{{route('admin.replay', $ticketId)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="summernote">Message</label>
                    <textarea class="form-control" name="message" id="summernote"></textarea>
                </div>

                <div class="form-group">
                    <label for="file">File</label>
                    <input type="file" class="form-control" name="file"  id="file">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
      </div>
</div>

@push('page-script')
    <script src="{{asset('js/customer.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
        $('#summernote').summernote({
            minHeight: 200,
        });
      });
    </script>
@endpush


@endsection
