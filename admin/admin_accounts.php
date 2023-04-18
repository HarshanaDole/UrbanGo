<?php

include '../components/dbconfig.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_GET['delete'])) {
    $key = $_GET['delete'];
    $ref = $database->getReference('admins/' . $key);
    $admin = $ref->getValue();

    if ($key == $admin_id) {
        // if the account being deleted is the current admin, destroy the session
        $ref->remove();
        session_unset();
        session_destroy();
        header('location:admin_login.php');
        exit();
    }

    $ref->remove();
    header('location:admin_accounts.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin accounts</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="../css/adminstyle.css">

</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="accounts">

        <h1 class="heading">admin accounts</h1>

        <div class="box-container">

            <div class="box" style="height:15.15rem;">
                <p>add new admin</p><br>
                <a href="register_admin.php" class="option-btn">register admin</a>
            </div>

            <?php
            $ref = "admins/";
            $fetch_accounts = $database->getReference($ref)->getValue();
            if (!empty($fetch_accounts)) {
                foreach ($fetch_accounts as $key => $row) {
            ?>
                    <div class="box">
                        <p> admin name : <span><?= $row['name']; ?></span> </p>
                        <p> contact no. : <span><?= $row['contact_no']; ?></span> </p>
                        <p> station : <span><?= $row['station']; ?></span> </p>
                        <div class="flex-btn">
                            <?php if ($key == $admin_id) { ?>
                                <a href="admin_accounts.php?delete=<?= $key; ?>" onclick="return confirm('delete this account?')" class="delete-btn">delete</a>
                            <?php } ?>
                            <?php
                            if ($key == $admin_id) {
                                echo '<a href="update_profile.php" class="option-btn">update</a>';
                            }
                            ?>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no accounts available!</p>';
            }
            ?>

        </div>

    </section>


    <script src="../js/adminscript.js"></script>

</body>

</html>