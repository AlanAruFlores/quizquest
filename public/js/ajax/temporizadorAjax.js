const $contadorTiempoElem = document.querySelector("#contador_tiempo");


//Temporizador
setInterval(()=>{
    $.ajax({
        url:"/quizquest/contar/get",
        type:"GET",
        datatype: 'json',
        success: function($temporizador){
            $contadorTiempoElem.innerHTML = $temporizador.segundos;
            if($temporizador.segundos == 0)
                location.href="http://localhost/quizquest/juego/goToTheEnd";
        }
    });
},1000);



