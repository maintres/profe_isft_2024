<?php
require("navbar.php");
include("../../conn/connection.php");
?>
<div class="container mt-3">
  <div class="card rounded-2 border-0">
    <h5 class="card-header bg-dark text-white">Formulario de crear licencia</h5>
    <b class="card-body bg-light">
      <form class="form-group" action="../admin/proseso/procesoLicencia.php" method="POST">
        <p>Profesor</p>
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
          mysqli_close($conexion);
          ?>
        </select>
        <p class="form-label mt-4">Fecha de inicio</p>
        <input class="form-control datepicker-date" type="date" name="Finicio" id="">
        <p>Fecha de fin</p>
        <input class="form-control datepicker-date" type="date" name="Ffin" id=""><br>
        <input class="btn btn-primary" type="submit" value="Guardar" />
      </form>
    </b>
  </div>
</div>
<?php
require("footer.php");
?>