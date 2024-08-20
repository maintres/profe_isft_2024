<?php
require '../../fpdf/fpdf.php'; // Incluye la biblioteca FPDF
include('../../conn/connection.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Función para obtener todos los registros de clases de profesores
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

// Función para generar PDF
function generarPDF($registros)
{
    $pdf = new FPDF();
    $pdf->AddPage();
    
    // Configuración del texto ISFT Angaco en la parte derecha superior
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->SetX(-30); // Posiciona el cursor 30 mm desde el borde derecho
    $pdf->Cell(0, 10, 'ISFT Angaco', 0, 1, 'R');
    $pdf->Ln(10); // Espacio adicional después del texto

    // Título y subtítulo
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Listado de Registros de Clases de Profesores', 0, 1, 'C');

    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Detalles de los registros de asistencia', 0, 1, 'C');
    $pdf->Ln(9); // Espacio entre el subtítulo y la tabla

    // Configuración de la tabla
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(200, 220, 255); // Color de fondo para los encabezados
    
    // Anchos de las columnas
    $ancho_nombre_completo = 30;
    $ancho_dni = 20;
    $ancho_carrera = 35;
    $ancho_materia = 25;
    $ancho_hora_entrada = 20;
    $ancho_hora_salida = 20;
    $ancho_fecha = 25;
    $ancho_total = $ancho_nombre_completo + $ancho_dni + $ancho_carrera + $ancho_materia + $ancho_hora_entrada + $ancho_hora_salida + $ancho_fecha;

    // Ancho de la página menos el ancho total de la tabla
    $ancho_pagina = 200; // Ancho de la página (en mm)
    $margen_izquierdo = ($ancho_pagina - $ancho_total) / 2;

    $pdf->SetLeftMargin($margen_izquierdo);
    $pdf->SetRightMargin($margen_izquierdo);

    // Encabezado de la tabla
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
        $nombre_completo = htmlspecialchars($registro['usuario_nombre'] . ' ' . $registro['usuario_apellido']);
        $dni = htmlspecialchars($registro['usuario_dni']);
        $carrera = htmlspecialchars($registro['carrera_nombre']); // Nombre completo de la carrera
        $materia = htmlspecialchars($registro['materia_nombre']);
        $hora_entrada = htmlspecialchars($registro['hora_entrada']);
        $hora_salida = htmlspecialchars($registro['hora_salida']);
        $fecha = htmlspecialchars($registro['fecha']);

        $pdf->Cell($ancho_nombre_completo, 6, $nombre_completo, 1);
        $pdf->Cell($ancho_dni, 6, $dni, 1);
        $pdf->Cell($ancho_carrera, 6, $carrera, 1);
        $pdf->Cell($ancho_materia, 6, $materia, 1);
        $pdf->Cell($ancho_hora_entrada, 6, $hora_entrada, 1);
        $pdf->Cell($ancho_hora_salida, 6, $hora_salida, 1);
        $pdf->Cell($ancho_fecha, 6, $fecha, 1);
        $pdf->Ln();
    }

    // Enviar el archivo PDF al navegador
    $pdf->Output('D', 'registros_clases.pdf');
}

// Limpia el búfer de salida para evitar errores de salida previa
ob_clean(); 

// Verifica que se haya hecho una solicitud para exportar el PDF
if (isset($_GET['export']) && $_GET['export'] === 'pdf') {
    generarPDF($registros);
    exit(); // Asegúrate de detener la ejecución después de generar el PDF
}
?>
