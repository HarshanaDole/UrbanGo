<!DOCTYPE html>
<html>
<head>
	<title>Bus Ticket Booking</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/notifi.css">
</head>
<body>
	<div class="container">
        <h1>Notifications</h1>
        <div class="noti">
            <div class="not">
            <h2>Today</h2>
            <div class="first-card">
                <div class="icon-not">
                     <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="card-text">
                    <p>Your bus will be arrived in 30 minutes.</p>
                </div>     
            </div>
            <div class="first-card">
                <div class="icon-not">
                    <i class="far fa-credit-card"></i>
                </div>
                <div class="card-text">
                    <p>You have made the payment successfully.</p>
                </div>
            </div>
            </div>
            <div class="not">
            <h2>Yesterday</h2> 
            <div class="first-card">
                <div class="icon-not">
                     <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="card-text">
                    <p>Your bus will be arrived in 30 minutes.</p>
                </div> 
            </div>
            <div class="first-card">
                <div class="icon-not">
                    <i class="far fa-credit-card"></i>
                </div>
                <div class="card-text">
                    <p>You have made the payment successfully.</p>
                </div>
            </div>
        </div>
    </div>
    </div>
	
	<?php include "components/bottom-nav-bar.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</body>
</html>