<?php

if(isset($_SESSION['username'])) {
    include __DIR__ . '/afterlogin.php'; // Include afterlogin.php for logged-in users
} else {
    include __DIR__ . '/header.php'; // Include default header for non-logged-in users
}
?>
<head>
    <link rel="stylesheet" type="text/css" href="/css/homeStyle.css">
    </head>
<div>
    <?php

    foreach ($sections as $section) {
        if ($section['type'] === 'header') {
            include __DIR__ . '/components/' . $section['type'] . '.php';
        }
    }
    ?>
</div>
<div class="row">
    <div class="col-8">
        <?php
        foreach ($sections as $section) {
            if ($section['type'] === 'subsection' || $section['type'] === 'introduction') {
                include __DIR__ . '/components/' . $section['type'] . '.php';
            }
        }
        ?>
    </div>

    <div class="col-4">
        <?php
        foreach ($sections as $section) {
            if ($section['type'] === 'photosection') {
                include __DIR__ . '/components/' . $section['type'] . '.php';
                break;
            }
        }
        ?>
    </div>
</div>

<?php
include __DIR__ . '/footer.php';
?>

<script>
    if(document.getElementById('photo-col')){
        document.getElementById('photo-col').style.display = "block";
    }
</script>

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
</style>
