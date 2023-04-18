<?php

include 'components/dbconfig.php';

session_start();

if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
} else {
	header('location:login.php');
	exit;
}

if (isset($_POST['search'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $date = $_POST['date'];

    // Query the database for trips that match the selected pickup, dropoff, and date
    $tripsRef = $database->getReference('trips');
    $query = $tripsRef->orderByChild('pickup')->equalTo($from)->getSnapshot()->getValue();
    $trips = array();
    foreach ($query as $key => $trip) {
        if ($trip['dropoff'] == $to && $trip['date'] == $date) {
            $trips[$key] = $trip;
        }
    }

    // Display the matching trips in a table
    if (count($trips) > 0) {
        echo '<table>';
        echo '<tr><th>Driver Name</th><th>Vehicle Number</th><th>Departure Time</th><th>Price</th></tr>';
        foreach ($trips as $trip) {
            echo '<tr>';
            echo '<td>' . $trip['driver'] . '</td>';
            echo '<td>' . $trip['vehicle'] . '</td>';
            echo '<td>' . $trip['time'] . '</td>';
            echo '<td>' . $trip['price'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No trips found.';
    }
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
		<form>
			<div class="form-group">
				<label for="from">From</label>
				<select id="from" name="from" onchange="updateDropOff(this.value)" required>
					<option value="">Select pickup</option>
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
				<label for="to">To</label>
				<select id="to" name="to" onchange="updateDate(document.getElementById('from').value, this.value)" required>
					<option value="">Select dropoff</option>
				</select>
			</div>
			<div class="form-group">
				<label for="date">Date</label>
				<select id="date" name="date" required>
					<option value="">Select date</option>
				</select>
			</div>
			<div class="form-group">
				<input type="submit" value="Search" class="btn" name="search">
			</div>
		</form>
	</div>

	<?php include "components/bottom-nav-bar.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-database.js"></script>
    <script src="js/firebase.js"></script>
    <script src="js/adminscript.js"></script>
    <script>
        function updateDropOff(selectedPickup) {
            var dropOffSelect = document.getElementById('to');
            dropOffSelect.innerHTML = '<option value="">Select dropoff</option>';
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
            dateSelect.innerHTML = "<option value=''>Select date</option>";
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