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
$_SESSION['trip_key'] = $_POST['trip_key'];
$_SESSION['bus'] = $_POST['bus_no'];
$_SESSION['pickup'] = $_POST['pickup'];
$_SESSION['dropoff'] = $_POST['dropoff'];
$_SESSION['date'] = $_POST['date'];
$_SESSION['available_seats'] = $_POST['available_seats'];
$_SESSION['no_of_seats'] = $_POST['no_of_seats'];
$_SESSION['departure_time'] = $_POST['departure_time'];
$_SESSION['arrival_time'] = $_POST['arrival_time'];
$_SESSION['booked_seats'] = $_POST['booked_seats'];


$routesRef = "routes/";
$fetch_routes = $database->getReference($routesRef)->getValue();
$_SESSION['fare'] = "";
foreach ($fetch_routes as $key => $row) {
    if (($row['start'] == $_SESSION['pickup'] && $row['end'] == $_SESSION['dropoff']) || ($row['start'] == $_SESSION['dropoff'] && $row['end'] == $_SESSION['pickup'])) {
        $_SESSION['fare'] = $row['fare'];
        break;
    }
}

$_SESSION['total_cost'] = number_format($_SESSION['fare'] * $_SESSION['booked_seats'], 2);

// Construct the line_items parameter
$line_items = [[
    'price_data' => [
        'currency' => 'LKR',
        'unit_amount' => $_SESSION['fare'] * 100, // Stripe requires the amount to be in paise
        'product_data' => [
            'name' => 'Ticket for ' . $_SESSION['pickup'] . ' to ' . $_SESSION['dropoff'],
        ],
    ],
    'quantity' => $_SESSION['booked_seats'],
]];

$checkout_session = \Stripe\Checkout\Session::create([
    'line_items' => $line_items,
    'mode' => 'payment',
    'success_url' => 'http://localhost/UrbanGo/success.php',
    'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
