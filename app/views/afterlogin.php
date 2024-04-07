<?php
$role = $_SESSION["role"];
$isAdmin = $role === "Administrator";
$isEmployee = $role === "Employee";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Haarlem Festival</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="stylesheet" type="text/css" href="/css/headerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <script defer>
        document.addEventListener('DOMContentLoaded', function () {
            const currentPage = window.location.pathname;
            const links = document.querySelectorAll('.navbar-nav a');

            links.forEach(function (link) {
                if (link.getAttribute('href').includes(currentPage)) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</head>
<body>
<header>
    <div>
        <img id="logo" src="/img/festivalLogo.svg" >
    </div>
    <nav class="navbar navbar-expand-lg bg-body-primary d-flex justify-content-between px-2">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <div class="navbar-nav flex-row flex-lg" id="dynamicNavLinks">
        </div>
        <div class="navbar-nav flex-row flex-lg">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle text-white pt-0 pb-0" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    Manage Account
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="/manageaccount/showAccount">Profile</a></li>
                    <?php if($isEmployee): ?>
                    <li><a class="dropdown-item" href="/order/scanTicket">Scan tickets</a></li>
                    <?php endif; ?>
                    <?php if ($isAdmin): ?>
                        <li><a class="dropdown-item" href="#">Manage Users</a></li>
                        <li><a class="dropdown-item" href="#">Manage History Events</a></li>
                        <li><a class="dropdown-item" href="#">Manage Yummy Events</a></li>
                        <li><a class="dropdown-item" href="/pageManagement">Manage Content</a></li>
                        <li><hr class="dropdown-divider"></li>
                    <?php endif; ?>

                    <li><a class="dropdown-item" href="/manageAccount/showAccount">Profile</a></li>
                    <li><a class="dropdown-item admin hide" href="/ManageUsers/manageuser">Manage Users</a></li>
                    <li><a class="dropdown-item admin hide" href="/ManageHistory/manageHistory">Manage History Events</a></li>
                    <li><a class="dropdown-item admin hide" href="/ManageYummy/manageYummy">Manage Yummy Events</a></li>
                    <li><a class="dropdown-item admin hide" href="#">Manage Contents</a></li>
                    <li><a class="dropdown-item admin hide" href="/ManageReservation/manageReservation">Manage Reservation</a></li>
                    <li><a class="dropdown-item admin hide" href="/ManageOrder/manageOrder">Manage Order</a></li>

                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/login/logout">Logout</a></li>
                </ul>
            </div>

            <a id="personalProgramLink" class="nav-link ps-5" href="/personalProgram">
                <i class="fa-regular fa-heart fa-xl" style="color: #c80e0e;"></i>
                <img src="/img/heartbutton.svg" alt="personal program button" width="30" height="30" class="d-inline-block">
            </a>
            <!--remove this when all code is combined-->
            <a href="/order">invoice email</a>
        </div>
            <div class="navbar-nav flex-row flex-lg">
                <a class="nav-link ps-4 align-items-center" href="/shoppingCart/index">
                    <i class="fa-solid fa-cart-shopping fa-xl" style="color: #ffffff;"></i>
                </a>
                <a class="nav-link ps-4 align-items-center" href="/shoppingCart/showPaidOrders">
                    <i class="fa-solid fa-check-to-slot fa-xl" style="color: #ffffff;"></i>
                </a>
                <a id="personalProgramLink" class="nav-link ps-4 align-items-center" href="/ticket/index">
                    <i class="fa-regular fa-heart fa-xl" style="color: #c80e0e;"></i>
                </a>

            </div>
        </div>
    </nav>
</header>
<main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('/pageManagement/nav')
            .then(response => response.json())
            .then(data => {
                const navLinksContainer = document.getElementById('dynamicNavLinks');
                data.forEach(page => {
                    const navLink = document.createElement('a');
                    navLink.classList.add('nav-link', 'pe-5', 'text-white');
                    navLink.href = `${page.pageLink}?pageId=${page.pageId}`;
                    navLink.textContent = page.pageTitle;
                    navLinksContainer.appendChild(navLink);
                });
            })
            .catch(error => console.error('Error fetching pages:', error));
    });

     const role = "<?php echo $_SESSION["role"]?>";
     const items = document.querySelectorAll('.admin');

     if(role === "Administrator"){
         items.forEach(item =>{
             item.classList.remove("hide");
         })
     } else{
         items.forEach(item =>{
             item.classList.add("hide");
         })
     }
</script>
<style>
  .hide{
      display:none;
  }
</style>

