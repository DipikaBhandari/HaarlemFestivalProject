<div class="crossNavigation">
    <?php if(!empty($section['heading'])): ?>
        <h1><?php echo($section['heading']); ?></h1>
    <?php endif; ?>

    <?php if(!empty($section['subTitle'])): ?>
        <h4><?php echo($section['subTitle']); ?></h4>
    <?php endif; ?>

    <div id="myCarousel" class="carousel" >
        <div class="carousel-inner">
            <?php foreach ($section['carouselItems'] as $index => $item):?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="card text-start">
                            <?php
                            if (!empty($item['imageId'])):
                                $imagePath = '';
                                foreach ($section['images'] as $image) {
                                    if ($image['imageId'] === $item['imageId']) {
                                        $imagePath = $image['imagePath'];
                                        break;
                                    }
                                }
                                if (!empty($imagePath)): ?>
                                    <img src="<?php echo $imagePath; ?>" alt="Carousel Image" class="card-img-top img-fluid">
                                <?php endif;
                            endif; ?>
                            <div class="card-body" style="background-color: #006D77">
                                <h3 class="card-title"><?php echo $item['title']; ?></h3>
                                <p class="card-text"><?php echo $item['subtitle']; ?></p>
                                <a href="<?php echo $item['linkPath']; ?>" class="btn btn-light"><?php echo $item['linkText']; ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
