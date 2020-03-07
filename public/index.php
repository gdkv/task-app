<?php
    // DEBUG
    // ini_set('display_errors', 1);

    // composer libs
    require("../vendor/autoload.php");
    // core
    require("../Config/core.php");
    require("../router.php");
    $router = new Router();
    $router->forward();

?>