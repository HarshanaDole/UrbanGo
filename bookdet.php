<!DOCTYPE html>
<html>
<head>
	<title>Bus Ticket Booking</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/bookdet.css">
</head>
<body>
	<div class="container">
        <h1>Booking Details</h1>
        <img class="pay-image" src="img/payment.png" width="170px" height="  210px">
        <div class="bookdet-card">
            <div class="line">
                <span class="text">Galle</span>
                <span class="to-text">to</span>
                <span class="text">Kottawa</span>  
            </div>
            <div class="line">
                <span class="text-label">Date</span>
                <span class="text">Jul 23, 2023</span>
            </div>
            <div class="line">
                <span class="text-label">Arrival</span>
                <span class="text">16.20</span>
            </div>
            <div class="line">
                <span class="text-label">Departure</span>
                <span class="text">15.00</span>
            </div>
            <div class="line">
                <span class="text-label">No. of Seats</span>
                <select class="seat-select">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="line">
                <span class="text-label">TOTAL</span>
                <span class="text">Rs. 3500</span>
            </div>
        </div>
        <div class="button-container">
            <button class="button-next">Next</button>
        </div>
    </div>
	
	<?php include "components/bottom-nav-bar.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</body>
</html>

