<?php

include 'components/dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

// Query the bookings table to check if any bookings exist for the current user ID
$bookingsExist = $database->getReference('bookings')
    ->orderByChild('user_id')
    ->equalTo($user_id)
    ->getSnapshot()
    ->exists();

if ($bookingsExist) {
    // Retrieve the bookings data
    $bookings = $database->getReference('bookings')
        ->orderByChild('user_id')
        ->equalTo($user_id)
        ->getSnapshot()
        ->getValue();

    usort($bookings, function ($a, $b) {
        return strtotime($b['booking_time']) - strtotime($a['booking_time']);
    });
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Trip History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
</head>

<body style="background-color:#434A57;">
    <div class="container">
        <h1 style="color:white;">Trip History</h1>
        <?php if (empty($bookings)) : ?>
            <p class="empty">No available buses found!</p>
        <?php else : ?>
            <form>
                <?php foreach ($bookings as $booking) : ?>
                    <?php if (empty($booking['bus']) || empty($booking['date']) || empty($booking['departure_time']) || empty($booking['arrival_time']) || empty($booking['total_cost'])) continue; ?>

                    <div class="form-group" style="width: 100%;">

                        <div class="boxxx" style="margin-bottom:16px; background-color: #33FF86;">
                            <table>
                                <tr>
                                    <td><label style=" font-size: 14px;">Bus No</label></td>
                                    <td><label style="font-weight: normal;  font-size: 14px;"><?= $booking['bus'] ?></label></td>
                                </tr>
                                <tr>
                                    <td><label style=" font-size: 14px;">Date</label></td>
                                    <td><label style="font-weight: normal;  font-size: 14px;"> <?= $booking['date'] ?></label></td>
                                </tr>
                                <tr>
                                    <td><label style=" font-size: 14px;">Time</label></td>
                                    <td><label style="font-weight: normal;  font-size: 14px;"> <?= $booking['departure_time'] ?> to <?= $booking['arrival_time'] ?></label></td>
                                </tr>
                                <tr>
                                    <td><label style=" font-size: 14px;">Amount</label></td>
                                    <td><label style="font-weight: normal;  font-size: 14px;"> <?= $booking['total_cost'] ?></label></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
            </form>
        <?php endif; ?>
    </div>

    <?php include "components/bottom-nav-bar.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</body>

</html>