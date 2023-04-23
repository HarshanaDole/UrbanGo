<?php

include 'components/dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if(isset($_POST['submit'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $data = [
        'name' => $name,
        'email' => $email,
        'phone' => $number,
        'msg' => $msg
    ];

    $ref = "messages/";
    $postdata = $database->getReference($ref)->push($data);

    if($postdata) {
        header("location: index.php");
    } else {
        $message[] = 'failed';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Contct Us Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css\contact.css">
</head>
<body style="background-color:#434A57;">
	<div class="container">
		<h1 style="color:white;">Contact Us</h1>
        <form method="post">
            <div class="form-group">
                <div class="boxxx">
                    <label style=" font-size: 20px;" >Contact Info</label>
                    <label style=" font-size: 20px; font-family: Century-Gothic; font-weight: normal;" class="contactusphone">077-854-0511</label>
                    <label style=" font-size: 20px; font-family: Century-Gothic; font-weight: normal;" class="contactusmail">urbango@gmail.com</label>
                </div>
			</div>
            <div class="form-group">
                <label style=" font-size: 20px; color:white;">Write Us</label>
				<input type = "text" class="contactfield" name="name" placeholder="User name">
			</div>
			<div class="form-group">
                <input type = "email" class="contactfield" name="email" placeholder="Email address">
            </div>
            <div class="form-group">
                <input type = "text" class="contactfield" name="number" placeholder="Phone Number">
            </div>
            <div class="form-group">
                <textarea style="resize: none;" class="contactfield" name="msg" placeholder="Message" rows="6" cols="50" ></textarea>
            </div>
            <div class="button-container">
			    <a href=""></a>
                <input type = "submit" class="field" name="submit" value="Submit">
            </div>
		</form>
	</div>
	
	<?php include "components/bottom-nav-bar.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</body>
</html>