<?php 
    include_once("model/Pregunta.php");
    class PreguntaModel{
        private $database;        
        public function __construct($database){
            $this->database = $database;
        }

        private function getPreguntasNoRepeated($limit , $elementsNotIncluded = null){
            if($elementsNotIncluded == null){
                return $this->database->query("select * from pregunta p where p.id not in(
                    select r.pregunta_id from realiza r
                    where r.usuario_id = '".$_SESSION["usuarioLogged"]["id"]."'
                    ) order by rand() limit $limit ;");
            }
            
            var_dump($elementsNotIncluded);
            var_dump(array_column($elementsNotIncluded, 'id'));
            
            $idElementsNotIncluded = array_column($elementsNotIncluded, 'id');
            return $this->database->query("select * from pregunta p where p.id not in(
            ".implode(',',$idElementsNotIncluded).") order by rand() limit $limit ;");            
        }

        //Limpio si esas preguntas ya se los habia tomado a algun usuario
        private function clearQuestions(){
            $this->database->execute("
                delete from realiza where usuario_id = '".$_SESSION["usuarioLogged"]["id"]."'
            ");
        }

        public function generateRandomPreguntas(){
            $arrPreguntas = self::getPreguntasNoRepeated(10);
            
            $cantidadObtenida=sizeof($arrPreguntas) ;
            if( $cantidadObtenida<10){
                $limitAux = 10-$cantidadObtenida;
                self::clearQuestions();
                $arrPreguntasFaltantes= self::getPreguntasNoRepeated($limitAux, $arrPreguntas);
                $arrPreguntas = array_merge($arrPreguntas, $arrPreguntasFaltantes);
            }

            return $arrPreguntas;
        }

        public function getRandomPreguntas(){
            return $this->database->query("select p.id, p.descripcion, p.punto, p.esValido, c.nombre as categoria , c.color from realiza r join pregunta p 	
            on r.pregunta_id = p.id
            join categoria c on c.id = p.categoria_id
            where partida_id = '".$_SESSION["partidaActual"]["id"]."' order by rand()");
        }
    }
?>