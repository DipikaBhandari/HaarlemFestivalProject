<?php
include __DIR__ . '/../header.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rectangle Example</title>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome CSS -->
    <script src="/javascript/personalprogram.js"></script>

        <h1 style="text-align: center; color: rgba(88, 47, 14, 0.83);font-family: Aleo,serif;font-size: 50px;
">Your Personal Program</h1>

    <style>
        .rectangle {
            display: flex;
            align-items: center;
            padding: 10px;
            margin: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .left-section {
            flex: 1;
            padding-right: 20px;
        }

        .middle-section {
            flex: 3;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            padding-right: 20px;
        }

        .right-section {
            flex: 1;
            text-align: right;
        }

        .delete-icon {
            cursor: pointer;
            color: red;
        }

        .bottom-section {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
        }

        /* Styling for the paid and unpaid indicators */
        .indicator {
            display: flex;
            align-items: center;
            margin: 20px;
            justify-content: space-between;

        }

        .indicator-box {
            border-radius: 5px;
            width: 86px;
            height: 40px;
            margin-right: 5px;
        }

        .paid .indicator-box {
            flex-shrink: 0;
            background-color: rgba(0, 109, 119, 1); /* Change color as needed */
        }

        .unpaid .indicator-box {
            border: 4px dashed rgba(0, 109, 119, 0.60);
            background: #B5D5D8;
        }

        .indicator-text {
            font-weight: bold;
        }
        button{
            width: 300px;
            height: 62px;
            color: #FFF;
            background-color: rgba(0, 109, 119, 1); /* Change color as needed */
            text-align: center;
            font-family: Aleo, serif;
            font-size: 30px;
            border-radius: 10px;
            margin-right: 20px;
        }
    </style>
</head>
<body>
<div id='calendar'></div>
<!-- Toggle buttons -->

<div class="rectangle">
    <div class="left-section">
        <p>Date: January 1, 2023</p>
        <p>Day: Monday</p>
        <p>Time: 10:00 AM</p>
    </div>
    <div class="middle-section">
        <h2>Event Name</h2>
        <div>
            <p>Number of Tickets: 100</p>
        </div>
        <div>
            <p>Price: $10 per ticket</p>
        </div>
    </div>
    <div class="right-section">
        <input type="checkbox">
        <div>
            <span class="delete-icon">&#10006;</span>
        </div>
    </div>
</div>
<div class="bottom-section">
    <div class="checkbox-container">
        <div class="indicator paid">
            <div class="indicator-box"></div>
            <span class="indicator-text">Paid</span>
        </div>
        <div class="indicator unpaid">
            <div class="indicator-box"></div>
            <span class="indicator-text">Unpaid</span>
        </div>
    </div>
    <button>Checkout</button>
</div>

</body>
</html>


