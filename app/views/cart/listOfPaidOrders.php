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
    <title>Ticket List</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            color: #333;
        }.header {
             text-align: center;
             padding: 20px;
             background-color: #FFF9EEFF;
             color: #333;
             border-radius: 10px;
             margin-bottom: 30px;
             box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
         }
        .box{
            margin: 40px auto 10px;
            background:#FFF9EE url(https://subtlepatterns.com/patterns/lightpaperfibers.png);
            color:#333;
            text-transform:uppercase;
            padding:8px;
            width:500px;
            font-weight:bold;
            text-shadow:0 1px 0 #fff;
            font-family: "arvo", serif;
            font-size: 15px;
            border: 1px dashed rgba(51, 51, 51, 0.5);
            -webkit-filter: drop-shadow(0 5px 18px rgba(0, 0, 0, 0.71));
        }
        .ticket-container {
            margin: 50px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .ticket {
            border: 2px dashed rgba(51, 51, 51, 0.5);
            min-height:120px;
            margin: 20px;
            padding: 10px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .ticket:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }
        .ticket h2 {
            margin: 0;
            color: #333;
            font-size: 20px;
        }
        .ticket h4 {
            margin: 5px 0;
            color: #666;
            font-size: 16px;
        }
        .ticket p {
            margin: 10px 0 0;
            color: #333;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Your Tickets</h1>
</div>
<div class="ticket-container">
    <?php foreach ($paidOrders as $ticket): ?>
    <div class="box">
        <div class='ticket'>
            <h2><?= $ticket->getEventName() ?></h2>
            <h4>Participants: <?= $ticket->getNumberOfTickets() ?></h4>
            <h4>Date of Event: <?= $ticket->getDate() ?></h4>
            <h4>Timeslot: <?= $ticket->getStartTime()?> till <?= $ticket->getEndTime()?> </h4>
        </div>
    </div>
    <?php endforeach; ?>
</div>
</body>
</html>
