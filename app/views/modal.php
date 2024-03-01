<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div class="modal fade" id="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Password Reset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modalBtn1">Login</button>
                <button type="button" class="btn btn-secondary" id="modalBtn2">Go to Homepage</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    document.getElementById('modalBtn1').addEventListener('click', function() {
        window.location.href = '/login/login';
    });

    document.getElementById('modalBtn2').addEventListener('click', function() {
        window.location.href = '/home';
    });
</script>