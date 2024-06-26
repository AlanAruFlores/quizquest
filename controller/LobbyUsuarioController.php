<?php
include_once("model/Partida.php");
include_once("model/Temporizador.php");
include_once("model/PreguntaSugerida.php");
include_once("model/RespuestaSugerida.php");
include_once("model/Sugiere.php");
include_once("model/NivelUsuario.php");
include_once("model/Venta.php");

class LobbyUsuarioController
{

    private $mainSettings;
    private $presenter;
    private $partidaModel;
    private $preguntaSugeridaModel;
    private $respuestaSugeridaModel;
    private $sugiereModel;
    private $usuarioModel;

    private $rankingModel; 
    private $ventaModel;
    public function __construct($presenter, $partidaModel,$preguntaSugeridaModel, $respuestaSugeridaModel, $sugiereModel, $usuarioModel, $rankingModel,$ventaModel, $mainSettings)
    {
        $this->presenter = $presenter;
        $this->mainSettings = $mainSettings;
        $this->partidaModel = $partidaModel;
        $this->preguntaSugeridaModel = $preguntaSugeridaModel;
        $this->respuestaSugeridaModel = $respuestaSugeridaModel;
        $this->sugiereModel = $sugiereModel;
        $this->usuarioModel = $usuarioModel;
        $this->rankingModel = $rankingModel;
        $this->ventaModel = $ventaModel;
    }

    public function get()
    {
        self::updateDataUser(); //Actualizar los datos del usuario
        
        $usuarioRanking = $this->rankingModel->obtenerTopUsuarioId($_SESSION["usuarioLogged"]["id"]);

        $esAvanzado = $_SESSION["usuarioLogged"]["nivel"] == "AVANZADO" ? true : false;
        //die();
        $this->presenter->render("view/viewLobbyUsuario.mustache", [
            "usuarioLogeado" => $_SESSION["usuarioLogged"],
            "usuarioRanking" => $usuarioRanking,
            "esAvanzado" => $esAvanzado,
            ...$this->mainSettings
        ]);


    }

    public function createNewPartida()
    {
        //INSERTO Y OBTENGO LA PARTIDA
        $codigo = $this->partidaModel->generateCodeRandom();
        $partida = new Partida();
        $partida->setNombre("Partida#".$codigo);
        $partida->setPuntaje(0);
        $partida->setUsuarioId($_SESSION["usuarioLogged"]["id"]);
        $partida->setCodigo($codigo);

        $this->partidaModel->insertNewPartida($partida);
        $partidaObject = $this->partidaModel->getPartidaByNameAndCode($partida);
        $_SESSION["partidaActual"] = $partidaObject;

        $_SESSION["indicePregunta"] = 0;
        $_SESSION["playBot"] = false;
        //Aseguro que el usuario luego no se pueda ir libremente
        $_SESSION["isPlaying"] = true;
        header("Location:/quizquest/juego/get");
    }


    /*CREAR PARTIDA PARA JUGAR CON UN BOT */
    public function createPartidaBot()
    {
        //INSERTO Y OBTENGO LA PARTIDA
        $codigo = $this->partidaModel->generateCodeRandom();

        $partida = new Partida();
        $partida->setNombre("PartidaBot#".$codigo);
        $partida->setPuntaje(0);
        $partida->setUsuarioId($_SESSION["usuarioLogged"]["id"]);
        $partida->setCodigo($codigo);

        $this->partidaModel->insertNewPartida($partida);
        $partidaObject = $this->partidaModel->getPartidaByNameAndCode($partida);
        $_SESSION["partidaActual"] = $partidaObject;

        $_SESSION["indicePregunta"] = 0;
        $_SESSION["botPuntaje"] = 0;
        $_SESSION["botAcerto"] = true;

        $_SESSION["playBot"] = true;

        //Aseguro que el usuario luego no se pueda ir libremente
        $_SESSION["isPlaying"] = true;
        header("Location:/quizquest/juego/playBot");
    }


    public function suggestNewQuestion(){

        //Obtengo los ultimos IDS de preguntas y respuestas del bd:
        $lastIdPreguntaSugerida= $this->preguntaSugeridaModel->getLastPreguntaSugeridaId();
        $lastIdRespuestaSugerida = $this->respuestaSugeridaModel->getLastRespuestaSugeridaId();

        //Instancio las preguntas y respuestas nuevas y a sugerir
        $this->preguntaSugeridaModel->insertNewPreguntaSugerida(new PreguntaSugerida($lastIdPreguntaSugerida,$_POST["descripcionPregunta"],$_POST["preguntaCategoriaId"]));

        for($i = 1; $i<=intval($_POST["cantidadPreguntas"]); $i++){
            $this->respuestaSugeridaModel->insertNewRespuestaSugerida(new RespuestaSugerida($lastIdRespuestaSugerida,$_POST["respuesta$i"], ($i== $_POST["esCorrecta"]) ? TRUE : FALSE));
            $sugerir = new Sugiere($_SESSION["usuarioLogged"]["id"], $lastIdPreguntaSugerida,$lastIdRespuestaSugerida++);
            $this->sugiereModel->insertNewSugiere($sugerir);
        }
        
        header("Location:/quizquest/lobbyusuario/get");
    }


    public function exit()
    {
        unset($_SESSION["usuarioLogged"]);
        header("Location:/quizquest/login/get");
    }

    public function updateDataUser(){
        $usuarioAActualizar = $this->usuarioModel->findById($_SESSION["usuarioLogged"]["id"]);
        // var_dump($usuarioAActualizar);
        // die();
        if($usuarioAActualizar["ratio"] > 70 && $usuarioAActualizar["cantidad_dadas"] > 50){
            $usuarioAActualizar["nivel"] = NivelUsuario::AVANZADO;
            $this->usuarioModel->update($usuarioAActualizar);
        }
        $_SESSION["usuarioLogged"] = $usuarioAActualizar;
    }

    public function buyHelados(){
        $cantidad = $_GET["cantidad"];
        $precio  = $_GET["precio"];

        $nuevaVenta = new Venta(null,$cantidad,$precio, $_SESSION["usuarioLogged"]["id"]);
        // var_dump($nuevaVenta);
        // die();
        $this->ventaModel->insertNewVenta($nuevaVenta);
        $this->usuarioModel->updateTrampitas($_SESSION["usuarioLogged"], $cantidad);
        header("Location:/quizquest/lobbyusuario/get");
    }

}   
?>