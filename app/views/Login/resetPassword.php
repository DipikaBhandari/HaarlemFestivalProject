<html>
<head>
    <title>Haarlem Festival</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Reset password here</h1>
    <form method='POST' action="/login/updatePassword?email=<?php echo urlencode($_GET['email'] ?? ''); ?>">

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
</body>
</html>
