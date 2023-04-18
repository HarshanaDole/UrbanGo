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
	<title>Trip History</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color:#434A57;">
	<div class="container">
		<h1 style="color:white;">Trip History</h1>
        <form>
            <div class="form-group">

                <div class="boxxx" style="margin-bottom:16px; background-color: #33FF86;">
                    <table>
                        <tr>
                            <td><label style=" font-size: 14px;" >Bus No</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> NA 7724</label></td>
                        </tr>
                        <tr>
                            <td><label style=" font-size: 14px;" >Date</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> 11.05.2023</label></td>
                        </tr>
                        <tr>
                            <td><label style=" font-size: 14px;" >Time</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> 06.30 to 08.00</label></td>
                        </tr>
                        <tr>
                            <td><label style=" font-size: 14px;" >Amount</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> LKR 3500.00</label></td>
                        </tr>
                    </table>
                </div>

                <div class="boxxx" style="margin-bottom:16px; background-color: #33FF86;">
                    <table>
                        <tr>
                            <td><label style=" font-size: 14px;" >Bus No</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> NW 0569</label></td>
                        </tr>
                        <tr>
                            <td><label style=" font-size: 14px;" >Date</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> 11.05.2023</label></td>
                        </tr>
                        <tr>
                            <td><label style=" font-size: 14px;" >Time</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> 16.30 to 18.00</label></td>
                        </tr>
                        <tr>
                            <td><label style=" font-size: 14px;" >Amount</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> LKR 3500.00</label></td>
                        </tr>
                    </table>
                </div>

                <div class="boxxx" style="margin-bottom:16px; background-color: #33FF86;">
                    <table>
                        <tr>
                            <td><label style=" font-size: 14px;" >Bus No</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> NQ 4512</label></td>
                        </tr>
                        <tr>
                            <td><label style=" font-size: 14px;" >Date</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> 07.05.2023</label></td>
                        </tr>
                        <tr>
                            <td><label style=" font-size: 14px;" >Time</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> 11.00 to 01.45</label></td>
                        </tr>
                        <tr>
                            <td><label style=" font-size: 14px;" >Amount</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> LKR 2900.00</label></td>
                        </tr>
                    </table>
                </div>
			

                    <div class="boxxx" style="margin-bottom:16px; background-color: #33FF86;">
                    <table>
                        <tr>
                            <td><label style=" font-size: 14px;" >Bus No</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> NX 1114</label></td>
                        </tr>
                        <tr>
                            <td><label style=" font-size: 14px;" >Date</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> 07.05.2023</label></td>
                        </tr>
                        <tr>
                            <td><label style=" font-size: 14px;" >Time</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> 19.30 to 21.00</label></td>
                        </tr>
                        <tr>
                            <td><label style=" font-size: 14px;" >Amount</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> LKR 2900.00</label></td>
                        </tr>
                    </table>
                    </div>
			
		</form>
	</div>
	
	<?php include "components/bottom-nav-bar.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</body>
</html>