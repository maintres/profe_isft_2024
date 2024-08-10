<?php
require 'navbar.php'; 
include('../../conn/connection.php');
// -----------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if(isset($_POST['buscar1'])){
    $sql_clase = "SELECT * FROM registro_clases WHERE ...";
    $result_clase = $conexion->query($sql_clase);
    $clase = $result_clase->fetch_assoc();

    $select_clase = $clase['id'];  

    echo "
    *poner un if para no permitir que se pueda ingresar la misma fecha dos veces en la mima tabla*    
    "; 

    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    
    $usuario_id= $_POST['usuario_id'];
    $carrera_id= $_POST['carrera_id'];
    $usuario_id= $_POST['usuario_id'];    
    
}
if(isset($_POST['buscar2'])){
    
    echo "
    *poner un if para no permitir que se pueda ingresar la misma fecha dos veces en la mima tabla*
    ";

}
}

// ----------------------------------------------------------------------
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
                    <a class="btn btn-warning float-right mb-2 mr-3" href="">Listar Asistencias</a> 
                    <p class="float-right">**posible boton para listar la tabla "registro_clases"**</p>                

                </div>
                <div class="card-body table-responsive">
                    <table id="example" class="table table-striped table-sm" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Carrera</th>
                                <th>Materia</th>
                                <th>Estado del Registro</th> 
                                <th>Agrega</th>
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
                                    <p>**no se si dejarlo o quitarlo**</p>
                                </td>
                                <!-- ---------------------------- -->
                                <td class="text-center">
                                    <!-- <div class="btn-group">
                                        <?php if (!$registrado) { ?>
                                            <a href="listar_registros.php?usuario_id=<?php echo $usuario_id; ?>&carrera_id=<?php echo $materia['carrera_id']; ?>&materia_id=<?php echo $materia['materia_id']; ?>" 
                                                class="btn btn-primary btn-sm" 
                                                role="button">Registrar Clase
                                            </a>
                                        <?php } else { ?>
                                            <button class="btn btn-success btn-sm" disabled role="button">Registrado</button>
                                        <?php } ?>
                                    </div> -->
                                    <!-- ------------------------- -->
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mi-modal">
                                    Asistencia
                                    </button> 
                                </td>                               
                                <!-- ------------------------------------------------- -->
                                <div class="modal fade" id="mi-modal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Registrar </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="post">
                                                    <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($usuario_id); ?>">
                                                    <input type="hidden" name="carrera_id" value="<?php echo htmlspecialchars($materia['carrera_id']); ?>">
                                                    <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($materia['materia_id']); ?>">
                                                    <input type="hidden" name="fecha" value="<?php echo date("Y-m-d");?>">
                                                    <input type="hidden" name="hora" value="<?php echo date("h:i:sa");?>">
                                                    <!-- ---------------------------------------- -->
                                                    <div class="form-group d-flex">
                                                        <b>Docente</b>
                                                        <p><?php echo ": ". $_SESSION['nombre']?></p>
                                                        <!-- <label for="recipient-name" class="col-form-label">Docente:</label>
                                                        <input type="text" class="form-control" name="nombre" value="<?php echo $_SESSION['nombre']?>" selected disabled > -->
                                                    </div> 
                                                    <div class="form-group d-flex">
                                                        <b>Materia</b>
                                                        <p><?php echo ": ". $materia['materia_nombre']?></p>                                                        
                                                    </div> 
                                                    <div class="form-group d-flex">
                                                        <b>Carrera</b>
                                                        <p><?php echo ": ". $materia['carrera_nombre']?></p>                                                        
                                                    </div>    
                                                  
                                                    <div class="form-group d-flex">
                                                        <b>Fecha</b>
                                                        <p><?php echo ": ".date("d-m-Y");?></p>                                                        
                                                    </div>
                                                    <div class="form-group d-flex">
                                                        <b>Hora</b>
                                                        <p><?php echo ": ".date("h:i:sa");?></p>                                                        
                                                    </div>                                                    
                                                    <!-- ----------------- -->
                                                    <p>**hay que hacer funcionar la carga del form y los botones redireccionan hacia el post**</p>                                                    
                                                    <p>**no se si la carga de fecha y hora se pueda registrar asi, si no hay que cambiarlo en la BD y poner que sea tipo text**</p>   
                                                    <p>**mas comentarios en la linea 13 y 20**</p>    
                                                    <div class="btn-grup d-flex pt-2">                                                        
                                                        <button type="submit" name="buscar1" class="btn btn-primary w-100">Entrada</button>
                                                        <button type="submit" name="buscar2" class="btn btn-danger w-100">Salida</button>
                                                    </div>
                                                </form>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- ------------------------------------------- -->
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