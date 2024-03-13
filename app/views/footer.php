</main>
<footer class="text-center bg-body-primary footer">
    <div class="container">
        <a><i class="fa-brands fa-facebook"></i></a>
        <a><i class="fa-brands fa-instagram"></i></a>
        <a><i class="fa-brands fa-tiktok"></i></a>
        <a><i class="fa-brands fa-x-twitter"></i></a>
    </div>
</footer>
</body>
</html>

<style>
    html, body {
        height: 100%;
        margin: 0;
    }

    .main-content {
        min-height: calc(100vh - var(--footer-height)); /* Adjust the 70px to match your footer's height */
        /* Rest of your main content styles */
    }

    .footer {
        height: var(--footer-height); /* Set this to the height of your footer */
        width: 100%;
        position: fixed;
        bottom: 0;
        left: 0;
    }

    /* Add this variable somewhere in your CSS where you define global values */
    :root {
        --footer-height: 70px; /* Adjust this value to match your footer's actual height */
    }

</style>
