
console.log(localStorage.getItem("botAcerto"));

if(localStorage.getItem("botPuntaje") != null || localStorage.getItem("botPuntaje") != undefined)
    document.querySelector("#bot__puntaje").textContent = localStorage.getItem("botPuntaje");

$acerto = localStorage.getItem("botAcerto");

//Se ejecuta si sigue acertando
if($acerto != "false"){
    let botRespondiendo = setInterval(()=>{
        $.ajax({
            url:"/quizquest/bot/get",
            type:"GET",
            datatype: 'json',
            success: function(botPuntajeAcertoJson){
                console.log(botPuntajeAcertoJson);
                document.querySelector("#bot__puntaje").textContent = botPuntajeAcertoJson.botPuntaje;
                
                //Mantener la fluides en la parte del cliente
                localStorage.setItem("botPuntaje",  JSON.stringify(botPuntajeAcertoJson.botPuntaje));
                localStorage.setItem("botAcerto",  JSON.stringify(botPuntajeAcertoJson.acerto));

                if(botPuntajeAcertoJson.acerto  == false){
                    document.querySelector(".contador_puntaje__bot").classList.add("contador_puntaje__bot__desactivado");
                    console.log("Terminado")
                    clearInterval(botRespondiendo);
                }
            }
        });
    },Math.floor(Math.random() * (7000 - 3000 + 1)) + 3000);
}

//Se ejecuta si ya respondio mal
if($acerto == "false"){
    document.querySelector(".contador_puntaje__bot").classList.add("contador_puntaje__bot__desactivado");
}
