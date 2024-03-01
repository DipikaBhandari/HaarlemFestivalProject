<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
<link rel="stylesheet" type="text/css" href="/css/login.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    ></script>
</head>
<body>

<div class="container">
    <img id="loginImage" src="../img/example.jpg" >
    <div class="login-container">

    <div class="d-flex flex-column">
        <h1>Welcome To Haarlem Festival</h1>
        <br>
        <form method='POST' >
            <div>
            <div>
                <label for="exampleInputEmail1" class="form-label">Username</label>
            </div>
            <div>
                <input class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp" required>
            </div>
            <div>
                <label for="exampleInputPassword1" class="form-label">Password</label>
            </div>
            <div>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" required>
            </div>
            <button class="submit-btn" type="submit" name="btnLogin">Login</button>
            </div>
        </form>
        <form class="register-form" action="/login/createNewUser" method="POST">
            <div>
                <button class="register-btn btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" name="registerSubmit" type="submit">Don't have an account? Sign Up</button>
            </div>
        </form>
        <form class="register-form" action="/login/resetPasswordViaEmail" method="POST">
            <div>
                <a class="register-btn" href="./forgotPassword">Forgot Password?</a>
            </div>
        </form>
    </div>
    </div>
</div>
</body>
</html>
