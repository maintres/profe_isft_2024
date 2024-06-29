document.getElementById('formulario').addEventListener('submit', function(event) {
    const fechaNacimiento = new Date(document.getElementById('fecha_nacimiento').value);
    const fechaActual = new Date();
    const edad = fechaActual.getFullYear() - fechaNacimiento.getFullYear();
    const mes = fechaActual.getMonth() - fechaNacimiento.getMonth();

    if (mes < 0 || (mes === 0 && fechaActual.getDate() < fechaNacimiento.getDate())) {
        edad--;
    }

    let error = false;

    if (edad < 18) {
        document.getElementById('edadError').innerText = 'Debe ser mayor de edad para registrarse.';
        error = true;
    } else {
        document.getElementById('edadError').innerText = '';
    }

    if (error) {
        event.preventDefault();
    }
});
document.getElementById('dni').addEventListener('input', function(event) {
    const campo = event.target;
    const valido = document.getElementById('dniOK');

    // Expresión regular para validar números de DNI en Argentina (7 u 8 dígitos numéricos)
    const dniRegex = /^[0-9]{8}$/;

    if (dniRegex.test(campo.value)) {
        valido.innerText = "Número de DNI válido";
        valido.style.color = "green";
    } else {
        valido.innerText = "Número de DNI incorrecto";
        valido.style.color = "red";
    }
});
document.getElementById('celular').addEventListener('input', function(event) {
    const campo = event.target;
    const valido = document.getElementById('celularOK');
    const guardarBtn = document.getElementById('guardarBtn'); // Agregamos esta línea

    // Expresión regular para validar números de teléfono móviles argentinos con código de país "+54"
    const telefonoRegex = /^\d{10}$/;

    if (telefonoRegex.test(campo.value)) {
        valido.innerText = "Número de teléfono válido";
        valido.style.color = "green";
        guardarBtn.disabled = false; // Habilitamos el botón si el número es válido
    } else {
        valido.innerText = "Número de teléfono incorrecto";
        valido.style.color = "red";
        guardarBtn.disabled = true; // Deshabilitamos el botón si el número es incorrecto
    }
});
document.getElementById('email').addEventListener('input', function(event) {
    const campo = event.target;
    const valido = document.getElementById('emailOK');

    // Expresión regular para validar un correo electrónico con dominio "gmail.com"
    const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/i;

    if (emailRegex.test(campo.value)) {
        valido.innerText = "Correo válido";
        valido.style.color = "green";
    } else {
        valido.innerText = "Correo incorrecto";
        valido.style.color = "red";
    }
});
