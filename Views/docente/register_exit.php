<?php
require '../../conn/connection.php';

// Configura el encabezado para responder en formato JSON
header('Content-Type: application/json');

// Obtén los datos del formulario
$registro_id = $_POST['registro_id'] ?? '';
$fecha_salida = $_POST['fecha_salida'] ?? '';
$hora_salida = $_POST['hora_salida'] ?? '';

if (empty($registro_id) || empty($fecha_salida) || empty($hora_salida)) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
    exit;
}

// Aquí llamas a tu función para registrar la salida
$queryUpdate = "
    UPDATE registro_clases
    SET fecha_salida = :fecha_salida, hora_salida = :hora_salida
    WHERE id = :registro_id AND etapa = 'Activo'
";
$stmtUpdate = $db->prepare($queryUpdate);
$stmtUpdate->bindParam(':registro_id', $registro_id, PDO::PARAM_INT);
$stmtUpdate->bindParam(':fecha_salida', $fecha_salida);
$stmtUpdate->bindParam(':hora_salida', $hora_salida);

if ($stmtUpdate->execute()) {
    echo json_encode(['success' => true, 'message' => 'Salida registrada exitosamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al registrar la salida.']);
}
?>
