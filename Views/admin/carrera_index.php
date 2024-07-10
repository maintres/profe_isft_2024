<?php
include("../../conn/connection.php");
include("navbar.php");
?>


<?php

$sql = "SELECT * FROM carreras";
$resultado = mysqli_query($conexion, $sql);
/*
    Esta función realiza una consulta a la base de datos. 
    $conexion es un objeto que representa la conexión a una base de datos MySQL 
    y $sql es la consulta SQL que quieres ejecutar.
    */
?>
<br>

<div class="card rounded-2 border-0">
    <table id="example" class="table table-hover" border="1">
        <div class="card-header bg-dark text-white pb-0">
            <h5 class="d-inline-block">Listado de Carreras</h5>
            <a class="btn btn-primary float-right mb-2" href="carrera_create.php">Registro de Carreras</a>
        </div>
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
                        <button class="btn btn-warning btn-sm">
                            <?php echo '<a href="carrera_edit.php?id=' . $filas['id'] . '"><i class="fas fa-edit"></i></a>'; ?>
                        </button>
                        <button class="btn btn-danger"><a href="../../proceso/procesoSuprimir.php?id=<?php echo $filas['id']; ?>" onClick="return confirm('¿Estas seguro de esta acción?. La  ID del registro <?php echo $filas['id']; ?> será eliminada y una vez eliminada no se podrá recuperar...');"><i class="fas fa-trash"></i></a></button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<style>
    .fa-edit{
        color: black;
    }
    .fa-trash{
        color: white;

    }


</style>
<?php
//Esta función cierra una conexión previamente abierta a una base de datos.
mysqli_close($conexion);
require("footer.php");
?>