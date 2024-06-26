
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<section>
    <?php
    // Include the appropriate header based on whether the user is logged in or not
    if(isset($_SESSION['username'])) {
        include __DIR__ . '/../afterlogin.php'; // Include afterlogin.php for logged-in users
    } else {
        include __DIR__ . '/../header.php'; // Include default header for non-logged-in users
    }

    ?>
    <div class="container-fluid h-100 py-1">
        <div class="row h-100 d-flex justify-content-center align-items-center">
            <div class="col-lg-8">
                <div class="card card-registration card-registration-2" style="border-radius: 15px; background-color: #d2c9ff;">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-lg-11" >
                                <div class="p-5">
                                    <div class="d-flex justify-content-center align-items-center mb-5">
                                        <h1 class="fw-bold mb-0 text-center">Shopping Cart</h1>
                                    </div>
                                    <?php if (empty($orders)): ?>
                                        <div class="alert alert-info" role="alert">
                                            You need to buy tickets to see your orders. Click the button below to go to the homepage.
                                        </div>
                                        <a href="/home/index" class="btn btn-primary">Go to Homepage</a>
                                    <?php else: ?>

                                        <?php foreach ($orders as $order): ?>
                                            <div class="mb-3">
                                                <div class="card">
                                                    <div class="card-body d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h5 id="eventName<?= $order->getOrderItemId() ?>" class="card-title"><?= $order->getEventName() ?></h5>
                                                            <h6 class="card-subtitle mb-2 text-muted">Participants: <?= $order->getNumberOfTickets() ?></h6>
                                                            <h6 id="participants<?= $order->getOrderItemId() ?>" class="card-subtitle mb-2 text-muted">Price: €<?= $order->getPrice() ?></h6>
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
                                            <h5 id="totalPrice">€<?php echo $totalPrice; ?></h5>
                                        </div>
                                        <form method="post" action="/shoppingCart/pay">
                                            <input type="hidden" name="amount" value="<?php echo $totalPrice; ?>">
                                            <input type="hidden" name="description" value="Test">
                                            <input type="hidden" name="redirectUrl" value="http://localhost/shoppingCart/paymentRedirect">
                                            <input type="hidden" name="webhookUrl" value="https://example.com/webhook">
                                            <button id="payButton" type="submit" name="payNow" class="btn btn-warning btn-block btn-lg" style="width: 100%;">Buy Tickets</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.increase-btn').forEach(item => {
            item.addEventListener('click', event => {
                const orderId = event.target.dataset.id;
                const participantsCountElem = document.getElementById(`participants-count-${orderId}`);
                const eventNameElement = document.getElementById(`eventName${orderId}`).textContent;

                let count = parseInt(participantsCountElem.textContent);

                count++;
                participantsCountElem.textContent = count;

                // Send AJAX request to update quantity and retrieve updated price
                updateQuantity(orderId, count, eventNameElement, 'increase');

            });
        });

        document.querySelectorAll('.decrease-btn').forEach(item => {
            item.addEventListener('click', event => {
                const orderId = event.target.dataset.id;
                const participantsCountElem = document.getElementById(`participants-count-${orderId}`);
                const eventNameElement = document.getElementById(`eventName${orderId}`).textContent;

                let count = parseInt(participantsCountElem.textContent);
                if (count > 0) {
                    count--;
                    participantsCountElem.textContent = count;

                    // Send AJAX request to update quantity and price
                    updateQuantity(orderId, count, eventNameElement, 'decrease');

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
                body: JSON.stringify({orderItemId: orderItemId}),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (response.ok) {
                        window.location.reload();
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

        function updateQuantity(orderItemId, count, eventName, calculationMethod) {
            fetch('/shoppingcart/updateQuantity', {
                method: 'POST',
                body: JSON.stringify({orderItemId: orderItemId, numberOfTickets: count, eventName: eventName, calculationMethod: calculationMethod}),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (response.ok) {
                         window.location.reload();
                        console.log('Quantity updated successfully');

                        // Optionally, update the total price or UI
                    } else {
                        console.error('Failed to update quantity');
                    }
                })
                .catch(error => {
                    console.error('Error updating quantity:', error);
                });
        }
    });

</script>
</body>
</html>




