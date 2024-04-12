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

    <div id="spinner" class="spinner" style="display:none;"></div>

    <!-- User Information Form -->
    <form id="restaurantInfoForm" action="/ManageYummy/updateRestaurant/<?php echo htmlspecialchars($restaurantArray['restaurantId']); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="restaurantId" value="<?php echo htmlspecialchars($restaurantArray['restaurantId']); ?>">
        <input type="hidden" name="currentImagePath" value="<?php echo htmlentities($restaurantDetails->getPicture()); ?>">

        <!-- Current Image and Upload Input Grouped Together -->
        <div class="mb-3">
            <label for="restaurantImage">Restaurant Image:</label>
            <div class="image-upload-container">
                <!-- Image Preview Container -->
                <div class="image-preview mb-2">
                    <img id="currentImage" src="/img/<?php echo htmlentities($restaurantDetails->getPicture()); ?>" alt="Current Image" class="img-thumbnail" style="height: 200px;">
                </div>
                <!-- Upload Input with Label -->
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="restaurantImage" name="restaurantImage" onchange="previewImage(event)">
                    <label class="custom-file-label" for="restaurantImage">Choose file</label>
                </div>
            </div>
        </div>

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
        <div class="mb-3">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4"><?= isset($restaurantDetails) ? htmlspecialchars($restaurantDetails->getDescription()) : ''; ?></textarea>
        </div>

        <!-- Add Food Offerings -->
        <div class="mb-3">
            <label for="foodOfferings">Food Offerings:</label>
            <input type="text" class="form-control" id="foodOfferings" name="foodOfferings" value="<?= isset($restaurantDetails) ? htmlspecialchars($restaurantDetails->getFoodOfferings()) : ''; ?>">
        </div>




        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Restaurant</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>


    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const form = document.getElementById('restaurantInfoForm');
        const spinner = document.getElementById('spinner');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            spinner.style.display = 'block';
            const restaurantId = form.action.split('/').pop();
            const formData = new FormData(this);

            fetch(form.action, {
                method: 'POST',
                body: formData, // FormData will set the proper content type for file upload
            })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        setTimeout(() => {
                            spinner.style.display = 'none';
                            window.location.href = '/ManageYummy/manageYummy'; // Redirect
                        }, 3000); // 3000 milliseconds = 3 seconds
                    } else {
                        spinner.style.display = 'none';
                        console.error(data.message);
                        alert('Failed to update restaurant details: ' + data.message);
                    }
                })
                .catch((error) => {
                    spinner.style.display = 'none';
                    console.error('There has been a problem with your fetch operation:', error);
                });
        });
    });
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('currentImage');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

</script>
<style>
    .spinner {
        border: 5px solid #f3f3f3; /* Light grey */
        border-top: 5px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
        margin: auto;
        position: fixed; /* or absolute */
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    @keyframes spin {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }
</style>

<?php
include __DIR__ . '/footer.php';
?>
