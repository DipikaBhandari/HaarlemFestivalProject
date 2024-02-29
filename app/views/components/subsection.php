<div class="container subsection col-10">
    <?php if (!empty($section['heading'])): ?>
        <h2><?php echo $section['heading']; ?></h2>
    <?php endif; ?>

    <?php if (!empty($section['paragraphs'])): ?>
        <?php foreach ($section['paragraphs'] as $paragraph): ?>
            <p><?php echo $paragraph['text']; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($section['linkText'])): ?>
        <a href="#" id="readLessLink"><?php echo $section['linkText']; ?></a>
    <?php endif; ?>
</div>