<?php
include("../../conn/connection.php");
include("navbar.php");

// Capturar la etapa seleccionada del filtro, por defecto se muestran todos
$etapa = isset($_GET['etapa']) ? $_GET['etapa'] : 'Todos';

// Consulta para obtener todas las asignaciones con filtro de etapa
$sql = "SELECT d.id, CONCAT(p.nombreyapellido) AS nombre_profesor, m.nombre AS nombre_materia, d.tipo, d.baja, d.fecha_baja, d.motivo_baja, d.etapa 
        FROM dicta d
        INNER JOIN profesores p ON d.FKprofesor = p.id
        INNER JOIN asignaturas m ON d.FKmateria = m.id";

if ($etapa == 'Activo' || $etapa == 'Inactivo') {
    $sql .= " WHERE d.etapa = :etapa";
}

$sql .= " ORDER BY d.id DESC";
$stmt = $db->prepare($sql);

if ($etapa == 'Activo' || $etapa == 'Inactivo') {
    $stmt->bindParam(':etapa', $etapa);
}

$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar la baja y actualización de la etapa si se ha enviado el formulario del modal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['txtID'])) {
    $txtID = $_POST['txtID'];
    $motivo_baja = $_POST['motivo_baja'];
    $fecha_baja = date('Y-m-d');

    $sql_update = "UPDATE dicta SET motivo_baja = :motivo_baja, fecha_baja = :fecha_baja, etapa = 'Inactivo' WHERE id = :id";
    $stmt_update = $db->prepare($sql_update);
    $stmt_update->bindParam(':motivo_baja', $motivo_baja);
    $stmt_update->bindParam(':fecha_baja', $fecha_baja);
    $stmt_update->bindParam(':id', $txtID);
    $stmt_update->execute();

    echo '<script>
        var msj = "Registro Actualizado a Inactivo";
        window.location="dicta_index.php?mensaje="+ msj
        </script>';
    exit;
}
?>

<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">Listado de Asignaciones</h5>
                    <a class="btn btn-primary float-right mb-2" href="dicta_crea.php">Agregar Nueva Asignación</a>
                </div>
                <div class="card-body table-responsive">
                    <!-- Formulario de Filtro -->
                    <form method="get" action="dicta_index.php" class="form-inline justify-content-start my-1">
                        <div class="form-group">
                            <label for="etapa" class="label label-default " >Filtrar por Estado: </label>
                            <select name="etapa" id="etapa" class="form-control " onchange="this.form.submit()">
                                <option value="Todos" <?php if ($etapa == 'Todos') echo 'selected'; ?>>Todos</option>
                                <option value="Activo" <?php if ($etapa == 'Activo') echo 'selected'; ?>>Activo</option>
                                <option value="Inactivo" <?php if ($etapa == 'Inactivo') echo 'selected'; ?>>Inactivo</option>
                            </select>
                        </div>
                    </form>
                    <!-- Tabla de Asignaciones -->
                    <table id="example" class="table table-striped table-sm" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Profesor</th>
                                <th>Materia</th>
                                <th>Tipo</th>
                                <th>Baja</th>
                                <th>Fecha Baja</th>
                                <th>Motivo Baja</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($resultado as $row) {
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nombre_profesor']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nombre_materia']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tipo']); ?></td>
                                    <td><?php echo htmlspecialchars($row['baja']); ?></td>
                                    <td><?php echo htmlspecialchars($row['fecha_baja']); ?></td>
                                    <td><?php echo htmlspecialchars($row['motivo_baja']); ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="dicta_edit.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <?php if ($row['etapa'] == 'Inactivo') { ?>
                                                <button class="btn btn-danger btn-sm" disabled><i class="fas fa-trash"></i></button>
                                            <?php } else { ?>
                                                <button class="btn btn-danger btn-sm" onclick="showBajaModal('<?php echo htmlspecialchars($row['id']); ?>')"><i class="fas fa-trash"></i></button>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal para ingresar motivo de baja -->
<div id="bajaModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="dicta_index.php">
        <div class="modal-header">
          <h5 class="modal-title">Motivo de Baja</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="txtID" id="txtID">
          <div class="form-group">
            <label for="motivo_baja">Motivo de Baja</label>
            <textarea class="form-control" id="motivo_baja" name="motivo_baja" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-danger">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function showBajaModal(id) {
    document.getElementById('txtID').value = id;
    $('#bajaModal').modal('show');
}
</script>

<?php
require("footer.php");
?>
