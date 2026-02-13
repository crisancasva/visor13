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
    

    $(document).on("change","#orientacion",function(){
        let orien = $(this).val();
        let url = $(this).attr("data-url");
        
        $.ajax({
            url: url,
            method: "POST",
            data: {
                orien: orien
            },
            success: function(data){
                $("#senal").html(data);
            }
        })
    });
    $(document).on("change","#senal",function(){
        let csencod = $(this).val();
        let url = $(this).attr("data-url");
        
        $.ajax({
            url: url,
            method: "POST",
            data: {
                csencod: csencod
            },
            success: function(data){
                $("#catesenal").html(data);
            }
        })
    });
    $("#solicitudNuevaSenal").submit(function(event) {
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
                    showPopup('success', false, "Solicitud enviada exitosamente", data.message);
                
                } else {
                    showPopup('error', false, 'Error', data.message || 'Ocurrió un error al enviar la solicitud.');
                }
            },
            error: function(xhr, status, error) {
                console.log("Error en la solicitud AJAX:", error);
                showPopup('error', false, 'Error', 'No se pudo procesar la solicitud');
            }
        });
    });

});



  // Obtener referencias a los campos
  const tipoDireccion = document.getElementById('tipoDireccion');
  const numeroVia = document.getElementById('numeroVia');
  const prefijo = document.getElementById('prefijo');
  const numero = document.getElementById('numero');
  const direccionCompleta = document.getElementById('direccionCompleta');

  // Función para actualizar la direccion completa
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