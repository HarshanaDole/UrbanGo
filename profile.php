<!DOCTYPE html>
<html>
<head>
	<title>User Profile</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style1.css">



    <style>
        
.profile-pic-div{
    height: 90px;
    width: 90px;
    position: relative;
    top: 15%;
    left: 12%;
    transform: translate(-50%,-50%);
    border-radius: 50%;
    overflow: hidden;
    border: 1px solid grey;
    
    
}

#photo{
    height: 100%;
    width: 100%;
}

#file{
    display: none;
}

#uploadBtn{
    height: 30px;
    width: 100%;
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    background: rgba(0, 0, 0, 0.7);
    color: wheat;
    line-height: 30px;
    font-family: sans-serif;
    font-size: 11px;
    cursor: pointer;
    display: none;
}
    </style>

</head>
<body style="background-color:#434A57;">
	<div class="container">
		<h1 style="color:white;">Your Profile</h1>
        <form>


            <div class="form-group">
            <div class="profile-pic-div">

                <img src="img/image.jpg" id="photo">
                <input type="file" id="file">
                <label for="file" id="uploadBtn">Choose Photo</label>
            </div>
            </div>
            
			<div class="form-group">
				<input type = "text" class="field" name="uname" placeholder="User name">
			</div>
			<div class="form-group">
                <input type = "email" class="field" name="mail" placeholder="Email address">
            </div>
            <div class="form-group">
                <input type = "password" class="field" name="pass" placeholder="Password">
            </div>
            <div class="form-group">
				<input type = "text" class="field" name="nic" placeholder="Identy Card Number">
			</div>
            <div class="form-group">
                <input type = "text" class="field" name="cno" placeholder="Phone Number">
            </div>
            <div class="form-group">
                <input type = "submit" class="field" name="submit" value="Update" style="background-color:teal; color:white;">
            </div>

		</form>
	</div>
	
	<?php include "components/bottom-nav-bar.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script src="js/app.js"></script>
</body>
</html>
