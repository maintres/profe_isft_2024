<?php
include("../../conn/connection.php");
include("navbar.php");
// ---------------BORRADO-------------------
if (isset($_GET['txtID'])) {
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";
    $sentencia = $db->prepare("DELETE FROM carreras WHERE id = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    //$mensaje = "Registro Carrera Eliminado";
    echo '<script>
        var msj = "Registro Carrera Eliminado";
        window.location="carrera_index.php?mensaje="+ msj
        </script>';
    //header("Location:carrera_index.php?mensaje=" . $mensaje);
    exit;
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
            ?>
                <tr class="col-sm">
                    <td><?php echo $filas['id'] ?></td>
                    <td><?php echo $filas['nombre'] ?></td>
                    <td><?php echo $filas['descripcion']; ?></td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button class="btn btn-warning btn-sm">
                                <?php echo '<a href="carrera_edit.php?id=' . $filas['id'] . '"><i class="fas fa-edit"></i></a>'; ?>
                            </button>

                            <a href="javascript:eliminar_carrera(<?php echo $filas['id']; ?>)" 
                               class="btn btn-danger btn-sm" 
                               title="Borrar" 
                               role="button">
                                <i class="fas fa-trash"></i>
                            </a>

                            <!-- <button class="btn btn-danger btn-sm">
                                <a href="../../proceso/procesoSuprimir.php?id=<?php echo $filas['id']; ?>" 
                                onClick="return confirm('¿Estas seguro de esta acción?. La  ID del registro <?php echo $filas['id']; ?> será eliminada y una vez eliminada no se podrá recuperar...');"
                                >
                                <i class="fas fa-trash"></i>
                                </a>
                            </button> -->
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
    .fa-edit{
        color: black;
    }
    .fa-trash{
        color: white;
    }
</style>
<?php
mysqli_close($conexion);
require("footer.php");
?>