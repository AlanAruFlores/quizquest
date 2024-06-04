<?php 
    session_start();
    include_once("Configuration.php");



    $controller = isset($_GET["controller"]) ? $_GET["controller"] : "";
    $action = isset($_GET["action"]) ? $_GET["action"] : "";

    
    $router = Configuration::getRouter();
    $router->route($controller, $action);
?>