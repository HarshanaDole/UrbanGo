<?php

include '../components/dbconfig.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}


if (isset($_POST['update_status'])) {
    $key = $_POST['session_key'];
    $ref = "sessions/" . $key;
    $sessionData = $database->getReference($ref)->getValue();
    $trip_status = $_POST['trip_status'];
    $bus = $sessionData['bus'];
    $available_seats = $sessionData['available_seats'];
    $no_of_seats = $sessionData['no_of_seats'];
    $pickup = $sessionData['pickup'];
    $dropoff = $sessionData['dropoff'];
    $deptime = $sessionData['departure_time(estimated)'];
    $arrtime = $sessionData['arrival_time(estimated)'];
    $date = $sessionData['date'];
    $realdeptime = $sessionData['departed_at'];
    date_default_timezone_set('Asia/Colombo');
    $realarrtime = date('H:i:s');

    // get the trip data from the database
    $sessionRef = $database->getReference('sessions/' . $key);
    $session = $sessionRef->getValue();

    if ($trip_status == 'completed') {
        $sessionRef->update([
            'bus' => $bus,
            'available_seats' => $available_seats,
            'no_of_seats' => $no_of_seats,
            'pickup' => $pickup,
            'dropoff' => $dropoff,
            'date' => $date,
            'departure_time(estimated)' => $deptime,
            'arrival_time(estimated)' => $arrtime,
            'departed_at' => $realdeptime,
            'arrived_at' => $realarrtime,
            'trip_status' => $trip_status
        ]);
    }

    header('Location: sessions.php');
    exit();
}

if (isset($_GET['delete'])) {
    $key = $_GET['delete'];
    $ref = $database->getReference('sessions/' . $key);
    $ref->remove();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>placed orders</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="../css/adminstyle.css">

</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="sessions">

        <h1 class="heading">started sessions</h1>

        <div class="box-container">

            <?php

            $ref = "sessions/";
            $fetch_sessions = $database->getReference($ref)->getValue();
            if (!empty($fetch_sessions)) {
                foreach ($fetch_sessions as $key => $sessionData) {

            ?>

                    <div class="box">
                        <p> <span><?= $sessionData['pickup']; ?> - <span><?= $sessionData['dropoff']; ?></span> </p>
                        <p> <span><?= $sessionData['departure_time(estimated)']; ?> - <?= $sessionData['arrival_time(estimated)']; ?></span> </p>
                        <p> date : <span><?= $sessionData['date']; ?></span> </p>
                        <p> bus : <span><?= $sessionData['bus']; ?></span> </p>
                        <p> seats : <span><?= $sessionData['available_seats']; ?>/<?= $sessionData['no_of_seats']; ?></span> </p>
                        <p> departed at : <span><?= $sessionData['departed_at']; ?></span> </p>
                        <p> arrived at : <span><?= $sessionData['arrived_at']; ?></span> </p>
                        <form action="" method="post">
                            <input type="hidden" name="session_key" value="<?= $key; ?>">
                            <select name="trip_status" class="select">
                                <option selected disabled><?= $sessionData['trip_status']; ?></option>
                                <option value="departed">departed</option>
                                <option value="completed">completed</option>
                            </select>
                            <div class="flex-btn">
                                <input type="submit" value="update" class="option-btn" name="update_status">
                                <a href="sessions.php?delete=<?= $key; ?>" class="delete-btn" onclick="return confirm('delete this session?');">delete</a>
                            </div>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no sessions started yet!</p>';
            }
            ?>

        </div>

    </section>

    </section>

    <script src="../js/adminscript.js"></script>

</body>

</html>