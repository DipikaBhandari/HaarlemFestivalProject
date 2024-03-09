<?php
use App\model\user;

if(isset($_SESSION['username'])) {
    include __DIR__ . '/afterlogin.php';
} else {
    session_start();

    // Include default header for non-logged-in users
}

if (!isset($user) || !$user instanceof user) {
    exit('User data is not available.');
}
if (!isset($restaurantArray) || !is_array($restaurantArray)) {
    echo "No restaurant details available.";
    exit;
}
?>

<div class="container mt-4">

    <br>
    <br>

    <!-- User Information Form -->
    <form id="restaurantInfoForm" action="/ManageYummy/updateRestaurant/<?php echo htmlspecialchars($restaurantArray['restaurantId']); ?>" method="post" enctype="multipart/form-data">
        <!-- Name -->
        <div class="mb-3">
            <label for="restaurantName">Restaurant Name:</label>
            <input type="text" class="form-control" id="restaurantName" name="restaurantName" value="<?php echo htmlspecialchars($restaurantArray['restaurantName']); ?>" required>
        </div>
        <!-- Number of Seats -->
        <div class="mb-3">
            <label for="numberOfSeats">Number of Seats:</label>
            <input type="number" class="form-control" id="numberOfSeats" name="numberOfSeats" value="<?= isset($restaurantDetails)? htmlspecialchars($restaurantDetails->getNumberOfSeats()) : '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" value="<?= isset($restaurantDetails)? htmlspecialchars($restaurantDetails->getLocation()) : '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= isset($restaurantDetails)? htmlspecialchars($restaurantDetails->getEmail()) : '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="kidPrice">Kid's Price:</label>
            <input type="text" class="form-control" id="kidPrice" name="kidPrice" value="<?php echo htmlspecialchars($restaurantDetails->getKidPrice()); ?>" required>
        </div>
        <div class="form-group">
            <label for="adultPrice">Adult's Price:</label>
            <input type="text" class="form-control"  id="adultPrice" name="adultPrice" value="<?php echo htmlspecialchars($restaurantDetails->getAdultPrice()); ?>" required>
        </div>


        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Restaurant</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>

        <div class="modal-footer">
            <button type="button" id="savePassword" class="btn btn-primary">Save</button>

        </div>
    </form>
</div>


<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const form = document.getElementById('restaurantInfoForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const jsonObject = {};

            for (const [key, value] of formData.entries()) {
                jsonObject[key] = value;
            }

            // Set up the fetch options
            fetch('/manageYummy/updateRestaurant', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(jsonObject),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data); // Handle the success response here
                    // If you want to do a redirect:
                    // window.location.href = '/path-to-redirect';
                })
                .catch((error) => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
        });
    });
</script>


<?php
include __DIR__ . '/footer.php';
?>
