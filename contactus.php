<?php

include 'components/dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Contct Us Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color:#434A57;">
	<div class="container">
		<h1 style="color:white;">Contact Us</h1>
        <form>
            <div class="form-group">
                <div class="boxxx">
                    <label style=" font-size: 20px;" >Contact Info</label>
                    <label style=" font-size: 20px; font-family: Century-Gothic; font-weight: normal;" class="contactusphone">077-854-0511</label>
                    <label style=" font-size: 20px; font-family: Century-Gothic; font-weight: normal;" class="contactusmail">urbango@gmail.com</label>
                </div>
			</div>
            <div class="form-group">
                <label style=" font-size: 20px; color:white;">Write Us</label>
				<input type = "text" class="contactfield" name="uname" placeholder="User name">
			</div>
			<div class="form-group">
				<input type = "text" class="contactfield" name="uname" placeholder="User name">
			</div>
			<div class="form-group">
                <input type = "email" class="contactfield" name="mail" placeholder="Email address">
            </div>
            <div class="form-group">
                <input type = "text" class="contactfield" name="cno" placeholder="Phone Number">
            </div>
            <div class="form-group">
                <textarea style="resize: none;" class="contactfield" name="cno" placeholder="Message" rows="6" cols="50" ></textarea>
            </div>
            <div class="form-group">
                <input type = "submit" class="field" name="submit" value="Send" style="background-color:teal; color:white; max-width: 120px;">
            </div>
		</form>
	</div>
	
	<?php include "components/bottom-nav-bar.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</body>
</html>