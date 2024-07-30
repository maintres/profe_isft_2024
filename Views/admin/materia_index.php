<?php
require '../../conn/connection.php'; 

// Procesar la eliminación y actualización de etapa
if (isset($_GET['txtID'])) {
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";
    $sentencia = $db->prepare("UPDATE asignaturas SET etapa = 'Inactivo' WHERE id = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $mensaje = "Registro Materia Eliminado";
    header("Location:materia_index.php?mensaje=" . urlencode($mensaje));
    exit;
}

require 'navbar.php';

// Capturar la etapa seleccionada del filtro, por defecto se muestran todos
$etapa = isset($_GET['etapa']) ? $_GET['etapa'] : 'Todos';

// Consulta para obtener todas las asignaturas con filtro de etapa
$query = "SELECT * FROM asignaturas";

if ($etapa == 'Activo' || $etapa == 'Inactivo') {
    $query .= " WHERE etapa = :etapa";
}

$query .= " ORDER BY id DESC";
$stmt = $db->prepare($query);

if ($etapa == 'Activo' || $etapa == 'Inactivo') {
    $stmt->bindParam(':etapa', $etapa);
}

$stmt->execute();
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- ------------------------------------------- -->
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">Listado de Materias y Correlativas</h5>
                    <a class="btn btn-primary float-right mb-2" href="materia_crea.php">Registro de Materia</a>
                </div>
                <div class="card-body table-responsive">
                    <!-- Formulario de Filtro -->
                    <form method="get" action="materia_index.php" class="mb-3">
                        <div class="form-group">
                            <label for="etapa">Filtrar por Etapa:</label>
                            <select name="etapa" id="etapa" class="form-control" onchange="this.form.submit()">
                                <option value="Todos" <?php if ($etapa == 'Todos') echo 'selected'; ?>>Todos</option>
                                <option value="Activo" <?php if ($etapa == 'Activo') echo 'selected'; ?>>Activo</option>
                                <option value="Inactivo" <?php if ($etapa == 'Inactivo') echo 'selected'; ?>>Inactivo</option>
                            </select>
                        </div>
                    </form>

                    <!-- Tabla de Materias -->
                    <table id="example" class="table table-striped table-sm" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Cantidad de Horas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($materias as $materia) {
                            ?>
                                <tr>    
                                    <td><?php echo htmlspecialchars($materia['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($materia['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($materia['cantidaddehoras'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="materia_edit.php?id=<?php echo htmlspecialchars($materia['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-warning btn-sm" role="button"><i class="fas fa-edit"></i></a>
                                            <?php if ($materia['etapa'] == 'Inactivo') { ?>
                                                <button class="btn btn-danger btn-sm" disabled title="Borrar" role="button"><i class="fas fa-trash"></i></button>
                                            <?php } else { ?>
                                                <a href="javascript:eliminar3(<?php echo $materia['id']; ?>)" 
                                                    class="btn btn-danger btn-sm" 
                                                    title="Borrar" 
                                                    role="button">
                                                    <i class="fas fa-trash"></i>
                                                </a>
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="js/ocultarMensaje.js"></script>
<script>
function eliminar3(id) {
    if (confirm("¿Estás seguro de que deseas eliminar esta materia?")) {
        window.location.href = "materia_index.php?txtID=" + id;
    }
}
</script>
<?php require 'footer.php'; ?>
