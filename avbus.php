<?php

include 'C:\xamppp\htdocs\UrbanGo\components\dbconfig.php';

if (isset($_POST['search_trips'])) {
	$pickup = $_POST['pickup'];
	$dropoff = $_POST['dropoff'];
	$date = $_POST['date'];

	$ref = "trips/";
	$fetch_trips = $database->getReference($ref)->getValue();

	$found_trips = array();
	foreach ($fetch_trips as $key => $row) {
		if ($row['pickup'] == $pickup && $row['dropoff'] == $dropoff && $row['date'] == $date) {
			$deptime = $row['departure_time'];
			// Get current time in Sri Lanka
			date_default_timezone_set('Asia/Colombo');
			$current_time = date("H:i");
			if (strtotime($deptime) > strtotime($current_time) || date('Y-m-d', strtotime($date)) > date('Y-m-d')) {
				$found_trips[$key] = $row;
			}
		}
	}

	if (!empty($found_trips)) {
		foreach ($found_trips as $key => $row) {
?>


<!DOCTYPE html>
<html>
<head>
	<title>Available Busses</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/avbus.css">
</head>
<body>
	<div class="container">
		<h1>Available Buses</h1>
            <form action="" method="post" encrypt="multipart/form-data">
				<input type="hidden" name="trip_key" value="<?= $key; ?>">
				<div class="bus-card">
                    <h3 class="bus-no-label">Bus Number :</h3>
                    <p class="bus-no"><?= $bus = $row['bus']; ?></p>
                    <h3 class="bus-remseats-label">Remaining Seats :</h3>
                    <p class="bus-remseats"><?= $available_seats = $row['available_seats']; ?>/<?= $no_of_seats = $row['no_of_seats']; ?></p>
                    <p class="time"><?= $deptime = $row['departure_time']; ?> - <?= $arrtime = $row['arrival_time']; ?></p>
                </div>
			</form>
<?php 
	}
} else {
		echo '<p class="empty">no available buses found!</p>';
	}
 } else {
		echo '<p class="empty">Please select a pickup, dropoff, and date to search for trips.</p>';
	}				
?>
	</div>
	
	<?php include "components/bottom-nav-bar.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</body>
</html>