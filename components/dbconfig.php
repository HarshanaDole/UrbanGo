<?php
    require __DIR__.'/vendor/autoload.php';

    use Kreait\Firebase\Factory;
    use Kreait\Firebase\ServiceAccount;

    $factory = (new Factory)
        ->withServiceAccount('E:\Xampppp\htdocs\UrbanGo\components\urbango-a6211-firebase-adminsdk-m2r8z-77a02a5e99.json')
        ->withDatabaseUri('https://urbango-a6211-default-rtdb.firebaseio.com');

    $database = $factory->createDatabase();

?>