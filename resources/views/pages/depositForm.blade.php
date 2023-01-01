@extends('layouts.app')

@section('title', "depositForm")

@section('content')

    <p>Select amount</p>
    <input type="radio" id= deposit1 name="deposit" onclick="handleClick(this)" value="deposit1">
    <label for="deposit1">€2.50</label>
    <input type="radio" id= deposit2 name="deposit" onclick="handleClick(this)" value="deposit2">
    <label for="deposit2">€5.00</label>
    <input type="radio" id= deposit3 name="deposit" onclick="handleClick(this)" value="deposit3">
    <label for="deposit3">€10.00</label>
    <input type="radio" id= deposit4 name="deposit" onclick="handleClick(this)" value="deposit4">
    <label for="deposit4">€25.00</label>
    <input type="radio" id= deposit5 name="deposit" onclick="handleClick(this)" value="deposit5">
    <label for="deposit5">€50.00</label>
    <input type="radio" id= deposit6 name="deposit" onclick="handleClick(this)" value="deposit6">
    <label for="deposit6">€100.00</label>
    <input type="radio" id= deposit7 name="deposit" onclick="handleClick(this)" value="deposit7">
    <label for="deposit7">€500.00</label>
    <input type="radio" id= deposit8 name="deposit" onclick="handleClick(this)" value="deposit8">
    <label for="deposit8">€1000.00</label>  xx
    <!-- Set up a container element for the button -->
    <div id="paypal-button-container"></div>

    <!-- Include the PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=AftpiB70FALqSt8S6JHQHm1lWNdXJyA2KtAIpZdC6sJlSrR6ACv6fNapY7gvvKu2JWBcPZljOrgKoJYx&currency=EUR"></script>

    <script>
        //get clicked radio btn
        function handleClick(radioBtn) {
            productValue = radioBtn.value;
            document.getElementById("paypal-button-container").style.display = "block";
        }

        // Render the PayPal button into #paypal-button-container
        paypal.Buttons({

            // Call your server to set up the transaction
            createOrder: function(data, actions) {
                return fetch('../../api/paypal/order/create', {
                    method: 'post',
                    body:JSON.stringify({
                        "value":productValue,
                        "author": {{ $user['id'] }}
                    })
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    return orderData.id;
                });
            },

            // Call your server to finalize the transaction
            onApprove: function(data, actions) {
                return fetch('api/paypal/order/' + data.orderID + '/capture/', {
                    method: 'post'
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    // Three cases to handle:
                    //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                    //   (2) Other non-recoverable errors -> Show a failure message
                    //   (3) Successful transaction -> Show confirmation or thank you

                    // This example reads a v2/checkout/orders capture response, propagated from the server
                    // You could use a different API or structure for your 'orderData'
                    var errorDetail = Array.isArray(orderData.details) && orderData.details[0];

                    if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                        return actions.restart(); // Recoverable state, per:
                        // https://developer.paypal.com/docs/checkout/integration-features/funding-failure/
                    }

                    if (errorDetail) {
                        var msg = 'Sorry, your transaction could not be processed.';
                        if (errorDetail.description) msg += '\n\n' + errorDetail.description;
                        if (orderData.debug_id) msg += ' (' + orderData.debug_id + ')';
                        return alert(msg); // Show a failure message (try to avoid alerts in production environments)
                    }

                    // Successful capture! For demo purposes:
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                    // Replace the above to show a success message within this page, e.g.
                    // const element = document.getElementById('paypal-button-container');
                    // element.innerHTML = '';
                    // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                    // Or go to another URL:  actions.redirect('thank_you.html');
                });
            }

        }).render('#paypal-button-container');
    </script>
@endsection
                                