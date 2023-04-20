<?php

include '../../dbconfig.php';
include '../stripe-php/init.php';
//require_once '../vendor/autoload.php';
require_once '../secrets.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost/UrbanGo/components/stripe/public/';

// Retrieve the values of the hidden input fields
$trip_key = $_POST['trip_key'];
$bus = $_POST['bus_no'];
$pickup = $_POST['pickup'];
$dropoff = $_POST['dropoff'];
$date = $_POST['date'];
$available_seats = $_POST['available_seats'];
$no_of_seats = $_POST['no_of_seats'];
$departure_time = $_POST['departure_time'];
$arrival_time = $_POST['arrival_time'];
$booked_seats = $_POST['booked_seats'];

$routesRef = "routes/";
$fetch_routes = $database->getReference($routesRef)->getValue();
$fare = "";
foreach ($fetch_routes as $key => $row) {
    if (($row['start'] == $pickup && $row['end'] == $dropoff) || ($row['start'] == $dropoff && $row['end'] == $pickup)) {
        $fare = $row['fare'];
        break;
    }
}

$total_cost = number_format($fare * $booked_seats, 2);

// Construct the line_items parameter
$line_items = [[
    'price_data' => [
        'currency' => 'LKR',
        'unit_amount' => $fare * 100, // Stripe requires the amount to be in paise
        'product_data' => [
            'name' => 'Ticket for ' . $pickup . ' to ' . $dropoff,
        ],
    ],
    'quantity' => $_POST['booked_seats'],
]];

$checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => $line_items,
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/success.html',
  'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);

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
        'departure_time' => $departure_time,
        'arrival_time' => $arrival_time,
        'booking_time' => $current_time,
        'booked_seats' => $booked_seats,
        'fare' => $fare,
        'total_cost' => $total_cost,
        'user_id' => $user_id
    ]);

    // update available seats in trips table
    $tripRef = $database->getReference('trips/' . $trip_key);
    $tripRef->update([
        'available_seats' => $available_seats - $booked_seats,
    ]);

}
?>
