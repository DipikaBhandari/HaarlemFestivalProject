<?php



if(isset($_SESSION['username'])) {
    include __DIR__ . '/../afterlogin.php'; // Include afterlogin.php for logged-in users
} else {
    include __DIR__ . '/../header.php'; // Include default header for non-logged-in users
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/Admin/AdminPanelSideBar.css">
    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<section class="h-100" style="background-color: #d2c9ff;">
    <div class="container py-1 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-8">
                <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-lg-11">
                                <div class="p-5">
                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                        <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                                    </div>
<!--                                    --><?php //foreach ($orders as $event): ?>
<!--                                        <p>Event Name: --><?php //echo $event->eventName ?><!--</p>-->
                                        <!-- Other event details here -->
<!--                                    --><?php //endforeach; ?>
                                    <?php foreach ($orders as $order): ?>
                                        <div class="mb-3">
                                            <div class="card">
                                                <div class="card-body d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h5 class="card-title"><?= $order->getEventName() ?></h5>
                                                        <h6 class="card-subtitle mb-2 text-muted">Participants: <?= $order->getNumberOfTickets() ?></h6>
                                                        <h6 class="card-subtitle mb-2 text-muted">Price: $<?= $order->getPrice() ?></h6>
                                                    </div>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" class="btn btn-secondary btn-sm decrease-btn" data-id="<?= $order->getOrderItemId() ?>">-</button>
                                                        <span id="participants-count-<?= $order->getOrderItemId() ?>" class="btn btn-light"><?= $order->getNumberOfTickets() ?></span>
                                                        <button type="button" class="btn btn-secondary btn-sm increase-btn" data-id="<?= $order->getOrderItemId() ?>">+</button>
                                                        <button type="button" class="btn btn-danger delete-btn" data-id="<?= $order->getOrderItemId() ?>">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endforeach; ?>
                                    <div class="d-flex justify-content-between mb-5">
                                        <h5>Total Price</h5>
                                        <h5 id="totalPrice">$<?php echo $totalPrice; ?></h5>
                                    </div>
                                    <form method="post">
                                        <input type="hidden" name="amount" value="<?php echo $totalPrice; ?>">
                                        <input type="hidden" name="description" value="Test">
                                        <input type="hidden" name="redirectUrl" value="http://localhost/shoppingCart/paymentRedirect">
                                        <input type="hidden" name="webhookUrl" value="https://example.com/webhook">
                                        <button id="payButton" type="submit" name="payNow" class="btn btn-warning btn-block btn-lg" style="width: 100%;">Buy Tickets</button>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    // Add event listeners for increase, decrease, and delete buttons
    document.querySelectorAll('.increase-btn').forEach(item => {
        item.addEventListener('click', event => {
            const orderId = event.target.dataset.id;
            const participantsCountElem = document.getElementById(`participants-count-${orderId}`);
            let count = parseInt(participantsCountElem.textContent);
            count++;
            participantsCountElem.textContent = count;
            // Update price accordingly (You may need to implement this logic)
        });
    });

    document.querySelectorAll('.decrease-btn').forEach(item => {
        item.addEventListener('click', event => {
            const orderId = event.target.dataset.id;
            const participantsCountElem = document.getElementById(`participants-count-${orderId}`);
            let count = parseInt(participantsCountElem.textContent);
            if (count > 0) {
                count--;
                participantsCountElem.textContent = count;
                // Update price accordingly (You may need to implement this logic)
            }
        });
    });

    document.querySelectorAll('.delete-btn').forEach(item => {
        item.addEventListener('click', event => {
            const orderId = event.target.dataset.id;
            deleteOrder(orderId); // Call deleteOrder function with orderId
            // Optionally, remove the card or update the UI
            event.target.closest('.mb-3').remove(); // Remove the card element from the DOM
        });
    });

    function deleteOrder(orderItemId) {
        fetch('/ticket/deleteOrder', {
            method: 'POST',
            body: JSON.stringify({ orderItemId: orderItemId }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => {
                if (response.ok) {
                    console.log('Order item deleted successfully');
                    // Optionally, remove the card or update the UI
                } else {
                    console.error('Failed to delete order item');
                }
            })
            .catch(error => {
                console.error('Error deleting order item:', error);
            });
    }
</script>
<!-- JavaScript to calculate total price -->

</body>
</html>

<?php
//// Include Mollie API library
//require_once 'app/vendor/mollie-api-php/vendor/composer-autoload.php';
//
//// Initialize Mollie API client with your API key
//$mollie = new \Mollie\Api\MollieApiClient();
//$mollie->setApiKey('your_mollie_api_key');
//
//// Process form submission
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    // Retrieve customer details from the form
//    $customerName = $_POST['customer_name'];
//    $customerEmail = $_POST['customer_email'];
//    $totalAmount = 50; // Example total amount in cents or euros (depends on your currency)
//
//    try {
//        // Create a payment using Mollie API
//        $payment = $mollie->payments->create([
//            "amount" => [
//                "currency" => "EUR",
//                "value" => sprintf("%.2f", $totalAmount),
//            ],
//            "description" => "Order payment",
//            "redirectUrl" => "http://example.com/thank-you", // URL to redirect after payment
//            // Additional metadata if needed
//            "metadata" => [
//                "customer_name" => $customerName,
//                "customer_email" => $customerEmail,
//            ],
//        ]);
//
//        // Redirect the user to the payment URL
//        header("Location: " . $payment->getCheckoutUrl());
//        exit;
//    } catch (\Mollie\Api\Exceptions\ApiException $e) {
//        // Handle API errors
//        echo "API Error: " . htmlspecialchars($e->getMessage());
//    }
//}
//?>



