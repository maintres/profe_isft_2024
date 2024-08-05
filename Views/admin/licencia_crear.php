<?php
require("navbar.php");
include("../../conn/connection.php");
?>
<div class="container mt-3">
  <div class="card rounded-2 border-0">
    <h5 class="card-header bg-dark text-white">Formulario de crear licencia</h5>
    <div class="card-body bg-light">
      <form class="form-group" action="../admin/proseso/procesoLicencia.php" method="POST">
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
          <!-- -------------------Para conectar con tipo de licencias----------------------------- -->
        <!-- <input type="hidden" id="" name="idtipos_licencias" value=""> -->
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