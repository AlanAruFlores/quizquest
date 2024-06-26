<?php
include_once("helper/Database.php");
include_once("helper/MustachePresenter.php");
include_once("helper/Router.php");
include_once("controller/LobbyUsuarioController.php");
include_once("controller/JuegoController.php");
include_once("controller/RankingController.php");
include_once("controller/PartidaController.php");
include_once("controller/LobbyEditorController.php");
include_once("controller/LoginController.php");
include_once("controller/PerfilController.php");
include_once("controller/RegistroController.php");
include_once("controller/ContarController.php");
include_once("controller/QuestionManagementController.php");
include_once("controller/BotController.php");

include_once("model/RegistroModel.php");
include_once("model/UsuarioModel.php");
include_once("model/RankingModel.php");

include_once("model/PartidaModel.php");
include_once("model/RespuestaModel.php");
include_once("model/PreguntaModel.php");
include_once("model/UsuarioPreguntaModel.php");
include_once("model/PreguntaSugeridaModel.php");
include_once("model/RespuestaSugeridaModel.php");
include_once("model/SugiereModel.php");
include_once("model/ReportaModel.php");
include_once("model/CategoriaModel.php");
include_once("model/VentaModel.php");

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
        return new JuegoController(self::getPresenter(),self::getPartidaModel(), self::getPreguntaModel(),self::getRespuestaModel(), self::getUsuarioPreguntaModel(), self::getReportaModel(),self::getUsuarioModel() ,self::getMainSettings());
    }

    public static function getLobbyUsuarioController()
    {
        return new LobbyUsuarioController(self::getPresenter(),self::getPartidaModel(),self::getPreguntaSugeridaModel(),self::getRespuestaSugeridaModel(),self::getSugiereModel(),self::getUsuarioModel(),self::getRankingModel(),self::getVentaModel(),self::getMainSettings());
    }

    public static function getLobbyEditorController()
    {
        return new LobbyEditorController(self::getPresenter(), self::getSugiereModel(),self::getPreguntaSugeridaModel(), self::getRespuestaSugeridaModel(),self::getPreguntaModel(), self::getRespuestaModel(), self::getReportaModel(), self::getMainSettings());
    }

    public static function getRankingController()
    {
        return new RankingController(self::getPresenter(), self::getRankingModel(), self::getMainSettings());
    }

    public static function getPartidaController()
    {
        return new PartidaController(self::getPresenter(),self::getPartidaModel(), self::getMainSettings());
    }

    public static function getLoginController(){
        return new LoginController(self::getPresenter(),self::getUsuarioModel(), self::getMainSettings());
    }

    public static function getRegistroController(){
        return new RegistroController(self::getPresenter(),self::getRegistroModel(),self::getUsuarioModel(),self::getMainSettings());
    }

    public static function getPerfilController(){
        return new PerfilController(self::getPresenter(), self::getUsuarioModel(),self::getPartidaModel(), self::getMainSettings());
    }

    public static function getContarController(){
        return new ContarController(self::getPresenter());
    }

    public static function getQuestionManagementController(){
        return new QuestionManagementController(self::getPresenter(),self::getPreguntaModel(), self::getRespuestaModel(),self::getCategoriaModel(), self::getReportaModel(), self::getUsuarioPreguntaModel(), self::getMainSettings());
    }

    public static function getBotController(){
        return new BotController(self::getPresenter(), self::getUsuarioModel(), self::getPreguntaModel(),self::getRespuestaModel(), self::getUsuarioPreguntaModel());
    }

    /*MODELOS*/
    public static function getRegistroModel(){
        return new RegistroModel(self::getDatabase());
    }

    public static function getUsuarioModel(){
        return new UsuarioModel(self::getDatabase());
    }

    public static function getPreguntaModel(){
        return new PreguntaModel(self::getDatabase());
    }

    public static function getRespuestaModel(){
        return new RespuestaModel(self::getDatabase());
    }

    public static function getPartidaModel(){
        return new PartidaModel(self::getDatabase());
    }

    public static function getUsuarioPreguntaModel(){
        return new UsuarioPreguntaModel(self::getDatabase());
    }

    public static function getPreguntaSugeridaModel(){
        return new PreguntaSugeridaModel(self::getDatabase());
    }

    public static function getRespuestaSugeridaModel(){
        return new RespuestaSugeridaModel(self::getDatabase());
    }

    public static function getSugiereModel(){
        return new SugiereModel(self::getDatabase());
    }

    public static function getReportaModel(){
        return new ReportaModel(self::getDatabase());
    }
    public static function getRankingModel(){
        return new RankingModel(self::getDatabase());
    }
    public static function getCategoriaModel(){
        return new CategoriaModel(self::getDatabase());
    }

    public static function getVentaModel(){
        return new VentaModel(self::getDatabase());
    }
    /*Configuracion principal */
    public static function getMainSettings()
    {
        $main_settings = array(
            "isOnLobbyUsuarioView" => (isset($_GET["controller"]) && $_GET["controller"] == "lobbyusuario" || empty($_GET["controller"])) ? true : false,
            "isOnLobbyEditorView" => (isset($_GET["controller"]) && $_GET["controller"] == "lobbyeditor") ? true : false,
            "isOnJuegoView" => (isset($_GET["controller"]) && $_GET["controller"] == "juego") ? true : false,
            "isOnJuegoToTheEnd" => (isset($_GET["controller"]) && $_GET["controller"] == "juego" && $_GET["action"] == "goToTheEnd") ? true : false,
            "isOnRankingView" => (isset($_GET["controller"]) && $_GET["controller"] == "ranking") ? true : false,
            "isOnPartidaView" => (isset($_GET["controller"]) && $_GET["controller"] == "partida") ? true : false,
            "isOnLoginOrRegisterView" => (isset($_GET["controller"]) && ($_GET["controller"] == "login" || $_GET["controller"]=="registro")) ? true : false,
            "isOnLoginView" => (isset($_GET["controller"]) && $_GET["controller"] == "login") ? true : false,
            "isOnRegisterView" => (isset($_GET["controller"]) && $_GET["controller"] == "registro") ? true : false,
            "isOnPerfilView" => (isset($_GET["controller"]) && $_GET["controller"] == "perfil" && $_GET["action"] == "get") ? true : false,
            "isOnShowPerfilView" => (isset($_GET["controller"]) && $_GET["controller"] == "perfil" && $_GET["action"] == "showPerfil") ? true : false,
            "isOnValidateView" => (isset($_GET["controller"]) && ($_GET["controller"] == "registro" && $_GET["action"]=="validate")) ? true : false,
            "isOnQuestionManagementView" => (isset($_GET["controller"]) && $_GET["controller"] == "questionmanagement") ? true : false,
            "isOnEditView"=>(isset($_GET["controller"]) && $_GET["controller"] == "questionmanagement" && $_GET["action"] == "goToEdit") ? true:false
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