<?php

include '../components/dbconfig.php';

session_start();

if(isset($_POST['submit'])){

   $username = $_POST['username'];
   $pass = sha1($_POST['pass']);

   $adminRef = $database->getReference('admins')->orderByChild('username')->equalTo($username);
   $adminSnapshot = $adminRef->getSnapshot();
   $admin = null;
   foreach ($adminSnapshot->getValue() as $key => $value) {
       $admin = $value;
       break;
   }

   if($admin && $admin['password'] == $pass){
      $admin_id = array_keys($adminSnapshot->getValue())[0]; // get the push id of the first matched admin
      $_SESSION['admin_id'] = $admin_id;
      header('location:dashboard.php');
   }else{
      $message[] = 'incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/adminstyle.css">

</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<section class="form-container">

   <form action="" method="POST">
      <h3>login now</h3>
      <p>default username = <span>admin</span> & password = <span>123</span></p>
      <input type="text" name="username" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" class="btn" name="submit">
   </form>

</section>
   
</body>
</html>