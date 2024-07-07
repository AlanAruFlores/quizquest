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
        
        public function createNewPregunta($pregunta){
            $this->database->execute("INSERT INTO pregunta (id,descripcion,punto,esValido,cantidad_dadas,acertadas,porcentaje,categoria_id,fechaCreacion) VALUES ('".$pregunta->getId()."','".$pregunta->getDescripcion()."','10','".$pregunta->getEsValido()."','0','0','100','".$pregunta->getCategoriaId()."',curdate())");
            
        }


        //Creo una nueva pregunta
        public function insertNewPregunta($preguntaNueva){
            $this->database->execute("INSERT INTO pregunta (id,descripcion,punto,esValido,cantidad_dadas,acertadas,porcentaje,categoria_id,fechaCreacion) VALUES ('null','".$preguntaNueva["descripcion"]."','10',true,'0','0','100','".$preguntaNueva["categoria_id"]."',curdate())");
        }
        public function updateDescripcionAndCategoriaPregunta($pregunta){
            $this->database->execute("UPDATE pregunta SET descripcion = '".$pregunta["descripcion"]."', categoria_id = '".$pregunta["categoria_id"]."' WHERE id = '".$pregunta["id"]."'");
        }


        //Obtener pregunta no repetida por usuario por su nivel y por puntaje(novato).
        private function getPreguntasNoRepeatedByLevel($level){
            $porcentajeDificultadConditional = ($level == "FACIL") ? "p.porcentaje between 50 and 100" :
                    (($level =="INTERMEDIO") ? "p.porcentaje between 25 and 49": "p.porcentaje between 0 and 24");

            return $this->database->query("select p.*, c.nombre as categoria, c.color from pregunta p join categoria c on p.categoria_id = c.id where p.id not in(
                    select r.pregunta_id from realiza r
                    where r.usuario_id = '".$_SESSION["usuarioLogged"]["id"]."'
                    ) and $porcentajeDificultadConditional order by rand() limit 1 ;");         
        }

        //Genera una pregunta para el bot
        public function getPreguntaNoRepeatedForBot($botId){
            $preguntaSeleccionada = $this->database->query("select p.*, c.nombre as categoria, c.color from pregunta p join categoria c on p.categoria_id = c.id where p.id not in(
                    select r.pregunta_id from realiza r
                    where r.usuario_id = '$botId'
                    ) order by rand() limit 1 ;");         
        
            //En caso de que contesto todas la preguntas, se borra el 'historial'.
            if(!$preguntaSeleccionada){
                $this->database->execute("DELETE FROM realiza WHERE usuario_id = '$botId'");
                $preguntaSeleccionada = $this->database->query("select p.*, c.nombre as categoria, c.color from pregunta p join categoria c on p.categoria_id = c.id where p.id not in(
                    select r.pregunta_id from realiza r
                    where r.usuario_id = '$botId'
                    ) order by rand() limit 1 ;");    
            }
            return $preguntaSeleccionada;
        }


        //Limpio si esas preguntas ya se los habia tomado a algun usuario   
        private function getPreguntasRepeatedByLevel($porcentajeDificultadConditional){
            return $this->database->query("select * from realiza r join pregunta p on r.pregunta_id  = p.id where $porcentajeDificultadConditional;");
        }
        private function clearQuestionsByLevel($level){
           
            $porcentajeDificultConditional = ($level == "FACIL") ? "p.porcentaje between 50 and 100" :
                (($level =="INTERMEDIO") ? "p.porcentaje between 25 and 49": "p.porcentaje between 0 and 24");
            
                //OBTENGO LAS PREGUNTAS RESPONDIDAS EN EL HISTORIAL
            $preguntasToDelete = self::getPreguntasRepeatedByLevel($porcentajeDificultConditional);
            
            //Elimina cada pregunta del arreglo de las preguntas ya respondidas
            foreach($preguntasToDelete as $preguntaItem){
                $this->database ->execute("DELETE FROM realiza WHERE usuario_id = '".$preguntaItem["usuario_id"]."' and pregunta_id = '".$preguntaItem["pregunta_id"]."';");
            }
                // var_dump($level);
                // var_dump($porcentajeDificultadConditional);
                // die();
            }

        public function generateARandomQuestion($puntaje, $nivelUsuario){
            // if($nivelUsuario == "NOVATO")
            //     $level = ($puntaje>=0 && $puntaje <=100) ? "FACIL" : "INTERMEDIO";
            // else
            //     $level  = "DIFICIL";

            //DETERMINO EL NIVEL DE LA PREGUNTA
            $level = self::getLevelOfQuestion($puntaje,$nivelUsuario);            
 
            //getPreguntasNoRepeatedByLevel() obtiene la pregunta por el nivel obtenido en "$level"

            if(!self::getPreguntasNoRepeatedByLevel($level)) 
                self::clearQuestionsByLevel($level); // LIMPIO "HISTORIAL" DE PREGUNTAS RESPONDIDAS DEL USUARIO

            $questionGenerated = self::getPreguntasNoRepeatedByLevel($level);
            return $questionGenerated;
            
        }

        public function getLevelOfQuestion($puntaje, $nivelUsuario){
            $level = "";
            if($nivelUsuario == "NOVATO")
                $level = ($puntaje>=0 && $puntaje <=100) ? "FACIL" : "INTERMEDIO";
            else
                $level  = "DIFICIL";
            return $level;
        }
        
        // public function generateARandomQuestion($puntaje){
        //     $level = ($puntaje>=0 && $puntaje <=100) ? "FACIL" : (($puntaje >100 && $puntaje <=150) ? "INTERMEDIO" : "DIFICIL");
 
        //     if(!self::getPreguntasNoRepeatedByLevel($level))
        //         self::clearQuestionsByLevel($level);

        //     $questionGenerated = self::getPreguntasNoRepeatedByLevel($level);
        //     return $questionGenerated;
            
        // }
        
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
        
        public function getLastPreguntaId(){
            $preguntaId = $this->database->query("select id from pregunta order by id desc limit 1");
            if($preguntaId == null)
                return 1;
        
            return ++$preguntaId["id"];
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