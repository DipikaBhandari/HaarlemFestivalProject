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
    <h2 class="text-center">Restaurant List</h2>
    <br>
    <div class="restaurant-grid">
        <!-- New restaurant button -->
        <div class="restaurant-tile add-new">
            <a href="/CreateRestaurant/createRestaurant" class="restaurant-tile-content add-new-content">
                <i class="fas fa-plus"></i>
                <h3>Create New Restaurant</h3>
            </a>
        </div>
        <?php foreach ($restaurants as $index => $restaurant): ?>
        <a href="/ManageYummy/manageRestaurant/<?php echo $restaurant['restaurantSectionId']; ?>" class="restaurant-tile-link">
            <!-- Assign a "featured" class to every third tile for a different color -->
            <div class="restaurant-tile<?php echo ($index + 1) % 3 == 0 ? ' featured' : ''; ?>">
                <div class="restaurant-tile-number"><?php echo $index + 1; ?></div>
                <div class="restaurant-tile-content">
                    <h3><?php echo $restaurant['restaurantName']; ?></h3>
                    <p>No. of Seats: <?php echo $restaurant['numberOfSeats'];?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
    }

    .restaurant-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        gap: 10px;
    }

    .restaurant-tile {
        background-color: #1abc9c;
        color: white;
        width: 150px;
        height: 150px;
        margin: 10px;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
    }

    .restaurant-tile.featured {
        background-color: #e74c3c;
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

    /* Responsive design adjustments */
    @media (max-width: 768px) {
        .restaurant-grid {
            justify-content: center;
        }
    }

</style>
<?php
include __DIR__ . '/footer.php';
?>

