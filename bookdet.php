<?php

include 'components/dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
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
<html>

<head>
    <title>Bus Ticket Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/bookdet.css">
</head>

<body>
    <div class="container">
        <h1>Booking Details</h1>
        <img class="pay-image" src="img/payment.png" width="170px" height="  210px">
        <form action="components/stripe/public/checkout.php" method="post">
            <div class="bookdet-card">
                <?php
                $trip_key = $_POST['trip_key'];
                $bus_no = $_POST['bus_no'];
                $pickup = $_POST['pickup'];
                $dropoff = $_POST['dropoff'];
                $date = $_POST['date'];
                $available_seats = $_POST['available_seats'];
                $no_of_seats = $_POST['no_of_seats'];
                $departure_time = $_POST['departure_time'];
                $arrival_time = $_POST['arrival_time'];
                ?>
                <input type="hidden" name="trip_key" value="<?= $trip_key; ?>">
                <input type="hidden" name="pickup" value="<?= $pickup; ?>">
                <input type="hidden" name="dropoff" value="<?= $dropoff; ?>">
                <input type="hidden" name="date" value="<?= $date; ?>">
                <input type="hidden" name="bus_no" value="<?= $bus_no; ?>">
                <input type="hidden" name="available_seats" value="<?= $available_seats; ?>">
                <input type="hidden" name="no_of_seats" value="<?= $no_of_seats; ?>">
                <input type="hidden" name="departure_time" value="<?= $departure_time; ?>">
                <input type="hidden" name="arrival_time" value="<?= $arrival_time; ?>">
                <div class="line">
                    <span class="text"><?= $pickup ?></span>
                    <span class="to-text">to</span>
                    <span class="text"><?= $dropoff ?></span>
                </div>
                <div class="line">
                    <span class="text-label">Date</span>
                    <span class="text"><?= $date ?></span>
                </div>
                <div class="line">
                    <span class="text-label">Departure</span>
                    <span class="text"><?= $departure_time ?></span>
                </div>
                <div class="line">
                    <span class="text-label">Arrival</span>
                    <span class="text"><?= $arrival_time ?></span>
                </div>
                <div class="line">
                    <span class="text-label">No. of Seats</span>
                    <input class="seat-select" type="number" name="booked_seats" min="1" max="<?= $available_seats; ?>" value="1">
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
                <div class="line">
                    <span class="text-label">TOTAL</span>
                    <span class="text">Rs. <?= $fare ?></span>
                </div>
            </div>
            <div class="button-container">
                <button type="submit" class="button-next">Checkout</button>
            </div>
        </form>
    </div>

    <?php include "components/bottom-nav-bar.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</body>

</html>