$(document).ready(function () {
        // Función para ocultar automáticamente los mensajes después de 5 segundos
        function ocultarMensajes() {
            $(".alert").delay(50000).fadeOut(400, function () {
                $(this).remove();
                // Eliminar parámetros de mensaje de la URL después de ocultar el mensaje
                var url = window.location.href;
                history.replaceState({}, document.title, url.split("?")[0]);
            });
        }

        // Llama a la función para ocultar automáticamente los mensajes
        ocultarMensajes();
    });

