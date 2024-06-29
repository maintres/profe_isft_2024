<?php
require '../../conn/connection.php';
//-------------BORRADO------------------ 
if(isset($_GET['txtID'])){
  $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
  $sentencia=$db->prepare("UPDATE usuarios SET estado = 'Inactivo' WHERE id = :id" );
  $sentencia->bindParam(':id',$txtID);
  $sentencia->execute();
  $mensaje="Registro Administrador Eliminado";
  header("Location:admin_index.php?mensaje=".$mensaje);
}
?>
<!-- ------------------------------------------ -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recolecta datos del formulario
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $password = $_POST["password"];
    
    $id_permisos = "1"; // Valor predeterminado para alumno es 1.

    $error = "";
    try {
        // Verificar si el correo electrónico ya existe
        $sql_check_correo = "SELECT COUNT(*) FROM usuarios WHERE correo = :correo";
        $stmt_check_correo = $db->prepare($sql_check_correo);
        $stmt_check_correo->bindParam(':correo', $correo);
        $stmt_check_correo->execute();
        $count = $stmt_check_correo->fetchColumn();

        if ($count > 0) {
            // El correo ya está registrado, redirige a alumno_crea.php con mensaje de error y datos del formulario
            $error = "El correo electrónico ya está registrado. Por favor, use uno diferente.";
            $redirect_url = "admin_index.php?error=" . urlencode($error)
                . "&nombre=" . urlencode($nombre)
                . "&correo=" . urlencode($correo);
            header("Location: " . $redirect_url);
            exit();
        } else {
            // Inserta datos en la base de datos
            $sql = "INSERT INTO usuarios (nombre, correo, password, id_permisos ) 
                    VALUES (:nombre, :correo, :password, :id_permisos)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre); 
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':id_permisos', $id_permisos);

            if ($stmt->execute()) {
                // Redirige a alumno_index.php con mensaje de éxito
                header("Location: admin_index.php?mensaje=" . urlencode("Administrador ingresado con éxito."));
                exit();
            } else {
                $error = "Error al ingresar Administrador.";
            }            
        }
    } catch (PDOException $e) {
        $error = "Error en la base de datos: " . $e->getMessage();
        // Redirige a alumno_crea.php con el error y datos del formulario
        $redirect_url = "admin_index.php?error=" . urlencode($error)
            . "&nombre=" . urlencode($nombre)
            . "&apellido=" . urlencode($apellido)
            . "&correo=" . urlencode($correo);
        header("Location: " . $redirect_url);
        exit();
    }
}
?>
<!-- ------------------------------ -->
<?php require 'navbar.php'; ?>
    <section class="content mt-3">
        <div class="row m-auto">
            <div class="col-sm">
                    <!-- -------------------- -->
                        <div class="row">
                            <div class="col">                                
                            <div class="card rounded-2 border-0">
                            <h5 class="card-header bg-dark text-white">Lista de Administradores</h5>                                
                                <div class="card-body bg-light">
                                <form id="inscripcionForm" action="" method="post">
                            <table id="" class="table table-striped table-sm" style="width:100%">
                                <thead class="thead-dark">
                                    <th>#</th>
                                    <th>Nombres</th> 
                                    <th>E-mail</th>                                    
                                    <th>Acciones</th>               
                                </thead>
                                <tbody>
                                    <?php                                    
                                    try {
                                        $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
                                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        $query = "SELECT * FROM usuarios WHERE id_permisos = 1 ";
                                        $stmt = $db->prepare($query);
                                        $stmt->execute();
                                        $usuarioss = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($usuarioss as $usuarios) {
                                    ?>
                                            <tr>
                                                <th scope="row"><?php echo $usuarios['id'] ?></th>
                                                <td><?php echo $usuarios['nombre'] ?></td>
                                                <td><?php echo $usuarios['correo'] ?></td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        
                                                        <a href="javascript:eliminar4(<?php echo $usuarios['id'];?>)" class="btn btn-danger btn-sm" type="button" title="Borrar">                                                            
                                                            <i class="fas fa-trash"></i>
                                                        </a> 
                                                    </div>  
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } catch (PDOException $e) {
                                        echo "Error de conexión: " . $e->getMessage();
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </form>
                                </div>
                            </div>
                            
                        </div>
                            <div class="col">
                            <div class="card rounded-2 border-0">
                                <h5 class="card-header bg-dark text-white">Inscripción de Administrador</h5>
                                <div class="card-body bg-light">
                                    <?php
                                    // Recupera el mensaje de error y los datos del formulario desde la URL
                                    $error = isset($_GET["error"]) ? $_GET["error"] : "";
                                    $nombre = isset($_GET["nombre"]) ? $_GET["nombre"] : "";
                                    $correo = isset($_GET["correo"]) ? $_GET["correo"] : "";
                                    ?>
                                    <form id="formulario" action="" method="post" enctype="multipart/form-data">
                                        <!-- --------------------------------- -->                
                                                <div class="form-group">
                                                    <label for="nombre">Nombre:</label>
                                                    <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" autocomplete="off" placeholder="Ingrese Nombre(s)" required>
                                                </div>
                                            
                                        <!-- --------------------------------- -->                
                                                <div class="form-group">
                                                    <label for="correo">correo:</label>
                                                    <input id="correo" class="form-control" name="correo" placeholder="Ingrese correo" autocomplete="off" value="<?php echo htmlspecialchars($correo); ?> " required>
                                                    <span id="correoOK"></span>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label for="password">password:</label>
                                                    <div class="input-group">
                                                        <input class="form-control bg-light d-inline-block" type="password" placeholder="password" name="password" id="password" autocomplete="off" required />
                                                        <button type="button" class="btn btn-outline-primary" name="toggle-eye" id="toggle-eye" onclick="togglePasswordVisibility()">
                                                            <i class="fas fa-eye p-1"></i>
                                                        </button>
                                                    </div>
                                                </div>                    
                                        <!-- --------------------------------- -->
                                        <!-- Agregamos un botón para guardar con un evento JavaScript -->
                                        <button type="button" class="btn btn-primary float-right " id="guardarBtn" onclick="validarFormulario()">Guardar</button>
                                        <!-- Agregamos un div para mostrar un mensaje de confirmación -->
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
                        <br>
                        <br><br>
                    </div>                
        </div>
    </section>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- <script src="js/ocultarMensaje.js"></script>     -->
<script src="../../js/contraseña.js"></script>
<script src="../../js/validacion.js"></script>
<script src="../../js/validacion2.js"></script>
<?php require 'footer.php'; ?>   