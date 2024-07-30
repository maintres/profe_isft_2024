<?php
include '../../conn/connection.php';

// Variables para almacenar los valores del formulario y mensajes de error
$profesor_id = $materia_id = $tipo = $error = "";
$etapa = "activo";

// Procesamiento del formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recolecta datos del formulario y realiza validaciones
    $profesor_id = trim($_POST["profesor_id"]);
    $materia_id = trim($_POST["materia_id"]);
    $tipo = trim($_POST["tipo"]);

    // Validar campos obligatorios
    if (empty($profesor_id) || empty($materia_id) || empty($tipo)) {
        $error = "Por favor complete todos los campos obligatorios.";
    } else {
        try {
            // Inserta datos en la tabla dicta
            $sql = "INSERT INTO dicta (FKprofesor, FKmateria, tipo, etapa) 
                    VALUES (:profesor_id, :materia_id, :tipo, :etapa)";
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':profesor_id', $profesor_id);
            $stmt->bindParam(':materia_id', $materia_id);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':etapa', $etapa);
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

// Obtener listas de profesores y materias para select options
$query_profesores = "SELECT id, nombreyapellido FROM profesores ORDER BY nombreyapellido";
$result_profesores = $db->query($query_profesores);

$query_materias = "SELECT id, nombre FROM asignaturas ORDER BY nombre";
$result_materias = $db->query($query_materias);
?>

<?php require 'navbar.php'; ?>

<div class="container mt-3">
    <div class="card rounded-2 border-0">
        <h5 class="card-header bg-dark text-white">Agregar Nueva Asignación</h5>
        <div class="card-body bg-light">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="profesor_id">Profesor:</label>
                    <select name="profesor_id" class="form-control">
                        <option value="">Seleccione un profesor</option>
                        <?php while ($row = $result_profesores->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nombreyapellido']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="materia_id">Materia:</label>
                    <select name="materia_id" class="form-control">
                        <option value="">Seleccione una materia</option>
                        <?php while ($row = $result_materias->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nombre']); ?></option>
                        <?php endwhile; ?>
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
