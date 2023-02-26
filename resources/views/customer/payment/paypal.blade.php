@extends('layouts.customer_app')

@section('title', 'Payment')

@section('content')

<!-- Set up a container element for the button -->

    @php
        // if(!(isset($_SESSION['value']) && isset($_SESSION['currency']))){
        //     header('Location: signUp_email.php');
        // }
        // $value = {{$cartProdcut->}};
        $currency = 'USD';
             //paypal sdk
            // $value = $addToCart->total_discounted_price;
            $value = $cartProdcut[0]->total_discounted_price;

            // $currency = 'AUD';
            $paypal_sdk_api = "https://www.paypal.com/sdk/js?client-id=test&currency=".$currency;
        // $paypal_sdk_api = "https://www.paypal.com/sdk/js?client-id=AamCc-h0T41_FqF3hPHy2VfNEvZB_lO2LpX2x4jRir7SYdNlF6VdlW_skLgosYg3WI0Of7q8TC_dHyIg&currency=".$currency;
    @endphp



    <div class="row justify-content-center">
        <div class="col-md-6 card mt-5">
            <div class="card-title mt-5 text-center">
                <h2>Pay with paypal</h2>
            </div>
            <div class="card-body">
                <div id="paypal-button-container" style="margin-top: 30px"></div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
    
    
    <!-- Include the PayPal JavaScript SDK -->
    
    <script src="<?php echo"$paypal_sdk_api"?>">
   
    </script>

    <script type="text/javascript">
        // Render the PayPal button into #paypal-button-container
        paypal.Buttons({
            // Set up the transaction
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo"$value"?>',
                        }
                    }]
                });
            },
            style: {
                layout: 'horizontal'
            },

            // Finalize the transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                    var data = JSON.stringify(orderData, null, 2);
                    console.log('Capture result', data);
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    // alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');
                    if(orderData && orderData.status === "COMPLETED"){
                        var userData = orderData.purchase_units[0];
                        var address = userData.shipping.address;

                        //alert(orderData.purchase_units[0].amount.value);
                        console.warn('myData: ', orderData);
                        console.warn('myData: ', userData);
                        const element = document.getElementById('paypal-button-container');
                        element.innerHTML = '';
                        element.innerHTML = '<h3>Payment Successful. <br />Thank you for your payment!</h3>';
                        
                        window.location.href = `{{route('verify.payment', ['cartId' => $cartProdcut[0]->id, 'payment_type' => 'paypal_payment'])}}`;
                    } 
                });
            }
        }).render('#paypal-button-container');
    </script>
    
@endsection
    