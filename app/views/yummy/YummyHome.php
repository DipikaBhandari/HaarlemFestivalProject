<?php if(isset($_SESSION['username'])) {
    include __DIR__ . '/../afterlogin.php'; // Include afterlogin.php for logged-in users
} else {
    include __DIR__ . '/../header.php'; // Include default header for non-logged-in users
}

 foreach ($sections as $section): ?>
        <div class="section">
            <?php include __DIR__ . '/../yummyComponents/' . $section['type'] . '.php'; ?>
        </div>
    <?php endforeach; ?>

<?php include __DIR__ . '/../footer.php'; ?>
