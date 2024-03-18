<?php
session_start();

if(isset($_SESSION['username'])) {
    include __DIR__ . '/afterlogin.php'; // Include afterlogin.php for logged-in users
} else {
    include __DIR__ . '/header.php'; // Include default header for non-logged-in users
}
?>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>
    </head>
    <div class="conainer text-center m-5">
        <h1>Scan ticket</h1>
        <video id="camera-feed" width="320" height="240" autoplay></video>
        <p id="result"></p>
    </div>

    <?php include __DIR__ . '/footer.php'; ?>
<script>
        const videoElement = document.getElementById('camera-feed');
        const result = document.getElementById('result');

        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment'}})
            .then(stream => {
                videoElement.srcObject = stream;
                videoElement.onloadedmetadata = () => {
                    videoElement.play();
                    detectQRCode(videoElement);
                };
            })
            .catch(error => console.error('Error accessing camera:', error));

    function detectQRCode(video) {
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, imageData.width, imageData.height);

        if (code) {
            result.innerText = 'QR Code detected: ' + code.data;
            fetch('/order/verifyTicket',{
                method: 'POST',
                body: code.data
            })
                .then(response => {
                    if(!response.ok){
                        document.getElementById('result').innerHTML = '<div class="alert alert-danger mt-3">Failed to verify QR code. Please try again.</div>';
                    }
                    return response.json();
                })
                .then(data => {
                document.getElementById('result').innerHTML = '<div class="alert alert-success mt-3">' + data + '</div>';
            })
            .catch(error => {
                console.error(error);
            })
        } else{
            result.innerText = 'No QR Code detected';
        }
        requestAnimationFrame(() => detectQRCode(video));
    }
</script>

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
</style>
