<?php if (!empty($section) && $section['type'] === 'header'): ?>
    <div class="header-section position-relative">
        <div class="container-fluid text-white">
            <div class="row align-items-center custom-height">
                <div class="col-md-6">
                    <div class="text-warning custom-heading">
                      <h1><?php echo $section['heading']; ?></h1>
                    </div>
                    <div class="yummy-header-line">
                        <img src="../img/yummyHeaderLine.png" alt="yummy Header Line" class="img-fluid">
                    </div>
                    <div class="paragraphs">
                        <?php foreach ($section['paragraphs'] as $paragraph): ?>
                            <p class="lead"><?php echo $paragraph['text']; ?></p>
                        <?php endforeach; ?>
                    </div>
                    <button id="reserveButton" class="btn btn-primary">Reserve Now</button>
                </div>
                <div class="col-md-6 d-none d-md-block">
                    <?php foreach ($section['images'] as $images): ?>
                        <div class="cropped-image-container">
                            <div class="cropped-image">
                                <img class="img-fluid" src="<?php echo $images['imagePath']; ?>" alt="<?php echo $images['imageName']; ?>">
                            </div>
                            <?php if (!empty($section['heading']) || !empty($section['subTitle'])): ?>
                                <div class="overlay-text position-absolute bottom-0 start-0 p-3 text-white">
                                    <?php if (!empty($section['subTitle'])): ?>
                                        <h2><?php echo $section['subTitle']; ?></h2>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <style>
        .header-section {
            background: url('/img/yummyHeaderBackground.png') no-repeat center center;
            background-size: cover;

        }

        .custom-height {
            min-height: 42vh;
        }

        .custom-heading h1 {
            width: 745px; height: 142.06px; text-align: center; color: #FFD700; font-size: 96px; font-family: Aleo; font-weight: 400; line-height: 90px; word-wrap: break-word
        }

        .yummy-header-line .img-fluid {
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        .paragraphs p {
            font-family: 'Aleo';
            font-size: 20px;
            font-weight: 400;
            line-height: 45px;
        }

        .cropped-image-container {
            background-size: cover;
        }

        .cropped-image {
            width: 1000px; height: 656px
        }

        .overlay-text {
            /* Additional styles if needed */
        }
    </style>




    <!-- Reservation Popup Trigger -->


    <!-- Reservation Popup Modal -->
    <div id="reservationPopup" class="reservation-popup">
        <div class="reservation-content">
            <span id="closePopup" class="close">&times;</span>
            <h2>Reserve Your Table</h2>
            <!-- Reservation Form -->
            <form id="reservationForm">

                <label for="restaurant">Choose a restaurant:</label>
                <select id="restaurant" name="restaurant" required>
                    <!-- Assuming you will populate this list server-side -->
                    <?php foreach ($restaurantName as $restaurant): ?>
                        <option value="<?= htmlspecialchars($restaurant['restaurantId']); ?>"><?= htmlspecialchars($restaurant['restaurantName']); ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="numAdults">Number of Adults:</label>
                <input type="number" id="numAdults" name="numAdults" min="1" required>

                <label for="numChildren">Number of Children:</label>
                <input type="number" id="numChildren" name="numChildren" min="0" required>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="session">Time:</label>
                <select id="session" name="session" required>
                    <option value="session1">17:00 - 19:00</option>
                    <option value="session2">19:00 - 21:00</option>
                    <option value="session3">21:00 - 23:00</option>
                </select>

                <label for="specialRequests">Special Requests:</label>
                <textarea id="specialRequests" name="specialRequests"></textarea>

                <input type="submit" value="Submit Reservation">
            </form>
        </div>
    </div>

<?php endif; ?>
<script>
    document.getElementById('restaurant').addEventListener('change', function() {
        var restaurantId = this.value;
        var sessionDropdown = document.getElementById('session');
        sessionDropdown.innerHTML = '';

        if(restaurantId) {
            fetch('/restaurant/getSessionsForRestaurant/' + restaurantId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(sessions => {
                    // Populate the session dropdown with new options
                    sessions.forEach(session => {
                        // Assuming session.startTime and session.endTime are in "HH:MM:SS" format
                        var startTime = new Date('1970-01-01T' + session.startTime + 'Z').toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                        var endTime = new Date('1970-01-01T' + session.endTime + 'Z').toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

                        var option = new Option(`${startTime} - ${endTime}`, session.sessionId);
                        sessionDropdown.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching sessions:', error);
                    alert('Error fetching session times for the selected restaurant.');
                });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var reserveButton = document.getElementById('reserveButton');
        var reservationPopup = document.getElementById('reservationPopup');
        var closePopup = document.getElementById('closePopup');
        var reservationForm = document.getElementById('reservationForm');

        // Display the popup
        reserveButton.onclick = function() {
            reservationPopup.style.display = 'block';
        }

        // Close the popup
        closePopup.onclick = function() {
            reservationPopup.style.display = 'none';
        }

        // Close the popup if user clicks outside of it
        window.onclick = function(event) {
            if (event.target == reservationPopup) {
                reservationPopup.style.display = 'none';
            }
        }

        // Handle form submission
        reservationForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            var formData= new FormData(reservationForm);
           /* const formData = {
                restaurant: document.getElementById('restaurant').value.trim(),
                numAdults: parseInt(document.getElementById('numAdults').value.trim(), 10),
                numChildren: parseInt(document.getElementById('numChildren').value.trim(), 10),
                date: document.getElementById('date').value.trim(),
                session: document.getElementById('session').value.trim(),
                specialRequests: document.getElementById('specialRequests').value.trim(),
            };*/

            // Perform the fetch call to send the data to the server
            fetch('/CreateReservation/create', {
                method: 'POST',
                body: formData,
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Reservation created successfully!');
                        reservationPopup.style.display = 'none';
                        // Clear the form or redirect the user
                        reservationForm.reset();
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

        })
    });
</script>

<style>
    /* The Modal (background) */
    .reservation-popup {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content/Box */
    .reservation-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
    }

    /* The Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

</style>



