<?php 
    include_once("model/Usuario.php");
    class UsuarioModel{
        private $database;        
        public function __construct($database){
            $this->database = $database;
        }

        public function findUserByEmailandPassword($usuario){
            return $this->database->query("SELECT * FROM usuario WHERE CorreoElectronico='".$usuario->getCorreoElectronico()."' AND contrasena='".$usuario->getContrasena()."'");
        }
        //Metodo para crear un nuevo Usuario

    }
?>