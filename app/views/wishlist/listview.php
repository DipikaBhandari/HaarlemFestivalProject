<?php
// Include the appropriate header based on whether the user is logged in or not
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
    <title>Your Personal Program</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <style>
        h1 {
            text-align: center;
            color: rgba(88, 47, 14, 0.83);
            font-family: Aleo, serif;
            font-size: 50px;
            margin-bottom: 20px;
        }

        .fc-event-delete {
            cursor: pointer;
            position: absolute;
            top: 2px;
            right: 2px;
            color: white;
            font-size: 18px;
        }

        /* Style the modal */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 20%;
            top: 0;
            width: 60%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */

        }

        /* Modal Content/Box */
        .modal-content {
            background-color: rgba(115, 153, 157, 0.9);
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            text-align: center;
        }

        /* The Close Button */
        .close {
            color: #830606;
            float: right;
            font-size: 30px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        button{
            background-color: #5aa9b0;
        }
        button:hover{
            background-color: #cccccc;
        }
        .paid {
            color: #888888;
            background-color: rgba(136, 231, 149, 0.43); /* Light red for work tasks */
        }

    </style>
</head>
<body>
<div>
<button class="btn btn-primary btn-lg" onclick="generatePDF()">Download Personal Program</button>

    <?php
if (!empty($sharingUrl)) {
    // Render the "Share" button
    echo '<a href="#" onclick="showShareModal(\'' . $sharingUrl . '\')" class="btn btn-primary btn-lg">Share</a>';
}
?>
    <button id="toggleButton" class="btn btn-primary" style="position: absolute; top: 140px; right: 10px;">Toggle View</button>

</div>


<div id="calendarContainer">
    <h1>Your Personal Program</h1>

        <div id="calendar" class="pdf-page" data-events="<?php echo htmlspecialchars(json_encode($events)); ?>"></div>

</div>


<!-- Modal -->
<div id="shareModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" onclick="closeShareModal()">&times;</span>
        <p>Share this link:</p>
        <input type="text" id="shareLink" style="width: 80%; margin-bottom: 10px;" readonly>
        <br>
        <!-- Add social media sharing buttons here -->
        <button onclick="copyShareLink()">Copy Link</button>
        <button onclick="shareOnWhatsApp()">Share on WhatsApp</button> <!-- New button for WhatsApp -->
        <button onclick="shareOnSocialMedia()">Share on Social Media</button>
    </div>
</div>


<div id="agendacontainer" class="agenda" style="display: none; margin: 100px;">
    <h1>Your Personal Program</h1>
    <div class="row">
        <?php foreach ($orderItems as $order): ?>
            <?php
            // Determine the status and set the appropriate class for background color
            $statusClass = '';
            $orderStatus = $order->getStatus(); // Assuming getStatus() returns the status of the orderItem

            if ($orderStatus === 'paid') {
                $statusClass = 'paid';
            } elseif ($orderStatus === 'open') {
                $statusClass = 'open';
            }
            ?>
            <div class="col-md-6 mb-4">
                <div class="card <?php echo $statusClass; ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 text-right"> <!-- Adjust column width and text alignment -->
                                <h3 class="card-title"><?= $order->getEventName() ?></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="card-subtitle mb-2 text-muted`-white">Date: <?= $order->getDate() ?></h6>
                                <h6 class="card-subtitle mb-2 text-muted-white">Time: <?= $order->getStartTime()?> - <?= $order->getEndTime()?></h6>
                            </div>
                            <div class="col-md-6">
                                <h6 class="card-subtitle mb-2 text-muted-white">Participants: <?= $order->getNumberOfTickets() ?></h6>
                                <h6 class="card-subtitle mb-2 text-muted-white">Price: €<?= $order->getPrice() ?></h6>
                            </div>
                        </div>
                        <div class="col-md-12 text-right"> <!-- Adjust column width and text alignment -->
                            <?php if ($orderStatus !== 'paid'): ?>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-danger delete-btn" data-id="<?= $order->getOrderItemId() ?>">Delete</button>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="index">
        <span class="index-item paid" style="background-color: #rgba(136, 231, 149, 0.43);">Paid</span>
        <span class="index-item open" style="background-color: #006D77;">Unpaid</span>
    </div>
</div>






<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
<script src="/javascript/personalprogram.js"></script>
<script>
    // Function to toggle between calendar and agenda views
    function toggleView() {
        var calendarContainer = document.getElementById('calendarContainer');
        var agendaContainer = document.querySelector('.agenda');

        if (calendarContainer.style.display === 'block') {
            calendarContainer.style.display = 'none';
            agendaContainer.style.display = 'block';
        } else {
            calendarContainer.style.display = 'block';
            agendaContainer.style.display = 'none';
        }
    }

    // Add event listener to the toggle button
    document.getElementById('toggleButton').addEventListener('click', toggleView);
</script>


</body>
</html>