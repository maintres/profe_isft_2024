<?php
require('../../conn/connection.php');

// Verificar si se ha enviado el formulario para actualizar un registro específico
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['estado'])) {
    try {
        $id_asistencia = $_POST['id'];
        $estado = $_POST['estado'];

        // Validar que el estado de asistencia sea válido
        if (!in_array($estado, ['presente', 'ausente', 'justificada'])) {
            throw new Exception('Estado de asistencia inválido.');
        }

        // Consulta para actualizar el registro de asistencia
        $sql = "UPDATE asistencias SET estado = :estado WHERE id = :id";
        $stmt = $db->prepare($sql);

        if ($stmt === false) {
            throw new Exception('Error en la preparación de la consulta: ' . $db->errorInfo()[2]);
        }

        // Asociar parámetros e intentar ejecutar la consulta
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id_asistencia, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception('Error al actualizar el registro: ' . $stmt->errorInfo()[2]);
        }

        // Redirigir a la lista de asistencias después de la actualización
        header("Location: list_asist.php?mensaje=Asistencia actualizada correctamente");
        exit();
    } catch (Exception $e) {
        $error = "Error al actualizar la asistencia: " . $e->getMessage();
    }
}

// Obtener el ID de la asistencia a actualizar si está presente en la URL
$id_asistencia = isset($_GET['id']) ? $_GET['id'] : null;

// Consultar la información de la asistencia actual para mostrarla en el formulario
if (!empty($id_asistencia)) {
    try {
        $sql = "SELECT * FROM asistencias WHERE id = :id";
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

// Consulta SQL para obtener los registros de asistencias con nombres y apellidos de profesores
$sql = "SELECT a.id, p.nombreyapellido AS nombre_profesor, a.fecha, a.estado 
        FROM asistencias a
        INNER JOIN profesores p ON a.profesor_id = p.id
        ORDER BY a.fecha DESC"; // Puedes cambiar el orden como necesites

$stmt = $db->query($sql);

if ($stmt === false) {
    $error = 'Error en la consulta: ' . $db->errorInfo()[2];
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Asistencia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <?php require 'navbar.php'; ?>
    
    <div class="container mt-4">
        <h1 class="mb-4">Actualizar Asistencia de Profesor</h1>

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

    <?php require 'footer.php'; ?>
</body>
</html>
