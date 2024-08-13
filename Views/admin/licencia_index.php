<?php
require '../../conn/connection.php';
require 'navbar.php';

// Usando PDO en lugar de mysqli
$SQl = "SELECT l.id, l.fechadeinicio, l.fechadefin, u.nombre AS nombre_profesor, u.apellido AS apellido_profesor, t.tipodelicencia AS tipo_licencia FROM licencias l INNER JOIN usuarios u ON l.usuario_id = u.id_usuario INNER JOIN tipos_licencias t ON l.idtipos_licencias = t.id WHERE l.etapa = 'Activo' AND u.id_rol = 2;"; // Filtrar por id_rol = 2

try {
    $resultado = $db->query($SQl);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

//-------------BORRADO------------------ 
if (isset($_GET['txtID'])) {
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";
    try {
        $sentencia = $db->prepare("UPDATE licencias SET etapa = 'Inactivo' WHERE id = :id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        echo '<script>
                var msj = "Registro de licencia eliminado";
                window.location="licencia_index.php?mensaje=" + encodeURIComponent(msj);
                </script>';
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
// ------------------------------
?>
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">Listado de Licencias</h5>
                    <a class="btn btn-primary float-right mb-2" href="licencia_crear.php">Registro de Licencias</a>
                </div>
                <div class="card-body table-responsive">
                    <table id="example" class="table table-striped table-sm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Profesor</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Finalización</th>
                                <th>Licencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($filas = $resultado->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr class="col-sm">
                                    <td><?php echo htmlspecialchars($filas['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($filas['nombre_profesor'] . ' ' . $filas['apellido_profesor'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($filas['fechadeinicio'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($filas['fechadefin'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($filas['tipo_licencia'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="licencia_edit.php?id=<?php echo htmlspecialchars($filas['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-warning btn-sm" role="button">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:elimina_licencia(<?php echo htmlspecialchars($filas['id'], ENT_QUOTES, 'UTF-8'); ?>)" class="btn btn-danger btn-sm" title="Borrar" role="button">
                                                <i class="fas fa-trash"></i>
                                            </a>
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
<?php
require("footer.php");
?>