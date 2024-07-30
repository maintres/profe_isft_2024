<?php
include("../../../conn/connection.php");

$profesorSeleccionado = $_POST['profesor'];
$Finicio = $_POST['Finicio'];
$Ffin = $_POST['Ffin'];
list($profesorId, $profesorNombre) = explode('|', $profesorSeleccionado);
#------------------------------------------------------------------------------
$SQL = "INSERT INTO licencias(idprofesor, nombreyapellido, fechadeinicio, fechadefin) VALUES(?, ?, ?, ?)";
$Preparacion = mysqli_prepare($conexion, $SQL);
if ($Preparacion == false) {
    die("La preparación de consulta no ha sido exitosa: " . $conexion->error);
} else {
    mysqli_stmt_bind_param($Preparacion, "isss", $profesorId, $profesorNombre, $Finicio, $Ffin);

    if (mysqli_stmt_execute($Preparacion)) {
        echo '<script>
          var msj = "Licencia ingresada con éxito.";
          window.location="licencia_index.php?mensaje="+ msj;
          </script>';
    } else {
        die("Se ha producido un error al guardar los datos: " . $Preparacion->error);
    }
    mysqli_stmt_close($Preparacion);
}
mysqli_close($conexion);
?>