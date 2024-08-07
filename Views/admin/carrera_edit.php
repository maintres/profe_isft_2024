<?php
include("../../conn/connection.php");
require("navbar.php");

// --------------------------------
if (isset($_POST['enviar'])) {
    // Aquí entra cuando se presiona el botón enviar.
    $id = $_POST['id'];
    $NombreCarrera = $_POST['Ncarrera'];
    $DescripcionCarrera = $_POST['Descripcion'];

    // Consulta SQL preparada para actualizar.
    $sql = "UPDATE carreras SET nombre=?, descripcion=? WHERE id=?";
    $sentenciaPreparada = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sentenciaPreparada, 'ssi', $NombreCarrera, $DescripcionCarrera, $id);

    if (mysqli_stmt_execute($sentenciaPreparada)) {
        echo "<script language='JavaScript'>
            alert('Los datos se actualizaron correctamente');
            location.assign('carrera_index.php');
            </script>";
    } else {
        echo "<script language='JavaScript'>
            alert('Los datos no se actualizaron correctamente');
            location.assign('carrera_index.php');
            </script>";
    }
    mysqli_stmt_close($sentenciaPreparada);
    // mysqli_close($conexion);
} else {
    // Aquí entra si no se ha presionado el botón enviar.
    $id = $_GET['id'];
    $sql = "SELECT * FROM carreras WHERE id=?";
    $sentenciaPreparada = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sentenciaPreparada, 'i', $id);
    mysqli_stmt_execute($sentenciaPreparada);

    $resultado = mysqli_stmt_get_result($sentenciaPreparada);
    $fila = mysqli_fetch_assoc($resultado);
    $NombreCarrera = $fila['nombre'];
    $DescripcionCarrera = $fila['descripcion'];

    mysqli_stmt_close($sentenciaPreparada);
    mysqli_close($conexion);
}
?>
<div class="container mt-3">
    <div class="card rounded-2 border-0">
        <h5 class="card-header bg-dark text-white">Formulario de editar carreras</h5>
        <div class="card-body bg-light">
            <form class="form-group" action="" method="post">
                <p class="form-label mt-4">Nombre de Carrera:</p>
                <input class="form-control" type="text" name="Ncarrera" value="<?php echo htmlspecialchars($NombreCarrera); ?>" placeholder="Ingrese el nombre de la carrera" required />

                <p class="form-label mt-4">Descripción de Carrera:</p>
                <input class="form-control" type="text" name="Descripcion" value="<?php echo htmlspecialchars($DescripcionCarrera); ?>" placeholder="Ingrese la descripción de la carrera" required />
                
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"><br>

                <input class="btn btn-primary" type="submit" name="enviar" value="Guardar cambios" />

                <button class="btn btn-warning"><a href="carrera_index.php">Volver al Listado</a></button>
            </form>
            <style>
                button a {
                    color: black;
                    text-decoration: none;
                }

                a:hover {
                    color: black;
                    text-decoration: none;
                }
            </style>
        </div>
    </div>
</div>
<?php
require("footer.php");
?>
