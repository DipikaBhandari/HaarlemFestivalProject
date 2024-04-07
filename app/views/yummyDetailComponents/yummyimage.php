<?php if (!empty($section) && $section['type'] === 'yummyimage'): ?>
<br>
    <div class="container-fluid text-white py-5 my-0" style="height: 500px; background: url('/img/yummyHeaderBackground.png') no-repeat center center; background-size: cover;">
    <h3  style="width: 100%; color: white; padding-left: 35px; font-size: 40px; font-family: Aleo; font-weight: 700; line-height: 45px;" class="display-3 text-center"><?= htmlspecialchars($section['restaurantName']); ?></h3>
        <div class="row text-center mt-5">
            <?php foreach ($section['image'] as $images): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <img style="width: 390px;" class="header-image img-fluid" src="<?php echo $images['imagePath']; ?>" alt="<?php echo $images['imageName']; ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php endif; ?>

<style>
    .container-fluid {
        /* ... other styles ... */
    }

    .container-fluid .row.no-gutters {
        margin-right: 0;
        margin-left: 0;
    }

    .container-fluid .row.no-gutters > [class^="col-"],
    .container-fluid .row.no-gutters > [class*=" col-"] {
        padding-right: 0;
        padding-left: 0;
    }

    .container-fluid .row > div {
        padding: 0; /* Remove padding from columns */
    }

    .container-fluid img {
        width: 100%; /* Each image takes full width of its column */
        height: auto; /* Keep image aspect ratio */
        display: block; /* Remove any inline spacing */
    }

    /* You can add media queries to ensure the images stack on smaller screens */
    @media (max-width: 768px) {
        .container-fluid .row > div {
            flex: 0 0 100%; /* Each column takes full width of the viewport on small screens */
            max-width: 100%; /* Prevents any exceeding of the viewport width */
        }
    }
</style>
