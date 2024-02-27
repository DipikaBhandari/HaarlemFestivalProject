<!-- Assuming $cards contains all the card data from the backend -->
<?php if (!empty($section) && $section['type'] === 'card'): ?>
    <div class="container-fluid text-white py-5 my-0" style="background: url('/img/yummyHeaderBackground.png') no-repeat center center; background-size: cover;">
        <div class="row">
            <div style="height: 96px; display: flex; align-items: center; justify-content: center;">
                 <h2  style="font-size: 64px; font-weight: 400; line-height: 88.94px; color: #FFD700; margin: 0;"><?= htmlspecialchars($section['heading']); ?> <br>
                 <br></h2>
            </div>
        <!-- Loop through each card and display its content -->
        <?php foreach ($section['card'] as $card): ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <a href="/restaurant/details/<?= $card['restaurantId']; ?>" class="stretched-link"></a>
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
                            <a href="mailto:<?= htmlspecialchars($card['email']); ?>" class="card-link">Email</a>
                        <?php endif; ?>
                        <?php if (isset($card['phoneNumber'])): ?>
                            <a href="tel:<?= htmlspecialchars($card['phoneNumber']); ?>" class="card-link">Call</a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
            <div id="map" style=" height: 400px;"></div>
        </div>
</div>
<?php endif; ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCymxT75KkPHAA7LcaoUfPrFD4p0SdtGF4&callback=initMap" async defer></script>
<?php
// Assuming $locations is already populated with the data you need
$jsonLocations = json_encode($locations);
?>
<script>
    // This variable will be accessible in your existing initMap() function
    var locations = <?php echo $jsonLocations; ?>;
</script>
<script>
    function initMap() {
        var bounds = new google.maps.LatLngBounds();
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: {lat: 40.7128, lng: -74.0060} // This will be overridden by the bounds
        });

        locations.forEach(function(location) {
            var position = new google.maps.LatLng(location.Lati, location.Long);
            var marker = new google.maps.Marker({
                position: position,
                map: map,
                title: location.Locationmm // Assuming there is a name property
            });
            bounds.extend(position);
        });

        map.fitBounds(bounds); // Fits the map bounds to include all markers
    }
</script>
