<?php
require '../../conn/connection.php';

// Obtener el ID del profesor a editar
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    try {
        // Obtener los datos del profesor
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
<?php require 'navbar.php'; ?>  
<br>
<div class="col">
    <div class="card rounded-2 border-0">
        <h5 class="card-header bg-dark text-white">Actualizar Profesor</h5>
        <div class="card-body bg-light">
            <form action="procesar_update_profe.php" method="post" enctype="multipart/form-data">
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