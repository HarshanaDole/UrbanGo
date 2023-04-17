<!DOCTYPE html>
<html>
<head>
	<title>Bus Ticket Booking</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/payment.css">
</head>
<body>
	<div class="container">
        <h1>Payment</h1>
        <div class="row">
            <div class="col-75">
                <div class="checkout-container">
                    <form action="">   
                        <div class="row">
                            <div class="col-50">
                                <h3>Billing Address</h3>
                                <label for="fname"><i class="fa fa-user"></li>Full Name</label>
                                <input type="text" id="fname" name="firstname" placeholder="Yasas R. Katudampe">
                                <label for="email"><i class="fa fa-envelope"></li>Email</label>
                                <input type="text" id="address" name="email" placeholder="Yasas@example.com">
                                <label for="Address"><i class="fa fa-address"></li>Address</label>
                                <input type="text" id="address" name="address" placeholder="125/B, Akarawita, Gampaha">
                                <label for="City"><i class="fa fa-institution"></li>City</label>
                                <input type="text" id="city" name="city" placeholder="Gampaha">

                                <div class="row">
                                    <div class="col-50">
                                        <label for="province">Province</label>
                                        <input type="text" id="province" name="province" placeholder="Western">
                                    </div>
                                    <div class="col-50">
                                        <label for="zip">Zip</label>
                                        <input type="zip" id="zip" name="zip" placeholder="20001">
                                    </div>
                                </div>
                            </div>
                            <div class="col-50">
                                <h3>Payment Details</h3>
                                <label for="fname">Accepted Cards</label>
                                <div class="icon-container">
                                    <i class="fa fa-cc-visa" style="color: navy"></li>
                                    <i class="fa fa-cc-amex" style="color: blue"></li>
                                    <i class="fa fa-cc-mastercard" style="color: red"></li>
                                    <i class="fa fa-cc-discover" style="color: orange"></li>
                                </div>
                                <label for="cname">Name on Card</label>
                                <input type="text" id="cname" name="cardname" placeholder="Yasas Randeepa Katudampe">
                                <label for="ccnum">Credit Card Number</label>
                                <input type="text" id="ccnum" name="ccnum" placeholder="1111-2222-3333-4444">
                                <label for="expmonth">Exp Month</label>
                                <input type="text" id="expmonth" name="expmonth" placeholder="April">
                                <div class="row">
                                    <div class="col-50">
                                        <label for="expyr">Exp Year</label>
                                        <input type="text" id="expyr" name="expyr" placeholder="2024">
                                    </div>
                                    <div class="col-50">
                                        <label for="cvv">CVV</label>
                                        <input type="text" id="cvv" name="cvv" placeholder="235">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="submit" value="Proceed" class="proc-btn">
                        <input type="cancel" value="Cancel" class="canc-btn">
                    </form>
                </div>
            </div>
        </div>
    </div>
	<?php include "components/bottom-nav-bar.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</body>
</html>
