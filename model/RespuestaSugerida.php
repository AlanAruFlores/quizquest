<?php

class RespuestaSugerida {
    private $id;
    private $descripcion;
    private $esCorrecto;

    // Constructor con valores por defecto
    public function __construct($id = null, $descripcion = null, $esCorrecto = null) {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->esCorrecto = $esCorrecto;
    }

    // Getter y Setter para id
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter y Setter para descripcion
    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    // Getter y Setter para esCorrecto
    public function getEsCorrecto() {
        return $this->esCorrecto;
    }

    public function setEsCorrecto($esCorrecto) {
        $this->esCorrecto = $esCorrecto;
    }
}

?>