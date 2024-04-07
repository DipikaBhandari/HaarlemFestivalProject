<?php if (!empty($section) && $section['type'] === 'discriptio'): ?>
    <div class="details-section">
        <h3  style="width: 100%; color: black; padding-left: 35px; font-size: 40px; font-family: Aleo; font-weight: 700; line-height: 45px;"class="display-3 text-left"><?= htmlspecialchars($section['restaurantName']); ?></h3>
        <?php foreach ($section['paragraphs'] as $paragraph): ?>
            <p style="font-size: 24px; font-family: 'Aleo', serif;font-weight: 400; line-height: 35px;  padding-left: 2rem;"><?= htmlspecialchars($paragraph['text']); ?></p>
        <?php endforeach; ?>
        <div class="price-range">
            <br>
            <h5 style="width: 100%; color: black; font-size: 40px; font-family: Aleo; font-weight: 700; line-height: 45px;; ">Price Range</h5>
            <div class="price-detail"><?= htmlspecialchars($section['adultPrice']); ?></div>
            <div class="price-detail"><?= htmlspecialchars($section['kidPrice']); ?></div>
        </div>

    </div>
<?php endif; ?>
<style>
    .details-section {
        padding: 20px;
        margin: 30px; /* This adds space around the details section */
        border: 1px black solid; /* Black border, adjust as needed */
        border-radius: 5px;
        text-align: left;
        background: rgba(217, 217, 217, 0); /* White background, adjust as needed */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow, adjust as needed */
        box-sizing: border-box;
    }
    .price-detail {
        border: 1px black solid; /* Thin black border */
        display: table; /* Makes each price detail appear on a new line */
        padding: 10px; /* Space between content and border */
        margin-top: 10px; /* Space above the price detail */
        border-radius: 5px;
    }
    .price-range{
        padding-left: 35px;
    }
</style>
