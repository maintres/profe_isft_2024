<?php
require '../../fpdf/fpdf.php'; 
include('../../conn/connection.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function obtenerRegistrosProfesores($conexion)
{
    $sql = "SELECT r.usuario_id, r.carrera_id, r.materia_id, r.fecha, r.hora_entrada, r.hora_salida, 
                   c.nombre AS carrera_nombre, a.nombre AS materia_nombre, 
                   u.nombre AS usuario_nombre, u.apellido AS usuario_apellido, u.dni AS usuario_dni
            FROM registro_clases r
            JOIN asignaturas a ON r.materia_id = a.id
            JOIN carreras c ON r.carrera_id = c.id
            JOIN usuarios u ON r.usuario_id = u.id_usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

$registros = obtenerRegistrosProfesores($conexion);


function generarPDF($registros)
{

    ob_clean(); 

    $pdf = new FPDF();
    $pdf->AddPage();
    
   
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->SetX(-30);
    $pdf->Cell(0, 10, 'ISFT Angaco', 0, 1, 'R');
    $pdf->Ln(10); 

    
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Listado de Registros de Clases de Profesores', 0, 1, 'C');

    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Detalles de los registros de asistencia', 0, 1, 'C');
    $pdf->Ln(9);

  
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(200, 220, 255); 

    $ancho_nombre_completo = 30;
    $ancho_dni = 20;
    $ancho_carrera = 35;
    $ancho_materia = 25;
    $ancho_hora_entrada = 20;
    $ancho_hora_salida = 20;
    $ancho_fecha = 25;
    $ancho_total = $ancho_nombre_completo + $ancho_dni + $ancho_carrera + $ancho_materia + $ancho_hora_entrada + $ancho_hora_salida + $ancho_fecha;


    $ancho_pagina = 200; 
    $margen_izquierdo = ($ancho_pagina - $ancho_total) / 2;

    $pdf->SetLeftMargin($margen_izquierdo);
    $pdf->SetRightMargin($margen_izquierdo);

   
    $pdf->Cell($ancho_nombre_completo, 6, 'Nombre Completo', 1, 0, 'C', true);
    $pdf->Cell($ancho_dni, 6, 'DNI', 1, 0, 'C', true);
    $pdf->Cell($ancho_carrera, 6, 'Carrera', 1, 0, 'C', true);
    $pdf->Cell($ancho_materia, 6, 'Materia', 1, 0, 'C', true);
    $pdf->Cell($ancho_hora_entrada, 6, 'Hora Entrada', 1, 0, 'C', true);
    $pdf->Cell($ancho_hora_salida, 6, 'Hora Salida', 1, 0, 'C', true);
    $pdf->Cell($ancho_fecha, 6, 'Fecha', 1, 0, 'C', true);
    $pdf->Ln();

    // Contenido de la tabla
    $pdf->SetFont('Arial', '', 8);
    foreach ($registros as $registro) {
        $nombre_completo = htmlspecialchars($registro['usuario_nombre'] . ' ' . $registro['usuario_apellido'] ?? 'No asignado');
        $dni = htmlspecialchars($registro['usuario_dni'] ?? 'No asignado');
        $carrera = htmlspecialchars($registro['carrera_nombre'] ?? 'No asignado');
        $materia = htmlspecialchars($registro['materia_nombre'] ?? 'No asignado');
        $hora_entrada = htmlspecialchars($registro['hora_entrada'] ?? 'No asignado');
        $hora_salida = htmlspecialchars($registro['hora_salida'] ?? 'No asignado');
        $fecha = htmlspecialchars($registro['fecha'] ?? 'No asignado aún');

        $pdf->Cell($ancho_nombre_completo, 6, $nombre_completo, 1);
        $pdf->Cell($ancho_dni, 6, $dni, 1);
        $pdf->Cell($ancho_carrera, 6, $carrera, 1);
        $pdf->Cell($ancho_materia, 6, $materia, 1);
        $pdf->Cell($ancho_hora_entrada, 6, $hora_entrada, 1);
        $pdf->Cell($ancho_hora_salida, 6, $hora_salida, 1);
        $pdf->Cell($ancho_fecha, 6, $fecha, 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'registros_clases.pdf');
}


if (isset($_GET['export']) && $_GET['export'] === 'pdf') {
    generarPDF($registros);
    exit(); 
}
?>
