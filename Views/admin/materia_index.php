<?php
require '../../conn/connection.php'; 
require 'navbar.php';

// ---------------------------------
if (isset($_GET['txtID'])) {
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";

    try {
        // Cambia el estado de activo a inactivo en lugar de eliminar el registro
        $sentencia = $db->prepare("UPDATE asignaturas SET etapa = 'Inactivo' WHERE id = :id");
        $sentencia->bindParam(':id', $txtID, PDO::PARAM_INT);
        $sentencia->execute();

        $mensaje = "Registro Materia Inactivado";
        echo '<script>
            var msj = "' . $mensaje . '";
            window.location="materia_index.php?mensaje="+ encodeURIComponent(msj);
            </script>';
        exit;
    } catch (PDOException $e) {
        error_log("Error al actualizar el estado de la materia: " . $e->getMessage());
    }
}
?>
<!-- ------------------------------------------- -->
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">Listado de Materias y Correlativas</h5>
                    <a class="btn btn-primary float-right mb-2" href="materia_crea.php">Registro de Materia</a>
                </div>
                <div class="card-body table-responsive">
                    <table id="example" class="table table-striped table-sm" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Cantidad de Horas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $query = "SELECT * FROM asignaturas WHERE etapa = 'Activo'";
                                $stmt = $db->prepare($query);
                                $stmt->execute();
                                $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($materias as $materia) {
                            ?>
                                    <tr>
                                    <td><?php echo htmlspecialchars($materia['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($materia['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($materia['cantidaddehoras'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="materia_edit.php?id=<?php echo htmlspecialchars($materia['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-warning btn-sm" role="button"><i class="fas fa-edit"></i></a>
                                            <?php if ($materia['etapa'] == 'Inactivo') { ?>
                                                <button class="btn btn-danger btn-sm" disabled title="Inactivado" role="button"><i class="fas fa-trash"></i></button>
                                            <?php } else { ?>
                                                <a href="javascript:eliminar3(<?php echo htmlspecialchars($materia['id'], ENT_QUOTES, 'UTF-8'); ?>)" 
                                                    class="btn btn-danger btn-sm" 
                                                    title="Inactivar" 
                                                    role="button">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    </tr>
                            <?php
                                }
                            } catch (PDOException $e) {
                                error_log("Error al obtener las materias: " . $e->getMessage());
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="js/ocultarMensaje.js"></script>
<script>
function eliminar3(id) {
    if (confirm("¿Estás seguro de que deseas inactivar esta materia?")) {
        window.location.href = "materia_index.php?txtID=" + id;
    }
}
</script>
<?php require 'footer.php'; ?>
