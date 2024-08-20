<?php
require 'navbar.php';
include('../../conn/connection.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica que el usuario tenga el rol adecuado
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 3) {
    die("No tienes permisos para acceder a esta página.");
}

$usuario_id = $_SESSION['id_usuario'];

// Función para obtener todos los registros de clases de profesores
function obtenerRegistrosProfesores($conexion)
{
    $sql = "SELECT r.usuario_id, r.carrera_id, r.materia_id, r.fecha, r.hora_entrada, r.hora_salida, 
                   c.nombre AS carrera_nombre, a.nombre AS materia_nombre, 
                   u.nombre AS usuario_nombre, u.apellido AS usuario_apellido, u.dni AS usuario_dni
            FROM registro_clases r
            JOIN asignaturas a ON r.materia_id = a.id
            JOIN carreras c ON r.carrera_id = c.id
            JOIN usuarios u ON r.usuario_id = u.id_usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

$registros = obtenerRegistrosProfesores($conexion);
?>

<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="d-inline-block">Listado de Registros de Clases de Profesores</h5>
                    <a href="generar_pdf.php?export=pdf" class="btn btn-primary">Exportar a PDF</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-sm" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>DNI</th>
                                    <th>Carrera</th>
                                    <th>Materia</th>
                                    <th>Estado del Registro</th>
                                    <th>Hora Entrada</th>
                                    <th>Hora Salida</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = 1;
                                if (!empty($registros)) {
                                    foreach ($registros as $registro) {
                                        $estado = $registro['hora_salida'] ? 'Presente' : 'Ausente';
                                        $hora_entrada = $registro['hora_entrada'] ?? '---';
                                        $hora_salida = $registro['hora_salida'] ?? '---';
                                        $fecha_registro = $registro['fecha'] ?? '---';
                            ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($registro['usuario_nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($registro['usuario_apellido']); ?></td>
                                    <td><?php echo htmlspecialchars($registro['usuario_dni']); ?></td>
                                    <td><?php echo htmlspecialchars($registro['carrera_nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($registro['materia_nombre']); ?></td>
                                    <td><?php echo $estado; ?></td>
                                    <td><?php echo htmlspecialchars($hora_entrada); ?></td>
                                    <td><?php echo htmlspecialchars($hora_salida); ?></td>
                                    <td><?php echo htmlspecialchars($fecha_registro); ?></td>
                                </tr>
                            <?php 
                                    }
                                } else {
                            ?>
                                <tr>
                                    <td colspan="10" class="text-center">No hay registros.</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require 'footer.php'; ?>
