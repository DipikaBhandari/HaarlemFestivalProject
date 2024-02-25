<?php if (!empty($section) && $section['type'] === 'card'): ?>
    <div class="container-fluid text-white py-5 my-0" style="background: url('/img/yummyHeaderBackground.png') no-repeat center center; background-size: cover;">
        <div class="row">
            <div style="height: 96px; display: flex; align-items: center; justify-content: center;">
                <h2  style="font-size: 64px; font-weight: 400; line-height: 88.94px; color: #FFD700; margin: 0;"><?= htmlspecialchars($section['heading']); ?> <br>
                    <br></h2>
            </div>
            <!-- Loop through each card and display its content -->
            <?php foreach ($section['card'] as $card): ?>
                <!-- Wrap the card in an anchor tag that links to the restaurant-specific page -->
                <a href="/restaurant/<?= urlencode(strtolower(str_replace(' ', '-', $card['restaurantName']))); ?>" class="col-md-4 mb-3 text-decoration-none">
                    <div class="card h-100">
                        <div class="card-body">
                            <?php if (isset($card['restaurantName'])): ?>
                                <h5 class="card-title"><?= htmlspecialchars($card['restaurantName']); ?></h5>
                            <?php endif; ?>
                            <!-- Display service options -->
                            <?php if (isset($card['service'])): ?>
                                <ul class="list-unstyled">
                                    <!-- Assuming service is a comma-separated list -->
                                    <?php foreach (explode(',', $card['service']) as $service): ?>
                                        <li><?= trim(htmlspecialchars($service)); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <?php if (isset($card['foodOfferings'])): ?>
                                <p><?= htmlspecialchars($card['foodOfferings']); ?></p>
                            <?php endif; ?>
                            <?php if (isset($card['restaurantPicture'])): ?>
                                <img src="<?= htmlspecialchars($card['restaurantPicture']); ?>" alt="<?= htmlspecialchars($card['restaurantName']); ?>" class="card-img-top">
                            <?php endif; ?>
                            <?php if (isset($card['description'])): ?>
                                <p class="card-text"><?= nl2br(htmlspecialchars($card['description'])); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer">
                            <?php if (isset($card['email'])): ?>
                                <span class="card-link">Email</span>
                            <?php endif; ?>
                            <?php if (isset($card['phoneNumber'])): ?>
                                <span class="card-link">Call</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
