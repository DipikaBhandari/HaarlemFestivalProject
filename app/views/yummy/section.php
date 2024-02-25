<?php if (!empty($section['heading'])): ?>
    <h1><?= htmlspecialchars($section['heading']); ?></h1>
<?php endif; ?>

<?php if (!empty($section['subTitle'])): ?>
    <h2><?= htmlspecialchars($section['subTitle']); ?></h2>
<?php endif; ?>

<?php foreach ($section['images'] as $image): ?>
    <img src="<?= htmlspecialchars($image['imagePath']); ?>" alt="<?= htmlspecialchars($image['imageName']); ?>" />
<?php endforeach; ?>

<?php foreach ($section['paragraphs'] as $paragraph): ?>
    <p><?= htmlspecialchars($paragraph['text']); ?></p>
<?php endforeach; ?>
