<div class="container introduction col-10">
    <?php if (!empty($section['heading'])): ?>

        <?php echo $section['heading'];
        if (!empty($section['images'])):
            foreach ($section['images'] as $image): ?>
                <img src="<?php echo $image['imagePath']; ?>" alt="<?php echo $image['imageName']; ?>">
            <?php endforeach;
            endif; ?>
    <?php endif; ?>

    <?php if (!empty($section['paragraphs'])): ?>
        <?php foreach ($section['paragraphs'] as $paragraph): ?>
            <?php echo $paragraph['text']; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($section['linkText'])): ?>
        <a id="readMoreLink" href="#"><?php echo $section['linkText']; ?></a>
    <?php endif; ?>
</div>