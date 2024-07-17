<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Asistencia de Profesores</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <?php require 'navbar.php'; ?>
    
    <div class="container mt-4">
        <h1 class="mb-4">Registro de Asistencia de Profesores</h1>
        <form action="Rasist.php" method="post">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre y Apellido</th>
                            <th>Asistencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('../../conn/connection.php');

                        $sql = "SELECT id, nombreyapellido FROM profesores";
                        $stmt = $db->query($sql);

                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nombreyapellido']) . "</td>";
                                echo "<td>";
                                echo "<div class='form-group'>";
                                echo "<select class='form-control' name='asistencia[" . htmlspecialchars($row['id']) . "]'>";
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

    <?php require 'footer.php'; ?>
</body>
</html>
