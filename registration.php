<?php

include 'C:\xamppp\htdocs\UrbanGo\components\dbconfig.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $data = [
      'name' => $name,
      'phone' => $number,
      'email' => $email,
      'password' => $pass
   ];

   $ref = "users/";
   $postdata = $database->getReference($ref)->push($data);

   if($postdata){
      header("location: index.php");
   }else{
      $message[] = 'failed';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="container">
		<h1>Signup</h1>
		<form method="post">
			<div class="form-group">
                <input type="text" name="name" required placeholder="enter your username" maxlength="20"  class="box">
			</div>
         <div class="form-group">
            <input type="text" name="number" placeholder="enter your mobile number" class="box" onkeypress="if(this.value.length == 25) return false;" pattern="^[0-9\+]+$" required>
			</div>
			<div class="form-group">
                <input type="email" name="email" required placeholder="enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
			</div>
			<div class="form-group">
                <input type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
			</div>
         <div class="form-group">
                <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
			</div>
			<div class="form-group">
                <input type="submit" value="Register Now" class="btn" name="submit">
			</div>
            <div class="form-group">
                <p>already have an account?<a href="login.php" class="option-btn">Login</a></p>               
			</div>
		</form>
</div>

<script src="js/script.js"></script>

</body>
</html>