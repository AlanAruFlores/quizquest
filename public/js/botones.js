document.getElementById('filtro').addEventListener('change', function() {
    var filtro = this.value;
    var selectPais = document.getElementById('selectPais');
    var selectEdad = document.getElementById('selectEdad');
    var selectSexo = document.getElementById('selectSexo');

    selectPais.classList.add('hidden');
    selectEdad.classList.add('hidden');
    selectSexo.classList.add('hidden');

    if (filtro === 'pais') {
        selectPais.classList.remove('hidden');
    } else if (filtro === 'edad') {
        selectEdad.classList.remove('hidden');
    } else if (filtro === 'sexo') {
        selectSexo.classList.remove('hidden');
    }
});

document.querySelectorAll('.elemento').forEach(button => {
    button.addEventListener('click', function() {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.style.display = 'none';
        });

        // Muestra el menú desplegable del elemento seleccionado
        const dropdownMenu = this.nextElementSibling;
        dropdownMenu.style.display = 'block';
    });
});

// Cierra el menú desplegable si se hace clic fuera de él
window.addEventListener('click', function(event) {
    if (!event.target.matches('.elemento')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.style.display = 'none';
        });
    }
});