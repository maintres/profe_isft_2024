<?php
include("../../conn/connection.php");
include("navbar.php");

// Establecer atributos de error para PDO
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Capturar la etapa seleccionada del filtro, por defecto se muestran todos
$etapa = isset($_GET['etapa']) ? $_GET['etapa'] : 'Todos';

// Inicializar la consulta SQL
$sql = "SELECT d.id, CONCAT(u.nombre, ' ', u.apellido) AS nombre_profesor, u.dni AS dni_profesor, m.nombre AS nombre_materia, c.nombre AS nombre_carrera, d.tipo, d.Baja, d.Fecha_baja, d.motivo_baja, d.etapa
        FROM dicta d
        INNER JOIN usuarios u ON d.usuario_id = u.id_usuario
        INNER JOIN asignaturas m ON d.FKmateria = m.id
        INNER JOIN carreras c ON d.FK_carrera = c.id";

if ($etapa === 'Activo' || $etapa === 'Inactivo') {
    $sql .= " WHERE d.etapa = :etapa";
}

$sql .= " ORDER BY d.id DESC";
$stmt = $db->prepare($sql);

if ($etapa === 'Activo' || $etapa === 'Inactivo') {
    $stmt->bindParam(':etapa', $etapa);
}

try {
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
    exit;
}

// Procesar la baja y actualización de la etapa si se ha enviado el formulario del modal
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['txtID'])) {
    $txtID = $_POST['txtID'];
    $motivo_baja = $_POST['motivo_baja'];
    $fecha_baja = date('Y-m-d');

    $sql_update = "UPDATE dicta SET motivo_baja = :motivo_baja, Fecha_baja = :fecha_baja, etapa = 'Inactivo' WHERE id = :id";
    $stmt_update = $db->prepare($sql_update);
    $stmt_update->bindParam(':motivo_baja', $motivo_baja);
    $stmt_update->bindParam(':fecha_baja', $fecha_baja);
    $stmt_update->bindParam(':id', $txtID);

    try {
        $stmt_update->execute();
        header("Location: dicta_index.php?mensaje=Registro%20Actualizado%20a%20Inactivo");
        exit;
    } catch (PDOException $e) {
        echo "Error al actualizar: " . $e->getMessage();
        exit;
    }
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
                            <label for="etapa" class="label label-default">Filtrar por Estado: </label>
                            <select name="etapa" id="etapa" class="form-control" onchange="this.form.submit()">
                                <option value="Todos" <?php echo ($etapa === 'Todos') ? 'selected' : ''; ?>>Todos</option>
                                <option value="Activo" <?php echo ($etapa === 'Activo') ? 'selected' : ''; ?>>Activo</option>
                                <option value="Inactivo" <?php echo ($etapa === 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                            </select>
                        </div>
                    </form>
                    <!-- Tabla de Asignaciones -->
                    <?php if (empty($resultado)) : ?>
                        <div class="alert alert-info">No hay registros disponibles.</div>
                    <?php else : ?>
                        <table id="example" class="table table-striped table-sm" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Profesor</th>
                                    <th>DNI</th>
                                    <th>Materia</th>
                                    <th>Carrera</th>
                                    <th>Tipo</th>
                                    <th>Baja</th>
                                    <th>Fecha Baja</th>
                                    <th>Motivo Baja</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultado as $row) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nombre_profesor']); ?></td>
                                        <td><?php echo htmlspecialchars($row['dni_profesor']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nombre_materia']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nombre_carrera']); ?></td>
                                        <td><?php echo htmlspecialchars($row['tipo']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Baja']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Fecha_baja']); ?></td>
                                        <td><?php echo htmlspecialchars($row['motivo_baja']); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="dicta_edit.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                <?php if ($row['etapa'] === 'Inactivo') : ?>
                                                    <button class="btn btn-danger btn-sm" disabled><i class="fas fa-trash"></i></button>
                                                <?php else : ?>
                                                    <button class="btn btn-danger btn-sm" onclick="showBajaModal('<?php echo htmlspecialchars($row['id']); ?>')"><i class="fas fa-trash"></i></button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
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

<?php require("footer.php"); ?>