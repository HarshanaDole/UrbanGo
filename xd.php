<?php

include 'components/dbconfig.php';

  $route = [
    'email' => 'yr@gmail.com',
    'name' => 'ktt',
    'password' => 'fhrhre4hrhehjaqw',
    'phone' => '0742664351'
  ];

  $new_route = $database->getReference('users')->push($route);

  echo 'New route added with key: '.$new_route->getKey();
?>