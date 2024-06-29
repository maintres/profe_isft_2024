function validarFormulario() {
    if (validarCampos()) {
        // Mostrar el mensaje de confirmación
        document.getElementById('confirmacion').style.display = 'block';
    } else {
        alert('Por favor complete todos los campos requeridos antes de continuar.');
    }
}
function validarCampos() {
    var camposRequeridos = document.querySelectorAll('[required]');
    for (var i = 0; i < camposRequeridos.length; i++) {
        if (camposRequeridos[i].value.trim() === '') {
            return false; // Si hay un campo requerido vacío, la validación falla
        }
    }
    return true; // Todos los campos requeridos están completos
}

document.getElementById('cancelarBtn').addEventListener('click', function () {
    // Ocultar el mensaje de confirmación
    document.getElementById('confirmacion').style.display = 'none';
});

document.getElementById('confirmarBtn').addEventListener('click', function () {
    // Enviar el formulario cuando se confirme
    document.getElementById('formulario').submit();
});