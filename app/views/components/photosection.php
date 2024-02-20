<div class="container">
    <?php foreach ($section['images'] as $image): ?>
        <img src="<?php echo $image['imagePath']; ?> " alt="<?php echo $image['imageName']; ?>">
    <?php endforeach; ?>
</div>
