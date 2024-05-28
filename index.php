<?php 
    session_start();
    include_once("Configuration.php");

    if(!isset($_SESSION["usuarioLogged"]) && ($_GET["controller"] != "login" && $_GET["controller"] != "registro") ){
        $_GET["controller"]="login";
        $_GET["action"]="get";
    }

    $controller = isset($_GET["controller"]) ? $_GET["controller"] : "";
    $action = isset($_GET["action"]) ? $_GET["action"] : "";

    
    $router = Configuration::getRouter();
    $router->route($controller, $action);
?>