document.getElementById('savePassword').addEventListener('click', function () {
    // Get values from the modal's input fields
    var currentPassword = document.getElementById('currentPassword').value;
    var newPassword = document.getElementById('newPassword').value;
    var confirmNewPassword = document.getElementById('confirmNewPassword').value;

    // Basic client-side validation
    if (newPassword !== confirmNewPassword) {
    alert('New passwords do not match.');
    return;
}


    verifyCurrentAndUpdatePassword(currentPassword, newPassword);
});
    function verifyCurrentAndUpdatePassword(currentPassword, newPassword) {
    // Example: AJAX request to server
    fetch('/manageAccount/updatePassword', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            // Ensure any needed security headers are included
        },
        body: JSON.stringify({
            currentPassword: currentPassword,
            newPassword: newPassword,
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Display success feedback
                document.getElementById('feedbackMessage').textContent = 'Password updated successfully.';
                const feedbackAlert = document.getElementById('feedbackAlert');
                feedbackAlert.classList.remove('d-none');

                // Hide the alert after 5 seconds
                setTimeout(() => {
                    feedbackAlert.classList.add('d-none');
                }, 3000);

                $('#passwordModal').modal('hide');
            }else {
                alert(data.message); // e.g., "Current password is incorrect."
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });

}
