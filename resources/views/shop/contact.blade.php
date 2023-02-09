@extends('layouts.shop_app')

@section('title', 'Contact')

@section('content')
     <!-- Default box -->
     <div class="card">
        <div class="card-body row">
          <div class="col-5 text-center d-flex align-items-center justify-content-center">
            <div class="">
              <h2>BFIN IT<strong>PVT LTD</strong></h2>
              <p class="lead mb-5 mx-5">(Asian Markets, White label Products, Payroll Services, Support, Training). 2/23, Razia Sultana Road, Mohammadpur, Dhaka –1207, Bangladesh<br>
                Phone: +1 234 56789012
              </p>
            </div>
          </div>
          <div class="col-6">
            <h2>Contact</h2>
            <hr>
            <div class="form-group">
              <label for="inputName">Name</label>
              <input type="text" id="inputName" class="form-control" />
            </div>
            <div class="form-group">
              <label for="inputEmail">E-Mail</label>
              <input type="email" id="inputEmail" class="form-control" />
            </div>
            <div class="form-group">
              <label for="inputSubject">Subject</label>
              <input type="text" id="inputSubject" class="form-control" />
            </div>
            <div class="form-group">
              <label for="inputMessage">Message</label>
              <textarea id="inputMessage" class="form-control" rows="4"></textarea>
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Send message">
            </div>
          </div>
        </div>
      </div>
@endsection