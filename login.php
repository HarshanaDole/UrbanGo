<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="container">
		<h1>Login</h1>
		<form>
			<div class="form-group">
                <input type="email" name="email" required placeholder="enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
			</div>
			<div class="form-group">
                <input type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
			</div>
			<div class="form-group">
                <input type="submit" value="login now" class="btn" name="submit">
			</div>
            <div class="form-group">
                <p>don't have an account?<a href="registration.php" class="option-btn">register now</a></p>               
			</div>
		</form>
</div>

<script src="js/script.js"></script>

</body>
</html>