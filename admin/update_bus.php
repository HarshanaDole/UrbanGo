<?php

include '../components/dbconfig.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['update'])) {
    $key = $_POST['bus_key'];
    $reg = $_POST['reg'];
    $route = $_POST['route'];
    $number = $_POST['number'];
    $seats = $_POST['seats'];

    $BusRef = $database->getReference('buses/' . $key);
    $busSnapshot = $BusRef->getValue();

    if ($busSnapshot) {
        $BusRef->update([
            'registration_plate' => $reg,
            'contact_no' => $number,
            'route' => $route,
            'no_of_seats' => $seats
        ]);
        $message[] = 'bus updated successfully!';
    } else {
        $message[] = 'bus does not exist!';
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update product</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="../css/adminstyle.css">

</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="update-bus">

        <h1 class="heading">update bus</h1>

        <?php
        // get the bus key from the URL
        $key = $_GET['update'];

        // get the bus data from Firebase using the key
        $busRef = $database->getReference('buses/' . $key);
        $busData = $busRef->getValue();

        // set the form values with the current bus data
        $reg = $busData['registration_plate'];
        $number = $busData['contact_no'];
        $route = $busData['route'];
        $seats = $busData['no_of_seats'];

        // retrieve the route data from Firebase
        $routeRef = $database->getReference('routes');
        $routeSnapshot = $routeRef->getValue();
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="bus_key" value="<?= $key; ?>">
            <span>update reg. plate</span>
            <input type="text" name="reg" required class="box" maxlength="100" placeholder="enter reg. plate number" value="<?= $reg; ?>">
            <span>update price</span>
            <input type="number" name="number" required class="box" min="0" max="9999999999" placeholder="enter contact number" onkeypress="if(this.value.length == 10) return false;" value="<?= $number; ?>">
            <span>update route</span>
            <select name="route" required class="box">
                <?php
                // loop through the routes and create an option for each one
                foreach ($routeSnapshot as $routeKey => $routeData) {
                    $selected = ($routeData['routeno'] == $route) ? 'selected' : '';
                    echo '<option value="' . $routeData['routeno'] . '" ' . $selected . '>' . $routeData['routeno'] . '</option>';
                }
                ?>
            </select>
            <span>update total seats</span>
            <input type="number" class="box" required maxlength="100" placeholder="enter total seats" name="seats" onkeypress="if(this.value.length == 4) return false;" value="<?= $seats; ?>">
            <div class="flex-btn">
                <input type="submit" name="update" class="btn" value="update">
                <a href="buses.php" class="option-btn">go back</a>
            </div>
        </form>

    </section>

    <script src="../js/adminscript.js"></script>

</body>

</html>