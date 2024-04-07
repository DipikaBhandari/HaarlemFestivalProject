<!DOCTYPE html>
<html>
<head>
    <style>
        .pop-up {
            display: none; /* Initially hide the pop-up */
            position: fixed;
            top: 10%;
            left: 20%;
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
            margin-right: 5%; /* Adjust as needed */
        }
        tbody tr {
            border-bottom: 1px solid black; /* Add bottom border to each row */
        }
        /* Apply styling to both tables */
        table {
            border: 1px solid black;
            font-family: Inter, serif;
        }
        th {
            height: 50px;
            background: #582F0E;
            color: #FFFFFF;
            font-size: 24px;
            border: 1px solid #FFFFFF;
        }
        td {
            padding: 10px;

        }
    </style>
</head>
<body>
<div class="container" style="display: flex;">
    <!-- First table -->
    <div class="time-container" style="text-align: center; margin-left: 10%; margin-bottom: 50px;">
        <table>
            <thead>
            <tr>
                <th rowspan="10">Date</th>
                <th colspan="24">TimeSlots and Language</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($section['historyDetails']) && !empty($guides)): ?>
                <?php
                // Group history details by date
                $groupedDetails = [];
                foreach ($section['historyDetails'] as $detail) {
                    $groupedDetails[$detail['date']][] = $detail;
                    // Sort dates in ascending order
                    ksort($groupedDetails);
                }
                ?>
                <?php foreach ($groupedDetails as $date => $details): ?>
                    <tr>
                        <td colspan="5" style="color: #006D77;  border-left: 1px solid #000; border-right: 1px solid #000;font-size: 26px; font-weight: bold;"><?php echo $date; ?></td>

                        <?php
                        usort($details, function($a, $b) {
                            return strtotime($a['time']) - strtotime($b['time']);
                        });
                        foreach ($details as $detail): ?>
                            <td colspan="2"><?php echo $detail['time']; ?></td>
                            <?php
                            // Determine the maximum number of images in a time slot
                            $maxImages = 3; // Maximum number of images in each block of columns
                            // Split the image paths into an array
                            $imagePaths = explode(", ", $detail['languageIndicator']);
                            // Calculate the remaining columns without images
                            $remainingColumns = max(0, $maxImages - count($imagePaths));
                            ?>
                            <?php for ($i = 0; $i < $maxImages; $i++): ?>
                                <td colspan="1">
                                    <?php if (isset($imagePaths[$i])): ?>
                                        <button onclick="togglePopUp('<?php echo $date; ?>', '<?php echo $detail['startTime']; ?>', '<?php echo $detail['endTime']; ?>', '<?php echo $imagePaths[$i]; ?>')" style="border: none; background: none;"><img src="<?php echo $imagePaths[$i]; ?>" alt=""></button>
                                    <?php else: ?>
                                        <!-- Empty image placeholder -->
                                        <div style="width: 100px; height: 80px;"></div>
                                    <?php endif; ?>
                                </td>
                            <?php endfor; ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Second table for guide names -->
    <div class="guide-names" style="margin-left: 0;">
        <table>
            <thead>
            <tr>
                <th>Guide Names</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($groupedDetails)): ?>
                <?php foreach ($groupedDetails as $date => $details): ?>
                    <tr>
                        <td style="height: 101px;"> <!-- Set the height here -->
                            <?php
                            // Initialize an array to store unique guide names for the current date
                            $uniqueGuideNames = [];

                            foreach ($details as $detail) {
                                foreach ($guides as $guide) {
                                    if ($guide['guideId'] == $detail['guideId']) {
                                        // Check if the guide name is already added for the current date
                                        if (!in_array($guide['guideName'], $uniqueGuideNames)) {
                                            $uniqueGuideNames[] = $guide['guideName'];
                                        }
                                    }
                                }
                            }
                            echo implode(', ', $uniqueGuideNames);
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</body>
</html>


<div class="pop-up" id="pop-up">
    <form id="ticketform" method="post">
        <h2>A Stroll Through History Ticket</h2>
        <div class="container">


            <div class="item">
                <label for="date">Date:</label>
                <input type="text" id="date" name="date" class="date-input">
            </div>
            <div class="item">
                <label for="start-time">Start Time:</label>
                <input type="text" id="start-time" name="startTime" class="start-time-input">
            </div>
            <div class="item">
                <label for="end-time">End Time:</label>
                <input type="text" id="end-time" name="endTime" class="end-time-input">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="card mb-2">
                        <div class="card-body">
                            <span class="text-primary fs-4 fw-bold">Regular Participant:</span>
                            <span class="me-4 fs-9">€17.50 each</span>
                            <span class="text-primary fs-4 fw-bold">Family Ticket:</span>
                            <span class="fs-9">€60 each</span>
                            <small class="text-muted"> (max. 4 participants)</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
            <span class="input-group-btn">
                <button type="button" class="btn btn-default btn-number"  data-type="minus">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>
            </span>
                    <input type="number" class="form-control input-number" id="tourSingleTicket" name="tourSingleTicket" placeholder="Enter custom language" min="0" max="100" value="0">
                    <span class="input-group-btn">
                <button type="button" class="btn btn-default btn-number" data-type="plus">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </span>
                </div>

                <div class="col-md-11">
                    <div class="d-flex align-items-center mb-9">
                        <input type="checkbox" class="btn-check" name="tourFamilyTicket" id="btn-check-outlined" autocomplete="off">
                        <label class="btn btn-outline-danger" for="btn-check-outlined">Family Ticket</label><br>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary" name="addToPersonalProgram">Add to Personal Program<img src="/img/heartbutton.svg" width="20" height="20" alt=""></button>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-danger" onclick="cancelPopUp()">Close</button>
            </div>
        </div>
    </form>
</div>




<script>
    // Function to toggle pop-up visibility and populate form fields
    function togglePopUp(date, startTime, endTime, imagePath) {
        const popUp = document.getElementById("pop-up");
        popUp.style.display = (popUp.style.display === "none") ? "block" : "none";

        if (popUp.style.display === "block") {
            const popUpDate = popUp.querySelector('.date-input');
            const popUpStartTime = popUp.querySelector('.start-time-input');
            const popUpEndTime = popUp.querySelector('.end-time-input');

            // var popUpLanguageImage = popUp.querySelector('.language-image');

            //  popUpLanguageImage.src = imagePath; // Set the src attribute to display the image
            popUpDate.value = date; // Set the date input value
            popUpStartTime.value = formatTime(startTime); // Set the formatted start time input value
            popUpEndTime.value = formatTime(endTime); // Set the formatted end time input value
        }
    }

    // Function to format time as "HH:mm"
    function formatTime(timeString) {
        const timeComponents = timeString.split(':');
        const hours = parseInt(timeComponents[0]);
        let minutes = parseInt(timeComponents[1]);

        // Add leading zero if minutes is less than 10
        minutes = minutes < 10 ? '0' + minutes : minutes;

        return hours + ':' + minutes;
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        var ticket = document.getElementById('ticketform');

        // Add event listener to the "Add to Personal Program" button
        ticket.addEventListener('submit', function(event){
            event.preventDefault();

            const formData = new FormData(ticket);

            fetch('/ticket/addOrder', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error (`Error: ${response.status}`)
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('History Tour Reservation created successfully!');
                        // Clear the form or redirect the user
                        // reservationForm.reset();
                        // window.location.href = '/reservationSuccess'; // Redirect if needed
                    } else {
                        alert('Failed to create reservation: ' + data.message);
                    }
                })
                .catch((error) => {
                    alert('There was a problem with your reservation: ' + error.message);
                })
                .finally(() => {
                    // You might want to hide spinner here if you have one
                });
        });
    });


    function cancelPopUp() {
        const popUp = document.getElementById("pop-up");
        popUp.style.display = "none";

        // Reset all form fields
        const form = document.getElementById("ticketform");
        form.reset();
    }
</script>
