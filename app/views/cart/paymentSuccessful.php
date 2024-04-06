<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 10px;
            width: 60%;
            text-align: center;
        }

        #homeLink {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        #homeLink:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div id="registerModal" class="modal" style="display: block;">
    <div class="modal-content">
        <h1 style="color: #205e71">Haarlem Festival</h1>
        <h4>Payment Successful!</h4>
        <p>Thank you for the payment! You will receive your tickets and invoice in your mail. </p>

        <a id="homeLink" class="nav-link pe-5" aria-current="page" href="/home">Go back to Homepage</a>
        <a id="homeLink" class="nav-link pe-5" aria-current="page" href="/shoppingCart/showPaidOrders">Orders</a>

    </div>
</div>

</body>
</html>
