<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="/css/login.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

<div class="container">
    <img id="loginImage" src="../img/haarlem.jpg">
    <div class="login-container">
        <h1>Welcome to Haarlem Festival</h1>
        <form method='POST'>
            <div class="form-group">
                <label for="exampleInputEmail1" class="form-label">Username</label>
                <input class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label">Password </label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" required>
            </div>
            <button class="submit-btn" type="submit" name="btnLogin">Login</button>
        </form>
        <form class="register-form" action="/login/register" method="POST">
            <button class="register-btn btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" name="registerSubmit" type="submit">Don't have an account? Sign Up</button>
        </form>
        <form class="register-form" action="/login/resetPasswordViaEmail" method="POST">
            <a class="forgot-password" href="./forgotPassword">Forgot Password?</a>
        </form>
    </div>
</div>

</body>
</html>
