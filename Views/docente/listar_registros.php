
<?php
require 'navbar.php';
include('../../conn/connection.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function registrarEntrada($conexion, $usuario_id, $carrera_id, $materia_id, $fecha)
{
    $sql_insert = "INSERT INTO registro_clases (usuario_id, carrera_id, materia_id, fecha, hora_entrada) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $conexion->prepare($sql_insert);
    $hora_entrada = date("H:i:s");
    $stmt_insert->bind_param('iiiss', $usuario_id, $carrera_id, $materia_id, $fecha, $hora_entrada);
    return $stmt_insert->execute();
}

function registrarSalida($conexion, $usuario_id, $carrera_id, $materia_id, $fecha)
{
    $hora_salida = date("H:i:s");
    $sql_select = "SELECT hora_entrada FROM registro_clases WHERE usuario_id = ? AND carrera_id = ? AND materia_id = ? AND fecha = ? AND hora_salida IS NULL";
    $stmt_select = $conexion->prepare($sql_select);
    $stmt_select->bind_param('iiis', $usuario_id, $carrera_id, $materia_id, $fecha);
    $stmt_select->execute();
    $resultado = $stmt_select->get_result()->fetch_assoc();

    if ($resultado) {
        $hora_entrada = $resultado['hora_entrada'];
        $hora_entrada_dt = new DateTime($hora_entrada);
        $hora_salida_dt = new DateTime($hora_salida);
        $intervalo = $hora_entrada_dt->diff($hora_salida_dt);
        $minutos_transcurridos = ($intervalo->h * 60) + $intervalo->i;
        if ($minutos_transcurridos >= 40) {
            $sql_update = "UPDATE registro_clases SET hora_salida = ? WHERE usuario_id = ? AND carrera_id = ? AND materia_id = ? AND fecha = ? AND hora_salida IS NULL";
            $stmt_update = $conexion->prepare($sql_update);
            $stmt_update->bind_param('siiis', $hora_salida, $usuario_id, $carrera_id, $materia_id, $fecha);
            return $stmt_update->execute();
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Error',
                    text: 'No se puede registrar la salida antes de que hayan pasado 40 minutos desde la entrada.',
                    showConfirmButton: true
                });
            </script>";
            return false;
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Registro inválido',
                text: 'No hay registro de entrada para esta fecha.',
                showConfirmButton: true
            });
        </script>";
        return false;
    }

}
function obtenerRegistroDelDia($conexion, $usuario_id, $carrera_id, $materia_id, $fecha)
{
    $sql_check = "SELECT * FROM registro_clases WHERE usuario_id = ? AND carrera_id = ? AND materia_id = ? AND fecha = ?";
    $stmt_check = $conexion->prepare($sql_check);
    $stmt_check->bind_param('iiis', $usuario_id, $carrera_id, $materia_id, $fecha);
    $stmt_check->execute();
    return $stmt_check->get_result()->fetch_assoc();
}



function procesarFormulario($conexion)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario_id = $_POST['usuario_id'];
        $carrera_id = $_POST['carrera_id'];
        $materia_id = $_POST['materia_id'];
        $fecha = date('Y-m-d'); 

        $registro = obtenerRegistroDelDia($conexion, $usuario_id, $carrera_id, $materia_id, $fecha);

        if (isset($_POST['buscar1'])) {
            if (!$registro) {
                if (registrarEntrada($conexion, $usuario_id, $carrera_id, $materia_id, $fecha)) {
                    echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Hora de entrada registrada',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al registrar la entrada',
                            text: 'Por favor, inténtalo de nuevo.',
                            showConfirmButton: true
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Registro existente',
                        text: 'Ya existe un registro para esta fecha.',
                        showConfirmButton: true
                    });
                </script>";
            }
        } elseif (isset($_POST['buscar2'])) {
            if ($registro && empty($registro['hora_salida'])) {
                if (registrarSalida($conexion, $usuario_id, $carrera_id, $materia_id, $fecha)) {
                    echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Hora de salida registrada',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    </script>";
                } else {
                 
                }
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Registro inválido',
                        text: 'No hay registro de entrada o ya se registró la salida.',
                        showConfirmButton: true
                    });
                </script>";
            }
        }
    }
}

procesarFormulario($conexion);

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 2) {
    die("No tienes permisos para acceder a esta página.");
}
$usuario_id = $_SESSION['id_usuario'];

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

function getRegistros($db, $usuario_id, $fecha_actual)
{
    $queryRegistros = "
        SELECT carrera_id, materia_id, fecha, hora_entrada, hora_salida
        FROM registro_clases
        WHERE usuario_id = :usuario_id
        AND fecha = :fecha_actual
    ";
    $stmtRegistros = $db->prepare($queryRegistros);
    $stmtRegistros->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmtRegistros->bindParam(':fecha_actual', $fecha_actual, PDO::PARAM_STR);
    $stmtRegistros->execute();
    return $stmtRegistros->fetchAll(PDO::FETCH_ASSOC);
}

$materias = getMateriasAndCarreras($db, $usuario_id);
$fecha_actual = date('Y-m-d');
$registros = getRegistros($db, $usuario_id, $fecha_actual);

$registrosMap = [];
foreach ($registros as $registro) {
    $key = $registro['carrera_id'] . '-' . $registro['materia_id'];
    $registrosMap[$key] = $registro;
}
?>

<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">Listado de Registros de Clases</h5>
                    <a class="btn btn-warning float-right mb-2 mr-3" href="">Listar Asistencias</a>
                    <p class="float-right"></p>
                </div>
                <div class="card-body table-responsive">
                    <table id="example" class="table table-striped table-sm" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Carrera</th>
                                <th>Materia</th>
                                <th>Estado del Registro</th>
                                <th>Hora Entrada</th>
                                <th>Hora Salida</th>
                                <th>Fecha</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i = 1;
                            foreach ($materias as $materia) {
                                $key = $materia['carrera_id'] . '-' . $materia['materia_id'];
                                $registro = isset($registrosMap[$key]) ? $registrosMap[$key] : null;
                                if ($registro) {
                                    $estado = $registro['hora_salida'] ? 'Presente' : 'Ausente';
                                    $hora_entrada = $registro['hora_entrada'];
                                    $hora_salida = $registro['hora_salida'] ?? '---';
                                    $fecha_registro = $registro['fecha'];
                                } else {
                                    $estado = 'No Registrado';
                                    $hora_entrada = '---';
                                    $hora_salida = '---';
                                    $fecha_registro = '---';
                                }
                                
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo htmlspecialchars($materia['carrera_nombre'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($materia['materia_nombre'] ?? ''); ?></td>
                                <td><?php echo $estado; ?></td>
                                <td><?php echo htmlspecialchars($hora_entrada); ?></td>
                                <td><?php echo htmlspecialchars($hora_salida); ?></td>
                                <td><?php echo htmlspecialchars($fecha_registro); ?></td>
                                <td class="text-center">
                                    <?php if ($estado === 'No Registrado' || $hora_salida === '---') { ?>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mi-modal-<?php echo $materia['materia_id']; ?>">
                                            Asistencia
                                        </button>
                                    <?php } else { ?>
                                        <button class="btn btn-success" disabled role="button">Registrado</button>
                                    <?php } ?>
                                    <!-- Modal -->
                                    <div class="modal fade" id="mi-modal-<?php echo $materia['materia_id']; ?>" tabindex="-1" aria-labelledby="mi-modal-<?php echo $materia['materia_id']; ?>Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Registrar Asistencia</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post">
                                                        <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($usuario_id); ?>">
                                                        <input type="hidden" name="carrera_id" value="<?php echo htmlspecialchars($materia['carrera_id']); ?>">
                                                        <input type="hidden" name="materia_id" value="<?php echo htmlspecialchars($materia['materia_id']); ?>">
                                                        <div class="form-group d-flex">
                                                            <b>Docente:</b>
                                                            <p><?php echo ": " . $_SESSION['nombre']; ?></p>
                                                        </div>
                                                        <div class="form-group d-flex">
                                                            <b>Materia:</b>
                                                            <p><?php echo ": " . htmlspecialchars($materia['materia_nombre']); ?></p>
                                                        </div>
                                                        <div class="form-group d-flex">
                                                            <b>Carrera:</b>
                                                            <p><?php echo ": " . htmlspecialchars($materia['carrera_nombre']); ?></p>
                                                        </div>
                                                        <div class="form-group d-flex">
                                                            <b>Fecha:</b>
                                                            <p><?php echo ": " . date("d-m-Y"); ?></p>
                                                        </div>
                                                        <div class="form-group d-flex">
                                                            <b>Hora:</b>
                                                            <p><?php echo ": " . date("H:i:s"); ?></p>
                                                        </div>
                                                        <div class="btn-group d-flex pt-2">
                                                            <?php if ($estado === 'No Registrado') { ?>
                                                                <button type="submit" name="buscar1" class="btn btn-primary w-100">Entrada</button>
                                                            <?php } ?>
                                                            <?php if ($estado === 'Ausente' && $hora_salida === '---') { ?>
                                                                <button type="submit" name="buscar2" class="btn btn-danger w-100">Salida</button>
                                                            <?php } ?>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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
