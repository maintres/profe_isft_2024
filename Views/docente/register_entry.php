<?php
require '../../conn/connection.php';

// Validar datos de entrada
if (!isset($_POST['profesor_id']) || !isset($_POST['carrera_id']) || !isset($_POST['materia_id'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
    exit;
}

$profesor_id = $_POST['profesor_id'];
$carrera_id = $_POST['carrera_id'];
$materia_id = $_POST['materia_id'];
$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i:s');
$fecha_hora_entrada = $fecha_actual . ' ' . $hora_actual;

// Función para registrar la entrada
function registerEntry($db, $profesor_id, $carrera_id, $materia_id, $fecha_hora_entrada)
{
    $queryInsert = "
        INSERT INTO registro_clases (profesor_id, carrera_id, materia_id, fecha, hora_entrada, hora_salida, etapa)
        VALUES (:profesor_id, :carrera_id, :materia_id, :fecha_hora_entrada, :fecha_hora_entrada, NULL, 'Activo')
    ";
    $stmtInsert = $db->prepare($queryInsert);
    $stmtInsert->bindParam(':profesor_id', $profesor_id, PDO::PARAM_INT);
    $stmtInsert->bindParam(':carrera_id', $carrera_id, PDO::PARAM_INT);
    $stmtInsert->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
    $stmtInsert->bindParam(':fecha_hora_entrada', $fecha_hora_entrada);

    return $stmtInsert->execute();
}

try {
    if (registerEntry($db, $profesor_id, $carrera_id, $materia_id, $fecha_hora_entrada)) {
        echo json_encode(['success' => true, 'message' => 'Clase registrada exitosamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar la clase.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()]);
}
