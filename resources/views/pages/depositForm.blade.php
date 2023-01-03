@extends('layouts.app')

@section('title', "depositForm")

@section('content')

    <p>Select amount</p>
    <input type="radio" id= deposit1 name="deposit" onclick="handleClick(this)" value="2.50">
    <label for="deposit1">€2.50</label>
    <input type="radio" id= deposit2 name="deposit" onclick="handleClick(this)" value="5.00">
    <label for="deposit2">€5.00</label>
    <input type="radio" id= deposit3 name="deposit" onclick="handleClick(this)" value="10.00">
    <label for="deposit3">€10.00</label>
    <input type="radio" id= deposit4 name="deposit" onclick="handleClick(this)" value="25.00">
    <label for="deposit4">€25.00</label>
    <input type="radio" id= deposit5 name="deposit" onclick="handleClick(this)" value="50.00">
    <label for="deposit5">€50.00</label>
    <input type="radio" id= deposit6 name="deposit" onclick="handleClick(this)" value="100.00">
    <label for="deposit6">€100.00</label>
    <input type="radio" id= deposit7 name="deposit" onclick="handleClick(this)" value="500.00">
    <label for="deposit7">€500.00</label>
    <input type="radio" id= deposit8 name="deposit" onclick="handleClick(this)" value="1000.00">
    <label for="deposit8">€1000.00</label> 
    <!-- Set up a container element for the button -->
    <div id="paypal-button-container"></div>

    <!-- Include the PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=AftpiB70FALqSt8S6JHQHm1lWNdXJyA2KtAIpZdC6sJlSrR6ACv6fNapY7gvvKu2JWBcPZljOrgKoJYx&currency=EUR"></script>

    <script>

        function handleClick(radio) {
            depositAmount = radio.value;
            console.log(depositAmount);
            document.getElementById("paypal-button-container").style.display= "block";
        }


        paypal.Buttons({
            // Order is created on the server and the order id is returned
            createOrder: (data, actions) => {
            return fetch("/api/paypal/order/create/", {
                method: "post",
                body:JSON.stringify({
                        "value": depositAmount,
                        "currency_code": "EUR"
                    })
                // use the "body" param to optionally pass additional order information
                // like product ids or amount
                })
                .then((response) => response.json())
                .then((order) => order.id);
            },
            // Finalize the transaction on the server after payer approval
            onApprove: (data, actions) => {
                return fetch(`/api/paypal/order/capture/`, {
                    method: "post",
                    body:JSON.stringify({
                        orderID: data.orderID
                    })
                })
                .then((response) => response.json())
                .then((orderData) => {
                    // Successful capture! For dev/demo purposes:
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    const transaction = orderData.purchase_units[0].payments.captures[0];
                    const amount = orderData.purchase_units[0].payments.captures[0].amount.value;

                    alert(`Transaction ${transaction.status}: ${amount}€\n\n`);
                    // When ready to go live, remove the alert and show a success message within this page. For example:
                    // const element = document.getElementById('paypal-button-container');
                    // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                    // Or go to another URL:  actions.redirect('thank_you.html');
                });
            }
        }).render('#paypal-button-container');
    </script>
@endsection
                                