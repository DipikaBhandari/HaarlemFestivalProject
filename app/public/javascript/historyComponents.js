function toggleDescription(locationId) {
    // Hide all descriptions
    var descriptions = document.querySelectorAll('.cardDescription p');
    descriptions.forEach(function(description) {
        description.style.display = 'none';
    });

    var images = document.querySelectorAll('.cardImage img');
    images.forEach(function(image) {
        image.style.display='none';
    });

    // Show the description corresponding to the clicked button
    var description = document.getElementById('description_' + locationId);
    description.style.display = 'block';

    var image = document.getElementById('image_' + locationId);
    image.style.display = 'block';

    // Remove active class from all buttons and name buttons
    // var buttons = document.querySelectorAll('.timetable-button, .name-button');
    // buttons.forEach(function(button) {
    //     button.classList.remove('active');
    // });
    //
    // // Add active class to the clicked button and name button
    // var button = document.getElementById('button_' + locationId);
    // button.classList.add('active');
    //
    // var nameButton = document.getElementById('name_button_' + locationId);
    // nameButton.classList.add('active');
}




var map = L.map('map').setView([52.380, 4.64], 18); // Set initial center and zoom level

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
    maxZoom: 20
}).addTo(map);

// Add markers for festival places
var places = [
    { name: 'St.Bavo Church', location: [52.38112, 4.63731] },
    { name: 'Grote Markt', location: [52.38165, 4.63721] },
    { name: 'De Hallen Haarlem', location: [52.38152, 4.63599] },
    { name: 'Proveniershof', location: [52.37775, 4.63082] },
    { name: 'Jopenkerk', location: [52.38158, 4.62982] },
    { name: 'Waalse Kerk', location: [52.39758, 4.63770] },
    { name: 'De Adriaan', location: [52.38441, 4.64264] },
    { name: 'Amsterdamse Poort', location: [52.38070, 4.64657] },
    { name: 'Hofje van Bakenes', location: [52.38227, 4.63995] },
];

places.forEach(function(place) {
    L.marker(place.location).addTo(map).bindPopup(place.name);
});