<?php
require 'navbar.php';
include('../../conn/connection.php');

try {
    $sql = "SELECT a.id, u.nombre AS nombre_profesor, u.apellido AS apellido_profesor, a.fecha, a.estado 
            FROM asistencia a
            INNER JOIN usuarios u ON a.profesor_id = u.id_usuario
            ORDER BY a.fecha DESC";
    $stmt = $db->query($sql);
    if ($stmt === false) {
        throw new Exception('Error en la consulta: ' . $db->errorInfo()[2]);
    }   
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit;
}
?>
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">Lista de Asistencias</h5>
                    <a class="btn btn-primary float-right mb-2" href="asistencia_crea.php">Agregar Nueva Asistencia</a>
                    <a class="btn btn-secondary float-right mb-2 mr-2" href="asistencia_pdf.php">Descargar PDF</a>
                </div>
                <div class="card-body table-responsive">
                    <table id="example" class="table table-striped table-sm" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Profesor</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['nombre_profesor']) . ' ' . htmlspecialchars($row['apellido_profesor']) . '</td>';
            echo '<td>' . htmlspecialchars($row['fecha']) . '</td>';
            echo '<td>' . htmlspecialchars($row['estado']) . '</td>';
            echo '<td>
                    <div class="btn-group">
                    <a href="asistencia_edit.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                    <a href="asistencia_borra.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este registro?\')"><i class="fas fa-trash"></i></a>
                    </div>
                  </td>';
            echo '</tr>';
        }
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$stmt->closeCursor();
$db = null;
?>
<?php require 'footer.php'; ?>
