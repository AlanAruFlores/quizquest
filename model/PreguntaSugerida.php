<?php

class PreguntaSugerida {
    private $id;
    private $descripcion;
    private $categoriaId;

    // Constructor con valores por defecto
    public function __construct($id = null, $descripcion = null, $categoriaId = null) {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->categoriaId = $categoriaId;
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

    // Getter y Setter para categoriaId
    public function getCategoriaId() {
        return $this->categoriaId;
    }

    public function setCategoriaId($categoriaId) {
        $this->categoriaId = $categoriaId;
    }
}

?>