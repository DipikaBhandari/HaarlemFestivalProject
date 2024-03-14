<?php if (!empty($section) && $section['type'] === 'header'): ?>
    <div class="container-fluid text-white py-5 my-0" style="background: url('/img/yummyHeaderBackground.png') no-repeat center center; background-size: cover;">
        <div class="row align-items-center" style="min-height: 42vh;">
            <div class="col-md-6">
                <h1 style="font-family: 'Aleo'; font-size: 96px; font-weight: 400; line-height: 90px; color: #FFD700; text-align: center; padding-left: 30px;" class="display-3"><?= htmlspecialchars($section['heading']); ?></h1>
                <div style="height: 50px; margin-top: 20px;">
                    <img src="../img/yummyHeaderLine.png" alt="yummy Header Line" width="546" height="156" style="padding-left: 200px; padding-top: 20px; padding-bottom: 100px;">
                </div>
                <div>
                    <?php foreach ($section['paragraphs'] as $paragraph): ?>
                        <p style="font-family: 'Aleo'; font-size: 20px; font-weight: 400; line-height: 45px; padding-left: 80px;" class="lead"><?= htmlspecialchars($paragraph['text']); ?></p>
                    <?php endforeach; ?>
                </div>
                <button id="reserveButton" class="btn btn-primary">Reserve Now</button>
            </div>
            <div class="col-md-6 d-none d-md-block">
                <?php foreach ($section['images'] as $images): ?>
                    <img src="<?= htmlspecialchars($images['imagePath']); ?>" alt="<?= htmlspecialchars($images['imageName']); ?>" style="width:  92vh; height:100%; max-height: 76.5vh; object-fit: cover; position: absolute; top: 120px; right: 0;">
                    <h2 style="font-family: 'Playfair Display'; font-size: 32px; font-weight: 700; position: absolute; top: 200px; left: 65%; transform: translateX(-50%);" class="fs-3 text-center"><?= htmlspecialchars($section['subTitle']); ?></h2>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Reservation Popup Trigger -->
    <button id="reserveButton" class="btn btn-primary">Reserve Now</button>

    <!-- Reservation Popup Modal -->
    <div id="reservationPopup" class="reservation-popup">
        <div class="reservation-content">
            <span id="closePopup" class="close">&times;</span>
            <h2>Reserve Your Table</h2>
            <!-- Reservation Form -->
            <form id="reservationForm">
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
        reservationForm.onsubmit = function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = {
                numAdults: document.getElementById('numAdults').value,
                numChildren: document.getElementById('numChildren').value,
                date: document.getElementById('date').value,
                session: document.getElementById('session').value,
                specialRequests: document.getElementById('specialRequests').value,
                // Add other form fields here
            };

            // Perform the fetch call to send the data to the server
            fetch('/CreateReservation/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData),
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
        }
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



