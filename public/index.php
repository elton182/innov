<?php 

    require dirname(__DIR__) . '/vendor/autoload.php';
    $app = new App\App\App;

    $app->router->routes($_SERVER);
    
?>
