<?php 

    class UsuarioPartidaPregunta{

        private $partidaId;
        private $preguntaId;
        private $usuarioId;

            
        public function __construct($partidaId = null, $preguntaId = null, $usuarioId = null) {
            $this->partidaId = $partidaId;
            $this->preguntaId = $preguntaId;
            $this->usuarioId = $usuarioId;
        }

        public function getPartidaId() {
            return $this->partidaId;
        }

        public function setPartidaId($partidaId) {
            $this->partidaId = $partidaId;
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