document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        initialDate: '2022-07-25',
        // validRange: { // Set valid date range
        //     start: '2022-07-25', // Start date
        //     end: '2022-07-28' // End date
        // }

    });
    calendar.render();

    // Function to switch to list view
    function switchToListView() {
        calendar.changeView('listWeek'); // Change to list view
    }

    // Function to switch to agenda view
    function switchToAgendaView() {
        calendar.changeView('timeGridWeek'); // Change to agenda view
    }

    // Event listeners for toggle buttons
    document.getElementById('listViewBtn').addEventListener('click', switchToListView);
    document.getElementById('agendaViewBtn').addEventListener('click', switchToAgendaView);
});

function addEventToCalendar(date, time, imagePath) {
    // Send an AJAX request to your server with the event details
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "timetable.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // Upon successful response, update the FullCalendar with the new event
            var eventData = JSON.parse(this.responseText);
            if (eventData) {
                // Add the event source to the FullCalendar
                calendar.addEventSource([eventData]);
            }
        }
    };
    xhr.send("date=" + date + "&time=" + time + "&imagePath=" + imagePath);
}