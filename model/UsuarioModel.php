<?php 
    include_once("model/Usuario.php");
    class UsuarioModel{
        private $database;        
        public function __construct($database){
            $this->database = $database;
        }

        public function findById($id){
            return $this->database->query("SELECT * FROM usuario WHERE id = '$id'");     
        }

        public function findUserByEmailandPassword($usuario){
            return $this->database->query("SELECT * FROM usuario WHERE CorreoElectronico='".$usuario->getCorreoElectronico()."' AND contrasena='".$usuario->getContrasena()."'");
        }

        public function update($usuario){
            // Construimos la consulta SQL
            // var_dump($usuario);
            // die();
            $this->database->execute("UPDATE usuario SET 
                        nombreCompleto = '".$usuario["nombreCompleto"]."',
                        rol = '".$usuario["rol"]."',
                        imagen = '".$usuario["imagen"]."',
                        esHabilitado = '".$usuario["esHabilitado"]."',
                        fechaNacimiento = '".$usuario["fechaNacimiento"]."',
                        Sexo = '".$usuario["Sexo"]."',
                        CorreoElectronico = '".$usuario["CorreoElectronico"]."',
                        nombrerUsuario = '".$usuario["nombrerUsuario"]."',
                        contrasena = '".$usuario["contrasena"]."',
                        pais = '".$usuario["pais"]."',
                        ciudad = '".$usuario["ciudad"]."',
                        cantidad_dadas = '".$usuario["cantidad_dadas"]."',
                        cantidad_acertadas = '".$usuario["cantidad_acertadas"]."',
                        ratio = '".$usuario["ratio"]."',
                        nivel = '".$usuario["nivel"]."'
                    WHERE id = '".$usuario["id"]."'");
    
        }

        public function updateTrampitas($usuario, $cantidad){
            $this->database->execute("update usuario set trampitas = trampitas + $cantidad where id = '".$usuario["id"]."';");
        }

        //Metodo para crear un nuevo Usuario
    }
?>