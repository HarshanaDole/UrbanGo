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
	<title>User Feedback</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <style>
        .boxsection{
            position:absolute;
            top:50%;
            left:50%;
            transform: translate(-50%,-50%);
            width: 185px;
            height: 275px;
            background: #c7c9cb;
        }
    </style>
</head>
<body style="background-color:#434A57;">
	<div class="container">
		
        
            <div class="boxsection">
                <img src="img/dark-pin.jpg" id="pin" style="height: 80px; width: 80px; border-radius: 50%; margin-top: 20px; margin-left: 53px; "><br><br>
                <label style=" font-size: 13px;  font-weight:bold;  margin-left: 38px;">You have arrived</label><br>
                <label style=" font-size: 13px;  font-weight:bold; margin-left: 31.5px;">at your destination</label>
                <label style=" font-size: 9px;  font-weight: normal;  margin-left: 37px;">See you on the next trip <b>: )</b></label><br><br>
                <input type="submit" name="ok" value="Close" style=" margin-left: 68px; background-color:teal; color:white;  border-radius: 5px;">
            </div>
		
	</div>
	
	<?php include "components/bottom-nav-bar.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</body>
</html>
