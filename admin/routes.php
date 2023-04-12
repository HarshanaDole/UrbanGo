<?php

include '../components/dbconfig.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>routes</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/adminstyle.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="routes">

      <h1 class="heading">available routes</h1>

      <div class="box-container">

         <?php
         $ref = "routes/";
         $fetch_routes = $database->getReference($ref)->getValue();

         foreach ($fetch_routes as $key => $row) {

         ?>

            <div class="box">
               <p> starting location : <span><?php echo $row['start']; ?></span> </p>
               <p> ending location : <span><?php echo $row['end']; ?></span> </p>
               <p> route number : <span><?php echo $row['routeno']; ?></span> </p>
               <p> fare : <span>Rs. <?php echo $row['fare']; ?>/-</span> </p>
            </div>

         <?php

         }
         ?>


      </div>

   </section>


   <script src="../js/adminscript.js"></script>

</body>

</html>