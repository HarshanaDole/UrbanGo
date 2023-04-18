<?php

include '../components/dbconfig.php';

  $route = [
    'start' => 'Elpitiya',
    'end' => 'Colombo',
    'routeno' => 'EX 1-16',
    'fare' => '2600.00'
  ];

  $new_route = $database->getReference('routes')->push($route);

  echo 'New route added with key: '.$new_route->getKey();
?>