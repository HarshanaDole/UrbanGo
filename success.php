<?php
include 'components/dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

$trip_key = $_SESSION['trip_key'];
$bus = $_SESSION['bus'];
$pickup = $_SESSION['pickup'];
$dropoff = $_SESSION['dropoff'];
$date = $_SESSION['date'];
$available_seats = $_SESSION['available_seats'];
$no_of_seats = $_SESSION['no_of_seats'];
$departure_time = $_SESSION['departure_time'];
$arrival_time = $_SESSION['arrival_time'];
$booked_seats = $_SESSION['booked_seats'];
$fare = $_SESSION['fare'];
$total_cost = $_SESSION['total_cost'];

// update available seats in trips table
$tripRef = $database->getReference('trips/' . $trip_key);
$tripSnapshot = $tripRef->getValue();
$available_seats = $tripSnapshot['available_seats'];
$tripRef->update([
    'available_seats' => $available_seats - $booked_seats,
]);

// set timezone
date_default_timezone_set('Asia/Colombo');

// get current time in Sri Lanka
$current_time = date('Y-m-d H:i:s');

// store booking information in database
$BookingRef = $database->getReference('bookings');
$newbookingRef = $BookingRef->push();
$newbookingRef->set([
    'bus' => $bus,
    'pickup' => $pickup,
    'dropoff' => $dropoff,
    'date' => $date,
    'departure_time' => $departure_time,
    'arrival_time' => $arrival_time,
    'booking_time' => $current_time,
    'booked_seats' => $booked_seats,
    'fare' => $fare,
    'total_cost' => $total_cost,
    'user_id' => $user_id
]);

// clear booking information from session
unset($_SESSION['trip_key']);
unset($_SESSION['bus']);
unset($_SESSION['pickup']);
unset($_SESSION['dropoff']);
unset($_SESSION['date']);
unset($_SESSION['available_seats']);
unset($_SESSION['no_of_seats']);
unset($_SESSION['departure_time']);
unset($_SESSION['arrival_time']);
unset($_SESSION['booked_seats']);
unset($_SESSION['fare']);
unset($_SESSION['total_cost']);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Bus Ticket Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/receipt.css">
</head>

<body>
    <div class="container">
        <h1>e Ticket</h1>
        <div class="ticket-container">
            <img class="logo" src="img/logo.png" width="140px">
            <div class="price">
                <p>Total price</p>
                <h3>Rs. <?= $total_cost ?></h3>
            </div>
            <hr>
            <div class="line-1">
                <span class="first">Departure</span>
                <span class="first">From</span>
                <span class="first">Bus Number</span>
            </div>
            <div class="line-2">
                <span class="second"><?= date('M d', strtotime($date)) ?>, <?= $departure_time ?></span>
                <span class="second"><?= $pickup ?></span>
                <span class="second"><?= $bus ?></span>
            </div>
            <div class="line-1">
                <span class="first">Arrival</span>
                <span class="first">To</span>
                <span class="first">Seats</span>
            </div>
            <div class="line-2">
                <span class="second"><?= date('M d', strtotime($date)) ?>, <?= $arrival_time ?></span>
                <span class="second"><?= $dropoff ?></span>
                <span class="second"><?= $booked_seats ?></span>
            </div>
            <hr>
            <p class="message">Show this at the counter</p>
        </div>
        <div class="button-container">
            <button class="button-home" onclick="window.location.href='index.php'">Back to home</button>
        </div>
    </div>

    <?php include "components/bottom-nav-bar.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</body>

</html>