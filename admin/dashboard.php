<?php

include '../components/dbconfig.php';

session_start();

if (isset($_SESSION['admin_id'])) {
   $admin_id = $_SESSION['admin_id'];
} else {
   header('location:admin_login.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/adminstyle.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="dashboard">

      <h1 class="heading">dashboard</h1>

      <div class="box-container">

         <div class="box">
            <?php
            $busesRef = $database->getReference('buses');
            $busesData = $busesRef->getValue();
            $numBuses = count($busesData);
            ?>
            <h3><?= $numBuses ?></h3>
            <p>buses added</p>
            <a href="buses.php" class="btn">see buses</a>
         </div>

         <div class="box">
            <?php
            $tripsRef = $database->getReference('trips');
            $tripData = $tripsRef->getValue();
            $numtrips = count($tripData);
            ?>
            <h3><?= $numtrips ?></h3>
            <p>trips assigned</p>
            <a href="trips.php" class="btn">see trips</a>
         </div>

         <div class="box">
            <?php
            $sessionsRef = $database->getReference('sessions');
            $sessionData = $sessionsRef->getValue();
            $numsessions = count($sessionData);
            ?>
            <h3><?= $numsessions ?></h3>
            <p>ongoing sessions</p>
            <a href="sessions.php" class="btn">see sessions</a>
         </div>

         <div class="box">
            <?php
            $routesRef = $database->getReference('routes');
            $routeData = $routesRef->getValue();
            $numroutes = count($routeData);
            ?>
            <h3><?= $numroutes ?></h3>
            <p>routes & fares</p>
            <a href="routes.php" class="btn">see routes</a>
         </div>

         <div class="box">
            <?php
            $bookingsRef = $database->getReference('bookings');
            $bookingData = $bookingsRef->getValue();
            $numbookings = count($bookingData);
            ?>
            <h3><?= $numbookings ?></h3>
            <p>bookings added</p>
            <a href="see_bookings.php" class="btn">see bookings</a>
         </div>

         <div class="box">
            <h3>54</h3>
            <p>feedback recieved</p>
            <a href="" class="btn">see feedback</a>
         </div>

         <div class="box">
            <h3>69</h3>
            <p>users registered</p>
            <a href="" class="btn">see users</a>
         </div>

         <div class="box">
            <?php
            $adminsRef = $database->getReference('admins');
            $adminData = $adminsRef->getValue();
            $numadmins = count($adminData);
            ?>
            <h3><?= $numadmins ?></h3>
            <p>admins registered</p>
            <a href="" class="btn">see admins</a>
         </div>
      </div>

   </section>












   <script src="../js/adminscript.js"></script>

</body>

</html>