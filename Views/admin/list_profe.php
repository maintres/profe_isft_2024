<?php
require '../../conn/connection.php'; 

//-------------BORRADO------------------ 
if (isset($_GET['txtID'])) {
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";
    $sentencia = $db->prepare("DELETE FROM profesores WHERE id = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $mensaje = "Registro de Profesor Eliminado";
    header("Location: list_profe.php?mensaje=" . $mensaje);
    exit;
}
require 'navbar.php';
?>
<head>
    <style>
        tr:nth-child(even){
	background-color: #ddd;
}

tr:hover td{
	background-color: #369681;
	color: white;
}

    </style>
</head>
<!-- ------------------------------------------- -->
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">Listado de Profesores</h5>
                    <a class="btn btn-primary float-right mb-2" href="profesor_crea.php">Registro de Profesor</a>
                </div>
                <div class="card-body table-responsive">
                    <table id="example" class="table table-striped table-sm" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre y Apellido</th>
                                <th>DNI</th>
                                <th>Domicilio</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>CV</th>
                                <th>Foto</th>
                                <th>Fecha de Ingreso</th>
                                <th>Fecha de Baja</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $query = "SELECT * FROM profesores";
                                $stmt = $db->prepare($query);
                                $stmt->execute();
                                $profesores = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($profesores as $profesor) {
                            ?>
                                    <tr>    
    <td><?php echo htmlspecialchars($profesor['id'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($profesor['nombreyapellido'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($profesor['dni'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($profesor['domicilio'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($profesor['telefono'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($profesor['email'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td>
        <a href="../../profesores/cv/<?php echo htmlspecialchars($profesor['cv'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank">Ver CV</a>
    </td>
    <td>
        <img src="../../profesores/uploads/<?php echo htmlspecialchars($profesor['foto'], ENT_QUOTES, 'UTF-8'); ?>" alt="Foto del Profesor" width="100" height="100" style="border-radius: 100%;">
    </td>
    <td><?php echo htmlspecialchars($profesor['fechadeingreso'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($profesor['fechadebaja'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td class="text-center">
        <div class="btn-group">
            <a href="update_profe.php?id=<?php echo htmlspecialchars($profesor['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-warning btn-sm" role="button"><i class="fas fa-edit"></i></a>
            <a href="delete_profe.php?txtID=<?php echo htmlspecialchars($profesor['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-danger btn-sm" role="button" onclick="return confirm('¿Seguro que desea eliminar este profesor?');"><i class="fas fa-trash"></i></a>
        </div>
    </td>
</tr>
                            <?php
                                }
                            } catch (PDOException $e) {
                                error_log("Error al obtener los profesores: " . $e->getMessage());
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="js/ocultarMensaje.js"></script>
<?php require 'footer.php'; ?>