<?php 
    class Respuesta {
        private $id;
        private $esCorrecto;
        private $descripcion;
        private $preguntaId;
    
        // Constructor
        public function __construct($id=null, $esCorrecto=null, $descripcion=null, $preguntaId=null) {
            $this->id = $id;
            $this->esCorrecto = $esCorrecto;
            $this->descripcion = $descripcion;
            $this->preguntaId = $preguntaId;
        }
    
        // Métodos Setter
        public function setId($id) {
            $this->id = $id;
        }
    
        public function setEsCorrecto($esCorrecto) {
            $this->esCorrecto = $esCorrecto;
        }
    
        public function setDescripcion($descripcion) {
            $this->descripcion = $descripcion;
        }
    
        public function setPreguntaId($preguntaId) {
            $this->preguntaId = $preguntaId;
        }
    
        // Métodos Getter
        public function getId() {
            return $this->id;
        }
    
        public function getEsCorrecto() {
            return $this->esCorrecto;
        }
    
        public function getDescripcion() {
            return $this->descripcion;
        }
    
        public function getPreguntaId() {
            return $this->preguntaId;
        }
    }
?>