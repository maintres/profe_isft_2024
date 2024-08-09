<?php 
require 'navbar.php'; 
require '../../conn/connection.php';
// -----------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {   
    include '../../conn/connection.php';
    $nombreyapellido = $_POST['nombreyapellido'];
    $dni = $_POST['dni'];
    $domicilio = $_POST['domicilio'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $fechadeingreso = $_POST['fechadeingreso'];
    $fechadebaja = $_POST['fechadebaja'];
    $foto = $_FILES['foto']['name'];
    $etapa = "Activo";
    $target_dir_foto = "../../profesores/uploads/";
    $target_file_foto = $target_dir_foto . basename($foto);
    $cv = $_FILES['cv']['name'];
    $target_dir_cv = "../../profesores/cv/";
    $target_file_cv = $target_dir_cv . basename($cv);
    if (!is_dir($target_dir_foto)) {
        mkdir($target_dir_foto, 0777, true);
    }
    if (!is_dir($target_dir_cv)) {
        mkdir($target_dir_cv, 0777, true);
    }
    try {
        $sql_check_dni = "SELECT * FROM profesores WHERE dni=:dni";
        $stmt = $db->prepare($sql_check_dni);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {            
            //$error = "Error: Ya existe un profesor con el mismo DNI.";
            // echo "Error: Ya existe un profesor con el mismo DNI.";
            // echo "<br> <a href='profe_crea.php' class='btn btn-warning'>Volver</a>";
            echo '<script>
                    var msj = "Error: Ya existe un profesor con el mismo DNI.";
                    window.location="profe_crea.php?error="+ msj
                  </script>';
        } else {
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file_foto);
            move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file_cv);
            $sql_insert = "INSERT INTO profesores (nombreyapellido, dni, domicilio, telefono, email, foto, cv, fechadeingreso, fechadebaja, etapa) 
                    VALUES (:nombreyapellido, :dni, :domicilio, :telefono, :email, :foto, :cv, :fechadeingreso, :fechadebaja, :etapa)";
            $stmt = $db->prepare($sql_insert);
            $stmt->bindParam(':nombreyapellido', $nombreyapellido);
            $stmt->bindParam(':dni', $dni);
            $stmt->bindParam(':domicilio', $domicilio);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':foto', $foto);
            $stmt->bindParam(':cv', $cv);
            $stmt->bindParam(':fechadeingreso', $fechadeingreso);
            $stmt->bindParam(':fechadebaja', $fechadebaja);
            $stmt->bindParam(':etapa', $etapa);
            if ($stmt->execute()) {
                //header("Location: profe_index.php?mensaje=" . urlencode("Profesor ingresada con éxito."));
                echo '<script>
                    var msj = "Profesor Creado exitosamente";
                    window.location="profe_index.php?mensaje="+ msj
                  </script>';
                exit();
            } else {
                $error = "Error al ingresar Profesor.";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    }
?>
<!-- -----------------------------------   -->  
<div class="container mt-3">
    <div class="col d-flex align-items-center justify-content-center">
    <div class="card rounded-2 border-0 w-75 ">
        <h5 class="card-header bg-dark text-white">Agregar Profesor</h5>
        <div class="card-body bg-light">          
            <form action="" method="post" enctype="multipart/form-data">
                <!-- --------------------------------- -->                
                        <div class="form-group">
                            <label for="nombre">Nombre y apellido:</label>
                            <input type="text" class="form-control" id="nombreyapellido" name="nombreyapellido" placeholder="Ingrese nombre y apellido"  required>
                        </div>                    
                        <div class="form-group">
                            <label for="nombre">DNI:</label>
                            <input type="number" class="form-control" id="dni" name="dni" placeholder="Ingrese DNI"  required>
                        </div>                    
                        <div class="form-group">
                            <label for="nombre">Domicilio:</label>
                            <input type="text" class="form-control" id="domicilio" name="domicilio" placeholder="Ingrese Domicilio"  required>
                        </div>                    
                        <div class="form-group">
                            <label for="nombre">Telefono:</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ingrese Telefono"  required>
                        </div>                    
                        <div class="form-group">
                            <label for="nombre">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese Email"  required>
                        </div>                    
                        <div class="form-group">
                            <label for="nombre">Foto:</label>
                            <input type="file" class="form-control" id="foto" name="foto"   >
                        </div>                    
                        <div class="form-group">
                            <label for="nombre">CV:</label>
                            <input type="file" class="form-control" id="cv" name="cv"  >
                        </div>                    
                        <div class="form-group">
                            <label for="nombre">Fecha de ingreso:</label>
                            <input type="date" class="form-control" id="fechadeingreso" name="fechadeingreso"  required>
                        </div>                    
                       
                <!-- --------------------------------- -->
                <button type="submit" class="btn btn-primary ">Guardar</button>
                <div id="confirmacion" style="display: none;">
                    <p>¿Seguro desea guardar los datos?</p>
                    <button type="button" class="btn btn-success" id="confirmarBtn">Sí</button>
                    <button type="button" class="btn btn-danger" id="cancelarBtn">No</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>             
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- <script src="js/ocultarMensaje.js"></script>     -->
<script src="../../js/contraseña.js"></script>
<script src="../../js/validacion.js"></script>
<script src="../../js/validacion2.js"></script>
<?php require 'footer.php'; ?>   