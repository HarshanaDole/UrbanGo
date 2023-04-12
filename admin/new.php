<?php

include '../components/dbconfig.php';

  $route = [
    'start' => 'Makumbura',
    'end' => 'Matara',
    'routeno' => 'EX-001-001',
    'fare' => '210.00'
  ];

  $new_route = $database->getReference('routes')->push($route);

  echo 'New route added with key: '.$new_route->getKey();
?>