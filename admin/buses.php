<?php

include '../components/dbconfig.php';

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['add_bus'])) {

    $reg = $_POST['reg'];
    $route = $_POST['route'];
    $number = $_POST['number'];
    $seats = $_POST['seats'];

    $BusRef = $database->getReference('buses');
    $busSnapshot = $BusRef->getValue();

    $busExists = false;
    foreach ($busSnapshot as $key => $bus) {
        if ($bus['registration_plate'] == $reg) {
            $busExists = true;
            break;
        }
    }

    if ($busExists) {
        $message[] = 'bus already exist!';
    } else {
        $newBusRef = $BusRef->push();
        $newBusRef->set([
            'registration_plate' => $reg,
            'contact_no' => $number,
            'route' => $route,
            'no_of_seats' => $seats
        ]);
        $message[] = 'new bus registered successfully!';
    }
}

if (isset($_GET['delete'])) {
    $key = $_GET['delete'];
    $ref = $database->getReference('buses/' . $key);
    $ref->remove();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="../css/adminstyle.css">

</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="add-buses">

        <h1 class="heading">add buses</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="flex">
                <div class="inputBox">
                    <span>Registration Plate (required)</span>
                    <input type="text" class="box" required maxlength="100" placeholder="enter reg. plate number" name="reg">
                </div>

                <div class="inputBox">
                    <span>Contact No. (required)</span>
                    <input type="number" name="number" placeholder="e.g. 0771234567" class="box" onkeypress="if(this.value.length == 10) return false;" pattern="^[0-9]+$" required>
                </div>
                <div class="inputBox">
                    <span>Route (required)</span>
                    <select name="route" class="box" required>
                        <option value="">-- select route --</option>
                        <?php
                        $routesRef = $database->getReference('routes');
                        $routes = $routesRef->getValue();
                        foreach ($routes as $route) {
                            echo '<option value="' . $route['routeno'] . '">' . $route['routeno'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="inputBox">
                    <span>Total Seats (required)</span>
                    <input type="number" class="box" required maxlength="100" placeholder="enter total seats" name="seats">
                </div>
            </div>

            <input type="submit" value="add bus" class="btn" name="add_bus">
        </form>

    </section>

    <section class="show-buses">

        <h1 class="heading">buses added</h1>

        <div class="box-container">

            <?php
            $ref = "buses/";
            $fetch_buses = $database->getReference($ref)->getValue();
            if (!empty($fetch_buses)) {
                foreach ($fetch_buses as $key => $row) {


            ?>
                    <div class="box">
                        <div class="row">
                            <span>Reg. Plate :</span>
                            <div class="reg"><?= $row['registration_plate']; ?></div>
                        </div>
                        <div class="row">
                            <span>Route :</span>
                            <div class="route"><?= $row['route']; ?></div>
                        </div>
                        <div class="row">
                            <span>Contact No :</span>
                            <div class="number"><?= $row['contact_no']; ?></div>
                        </div>
                        <div class="row">
                            <span>No of Seats :</span>
                            <div class="seats"><?= $row['no_of_seats'] ?></div>
                        </div>
                        <div class="flex-btn">
                            <a href="update_bus.php?update=<?= $key; ?>" class="option-btn">update</a>
                            <a href="buses.php?delete=<?= $key; ?>" class="delete-btn" onclick="return confirm('delete this bus?');">delete</a>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no buses added yet!</p>';
            }
            ?>

        </div>

    </section>


    <script src="../js/adminscript.js"></script>

</body>

</html>