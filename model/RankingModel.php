<?php
    class RankingModel{
        private $database;

        public function __construct($database){
            $this->database = $database;
        }

        public function obtenerJugadoresTop(){
            return $this->database->query("select ROW_NUMBER() OVER (ORDER BY p.puntaje asc) AS top, max(p.puntaje) as puntajeMaximo, p.*, u.id, u.nombrerUsuario from partida p
join usuario u on p.usuario_id = u.id
group by u.id order by puntaje asc limit 10");
        }

        public function obtenerPartidasJugador(){
            return $this->database->query("select * from partida p where usuario_id =" . $_SESSION["usuarioLogged"]["id"]);
        }
        public function obtenerTopUsuarioId($usuariosTop){
            $usuarioDatos= "";
            foreach($usuariosTop as $usuario){
                if($usuario["usuario_id"] == $_SESSION["usuarioLogged"]["id"]){
                    $usuarioDatos = $usuario;

                }
            }
            return $usuarioDatos;
        }

        public function obtenerTop(){
            $usuariosTop = self::obtenerJugadoresTop();
            return $usuariosTop;
        }


    }

?>