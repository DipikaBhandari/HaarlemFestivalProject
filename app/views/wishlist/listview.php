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

<?php if (!empty($orderItems)): ?>
    <div id="agendacontainer" class="agenda" style="display: none">
        <h1>Your Personal Program</h1>
        <?php foreach ($orderItems as $order): ?>
            <div class="mb-3">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h6 class="card-subtitle mb-2 text-muted"><?= $order->getDate() ?></h6>
                            <h6 class="card-subtitle mb-2 text-muted"><?= $order->getStartTime()?> till <?= $order->getEndTime()?> </h6>
                        </div>

                        <div>
                            <h5 class="card-title">Event: <?= $order->getEventName() ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Participants: <?= $order->getNumberOfTickets() ?></h6>
                        </div>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-danger delete-btn" data-id="<?= $order->getOrderItemId() ?>">Delete</button>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No items found in the order list.</p>
<?php endif; ?>

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