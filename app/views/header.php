<!DOCTYPE html>
<html lang="en">
<head>
    <title>Haarlem Festival</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Aleo:wght@400&family=Architects+Daughter&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/css/headerStyle.css">
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
        <div class="navbar-nav flex-row flex-lg">
            <a id="homeLink" class="nav-link pe-5 text-white" aria-current="page" href="/home/index">The Festival</a>
            <a id="yummyLink" class="nav-link pe-5 text-white" href="/restaurant/yummyHome">Yummy</a>
            <a id="historyLink" class="nav-link pe-5 text-white" href="/history">History</a>
        </div>
        <div class="navbar-nav flex-row flex-lg">
            <a id="loginLink" class="nav-link text-white pt-0 pb-0" href="/login/login">Login</a>
            <a id="personalProgramLink" class="nav-link ps-5" href="/personalProgram">
                <img src="/img/heartbutton.svg" alt="personal program button" width="30" height="30" class="d-inline-block">
            </a>
        </div>
    </nav>
</header>
<main>

