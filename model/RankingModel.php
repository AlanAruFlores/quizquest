<?php
    class RankingModel{
        private $database;

        public function __construct($database){
            $this->database = $database;
        }

        public function obtenerJugadoresTop(){
            return $this->database->query("SELECT 
                ROW_NUMBER() OVER (ORDER BY 
                CASE 
                    WHEN u.nivel = 'AVANZADO' THEN 1 
                    ELSE 2 
                END, p.max_puntaje DESC) AS top, p.max_puntaje, u.id AS id_usuario, u.nombrerUsuario, u.nivel FROM ( SELECT usuario_id, MAX(puntaje) AS max_puntaje FROM partida GROUP BY usuario_id) p 
            JOIN usuario u ON p.usuario_id = u.id   
            ORDER BY top LIMIT 10");
        }
        public function obtenerTodosTops(){
            return $this->database->query("SELECT 
                ROW_NUMBER() OVER (ORDER BY 
                CASE 
                    WHEN u.nivel = 'AVANZADO' THEN 1 
                    ELSE 2 
                END, p.max_puntaje DESC) AS top, p.max_puntaje, u.id AS id_usuario, u.nombrerUsuario, u.nivel FROM ( SELECT usuario_id, MAX(puntaje) AS max_puntaje FROM partida GROUP BY usuario_id) p 
            JOIN usuario u ON p.usuario_id = u.id   
            ORDER BY top");
        }





        public function obtenerPartidasJugador(){
            return $this->database->query("select * from partida p where usuario_id =" . $_SESSION["usuarioLogged"]["id"]);
        }
        public function obtenerTopUsuarioId($id){
            $usuarioDatos= null;
            $usuariosTop = self::obtenerTodosTops();
            if(self::isBidimentionalResult($usuariosTop)){
                foreach($usuariosTop as $usuario){
                    if($usuario["id_usuario"] == $id){
                        $usuarioDatos = $usuario;
                    }
                }
            }
            else{
                if($usuariosTop["id_usuario"] == $id)
                    $usuarioDatos = $usuariosTop;
            }
            return $usuarioDatos;
        }

        public function obtenerTop(){
            $usuariosTop = self::obtenerJugadoresTop();
            return $usuariosTop;
        }


        public function isBidimentionalResult($result__array){
            if(!is_array($result__array))
                return false;
        
            foreach ($result__array as $element) {
                if(is_array($element))
                    return true;
            }
    
            return false;
        }
    }

?>