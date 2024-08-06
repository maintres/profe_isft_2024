<?php
require("navbar.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include('../../conn/connection.php');
$NombreCarrera = $_POST['Ncarrera'];
$AbrebiaturaCarrera = $_POST['Abrev'];
$consultaSQL = "INSERT INTO carreras (nombre, descripcion) VALUES (?, ?)";
if (!($sentenciaPreparada = mysqli_prepare($conexion,$consultaSQL))) {
    echo "Falló la preparación: (" . $conexion->errno . ") " . $conexion->error;
} else {
    $sentenciaPreparada->bind_param("ss", $NombreCarrera, $AbrebiaturaCarrera);
    if ($sentenciaPreparada->execute()) {
        echo '<script>
        var msj = "Carrera ingresada con éxito.";
        window.location="carrera_index.php?mensaje="+ msj
        </script>';
    } else {
        echo "Se ha producido un error: " . $sentenciaPreparada->error;
    }
    $sentenciaPreparada->close();
}
$conexion->close();
}
?>
<!-- ----------------------------------------------------- -->
<div class="container mt-3 w-50">
  <div class="card rounded-2 border-0 row d-flex justify-content-center">
    <h5 class="card-header bg-dark text-white">Formulario de agregar carreras</h5>
    <div class="card-body bg-light">
      <form class="form-group" action="" method="post">
        <p>Nombre de Carrera:</p>
        <input type="text" class="form-control" name="Ncarrera" id="" placeholder="Ingrese el nombre de la carrera" />

        <p>Abreviatura de carrera</p>
        <input type="text" class="form-control" name="Abrev" id="" placeholder="ingrese la abreviatura de la carrera" /><br>

        <input class="btn btn-primary float-right" name="Enviar" type="submit" value="Guardar" />
      </form>
    </div>
  </div>
</div>
<?php
require("footer.php");
?>