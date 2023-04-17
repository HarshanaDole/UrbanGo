<!DOCTYPE html>
<html>
<head>
	<title>Bus Ticket Booking</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/receipt.css">
</head>
<body>
	<div class="container">
        <h1>e Ticket</h1>
        <div class="ticket-container">
            <img class="logo" src="img/logo.png" width="140px">
            <div class="price">
                <p>Ticket price</p>
                <h3>Rs. 2750</h3>
            </div>
            <hr>
            <div class="line-1">
                <span class="first">Departure</span>
                <span class="first">From</span>
                <span class="first">Bus Number</span>
            </div>
            <div class="line-2">
                <span class="second">Jul 23, 15:00</span>
                <span class="second">Kottawa</span>
                <span class="second">NW-6689</span>
            </div>
            <div class="line-1">
                <span class="first">Arrival</span>
                <span class="first">To</span>
                <span class="first">Seats</span>
            </div>
            <div class="line-2">
                <span class="second">Jul 23, 16:20</span>
                <span class="second">Galle</span>
                <span class="second">03</span>
            </div>
            <hr>
            <p class="message">Show this at the counter</p>
        </div>
        <div class="button-container">
            <button class="button-home">Back to home</button>
        </div>
    </div>
	
	<?php include "components/bottom-nav-bar.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</body>
</html>