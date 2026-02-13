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

    document.getElementById("correo").addEventListener("keypress", function(e) {
        const tecla = String.fromCharCode(e.which);
        const permitidos = /^[a-zA-Z0-9@._-]$/;
    
        if (!permitidos.test(tecla)) {
          e.preventDefault(); // Bloquea el carácter
        }
      });


    $("#insert-user").submit(function(event) {
        event.preventDefault();
        
        let form = $(this);
        let formData = new FormData(this);
        let password = $("#usuClave").val();
        let confirmPassword = $("#usuConfirmarClave").val();
        let url = form.attr("action");

        // Validar contraseña
        let passwordPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[#\$%&/*])[A-Za-z\d#$%&/*]{8,}$/;

        if (!passwordPattern.test(password)) {
            showPopup('error', false, "Contraseña incorrecta", "Contraseña no válida.");
            return;
        }

        // Validar que ambas contraseñas coincidan
        if (password !== confirmPassword) {
            showPopup('error', false, "Contraseñas no coinciden", "Ambas contraseñas deben ser iguales.");
            return;
        }



        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(data) {
                if (data.success) {
                    showPopup('success', data.redirectUrl, 'Registro exitoso', data.message);
                
                } else {
                    showPopup('error', false, 'Error', data.message || 'Ocurrió un error al registrar el usuario.');
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

    // Mostrar/ocultar confirmar contraseña
    window.toggleConfirmPassword = function() {
        let confirmField = $("#usuConfirmarClave");
        let toggleIcon = $("#toggleConfirmIcon");
        if (confirmField.attr("type") === "password") {
            confirmField.attr("type", "text");
            toggleIcon.removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            confirmField.attr("type", "password");
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