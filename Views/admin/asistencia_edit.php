<?php
require('../../conn/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['estado'])) {
    try {
        $id_asistencia = $_POST['id'];
        $estado = $_POST['estado'];

        if (!in_array($estado, ['presente', 'ausente', 'justificada'])) {
            throw new Exception('Estado de asistencia inválido.');
        }

        $sql = "UPDATE asistencia SET estado = :estado WHERE id = :id";
        $stmt = $db->prepare($sql);

        if ($stmt === false) {
            throw new Exception('Error en la preparación de la consulta: ' . $db->errorInfo()[2]);
        }

        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id_asistencia, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception('Error al actualizar el registro: ' . $stmt->errorInfo()[2]);
        }

        header("Location: asistencia_index.php?mensaje=Asistencia actualizada correctamente");
        exit();
    } catch (Exception $e) {
        $error = "Error al actualizar la asistencia: " . $e->getMessage();
    }
}

$id_asistencia = isset($_GET['id']) ? $_GET['id'] : null;

if (!empty($id_asistencia)) {
    try {
        $sql = "SELECT * FROM asistencia WHERE id = :id";
        $stmt = $db->prepare($sql);

        if ($stmt === false) {
            throw new Exception('Error en la preparación de la consulta: ' . $db->errorInfo()[2]);
        }

        $stmt->bindParam(':id', $id_asistencia, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception('Error al ejecutar la consulta: ' . $stmt->errorInfo()[2]);
        }

        $asistencia = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$asistencia) {
            throw new Exception('No se encontró la asistencia con ID ' . $id_asistencia);
        }
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
} else {
    $error = "No se proporcionó un ID válido.";
}

$sql = "SELECT a.id, u.nombre AS nombre_profesor, a.fecha, a.estado 
        FROM asistencia a
        INNER JOIN usuarios u ON a.profesor_id = u.id_usuario
        ORDER BY a.fecha DESC";

$stmt = $db->query($sql);

if ($stmt === false) {
    $error = 'Error en la consulta: ' . $db->errorInfo()[2];
}
?>
<!-- ------------------------------------------- -->
<?php require 'navbar.php'; ?>
<!-- ------------------------------------------- -->
<div class="container mt-4">
    <div class="col d-flex align-items-center justify-content-center">
        <div class="card rounded-2 border-0 w-50 ">
            <h5 class="card-header bg-dark text-white">Actualizar Asistencia de Profesor</h5>
            <div class="card-body bg-light">  
                <?php if (!empty($error)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($asistencia['id']); ?>">
                    <div class="form-group">
                        <label for="estado">Estado de Asistencia:</label>
                        <select class="form-control" id="estado" name="estado">
                            <option value="presente" <?php echo ($asistencia['estado'] === 'presente') ? 'selected' : ''; ?>>Presente</option>
                            <option value="ausente" <?php echo ($asistencia['estado'] === 'ausente') ? 'selected' : ''; ?>>Ausente</option>
                            <option value="justificada" <?php echo ($asistencia['estado'] === 'justificada') ? 'selected' : ''; ?>>Justificada</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar Asistencia</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ------------------------------------------- -->
<?php require 'footer.php'; ?>
