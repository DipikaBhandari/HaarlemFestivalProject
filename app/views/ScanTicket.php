<?php
if(!isset($_SESSION)){
    session_start();
}

if(isset($_SESSION['username'])) {
    include __DIR__ . '/afterlogin.php'; // Include afterlogin.php for logged-in users
} else {
    include __DIR__ . '/header.php'; // Include default header for non-logged-in users
}
?>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>
    </head>
    <div class="text-center m-5">
        <h1>Scan ticket</h1>
        <video id="camera-feed" autoplay></video>
        <div id="alert-message" class="hidden"></div>
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
            console.log('QR Code detected:', code.data); // Log the QR code data
            console.log('Request body:', JSON.stringify({ code: code.data }));
            video.srcObject.getTracks().forEach(track => track.stop());
            fetch('/order/verifyTicket',{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json' // Ensure JSON content type
                },
                body: JSON.stringify({ code: code.data })
            })
                .then(response => response.json())
                .then(data => {
                    showAlert(data.message, data.success);
                    setTimeout(() => {
                        requestAnimationFrame(() => detectQRCode(video));
                    }, 3000);
                })
                .catch(error => {
                    showAlert('Failed to verify QR code. Please try again.', false);
                });
        } else{
            requestAnimationFrame(() => detectQRCode(video));
        }
    }
    function showAlert(message, success) {
            const alertMessage = document.getElementById('alert-message');
            alertMessage.innerText = message;

            if (success) {
                alertMessage.classList.remove('error');
                alertMessage.classList.add('success');
            } else {
                alertMessage.classList.remove('success');
                alertMessage.classList.add('error');
            }

            alertMessage.classList.remove('hidden');
            setTimeout(() => {
                alertMessage.classList.add('hidden');
                // Restart the video
                const videoElement = document.getElementById('camera-feed');
                navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }})
                    .then(stream => {
                        videoElement.srcObject = stream;
                        videoElement.onloadedmetadata = () => {
                            videoElement.play();
                            detectQRCode(videoElement);
                        };
                    })
                    .catch(error => console.error('Error accessing camera:', error));
            }, 3000);
    }
</script>

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        width: 100%;
    }
    .hidden {
        display: none;
    }

    #camera-feed {
        max-width: 100%;
        height: auto;
        margin: auto;
        display: block;
    }

    #alert-message {
        position: relative;
        left: 50%;
        transform: translateX(-50%);
        padding: 10px 20px;
        border-radius: 5px;
        z-index: 999;
    }

    .success {
        background-color: #4CAF50;
    }

    .error {
        background-color: #f44336;
    }
</style>
