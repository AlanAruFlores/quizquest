<?php 
class Partida {
    private $id;
    private $nombre;
    private $puntaje;

    // Constructor
    public function __construct($id=null, $nombre=null, $puntaje=null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->puntaje = $puntaje;
    }

    // Métodos Setter
    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPuntaje($puntaje) {
        $this->puntaje = $puntaje;
    }

    // Métodos Getter
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPuntaje() {
        return $this->puntaje;
    }
}
?>