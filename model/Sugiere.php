<?php

class Sugiere {
    private $usuarioId;
    private $preguntaSugeridaId;
    private $respuestaSugeridaId;

    // Constructor con valores por defecto
    public function __construct($usuarioId = null, $preguntaSugeridaId = null, $respuestaSugeridaId = null) {
        $this->usuarioId = $usuarioId;
        $this->preguntaSugeridaId = $preguntaSugeridaId;
        $this->respuestaSugeridaId = $respuestaSugeridaId;
    }

    // Getter y Setter para usuarioId
    public function getUsuarioId() {
        return $this->usuarioId;
    }

    public function setUsuarioId($usuarioId) {
        $this->usuarioId = $usuarioId;
    }

    // Getter y Setter para preguntaSugeridaId
    public function getPreguntaSugeridaId() {
        return $this->preguntaSugeridaId;
    }

    public function setPreguntaSugeridaId($preguntaSugeridaId) {
        $this->preguntaSugeridaId = $preguntaSugeridaId;
    }

    // Getter y Setter para respuestaSugeridaId
    public function getRespuestaSugeridaId() {
        return $this->respuestaSugeridaId;
    }

    public function setRespuestaSugeridaId($respuestaSugeridaId) {
        $this->respuestaSugeridaId = $respuestaSugeridaId;
    }
}

?>