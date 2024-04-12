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
?>
<div class="container">
    <br>
    <br>
    <h2 class="text-center">Restaurant List</h2>
    <br>
    <div class="restaurant-grid">
        <!-- Create New Restaurant button always first -->
        <div class="restaurant-tile add-new">
            <a href="/CreateRestaurant/createRestaurant" class="restaurant-tile-content add-new-content">
                <i class="fas fa-plus"></i>
                <h3>Create New Restaurant</h3>
            </a>
        </div>

        <!-- Existing restaurant tiles -->
        <?php foreach ($restaurants as $restaurant): ?>
            <div class="restaurant-tile">
                <a href="/ManageYummy/manageRestaurant/<?php echo $restaurant['restaurantId']; ?>" class="restaurant-tile-link">
                    <div class="restaurant-tile-content">
                        <h3><?php echo $restaurant['restaurantName']; ?></h3>
                        <p>No. of Seats: <?php echo $restaurant['numberOfSeats'];?></p>
                    </div>
                </a>
                <div class="delete-btn-container">
                    <button class="delete-btn" onclick="confirmDelete('<?php echo $restaurant['restaurantId']; ?>')">Delete</button>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
    }

    .restaurant-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        gap: 25px;
    }

    .restaurant-tile {
        background-color: #1abc9c;
        color: white;
        width: 150px;
        margin: 10px;
        position: relative;
        display: flex;
        flex-direction: column; /* Stack content and delete button vertically */
        justify-content: space-between; /* Space content at the top, button at the bottom */
        align-items: flex-start; /* Align items to the start (left) */
        border-radius: 10px;
        padding: 10px; /* Add padding around the content */
        height: auto;
    }
    .restaurant-tile-number {
        position: absolute;
        top: -10px;
        right: -10px;
        background-color: white;
        color: #333;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
    }

    .text-center {
        text-align: center;
    }
    .add-new {
        background-color: #fff;
        color: #333;
        border: 2px dashed #1abc9c;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
    .add-new-content {
        text-decoration: none;
        color: #333;
        text-align: center;
    }

    .add-new i {
        display: block;
        margin-bottom: 10px;
        font-size: 24px; /* Adjust size as needed */
    }

    /* You can remove the number for the new restaurant button */
    .add-new .restaurant-tile-number {
        display: none;
    }
    .restaurant-tile-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }


    .delete-btn-container {
        align-self: flex-start; /* Align the delete button container to the start (left) */
        width: 100%; /* Take the full width of the tile to center the button inside it */
        display: flex;
        justify-content: center; /* Center the button horizontally */
    }

    .delete-btn {
        margin: 10px 0; /* Add some margin at the top and bottom for spacing */
        padding: 5px 10px; /* Padding inside the button for better appearance */
        color: #fff;
        background-color: #e74c3c; /* Red color for the delete button */
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }


    /* Responsive design adjustments */
    @media (max-width: 768px) {
        .restaurant-grid {
            justify-content: center;
        }
    }

</style>

<script>
    function confirmDelete(restaurantId) {
        if(confirm("Are you sure you want to delete this restaurant?")) {
            fetch('/manageYummy/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({restaurantId: restaurantId}),
            })
                .then(response => response.json())
                .then(response => {
                    console.log(response.status); // Should log 200 for a successful POST request
                    return response.json();
                })
                .then(data => {
                    if(data.success) {
                        alert("Restaurant deleted successfully.");
                        window.location.reload();
                    } else {
                        alert("Failed to delete the restaurant.");
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
</script>


<?php
include __DIR__ . '/footer.php';
?>

