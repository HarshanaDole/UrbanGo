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
        <h1>Payment Methods</h1>
        <p>Select the payment method you'd like to use.</p>
        <div class="cards">
            <div class="card">
                <ul class="payment-method">
                    <li>
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="mySwitch">Paypal</label>
                            <input class="form-check-input" type="checkbox" id="mySwitch" name="paypal-method" value="yes" checked>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="cards">
            <div class="card">
                <ul class="payment-method">
                    <li>
                    <div class="form-check form-switch">
                            <label class="form-check-label" for="mySwitch">Visa</label>
                            <input class="form-check-input" type="checkbox" id="mySwitch" name="visa-method" value="yes" checked>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="cards">
            <div class="card">
                <ul class="payment-method">
                    <li>
                    <div class="form-check form-switch">
                            <label class="form-check-label" for="mySwitch">Stripe</label>
                            <input class="form-check-input" type="checkbox" id="mySwitch" name="stripe-method" value="yes" checked>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="cards">
            <div class="card">
                <ul class="payment-method">
                    <li>
                    <div class="form-check form-switch">
                            <label class="form-check-label" for="mySwitch">GooglePay</label>
                            <input class="form-check-input" type="checkbox" id="mySwitch" name="google-method" value="yes" checked>
                        </div>
                    </li>
                </ul>
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