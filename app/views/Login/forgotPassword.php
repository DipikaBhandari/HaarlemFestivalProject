<!DOCTYPE html>
<html lang="en">
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
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;900&display=swap" rel="stylesheet">
    </head>
    <body class="min-vh-100 d-flex align-items-center">
        <div class="container vh-90">
            <div class="row justify-content-center align-items-center">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title">Forgot your password?</h1>
                            <p class="card-text">Enter your email address below. We will send you a link to reset your password.</p>
            <form id="forgotPasswordForm" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Email@address.com" required>
                </div>
                <button class="btn btn-primary" type="submit">Send</button>
            </form>
        </div>
        <?php include __DIR__ . '/../modal.php'; ?>
    </body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('forgotPasswordForm').addEventListener("submit", function(event) {
            event.preventDefault();
            let formData = new FormData(this);

            fetch('/login/sendResetLink',{
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    let sentLinkModal = new bootstrap.Modal(document.getElementById('modal'));
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
                    sentLinkModal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again later.');
                })
        })
    });
</script>