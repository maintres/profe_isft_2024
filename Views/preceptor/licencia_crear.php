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

    list($usuarioId) = explode('|', $profesorSeleccionado);

    if (empty($idtipos_licencias)) {
        $idtipos_licencias = NULL;
    }

    try {
        $SQL = "INSERT INTO licencias (fechadeinicio, fechadefin, usuario_id, idtipos_licencias, etapa) VALUES (?, ?, ?, ?, ?)";
        $Preparacion = $db->prepare($SQL);
        $Preparacion->execute([$Finicio, $Ffin, $usuarioId, $idtipos_licencias, $etapa]);

        echo '<script>
              var msj = "Licencia ingresada con éxito.";
              window.location="licencia_index.php?mensaje=" + encodeURIComponent(msj);
              </script>';
    } catch (PDOException $e) {
        die("Se ha producido un error al guardar los datos: " . $e->getMessage());
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
          // Consulta para obtener profesores con id_rol = 2
          $consulta = "SELECT id_usuario AS id, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM usuarios WHERE id_rol = 2";
          $resultado = $db->query($consulta);
          if (!$resultado) {
              die("Error en la consulta: " . $db->errorInfo()[2]);
          }
          ?>
          <select class="form-select" name="profesor" id="profesor">
            <?php
            while ($opciones = $resultado->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <option value="<?php echo htmlspecialchars($opciones['id']); ?>">
                <?php echo htmlspecialchars($opciones['nombre_completo']); ?>
              </option>
            <?php
            }          
            ?>
          </select>
        </div>
        <!-- -------------------------------------- -->
        <div class="form-group">
          <label for="Finicio">Fecha de inicio:</label>        
          <input class="form-control" type="date" name="Finicio" id="Finicio" required>
        </div>
        <!-- -------------------------------------- -->
        <div class="form-group">
          <label for="Ffin">Fecha de fin:</label>          
          <input class="form-control" type="date" name="Ffin" id="Ffin" required>
        </div>
        <!-- -------------------------- -->
        <div class="form-group">
          <label for="idtipos_licencias">Tipo de Licencia:</label>
          <?php
          // Consulta para obtener tipos de licencia activos
          $cons = "SELECT id, tipodelicencia FROM tipos_licencias WHERE etapa = 'Activo'";
          $resul = $db->query($cons);
          if (!$resul) {
              die("Error en la consulta: " . $db->errorInfo()[2]);
          }
          ?>
          <select class="form-select" name="idtipos_licencias" id="idtipos_licencias">
            <?php
            while ($opcion = $resul->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <option value="<?php echo htmlspecialchars($opcion['id']); ?>">
                <?php echo htmlspecialchars($opcion['tipodelicencia']); ?>
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
