<?php

include '../components/dbconfig.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_GET['delete'])) {
    $message_id = $_GET['delete'];
    $delete_message = $database->getReference('messages/' . $message_id);
    $delete_message->remove();
    header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>messages</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="../css/adminstyle.css">

</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="contacts">

        <h1 class="heading">messages</h1>

        <div class="box-container">

            <?php
             $messages = $database->getReference('messages')->getValue();

            if (!empty($messages)) {
                foreach ($messages as $key => $message) {
            ?>
                    <div class="box">
                        <p> name : <span><?= $message['email']; ?></span></p>
                        <p> email : <span><?= $message['phone']; ?></span></p>
                        <p> number : <span><?= $message['name']; ?></span></p>
                        <p> message : <span><?= $message['msg']; ?></span></p>
                        <a href="messages.php?delete=<?= $key; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete</a>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">you have no messages</p>';
            }
            ?>

        </div>

    </section>

    <script src="../js/adminscript.js"></script>

</body>

</html>