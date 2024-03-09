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

<?php
include __DIR__ . '/footer.php';
?>
