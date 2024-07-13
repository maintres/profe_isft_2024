<?php
require '../../conn/connection.php';

// Verificar si se ha pasado un ID por GET
if (isset($_GET['txtID'])) {
    $txtID = $_GET['txtID'];

    try {
        // Eliminar el profesor de la base de datos
        $sql = "DELETE FROM profesores WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $txtID);
        $stmt->execute();

        // Mensaje de éxito
        $mensaje = "Registro de Profesor Eliminado";
        header("Location: list_profe.php?mensaje=" . urlencode($mensaje));
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "ID de profesor no proporcionado.";
}
?>