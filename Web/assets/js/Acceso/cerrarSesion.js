
$(document).ready(function() {
    $("#cerrarSesion").click(function(event) {
        event.preventDefault();
        
        let form = $(this);
        let url = form.attr("data-url");
        Swal.fire({
            title: '¿Quieres cerrar sesión?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí",
            cancelButtonText: "No"
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: [],
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(data) {
                        if (data.success) {
                            window.location.href = data.redirectUrl;
                        } 
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la solicitud AJAX:", error);
                    }
                });
            }
        });
       
    });

});