<?php
include '../../conn/connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        // Eliminar el registro de la tabla dicta
        $sql = "DELETE FROM dicta WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header("Location: dicta_index.php?mensaje=" . urlencode("Asignación eliminada con éxito."));
            exit();
        } else {
            echo "Error al eliminar la asignación.";
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    echo "ID no especificado.";
}
?>
