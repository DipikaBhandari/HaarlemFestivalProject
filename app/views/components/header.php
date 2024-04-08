<div class="header">
    <div class="row">
        <?php
        if (!empty($section['images'])):
            $num_images = count($section['images']);
            switch ($num_images) {
                case 1:
                    $col_class = 'col-12';
                    break;
                case 2:
                    $col_class = 'col-6';
                    break;
                case 3:
                default:
                    $col_class = 'col-4';
                    break;
            }

            foreach ($section['images'] as $image):?>
                <div class="<?php echo $col_class; ?> g-0 header-img">
                    <img class="img-fluid" src="<?php echo $image['imagePath']; ?>" alt="<?php echo $image['imageName']; ?>" style="min-width: 100%;">
                </div>
            <?php endforeach;
        endif; ?>
    </div>
    <div class="col-8">
        <div class="container col-10">
            <?php if(!empty($section['heading'])): ?>
                <?php echo($section['heading']); ?>
            <?php endif; ?>

            <?php if(!empty($section['subTitle'])): ?>
                <?php echo($section['subTitle']); ?>
            <?php endif; ?>

            <?php if(!empty($section['paragraphs'])):
                foreach ($section['paragraphs'] as $paragraph):?>
                <?php echo($paragraph['text']); ?>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>

