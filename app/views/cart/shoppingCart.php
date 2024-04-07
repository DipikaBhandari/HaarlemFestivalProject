
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
                                                        <h6 id="participants<?= $order->getOrderItemId() ?>" class="card-subtitle mb-2 text-muted">Price: $<?= $order->getPrice() ?></h6>
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
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.increase-btn').forEach(item => {
            item.addEventListener('click', event => {
                const orderId = event.target.dataset.id;
                const participantsCountElem = document.getElementById(`participants-count-${orderId}`);
                let count = parseInt(participantsCountElem.textContent);

                count++;
                participantsCountElem.textContent = count;

                // Send AJAX request to update quantity and retrieve updated price
                updateQuantity(orderId, count);

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

                    // Calculate total price
                    const priceElement = document.getElementById(`participants${orderId}`);
                    const currentPrice = parseFloat(priceElement.textContent.replace('Price: $', '').trim());
                    const totalPrice = currentPrice - 17.5; // Decrease by the price of one ticket

                    // Send AJAX request to update quantity and price
                    updateQuantity(orderId, count, totalPrice);

                }
            });
        });

        document.querySelectorAll('.delete-btn').forEach(item => {
            item.addEventListener('click', event => {
                const orderId = event.target.dataset.id;
                deleteOrder(orderId); // Call deleteOrder function with orderId
                // Optionally, remove the card or update the UI
                event.target.closest('.mb-3').remove(); // Remove the card element from the DOM
                //window.location.reload();
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

        function updateQuantity(orderItemId, count) {
            fetch('/shoppingcart/updateQuantity', {
                method: 'POST',
                body: JSON.stringify({orderItemId: orderItemId, numberOfTickets: count}),
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




