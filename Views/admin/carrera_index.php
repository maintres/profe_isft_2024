<?php
include("../../conn/connection.php");
include("navbar.php");

// ---------------ACTUALIZAR ESTADO A INACTIVO-------------------
if (isset($_GET['txtID'])) {
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";

    try {
        // Actualiza el estado en lugar de eliminar el registro
        $sentencia = $db->prepare("UPDATE carreras SET etapa = 'Inactivo' WHERE id = :id");
        $sentencia->bindParam(':id', $txtID, PDO::PARAM_INT);
        $sentencia->execute();

        $mensaje = "Registro Carrera Inactivado";
        echo '<script>
            var msj = "' . $mensaje . '";
            window.location="carrera_index.php?mensaje="+ encodeURIComponent(msj);
            </script>';
        exit;
    } catch (PDOException $e) {
        error_log("Error al actualizar el estado de la carrera: " . $e->getMessage());
    }
}
// ----------------------------------
$sql = "SELECT * FROM carreras";
$resultado = mysqli_query($conexion, $sql);
?>
<!-- ---------------------------------------------- -->
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">Listado de Carreras</h5>
                    <a class="btn btn-primary float-right mb-2" href="carrera_crea.php">Registro de Carreras</a>
                </div>
                <div class="card-body table-responsive">   
                    <table id="example" class="table table-striped table-sm" style="width:100%">
                        <thead id="color1" class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre de la carrera</th>
                                <th>Abreviatura</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($filas = mysqli_fetch_assoc($resultado)) {
                                if ($filas['etapa'] == 'Activo') { // Mostrar solo carreras activas
                            ?>
                                    <tr class="col-sm">
                                        <td><?php echo htmlspecialchars($filas['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($filas['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($filas['descripcion'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-warning btn-sm">
                                                    <?php echo '<a href="carrera_edit.php?id=' . htmlspecialchars($filas['id'], ENT_QUOTES, 'UTF-8') . '"><i class="fas fa-edit"></i></a>'; ?>
                                                </button>

                                                <a href="javascript:eliminar_carrera(<?php echo htmlspecialchars($filas['id'], ENT_QUOTES, 'UTF-8'); ?>)" 
                                                   class="btn btn-danger btn-sm" 
                                                   title="Inactivar" 
                                                   role="button">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                }
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

<script>
function eliminar_carrera(id) {
    if (confirm("¿Estás seguro de que deseas inactivar esta carrera?")) {
        window.location.href = "carrera_index.php?txtID=" + id;
    }
}
</script>

<?php
mysqli_close($conexion);
require("footer.php");
?>
