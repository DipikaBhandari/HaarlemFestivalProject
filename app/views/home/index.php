<?php
session_start();

if(isset($_SESSION['username'])) {
    include __DIR__ . '/../afterlogin.php'; // Include afterlogin.php for logged-in users
} else {
    include __DIR__ . '/../header.php'; // Include default header for non-logged-in users
}
    ?>
<head>
    <link rel="stylesheet" type="text/css" href="/css/homeStyle.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<div>
    <?php
    foreach ($sections as $section) {
        if ($section['type'] === 'header') {
            include __DIR__ . '/../components/' . $section['type'] . '.php';
        }
    }
    ?>
</div>
    <div class="row">
        <div class="col-8">
            <?php
            foreach ($sections as $section) {
                if ($section['type'] === 'subsection' || $section['type'] === 'introduction') {
                    include __DIR__ . '/../components/' . $section['type'] . '.php';
                }
            }
            ?>
        </div>

        <div class="col-4">
            <?php
            include __DIR__ . '/../components/map.php';
            foreach ($sections as $section) {
                if ($section['type'] === 'photosection') {
                    include __DIR__ . '/../components/' . $section['type'] . '.php';
                    break;
                }
            }
            ?>
        </div>
    </div>
    <div>
        <?php
        foreach ($sections as $section) {
            if ($section['type'] === 'crossnavigation') {
                include __DIR__ . '/../components/' . $section['type'] . '.php';
            }
        }
        ?>
    </div>
    <script src="/javascript/home.js"></script>

<?php
    include __DIR__ . '/../footer.php';
?>