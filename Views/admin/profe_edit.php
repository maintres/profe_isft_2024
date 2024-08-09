<?php
require '../../conn/connection.php';
require 'navbar.php';
// ------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombreyapellido = $_POST['nombreyapellido'];
    $dni = $_POST['dni'];
    $domicilio = $_POST['domicilio'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $fechadeingreso = $_POST['fechadeingreso'];
    $fechadebaja = $_POST['fechadebaja'];
    // Manejo del archivo de foto
    $foto = $_FILES['foto']['name'];
    $cv = $_FILES['cv']['name'];
    $etapa = $fechadebaja ? 'Inactivo' : 'Activo';
    $updateQuery = "UPDATE profesores SET 
        nombreyapellido = :nombreyapellido, 
        dni = :dni, 
        domicilio = :domicilio, 
        telefono = :telefono, 
        email = :email, 
        fechadeingreso = :fechadeingreso, 
        fechadebaja = :fechadebaja, 
        etapa = :etapa";
    if ($foto) {
        $updateQuery .= ", foto = :foto";
        $target_dir_foto = "../../profesores/uploads/";
        $target_file_foto = $target_dir_foto . basename($foto);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file_foto);
    }
    if ($cv) {
        $updateQuery .= ", cv = :cv";
        $target_dir_cv = "../../profesores/cv/";
        $target_file_cv = $target_dir_cv . basename($cv);
        move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file_cv);
    }
    $updateQuery .= " WHERE id = :id";
    try {
        $stmt = $db->prepare($updateQuery);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombreyapellido', $nombreyapellido);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':domicilio', $domicilio);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fechadeingreso', $fechadeingreso);
        $stmt->bindParam(':fechadebaja', $fechadebaja);
        $stmt->bindParam(':etapa', $etapa);
        if ($foto) {
            $stmt->bindParam(':foto', $foto);
        }
        if ($cv) {
            $stmt->bindParam(':cv', $cv);
        }
        if ($stmt->execute()) {
            echo '<script>
                    var msj = "Profesor actualizado exitosamente";
                    window.location="profe_index.php?mensaje="+ msj
                  </script>';
            exit;
        } else {
            echo "Error: No se pudo actualizar el profesor.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
// -----------------------------------------
$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id) {
    try {
        $sql = "SELECT * FROM profesores WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $profesor = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$profesor) {
            echo "Profesor no encontrado.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "ID de profesor no proporcionado.";
    exit;
}
?>
<!-- ---------------------------- -->
<div class="col">
    <div class="card rounded-2 border-0">
        <h5 class="card-header bg-dark text-white">Actualizar Profesor</h5>
        <div class="card-body bg-light">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($profesor['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <!-- --------------------------------- -->                
                <div class="form-group">
                    <label for="nombre">Nombre y apellido:</label>
                    <input type="text" class="form-control" id="nombreyapellido" name="nombreyapellido" placeholder="Ingrese nombre y apellido" value="<?php echo htmlspecialchars($profesor['nombreyapellido'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="dni">DNI:</label>
                    <input type="number" class="form-control" id="dni" name="dni" placeholder="Ingrese DNI" value="<?php echo htmlspecialchars($profesor['dni'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="domicilio">Domicilio:</label>
                    <input type="text" class="form-control" id="domicilio" name="domicilio" placeholder="Ingrese Domicilio" value="<?php echo htmlspecialchars($profesor['domicilio'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="telefono">Telefono:</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ingrese Telefono" value="<?php echo htmlspecialchars($profesor['telefono'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese Email" value="<?php echo htmlspecialchars($profesor['email'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="foto">Foto:</label>
                    <input type="file" class="form-control" id="foto" name="foto">
                    <?php if ($profesor['foto']): ?>
                        <img src="../../profesores/uploads/<?php echo htmlspecialchars($profesor['foto'], ENT_QUOTES, 'UTF-8'); ?>" alt="Foto del Profesor" width="100" height="100">
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="cv">CV:</label>
                    <input type="file" class="form-control" id="cv" name="cv">
                    <?php if ($profesor['cv']): ?>
                        <a href="../../profesores/cv/<?php echo htmlspecialchars($profesor['cv'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank">Ver CV</a>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="fechadeingreso">Fecha de ingreso:</label>
                    <input type="date" class="form-control" id="fechadeingreso" name="fechadeingreso" value="<?php echo htmlspecialchars($profesor['fechadeingreso'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="fechadebaja">Fecha de Baja:</label>
                    <input type="date" class="form-control" id="fechadebaja" name="fechadebaja" value="<?php echo htmlspecialchars($profesor['fechadebaja'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <!-- --------------------------------- -->
                <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
            </form>
        </div>
    </div>
</div>
<br>
<br><br>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="../../js/contraseña.js"></script>
<script src="../../js/validacion.js"></script>
<script src="../../js/validacion2.js"></script>
<?php require 'footer.php'; ?>                                                                                                                                                                                                 
