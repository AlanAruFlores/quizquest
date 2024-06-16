<?php
class PreguntaRespuestasSugeridaDTO
{
    private $preguntaSugerida;
    private $respuestasSugeridas;


    public function __construct($preguntaSugerida, $respuestasSugeridas)
    {
        $this->preguntaSugerida = $preguntaSugerida;
        $this->respuestasSugeridas = $respuestasSugeridas;
    }

    // Getter y setter para $preguntaSugerida
    public function getPreguntaSugerida()
    {
        return $this->preguntaSugerida;
    }

    public function setPreguntaSugerida($preguntaSugerida)
    {
        $this->preguntaSugerida = $preguntaSugerida;
    }

    // Getter y setter para $respuestasSugeridas
    public function getRespuestasSugeridas()
    {
        return $this->respuestasSugeridas;
    }

    public function setRespuestasSugeridas($respuestasSugeridas)
    {
        $this->respuestasSugeridas = $respuestasSugeridas;
    }
}
?>