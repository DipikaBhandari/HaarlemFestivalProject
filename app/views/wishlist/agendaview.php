<?php
include __DIR__ . '/../header.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rectangle Example</title>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome CSS -->
    <script src="/javascript/personalprogram.js"></script>

        <h1 style="text-align: center; color: rgba(88, 47, 14, 0.83);font-family: Aleo,serif;font-size: 50px;
">Your Personal Program</h1>

</head>
<body>
<?php foreach ($orderItems as $order): ?>
    <div class="mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Event: <?= $order->getEventName() ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Participants: <?= $order->getNumberOfTickets() ?></h6>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary btn-sm decrease-btn" data-id="<?= $order->getOrderItemId() ?>">-</button>
                    <span id="participants-count-<?= $order->getOrderItemId() ?>"><?= $order->getNumberOfTickets() ?></span>
                    <button type="button" class="btn btn-secondary btn-sm increase-btn" data-id="<?= $order->getOrderItemId() ?>">+</button>
                </div>
                <button type="button" class="btn btn-danger delete-btn" data-id="<?= $order->getOrderItemId() ?>">Delete</button>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</body>
</html>


