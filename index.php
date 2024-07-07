<?php 
    session_start();
    include_once("Configuration.php");
    

    //Evita que accede a cualquier vista del juego si no esta logeado
    if(!isset($_SESSION["usuarioLogged"]) && ($_GET["controller"] != "login" && $_GET["controller"] != "registro") ){
        $_GET["controller"]="login";
        $_GET["action"]="get";
    }
    
    //Para evitar que se vaya otra vista si esta jugando una partida y que las peticiones AJAX se llamen correctamente
    if(isset($_SESSION["isPlaying"]) && ($_GET["controller"] != "juego") && ($_GET["controller"] !="contar") && ($_GET["controller"] != "bot") && $_SESSION["playBot"] == false){
        $_GET["controller"]="juego";
        $_GET["action"]="get";
    }

    //Para evitar que se vaya otra vista si esta jugando una partida y que las peticiones AJAX se llamen correctamente para el BOT
    if(isset($_SESSION["isPlaying"]) && ($_GET["controller"] != "juego") && ($_GET["controller"] !="contar") && ($_GET["controller"] != "bot") && $_SESSION["playBot"] == true){
        $_GET["controller"]="juego";
        $_GET["action"]="playBot";
    }


    //strcasecmp -> Comparar strings
    //Si no soy editor , me redirige al lobby del usuario normal
    if(isset($_SESSION["usuarioLogged"]) && $_SESSION["usuarioLogged"]["rol"] != "Editor" && strcasecmp($_GET["controller"], "lobbyeditor") == 0){
        $_GET["controller"]="lobbyusuario";
        $_GET["action"]="get";    
    }

    //Si no soy admin , me redirige al lobby usuario normal
    if(isset($_SESSION["usuarioLogged"]) && $_SESSION["usuarioLogged"]["rol"] != "Administrador" && strcasecmp($_GET["controller"], "adminpanel") == 0){
        $_GET["controller"]="lobbyusuario";
        $_GET["action"]="get";    
    }

    $controller = isset($_GET["controller"]) ? $_GET["controller"] : "";
    $action = isset($_GET["action"]) ? $_GET["action"] : "";

    
    $router = Configuration::getRouter();
    $router->route($controller, $action);
?>