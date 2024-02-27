<?php include __DIR__ . '/../header.php';
    foreach ($sections as $section): ?>
    <div class="section">
        <?php include __DIR__ . '/../yummyDetailComponents/' . $section['type'] . '.php'; ?>
    </div>
<?php endforeach; ?>
<?php include __DIR__ . '/../footer.php'; ?>


