<?php

include 'components/dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['logout'])) {
    session_destroy();

    header('Location: login.php');
    exit;
}


if (isset($_POST['update'])) {
    $username = $_POST['uname'];
    $number = $_POST['cno'];
    $email = $_POST['mail'];

    $userRef = $database->getReference('users/' . $user_id);

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $prev_pass = $_POST['prev_pass'];
    $old_pass = sha1($_POST['old_pass']);
    $new_pass = sha1($_POST['new_pass']);
    $confirm_pass = sha1($_POST['confirm_pass']);

    $userSnapshot = $userRef->getSnapshot();
    $userData = $userSnapshot->getValue();
    $existing_pass = $userData['password'];

    if ($old_pass == $empty_pass) {
        $message[] = 'please enter old password!';
    } elseif ($old_pass != $existing_pass) {
        $message[] = 'old password not matched!';
    } else {
        $userRef->update(['name' => $username]);
        $userRef->update(['phone' => $number]);
        $userRef->update(['email' => $email]);
    }


    if ($new_pass != $confirm_pass) {
        $message[] = 'confirm password not matched!';
    } else {
        if ($new_pass != $empty_pass) {
            $userRef->update(['password' => $confirm_pass]);
            $message[] = 'password updated successfully!';
        } else {
            $message[] = 'please enter a new password!';
        }
    }
}

?>
<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">



    <style>
        .profile-pic-div {
            height: 90px;
            width: 90px;
            position: relative;
            border-radius: 50%;
            overflow: hidden;
            border: 1px solid grey;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            margin-bottom: 10px;
        }

        #photo {
            height: 100%;
            width: 100%;
        }

        #file {
            display: none;
        }

        #uploadBtn {
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
        <h1 style="color:white; margin-bottom: 20px;">Your Profile</h1>
        <?php
        $userRef = $database->getReference('users/' . $user_id);
        $userSnapshot = $userRef->getSnapshot();
        $fetch_profile = $userSnapshot->getValue();
        ?>
        <form method="post">

            <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
            <div class="profile-pic-div">

                <img src="img/image.jpg" id="photo">
                <input type="file" id="file">
                <label for="file" id="uploadBtn">Choose Photo</label>
            </div>

            <div class="form-group">
                <input type="text" class="field" name="uname" placeholder="User name" value="<?= $fetch_profile['name']; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="field" name="cno" placeholder="Phone Number" value="<?= $fetch_profile['phone']; ?>">
            </div>
            <div class="form-group">
                <input type="email" class="field" name="mail" placeholder="Email address" value="<?= $fetch_profile['email']; ?>">
            </div>
            <div class="form-group">
                <input type="password" class="field" name="old_pass" placeholder="Enter your Old Password" required>
            </div>
            <div class="form-group">
                <input type="password" class="field" name="new_pass" placeholder="Enter new Password">
            </div>
            <div class="form-group">
                <input type="password" class="field" name="confirm_pass" placeholder="Confirm Password">
            </div>

            <div class="form-group">
                <input type="submit" class="btn" name="update" value="Update" style="background-color:teal; color:white;">
            </div><br>
        </form>
        <form method="post">
            <div class="form-group">
                <input type="submit" class="btn" name="logout" value="Logout" style="background-color:#e74c3c; color:white;" onclick="return confirm('Are you sure you want to logout?')">
            </div>
        </form>
    </div>

    <?php include "components/bottom-nav-bar.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script src="js/app.js"></script>
</body>

</html>