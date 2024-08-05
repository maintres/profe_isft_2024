<?php
ob_start(); // Inicia el almacenamiento en búfer de salida

require '../../fpdf/fpdf.php';
include('../../conn/connection.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Lista de Asistencias', 0, 1, 'C');
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    // Tabla simple
    function BasicTable($header, $data)
    {
        foreach ($header as $col) {
            $this->Cell(40, 7, $col, 1);
        }
        $this->Ln();
        foreach ($data as $row) {
            foreach ($row as $col) {
                $this->Cell(40, 6, $col, 1);
            }
            $this->Ln();
        }
    }
}

try {
    $sql = "SELECT a.id, p.nombreyapellido AS nombre_profesor, a.fecha, a.estado 
            FROM asistencias a
            INNER JOIN profesores p ON a.profesor_id = p.id
            ORDER BY a.fecha DESC";
    $stmt = $db->query($sql);
    if ($stmt === false) {
        throw new Exception('Error en la consulta: ' . $db->errorInfo()[2]);
    }
    $data = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = array_map('utf8_decode', $row); // Asegura la correcta codificación
    }

    $pdf = new PDF();
    $header = array('ID', 'Profesor', 'Fecha', 'Estado');
    $pdf->SetFont('Arial', '', 12);
    $pdf->AddPage();
    $pdf->BasicTable($header, $data);
    $pdf->Output('D', 'Lista_de_Asistencias.pdf');

    ob_end_flush(); // Finaliza el almacenamiento en búfer de salida y envía la salida

} catch (Exception $e) {
    ob_end_clean(); // Descarta el almacenamiento en búfer de salida en caso de error
    echo 'Error: ' . $e->getMessage();
}
?>
