<html>
    <head>
        <title>Haarlem Festival</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
              integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
              integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
              crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <h1>Reset password here</h1>
            <form id="resetPasswordForm" method='POST'>

                <div class="mb-3">
                    <label for="newPassword" class="form-label">New password</label>
                    <input class="form-control" type="password" name="newPassword" id="newPassword" required>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" required>
                </div>
                <button type="submit" class="btn btn-success" name="btnResetPassword" >Reset Password</button>
            </form>
        </div>
        <?php include __DIR__ . '/../modal.php'; ?>
    </body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('resetPasswordForm').addEventListener("submit", function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            let email = new URLSearchParams(window.location.search).get('email');
            formData.append('email', email);

            fetch('/login/updatePassword',{
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    let resetPasswordModal = new bootstrap.Modal(document.getElementById('modal'));
                    let modalBody = document.getElementById('modalBody');
                    let loginButton = document.getElementById('modalBtn1');
                    let goToHomepageButton = document.getElementById('modalBtn2');
                    modalBody.innerHTML = data.message;
                    if(data.success){
                        loginButton.style.display = 'block';
                        goToHomepageButton.style.display = 'block';
                    } else{
                        loginButton.style.display = 'none';
                        goToHomepageButton.style.display = 'none';
                    }
                    resetPasswordModal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again later.');
                })
            })
    });
</script>
