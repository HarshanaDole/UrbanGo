<!DOCTYPE html>
<html>
<head>
	<title>Bus Ticket Booking</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container">
		<h1>Welcome to UrbanGo</h1>
        <form>
			<div class="form-group">
				<label for="from">From</label>
				<select id="from" name="from">
					<option value="">Select a city</option>
					<option value="chennai">Colombo</option>
					<option value="bangalore">Makumbura</option>
					<option value="hyderabad">Katunayake</option>
				</select>
			</div>
			<div class="form-group">
				<label for="to">To</label>
				<select id="to" name="to">
					<option value="">Select a city</option>
                    <option value="chennai">Colombo</option>
					<option value="bangalore">Makumbura</option>
					<option value="hyderabad">Katunayake</option>
				</select>
            </div>
            <div class="form-group">
				<label for="date">Date of Travel</label>
				<input type="date" id="date" name="date" required>
			</div>
		</form>
	</div>
	
	<?php include "components/bottom-nav-bar.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</body>
</html>
