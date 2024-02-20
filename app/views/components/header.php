<div class="container header">
    <?php if(!empty($section['heading'])): ?>
        <h1><?php echo($section['heading']); ?></h1>
    <?php endif; ?>

    <?php if(!empty($section['subTitle'])): ?>
        <h2><?php echo($section['subTitle']); ?></h2>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($section['images'] as $image): ?>
            <div class="col-md-4 g-0">
                <img class="img-fluid" src="<?php echo $image['imagePath']; ?> " alt="<?php echo $image['imageName']; ?>">
            </div>
        <?php endforeach; ?>
    </div>
</div>
