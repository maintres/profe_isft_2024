<?php
require 'navbar.php';
include('../../conn/connection.php');
// ---------------------------------
try {
    // Consulta SQL para obtener los registros de asistencias con nombres y apellidos de profesores
    $sql = "SELECT a.id, p.nombreyapellido AS nombre_profesor, a.fecha, a.estado 
            FROM asistencias a
            INNER JOIN profesores p ON a.profesor_id = p.id
            ORDER BY a.fecha DESC"; // Puedes cambiar el orden como necesites
    $stmt = $db->query($sql);
    if ($stmt === false) {
        throw new Exception('Error en la consulta: ' . $db->errorInfo()[2]);
    }
    if ($stmt->rowCount() > 0) {
    ?>    
    <!-- ------------------------------------------ -->
        <section class="content mt-3">
                <div class="row m-auto">
                    <div class="col-sm">
                        <div class="card rounded-2 border-0">
                            <div class="card-header bg-dark text-white pb-0">
                                <h5 class="d-inline-block ">Lista de Asistencias</h5>
                                <a class="btn btn-primary float-right mb-2" href="asistencia_crea.php">Agregar Nueva Asistencia</a>                    
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
            echo '<td>' . htmlspecialchars($row['nombre_profesor']) . '</td>';
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
        echo '</tbody>
                </table>
                </div>
                </div>
                </div>
                </div>
                </section>';
    } else {
        echo '<div class="alert alert-warning" role="alert">No se encontraron registros de asistencias.</div>';
    }
    $stmt->closeCursor();
} catch (Exception $e) {
    echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . '</div>';
}
$db = null;
?>
<!-- -------------------------------------- -->
<?php require 'footer.php'; ?>
