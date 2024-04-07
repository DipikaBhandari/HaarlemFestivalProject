<div id="photo-col" class="container col-4">
    <div class="row">
        <?php if(!empty($section['images'])):
        foreach ($section['images'] as $image): ?>
            <div class="col-6">
                <img src="<?php echo $image['imagePath']; ?>" alt="<?php echo $image['imageName']; ?>">
            </div>
        <?php endforeach;
        endif; ?>
    </div>
</div>
