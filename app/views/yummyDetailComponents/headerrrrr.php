<?php if (!empty($section) && $section['type'] === 'headerrrrr'): ?>
    <div class="container-fluid text-white py-5 my-0" style="background: url('/img/yummyHeaderBackground.png') no-repeat center center; background-size: cover;">
        <div class="row align-items-center" style="min-height: 50vh;">
            <div class="col-md-6 text-left">
                <!-- Placeholder for the logo -->
                <h1 style="padding-left: 240px; padding-bottom: 5px; margin: auto;" class="display-3"><?= htmlspecialchars($section['restaurantName']); ?></h1>
                <!-- Placeholder for the line under the restaurant name -->
                <div style="padding-left: 78px; height: 6px; background-color: white; width: 25%; margin: auto;"></div>
                <div style="padding-left: 35px; padding-top: 30px;">
                    <?php foreach ($section['paragraphs'] as $paragraph): ?>
                        <p style="font-size: 24px;
                        padding-top: 35px;font-family: 'Aleo', serif;font-weight: 400;line-height: 35px;margin-bottom: 2rem;padding-left: 2rem;"><?= htmlspecialchars($paragraph['text']); ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-center position-relative">
                <!-- Placeholder or real image -->
                <div class="image-opening-hours-container" style="position: absolute; top: -300px; right: 50px;">
                    <?php foreach ($section['image'] as $images): ?>
                        <img class="header-image img-fluid" src="<?php echo $images['imagePath']; ?>" alt="<?php echo $images['imageName']; ?>" style="width: 490px; ">
                    <?php endforeach; ?>
                </div>
                <div class="opening-hours-container" style="
                width: 430px;
                height: 200px;
                padding: 20px 0px;
                border-radius: 25px;
                background-color: white;
                color: black;
                font-family: 'Roboto Slab', serif;
                position: absolute;
                top: 250px;
                right: 30px;
                display: flex;
                flex-direction: column;
                gap: 10px;
                align-items: center;
                justify-content: center;">
                    <h2 style="margin: 0; font-size: 25px; font-weight: 700; line-height: 33px; text-align: center;">Opening hours</h2>
                    <?php
                    // Group opening times into sessions
                    $sessions = [
                        1 => [],
                        2 => [],
                        3 => []
                    ];

                    foreach ($section['OpeningTime'] as $OpeningTime) {
                        $sessionId = ($OpeningTime['OpeningTimeId'] - 1) % 3 + 1;
                        $sessions[$sessionId][] = $OpeningTime['openingTime'];
                    }

                    // Display each session
                    $sessionNames = ['First session', 'Second session', 'Third session'];
                    foreach ($sessions as $sessionId => $times) {
                        echo '<div class="session" style="
                        background-color: #205e71;
                        border-radius: 25px;
                        width: 376px;
                        height: 38px;
                        padding: 10px 22px;
                        margin-bottom: 10px;
                        text-align: center;
                        color: white;">
                        <strong>' . $sessionNames[$sessionId - 1] . '</strong> ' . htmlspecialchars(implode(' | ', $times)) . '
                    </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
