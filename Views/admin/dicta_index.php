<?php
include("../../conn/connection.php");
include("navbar.php");

// Eliminación de registro si se proporciona el parámetro txtID en la URL
if (isset($_GET['txtID'])) {
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";
    $sentencia = $db->prepare("DELETE FROM dicta WHERE id = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    echo '<script>
        var msj = "Registro Eliminado";
        window.location="dicta_index.php?mensaje="+ msj
        </script>';
    exit;
}

// Consulta para obtener todas las asignaciones
$sql = "SELECT d.id, CONCAT(p.nombreyapellido) AS nombre_profesor, m.nombre AS nombre_materia, d.tipo, d.baja, d.fecha_baja, d.motivo_baja 
        FROM dicta d
        INNER JOIN profesores p ON d.FKprofesor = p.id
        INNER JOIN asignaturas m ON d.FKmateria = m.id
        ORDER BY d.id DESC";
$resultado = $db->query($sql);

?>

<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">Listado de Asignaciones</h5>
                    <a class="btn btn-primary float-right mb-2" href="dicta_crea.php">Agregar Nueva Asignación</a>
                </div>
                <div class="card-body table-responsive">   
                    <table id="example" class="table table-striped table-sm" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Profesor</th>
                                <th>Materia</th>
                                <th>Tipo</th>
                                <th>Baja</th>
                                <th>Fecha Baja</th>
                                <th>Motivo Baja</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nombre_profesor']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nombre_materia']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tipo']); ?></td>
                                    <td><?php echo htmlspecialchars($row['baja']); ?></td>
                                    <td><?php echo htmlspecialchars($row['fecha_baja']); ?></td>
                                    <td><?php echo htmlspecialchars($row['motivo_baja']); ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="dicta_edit.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <a href="dicta_index.php?txtID=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .fa-edit {
        color: black;
    }

    .fa-trash {
        color: white;
    }
</style>

<?php
require("footer.php");
?>
