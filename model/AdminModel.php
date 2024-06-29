<?php 
    class AdminModel{
        private $database;

        public function __construct($database){
            $this->database =$database; 
        }


        /*CANTIDADES */
        public function getCountUsuarios(){
            return $this->database->query("select count(*) as cantidad_usuarios from usuario");
        }

        public function getCountUsuariosCreated(){
            return $this->database->query("select count(*) as cantidad_usuarios_nuevos from usuario where fechaCreacion = curdate()");
        }

        public function getCountPartidas(){
            return $this->database->query("select count(*) as cantidad_partidas from partida");
        }

        public function getTotalPreguntas(){
            return $this->database->query("select count(*) as cantidad_preguntas from pregunta");
        }

        public function getCountPreguntasCreated(){
            return $this->database->query("select count(*) as cantidad_preguntas_creadas from pregunta where fechaCreacion = curdate()");
        }

        public function getGanancia(){
            return $this->database->query("select sum(precio) as ganancia from venta");
        }


        /*Consultas para los graficos */

        public function getUsuariosAndHisRatio(){
            return $this->database->query("select u.nombrerUsuario , u.ratio from usuario u where nivel != 'INDEFINIDO'");
        }
    }
?>