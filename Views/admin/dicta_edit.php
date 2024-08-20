<?php
include '../../conn/connection.php';

// Variables para almacenar los valores del formulario y mensajes de error
$id = $profesor_id = $materia_id = $tipo = $carrera_id = $error = "";
$baja = $fecha_baja = $motivo_baja = "";
$etapa = "Activo"; 


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT d.*, u.nombre, u.apellido, u.dni 
            FROM dicta d 
            JOIN usuarios u ON d.usuario_id = u.id_usuario 
            WHERE d.id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($registro) {
        $profesor_id = $registro['usuario_id'];
        $materia_id = $registro['FKmateria'];
        $tipo = $registro['tipo'];
        $carrera_id = $registro['FK_carrera'];
        $baja = $registro['Baja'];
        $fecha_baja = $registro['Fecha_baja'];
        $motivo_baja = $registro['motivo_baja'];
        $etapa = $registro['etapa'];
        $nombre_profesor = $registro['nombre'];
        $apellido_profesor = $registro['apellido'];
        $dni_profesor = $registro['dni'];
    } else {
        echo "Registro no encontrado.";
        exit();
    }
}

// Procesamiento del formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recolecta datos del formulario y realiza validaciones
    $profesor_id = trim($_POST["profesor_id"]);
    $materia_id = trim($_POST["materia_id"]);
    $tipo = trim($_POST["tipo"]);
    $carrera_id = trim($_POST["carrera_id"]);
    $baja = isset($_POST["baja"]) ? "SI" : "NO";
    $fecha_baja = !empty($_POST["fecha_baja"]) ? trim($_POST["fecha_baja"]) : NULL;
    $motivo_baja = !empty($_POST["motivo_baja"]) ? trim($_POST["motivo_baja"]) : NULL;

    if($baja==='SI'){
        $etapa='Inactivo';
    }


    // Validar campos obligatorios
    if (empty($profesor_id) || empty($materia_id) || empty($tipo) || empty($carrera_id)) {
        $error = "Por favor complete todos los campos obligatorios.";
    } else {
        try {
            // Actualizar datos en la tabla dicta
            $sql = "UPDATE dicta 
                    SET usuario_id = :profesor_id, FKmateria = :materia_id, tipo = :tipo, FK_carrera = :carrera_id, Baja = :baja, Fecha_baja = :fecha_baja, motivo_baja = :motivo_baja, etapa = :etapa 
                    WHERE id = :id";
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':profesor_id', $profesor_id);
            $stmt->bindParam(':materia_id', $materia_id);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':carrera_id', $carrera_id);
            $stmt->bindParam(':baja', $baja);
            $stmt->bindParam(':fecha_baja', $fecha_baja);
            $stmt->bindParam(':motivo_baja', $motivo_baja);
            $stmt->bindParam(':etapa', $etapa);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: dicta_index.php?mensaje=" . urlencode("Asignación editada con éxito."));
                exit();
            } else {
                $error = "Error al actualizar la asignación.";
            }
        } catch (PDOException $e) {
            $error = "Error en la base de datos: " . $e->getMessage();
        }
    }
}

// Obtener listas de materias y carreras para select options
$query_materias = "SELECT id, nombre FROM asignaturas ORDER BY nombre";
$result_materias = $db->query($query_materias);

$query_carreras = "SELECT id, nombre FROM carreras ORDER BY nombre";
$result_carreras = $db->query($query_carreras);
?>

<!-- -------------------------------------- -->
<?php require 'navbar.php'; ?>

<div class="container mt-3">
    <div class="card rounded-2 border-0">
        <h5 class="card-header bg-dark text-white">Editar Asignación</h5>
        <div class="card-body bg-light">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
                <input type="hidden" name="profesor_id" value="<?php echo htmlspecialchars($registro['usuario_id']); ?>">

                <div class="form-group">
                    <label for="nombre">Nombre del Profesor:</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($nombre_profesor) . ' ' . htmlspecialchars($apellido_profesor); ?>" >
                </div>
                <div class="form-group">
                    <label for="dni">DNI del Profesor:</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($dni_profesor); ?>" >
                </div>
                <div class="form-group">
                    <label for="materia_id">Materia:</label>
                    <select name="materia_id" class="form-control">
                        <option value="">Seleccione una materia</option>
                        <?php while ($row = $result_materias->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value="<?php echo $row['id']; ?>" <?php echo $materia_id == $row['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($row['nombre']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="carrera_id">Carrera:</label>
                    <select name="carrera_id" class="form-control">
                        <option value="">Seleccione una carrera</option>
                        <?php while ($row = $result_carreras->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value="<?php echo $row['id']; ?>" <?php echo $carrera_id == $row['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($row['nombre']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo de Asignación:</label>
                    <select name="tipo" class="form-control">
                        <option value="">Seleccione un tipo</option>
                        <option value="titular" <?php echo $tipo == 'titular' ? 'selected' : ''; ?>>Titular</option>
                        <option value="interino" <?php echo $tipo == 'interino' ? 'selected' : ''; ?>>Interino</option>
                        <option value="suplente" <?php echo $tipo == 'suplente' ? 'selected' : ''; ?>>Suplente</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="baja">Baja:</label>
                    <input type="checkbox" name="baja" value="SI" <?php echo $baja == "SI" ? 'checked' : ''; ?>> Marcar si tiene baja
                </div>
                <div class="form-group">
                    <label for="fecha_baja">Fecha de Baja:</label>
                    <input type="date" name="fecha_baja" class="form-control" value="<?php echo htmlspecialchars($fecha_baja); ?>">
                </div>
                <div class="form-group">
                    <label for="motivo_baja">Motivo de Baja:</label>
                    <textarea name="motivo_baja" class="form-control"><?php echo htmlspecialchars($motivo_baja); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
                <?php if (!empty($error)) : ?>
                    <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>
