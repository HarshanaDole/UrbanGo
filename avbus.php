<?php

include 'components/dbconfig.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('location:login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted form data
    $from = $_POST['from'];
    $to = $_POST['to'];
    $date = $_POST['date'];

}

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
        <?php
        $from = $_POST['from'];
        $to = $_POST['to'];
        $date = $_POST['date'];

        $ref = "trips/";
        $fetch_trips = $database->getReference($ref)->getValue();

        foreach ($fetch_trips as $key => $row) {
            if ($row['pickup'] == $from && $row['dropoff'] == $to && $row['date'] == $date) {
                $deptime = $row['departure_time'];
                // Get current time in Sri Lanka
                date_default_timezone_set('Asia/Colombo');
                $current_time = date("H:i");
                if (strtotime($deptime) > strtotime($current_time) || date('Y-m-d', strtotime($date)) > date('Y-m-d')) {
                    $found_trips[$key] = $row;
                }
            }
        }
        ?>
        <?php if (count($found_trips) > 0) : ?>
            <?php foreach ($found_trips as $key => $row) :
                $available_seats = $database->getReference('trips/' . $key . '/available_seats')->getValue();
            ?>
                <form id="form-<?= $key ?>" action="bookdet.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="trip_key" value="<?= $key ?>">
                    <input type="hidden" name="pickup" value="<?= $pickup = $row['pickup']; ?>">
                    <input type="hidden" name="dropoff" value="<?= $dropoff = $row['dropoff']; ?>">
                    <input type="hidden" name="date" value="<?= $date = $row['date']; ?>">
                    <input type="hidden" name="bus_no" value="<?= $bus = $row['bus']; ?>">
                    <input type="hidden" name="available_seats" value="<?= $available_seats = $row['available_seats']; ?>">
                    <input type="hidden" name="no_of_seats" value="<?= $no_of_seats = $row['no_of_seats']; ?>">
                    <input type="hidden" name="departure_time" value="<?= $deptime = $row['departure_time']; ?>">
                    <input type="hidden" name="arrival_time" value="<?= $arrtime = $row['arrival_time']; ?>">
                    <div class="bus-card" onclick="submitForm(document.getElementById('form-<?= $key ?>'))">
                        <h3 class="bus-no-label">Bus Number :</h3>
                        <p class="bus-no"><?= $bus = $row['bus']; ?></p>
                        <h3 class="bus-remseats-label">Remaining Seats :</h3>
                        <p class="bus-remseats"><?= $available_seats = $row['available_seats']; ?>/<?= $no_of_seats = $row['no_of_seats']; ?></p>
                        <p class="time"><?= $deptime = $row['departure_time']; ?> - <?= $arrtime = $row['arrival_time']; ?></p>
                    </div>
                </form>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="empty">No available buses found!</p>
        <?php endif; ?>
    </div>


    <?php include "components/bottom-nav-bar.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

    <script>
        function submitForm(form) {
            form.submit();
        }
    </script>

</body>

</html>