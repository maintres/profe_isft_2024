<?php
require '../../conn/connection.php';
$infoMessage = '';
$errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];        
        $cantidaddehoras = $_POST['cantidaddehoras'];

        $consulta_actualizar = $db->prepare("UPDATE asignaturas SET nombre = ?, cantidaddehoras	= ? WHERE id = ?");
        $consulta_actualizar->bindParam($id,$nombre,$cantidaddehoras,$id);

        if ($consulta_actualizar->execute([$nombre, $cantidaddehoras,$id])) {
            $infoMessage = 'Registro modificado correctamente';
        } else {
            $errorMessage = 'Error al editar el registro: ' . implode(', ' , $consulta_actualizar->errorInfo());
        }
    } else {
        $errorMessage = 'Falta el ID de la materia en el formulario.';
    }
}
// --------------------------------------------------------------------
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Consultar la materia con el ID proporcionado
    $consulta_materia = $db->prepare("SELECT * FROM asignaturas WHERE id = ?");
    $consulta_materia->execute([$id]);
    $materia = $consulta_materia->fetch();
    // Verificar si se encontró la materia
    if (!$materia) {
        die('No se encontró la materia con el ID proporcionado.');
    }
} else {
    // Si no se proporciona un ID válido en la URL
    die('Ha ocurrido un error');
}
// Redirigir solo si hay mensajes para enviar
if ($infoMessage || $errorMessage) {
    header("Location: materia_index.php?mensaje=" . urlencode($infoMessage) . "&error=" . urlencode($errorMessage));
    exit();
}
?>
<!-- -------------------------------------------- -->
<?php require 'navbar.php'; ?>
    <div class="container mt-3">
        <div class="row m-auto">
            <div class="col-sm">
                <div class="card rounded-2 border-0">
                    <h5 class="card-header bg-dark text-white">Edición de Materia</h5>
                    <div class="card-body bg-light">
                        <form method="post" class="form" action="">
                            <input type="hidden" class="form-control" name="id" value="<?php echo htmlspecialchars($materia['id']); ?>">
                            <!-------------------------------------------------------------->
                            <label>Nombres:</label>
                            <input type="text" class="form-control" required name="nombre" autocomplete="off" value="<?php echo htmlspecialchars($materia['nombre']); ?>" maxlength="45">
                            <!-------------------------------------------------------------->
                            <label>Horas de cursada:</label>
                            <input type="text" class="form-control" required name="cantidaddehoras" autocomplete="off" value="<?php echo htmlspecialchars($materia['cantidaddehoras']); ?>" maxlength="8">
                           
                            <br>
                            <!-------------------------------------------------------------->
                            <div class="mt-3 mb-2">
                                <button type="submit" class="btn btn-primary" name="modificar" onclick="return confirm('¿Estás seguro de guardar los cambios?')">Guardar Cambios</button>
                                <a class="btn btn-warning" href="materia_index.php">Ver Listado</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require 'footer.php'; ?>   