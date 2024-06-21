<?php
    class RankingModel{
        private $database;

        public function __construct($database){
            $this->database = $database;
        }

        public function obtenerJugadoresTop(){
            return $this->database->query("select ROW_NUMBER() OVER (ORDER BY p.puntaje desc) AS top, max(p.puntaje) as puntajeMaximo, p.*, u.id, u.nombrerUsuario from partida p
join usuario u on p.usuario_id = u.id
group by u.id order by puntaje desc limit 10");
        }

        public function obtenerPartidasJugador(){
            return $this->database->query("select * from partida p where usuario_id =" . $_SESSION["usuarioLogged"]["id"]);
        }
        public function obtenerTopUsuarioId($usuariosTop){
            $usuarioDatos= "";
            if(self::isBidimentionalResult($usuariosTop)){
                foreach($usuariosTop as $usuario){
                    if($usuario["usuario_id"] == $_SESSION["usuarioLogged"]["id"]){
                        $usuarioDatos = $usuario;
                    }
                }
            }
            else{
                if($usuariosTop["usuario_id"] == $_SESSION["usuarioLogged"]["id"])
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