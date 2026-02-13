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




function showPopup(icon, redirectUrl, title, text) {
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
    }).then(() => {
        if (redirectUrl) {
            window.location.href = redirectUrl;
        }
    });
}

$(document).ready(function() {
    $("#administrador").submit(function(event) {
        event.preventDefault();
        
        let form = $(this);
        let formData = new FormData(this);
        let url = form.attr("action");

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(data) {
                if (data.success) {
                    showPopup('success', data.redirectUrl, 'Actualización exitosa', data.message);
                
                } else {
                    showPopup('error', false, 'Error', data.message || 'Ocurrió un error al actualizar los datos.');
                }
            },
            error: function(xhr, status, error) {
                console.log("Error en la solicitud AJAX:", error);
                showPopup('error', false, 'Error', 'No se pudo procesar la solicitud');
            }
        });
    });

    // Mostrar/ocultar contraseña
    window.togglePassword = function() {
        let passwordField = $("#usuClave");
        let toggleIcon = $("#toggleIcon");
        if (passwordField.attr("type") === "password") {
            passwordField.attr("type", "text");
            toggleIcon.removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            passwordField.attr("type", "password");
            toggleIcon.removeClass("fa-eye-slash").addClass("fa-eye");
        }
    };

    
});


 // Obtener referencias a los campos
 const tipoDireccion = document.getElementById('tipoDireccion');
 const numeroVia = document.getElementById('numeroVia');
 const prefijo = document.getElementById('prefijo');
 const numero = document.getElementById('numero');
 const direccionCompleta = document.getElementById('direccionCompleta');

 // Función para actualizar la dirección completa
 function actualizarDireccion() {
     const tipo = tipoDireccion.value;
     const numeroLetras = numeroVia.value;
     const pref = prefijo.value ? ` ${prefijo.value}` : '';
     const numeroFinal = numero.value ? ` #${numero.value}` : '';
     direccionCompleta.value = ` ${tipo} ${numeroLetras}${pref}${numeroFinal}`;
 }

 // Event listeners para actualizar en tiempo real
 tipoDireccion.addEventListener('change', actualizarDireccion);
 numeroVia.addEventListener('input', actualizarDireccion);
 prefijo.addEventListener('change', actualizarDireccion);
 numero.addEventListener('input', actualizarDireccion);


 
