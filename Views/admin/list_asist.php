<?php
require 'navbar.php';
include('../../conn/connection.php');

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
        echo '<section class="content mt-2">
                <div class="row m-auto">
                    <div class="col-sm">
                        <div class="card rounded-2 border-0">
                            <div class="card-header bg-dark text-white pb-0">
                                <h5 class="d-inline-block ">Lista de Asistencias</h5>
                                <a class="btn btn-primary float-right mb-2" href="asist.php">Agregar Nueva Asistencia</a>                    
                            </div>
                            <div class="card-body table-responsive"> 
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Profesor</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

        // Iterar sobre los resultados
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['nombre_profesor']) . '</td>';
            echo '<td>' . htmlspecialchars($row['fecha']) . '</td>';
            echo '<td>' . htmlspecialchars($row['estado']) . '</td>';
            echo '<td>
                    <a href="upd_asist.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-warning btn-sm">Actualizar</a>
                    <a href="del_asis.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este registro?\')">Eliminar</a>
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

    // Cerrar el cursor
    $stmt->closeCursor();

} catch (Exception $e) {
    echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . '</div>';
}

// Cerrar la conexión
$db = null;
?>

<?php require 'footer.php'; ?>
