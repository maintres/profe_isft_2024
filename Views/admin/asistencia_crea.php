<?php 
require 'navbar.php'; 
include('../../conn/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" ){
    if (isset($_POST['asistencia'])) {
        $fecha = date('Y-m-d');
        $asistencia = $_POST['asistencia'];

        try {
            // Preparar la consulta para insertar la asistencia
            $sql = "INSERT INTO asistencia (profesor_id, fecha, estado) VALUES (?, ?, ?)";
            $stmt = $db->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Error en la preparación de la consulta: ' . $db->errorInfo()[2]);
            }

            foreach ($asistencia as $id_usuario => $estado) {
                if (in_array($estado, ['presente', 'ausente', 'justificada'])) {
                    $stmt->bindParam(1, $id_usuario, PDO::PARAM_INT);
                    $stmt->bindParam(2, $fecha, PDO::PARAM_STR);
                    $stmt->bindParam(3, $estado, PDO::PARAM_STR);

                    // Ejecutar la inserción para cada profesor
                    if (!$stmt->execute()) {
                        throw new Exception('Error al ejecutar la consulta: ' . $stmt->errorInfo()[2]);
                    }
                }
            }

            echo '<script>
                    var msj = "Asistencia registrada correctamente";
                    window.location="asistencia_index.php?mensaje="+ msj;
                  </script>';
            exit();

        } catch (Exception $e) {
            echo '<script>
                    var error = "Error al procesar la asistencia: ' . $e->getMessage() . '";
                    window.location="asistencia_index.php?error="+ error;
                  </script>';
            exit();
        }    
    } else {
        echo '<script>
                var error1 = "No se recibieron datos de asistencia.";
                window.location="asistencia_index.php?error="+ error1;
              </script>';
        exit();
    }
}
?>
<!-- --------------------------------------   -->
<div class="container mt-3">
    <div class="col d-flex align-items-center justify-content-center">
        <div class="card rounded-2 border-0 w-75">
            <h5 class="card-header bg-dark text-white">Registro de Asistencia de Profesores</h5>
            <div class="card-body bg-light">          
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre y Apellido</th>
                                    <th>Asistencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php    
                                $sql = "SELECT id_usuario, nombre, apellido FROM usuarios WHERE id_rol = 2"; // Asumiendo que el rol 2 es el de profesor
                                $stmt = $db->query($sql);
                                if ($stmt->rowCount() > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['id_usuario']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['nombre']) . " " . htmlspecialchars($row['apellido']) . "</td>";
                                        echo "<td>";
                                        echo "<div class='form-group'>";
                                        echo "<select class='form-control' name='asistencia[" . htmlspecialchars($row['id_usuario']) . "]'>";
                                        echo "<option value=''>Seleccionar</option>";
                                        echo "<option value='presente'>Presente</option>";
                                        echo "<option value='ausente'>Ausente</option>";
                                        echo "<option value='justificada'>Justificada</option>";
                                        echo "</select>";
                                        echo "</div>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center'>No hay profesores registrados</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar Asistencia</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require 'footer.php'; ?>

