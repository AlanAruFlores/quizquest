import { abrirVentana,cerrarVentana } from "./abrir_cerrar_ventana.js";

document.addEventListener("DOMContentLoaded", ()=>{
    document.addEventListener("click", (e)=>{
            //Cerrar reportar popup de la vista juego
            if(e.target.matches("#reportar__cerrar") || e.target.matches("#reportar__cerrar *"))
                cerrarVentana(".pop__up__reportar");
            if(e.target.matches("#boton__reportar") || e.target.matches("#boton__reportar *"))
                abrirVentana(".pop__up__reportar");
    })
})