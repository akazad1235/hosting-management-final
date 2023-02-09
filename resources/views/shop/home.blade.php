@extends('layouts.shop_app')

@section('title', 'Home')

@section('content')
    {{-- <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
          <div class="row mb-2">
            <div class="col-sm-6">
              
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Layout</a></li>
                <li class="breadcrumb-item active">Top Navigation</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header --> --}}
      {{-- carosol --}}
     
  
      <!-- Main content -->
      <div class="content">
        <div class="container">
          <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4">Pricing</h1>
            <p class="lead">Quickly build an effective pricing table for your potential customers with this Bootstrap example. It’s built with default Bootstrap components and utilities with little customization.</p>
          </div>
          <div class="row justify-content-center mt-5">

            @foreach ($products as $item)
            <div class="col-md-4">
              <div class="card mx-auto d-block" style="width: 18rem;">
                <img src="{{$item->image}}" class="card-img-top rounded float-left float-right" alt="...">
                <div class="card-body">
                  <h5 class="card-title">{{$item->name}}</h5>
                  <p class="card-text">{{$item->description}}</p>
                  <hr>
                  <p class="card-text">{{$item->price}}</p>
                  <a href="#" class="btn btn-primary">Buy Now</a>
                </div>
              </div>
            </div>
            @endforeach
  
             
           
            <!-- /.col-md-6 -->
            {{-- <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title m-0">Featured</h5>
                </div>
                <div class="card-body">
                  <h6 class="card-title">Special title treatment</h6>
  
                  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
              </div>
  
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h5 class="card-title m-0">Featured</h5>
                </div>
                <div class="card-body">
                  <h6 class="card-title">Special title treatment</h6>
  
                  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
              </div>
            </div> --}}
            <!-- /.col-md-6 -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
@endsection