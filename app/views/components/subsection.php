<div class="container subsection col-10">
    <?php if (!empty($section['heading'])): ?>
        <?php echo $section['heading']; ?>
    <?php endif; ?>

    <?php if (!empty($section['paragraphs'])): ?>
        <?php foreach ($section['paragraphs'] as $paragraph): ?>
            <?php echo $paragraph['text']; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($section['linkText'])): ?>
        <a href="#" id="readLessLink"><?php echo $section['linkText']; ?></a>
    <?php endif; ?>
</div>
