<!-- Assuming $cards contains all the card data from the backend -->
<?php if (!empty($section) && $section['type'] === 'card'): ?>
    <div class="container-fluid text-white py-5 my-0" style="background: url('/img/yummyHeaderBackground.png') no-repeat center center; background-size: cover;">
        <div class="row">
            <div class="col-12 card-title-container text-center mb-4">
                 <h2 class="card-title"><?php echo($section['heading']); ?> </h2>
            </div>




        <!-- Loop through each card and display its content -->
        <?php foreach ($section['card'] as $card): ?>
            <div class="col-md-4 mb-3">
                <div class="card custom-card">
                    <img src="<?= ($card['restaurantPicture']); ?>" alt="<?= ($card['restaurantName']); ?>" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-name"><?= ($card['restaurantName']); ?></h5>
                        <!-- Service options and offerings here -->
                        <p class="card-description"><?= nl2br(($card['description'])); ?></p>
                        <?php if (isset($card['service'])): ?>
                            <ul class="list-unstyled">
                                <!-- Assuming service is a comma-separated list -->
                                <?php foreach (explode(',', $card['service']) as $service): ?>
                                    <li><?= trim(($service)); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <?php if (isset($card['foodOfferings'])): ?>
                            <p><?= ($card['foodOfferings']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer ">
                        <?php if (isset($card['phoneNumber'])): ?>
                            <a href="tel:<?= ($card['phoneNumber']); ?>" class="card-link">Call</a>
                        <?php endif; ?>
                    </div>
                    <br>
                    <br>
                    <a href="/restaurant/details/<?= $card['restaurantId']; ?>" class="stretched-link"></a>
                    <div class="more-info-button text-center">
                        <a href="/restaurant/details/<?= $card['restaurantId']; ?>">MORE INFO</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
            <h3 class="map-title">Yummy Location</h3>
            <div id="map" style=" height: 400px;"></div>
        </div>
</div>




<style>

    .map-title{
        font-size: 64px;
        color: #FFD700;
        margin: 0 auto;
        font-weight: 400;
        line-height: 88.94px;
        padding-top: 3rem;
        padding-bottom: 1rem;
        padding-left: 2rem;
    }
    .card-title-container {
        /* Center title container */
    }

    .card-title {
        font-size: 64px;
        color: #FFD700;
        margin: 0 auto;
        font-weight: 400;
        line-height: 88.94px;
    }

    .custom-card {
        padding-bottom: 0rem;
    }

    .card-name {
        /* Style for the restaurant name */
    }

    .card-description {
        /* Style for the restaurant description */
    }
    .card-img-top {
        height: 300px; /* Fixed height for all card images */
        object-fit: cover; /* Ensures the image covers the element's box */
        width: 100%; /* Ensures the image spans the full width of the card */
    }

    .more-info-button {
        /* Style the 'MORE INFO' button */
        position: absolute;
        bottom: -10px; /* Adjust this value */
        left: 50%;
        transform: translateX(-50%);
        background-color: #A3AF1E;
        width: 266px;
        height: 61px;
        line-height: 61px;
        border-radius: 30px;
        margin-top: 20px;

    }

    .more-info-button a {
        display: block;
        font-size: 24px;
        color: white;
        text-decoration: none;
        border-radius: 30px;

    }

    .map-container {
        height: 400px; /* Set the height of the map */
    }

</style>

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
