<link rel="stylesheet" type="text/css" href="/css/register.css">
<section class="vh-100 bg-image">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px; display: flex;">
                        <div>
                        </div>
                        <div class="card-body">

                            <h2 class="text-uppercase text-center mb-5">Create an account</h2>

                            <form method="post" enctype="multipart/form-data">
                                <div class="form-outline mb-4">
                                    <label class="form-label text-center mb-5" for="imageUpload">Profile Picture</label>
                                    <div class="avatar-upload">
                                        <div class="avatar-preview">
                                            <img id="imagePreview" src="/img/<?=DEFAULT_PROFILE?>" alt="Preview">
                                        </div>
                                        <input type="file" name="createUserImage" id="imageUpload" accept=".png, .jpg, .jpeg" onchange="previewImage(this)">
                                        <label for="imageUpload" class="btn btn-primary">Choose Image</label>
                                    </div>
                                </div>

                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-outline mb-4">
                                                <input type="text" class="form-control form-control-lg" name="username" id="username" placeholder="Your Username">
                                            </div>
                                            <div class="form-outline mb-4">
                                                <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="Your Email">
                                            </div>
                                            <div class="form-outline mb-4">
                                                <input type="text" class="form-control form-control-lg" name="address" id="address" placeholder="Your Address">
                                            </div>
                                            <div class="form-outline mb-4">
                                                <input type="text" class="form-control form-control-lg" name="phonenumber" id="phonenumber" placeholder="Phone Number">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-outline mb-4">
                                                <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Password">
                                            </div>
                                            <div class="form-outline mb-4">
                                                <input type="password" class="form-control form-control-lg" id="repeatpassword" placeholder="Repeat your password">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success btn-lg" name="registerBtn">Register</button>
                                </div>
                                <p class="text-center text-muted mt-5 mb-0">Already have an account? <a href="/login/login" class="fw-bold text-body"><u>Login here</u></a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


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
