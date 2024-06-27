<?php

namespace controller;
class LobbyAdministradorController{
    private $presenter;
    private $sugiereModel;
    private $usuarioModel;
    private $preguntaSugeridaModel;
    private $preguntaModel;
    private $partidasModel;
    private $mainSettings;

    public function __construct($presenter, $sugiereModel, $usuarioModel, $preguntaSugeridaModel, $preguntaModel, $partidasModel, $mainSettings){
        $this->presenter = $presenter;
        $this->sugiereModel = $sugiereModel;
        $this->usuarioModel = $usuarioModel;
        $this->preguntaSugeridaModel = $preguntaSugeridaModel;
        $this->preguntaModel = $preguntaModel;
        $this->partidasModel = $partidasModel;
        $this->mainSettings = $mainSettings;
    }

    public function get(){
        //Obtengo todas las preguntas
        $arrayPreguntas = $this->preguntaModel->getAllPreguntas();

        //Obtengo preguntas sugeridas con sus respuestas
        $preguntasSugeridas = $this->sugiereModel->getPreguntasSugeridas();
        $arraySugeridas = $this->sugiereModel->gerArraySugestsByPreguntas($preguntasSugeridas);

        //Obtengo lista de usuarios
        $arrayUsuarios = $this->usuarioModel->getAll();

        //Obtengo partidas
        $arrayPartidas = $this->partidasModel->getAll();


        $this->presenter->render("view/viewLobbyAdministrador.mustache",
            ["sugeridasPreguntas" => $arraySugeridas,
                "arrayUsuarios" => $arrayUsuarios,
                "arrayPartidas" => $arrayPartidas,

                ...$this->mainSettings]);
    }
}