import { abrirVentana,cerrarVentana } from "./abrir_cerrar_ventana.js";

document.addEventListener("DOMContentLoaded", ()=>{

    document.addEventListener("click", (e)=>{
        if(!e.target.matches("#ir__ranking") && !e.target.matches("#ir__partida") && !e.target.matches("#salir") 
           && !e.target.matches("#crear__partida__boton") && !e.target.matches("#ver__sugerencias__ventana")
            && !e.target.matches(".input_esCorrecta") && !e.target.matches(".popup__boton"))
            e.preventDefault();

        //Crear partida popup
        if(e.target.matches("#abrir__crear__ventana") || e.target.matches("#abrir__crear__ventana *"))
            abrirVentana("#crear__partida__ventana");
        if(e.target.matches("#cerrar__crear__ventana") || e.target.matches("#cerrar__crear__ventana *"))
            cerrarVentana("#crear__partida__ventana");

        //Crear pregunta popup
        if(e.target.matches("#abrir__pregunta__ventana") || e.target.matches("#abrir__pregunta__ventana *"))
            abrirVentana("#crear__pregunta__ventana");
        if(e.target.matches("#cerrar__pregunta__ventana") || e.target.matches("#cerrar__pregunta__ventana *"))
            cerrarVentana("#crear__pregunta__ventana");
    });
})