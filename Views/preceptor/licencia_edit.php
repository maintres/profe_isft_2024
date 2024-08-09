<?php
include("../../conn/connection.php");
require("navbar.php");

if (isset($_POST['Enviar'])) {
    $idtipos_licencias = $_POST['idtipos_licencias'];
    $id = $_POST['id'];
    $profesorSeleccionado = $_POST['profesor'];
    $FechaInicio = $_POST['Finicio'];
    $FechaFin = $_POST['Ffin'];
    $etapa = "Activo";

<<<<<<< HEAD
    list($profesorId, $profesorNombre) = explode('|', $profesorSeleccionado);
    # Asignar NULL si idtipos_licencias está vacío
=======
    // Asignar NULL si idtipos_licencias está vacío
>>>>>>> 4140126 (Modifique varias cosas, por que cambie la bd para poder acceder ah la vista profesor y asi hacer las tareas que me dijo el profe, hagan una revison de sus modulos.)
    if (empty($idtipos_licencias)) {
        $idtipos_licencias = NULL;
    }

<<<<<<< HEAD
    $SQL = "UPDATE licencias SET nombre=?, fechadeinicio=?, fechadefin=?, idprofesor=?, idtipos_licencias=?, etapa=? WHERE id=?";
    $sentenciaPreparada = mysqli_prepare($conexion, $SQL);

    # Cambiar el tipo de enlace para que soporte NULL
    if ($idtipos_licencias === NULL) {
        mysqli_stmt_bind_param($sentenciaPreparada, "sssiiis", $profesor, $FechaInicio, $FechaFin, $idtipos_licencias, $id, $profesorId, $etapa);
    } else {
        mysqli_stmt_bind_param($sentenciaPreparada, "sssiiis", $profesor, $FechaInicio, $FechaFin, $idtipos_licencias, $id, $profesorId, $etapa);
    }
=======
    try {
        $SQL = "UPDATE licencias SET usuario_id=?, fechadeinicio=?, fechadefin=?, idtipos_licencias=? WHERE id=?";
        $stmt = $db->prepare($SQL);

        // Bind parameters
        $stmt->bindParam(1, $profesor, PDO::PARAM_INT);
        $stmt->bindParam(2, $FechaInicio);
        $stmt->bindParam(3, $FechaFin);
        $stmt->bindValue(4, $idtipos_licencias, PDO::PARAM_INT);
        $stmt->bindParam(5, $id, PDO::PARAM_INT);
>>>>>>> 4140126 (Modifique varias cosas, por que cambie la bd para poder acceder ah la vista profesor y asi hacer las tareas que me dijo el profe, hagan una revison de sus modulos.)

        if ($stmt->execute()) {
            echo "<script>
                alert('Los datos se actualizaron correctamente');
                window.location = 'licencia_index.php';
                </script>";
        } else {
            echo "<script>
                alert('Los datos no se actualizaron correctamente');
                window.location = 'licencia_index.php';
                </script>";
        }
    } catch (PDOException $e) {
        echo "<script>
            alert('Error: " . $e->getMessage() . "');
            window.location = 'licencia_index.php';
            </script>";
    }
} else {
    $id = $_GET['id'];

    try {
        $sql = "SELECT * FROM licencias WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar si las claves existen antes de usarlas
        $profesor = isset($fila['usuario_id']) ? $fila['usuario_id'] : '';
        $FechaInicio = isset($fila['fechadeinicio']) ? $fila['fechadeinicio'] : '';
        $FechaFin = isset($fila['fechadefin']) ? $fila['fechadefin'] : '';
        $idtipos_licencias = isset($fila['idtipos_licencias']) ? $fila['idtipos_licencias'] : '';
    } catch (PDOException $e) {
        die("Error al obtener los datos: " . $e->getMessage());
    }
}
?>

<div class="container mt-3">
    <div class="card rounded-2 border-0">
        <h5 class="card-header bg-dark text-white">Formulario para modificar licencia</h5>
        <div class="card-body bg-light">
            <form class="form-group" action="" method="post">
                <p>Profesor:</p>
                <?php
                // Consulta para obtener profesores con id_rol = 2
                $consulta = "SELECT id_usuario AS id, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM usuarios WHERE id_rol = 2";
                $resultado = $db->query($consulta);
                ?>
                <select class="form-select" name="profesor" id="profesor">
                    <?php
                    while ($opciones = $resultado->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <option value="<?php echo htmlspecialchars($opciones['id']); ?>" <?php if ($opciones['id'] == $profesor) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($opciones['nombre_completo']); ?>
                        </option>
                    <?php
                    }
<<<<<<< HEAD
                   
                    ?>
                </select>
                <!-- -------------------------------------- -->
                <div class="form-group">
                   <label for="Finicio">Fecha de inicio:</label>
                   <input class="form-control datepicker-date" type="date" name="Finicio" value="<?php echo $FechaInicio; ?>">
                </div>
                <!-- -------------------------------------- -->
                <div class="form-group">
                    <label for="Finicio">Fecha de fin:</label>
                    <input class="form-control datepicker-date" type="date" name="Ffin" value="<?php echo $FechaFin; ?>">
                </div>
                <!-- -------------------------------------- -->
                <p class="form-label mt-4">Tipo de licencia</p>
                <?php
                 $cons = "SELECT * FROM tipos_licencias WHERE etapa = 'Activo'";
                 $resul = mysqli_query($conexion, $cons);
                  ?>
                <select class="form-select" name="tipoLicencia" id="">
                <?php
                 while ($opcion = mysqli_fetch_assoc($resul)) {
                 ?>
                    <option value="<?php echo $opcion['id'] . '|' . $opcion['tipodelicencia'];?>">
                    <?php echo $opcion['tipodelicencia']; ?>
                    </option>
                    <?php
                 }
                 mysqli_close($conexion);
                    ?>
                </select>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" id="idtipos_licencias" name="idtipos_licencias" value="">
=======
                    ?>
                </select>
                <p class="form-label mt-4">Fecha de inicio:</p>
                <input class="form-control" type="date" name="Finicio" value="<?php echo htmlspecialchars($FechaInicio); ?>" required>
                <p>Fecha de fin:</p>
                <input class="form-control" type="date" name="Ffin" value="<?php echo htmlspecialchars($FechaFin); ?>" required><br>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <input type="hidden" name="idtipos_licencias" value="<?php echo htmlspecialchars($idtipos_licencias); ?>">
>>>>>>> 4140126 (Modifique varias cosas, por que cambie la bd para poder acceder ah la vista profesor y asi hacer las tareas que me dijo el profe, hagan una revison de sus modulos.)
                <input class="btn btn-primary" type="submit" name="Enviar" value="Guardar Cambios">
                <button class="btn btn-warning"><a href="licencia_index.php" style="color: inherit; text-decoration: none;">Volver al Listado</a></button>
            </form>
        </div>
    </div>
</div>

<?php
require("footer.php");
?>
