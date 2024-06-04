import { abrirVentana,cerrarVentana } from "./abrir_cerrar_ventana.js";

document.addEventListener("DOMContentLoaded", ()=>{

    document.addEventListener("click", (e)=>{
        if(!e.target.matches("#ir__ranking") && !e.target.matches("#ir__partida") && !e.target.matches("#salir") 
           && !e.target.matches("#crear__partida__boton") && !e.target.matches("#ver__sugerencias__ventana"))
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

        //Ver sugerencias popup
        if(e.target.matches("#abrir__sugerencias__ventana") || e.target.matches("#abrir__sugerencias__ventana *"))
            abrirVentana("#ver__sugerencias__ventana");
        if(e.target.matches("#cerrar__sugerencias__ventana") || e.target.matches("#cerrar__sugerencias__ventana *"))
            cerrarVentana("#ver__sugerencias__ventana");

        if (e.target.matches(".sugerencia__item")) {
            const opcion = e.target.dataset.opcion;

            document.querySelectorAll(".detalle__contenido").forEach(item => item.classList.add("inactivo"));
            document.querySelectorAll(".sugerencia__item").forEach(item => item.classList.remove("activo"))
            document.getElementById(opcion).classList.remove("inactivo");
            document.getElementById(opcion).classList.add("activo");
            e.target.classList.add("activo");
        }

        //Ver reportes popup
        if(e.target.matches("#abrir__reportes__ventana") || e.target.matches("#abrir__reportes__ventana *"))
            abrirVentana("#ver__reportes__ventana");
        if(e.target.matches("#cerrar__reportes__ventana") || e.target.matches("#cerrar__reportes__ventana *"))
            cerrarVentana("#ver__reportes__ventana");

        if (e.target.matches(".reporte__item")) {
            const reporte = e.target.dataset.opcion;

            document.querySelectorAll(".detalle__contenido").forEach(item => item.classList.add("inactivo"));
            document.querySelectorAll(".reporte__item").forEach(item => item.classList.remove("activo"))
            document.getElementById(reporte).classList.remove("inactivo");
            document.getElementById(reporte).classList.add("activo");
            e.target.classList.add("activo");
        }
    });

})