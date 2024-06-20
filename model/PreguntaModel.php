<?php 
    include_once("model/Pregunta.php");
    class PreguntaModel{
        private $database;        
        public function __construct($database){
            $this->database = $database;
        }



        public function getAllPreguntas(){
            return $this->database->query("SELECT * FROM pregunta");
        }
        
        //Creo una nueva pregunta
        public function insertNewPregunta($preguntaNueva){
            $this->database->execute("INSERT INTO pregunta (id,descripcion,punto,esValido,cantidad_dadas,acertadas,porcentaje,categoria_id) VALUES ('null','".$preguntaNueva["descripcion"]."','10',true,'0','0','100','".$preguntaNueva["categoria_id"]."')");
        }
        public function updateDescripcionAndCategoriaPregunta($pregunta){
            $this->database->execute("UPDATE pregunta SET descripcion = '".$pregunta["descripcion"]."', categoria_id = '".$pregunta["categoria_id"]."' WHERE id = '".$pregunta["id"]."'");
        }

        private function getPreguntasNoRepeatedByLevel($level){
            $porcentajeDificultadConditional = ($level == "FACIL") ? "p.porcentaje between 50 and 100" :
                    (($level =="INTERMEDIO") ? "p.porcentaje between 25 and 49": "p.porcentaje between 0 and 24");

            return $this->database->query("select p.*, c.nombre as categoria, c.color from pregunta p join categoria c on p.categoria_id = c.id where p.id not in(
                    select r.pregunta_id from realiza r
                    where r.usuario_id = '".$_SESSION["usuarioLogged"]["id"]."'
                    ) and $porcentajeDificultadConditional order by rand() limit 1 ;");         
        }

        //Limpio si esas preguntas ya se los habia tomado a algun usuario   
        private function getPreguntasRepeatedByLevel($porcentajeDificultadConditional){
            return $this->database->query("select * from realiza r join pregunta p on r.pregunta_id  = p.id where $porcentajeDificultadConditional;");
        }
        private function clearQuestionsByLevel($level){
           
            $porcentajeDificultConditional = ($level == "FACIL") ? "p.porcentaje between 50 and 100" :
                (($level =="INTERMEDIO") ? "p.porcentaje between 25 and 49": "p.porcentaje.between 0 and 24");
            
            $preguntasToDelete = self::getPreguntasRepeatedByLevel($porcentajeDificultConditional);
            
            foreach($preguntasToDelete as $preguntaItem){
                $this->database ->execute("DELETE realiza FROM realiza WHERE usuario_id = '".$preguntaItem["usuario_id"]."' and pregunta_id = '".$preguntaItem["pregunta_id"]."';");
            }
                // var_dump($level);
                // var_dump($porcentajeDificultadConditional);
                // die();
            }

        public function generateARandomQuestion($puntaje){
            $level = ($puntaje>=0 && $puntaje <=100) ? "FACIL" : (($puntaje >100 && $puntaje <=150) ? "INTERMEDIO" : "DIFICIL");
 
            if(!self::getPreguntasNoRepeatedByLevel($level))
                self::clearQuestionsByLevel($level);

            $questionGenerated = self::getPreguntasNoRepeatedByLevel($level);
            return $questionGenerated;
            
        }
        
        public function update($pregunta){
            $this->database->execute("UPDATE pregunta SET cantidad_dadas='".$pregunta["cantidad_dadas"]."', acertadas='".$pregunta["acertadas"]."' , porcentaje='".$pregunta["porcentaje"]."' WHERE id = '".$pregunta["id"]."'");  
        }

        public function increaseCantidadOfPregunta($pregunta){
            $pregunta["cantidad_dadas"] += 1;
            $_SESSION["preguntaActualExistente"] = $pregunta;
            self::update($pregunta);
        }

        public function increaseAcertadasOfPregunta($pregunta){
            $pregunta["acertadas"] += 1;
            $_SESSION["preguntaActualExistente"] = $pregunta;
            self::update($pregunta);
        }

        public function updatePorcentaje($pregunta){
            $pregunta["porcentaje"] = floor((($pregunta["acertadas"])/($pregunta["cantidad_dadas"]))*100);
            $_SESSION["preguntaActualExistente"] = $pregunta;
            self::update($pregunta);
        }

        public function getLastPregunta(){
            return $this->database->query("select * from pregunta order by id desc limit 1");
        }

        public function getPreguntaById($id){
            return $this->database->query("select * from pregunta where id = '$id'");
        }

        public function getPreguntaWithCategoria($id){
            return $this->database->query("select p.*,p.cantidad_dadas-p.acertadas as no_acertadas, c.nombre as descripcion_categoria from pregunta p  join categoria c on p.categoria_id = c.id where p.id = '$id';");
        }

        public function changePreguntaToInvalidById($id){
            $this->database->execute("update pregunta set esValido = 'false' where id = '$id'");
        }

        public function deletePreguntaById($id){
            $this->database->execute("delete from pregunta where id = '$id'");
        }
    }
?>