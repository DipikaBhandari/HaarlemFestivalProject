<div id="map"></div>
<script>
    var map = L.map('map').setView([52.382, 4.63], 14); // Set initial center and zoom level

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    // Add markers for festival places
    var places = [
        { name: 'Patronaat', location: [52.3830005, 4.6287112] },
        { name: 'Grote Markt', location: [52.3814885, 4.6368004] },
        { name: 'Cafe De Roemer', location: [52.3798641, 4.6318660] },
        { name: 'Ratatouille', location: [52.3786756, 4.63760304] },
        { name: 'Restaurant ML', location: [52.3777908, 4.6356580] },
        { name: 'Restaurant Fris', location: [52.3722528, 4.6341628] },
        { name: 'Specktakel', location: [52.3807800, 4.6361150] },
        { name: 'Grand Cafe Brinkmann', location: [52.3816500, 4.6361507] },
        { name: 'Toujours', location: [52.3806823, 4.6370676] },
        { name: 'Lichtfabriek', location: [52.3869543, 4.6514515] },
        { name: 'Club Stalker', location: [52.3821995, 4.6342955] },
        { name: 'Jopenkerk', location: [52.3812919, 4.6297175] },
        { name: 'XO The Club', location: [52.3812136, 4.6352088] },
        { name: 'Club Ruis', location: [52.3821880, 4.6363621] },
        { name: 'Caprera Openluchttheater', location: [52.4112139, 4.6080190] },
    ];

    places.forEach(function(place) {
        L.marker(place.location).addTo(map).bindPopup(place.name);
    });
</script>
