<?php if (!empty($section) && $section['type'] === 'header'): ?>
    <div class="header-section">
        <div class="container-fluid p-0">
            <div class="row no-gutters">
                <div class="col-md-8 text-container">
                    <div class="header-content">
                        <div class="event-dates">
                            <span><?php echo $section['subTitle']; ?></span>
                        </div>
                        <div class="header-title">
                             <h1><?php echo $section['heading']; ?></h1>
                        </div>
                        <div class="header-paragraphs">
                            <?php foreach ($section['paragraphs'] as $paragraph): ?>
                                <p class="header-paragraph"><?php echo $paragraph['text']; ?></p>
                            <?php endforeach; ?>
                        </div>
                        <?php if (!empty($section['linkText'])): ?>
                            <button id="reserveButton" class="btn btn-primary"><?php echo($section['linkText']); ?></button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4 image-container">
                    <?php foreach ($section['images'] as $images): ?>
                        <img class="header-image img-fluid" src="<?php echo $images['imagePath']; ?>" alt="<?php echo $images['imageName']; ?>">
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<style>
    .header-section {
    background: url('/img/yummyHeaderBackground.png') no-repeat center center / cover;
    color: #fff;
    font-family: 'Aleo', serif;
    position: relative;
    display: flex; /* Added to use flexbox for layout */
    }

    .text-container {
    padding: 4rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    flex-grow: 1; /* Added to allow container to grow */
    }

    .event-dates {
    color: white;
    font-size: 32px;
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    position: absolute;
    right: 20%; /* Adjusted to accommodate different screen sizes */
    top: 2rem; /* Adjusted to better match the provided design */
    z-index: 2; /* Make sure it's above the image */
    }

    .header-title h1 {
    color: #FFD700;
    font-size: 80px;
    font-weight: 200;
    line-height: 90px;
    margin-bottom: 1rem;
    }

    .header-paragraphs {
    max-width: 700px; /* Adjust the width as per the design */
    }

    .header-paragraph {
    font-size: 24px;
    font-family: 'Aleo', serif;
    font-weight: 400;
    line-height: 45px;
    margin-bottom: 2rem;
    }

    .btn-primary {
        background-image: linear-gradient(120deg, #00b09b 40%, #55968f 60%);
    border: none;
    font-size: 24px;
    padding: 0.5rem 1rem;
    }

    .image-container {
    position: relative;
    flex-basis: 400px; /* Fixed basis for the image */
    flex-shrink: 0; /* Prevent shrinking */
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    }

    .header-image {
    height: auto;
    max-width: 100%;
    max-height: 100vh; /* Set max height to be viewport height */
    object-fit: contain; /* Maintain aspect ratio */
        object-position: center;
    }

    @media (max-width: 1200px) {
    .event-dates {
    right: 10%; /* Adjust position for medium screens */
    }
    }

    @media (max-width: 991px) {
    .header-section {
    flex-direction: column;
    }

    .text-container, .image-container {
    padding: 1rem;
    width: 100%; /* Full width */
    box-sizing: border-box; /* Adjust box model for padding */
    align-items: center;
    text-align: center;
    }

    .event-dates {
    position: relative;
    right: auto;
    top: auto;
    order: -1; /* Move it above the title */
    }

    .btn-primary {
    position: relative;
    margin: 1rem auto;
    left: auto;
    bottom: auto;
    }

    }
</style>

    <!-- Reservation Popup Modal -->
    <div id="reservationPopup" class="reservation-popup">
        <div class="reservation-content">
              <span id="closePopup" class="close"> &times; </span>
            <div class="form-header">
                <h1>Reserve Your Table</h1>
            </div>
            <!-- Reservation Form -->
            <form id="reservationForm" class="reservation-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="restaurant">Choose a restaurant:</label>
                        <select id="restaurant" name="restaurant" required>
                            <!-- Assuming you will populate this list server-side -->
                            <?php foreach ($restaurantName as $restaurant): ?>
                                <option value="<?= htmlspecialchars($restaurant['restaurantId']); ?>"><?= htmlspecialchars($restaurant['restaurantName']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="numAdults">Number of Adults:</label>
                        <input type="number" id="numAdults" name="numAdults" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="numChildren">Number of Children:</label>
                        <input type="number" id="numChildren" name="numChildren" min="0" required>
                    </div>
                    <div class="form-group inlined">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="session">Time:</label>

                            <select id="session" name="session" required>
                            <option value="session1">17:00 - 19:00</option>
                            <option value="session2">19:00 - 21:00</option>
                            <option value="session3">21:00 - 23:00</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="specialRequests">Special Requests:</label>
                        <textarea id="specialRequests" name="specialRequests"></textarea>
                    </div>
                <button class="book" type="submit" value="Submit Reservation">Submit Reservation
                </button>
            </form>
        </div>
    </div>
    <style>
        .reservation-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }
       .reservation-content{
           background: url('/img/yummyHeaderBackground.png') no-repeat center center / cover;
           position: relative;
           max-width: 642px;
           width: 100%;
           margin: auto;
           padding: 40px;
           overflow: hidden;
           background-size: cover;
           border-radius: 5px;
           z-index: 20;
       }
       .reservation-content::before{
           content: '';
           position: absolute;
           left: 0;
           right: 0;
           bottom: 0;
           top: 0;
           background: rgb(0,0,0,0.7);
           z-index: -1;
       }
       .reservation-content .form-header{
           text-align: center;
           position: relative;
           margin-bottom: 30px;
       }
       .reservation-content .form-header h1{
           font-weight:700;
           text-transform: capitalize;
           font-size: 42px;
           color: #fff;
           margin: 0px;
       }
       .form-group{
           margin: 20px 0;
       }
       .form-group.inlined{
            width: 49%;
           display: inline-block;
           float: left;
           margin-left: 1%;
       }
       label{
           color: #fff;
           display: block;
           padding-bottom: 10px;
           font-family: 'Nova Round', cursive;
           font-size: 1.25em;

       }
       input,select,textarea{
           width: 100%;
           padding: 15px;
           border-radius: 25px;
           box-sizing: border-box;
           border:2px solid #777;
           font-size: 1.25em;
           font-family: 'Nova Round', cursive;

       }
       .form-group.inlined input{
           width: 95%;
           display: inline-block;
       }
       textarea{
           height: 200px;
       }
       hr{
           border: 1px dashed #ccc;
       }
       .book{
           width:200px;
           height:50px;
           color: #fff;
           background-image: linear-gradient(120deg, #00b09b 40%, #55968f 60%);
           border: none;
           font-size: 1.25em;
           font-family: 'Nova Round', cursive;
           border-radius: 4px;
           cursor: pointer;
       }
       .book:hover{
           border: 2px solid black;
       }
       .close{
           position: absolute;
           right: 34px;
           top: 32px;
           background-image: linear-gradient(120deg, #00b09b 40%, #55968f 60%);

       }
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

        reserveButton.onclick = function() {
            reservationPopup.style.display = 'block';
        }
        closePopup.onclick = function() {
            reservationPopup.style.display = 'none';
        }
        // Close the popup if user clicks outside of it
        window.onclick = function(event) {
            if (event.target == reservationPopup) {
                reservationPopup.style.display = 'none';
            }
        }
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
                    //  hide spinner here
                });
        })
    });
</script>

<style>
    /* The Modal (background) */
    .reservation-popup {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }

</style>



