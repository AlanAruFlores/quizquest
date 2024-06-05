<?php 

    class UsuarioPregunta{

        private $preguntaId;
        private $usuarioId;

            
        public function __construct($preguntaId = null, $usuarioId = null) {
            $this->preguntaId = $preguntaId;
            $this->usuarioId = $usuarioId;
        }

        public function getPreguntaId() {
            return $this->preguntaId;
        }

        public function setPreguntaId($preguntaId) {
            $this->preguntaId = $preguntaId;
        }

        public function getUsuarioId() {
            return $this->usuarioId;
        }

        public function setUsuarioId($usuarioId) {
            $this->usuarioId = $usuarioId;
        }

    }
?>