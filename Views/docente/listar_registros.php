<?php
require '../conn/connection.php';
session_start();

// Verificar que el usuario está logueado y es un docente
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 2) {
    die("No tienes permisos para acceder a esta página.");
}

$usuario_id = $_SESSION['id_usuario'];

// Función para obtener materias y carreras del docente
function getMateriasAndCarreras($db, $usuario_id)
{
    $queryMaterias = "
        SELECT c.id AS carrera_id, c.nombre AS carrera_nombre, a.id AS materia_id, a.nombre AS materia_nombre
        FROM asignaturas a
        JOIN carreras c ON a.FK_carrera = c.id
        JOIN dicta d ON a.id = d.FKmateria
        WHERE d.usuario_id = :usuario_id
        AND a.etapa = 'Activo'
    ";
    $stmtMaterias = $db->prepare($queryMaterias);
    $stmtMaterias->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmtMaterias->execute();
    return $stmtMaterias->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener registros
function getRegistros($db, $usuario_id)
{
    $queryRegistros = "
        SELECT DISTINCT carrera_id, materia_id
        FROM registro_clases
        WHERE usuario_id = :usuario_id
    ";
    $stmtRegistros = $db->prepare($queryRegistros);
    $stmtRegistros->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmtRegistros->execute();
    return $stmtRegistros->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener datos
$materias = getMateriasAndCarreras($db, $usuario_id);
$registros = getRegistros($db, $usuario_id);

// Convertir registros en un array de fácil acceso
$registrosMap = [];
foreach ($registros as $registro) {
    $registrosMap[$registro['carrera_id'] . '-' . $registro['materia_id']] = true;
}
?>

<!-- Código HTML para mostrar las materias y carreras -->

<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">Listado de Registros de Clases</h5>
                </div>
                <div class="card-body table-responsive">
                    <table id="example" class="table table-striped table-sm" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Carrera</th>
                                <th>Materia</th>
                                <th>Estado del Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($materias as $materia) {
                                $key = $materia['carrera_id'] . '-' . $materia['materia_id'];
                                $registrado = isset($registrosMap[$key]);
                            ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($materia['carrera_nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($materia['materia_nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <?php echo $registrado ? 'Registrado' : 'Pendiente'; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <?php if (!$registrado) { ?>
                                                <a href="listar_registros.php?usuario_id=<?php echo $usuario_id; ?>&carrera_id=<?php echo $materia['carrera_id']; ?>&materia_id=<?php echo $materia['materia_id']; ?>" class="btn btn-primary btn-sm" role="button">Registrar Clase</a>
                                            <?php } else { ?>
                                                <button class="btn btn-success btn-sm" disabled role="button">Registrado</button>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php require 'footer.php'; ?>
