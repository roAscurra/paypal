<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add meta tags for mobile and IE -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> PayPal Checkout Integration | Server Demo </title>

</head>

<body>
 <!-- Set up a container element for the button -->
 <div id="paypal-button-container"></div>

<!-- Include the PayPal JavaScript SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=AezMuAOhAZTiZeWUHNK_8hRhLPXXqgs-uEB6eE9vdvaX_YLUzT8mD0ZLV4-boS8DnDK5QXiWMua7xcgI"></script>

<script>
    var amount = 200;
    // Render the PayPal button into #paypal-button-container
    paypal.Buttons({

        // Call your server to set up the transaction
        createOrder: function(data, actions) {
            return fetch('createOrder.php', {
                method: 'post',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    amount: amount,
                }),
            }).then(function(res) {
                return res.json();
            }).then(function(orderData) {
                return orderData.id;
            });
        },
        onCancel: function(data){
            alert("Usted canceló su pago");
        },
        onApprove: function(data, actions) {
            actions.order.capture().then(function(details){
                console.log(details)
            })
        }

    }).render('#paypal-button-container');
</script>
</body>

</html>
