<?php 
class Partida {
    private $id;
    private $nombre;
    private $puntaje;
    private $usuarioId;
    // Constructor
    public function __construct($id=null, $nombre=null, $puntaje=null, $usuarioId = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->puntaje = $puntaje;
        $this->usuarioId = $usuarioId;
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

    public function setUsuarioId($usuarioId){
        $this->usuarioId = $usuarioId;
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

    public function getUsuarioId(){
        return $this->usuarioId;
    }

}
?>