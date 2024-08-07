<?php 
    session_start();
    include_once("Configuration.php");
    
    if(!isset($_SESSION["usuarioLogged"]) && ($_GET["controller"] != "login" && $_GET["controller"] != "registro") ){
        $_GET["controller"]="login";
        $_GET["action"]="get";
    }
    
    if(isset($_SESSION["isPlaying"]) && ($_GET["controller"] != "juego") && ($_GET["controller"] !="contar") && ($_GET["controller"] != "bot") && $_SESSION["playBot"] == false){
        $_GET["controller"]="juego";
        $_GET["action"]="get";
    }

    if(isset($_SESSION["isPlaying"]) && ($_GET["controller"] != "juego") && ($_GET["controller"] !="contar") && ($_GET["controller"] != "bot") && $_SESSION["playBot"] == true){
        $_GET["controller"]="juego";
        $_GET["action"]="playBot";
    }

    
    if(isset($_SESSION["usuarioLogged"]) && $_SESSION["usuarioLogged"]["rol"] != "Editor" && strcasecmp($_GET["controller"], "lobbyeditor") == 0){
        $_GET["controller"]="lobbyusuario";
        $_GET["action"]="get";    
    }


    if(isset($_SESSION["usuarioLogged"]) && $_SESSION["usuarioLogged"]["rol"] != "Administrador" && strcasecmp($_GET["controller"], "adminpanel") == 0){
        $_GET["controller"]="lobbyusuario";
        $_GET["action"]="get";    
    }

    if(isset($_SESSION["usuarioLogged"]) && $_SESSION["usuarioLogged"]["rol"] == "Editor" && $_GET["controller"] != "lobbyeditor" && $_GET["controller"] != "questionmanagement"){
        $_GET["controller"] ="lobbyeditor";
        $_GET["action"] = "get";
    }

    if(isset($_SESSION["usuarioLogged"]) && $_SESSION["usuarioLogged"]["rol"] == "Administrador" && $_GET["controller"] != "adminpanel"){
        $_GET["controller"] ="adminpanel";
        $_GET["action"] = "get";
    }

    $controller = isset($_GET["controller"]) ? $_GET["controller"] : "";
    $action = isset($_GET["action"]) ? $_GET["action"] : "";

    
    $router = Configuration::getRouter();
    $router->route($controller, $action);
?>