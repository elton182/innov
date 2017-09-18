<?php 

    require dirname(__DIR__) . '/vendor/autoload.php';
    $app = new Edi\App\App;

    $app->router->routes($_SERVER);
    
?>
