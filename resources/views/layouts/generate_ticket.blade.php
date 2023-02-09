@extends('layouts.shop_app') 

@section('title', 'Cehckout')

@section('content')
    
    <div class="row justify-content-center">
        <div class="col-md-8 card p-3 my-5">
            {{-- Registration --}}
    <div class="mt-2" id="showcustomerRegistration">
        <form class="needs-validation" id="registerFormValidation" method="POST" action="" novalidate>
            @csrf
            <input type="text" id="product_discounted_price" name="product_discounted_price" hidden>
            <input type="hidden" class="cuppon_discounted_price" name="cuppon_discounted_price">
            <input type="text" id="total_discounted_price" name="total_discounted_price" hidden>
            <input type="text" name="product_id" id="product_id" hidden>
            {{-- regustration inputs --}}
            
            <div>
                <p class="text-bold">Generate ticket</p>
                <hr>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="firstName">
                        Name
                    </label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="name" name="name" required readonly/>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">
                        Email
                    </label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Cupper" required readonly/>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="priority">
                        Set Priority
                    </label>
                    <select class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                        <option value="low" selected>Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                    @error('subscription')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="support_team">
                        Select Support Team
                    </label>
                    <select class="form-control @error('support_team') is-invalid @enderror" id="support_team" name="support_team" required>
                        <option value="admin" selected>Admin</option>
                        <option value="developer">Developer</option>
                        <option value="accounts">Accounts</option>
                    </select>
                    @error('support_team')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="product">
                        Select Your Product (not mendetory)
                    </label>
                    <select class="form-control @error('product') is-invalid @enderror" id="product" name="product" required>
                        <option value="">none</option>
                        <option value="product 1" selected>Product 1</option>
                        <option value="prodcut 2">Product 2</option>
                        <option value="prodcut 3">Product 3</option>
                    </select>
                    @error('subscription')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="conversation">
                        Type your issue
                    </label>
                    <textarea class="form-control" name="conversation" id="conversation" cols="100" rows="5"></textarea>
                    
                    @error('conversation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="mb-3">
                        <label for="formFile" class="form-label"> Submit screenshot only (not recomended)</label>
                        <input class="form-control" type="file" id="formFile">
                      </div>
                </div>
            </div>


            <button class="btn btn-primary btn-lg btn-block" type="submit">
                Submit Ticket
            </button>
        </form>
    </div>
        </div>
    </div>

@endsection