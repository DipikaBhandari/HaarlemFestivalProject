<div class="header position-relative">
    <div class="row">
        <?php foreach ($section['images'] as $image): ?>
            <div class="cropped-image-container">
                <div class="cropped-image">
                    <img class="img-fluid" src="<?php echo $image['imagePath']; ?>" alt="<?php echo $image['imageName']; ?>">
                </div>

                <?php if(!empty($section['heading']) || !empty($section['subTitle'])): ?>
                    <div class="overlay-text position-absolute bottom-0 start-0 p-3 text-white">
                        <?php if(!empty($section['heading'])): ?>
                            <h1><?php echo($section['heading']); ?></h1>
                        <?php endif; ?>

                        <?php if(!empty($section['subTitle'])): ?>
                            <h2><?php echo($section['subTitle']); ?></h2>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<style>
    .cropped-image-container {
        display: flex;
        justify-content: center;
        align-items: flex-end; /* Align image to the bottom */
        height: 80vh; /* Set the height to cover 60% of the screen height */
        width: 100%; /* Ensure full width */
        overflow: hidden; /* Hide any overflowing content */
    }

    .cropped-image {
        width: 100%; /* Ensure the image covers the entire container width */
        height: auto; /* Allow the height to adjust proportionally */
        object-fit: contain; /* Maintain aspect ratio without cropping or stretching */
        object-position: center bottom; /* Center the image horizontally and align it to the bottom */
    }

.overlay-text{
    margin: 80px;
    font-family: serif;
}

</style>