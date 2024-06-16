const $selectCantidadPreguntas = document.getElementById("cantidad_preguntas");
const $divPosiblesRespuestas = document.getElementById("posibles_respuestas");

$selectCantidadPreguntas.addEventListener("change",()=>{
    $divPosiblesRespuestas.innerHTML = "";

    let cantidad  = $selectCantidadPreguntas.value;
    for(i = 1; i<=cantidad; i++){
        $divPosiblesRespuestas.innerHTML +=`<label class='label_respuesta'>Respuesta ${i}
        </label><input type="radio" class="input_esCorrecta" name="esCorrecta" value="${i}">`;

        $divPosiblesRespuestas.innerHTML += "<input class='respuesta_pregunta' type='text' name='respuesta"+i+"'>";
    }
});