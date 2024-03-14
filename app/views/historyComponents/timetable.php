<!DOCTYPE html>
<html>
<head>
    <style>
        .pop-up {
            display: none; /* Initially hide the pop-up */
            position: fixed;
            top: 50%;
            left: 66%;
            /*transform: translate(-50%, -50%);*/
            background: #582F0E;
            color: #FFFFFF;
            border-radius: 20px;
            padding: 20px;
            z-index: 1000; /* Ensure pop-up appears above other elements */
        }
        .container {
            display: flex;
            padding: 10px;
        }

        .item {

            margin-right: 10%; /* Adjust as needed */
        }
    </style>
</head>
<body>
<div class="time-container" style="text-align: center; margin-left: 4%; margin-bottom: 50px;">
    <table style="border: 1px solid black; font-family: Inter, serif;">
        <thead>
        <tr style="height: 50px; background: #582F0E; color: #FFFFFF; font-size: 24px;">
            <th colspan="4" style="border: 1px solid #FFFFFF;">Date</th>
            <th colspan="3" style="border: 1px solid #FFFFFF;">10:00</th>
            <th colspan="3" style="border: 1px solid #FFFFFF;">13:00</th>
            <th colspan="3" style="border: 1px solid #FFFFFF;">16:00</th>
            <th style="border: 1px solid #FFFFFF;">Guides Name</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($section['historyDetails']) && !empty($guides)): ?>
            <?php
            // Group history details by date
            $groupedDetails = [];
            foreach ($section['historyDetails'] as $detail) {
                $groupedDetails[$detail['date']][] = $detail;
            }
            ?>
            <?php foreach ($groupedDetails as $date => $details): ?>
                <tr>
                    <td colspan="4" style="border-left:  1px solid #000; border-right: 1px solid #000; padding: 20px; color: #006D77; font-size: 26px; font-weight: bold;"><?php echo $date; ?></td>
                    <?php foreach ($details as $detail): ?>
                        <?php
                        // Split the image paths into an array
                        $imagePaths = explode(", ", $detail['languageIndicator']);
                        ?>
                        <?php for ($i = 0; $i < 3; $i++): ?>
                            <td colspan="1" style="border-bottom: 1px solid #000; padding: 10px;">
                                <?php if (isset($imagePaths[$i])): ?>
                                    <button onclick="togglePopUp('<?php echo $date; ?>', '<?php echo $detail['startTime']; ?>', '<?php echo $detail['endTime']; ?>', '<?php echo $imagePaths[$i]; ?>')" style="border: none; background: none;"><img src="<?php echo $imagePaths[$i]; ?>" alt=""></button>
                                <?php endif; ?>
                            </td>
                        <?php endfor; ?>
                    <?php endforeach; ?>
                    <td style="border: 1px solid #582F0E;">
                        <?php
                        // Find the guide name for this date
                        $guideName = '';
                        foreach ($guides as $guide) {
                            if ($guide['guideId'] == $details[0]['guideId']) { // Use the guideId of the first detail in the loop
                                $guideName = $guide['guideName'];
                                break;
                            }
                        }
                        echo $guideName;
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="pop-up" id="pop-up">
        <form id="ticket-form" method="post">
        <h2>A Stroll Through History Ticket</h2>
        <div class="container">
            <div class="item">Language: <img class="language-image" src="" alt=""></div>
            <div class="item">Date:</div>
            <div class="item">Start Time:</div>
            <div class="item">End Time:</div>

        </div>

    <div class="container">

        <div class="row">
            <div class="col-md-10">
                <div class="card mb-3">
                    <div class="card-body">
                        <span class="text-primary fs-5 fw-bold">Regular Participant:</span>
                        <span class="me-4 fs-9">€17.50 each</span>
                        <span class="text-primary fs-5 fw-bold">Family Ticket:</span>
                        <span class="fs-9">€60 each</span>
                        <small class="text-muted"> (max. 4 participants)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="d-flex align-items-center mb-4">
                    <button class="btn btn-outline-dark decrease-amount me-2">-</button>
                    <div class="me-2 fs-5 amount">0</div>
                    <button class="btn btn-outline-dark increase-amount">+</button>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <button class="btn btn-outline-dark family-decrease-amount me-2">-</button>
                    <div class="me-2 fs-5 family-amount">0</div>
                    <button class="btn btn-outline-dark family-increase-amount">+</button>
                </div>
            </div>
        </div>


    </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary" name="addToPersonalProgram">Add to Personal Program <img src="/img/heartbutton.svg" width="20" height="20" alt=""> </button>
            </div>
        </div>
    </div>
</div>
    <script src="/javascript/personalprogram.js"></script>

<script>
    // Function to toggle pop-up visibility
    function togglePopUp(date, startTime, endTime, imagePath) {
        var popUp = document.getElementById("pop-up");
        popUp.style.display = (popUp.style.display === "none") ? "block" : "none";

        if (popUp.style.display === "block") {
            var popUpDate = popUp.querySelector('.pop-up .container .item:nth-child(2)');
            var popUpStartTime = popUp.querySelector('.pop-up .container .item:nth-child(3)');
            var popUpEndTime = popUp.querySelector('.pop-up .container .item:nth-child(4)');

            var popUpLanguageImage = popUp.querySelector('.pop-up .container .item:nth-child(1) .language-image'); // Correct selection of the image

            popUpLanguageImage.src = imagePath; // Set the src attribute to display the image
            popUpDate.textContent = "Date: " + date;
            popUpStartTime.textContent = "Start Time: " + startTime;
            popUpEndTime.textContent = "End Time: " + endTime;

        }


    }

    // Select the buttons and the amount display element
    var decreaseButton = document.querySelector('.decrease-amount');
    var increaseButton = document.querySelector('.increase-amount');
    var amountDisplay = document.querySelector('.amount');

    var familyDecreaseButton = document.querySelector('.family-decrease-amount');
    var familyIncreaseButton = document.querySelector('.family-increase-amount');
    var familyAmountDisplay = document.querySelector('.family-amount');

    // Initial amounts
    var amount = 0;
    var familyAmount = 0;

    // Add event listener for decrease button
    decreaseButton.addEventListener('click', function() {
        if (amount > 0) {
            amount--;
            amountDisplay.textContent = amount;
        }
    });

    // Add event listener for increase button
    increaseButton.addEventListener('click', function() {
        if (amount + familyAmount < 12) { // Check combined total
            amount += 1;
            amountDisplay.textContent = amount.toString(); // Convert to string before assignment
        }
    });

    // Add event listener for family decrease button
    familyDecreaseButton.addEventListener('click', function() {
        if (familyAmount > 0) {
            familyAmount--;
            familyAmountDisplay.textContent = familyAmount;
        }
    });

    // Add event listener for family increase button
    familyIncreaseButton.addEventListener('click', function() {
        if ((amount + familyAmount < 12) && (familyAmount <4 )){ // Check combined total
            familyAmount += 1;
            familyAmountDisplay.textContent = familyAmount.toString(); // Convert to string before assignment
        }
    });


    // Add event listener to the "Add to Personal Program" button
    document.querySelector('.btn-primary').addEventListener('click', function() {
        // Retrieve ticket information from the page
        // Retrieve ticket information from the page
        var eventName = 'Event Name'; // Replace with actual value
        var dateElement = document.querySelector('.pop-up .container .item:nth-child(2)');
        var startTimeElement = document.querySelector('.pop-up .container .item:nth-child(3)');
        var endTimeElement = document.querySelector('.pop-up .container .item:nth-child(4)');
        var amountElement = document.querySelector('.amount');

        // Check if elements are retrieved correctly
        console.log('Date:', dateElement.textContent);
        console.log('Start Time:', startTimeElement.textContent);
        console.log('End Time:', endTimeElement.textContent);
        console.log('Amount Element:', amountElement);

        // Extract data from elements
        var date = dateElement.textContent.replace('Date: ', '');
        var startTime = startTimeElement.textContent.replace('Start Time: ', '');
        var endTime = endTimeElement.textContent.replace('End Time: ', '');

        // Check if data extraction is correct
        console.log('Extracted Date:', date);
        console.log('Extracted Start Time:', startTime);
        console.log('Extracted End Time:', endTime);

        // Get the number of tickets
        var numberOfTickets = parseInt(amountElement.textContent);
        console.log('Number of Tickets:', numberOfTickets);
        // Create an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/ticket/addOrder');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert('Ticket saved successfully!');
                } else {
                    alert('Failed to save ticket: ' + response.error);
                }
            } else {
                alert('Failed to save ticket: ' + xhr.statusText);
            }
        };
        xhr.onerror = function() {
            alert('Failed to save ticket: Network error');
        };

        // Send the AJAX request with ticket information
        xhr.send('eventName=' + encodeURIComponent(eventName) +
            '&date=' + encodeURIComponent(date) +
            '&startTime=' + encodeURIComponent(startTime) +
            '&endTime=' + encodeURIComponent(endTime) +
            '&numberOfTickets=' + encodeURIComponent(numberOfTickets));
    });



</script>
</body>
</html>


