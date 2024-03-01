<div class="container introduction">
    <div class="row align-items-center">
        <div class="col-md-2">
            <?php foreach ($section['images'] as $image): ?>
                <img src="<?php echo $image['imagePath']; ?>" alt="<?php echo $image['imageName']; ?>" class="img-fluid">
            <?php endforeach; ?>
        </div>
        <div class="col-md-10">
            <?php if (!empty($section['paragraphs'])): ?>
                <?php foreach ($section['paragraphs'] as $paragraph): ?>
                    <p style="font-size: 26px;"><?php echo $paragraph['text']; ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>


    












