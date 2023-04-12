<?php

include '../components/dbconfig.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

// update the trip data when the form is submitted
if (isset($_POST['update'])) {
    $key = $_POST['trip_key'];
    $pickup = $_POST['pickup'];
    $dropoff = $_POST['dropoff'];
    $bus = $_POST['bus'];
    $date = $_POST['date'];
    $deptime = $_POST['deptime'];
    $arrtime = $_POST['arrtime'];

    // get the trip data from the database
    $tripRef = $database->getReference('trips/' . $key);
    $trip = $tripRef->getValue();

    $tripRef->update([
        'pickup' => $pickup,
        'dropoff' => $dropoff,
        'bus' => $bus,
        'date' => $date,
        'departure_time' => $deptime,
        'arrival_time' => $arrtime,
    ]);

    header('Location: trips.php');
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update product</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="../css/adminstyle.css">

</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="update-bus">

        <h1 class="heading">update trip</h1>

        <?php
        // get the bus key from the URL
        $key = $_GET['update'];

        // get the bus data from Firebase using the key
        $tripRef = $database->getReference('trips/' . $key);
        $tripData = $tripRef->getValue();

        // set the form values with the current bus data
        $bus = $tripData['bus'];
        $pickup = $tripData['pickup'];
        $dropoff = $tripData['dropoff'];
        $date = $tripData['date'];
        $deptime = $tripData['departure_time'];
        $arrtime = $tripData['arrival_time'];

        // retrieve the route data from Firebase
        $busRef = $database->getReference('buses');
        $busSnapshot = $busRef->getValue();

        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="trip_key" value="<?= $key; ?>">
            <span>update pickup</span>
            <select name="pickup" id="pickup" class="box" required onchange="updateDropOff(this.value)">
                <option value="">-- select pickup --</option>
                <?php
                $routesRef = $database->getReference('routes');
                $routes = $routesRef->getValue();
                $pickupLocations = array();
                foreach ($routes as $route) {
                    if (!in_array($route['start'], $pickupLocations)) {
                        $selected = ($tripData['pickup'] == $route['start']) ? 'selected' : '';
                        echo '<option value="' . $route['start'] . '" ' . $selected . '>' . $route['start'] . '</option>';
                        $pickupLocations[] = $route['start'];
                    }
                    if (!in_array($route['end'], $pickupLocations)) {
                        $selected = ($tripData['pickup'] == $route['end']) ? 'selected' : '';
                        echo '<option value="' . $route['end'] . '" ' . $selected . '>' . $route['end'] . '</option>';
                        $pickupLocations[] = $route['end'];
                    }
                }
                ?>
            </select>
            <span>update dropoff</span>
            <select name="dropoff" id="dropoff" class="box" required onchange="updateBusReg(document.getElementById('pickup').value, this.value)">
                <?php
                $routesRef = $database->getReference('routes');
                $routes = $routesRef->getValue();
                $dropoffLocations = array();
                foreach ($routes as $route) {
                    if (!in_array($route['start'], $dropoffLocations)) {
                        $selected = ($tripData['dropoff'] == $route['start']) ? 'selected' : '';
                        echo '<option value="' . $route['start'] . '" ' . $selected . '>' . $route['start'] . '</option>';
                        $dropoffLocations[] = $route['start'];
                    }
                    if (!in_array($route['end'], $dropoffLocations)) {
                        $selected = ($tripData['dropoff'] == $route['end']) ? 'selected' : '';
                        echo '<option value="' . $route['end'] . '" ' . $selected . '>' . $route['end'] . '</option>';
                        $dropoffLocations[] = $route['end'];
                    }
                }
                ?>
            </select>
            <span>update bus</span>
            <select name="bus" required class="box">
                <?php
                // loop through the buses and create an option for each one
                foreach ($busSnapshot as $busKey => $busData) {
                    $selected = ($busData['registration_plate'] == $bus) ? 'selected' : '';
                    echo '<option value="' . $busData['registration_plate'] . '" ' . $selected . '>' . $busData['registration_plate'] . '</option>';
                }
                ?>
            </select>
            <span>update date</span>
            <input type="date" name="date" class="box" required value="<?= $tripData['date']; ?>">
            <span>update departure time</span>
            <input type="time" name="deptime" class="box" required value="<?= $tripData['departure_time']; ?>">
            <span>update arrival time</span>
            <input type="time" name="arrtime" class="box" required value="<?= $tripData['arrival_time']; ?>">
            <div class="flex-btn">
                <input type="submit" name="update" class="btn" value="update">
                <a href="trips.php" class="option-btn">go back</a>
            </div>
        </form>

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
                        });
                    }
                });
            });
        }
    </script>


</body>

</html>