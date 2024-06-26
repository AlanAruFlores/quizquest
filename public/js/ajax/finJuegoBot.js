if(localStorage.getItem("botPuntaje") != null || localStorage.getItem("botPuntaje") != undefined)
    document.querySelector("#bot__puntaje").textContent = localStorage.getItem("botPuntaje");

$acerto = localStorage.getItem("botAcerto");
if($acerto != "false"){
    let botRespondiendo = setInterval(()=>{
        $.ajax({
            url:"/quizquest/bot/get",
            type:"GET",
            datatype: 'json',
            success: function(botPuntajeAcertoJson){
                console.log(botPuntajeAcertoJson);
                document.querySelector("#bot__puntaje").textContent = botPuntajeAcertoJson.botPuntaje;
                localStorage.setItem("botPuntaje",  JSON.stringify(botPuntajeAcertoJson.botPuntaje));
                localStorage.setItem("botAcerto",  JSON.stringify(botPuntajeAcertoJson.acerto));

                if(botPuntajeAcertoJson.acerto  == false){
                    document.querySelector(".contador_puntaje__bot").classList.add("contador_puntaje__bot__desactivado");
                    console.log("Terminado")

                    document.querySelector("#resultadoParrafo").textContent = imprimirGanador();
                    document.querySelector(".popup__espera").innerHTML+=`
                     <a href="/quizquest/juego/goToLobby" class="popup__boton">Continuar</a>
                    `   
                    clearInterval(botRespondiendo);
                }
            }
        });
    },Math.floor(Math.random() * (7000 - 3000 + 1)) + 3000);
}

if($acerto == "false"){
    document.querySelector(".contador_puntaje__bot").classList.add("contador_puntaje__bot__desactivado");
    document.querySelector("#resultadoParrafo").textContent = imprimirGanador();
    document.querySelector(".popup__espera").innerHTML+=`
        <a href="/quizquest/juego/goToLobby" class="popup__boton">Continuar</a>
    `;
}


function imprimirGanador(){
    let puntajeJugador = document.querySelector("#puntajeJugador").dataset.puntaje;
    if(parseInt(puntajeJugador) > parseInt(localStorage.getItem("botPuntaje")))
        return "Le ganaste al Bot !!"

    return "Esta vez perdiste contra el Bot !!"
}