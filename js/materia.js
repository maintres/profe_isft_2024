document.getElementById('continuarBtn').addEventListener('click', function() {
    document.getElementById('formulario-ingreso').style.display = 'none';
    document.getElementById('confirmacion').style.display = 'block';

    document.getElementById('confirmarNombre').textContent = document.getElementById('nombre').value;
    document.getElementById('confirmarDescripcion').textContent = document.getElementById('descripcion').value;
    document.getElementById('confirmarHoras').textContent = document.getElementById('horas').value;
    document.getElementById('confirmarResolucion').textContent = document.getElementById('num_resolucion').value;
    document.getElementById('confirmarAño').textContent = document.getElementById('año').value;
    document.getElementById('confirmarPlan').textContent = document.getElementById('plan_estudio').value;

    // Obtener texto del select de Tipo de Materia
    var tipoSelect = document.getElementById('id_tipo');
    var tipoText = tipoSelect.options[tipoSelect.selectedIndex].text;
    document.getElementById('confirmarTipo').textContent = tipoText;

    let correlativasSeleccionadas = Array.from(document.querySelectorAll('input[name="correlativas[]"]:checked'))
        .map(el => el.parentElement.parentElement.previousElementSibling.textContent)
        .join(', ');
    document.getElementById('confirmarCorrelativas').textContent = correlativasSeleccionadas || 'Sin correlativas';

    document.querySelector('input[name="nombre"]').value = document.getElementById('nombre').value;
    document.querySelector('input[name="descripcion"]').value = document.getElementById('descripcion').value;
    document.querySelector('input[name="horas"]').value = document.getElementById('horas').value;
    document.querySelector('input[name="num_resolucion"]').value = document.getElementById('num_resolucion').value;
    document.querySelector('input[name="año"]').value = document.getElementById('año').value;
    document.querySelector('input[name="plan_estudio"]').value = document.getElementById('plan_estudio').value;
    document.querySelector('input[name="id_tipo"]').value = document.getElementById('id_tipo').value;
    
    // Actualizar correlativas ocultas
    document.querySelectorAll('.form-check.d-none input[name="correlativas[]"]').forEach(el => el.parentElement.remove());
    document.querySelectorAll('input[name="correlativas[]"]:checked').forEach(el => {
        let hiddenCheckbox = document.createElement('input');
        hiddenCheckbox.type = 'checkbox';
        hiddenCheckbox.className = 'form-check-input d-none';
        hiddenCheckbox.name = 'correlativas[]';
        hiddenCheckbox.value = el.value;
        hiddenCheckbox.checked = true;
        document.querySelector('.form-check.d-none').appendChild(hiddenCheckbox);
    });
});

document.getElementById('cancelarBtn').addEventListener('click', function() {
    document.getElementById('confirmacion').style.display = 'none';
    document.getElementById('formulario-ingreso').style.display = 'block';
});