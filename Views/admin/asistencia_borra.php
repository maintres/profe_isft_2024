<?php
require('../../conn/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    if (!empty($id) && is_numeric($id)) { // Verifica que el ID no esté vacío y sea numérico
        try {
            // Consulta para eliminar el registro de asistencia
            $sql = "DELETE FROM asistencia WHERE id = ?";
            $stmt = $db->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error en la preparación de la consulta: ' . $db->errorInfo()[2]);
            }

            // Asociar parámetro e intentar ejecutar la consulta
            $stmt->bindParam(1, $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Redireccionar a la lista de asistencias con mensaje de éxito
                $mensaje = "Registro de asistencia eliminado correctamente.";
                header("Location: asistencia_index.php?mensaje=" . urlencode($mensaje));
                exit();
            } else {
                throw new Exception('Error al eliminar el registro: ' . $stmt->errorInfo()[2]);
            }

        } catch (Exception $e) {
            $error = "Error al eliminar el registro: " . $e->getMessage();
            header("Location: asistencia_index.php?error=" . urlencode($error));
            exit();
        }
    } else {
        // Manejar el caso en que el ID no es válido
        $error = "ID de registro no válido.";
        header("Location: asistencia_index.php?error=" . urlencode($error));
        exit();
    }
} else {
    // Manejar el caso en que no se recibió el ID adecuadamente
    $error = "ID de registro no especificado.";
    header("Location: asistencia_index.php?error=" . urlencode($error));
    exit();
}
?>
