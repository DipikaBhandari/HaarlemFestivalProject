<div class="item" style="margin-left: 20px; margin-top: 15px; border-radius: 0 50px; background-color: #582F0E; width: 99%; height: 240px;">
    <?php if (!empty($section['paragraphs'])): ?>
        <?php foreach ($section['paragraphs'] as $paragraph): ?>
            <li style="margin-top: 10px; margin-bottom: 0; margin-left: 100px; color: white; font-size: 22px;">
                <?php echo htmlspecialchars(strip_tags($paragraph['text'])); ?>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


