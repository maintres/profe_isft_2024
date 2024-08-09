<?php
include '../../conn/connection.php';

// Obtener el ID de la carrera desde el POST
if (isset($_POST['carrera_id'])) {
    $carrera_id = $_POST['carrera_id'];

    try {
        // Preparar la consulta para obtener las materias de la carrera seleccionada
        $sql = "SELECT id, nombre FROM asignaturas WHERE FK_carrera = :carrera_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':carrera_id', $carrera_id, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener los resultados
        $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Devolver los resultados en formato JSON
        echo json_encode($materias);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}
?>

