<?php
include '../../conn/connection.php';

// Variables para almacenar los valores del formulario y mensajes de error
$id = $profesor_id = $materia_id = $tipo = $baja = $fecha_baja = $motivo_baja = "";
$error = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos actuales del registro
    $sql = "SELECT * FROM dicta WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($registro) {
        $profesor_id = $registro['FKprofesor'];
        $materia_id = $registro['FKmateria'];
        $tipo = $registro['tipo'];
        $baja = $registro['Baja'];
        $fecha_baja = $registro['Fecha_baja'];
        $motivo_baja = $registro['motivo_baja'];
    } else {
        echo "Registro no encontrado.";
        exit();
    }
}

// Procesamiento del formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recolecta datos del formulario y realiza validaciones
    $profesor_id = trim($_POST["profesor_id"]);
    $materia_id = trim($_POST["materia_id"]);
    $tipo = trim($_POST["tipo"]);
    $baja = isset($_POST["baja"]) ? "SI" : "NO";
    $fecha_baja = !empty($_POST["fecha_baja"]) ? trim($_POST["fecha_baja"]) : NULL;
    $motivo_baja = !empty($_POST["motivo_baja"]) ? trim($_POST["motivo_baja"]) : NULL;

    // Validar campos obligatorios
    if (empty($profesor_id) || empty($materia_id) || empty($tipo)) {
        $error = "Por favor complete todos los campos obligatorios.";
    } else {
        try {
            // Actualizar datos en la tabla dicta
            $sql = "UPDATE dicta SET FKprofesor = :profesor_id, FKmateria = :materia_id, tipo = :tipo, Baja = :baja, Fecha_baja = :fecha_baja, motivo_baja = :motivo_baja WHERE id = :id";
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':profesor_id', $profesor_id);
            $stmt->bindParam(':materia_id', $materia_id);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':baja', $baja);
            $stmt->bindParam(':fecha_baja', $fecha_baja);
            $stmt->bindParam(':motivo_baja', $motivo_baja);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: dicta_index.php?mensaje=" . urlencode("Asignación editada con éxito."));
                exit();
            } else {
                $error = "Error al actualizar la asignación.";
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
        <h5 class="card-header bg-dark text-white">Editar Asignación</h5>
        <div class="card-body bg-light">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
                <div class="form-group">
                    <label for="profesor_id">Profesor:</label>
                    <select name="profesor_id" class="form-control">
                        <option value="">Seleccione un profesor</option>
                        <?php while ($row = $result_profesores->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value="<?php echo $row['id']; ?>" <?php echo $profesor_id == $row['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($row['nombreyapellido']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="materia_id">Materia:</label>
                    <select name="materia_id" class="form-control">
                        <option value="">Seleccione una materia</option>
                        <?php while ($row = $result_materias->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value="<?php echo $row['id']; ?>" <?php echo $materia_id == $row['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($row['nombre']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo de Asignación:</label>
                    <select name="tipo" class="form-control">
                        <option value="">Seleccione un tipo</option>
                        <option value="titular" <?php echo $tipo == 'titular' ? 'selected' : ''; ?>>Titular</option>
                        <option value="interino" <?php echo $tipo == 'interino' ? 'selected' : ''; ?>>Interino</option>
                        <option value="suplente" <?php echo $tipo == 'suplente' ? 'selected' : ''; ?>>Suplente</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="baja">Baja:</label>
                    <input type="checkbox" name="baja" value="SI" <?php echo $baja == "SI" ? 'checked' : ''; ?>> Marcar si tiene baja
                </div>
                <div class="form-group">
                    <label for="fecha_baja">Fecha de Baja:</label>
                    <input type="date" name="fecha_baja" class="form-control" value="<?php echo htmlspecialchars($fecha_baja); ?>">
                </div>
                <div class="form-group">
                    <label for="motivo_baja">Motivo de Baja:</label>
                    <textarea name="motivo_baja" class="form-control"><?php echo htmlspecialchars($motivo_baja); ?></textarea>
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
