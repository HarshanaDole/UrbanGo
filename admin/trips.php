<?php

include '../components/dbconfig.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['add_trip'])) {

    $reg = $_POST['reg'];
    $pickup = $_POST['pickup'];
    $dropoff = $_POST['dropoff'];
    $deptime = $_POST['deptime'];
    $arrtime = $_POST['arrtime'];
    $date = $_POST['date'];
    $no_of_seats = $_POST['no_of_seats'];

    $TripRef = $database->getReference('trips');
    $tripSnapshot = $TripRef->getValue();

    $tripExists = false;
    foreach ($tripSnapshot as $key => $trip) {
        if (($trip['bus'] == $reg) && ($trip['departure_time'] == $deptime) && ($trip['date'] == $date)) {
            $tripExists = true;
            break;
        }
    }

    if ($tripExists) {
        $message[] = 'trip already exist!';
    } else {
        $newtripRef = $TripRef->push();
        $newtripRef->set([
            'bus' => $reg,
            'pickup' => $pickup,
            'dropoff' => $dropoff,
            'date' => $date,
            'departure_time' => $deptime,
            'arrival_time' => $arrtime,
            'available_seats' => $no_of_seats,
            'no_of_seats' => $no_of_seats
        ]);
        $message[] = 'new trip registered successfully!';
    }
}

if (isset($_GET['delete'])) {
    $key = $_GET['delete'];
    $ref = $database->getReference('trips/' . $key);
    $ref->remove();
}

if (isset($_POST['start_session'])) {
    $key = $_POST['key'];
    $ref = "trips/" . $key;
    $row = $database->getReference($ref)->getValue();
    $pickup = $row['pickup'];
    $dropoff = $row['dropoff'];
    $deptime = $row['departure_time'];
    $arrtime = $row['arrival_time'];
    $bus = $row['bus'];
    $date = $row['date'];
    $no_of_seats = $row['no_of_seats'];
    $available_seats = $row['available_seats'];
    // set timezone to Sri Lanka
    date_default_timezone_set('Asia/Colombo');

    // get current time in Sri Lanka
    $current_time = date('H:i:s');

    $SessionRef = $database->getReference('sessions');
    $sessionSnapshot = $SessionRef->getValue();

    $sessionExists = false;
    foreach ($sessionSnapshot as $key => $session) {
        if (($session['bus'] == $bus) && ($session['pickup'] == $pickup) && ($session['dropoff'] == $dropoff) && ($session['date'] == $date) && ($session['departure_time(estimated)'] == $deptime)) {
            $sessionExists = true;
            break;
        }
    }

    if ($sessionExists) {
        $message[] = 'session already exist!';
    } else {
        $newsessionRef = $SessionRef->push();
        $newsessionRef->set([
            'bus' => $bus,
            'pickup' => $pickup,
            'dropoff' => $dropoff,
            'date' => $date,
            'departure_time(estimated)' => $deptime,
            'arrival_time(estimated)' => $arrtime,
            'departed_at' => $current_time,
            'available_seats' => $available_seats,
            'no_of_seats' => $no_of_seats,
            'arrived_at' => '--',
            'trip_status' => 'departed'
        ]);
        $message[] = 'session started successfully!';
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

        <h1 class="heading">assign trips</h1>

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
                    <select name="dropoff" id="dropoff" class="box" required onchange="updateBusReg(document.getElementById('pickup').value, this.value)">
                        <option value="">-- select dropoff --</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Bus Reg. Plate</span>
                    <select name="reg" id="reg" class="box" required>
                        <option value="">-- select bus --</option>
                    </select>
                </div>
                <input type="hidden" id="seats" name="no_of_seats">
                <div class="inputBox">
                    <span>Date</span>
                    <input type="date" name="date" class="box" required>
                </div>
                <div class="inputBox">
                    <span>Departure Time</span>
                    <input type="time" name="deptime" class="box" required>
                </div>
                <div class="inputBox">
                    <span>Arrival Time</span>
                    <input type="time" name="arrtime" class="box" required>
                </div>
            </div>

            <input type="submit" value="add trip" class="btn" name="add_trip">
        </form>

    </section>

    <section class="show-sessions">

        <h1 class="heading">trips added</h1>

        <div class="box-container">

            <?php
            $ref = "trips/";
            $fetch_trips = $database->getReference($ref)->getValue();
            if (!empty($fetch_trips)) {
                foreach ($fetch_trips as $key => $row) {


            ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="box">
                            <input type="hidden" name="key" value="<?= $key; ?>">
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
                                <span>Seats :</span>
                                <div class="seats"><?= $available_seats = $row['available_seats']; ?>/<?= $no_of_seats = $row['no_of_seats']; ?></div>
                            </div>
                            <div class="flex-btn">
                                <input type="submit" value="start session" class="btn" name="start_session" onclick="return confirm('start session now?');">
                            </div>
                            <div class="flex-btn row">
                                <a href="update_trip.php?update=<?= $key; ?>" class="option-btn">update</a>
                                <a href="trips.php?delete=<?= $key; ?>" class="delete-btn" onclick="return confirm('delete this trip?');">delete</a>
                            </div>

                        </div>
                    </form>
            <?php
                }
            } else {
                echo '<p class="empty">no trips added yet!</p>';
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

        function updateBusReg(selectedPickup, selectedDropoff) {
            var selectedRoute = "";
            var routesRef = firebase.database().ref('routes');
            routesRef.on('value', function(snapshot) {
                snapshot.forEach(function(routeSnapshot) {
                    var route = routeSnapshot.val();
                    if ((route.start == selectedPickup && route.end == selectedDropoff) || (route.end == selectedPickup && route.start == selectedDropoff)) {
                        selectedRoute = route.routeno;

                        // Get buses for the selected route
                        var busesRef = firebase.database().ref('buses');
                        busesRef.orderByChild('route').equalTo(selectedRoute).on('value', function(snapshot) {
                            var buses = [];
                            snapshot.forEach(function(busSnapshot) {
                                var bus = busSnapshot.val();
                                if (bus.route == selectedRoute && buses.indexOf(bus.registration_plate) === -1) {
                                    buses.push(bus.registration_plate);
                                }
                            });

                            // Update bus registration numbers select
                            var busSelect = document.getElementById('reg');
                            busSelect.innerHTML = '<option value="">-- select bus --</option>';
                            buses.forEach(function(bus) {
                                var option = document.createElement('option');
                                option.value = bus;
                                option.text = bus;
                                busSelect.add(option);
                            });

                            // Add event listener for bus registration number select
                            busSelect.addEventListener('change', function() {
                                var selectedBusReg = this.value;
                                var selectedBusNoOfSeats = 0;
                                snapshot.forEach(function(busSnapshot) {
                                    var bus = busSnapshot.val();
                                    if (bus.registration_plate == selectedBusReg) {
                                        selectedBusNoOfSeats = bus.no_of_seats;
                                    }
                                });
                                var seatsInput = document.getElementById('seats');
                                seatsInput.setAttribute('value', selectedBusNoOfSeats);
                            });
                        });
                    }
                });
            });
        }
    </script>

</body>

</html>