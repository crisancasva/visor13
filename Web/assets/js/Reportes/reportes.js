function showPopup(icon, redirectUrl, title, text, confirmButton) {
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
        timer: 2000,
        showConfirmButton: confirmButton
    }).then((result) => {
        
        if (result.dismiss === Swal.DismissReason.timer) {
            if (redirectUrl) {
                window.location.href = redirectUrl;
            }
          }
    });
}

$(document).ready(function() {
    // Escuchar el evento click en los enlaces con clase "ajax-trigger"
    $(".ajax-trigger").click(function(event) {
        event.preventDefault(); // Evitar que el enlace redirija directamente

        let url = $(this).attr("href"); // Obtener la URL del atributo href
        let formData = {}; // Puedes enviar datos adicionales si es necesario

        $.ajax({
            url: url,
            type: "POST", // O "GET" si necesitas una solicitud GET
            data: formData, // Datos opcionales
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(data) {
                if (data.success) {
                  // Abrir el archivo en una nueva página para que se descargue
                window.open(data.redirectUrl, "_blank");

                } else {
                    showPopup('error', false, 'Error', data.message, true);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", error);
                showPopup('error', false, 'Error', 'No se pudo procesar la solicitud');
            }
        });
    });
});