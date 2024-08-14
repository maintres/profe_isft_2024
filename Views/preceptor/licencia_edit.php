<?php
include("../../conn/connection.php");
require("navbar.php");
// ----------------------------------
if (isset($_POST['Enviar'])) {
    $idtipos_licencias = $_POST['idtipos_licencias'];
    $id = $_POST['id'];
    $fechadeinicio = $_POST['Finicio'];
    $fechadefin = $_POST['Ffin'];
    $etapa = "Activo";
    if (empty($idtipos_licencias)) {
        $idtipos_licencias = NULL;
    }
    try {
        $SQL = "UPDATE licencias SET 
        fechadeinicio= :fechadeinicio, 
        fechadefin= :fechadefin, 
        idtipos_licencias= :idtipos_licencias ";
        $stmt = $db->prepare($SQL);
        $stmt->bindParam(':fechadeinicio', $fechadeinicio);
        $stmt->bindParam(':fechadefin', $fechadefin);
        $stmt->bindParam(':idtipos_licencias', $idtipos_licencias);
        if ($stmt->execute()) {
            echo '<script>
                    var msj = "Datos actualizado exitosamente";
                    window.location="licencia_index.php?mensaje="+ encodeURIComponent(msj)
                  </script>';
        } else {
            echo "Error: No se pudo actualizar el usuario.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
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
<!-- ------------------------------------------------- -->
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
                <select class="form-select" name="profesor" id="profesor" disabled>
                    <?php
                    while ($opciones = $resultado->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <option value="<?php echo htmlspecialchars($opciones['id']); ?>" <?php if ($opciones['id'] == $profesor) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($opciones['nombre_completo']); ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
                <!-- -------------------------- -->
                <p class="form-label mt-4">Fecha de inicio:</p>
                <input class="form-control" type="date" name="Finicio" value="<?php echo htmlspecialchars($FechaInicio); ?>" required >                
                <!-- -------------------------- -->
                <p>Fecha de fin:</p>
                <input class="form-control" type="date" name="Ffin" value="<?php echo htmlspecialchars($FechaFin); ?>" required><br>                
                <!-- -------------------------- -->
                <p>Tipo de Licencia</p>
                <?php
                $cons = "SELECT id, tipodelicencia FROM tipos_licencias WHERE etapa = 'Activo'";
                $resul = $db->query($cons);
                if (!$resul) {
                    die("Error en la consulta: " . $db->errorInfo()[2]);
                }
                ?>
                <select class="form-select" name="idtipos_licencias" id="idtipos_licencias">
                    <?php
                    while ($opcion = $resul->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <option value="<?php echo htmlspecialchars($opcion['id']); ?>">
                            <?php echo htmlspecialchars($opcion['tipodelicencia']); ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>                
                <!-- -------------------------- -->
                <br>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">                
                <input class="btn btn-primary" type="submit" name="Enviar" value="Guardar Cambios">
                <button class="btn btn-warning"><a href="licencia_index.php" style="color: inherit; text-decoration: none;">Volver al Listado</a></button>
            </form>
        </div>
    </div>
</div>
<?php require("footer.php"); ?>