<script src="assets/js/core/jquery-3.7.1.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>

<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<!-- Para los iconos del ojo -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- jQuery Scrollbar -->
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- Chart JS -->
<script src="assets/js/plugin/chart.js/chart.min.js"></script>

<!-- jQuery Sparkline -->
<script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

<!-- Chart Circle -->
<script src="assets/js/plugin/chart-circle/circles.min.js"></script>

<!-- Datatables -->
<script src="assets/js/plugin/datatables/datatables.min.js"></script>

<!-- Bootstrap Notify -->
<script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

<!-- jQuery Vector Maps -->
<script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
<script src="assets/js/plugin/jsvectormap/world.js"></script>

<!-- Sweet Alert -->
<script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

<!-- Kaiadmin JS -->
<script src="assets/js/kaiadmin.min.js"></script>

<!-- Kaiadmin DEMO methods, don't include it in your project! -->
<!-- <script src="assets/js/setting-demo.js"></script>
<script src="assets/js/demo.js"></script> -->
<script>
    $('#lineChart').sparkline([102,109,120,99,110,105,115], {
        type: 'line',
        height: '70',
        width: '100%',
        lineWidth: '2',
        lineColor: '#177dff',
        fillColor: 'rgba(92, 107, 245, 0.14)'
    });

    $('#lineChart2').sparkline([99,125,122,105,110,124,115], {
        type: 'line',
        height: '70',
        width: '100%',
        lineWidth: '2',
        lineColor: '#f3545d',
        fillColor: 'rgba(245, 111, 111, 0.18)'
    });

    $('#lineChart3').sparkline([105,103,123,100,95,105,115], {
        type: 'line',
        height: '70',
        width: '100%',
        lineWidth: '2',
        lineColor: '#ffa534',
        fillColor: 'rgba(255, 165, 52, .14)'
    });
</script>

<script>
    function togglePassword() {
        var passwordField = document.getElementById("usuClave"); //Obtiene el campo de entrada de la contraseña.
        var toggleIcon = document.getElementById("toggleIcon");//Obtiene el icono del ojo.
        
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
            //de tipo "password", se cambia a "text" para mostrar la contraseña.
            //Si es de tipo "text", se cambia de nuevo a "password" para ocultarla.
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
            // Si la contraseña es visible (text), cambia fa-eye a fa-eye-slash.

            // Si la contraseña está oculta (password), cambia fa-eye-slash a fa-eye.

        }
    }
</script>


<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const usuario = document.getElementById('usuario').value;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(usuario)) {
            e.preventDefault(); // Detiene el envío del formulario
            alert('Por favor, ingrese un correo electrónico válido.');
        }
    });
</script>


<!-- script para el popup de acceso -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const params = new URLSearchParams(window.location.search);

        if (params.get("auth") === "false") {
            Swal.fire({
                icon: 'warning',
                title: 'Acceso restringido',
                text: 'Para continuar con esta funcionalidad, es necesario iniciar sesión.',
                confirmButtonText: ' OK '
            })
                
        }
    });
</script>
