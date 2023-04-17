<!DOCTYPE html>
<html>
<head>
	<title>Bus Ticket Booking</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/cancel.css">
</head>
<body>
	<div class="container">
        <h1>Cancel Trip</h1>
        <p>Please select your reason for cancellation. </p>
        <div class="hero">
        <div class="checkbox-container">
            <div class="row">
                <p>Waiting for a long time</p>
                <label>
                    <input type="checkbox" checked="checked">
                    <span></span> 
                </label>
            </div>
            <div class="row">
                <p>Unable to make it in time</p>
                <label>
                    <input type="checkbox" checked="checked">
                    <span></span> 
                </label>
            </div>
            <div class="row">
                <p>Selected wrong destination</p>
                <label>
                    <input type="checkbox" checked="checked">
                    <span></span> 
                </label>
            </div>
            <div class="row">
                <p>The price is not reasonable</p>
                <label>
                    <input type="checkbox" checked="checked">
                    <span></span> 
                </label>
            </div>
            <div class="row">
                <p>Booking issue</p>
                <label>
                    <input type="checkbox" checked="checked">
                    <span></span> 
                </label>
            </div>
            <div class="row">
                <p>Other</p>
                <label>
                    <input type="checkbox" checked="checked">
                    <span></span> 
                </label>
            </div>
        </div>
        </div>
        <div class="button-container">
            <button class="button-submit">Submit</button>
        </div>
    </div>
	
	<?php include "components/bottom-nav-bar.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</body>
</html>
