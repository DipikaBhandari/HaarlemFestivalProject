<?php if (!empty($section) && $section['type'] === 'header'): ?>
    <div class="container-fluid text-white py-5 my-0" style="background: url('/img/yummyHeaderBackground.png') no-repeat center center; background-size: cover;">
        <div class="row align-items-center" style="min-height: 42vh;">
            <div class="col-md-6">
                <h1 class="display-3"><?= $section['heading']; ?></h1>
                <div style="height: 50px; margin-top: 20px;">
                    <img src="../img/yummyHeaderLine.png" alt="yummy Header Line" width="546" height="156" style="padding-left: 200px; padding-top: 20px; padding-bottom: 100px;">
                </div>
                <div>
                    <?php foreach ($section['paragraphs'] as $paragraph): ?>
                        <p style="font-family: 'Aleo'; font-size: 20px; font-weight: 400; line-height: 45px; padding-left: 80px;" class="lead"><?= htmlspecialchars($paragraph['text']); ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-6 d-none d-md-block">
                <?php foreach ($section['images'] as $images): ?>
                    <img src="<?= htmlspecialchars($images['imagePath']); ?>" alt="<?= htmlspecialchars($images['imageName']); ?>" style="width:  92vh; height:100%; max-height: 76.5vh; object-fit: cover; position: absolute; top: 120px; right: 0;">
                    <h2 style="font-family: 'Playfair Display'; font-size: 32px; font-weight: 700; position: absolute; top: 200px; left: 65%; transform: translateX(-50%);" class="fs-3 text-center"><?= htmlspecialchars($section['subTitle']); ?></h2>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<style>
    h1{
        font-family: 'Aleo'; font-size: 96px; font-weight: 400; line-height: 90px; color: #FFD700; text-align: center; padding-left: 30px;
    }
</style>






