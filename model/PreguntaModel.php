<?php 
    include_once("model/Pregunta.php");
    class PreguntaModel{
        private $database;        
        public function __construct($database){
            $this->database = $database;
        }

        private function getOnePreguntaRandom(){
            return $this->database->query("select p.id, p.descripcion, p.punto, c.nombre as categoria, c.color as color from pregunta p join categoria c on p.categoría_id = c.id order by rand() limit 1;");
        }

        public function getRandomPreguntas(){
            $arrPreguntas = array();
            $preguntaObtenida = null;
            $flag = true;

            for($i = 0; $i<10; $i++){

                while($flag){
                    $preguntaObtenida = self::getOnePreguntaRandom();
                    if($arrPreguntas == null || !in_array($preguntaObtenida,$arrPreguntas))
                        $flag = false;
                }

                array_push($arrPreguntas, $preguntaObtenida);
            }

            return $arrPreguntas;
        }

        //Metodo para crear un nuevo Usuario

    }
?>