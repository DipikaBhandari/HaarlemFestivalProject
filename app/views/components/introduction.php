<div class="container introduction">
    <?php if (!empty($section['heading'])): ?>
        <h1>
            <?php echo $section['heading']; ?>
            <?php foreach ($section['images'] as $image): ?>
                <img src="<?php echo $image['imagePath']; ?>" alt="<?php echo $image['imageName']; ?>">
            <?php endforeach; ?>
        </h1>
    <?php endif; ?>

    <?php if (!empty($section['paragraphs'])): ?>
        <?php foreach ($section['paragraphs'] as $paragraph): ?>
            <p><?php echo $paragraph['text']; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($section['linkText'])): ?>
        <a><?php echo $section['linkText']; ?></a>
    <?php endif; ?>
</div>