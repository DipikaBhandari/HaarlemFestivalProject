<?php
if(isset($_SESSION['username'])) {
    include __DIR__ . '/../afterlogin.php'; // Include afterlogin.php for logged-in users
} else {
    include __DIR__ . '/../header.php'; // Include default header for non-logged-in users
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Personal Program</title>
    <style>
        h1 {
            text-align: center;
            color: rgba(88, 47, 14, 0.83);
            font-family: Aleo, serif;
            font-size: 50px;
        }

        .fc-event-delete {
            cursor: pointer;
            position: absolute;
            top: 2px;
            right: 2px;
            color: white;
            font-size: 18px;
        }
    </style>
</head>
<body>
<h1>Your Personal Program</h1>
<div id='calendar'></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const firstEventDate = new Date(<?php echo json_encode($events[1]['start']); ?>);
        const initialView = 'timeGridWeek';

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: initialView,
            initialDate: firstEventDate,
            events: <?php echo json_encode($events); ?>,
            eventDidMount: addDeleteButton,
            eventClick: handleEventDelete
        });

        function addDeleteButton(info) {
            const deleteButton = document.createElement('span');
            deleteButton.className = 'fc-event-delete';
            deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
            deleteButton.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevent click event from propagating to eventClick handler
            });
            info.el.appendChild(deleteButton);
        }

        function handleEventDelete(info) {
            if (confirm('Are you sure you want to delete this event?')) {
                deleteEvent(info.event);
            }
        }

        function deleteEvent(event) {
            const orderItemId = event.extendedProps.orderItemId;
            fetch('/ticket/deleteOrder', {
                method: 'POST',
                body: JSON.stringify({ orderItemId: orderItemId }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (response.ok) {
                        console.log('Event deleted successfully');
                        event.remove();
                    } else {
                        console.error('Failed to delete event');
                    }
                })
                .catch(error => {
                    console.error('Error deleting event:', error);
                });
        }

        calendar.render();
    });
</script>

</body>
</html>
