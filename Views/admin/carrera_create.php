<?php
require("navbar.php");
?>


?>
<br>
<div class="container mt-3">
  <div class="card rounded-2 border-0">
    <h5 class="card-header bg-dark text-white">Formulario de agregar carreras</h5>
    <div class="card-body bg-light">

      <form class="form-group" action="../../proceso/proceso.php" method="post">
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