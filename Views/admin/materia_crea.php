<?php
include '../../conn/connection.php';
// Verifica si se envió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recolecta datos del formulario
    $nombre = trim($_POST["nombre"]);
    $cantidaddehoras = trim($_POST["cantidaddehoras"]);
    $error = "";
    try {
        // Verificar si el correo electrónico ya existe
        $sql_check_nombre = "SELECT COUNT(*) FROM asignaturas WHERE nombre = :nombre";
        $stmt_check_nombre = $db->prepare($sql_check_nombre);
        $stmt_check_nombre->bindParam(':nombre', $nombre);
        $stmt_check_nombre->execute();
        $count_nombre = $stmt_check_nombre->fetchColumn();
        // Verificar si el DNI ya existe        
        if ($count_nombre > 0) {
            $error = "Materia ya registrada. Por favor, ingrese una diferente.";
        }
        if ($error) {
            $redirect_url = "materia_crea.php?error=" . urlencode($error)
                . "&nombre=" . urlencode($nombre)
                . "&cantidaddehoras=" . urlencode($cantidaddehoras);

            header("Location: " . $redirect_url);
            exit();
        } else {
            // Inserta datos en la base de datos
            $sql = "INSERT INTO asignaturas (nombre,cantidaddehoras) 
                    VALUES (:nombre, :cantidaddehoras)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':cantidaddehoras', $cantidaddehoras);         

            if ($stmt->execute()) {
                header("Location: materia_index.php?mensaje=" . urlencode("Materia ingresada con éxito."));
                exit();
            } else {
                $error = "Error al ingresar Materia.";
            }
        }
    } catch (PDOException $e) {
        $error = "Error en la base de datos: " . $e->getMessage();
        $redirect_url = "materia_crea.php?error=" . urlencode($error)
            . "&nombre=" . urlencode($nombre)
            . "&cantidaddehoras=" . urlencode($cantidaddehoras);

        header("Location: " . $redirect_url);
        exit();
    }
}
?>
<!-- ---------------------------------------------------- -->
<?php require 'navbar.php'; ?>
<div class="container mt-3">
    <div class="card rounded-2 border-0">
        <h5 class="card-header bg-dark text-white">Formulario de Inscripción de Profesor</h5>
        <div class="card-body bg-light">
            <?php
            // Recupera el mensaje de error y los datos del formulario desde la URL
            $error = isset($_GET["error"]) ? $_GET["error"] : "";
            $nombre = isset($_GET["nombre"]) ? $_GET["nombre"] : "";
            $cantidaddehoras = isset($_GET["cantidaddehoras"]) ? $_GET["cantidaddehoras"] : "";
            
            ?>
            <form id="formulario" method="post" action="">
                <!-- --------------------------------- -->
                    <div class="col">

                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>" autocomplete="off" placeholder="Ingrese Nombre(s)" required>
                        </div>
                        <!-- ---------------------------- -->
                        <div class="form-group">
                            <label for="cantidaddehoras">Horas de cursada:</label>
                            <input type="text" class="form-control" name="cantidaddehoras" id="cantidaddehoras" value="<?php echo htmlspecialchars($cantidaddehoras); ?>" autocomplete="off" placeholder="Ingrese cantidaddehoras(s)" required>
                        </div>
                       
                        
                    </div>
                <!-- --------------------------------- -->
                <button type="button" class="btn btn-primary float-right" id="guardarBtn" onclick="validarFormulario()">Guardar</button>
                <!-- Agregamos un div para mostrar un mensaje de confirmación -->
                <div id="confirmacion" style="display: none;">
                    <p>¿Estás seguro de que deseas guardar los datos?</p>
                    <button type="button" class="btn btn-success" id="confirmarBtn">Sí</button>
                    <button type="button" class="btn btn-danger" id="cancelarBtn">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../../js/contraseña.js"></script>
<script src="../../js/validacion.js"></script>
<script src="../../js/validacion2.js"></script>
<?php require 'footer.php'; ?>