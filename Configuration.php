<?php
include_once("helper/Database.php");
include_once("helper/MustachePresenter.php");
include_once("helper/Router.php");
include_once("controller/LobbyUsuarioController.php");
include_once("controller/JuegoController.php");
include_once("controller/RankingController.php");
include_once("controller/PartidaController.php");

include_once("controller/LoginController.php");
include_once("controller/PerfilController.php");
include_once("controller/RegistroController.php");


include_once("vendor/mustache/src/Mustache/Autoloader.php");

//Clase tipo Factory que retornara las instancias del proyecto y donde vamos a tener los controllers a usar
class Configuration
{


    public static function getConfig()
    {
        $config = parse_ini_file("config/config.ini");
        return $config;
    }

    public static function getDatabase()
    {
        $config = self::getConfig();
        $server = $config["HOST"];
        $user = $config["USUARIO"];
        $password = $config["CONTRASENIA"];
        $database = $config["BASE_DATOS"];

        return new Database($server, $user, $password, $database);
    }

    public static function getPresenter()
    {
        // Le pasamos el controlador y metodo por defectos
        return new MustachePresenter("view/templates");
    }

    /*Controladores */
    public static function getJuegoController()
    {
        return new JuegoController(self::getPresenter(), self::getMainSettings());
    }

    public static function getLobbyUsuarioController()
    {
        return new LobbyUsuarioController(self::getPresenter(), self::getMainSettings());
    }

    public static function getRankingController()
    {
        return new RankingController(self::getPresenter(), self::getMainSettings());
    }

    public static function getPartidaController()
    {
        return new PartidaController(self::getPresenter(), self::getMainSettings());
    }

    public static function getLoginController(){
        return new LoginController(self::getPresenter(), self::getMainSettings());
    }

    public static function getRegistroController(){
        return new RegistroController(self::getPresenter(), self::getMainSettings());
    }

    public static function getPerfilController(){
        return new PerfilController(self::getPresenter(), self::getMainSettings());
    }

    public static function getMainSettings()
    {
        $main_settings = array(
            "isOnLobbyUsuarioView" => (isset($_GET["controller"]) || $_GET["controller"] == "lobbyusuario" || empty($_GET["controller"])) ? true : false,
            "isOnJuegoView" => (isset($_GET["controller"]) && $_GET["controller"] == "juego") ? true : false,
            "isOnRankingView" => (isset($_GET["controller"]) && $_GET["controller"] == "ranking") ? true : false,
            "isOnPartidaView" => (isset($_GET["controller"]) && $_GET["controller"] == "partida") ? true : false,
            "isOnLoginOrRegisterView" => (isset($_GET["controller"]) && $_GET["controller"] == "login" || $_GET["controller"]=="registro") ? true : false,
            "isOnPerfilView" => (isset($_GET["controller"]) && $_GET["controller"] == "perfil") ? true : false
        );
        return $main_settings;
    }

    /* NOTA: CAMBIAR ESTE POR EL DE LOGIN, OJO QUE ESTE "LOBBYCONTROLLER" ESTA DE EJEMPLO COMO CONTROLLER BASE */
    public static function getRouter()
    {
        return new Router("getLobbyUsuarioController", "get");
    }
}

?>