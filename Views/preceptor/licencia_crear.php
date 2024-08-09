<?php
require("navbar.php");
include("../../conn/connection.php");
// -----------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$idtipos_licencias = $_POST['idtipos_licencias'];
$profesorSeleccionado = $_POST['profesor'];
$Finicio = $_POST['Finicio'];
$Ffin = $_POST['Ffin'];
$etapa = "Activo";
list($profesorId, $profesorNombre) = explode('|', $profesorSeleccionado);
if (empty($idtipos_licencias)) {
    $idtipos_licencias = NULL;
}
$SQL = "INSERT INTO licencias(nombre, fechadeinicio, fechadefin, idprofesor, idtipos_licencias, etapa) VALUES(?, ?, ?, ?, ?, ?)";
$Preparacion = mysqli_prepare($conexion, $SQL);
if ($Preparacion == false) {
    die("La preparación de consulta no ha sido exitosa: " . $conexion->error);
} else {
    mysqli_stmt_bind_param($Preparacion, "sssiis",  $profesorNombre, $Finicio, $Ffin, $profesorId, $idtipos_licencias, $etapa);
    if (mysqli_stmt_execute($Preparacion)) {
        echo '<script>
              var msj = "Licencia ingresada con éxito.";
              window.location="licencia_index.php?mensaje=" + msj;
              </script>';
    } else {
        die("Se ha producido un error al guardar los datos: " . $Preparacion->error);
    }
    mysqli_stmt_close($Preparacion);
}
}
?>
<!-- -------------------------------- -->
<div class="container mt-3 w-50">
  <div class="card rounded-2 border-0 row d-flex justify-content-center ">
    <h5 class="card-header bg-dark text-white">Formulario de crear licencia</h5>
    <div class="card-body bg-light">
      <form class="form-group" method="post" action="">
      <div class="form-group">
        <label for="profesor">Profesor:</label>
        <?php
        $consulta = "SELECT id, nombreyapellido FROM profesores";
        $resultado = mysqli_query($conexion, $consulta);
        ?>
        <select class="form-select" name="profesor" id="">
          <?php
          while ($opciones = mysqli_fetch_assoc($resultado)) {
          ?>
            <option value="<?php echo $opciones['id'] . '|' . $opciones['nombreyapellido']; ?>">
              <?php echo $opciones['nombreyapellido']; ?>
            </option>
          <?php
          }          
          ?>
        </select>
      </div>
        <!-- -------------------------------------- -->
        <div class="form-group">
          <label for="Finicio">Fecha de inicio:</label>        
          <input class="form-control datepicker-date" type="date" name="Finicio" id="">
        </div>
        <!-- -------------------------------------- -->
        <div class="form-group">
          <label for="Finicio">Fecha de fin:</label>          
          <input class="form-control datepicker-date" type="date" name="Ffin" id="">
        </div>
        <!-- -------------------------- -->
        <div class="form-group">
          <label for="Finicio">Tipo de Licencia:</label>
          <?php
          $cons = "SELECT * FROM tipos_licencias WHERE etapa = 'Activo'";
          $resul = mysqli_query($conexion, $cons);
          ?>
          <select class="form-select" name="idtipos_licencias" id="">
            <?php
            while ($opcion = mysqli_fetch_assoc($resul)) {
            ?>
              <option value="<?php echo $opcion['id'] . '|' . $opcion['tipodelicencia']; ?>">
                <?php echo $opcion['tipodelicencia']; ?>
              </option>
            <?php
            }
            ?>
          </select>
        </div>
        <!-- ------------------------ -->
         <br>
        <input class="btn btn-primary" type="submit" value="Guardar" />
      </form>
    </div>
  </div>
</div>
<?php
require("footer.php");
?>