
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


$(document).ready(function(){
    
    $("#pqrsf").submit(function(event) {
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Solicitud enviada exitosamente',
                        text: data.message || 'Tu solicitud fue enviada correctamente',
                    }).then(() => {
                        // Limpiar el formulario
                        const form = document.getElementById("pqrsf");
                        form.reset();

                        // Restaurar el checkbox si el usuario no está logueado
                        if (typeof usuarioLogueado !== "undefined" && usuarioLogueado === false) {
                            const anonimoCheckbox = document.getElementById('anonimo');
                            anonimoCheckbox.checked = true;
                            anonimoCheckbox.disabled = true;

                            const advertencia = document.getElementById('advertenciaAnonimo');
                            advertencia.classList.remove('d-none');
                        }
        
                    });
            
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Ocurrió un error al enviar la solicitud.',
                    });
                }
            }
        });
    });

});




document.addEventListener('DOMContentLoaded', function () {
    const anonimoCheckbox = document.getElementById('anonimo');
    const advertencia = document.getElementById('advertenciaAnonimo');

    if (!anonimoCheckbox || !advertencia) return; // Por si no están en el DOM

    anonimoCheckbox.addEventListener('change', function () {
        if (this.checked) {
            advertencia.classList.remove('d-none');
        } else {
            advertencia.classList.add('d-none');
        }
    });

    // Si el usuario NO está logueado, forzamos el modo anónimo
    if (typeof usuarioLogueado !== "undefined" && usuarioLogueado === false) {
        advertencia.classList.remove('d-none');
        anonimoCheckbox.checked = true;
        anonimoCheckbox.disabled = true;
    }
});





