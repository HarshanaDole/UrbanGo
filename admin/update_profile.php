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
   $station = $_POST['station'];

   $adminRef = $database->getReference('admins/' . $admin_id);

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $new_pass = sha1($_POST['new_pass']);
   $confirm_pass = sha1($_POST['confirm_pass']);

   $adminSnapshot = $adminRef->getSnapshot();
   $adminData = $adminSnapshot->getValue();
   $existing_pass = $adminData['password'];

   if ($old_pass == $empty_pass) {
      $message[] = 'please enter old password!';
   } elseif ($old_pass != $existing_pass) {
      $message[] = 'old password not matched!';
   } else {
      $adminRef->update(['name' => $name]);
      $adminRef->update(['username' => $username]);
      $adminRef->update(['contact_no' => $number]);
      $adminRef->update(['station' => $station]);
   }
   
   
   if ($new_pass != $confirm_pass) {
      $message[] = 'confirm password not matched!';
   } else {
      if ($new_pass != $empty_pass) {
         $adminRef->update(['password' => $confirm_pass]);
         $message[] = 'password updated successfully!';
      } else {
         $message[] = 'please enter a new password!';
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
   <title>update profile</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/adminstyle.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="form-container">

      <form action="" method="post">
         <h3>update profile</h3>
         <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
         <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" required placeholder="enter your name" maxlength="20" class="box">
         <input type="text" name="username" value="<?= $fetch_profile['username']; ?>" required placeholder="enter your username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="text" name="number" value="<?= $fetch_profile['contact_no']; ?>" required placeholder="enter your contact no." maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="old_pass" placeholder="enter old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
         <input type="password" name="new_pass" placeholder="enter new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="confirm_pass" placeholder="confirm new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <div class="inputBox">
            <select name="station" id="station" class="box" required>
               <option value="">-- select station --</option>
               <?php
               $routesRef = $database->getReference('routes');
               $routes = $routesRef->getValue();
               $stations = array();
               foreach ($routes as $route) {
                  if (!in_array($route['start'], $stations)) {
                     $selected = ($fetch_profile['station'] == $route['start']) ? 'selected' : '';
                     echo '<option value="' . $route['start'] . '" ' . $selected . '>' . $route['start'] . '</option>';
                     $stations[] = $route['start'];
                  }
                  if (!in_array($route['end'], $stations)) {
                     $selected = ($fetch_profile['station'] == $route['end']) ? 'selected' : '';
                     echo '<option value="' . $route['end'] . '" ' . $selected . '>' . $route['end'] . '</option>';
                     $stations[] = $route['end'];
                  }
               }
               ?>
            </select>
         </div>
         <input type="submit" value="update now" class="btn" name="submit">
      </form>

   </section>


   <script src="../js/adminscript.js"></script>

</body>

</html>