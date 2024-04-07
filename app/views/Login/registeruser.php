<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
<!--    <link rel="stylesheet" type="text/css" href="/css/register.css">-->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</head>

<body class="bg-dark p-2 text-white">
<div class="container pt-0">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
            <div class="card text-black h-100" style="border-radius: 25px;">
                <div class="card-body p-md-5">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                            <?php if (isset($_SESSION['flash_message'])) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= $_SESSION['flash_message'] ?>
                                </div>
                                <?php unset($_SESSION['flash_message']); ?>
                            <?php endif; ?>

                            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4">Create An Account</p>
                            <form id="registerUserForm" class="mx-1 mx-md-4" method="POST"
                                  enctype="multipart/form-data">
                                <div class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <div class="position-relative">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <div class="avatar-preview">
                                                        <img id="imagePreview" src="/img/<?=DEFAULT_PROFILE?>" alt="Preview">
                                                    </div>
                                                    <input type="file" name="createUserImage" id="imageUpload" accept=".png, .jpg, .jpeg" onchange="previewImage(this)">
                                                    <label for="imageUpload" class="btn btn-primary">Choose Profile Picture</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row align-items-center mb-4">
                                    <div class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="form3Example4c">Username</label>
                                        <input type="text" name="username" id="username" class="form-control"/>
                                    </div>
                                </div>
                                <div class="d-flex flex-row align-items-center mb-4">
                                    <div class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="form3Example4c">Email</label>
                                        <input type="email" name="email" id="email" class="form-control"/>
                                    </div>
                                </div>
                                <div class="d-flex flex-row align-items-center mb-4">
                                    <div class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="form3Example4c">Address</label>
                                        <input type="text" name="address" id="address" class="form-control"/>
                                    </div>
                                </div>
                                <div class="d-flex flex-row align-items-center mb-4">
                                    <div class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="form3Example4c">Phone Number</label>
                                        <input type="text" name="phonenumber" id="number" class="form-control"/>
                                    </div>
                                </div>
                                <div class="d-flex flex-row align-items-center mb-4">
                                    <div class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control"/>
                                    </div>
                                </div>
                                <div class="d-flex flex-row align-items-center mb-4">
                                    <div class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="confirmPassword">Confirm
                                            Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password"
                                               class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-outline g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success btn-lg" name="registerBtn">Register</button>
                                </div>
                                <p class="text-center text-muted mt-5 mb-0">Already have an account? <a href="/login/login" class="fw-bold text-body"><u>Login here</u></a></p>

                                <?php if (!empty($errorMessage)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $errorMessage; ?>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('imagePreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script>
    function previewImage(input) {
        var preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "/img/<?=DEFAULT_PROFILE?>"; // If no file is selected, show the default avatar
        }
    }

</script>


<style>
    .avatar-preview {
        width: 200px;
        height: 200px;
        overflow: hidden;
        position: relative;
        margin: 10px;
        text-align: center;
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #224fa1;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Avatar Upload Styles */
    .avatar-upload label {
        display: inline-block;
        padding: 10px 10px;
        border: 2px solid #006D77;
        border-radius: 5px;
        cursor: pointer;
    }

    .avatar-upload input[type=file] {
        display: none;
    }
</style>