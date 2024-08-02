<?php
include("../../../conn/connection.php");

#---------------para el idtipos_licencias-----------------------------------
$idtipos_licencias = $_POST['idtipos_licencias'];
#------------------------------------------------------------------------------

$profesorSeleccionado = $_POST['profesor'];
$Finicio = $_POST['Finicio'];
$Ffin = $_POST['Ffin'];
list($profesorId, $profesorNombre) = explode('|', $profesorSeleccionado);

#Cambiar esto para modificar el tipo de datos NULL si idtipos_licencias
if (empty($idtipos_licencias)) {
    $idtipos_licencias = NULL;
}

$SQL = "INSERT INTO licencias(idprofesor, nombre, fechadeinicio, fechadefin, idtipos_licencias) VALUES(?, ?, ?, ?, ?)";
$Preparacion = mysqli_prepare($conexion, $SQL);
if ($Preparacion == false) {
    die("La preparación de consulta no ha sido exitosa: " . $conexion->error);
} else {
    mysqli_stmt_bind_param($Preparacion, "isssi", $profesorId, $profesorNombre, $Finicio, $Ffin, $idtipos_licencias);

    if (mysqli_stmt_execute($Preparacion)) {
        echo '<script>
              var msj = "Licencia ingresada con éxito.";
              window.location="../licencia_index.php?mensaje=" + msj;
              </script>';
    } else {
        die("Se ha producido un error al guardar los datos: " . $Preparacion->error);
    }
    mysqli_stmt_close($Preparacion);
}

mysqli_close($conexion);
?>
