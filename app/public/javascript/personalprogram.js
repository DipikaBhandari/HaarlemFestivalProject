function generatePDF() {
    // Create a new jsPDF instance
    var doc = new jsPDF();

    // Counter for the number of pages added to the PDF
    var pageCount = 0;

    // Function to add a page to the PDF
    function addPageToPDF(canvas) {
        // Convert the canvas to a data URL
        var imgData = canvas.toDataURL('image/png');

        // Add the captured image to the PDF
        if (pageCount > 0) {
            doc.addPage();
        }
        doc.addImage(imgData, 'PNG', 10, 10, 190, 277); // Set width and height manually (A4 size: 210x297mm)
        pageCount++;
    }

    // Capture the entire calendar container including the header
    var calendarContainer = document.getElementById('calendarContainer');

    // Use html2canvas to capture the calendar container
    html2canvas(calendarContainer, { useCORS: true, logging: true, onrendered: function(canvas) {
            // Add the captured calendar page to the PDF
            addPageToPDF(canvas);

            // Save the PDF
            doc.save('HaarlemFestivalPersonalProgram.pdf');
        }});

    
}



function showShareModal(url) {
    var modal = document.getElementById('shareModal');
    var shareLinkInput = document.getElementById('shareLink');
    shareLinkInput.value = url;
    modal.style.display = "block";
}

// Function to close the share modal
function closeShareModal() {
    var modal = document.getElementById('shareModal');
    modal.style.display = "none";
}

// Function to copy the sharing link
// Function to copy the sharing link
function copyShareLink() {
    var shareLinkInput = document.getElementById('shareLink');
    shareLinkInput.select();
    shareLinkInput.setSelectionRange(0, 99999); /* For mobile devices */
    document.execCommand("copy");
    alert("Link copied to clipboard: " + shareLinkInput.value);
}

// Function to share the link on social media
function shareOnSocialMedia() {
    var shareLinkInput = document.getElementById('shareLink');
    var shareUrl = shareLinkInput.value;

    // You can implement the social media sharing logic here
    // For example, you can open a new window with the social media platform's sharing URL
    var socialMediaUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(shareUrl);
    window.open(socialMediaUrl, "_blank");
}

// Function to share the link on WhatsApp
function shareOnWhatsApp() {
    var shareLinkInput = document.getElementById('shareLink');
    var shareUrl = shareLinkInput.value;

    // Construct the WhatsApp share link
    var whatsappUrl = "whatsapp://send?text=" + encodeURIComponent(shareUrl);

    // Open WhatsApp with the pre-filled message containing the sharing link
    window.location.href = whatsappUrl;
}


document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const events = JSON.parse(calendarEl.dataset.events); // Retrieve events from data attribute

    const urlParams = new URLSearchParams(window.location.search);
    const readOnly = urlParams.get('readOnly');

    if (readOnly === 'true') {
        // Disable editing functionalities
        disableEditingFunctionalities(calendarEl);
    }

    const firstEventDate = new Date(events[0].start); // Adjust the index if necessary
    const initialView = 'timeGridWeek';

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: initialView,
        initialDate: firstEventDate,
        events: events,
        eventDidMount: addDeleteButton,
        eventClick: handleEventDelete,
        editable: !readOnly // Make the calendar editable unless it's read-only
    });

    function disableEditingFunctionalities(calendarEl) {
        // Disable editing functionalities here
        calendarEl.addEventListener('click', function(info) {
            if (info.event && info.event.extendedProps && info.event.extendedProps.orderItemId) {
                // Check if the event has an orderItemId (indicating it's an event with delete button)
                // Remove the delete button
                const deleteButton = info.el.querySelector('.fc-event-delete');
                if (deleteButton) {
                    deleteButton.remove();
                }
            }
        });
    }
    function handleDeleteButtonClick(event) {
        event.stopPropagation(); // Prevent click event from propagating to eventClick handler
    }

    function handleEventDelete(info) {
        if (calendar.getOption('editable')) {
            if (confirm('Are you sure you want to delete this event?')) {
                deleteEvent(info.event);
            }
        } else {
            alert('You do not have permission to delete events in read-only mode.');
        }
    }


    function addDeleteButton(info) {
        // Add the delete button regardless of the read-only status
        const deleteButton = document.createElement('span');
        deleteButton.className = 'fc-event-delete';
        deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
        deleteButton.addEventListener('click', handleDeleteButtonClick);
        info.el.appendChild(deleteButton);
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