document.addEventListener('DOMContentLoaded', () => {
    const profilePictureInput = document.getElementById('profilePictureInput');
    const profilePicture = document.getElementById('profilePicture');
    const defaultAvatar = document.getElementById('defaultAvatar');
    const form = document.getElementById('userInfoForm');

    // Handle profile picture change
    profilePictureInput.addEventListener('change', function(event) {
        if (event.target.files.length > 0) {
            const src = URL.createObjectURL(event.target.files[0]);
            if (profilePicture) {
                profilePicture.src = src;
                profilePicture.style.display = 'block';
            } else {
                // Create an img element if not exists
                const newImg = document.createElement('img');
                newImg.id = 'profilePicture';
                newImg.src = src;
                newImg.classList.add('avatar');
                document.querySelector('.profile-pic-label').appendChild(newImg);
            }
            defaultAvatar.style.display = 'none';
        }
    });

    // Form submission with validation
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const userName = document.getElementById('userName').value.trim();
        const userEmail = document.getElementById('userEmail').value.trim();
        const userAddress = document.getElementById('userAddress').value.trim();
        const userPhoneNumber = document.getElementById('userPhoneNumber').value.trim();

        if (!userName || !userEmail || !userAddress || !userPhoneNumber) {
            alert('Please fill out all required fields.');
            return;
        }

        const formData= new FormData(form);

        fetch('/manageAccount/updateAccount' ,{
            method: 'POST',
            body: formData, // FormData will correctly handle file input

        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json(); // or .text(), depending on the response from your server
            })
            .then(data => {
                console.log(data); // Process and display success message or redirect
                alert('Profile updated successfully!');
                document.getElementById('feedbackMessage').textContent = 'Account updated successfully.';
                const feedbackAlert = document.getElementById('feedbackAlert');
                feedbackAlert.classList.remove('d-none');

                // Hide the alert after 5 seconds
                setTimeout(() => {
                    feedbackAlert.classList.add('d-none');
                }, 3000);
            })
            .catch(error => {
                console.error('Error:', error);
                 // Process and display success message or redirect
                alert('Profile updated successfully!');
                document.getElementById('feedbackMessage').textContent = 'Account updated successfully.';
                const feedbackAlert = document.getElementById('feedbackAlert');
                feedbackAlert.classList.remove('d-none');

                // Hide the alert after 5 seconds
                setTimeout(() => {
                    feedbackAlert.classList.add('d-none');
                }, 3000);
                alert('An error occurred while updating the profile.');
            });
    });
});

