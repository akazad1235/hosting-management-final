@extends('layouts.customer_app')

@section('title', 'Cehckout')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-9 card p-3 my-5">
            {{-- Registration --}}
    <div class="mt-2" id="showcustomerRegistration">
        <form class="needs-validation" method="POST" action="{{ route('customer.generate.ticket') }}" enctype="multipart/form-data">
            @csrf
            {{-- <input type="text" id="product_discounted_price" name="product_discounted_price" hidden>
            <input type="hidden" class="cuppon_discounted_price" name="cuppon_discounted_price">
            <input type="text" id="total_discounted_price" name="total_discounted_price" hidden>
            <input type="text" name="product_id" id="product_id" hidden> --}}
            {{-- regustration inputs --}}

            <div>
                <p class="text-bold">Generate ticket</p>
                <hr>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name">
                        Name
                    </label>
                    <input type="text" value="{{ Auth::guard('customer')->user()->name }}" class="form-control @error('email') is-invalid @enderror" readonly/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">
                        Email
                    </label>
                    <input type="email" value="{{ Auth::guard('customer')->user()->email }}" class="form-control @error('email') is-invalid @enderror" readonly/>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="priority">
                        Set Priority
                    </label>
                    <select class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                        <option value="">Select One</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                    @error('priority')
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
                        <option value="">Select One</option>
                        <option value="admin">Admin</option>
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
                    <select class="form-control @error('product_id') is-invalid @enderror" id="product" name="product_id">
                        <option value="">Select One</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} </option>
                        @endforeach
                    </select>
                    @error('product_id')
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
                    <textarea class="form-control  @error('message') is-invalid @enderror" name="message" id="conversation" cols="100" rows="5" placeholder="Typeing..."></textarea>

                    @error('message')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="mb-3 @error('image') is-invalid @enderror">
                        <label for="formFile" class="form-label"> Submit screenshot only (not recomended)</label>
                        <input class="form-control" type="file" id="formFile" name="image" accept="image/png, image/gif, image/jpeg, image/jpg">
                    </div>
                    @error('image')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <button class="btn btn-secondary btn-lg btn-block" type="submit">
                Submit Ticket
            </button>
        </form>
    </div>
        </div>
    </div>

@endsection
