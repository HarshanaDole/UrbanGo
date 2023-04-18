<?php

include '../components/dbconfig.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $username = $_POST['username'];
   $number = $_POST['number'];
   $pass = sha1($_POST['pass']);
   $cpass = sha1($_POST['cpass']);
   $station = $_POST['station'];

   $adminsRef = $database->getReference('admins');
   $adminsSnapshot = $adminsRef->getValue();

   $adminExists = false;
   if (is_array($adminsSnapshot)) {
      foreach ($adminsSnapshot as $key => $admin) {
         if (array_key_exists('username', $admin) && $admin['username'] == $username) {
            $adminExists = true;
            break;
         }
      }
   }

   if ($adminExists) {
      $message[] = 'username already exist!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'confirm password not matched!';
      } else {
         $newAdminRef = $adminsRef->push();
         $newAdminRef->set([
            'name' => $name,
            'username' => $username,
            'password' => $cpass,
            'contact_no' => $number,
            'station' => $station
         ]);
         $message[] = 'new admin registered successfully!';
      }
   }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register admin</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/adminstyle.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="form-container">

      <form action="" method="post">
         <h3>register now</h3>
         <input type="text" name="name" required placeholder="enter your name(e.g. Harshana Dole)" maxlength="50" class="box">
         <input type="text" name="username" required placeholder="enter your username(e.g. Haru)" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="text" name="number" placeholder="enter your mobile number" class="box" maxlength="10" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
         <input type="password" name="pass" required placeholder="enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <div class="inputBox">
            <select name="station" id="station" class="box" required>
               <option value="">-- select station --</option>
               <?php
               $routesRef = $database->getReference('routes');
               $routes = $routesRef->getValue();
               $pickupLocations = array();
               foreach ($routes as $route) {
                  if (!in_array($route['start'], $pickupLocations)) {
                     echo '<option value="' . $route['start'] . '">' . $route['start'] . '</option>';
                     $pickupLocations[] = $route['start'];
                  }
                  if (!in_array($route['end'], $pickupLocations)) {
                     echo '<option value="' . $route['end'] . '">' . $route['end'] . '</option>';
                     $pickupLocations[] = $route['end'];
                  }
               }
               ?>
            </select>
         </div>
         <input type="submit" value="register now" class="btn" name="submit">
      </form>

   </section>


   <script src="../js/adminscript.js"></script>

</body>

</html>