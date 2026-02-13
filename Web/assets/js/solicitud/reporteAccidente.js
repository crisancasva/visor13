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
  
    $('#numvehiculo').on("input", function() {
    let numvehiculo = $(this).val();
    if (numvehiculo > 5) {
            $(this).val(1);
            showPopup('error',false,'Error','EL valor no puede ser mayor a 5');

    } else if (numvehiculo < 0) {
        $(this).val(1);
        showPopup('error',false,'Error','EL valor no puede ser menor a 0');

    }
    });
    document.getElementById("numvehiculo").addEventListener("input", function(event) {
        // Filtra cualquier caracter que no sea un número
        const valor = event.target.value;
        event.target.value = valor.replace(/\D/g, ""); // Elimina cualquier carácter que no sea dígito (0-9)
    });
    document.getElementById("lesionados").addEventListener("input", function(event) {
        // Filtra cualquier caracter que no sea un número
        const valor = event.target.value;
        event.target.value = valor.replace(/\D/g, ""); // Elimina cualquier carácter que no sea dígito (0-9)
    });
    $('#tiposiniestro').on("change", function() {
        const valor = $(this).val();
        let url = $("#tiposiniestro").data("url");;
        if (valor > 0) {
        $.ajax({
            url: url,
            method: 'POST',
            data: { tiposiniestro: valor },
            success: function(response) {
            $('#otrotipo').html(response);
            }
        });
        } else {
        $('#otrotipo').html('');
        }
    });
    
      const form = $("#reporteAccidente");
    $('#numvehiculo').on("input", function() {
        const valor = $(this).val();
        let url = $("#numvehiculo").data("url");;
        if (valor > 0) {
        $.ajax({
            url: url,
            method: 'POST',
            data: { numvehiculo: valor },
            success: function(response) {
            $('#vehiseleccionado').html(response);
            }
        });
        } else {
        $('#vehiseleccionado').html('');
        }
    });

    $("#reporteAccidente").submit(function(event) {
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
                    showPopup('success', data.redirectUrl, "Solicitud enviada exitosamente", data.message);
                
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