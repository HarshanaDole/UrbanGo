<?php

include '../components/dbconfig.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}


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
    foreach ($bookingSnapshot as $key => $row) {
        if ($row['booked_seats'] > $available_seats) {
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
        $message[] = 'booking added successfully!';
    }
}

if (isset($_GET['delete'])) {
    $key = $_GET['delete'];
    $ref = $database->getReference('bookings/' . $key);
    $ref->remove();
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

    <section class="find-trips">

        <h1 class="heading">see bookings</h1>

        <div class="box-container">

            <?php

            $ref = "bookings/";
            $fetch_bookings = $database->getReference($ref)->getValue();

            $found_bookings = array();
            foreach ($fetch_bookings as $key => $row) {
                $found_bookings[$key] = $row;
            }

            if (!empty($found_bookings)) {
                foreach ($found_bookings as $key => $row) {
                    if (empty($row['bus']) || empty($row['date']) || empty($row['departure_time']) || empty($row['arrival_time']) || empty($row['total_cost'])) continue;
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
                                <span>Fare :</span>
                                <div class="reg"><?= $fare = $row['fare']; ?></div>
                            </div>
                            <div class="row">
                                <span>Number of Seats :</span>
                                <div class="reg"><?= $booked_seats = $row['booked_seats']; ?></div>
                            </div>
                            <div class="row">
                                <span>Total Cost :</span>
                                <div class="reg"><?= $total_cost = $row['total_cost']; ?></div>
                            </div>
                            <div class="row">
                                <span>Booked at :</span>
                                <div class="reg"><?= $booking_time = $row['booking_time']; ?></div>
                            </div>
                            <div class="row">
                                <span>User ID :</span>
                                <div class="reg"><?= $user_id = $row['user_id']; ?></div>
                            </div>
                            <div class="flex-btn row">
                                <a href="see_bookings.php?delete=<?= $key; ?>" class="delete-btn" onclick="return confirm('delete this booking?');">delete</a>
                            </div>
                        </div>
                    </form>

            <?php
                }
            } else {
                echo '<p class="empty">no bookings found!</p>';
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