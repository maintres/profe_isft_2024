<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['asistencia'])) {
    require("../../conn/connection.php");

    $fecha = date('Y-m-d');
    $asistencia = $_POST['asistencia'];

    try {
        // Preparar la consulta para insertar la asistencia
        $sql = "INSERT INTO asistencias (profesor_id, fecha, estado) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);

        if ($stmt === false) {
            throw new Exception('Error en la preparación de la consulta: ' . $db->errorInfo()[2]);
        }

        // Recorrer el array de asistencia y ejecutar la consulta para cada profesor
        foreach ($asistencia as $id_profesor => $estado) {
            if (in_array($estado, ['presente', 'ausente', 'justificada'])) {
                $stmt->bindParam(1, $id_profesor, PDO::PARAM_INT);
                $stmt->bindParam(2, $fecha, PDO::PARAM_STR);
                $stmt->bindParam(3, $estado, PDO::PARAM_STR);

                if (!$stmt->execute()) {
                    throw new Exception('Error al ejecutar la consulta: ' . $stmt->errorInfo()[2]);
                }
            } else {
                // Opcional: Puedes manejar aquí los casos donde el estado no es válido,
                // o simplemente omitir el registro si el estado no es válido.
                continue;
            }
        }

        // Cerrar la consulta preparada
        $stmt->closeCursor();

        // Redireccionar después de guardar la asistencia
        $mensaje = "Asistencia registrada correctamente";
        header("Location: list_asist.php?mensaje=" . urlencode($mensaje));
        exit();
    } catch (Exception $e) {
        $error = "Error al procesar la asistencia: " . $e->getMessage();
        header("Location: list_asist.php?error=" . urlencode($error));
        exit();
    }
} else {
    // Manejar el caso en que no se reciben datos de asistencia
    $error = "No se recibieron datos de asistencia.";
    header("Location: list_asist.php?error=" . urlencode($error));
    exit();
}
?>
