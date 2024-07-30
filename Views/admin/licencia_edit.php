<?php
include("../../conn/connection.php");
require("navbar.php");

#-------------------------------------------------------------------------------------
if (isset($_POST['Enviar'])) {
    $id = $_POST['id'];
    $profesor = $_POST['profesor'];
    $FechaInicio = $_POST['Finicio'];
    $FechaFin = $_POST['Ffin'];

    $SQL = "UPDATE licencias SET nombre=?, fechainicio=?, fechafin=? WHERE id=?";
    $sentenciaPreparada = mysqli_prepare($conexion, $SQL);
    mysqli_stmt_bind_param($sentenciaPreparada, "sssi", $profesor, $FechaInicio, $FechaFin, $id);

    if (mysqli_stmt_execute($sentenciaPreparada)) {
        echo "<script language='JavaScript'>
            alert('Los datos se actualizaron correctamente');
            location.assign('licencia_index.php');
            </script>";
    } else {
        echo "<script language='JavaScript'>
            alert('Los datos no se actualizaron correctamente');
            location.assign('licencia_index.php');
            </script>";
    }
    mysqli_stmt_close($sentenciaPreparada);
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM licencias WHERE id=?";
    $sentenciaPreparada = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sentenciaPreparada, 'i', $id);
    mysqli_stmt_execute($sentenciaPreparada);

    $resultado = mysqli_stmt_get_result($sentenciaPreparada);
    $fila = mysqli_fetch_assoc($resultado);
    $profesor = $fila['nombre'];
    $FechaInicio = $fila['fechainicio'];
    $FechaFin = $fila['fechafin'];
    mysqli_stmt_close($sentenciaPreparada);
}
?>

<div class="container mt-3">
    <div class="card rounded-2 border-0">
        <h5 class="card-header bg-dark text-white">Formulario para modificar licencia</h5>
        <div class="card-body bg-light">
            <form class="form-group" action="" method="post">
                <p>Profesor</p>
                <?php
                $consulta = "SELECT nombreyapellido FROM profesores";
                $resultado = mysqli_query($conexion, $consulta);
                ?>
                <select class="form-select" id="exampleSelect1" name="profesor">
                    <?php
                    while ($opciones = mysqli_fetch_assoc($resultado)) {
                    ?>
                        <option value="<?php echo $opciones['nombreyapellido']; ?>" <?php if ($opciones['nombreyapellido'] == $profesor) echo 'selected'; ?>>
                            <?php echo $opciones['nombreyapellido']; ?>
                        </option>
                    <?php
                    }
                    mysqli_close($conexion);
                    ?>
                </select>
                <p class="form-label mt-4">Fecha de inicio</p>
                <input class="form-control datepicker-date" type="date" name="Finicio" value="<?php echo $FechaInicio; ?>">
                <p>Fecha de fin</p>
                <input class="form-control datepicker-date" type="date" name="Ffin" value="<?php echo $FechaFin; ?>"><br>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input class="btn btn-primary" type="submit" name="Enviar" value="Guardar Cambios">
                <button class="btn btn-warning"><a href="">Volver al Listado</a></button>
            </form>
        </div>
    </div>
</div>

<?php
require("footer.php");
?>