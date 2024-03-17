<!-- Assuming $sections is an array containing all sections -->
<?php if (!empty($sections)): ?>
    <br>
    <br>
    <div class="container mt-4">
        <div class="row">
            <?php foreach ($sections as $section): ?>
                <?php if ($section['type'] === 'marketing' && $section['sectionId'] == 17): ?>
                    <!-- Column for the paragraph with orange background and specific height -->
                    <div class="col-md-4" style="background-color: #F18F01; height: 592px; display: flex; align-items: center; justify-content: center; border-radius: 10px 0 0 10px;">
                        <?php if (!empty($section['paragraphs'])): ?>
                            <div style="font-family: 'Aleo', serif; padding: 10px;  font-size: 50px; font-weight: 400; line-height: 77px; text-align: left; color: white;">
                                <?php foreach ($section['paragraphs'] as $paragraph): ?>
                                    <p><?= ($paragraph['text']); ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Column for the heading with specific styles -->
                    <div class="col-md-8" style="padding: 0; background-color: #2E294E; border-radius: 0 10px 10px 0;">
                        <div style="height: 96px; display: flex; align-items: center; justify-content: center;">
                            <?php if (!empty($section['heading'])): ?>
                                <h2 style="font-family: 'Architects Daughter', cursive; font-size: 64px; font-weight: 400; line-height: 88.94px; color: white; margin: 0;"><?= htmlspecialchars($section['heading']); ?></h2>
                            <?php endif; ?>
                        </div>
                        <!-- Image with specific styles -->
                        <?php if (!empty($section['images'])): ?>
                            <img src="<?= htmlspecialchars($section['images'][0]['imagePath']); ?>" alt="Marketing Image" class="img-fluid" style="width: 1221px; height: 496px; border-radius: 0 0 10px 20px;">
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <br>
    <br>
<?php endif; ?>
