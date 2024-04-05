<?php

if(!isset($_SESSION)){
    session_start();
}

if(isset($_SESSION['username'])) {
    include __DIR__ . '/../afterlogin.php'; // Include afterlogin.php for logged-in users
} else {
    include __DIR__ . '/../header.php'; // Include default header for non-logged-in users
}
?>
    <head>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <title>Strolling Through History</title>
    </head>
    <div>
        <?php
        foreach ($sections as $section) {
            if ($section['type'] === 'header') {
                include __DIR__ . '/../historyComponents/' . $section['type'] . '.php';
            }
        }
        ?>
    </div>
    <div class="row">
        <div class="col">
            <?php
            foreach ($sections as $section) {
                if ($section['type'] === 'subsection' || $section['type'] === 'introduction') {
                    include __DIR__ . '/../historyComponents/' . $section['type'] . '.php';
                }
            }
            ?>
        </div>
    </div>

<div class="shape"
     style="margin-top: 0; float: right; font-family: Aleo,serif; font-size: 64px; font-style: normal; font-weight: 800;
     width: 25%; height: 80px; background-color: #006D77; border: 1px solid black; color: white; text-align: center; border-radius: 0;">
    <h1>Before We Begin</h1>
</div>

    <div>
        <?php
        foreach ($sections as $section) {
            if ($section['type'] === 'list') {
                include __DIR__ . '/../historyComponents/' . $section['type'] . '.php';
            }
        }
        ?>
    </div>

<div>
    <div>
        <?php
        foreach ($sections as $section) {
            if ($section['type'] === 'timetable') {
                include __DIR__ . '/../historyComponents/' . $section['type'] . '.php';
            }
        }
        ?>
    </div>

<div>
    <?php
        foreach ($sections as $section) {
            if ($section['type'] === 'marketing') {
                include __DIR__ . '/../historyComponents/' . $section['type'] . '.php';
            }
        }
        ?>
</div>


<?php
include __DIR__ . '/../footer.php';
?>


