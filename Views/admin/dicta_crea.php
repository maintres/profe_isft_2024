<?php
include '../../conn/connection.php';

// Variables para almacenar los valores del formulario y mensajes de error
$usuario_id = $materia_id = $tipo = $carrera_id = $error = "";
$etapa = "Activo"; // Actualizado a "Activo"

// Procesamiento del formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recolecta datos del formulario y realiza validaciones
    $usuario_id = trim($_POST["usuario_id"]);
    $materia_id = trim($_POST["materia_id"]);
    $tipo = trim($_POST["tipo"]);
    $carrera_id = trim($_POST["carrera_id"]);

    // Validar campos obligatorios
    if (empty($usuario_id) || empty($materia_id) || empty($tipo) || empty($carrera_id)) {
        $error = "Por favor complete todos los campos obligatorios.";
    } else {
        try {
            // Inserta datos en la tabla dicta
            $sql = "INSERT INTO dicta (usuario_id, FKmateria, tipo, etapa, FK_carrera) 
                    VALUES (:usuario_id, :materia_id, :tipo, :etapa, :carrera_id)";
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':materia_id', $materia_id);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':etapa', $etapa);
            $stmt->bindParam(':carrera_id', $carrera_id);
            if ($stmt->execute()) {
                header("Location: dicta_index.php?mensaje=" . urlencode("Asignación agregada con éxito."));
                exit();
            } else {
                $error = "Error al ingresar la asignación.";
            }
        } catch (PDOException $e) {
            $error = "Error en la base de datos: " . $e->getMessage();
        }
    }
}

// Obtener listas de usuarios, carreras y materias para select options
$query_usuarios = "SELECT id_usuario, CONCAT(nombre, ' ', apellido) AS nombreyapellido 
                   FROM usuarios 
                   WHERE id_rol = 2 
                   ORDER BY nombreyapellido";
$result_usuarios = $db->query($query_usuarios);

$query_carreras = "SELECT id, nombre FROM carreras ORDER BY nombre";
$result_carreras = $db->query($query_carreras);
?>

<?php require 'navbar.php'; ?>

<div class="container mt-3 w-50">
    <div class="card rounded-2 border-0 row d-flex justify-content-center">
        <h5 class="card-header bg-dark text-white">Agregar Nueva Asignación</h5>
        <div class="card-body bg-light">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="usuario_id">Profesor:</label>
                    <select name="usuario_id" class="form-control">
                        <option value="">Seleccione un profesor</option>
                        <?php while ($row = $result_usuarios->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value="<?php echo $row['id_usuario']; ?>"><?php echo htmlspecialchars($row['nombreyapellido']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="carrera_id">Carrera:</label>
                    <select id="carrera_id" name="carrera_id" class="form-control">
                        <option value="">Seleccione una carrera</option>
                        <?php while ($row = $result_carreras->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nombre']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="materia_id">Materia:</label>
                    <select id="materia_id" name="materia_id" class="form-control">
                        <option value="">Seleccione una materia</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo de Asignación:</label>
                    <select name="tipo" class="form-control">
                        <option value="">Seleccione un tipo</option>
                        <option value="titular">Titular</option>
                        <option value="interino">Interino</option>
                        <option value="suplente">Suplente</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
                <?php if (!empty($error)) : ?>
                    <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>

<script>
document.getElementById('carrera_id').addEventListener('change', function() {
    var carreraId = this.value;
    var materiaSelect = document.getElementById('materia_id');

    // Limpia las materias anteriores
    materiaSelect.innerHTML = '<option value="">Seleccione una materia</option>';

    if (carreraId) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_materias.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var materias = JSON.parse(xhr.responseText);
                materiaSelect.innerHTML = '<option value="">Seleccione una materia</option>'; // Limpiar primero
                for (var i = 0; i < materias.length; i++) {
                    var option = document.createElement('option');
                    option.value = materias[i].id;
                    option.textContent = materias[i].nombre;
                    materiaSelect.appendChild(option);
                }
            }
        };
        xhr.send('carrera_id=' + carreraId);
    }
});
</script>
