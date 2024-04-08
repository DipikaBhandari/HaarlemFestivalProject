<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Unsuccessful</title>
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

        #tryAgainLink, #viewCartLink {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            background-color: #dc3545; /* Change color to signify an error or warning */
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        #tryAgainLink:hover, #viewCartLink:hover {
            background-color: #c82333; /* Darken the button on hover for better UX */
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

<div id="paymentFailedModal" class="modal" style="display: block;">
    <div class="modal-content">
        <h1 style="color: #8B0000">Haarlem Festival</h1> <!-- Change color to match the warning theme -->
        <h4>Payment Unsuccessful</h4>
        <p>We encountered an issue with your payment. Please try again or check your payment method for any issues. </p>

        <a id="tryAgainLink" href="/shoppingCart/index">Try Again</a> <!-- Button to retry payment -->
        <a id="homeLink" class="nav-link pe-5" aria-current="page" href="/home">Go back to Homepage</a>
    </div>
</div>

</body>
</html>
