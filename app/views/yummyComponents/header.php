<?php if (!empty($section) && $section['type'] === 'header'): ?>
    <div class="container-fluid text-white py-5 my-0" style="background: url('/img/yummyHeaderBackground.png') no-repeat center center; background-size: cover;">
        <div class="row align-items-center" style="min-height: 50vh;">
            <div class="col-md-6">
                <h1 style="color: #FFD700; margin-bottom: -20px;" class="display-3 text-center"><?= htmlspecialchars($section['heading']); ?></h1>
                <div class="text-left" style="position: relative; height: 50px; margin-top: 20px;">
                    <img src="../img/yummyHeaderLine.png" alt="yummy Header Line" width="500" height="50" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                </div>
                <h2 style="position: relative; top: -10px; left: 50%; transform: translateX(-50%);" class="fs-3 text-center"><?= htmlspecialchars($section['subTitle']); ?></h2>
                <div class="text-left pl-md-1000">
                    <?php foreach ($section['paragraphs'] as $paragraph): ?>
                        <p style="padding-left: 80px; padding-top: 10px" class="lead"><?= htmlspecialchars($paragraph['text']); ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-6 d-none d-md-block">
                <!-- Future image -->
            </div>
        </div>
    </div>
<?php endif; ?>




