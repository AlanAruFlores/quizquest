<?php 
    session_start();
    include_once("Configuration.php");



    
    if(isset($_SESSION["isPlaying"]) and ($_GET["controller"] != "juego")){
        $_GET["controller"]="juego";
        $_GET["action"]="get";
    }

    $controller = isset($_GET["controller"]) ? $_GET["controller"] : "";
    $action = isset($_GET["action"]) ? $_GET["action"] : "";

    
    $router = Configuration::getRouter();
    $router->route($controller, $action);
?>