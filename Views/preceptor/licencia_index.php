<?php
require '../../conn/connection.php'; 
require 'navbar.php';
$SQl = "SELECT * FROM licencias WHERE etapa = 'Activo'";
$resultado = mysqli_query($conexion, $SQl);
//-------------BORRADO------------------ 
if (isset($_GET['txtID'])) {
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";
    $sentencia = $db->prepare("UPDATE licencias SET etapa = 'Inactivo' WHERE id = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    echo '<script>
            var msj = "Registro licencia Eliminado";
            window.location="licencia_index.php?mensaje="+ msj
            </script>';
    exit;
}
// ------------------------------
?>
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">Listado de licencias</h5>
                    <a class="btn btn-primary float-right mb-2" href="licencia_crear.php">Registro de Licencias</a>
                </div>
                <div class="card-body table-responsive">
                    <table id="example" class="table table-striped table-sm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Profesor</th>
                                <th>Fecha de inicio </th>
                                <th>Fecha de finalizacion</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($filas = mysqli_fetch_assoc($resultado)) {
                            ?>
                                <tr class="col-sm">
                                    <td><?php echo $filas['id']; ?></td>
                                    <td><?php echo $filas['nombre']; ?></td>
                                    <td><?php echo $filas['fechadeinicio']; ?></td>
                                    <td><?php echo $filas['fechadefin']; ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">                                        
                                            <a href="licencia_edit.php?id=<?php echo htmlspecialchars($filas['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-warning btn-sm" role="button">
                                                <i class="fas fa-edit"></i>
                                            </a>                                            
                                            <a href="javascript:elimina_licencia(<?php echo $filas['id']; ?>)" class="btn btn-danger btn-sm" title="Borrar" role="button">
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
mysqli_close($conexion);
require("footer.php");
?>