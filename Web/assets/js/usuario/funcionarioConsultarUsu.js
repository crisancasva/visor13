document.getElementById('filtroBuscar').addEventListener('keyup', function() {
    let filtro = this.value.toLowerCase();
    let filas = document.querySelectorAll('#tablaConsultar tbody tr');
    let sinResultados = document.getElementById('filaSinResultados');
    let totalVisibles = 0;

    filas.forEach(function(fila) {
        // No cuenta la fila del mensaje
        if (fila.id !== 'filaSinResultados') {
            let textoFila = fila.textContent.toLowerCase();
            if (textoFila.includes(filtro)) {
                fila.style.display = '';
                totalVisibles++;
            } else {
                fila.style.display = 'none';
            }
        }
    });

    // Mostrar u ocultar el mensaje
    sinResultados.style.display = totalVisibles === 0 ? '' : 'none';
});



function limpiarFiltros() {
    document.getElementById('filtroBuscar').value = '';
    let filas = document.querySelectorAll('#tablaConsultar tbody tr');

    filas.forEach(function(fila) {
        fila.style.display = fila.id !== 'filaSinResultados' ? '' : 'none';
    });
}
