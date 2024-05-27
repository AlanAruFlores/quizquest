<?php 
    include_once("helper/Database.php");
    include_once("helper/MustachePresenter.php");
    include_once("helper/Router.php");
    include_once("controller/HomeController.php");
    include_once("controller/AdminController.php");
    include_once("model/PokemonModel.php");
    include_once("model/TipoModel.php");
    include_once("model/Pokemon.php");
    include_once("model/UsuarioModel.php");

    include_once("vendor/mustache/src/Mustache/Autoloader.php");

    //Clase tipo Factory que retornara las instancias del proyecto y donde vamos a tener los controllers a usar
    class Configuration{


        public static function getConfig(){
            $config = parse_ini_file("config/config.ini");
            return $config;
        }

        public static function getDatabase(){
            $config = self::getConfig();
            $server = $config["HOST"];
            $user = $config["USUARIO"];
            $password = $config["CONTRASENIA"];
            $database = $config["BASE_DATOS"];
            
            return new Database($server,$user,$password,$database);
        }

        public static function getPresenter(){
            // Le pasamos el controlador y metodo por defectos
            return new MustachePresenter("view/templates");
        }

        public static function getMainSettings(){
            $main_settings = array(
            );
            return $main_settings;
        }

    }
?>