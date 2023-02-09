@extends('layouts.admin_app')

@section('title', 'Edit Users')
@section('content')
     <!-- /.card -->

        <div class="">
          <div class=" row justify-content-center">
            <div class="card col-md-4 p-5 mt-5">
                <div class="">
                    <h2 >Edit Users</h2>
                    <hr>
                  </div>
                  <form method="POST" action="{{ route('update.users') }}">
                      @csrf
                      <div class="input-group mb-3">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                        
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                      <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->name }}" required autocomplete="email">
                        
                        @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                      </div>
                      <div class="input-group mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                        
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                      <div class="input-group mb-3">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password">
                        
                      </div>
                      <div class="row">
                        <div class="col-8">
                          
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                          <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                      </div>
                  </form>
            </div>
        </div>
        </div>

      <!-- /.card -->

   
    
@endsection