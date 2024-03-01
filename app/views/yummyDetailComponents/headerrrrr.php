<?php if (!empty($section) && $section['type'] === 'headerrrrr'): ?>
        <div class="container-fluid text-white py-5 my-0" style="background: url('/img/yummyHeaderBackground.png') no-repeat center center; background-size: cover;">
            <div class="row align-items-center" style="min-height: 50vh;">
                <div class="col-md-6">
                    <h1 style="color: #FFD700; margin-bottom: -20px;" class="display-3 text-center"><?= htmlspecialchars($section['restaurantName']); ?></h1>

                    <div class="text-left" style="position: relative; height: 50px; margin-top: 20px;">
                        <img src="/img/yummyHeaderLine.png" alt="yummy Header Line" width="500" height="50" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    </div>
                    <div class="text-left pl-md-1000">
                        <?php foreach ($section['paragraphs'] as $paragraph): ?>
                            <p style="padding-left: 80px; padding-top: 10px" class="lead"><?= htmlspecialchars($paragraph['text']); ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="opening-hours-container" style="
    width: 430px;
    height: 224px;
    padding: 20px 0px;
    border-radius: 25px;
    background-color: white;
    color: black;
    font-family: 'Roboto Slab', serif;
    position: absolute;
    top: 610px;
    left: 1000px;
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
            height: 41px;
            padding: 10px 22px;
            margin-bottom: 10px;
            text-align: center;
            color: white;">
            <strong>' . $sessionNames[$sessionId - 1] . '</strong> ' . htmlspecialchars(implode(' | ', $times)) . '
            </div>';
                    }
                    ?>
                </div>
                <div class="col-md-6 d-none d-md-block">
                    <!-- Future image -->
                </div>
            </div>
        </div>
<?php endif; ?>


