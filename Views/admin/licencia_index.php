<?php
include("../../conn/connection.php");
require("navbar.php");
$SQl = "SELECT * FROM licencias";
$resultado = mysqli_query($conexion, $SQl);
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
                                            <button class="btn btn-warning btn-sm">
                                                <?php echo '<a href="licencia_edit.php?id=' . $filas['id'] . '"><i class="fas fa-edit"></i></a>'; ?>
                                            </button>
                                            <button class="btn btn-danger">
                                                <a href="proceso/SuprimirLicencia.php?id=<?php echo $filas['id']; ?>" onClick="return confirm('¿Seguro de esta acción? ID <?php echo $filas['id']; ?> será eliminado y una vez eliminado no se podrá recuperar...');">
                                                <i class="fas fa-trash"></i>
                                                </a>
                                            </button>

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
mysqli_close($conexion);
require("footer.php");
?>