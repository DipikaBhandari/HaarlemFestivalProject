<?php
use App\model\user;

if(isset($_SESSION['username'])) {
    include __DIR__ . '/afterlogin.php'; // Include afterlogin.php for logged-in users
} else {
    session_start();

    // Include default header for non-logged-in users
}

if (!isset($user) || !$user instanceof user) {
    exit('User data is not available.');
}
?>

<div class="container mt-4">
    <h2>Create New Restaurant</h2>
    <div id="spinner" class="spinner"></div>
    <form id="createRestaurantForm">

        <div class="form-group">
            <label for="restaurantImage">Restaurant Image:</label>
            <input type="file" class="form-control" id="restaurantImage" name="restaurantImage">
        </div>

        <div class="form-group">
            <label for="restaurantName">Restaurant Name:</label>
            <input type="text" class="form-control" id="restaurantName" name="restaurantName" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="numberOfSeats">Number of Seats:</label>
            <input type="number" class="form-control" id="numberOfSeats" name="numberOfSeats"  required>
        </div>
        <div class="form-group">
            <label for="kidPrice">Kid's Price:</label>
            <input type="text" class="form-control" id="kidPrice" name="kidPrice"  required>
        </div>
        <div class="form-group">
            <label for="adultPrice">Adult's Price:</label>
            <input type="text" class="form-control"  id="adultPrice" name="adultPrice" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="foodOfferings">Food Offerings:</label>
            <input type="text" class="form-control" id="foodOfferings" name="foodOfferings" required>
        </div>


        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Restaurant</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createRestaurantForm = document.getElementById('createRestaurantForm');
        const spinner = document.getElementById('spinner');

        createRestaurantForm.addEventListener('submit', function(e) {
            e.preventDefault();

            spinner.style.display = 'block';

            const formData = new FormData(createRestaurantForm);
            formData.append('numberOfSeats', parseInt(formData.get('numberOfSeats')));
            formData.append('kidPrice', parseFloat(formData.get('kidPrice').replace('€', '')));
            formData.append('adultPrice', parseFloat(formData.get('adultPrice').replace('€', '')));


            fetch('/CreateRestaurant/create', {
                method: 'POST',
                //headers: { 'Content-Type': 'application/json' },
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Restaurant created successfully!');
                        //window.location.href = '/manageYummy/manageRestaurant';
                    } else {
                        alert('Failed to create new restaurant: ' + data.message);
                    }
                })
                .catch((error) => {
                    alert('There was a problem with your request: ' + error.message);
                })
                .finally(() => {
                    spinner.style.display = 'none';
                });
        });
    });
</script>

<?php
include __DIR__ . '/footer.php';
?>

<style>
    .spinner {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
        margin: auto;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none; /* Hidden by default */
    }
    @keyframes spin {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }
</style>
