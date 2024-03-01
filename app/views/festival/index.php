<?php
//session_start(); // Start the session

// Check if the user is logged in
   if(isset($_SESSION['username'])) {
    include __DIR__ . '/../afterlogin.php'; // Include afterlogin.php for logged-in users
} else {
    include __DIR__ . '/../header.php'; // Include default header for non-logged-in users
    }
   ?>


<?php
include __DIR__ . '/../footer.php';
?>



