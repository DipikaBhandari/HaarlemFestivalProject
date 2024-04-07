<?php if (!empty($section) && $section['type'] === 'introductt'): ?>
    <div class="reservation-section">
        <a href="#" class="reserve-button">Reserve</a>
        <?php foreach ($section['paragraphs'] as $paragraph): ?>
            <p style="font-size: 24px;
            padding-top: 35px;font-family: 'Aleo', serif;font-weight: 400;line-height: 35px;margin-bottom: 2rem;padding-left: 2rem;"><?= htmlspecialchars($paragraph['text']); ?></p>
        <?php endforeach; ?>

    </div>
<?php endif; ?>
<style>
    .reservation-section {
        background: #f2f2f2; /* This is a light grey, adjust as needed */
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 30px; /* This adds space below the reservation section */
        text-align: left;
    }

    .reserve-button {
        background-color: rgba(217, 217, 217, 0); /* Black button, adjust as needed */
        color: #fff; /* White text, adjust as needed */
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        margin-top: 10px;
    }
</style>


