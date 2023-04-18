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
        *{
    margin: 0;
    padding: 0;
}
.rate {
    float: left;
    height: 46px;
    padding: 0 10px;
}
.rate:not(:checked) > input {
    position:absolute;
    top:-9999px;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #deb217;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}
    </style>




</head>
<body style="background-color:#434A57;">
	<div class="container">
		<h1 style="color:white;">Give us Feedback</h1>
        <form>
            <div class="form-group">
                <div class="boxxx" style="margin-bottom:16px;">
                    <table>
                        <tr>
                            <td><label style=" font-size: 14px;" >Bus No</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> NW 0569</label></td>
                        </tr>
                        <tr>
                            <td><label style=" font-size: 14px;" >Date</label></td>
                            <td><label style="font-weight: normal;  font-size: 14px;"> 05.05.2023</label></td>
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
			</div>

            <div class="form-group">
                <label style=" font-size: 16.5px; color:white;">Rate Your Experience !</label>
                <label style=" font-size: 13px; text-align:center; font-weight: normal; color:white;">About this trip</label>
            

            <div class ="rating" style="text-align:center;">
            <div class="rate">
                <input type="radio" id="star5" name="rate" value="5" />
                <label for="star5" title="text">5 stars</label>
                <input type="radio" id="star4" name="rate" value="4" />
                <label for="star4" title="text">4 stars</label>
                <input type="radio" id="star3" name="rate" value="3" />
                <label for="star3" title="text">3 stars</label>
                <input type="radio" id="star2" name="rate" value="2" />
                <label for="star2" title="text">2 stars</label>
                <input type="radio" id="star1" name="rate" value="1" />
                <label for="star1" title="text">1 star</label>
            </div>

            </div>

            </div>


            <hr>
            <div class="form-group">
                <label style=" font-size: 13px; text-align:center; font-weight: normal; color: #F2E3BF;">Do you have any thoughts you’d like to share with us?</label>
                <textarea style="resize: none;" class="contactfield" name="cno" placeholder="Type here..." rows="6" cols="50" ></textarea>
            </div>
            <div style="text-align:center;">
                <input type = "submit" class="field" name="submit" value="Skip" style="background-color:teal; color:white; max-width: 120px;">
                <input type = "submit" class="field" name="submit" value="Ok" style="background-color:teal; color:white; max-width: 120px; margin-left:20px;">
            </div>
		</form>
	</div>
	
	<?php include "components/bottom-nav-bar.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</body>
</html>