const $contadorTiempoElem = document.querySelector("#contador_tiempo");
//Temporizador
setInterval(()=>{
    $.ajax({
        url:"/quizquest/contar/get",
        type:"GET",
        datatype: 'json',
        success: function($temporizador){ //Recibe el json
            console.log($temporizador);
            $contadorTiempoElem.innerHTML = $temporizador.segundos;
            if($temporizador.segundos == 0) // Si llega a cero , pierde y va a la vista final de la partida 
                location.href="http://localhost/quizquest/juego/goToTheEnd";
        }
    });
},1000);
