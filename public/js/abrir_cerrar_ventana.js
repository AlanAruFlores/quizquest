//Para abri y cerrar ventanas
export function abrirVentana(ventana) {
    const $ventanaElem = document.querySelector(ventana);
    $ventanaElem.style.setProperty("visibility", "visible");
    $ventanaElem.style.setProperty("opacity", 1);
}

export function cerrarVentana(ventana) {
    const $ventanaElem = document.querySelector(ventana);
    $ventanaElem.style.setProperty("visibility", "hidden");
    $ventanaElem.style.setProperty("opacity", 0);
}