<!-- Assuming $sections is an array containing all sections -->
<?php if (!empty($sections)): ?>

    <div class="container" style="background-color: rgba(115,153,157,0.2); width: 90%; padding: 30px 30px; border-radius: 10px;">
        <div class="row" style="align-items: center; justify-content: center;">
            <?php foreach ($sections as $section): ?>
                <?php if ($section['type'] === 'marketing' && $section['sectionId'] == 23): ?>
                    <!-- Column for the paragraph with orange background and specific height -->
                    <div class="col-md-4"
                         <button style="border: none; background-color: #F18F01; height: 592px; display: flex; align-items: center; justify-content: center; border-radius: 10px 0 0 10px; transition: background-color 0.3s;">
                        <?php if (!empty($section['paragraphs'])): ?>
                            <div style="font-family: 'Aleo', serif; padding: 10px;  font-size: 60px; font-weight: 400; line-height: 77px; text-align: left; color: white;">
                                <?php foreach ($section['paragraphs'] as $paragraph): ?>
                                    <p><?php echo $paragraph['text']; ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                         </button>
                    </div>

                    <!-- Column for the heading with specific styles -->
                    <div class="col-md-7" >
                        <button style=" border: none; padding: 0; background-color: #2E294E; border-radius: 0 10px 10px 0;">
                        <div style="height: 96px; display: flex; align-items: center; justify-content: center; transition: background-color 0.1s;">
                            <?php if (!empty($section['heading'])): ?>
                                <h2 style="font-family: 'Architects Daughter', cursive; font-size: 66px; font-weight: 400; line-height: 89px; color: white; margin: 0;"><?php echo $section['heading']; ?></h2>
                            <?php endif; ?>
                        </div>
                        <!-- Image with specific styles -->
                        <?php if (!empty($section['images'])): ?>
                            <?php foreach ($section['images'] as $image): ?>
                                <img src="<?php echo $image['imagePath']; ?>" alt="Marketing Image" class="img-fluid" style="width: 1221px; height: 496px; border-radius: 0 0 10px 0;">
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </button>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
    </div>
<?php endif; ?>






