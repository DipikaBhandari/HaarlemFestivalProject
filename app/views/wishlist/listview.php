<?php
include __DIR__ . '/../header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <h1 style="text-align: center; color: rgba(88, 47, 14, 0.83);font-family: Aleo,serif;font-size: 50px;
">Your Personal Program</h1>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                initialDate: '2024-07-23',
            });

            // Assume you have retrieved events from the database and stored them in $events array
           <?php
// Assume you have retrieved events from the database and stored them in $events array
$events = [
    ['title' => 'Event 1', 'date' => '23 July', 'start' => '10:00:00', 'end' => '12:00:00'],
    ['title' => 'Event 2', 'date' => '25 July', 'start' => '16:00:00', 'end' => '19:00:00'],
    // Add more events as needed
];
            foreach ($events as &$event) {
                // Assuming the year is the current year, you may need to change this logic if the year is not available
                $year = date('Y');
                $event['date'] = date('Y-m-d', strtotime($event['date'] . " $year"));
            }
// Concatenate date with start and end times
foreach ($events as &$event) {
    $year = date('Y');
    $event['date'] = date('Y-m-d', strtotime($event['date'] . " $year"));
    $event['start'] = $event['date'] . ' ' . $event['start'];
    $event['end'] = $event['date'] . ' ' . $event['end'];
    // Remove the 'date' key since it's no longer needed
    unset($event['date']);
}

// Pass $events array to JavaScript
?>


            // Pass PHP events data to JavaScript
            const events = <?php echo json_encode($events); ?>;

            // Add each event to the calendar
            events.forEach(function(event) {
                calendar.addEvent(event);
            });

            calendar.render();

        });
    </script>
</head>
<body>
<div id='calendar'></div>
</body>
</html>

<section class="home-section">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title text-center">Book your tour</h2>
                <?php if (!empty($errorMessage)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php endif; ?>
                <!--                <h3 class="panel-title text-center">dd</h3>-->
            </div>
            <div class="panel-body">
                <form method="POST">
                    <div id="address">
                        <div class="row justify-content-center mb-5">
                            <label class="control-label">Tour Date</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="tour-date" name="tourTicketDate"
                                           readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-5">
                            <label class="control-label">Tour Time</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="time" class="form-control" id="tour-time" name="tourTicketTime"
                                           readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-5">
                            <label class="control-label">Tour Language</label>
                            <div class="col-md-6">
                                <input type="hidden" id="language" name="TourLanguage" value="" />
                                <div id="languageButtonsContainer" class="d-flex justify-content-between">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-5">
                            <label class="control-label">Single Ticket</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-number" disabled="disabled"
                                                data-type="minus">
                                            <span class="glyphicon glyphicon-minus"></span>
                                        </button>
                                    </span>
                                    <input type="number" class="form-control input-number" id="tourSingleTicket"
                                           name="tourSingleTicket" placeholder="Enter custom language" min="0" max="100"
                                           value="0">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-number" data-type="plus">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-5">
                            <label class="control-label">Buy Family Ticket</label>
                            <div class="col-md-6">
                                <div>
                                    <input type="checkbox" class="btn-check" name="tourFamilyTicket" id="btn-check-outlined" autocomplete="off">
                                    <label class="btn btn-outline-danger" for="btn-check-outlined">Family Ticket</label><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-warning mt-3" name="addNewHistoryTour"
                                style="background-color: rgba(205, 53, 0, 1);">
                            <span style="color: #fff;">Cancel</span>
                        </button>
                        <button type="submit" class="btn btn-warning mt-3" name="addTourToCart"
                                style="background-color: rgba(205, 53, 0, 1);">
                            <span style="color: #fff;">Add to cart</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<!-- CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
<script src="/Javascripts/festival/History/TicketModalTour.js" type="text/javascript"></script>



<!--<script>-->
<!--    const bookingInfo = JSON.parse(localStorage.getItem('bookingInfo'));-->
<!--    const tourLanguages = bookingInfo.tourLanguages;-->
<!--    const tourTime = bookingInfo.tourTime;-->
<!--    const tourDate = bookingInfo.tourDate;-->
<!--    const buttonContainer = document.getElementById('languageButtonsContainer');-->
<!---->
<!--    document.querySelector('.panel-title.text-center:first-of-type').textContent = `Book your tour for ${tourDate} at ${tourTime}`;-->
<!---->
<!--    const languagesArray = tourLanguages.split('<br>');-->
<!---->
<!--    for (let i = 0; i < languagesArray.length; i++) {-->
<!--        const language = languagesArray[i].trim(); // trim to remove any white space-->
<!--        const button = document.createElement('button');-->
<!--        button.type = 'button';-->
<!--        button.name = 'TourLanguage';-->
<!--        button.value = language.toLowerCase();-->
<!--        button.textContent = language;-->
<!--        button.className = 'btn btn-outline-dark';-->
<!--        buttonContainer.appendChild(button);-->
<!--        button.onclick = function () {-->
<!--            document.getElementById("language").value = language.toLowerCase();-->
<!--        }-->
<!--    }-->
<!---->
<!--    document.getElementById('tour-date').value = tourDate;-->
<!--    document.getElementById('tour-time').value = tourTime;-->
<!---->
<!--    // Display date and time-->
<!--    document.getElementById('tour-date-display').textContent = tourDate;-->
<!--    document.getElementById('tour-time-display').textContent = tourTime;-->
<!--</script>-->








