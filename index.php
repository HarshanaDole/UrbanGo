<?php

include 'C:\xamppp\htdocs\UrbanGo\components\dbconfig.php';


if (isset($_POST['add_booking'])) {
    $trip_key = $_POST['trip_key'];
    $ref = "trips/" . $trip_key;
    $row = $database->getReference($ref)->getValue();
    $pickup = $row['pickup'];
    $dropoff = $row['dropoff'];
    $deptime = $row['departure_time'];
    $arrtime = $row['arrival_time'];
    $bus = $row['bus'];
    $date = $row['date'];
    $no_of_seats = $row['no_of_seats'];
    $available_seats = $row['available_seats'];
    $booked_seats = $_POST['booked_seats'];
    $route_key = $_POST['route_key'];
    $ref = "routes/" . $route_key;
    $row = $database->getReference($ref)->getValue();
    // set timezone to Sri Lanka
    date_default_timezone_set('Asia/Colombo');

    // get current time in Sri Lanka
    $current_time = date('H:i:s');

    $BookingRef = $database->getReference('bookings');
    $bookingSnapshot = $BookingRef->getValue();

    $seatsExceeded = false;
    foreach ($bookingSnapshot as $key => $booking) {
        if ($booking['booked_seats'] > $available_seats) {
            $seatsExceeded = true;
            break;
        }
    }

    if ($seatsExceeded) {
        $message[] = 'not enough seats available. please refresh!';
    } else {
        $newbookingRef = $BookingRef->push();
        $newbookingRef->set([
            'bus' => $bus,
            'pickup' => $pickup,
            'dropoff' => $dropoff,
            'date' => $date,
            'departure_time' => $deptime,
            'arrival_time' => $arrtime,
            'booking_time' => $current_time,
            'booked_seats' => $booked_seats,
            'user_id' => 'N/A',
        ]);
    }

	header("Location: avbus.php?pickup=$pickup&dropoff=$dropoff&date=$date");
    exit();
}
?>

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
		<?php if(isset($error)) { ?>
        <div class="error-message"><?php echo $error; ?></div>
        <?php } ?>
        <form action="avbus.php" name="search" method="POST" encrypt="multipart/form-data">
			<div class="form-group">
				<label for="pickup">From</label>
				<select id="pickup" name="pickup" required onchange="updateDropOff(this.value)">
					<option value="">Select a city</option>
					<?php
					$routesRef = $database->getReference('routes');
					$routes = $routesRef->getValue();
					$pickupLocations = array();
					foreach ($routes as $route) {
						if (!in_array($route['start'], $pickupLocations)) {
							echo '<option value="' . $route['start'] . '">' . $route['start'] . '</option>';
							$pickupLocations[] = $route['start'];
						}
						if (!in_array($route['end'], $pickupLocations)) {
							echo '<option value="' . $route['end'] . '">' . $route['end'] . '</option>';
							$pickupLocations[] = $route['end'];
						}
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="dropoff">To</label>
				<select id="dropoff" name="dropoff" required onchange="updateDate(document.getElementById('pickup').value, this.value)">
                    <option value="">Select a city</option>
                 </select>
            </div>
            <div class="form-group">
				<label for="date">Date</label>
				<select id="date" name="date" required>
					<option value="">Select a date</option>
				</select>
            </div>
			<div class="button-container">
			    <a href="avbus.php"></a>
                <input class="button-next" type="submit" name="search" value="Search">
            </div>
		</form>
	</div>
	
	<?php include "components/bottom-nav-bar.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
	<script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-database.js"></script>
	<script src="js/firebase.js"></script>
	<script>
		function updateDropOff(selectedPickup) {
            var dropOffSelect = document.getElementById('dropoff');
			if (!dropOffSelect) {
				return
			}
            dropOffSelect.innerHTML = '<option value="">Select a city</option>';
            var routesRef = firebase.database().ref('routes');
            routesRef.on('value', function(snapshot) {
                snapshot.forEach(function(routeSnapshot) {
                    var route = routeSnapshot.val();
                    if (route.start == selectedPickup) {
                        var option = document.createElement('option');
                        option.value = route.end;
                        option.text = route.end;
                        dropOffSelect.add(option);
                    } else if (route.end == selectedPickup) {
                        var option = document.createElement('option');
                        option.value = route.start;
                        option.text = route.start;
                        dropOffSelect.add(option);
                    }
                });
            });
        }

		var addedDates = []; // keep track of dates that have been added to the dropdown

        function updateDate(pickup, dropoff) {
            var dateSelect = document.getElementById("date");
            dateSelect.innerHTML = '<option value="">Select a date</option>';
            addedDates = []; // reset added dates array

            // Get current date at midnight in Sri Lankan time
            var today = new Date();
            today.setHours(0, 0, 0, 0);
            today.setUTCHours(today.getUTCHours() + 5.5); // UTC+5.5 is the timezone offset for Sri Lanka

            if (pickup !== "" && dropoff !== "") {
                var tripsRef = firebase.database().ref("trips");
                tripsRef.orderByChild("pickup").equalTo(pickup).on("child_added", function(tripSnapshot) {
                    var trip = tripSnapshot.val();
                    if (trip.dropoff === dropoff) {
                        // check if date has already been added and if it's not in the past
                        if (!addedDates.includes(trip.date) && new Date(trip.date) >= today) {
                            var option = document.createElement("option");
                            option.value = trip.date;
                            option.text = trip.date;
                            dateSelect.appendChild(option);
                            addedDates.push(trip.date); // add date to added dates array
                        }
                    }
                });
            }
        }
	</script>
</body>
</html>
