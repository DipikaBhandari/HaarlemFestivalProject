<div class="container subsection">
    <?php if (!empty($section['locations'])): ?>
        <?php foreach ($section['locations'] as $location): ?>
            <div class="button-col">
                <div class="buttons">
                    <li id="button" class="timetable-button"
                            style="width: 30px; height: 30px; border-radius: 50%; background-color: #006D77; color: white; margin: 10px; border: none; align-content: center;"><?php echo $location['location']; ?></li>
                </div>
            </div>
        <?php endforeach; ?>
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