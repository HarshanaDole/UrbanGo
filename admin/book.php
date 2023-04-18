<?php

include '../components/dbconfig.php';

session_start();

$admin_id = $_SESSION['admin_id'];


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
    $fare = $row['fare'];
    $total_cost = number_format($fare * $booked_seats, 2);
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
            'fare' => $fare,
            'total_cost' => $total_cost,
            'user_id' => 'N/A',
        ]);

        // update available seats in trips table
        $tripRef = $database->getReference('trips/' . $trip_key);
        $tripRef->update([
            'available_seats' => $available_seats - $booked_seats,
        ]);
        
        $message[] = 'booking added successfully!';
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="../css/adminstyle.css">

</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="add-buses">

        <h1 class="heading">add booking</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="flex">
                <div class="inputBox">
                    <span>Pick Up</span>
                    <select name="pickup" id="pickup" class="box" required onchange="updateDropOff(this.value)">
                        <option value="">-- select pickup --</option>
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
                <div class="inputBox">
                    <span>Drop Off</span>
                    <select name="dropoff" id="dropoff" class="box" required onchange="updateDate(document.getElementById('pickup').value, this.value)">
                        <option value="">-- select dropoff --</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Date</span>
                    <select name="date" id="date" class="box" required>
                        <option value="">-- select date --</option>
                    </select>
                </div>
            </div>

            <input type="submit" value="search trips" class="btn" name="search_trips">
        </form>

    </section>

    <section class="find-trips">

        <h1 class="heading">trips found</h1>

        <div class="box-container">

            <?php
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

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="box">
                                <input type="hidden" name="trip_key" value="<?= $key; ?>">
                                <div class="row">
                                    <div class="reg"><?= $pickup = $row['pickup']; ?> - <?= $dropoff = $row['dropoff']; ?></div>
                                </div><br>
                                <div class="row">
                                    <div class="reg"><?= $deptime = $row['departure_time']; ?> - <?= $arrtime = $row['arrival_time']; ?></div>
                                </div><br>
                                <div class="row">
                                    <span>Date :</span>
                                    <div class="reg"><?= $date = $row['date']; ?></div>
                                </div>
                                <div class="row">
                                    <span>Bus :</span>
                                    <div class="reg"><?= $bus = $row['bus']; ?></div>
                                </div>
                                <div class="row">
                                    <span>Available Seats :</span>
                                    <div class="seats"><?= $available_seats = $row['available_seats']; ?>/<?= $no_of_seats = $row['no_of_seats']; ?></div>
                                </div>
                                <?php
                                $routesRef = "routes/";
                                $fetch_routes = $database->getReference($routesRef)->getValue();
                                $fare = "";
                                foreach ($fetch_routes as $key => $row) {
                                    if (($row['start'] == $pickup && $row['end'] == $dropoff) || ($row['start'] == $dropoff && $row['end'] == $pickup)) {
                                        $fare = $row['fare'];
                                        break;
                                    }
                                }
                                ?>
                                <input type="hidden" name="route_key" value="<?= $key; ?>">
                                <div class="row">
                                    <span>Fare :</span>
                                    <div class="reg"><?= $fare; ?></div>
                                </div>
                                <div class="row">
                                    <span>Number of Seats :</span>
                                    <div class="qty">
                                        <input type="number" name="booked_seats" min="1" max="<?= $available_seats; ?>" value="1">
                                    </div>
                                </div>
                                <div class="flex-btn">
                                    <input type="submit" value="add booking" class="btn" name="add_booking" onclick="return confirm('add a new booking?');">
                                </div>
                            </div>
                        </form>

            <?php
                    }
                } else {
                    echo '<p class="empty">no trips found!</p>';
                }
            } else {
                echo '<p class="empty">Please select a pickup, dropoff, and date to search for trips.</p>';
            }
            ?>


        </div>

    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-database.js"></script>
    <script src="../js/firebase.js"></script>
    <script src="../js/adminscript.js"></script>
    <script>
        function updateDropOff(selectedPickup) {
            var dropOffSelect = document.getElementById('dropoff');
            dropOffSelect.innerHTML = '<option value="">-- select dropoff --</option>';
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
            dateSelect.innerHTML = "<option value=''>-- select date --</option>";
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