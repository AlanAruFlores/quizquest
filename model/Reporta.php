<?php
class Reporta {
    private $usuario_id;
    private $pregunta_id;
    private $razon;

    // Constructor con valores por defecto
    public function __construct($usuario_id = null, $pregunta_id = null, $razon = null) {
        $this->usuario_id = $usuario_id;
        $this->pregunta_id = $pregunta_id;
        $this->razon = $razon;
    }

    // Getters
    public function getUsuarioId() {
        return $this->usuario_id;
    }

    public function getPreguntaId() {
        return $this->pregunta_id;
    }

    public function getRazon() {
        return $this->razon;
    }

    // Setters
    public function setUsuarioId($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    public function setPreguntaId($pregunta_id) {
        $this->pregunta_id = $pregunta_id;
    }

    public function setRazon($razon) {
        $this->razon = $razon;
    }
}

?>