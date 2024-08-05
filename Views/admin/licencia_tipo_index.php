<?php
require '../../conn/connection.php';
//-------------BORRADO------------------ 
if(isset($_GET['txtID'])){
  $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
  $sentencia=$db->prepare("UPDATE tipos_licencias SET etapa = 'Inactivo' WHERE id = :id" );
  $sentencia->bindParam(':id',$txtID);
  $sentencia->execute();
  $mensaje="Registro Licencia Eliminado";
  header("Location:licencia_tipo_index.php?mensaje=".$mensaje);
}
?>
<!-- ------------------------------------------ -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipodelicencia = $_POST["tipodelicencia"];
    $descripcion = $_POST["descripcion"];
    $error = "";
    $etapa = "Activo";
    try {         
            $sql = "INSERT INTO tipos_licencias (tipodelicencia, descripcion,etapa) 
                    VALUES (:tipodelicencia, :descripcion, :etapa)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':tipodelicencia', $tipodelicencia); 
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':etapa', $etapa);
            if ($stmt->execute()) {
                // Redirige a alumno_index.php con mensaje de éxito
                header("Location: licencia_tipo_index.php?mensaje=" . urlencode("Tipo de Licencia ingresado con éxito."));
                exit();
            } else {
                $error = "Error al ingresar Licencia.";
            }                    
    } catch (PDOException $e) {
        $error = "Error en la base de datos: " . $e->getMessage();
        // Redirige a alumno_crea.php con el error y datos del formulario
        $redirect_url = "licencia_tipo_index.php?error=" . urlencode($error)
            . "&tipodelicencia=" . urlencode($tipodelicencia)
            . "&apellido=" . urlencode($apellido)
            . "&descripcion=" . urlencode($descripcion);
        header("Location: " . $redirect_url);
        exit();
    }
}
?>
<!-- ------------------------------ -->
<?php require 'navbar.php'; ?>
<!-- ----------------------- -->
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="row">
                <div class="col">                                
                    <div class="card rounded-2 border-0">
                        <h5 class="card-header bg-dark text-white">Lista de Administradores</h5>                                
                        <div class="card-body bg-light">
                            <form id="inscripcionForm" action="" method="post">
                                <table id="" class="table table-striped table-sm" style="width:100%">
                                    <thead class="thead-dark">
                                        <th>#</th>
                                        <th>tipodelicencias</th> 
                                        <th>Descripcion</th>
                                        <th>Acciones</th>   
                                    </thead>
                                    <tbody>
                                        <?php                                    
                                        try {
                                            $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
                                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            $query = "SELECT * FROM tipos_licencias WHERE etapa = 'Activo' ";
                                            $stmt = $db->prepare($query);
                                            $stmt->execute();
                                            $usuarioss = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($usuarioss as $usuarios) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $usuarios['id'] ?></th>
                                            <td><?php echo $usuarios['tipodelicencia'] ?></td>
                                            <td><?php echo $usuarios['descripcion'] ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:elimina_licencia(<?php echo $usuarios['id'];?>)" class="btn btn-danger btn-sm" type="button" title="Borrar">                                                            
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
                <!-- ------------------------------ -->
                <div class="col">
                    <div class="card rounded-2 border-0">
                        <h5 class="card-header bg-dark text-white">Agregar Tipo de Licencia</h5>
                        <div class="card-body bg-light">
                            <?php
                            // Recupera el mensaje de error y los datos del formulario desde la URL
                            $error = isset($_GET["error"]) ? $_GET["error"] : "";
                            $tipodelicencia = isset($_GET["tipodelicencia"]) ? $_GET["tipodelicencia"] : "";
                            $descripcion = isset($_GET["descripcion"]) ? $_GET["descripcion"] : "";
                            ?>
                            <form id="formulario" action="" method="post" enctype="multipart/form-data">
                                <!-- --------------------------------- -->                
                                        <div class="form-group">
                                            <label for="tipodelicencia">Nombre</label>
                                            <input type="text" class="form-control" name="tipodelicencia" value="" autocomplete="off" placeholder="Ingrese tipodelicencia" required>
                                        </div>                                            
                                <!-- --------------------------------- -->                
                                        <div class="form-group">
                                            <label for="descripcion">Descripcion:</label>
                                            <input id="descripcion" class="form-control" name="descripcion" placeholder="Ingrese Descripcion" autocomplete="off" value="" >
                                            
                                        </div>                                                        
                                <!-- --------------------------------- -->
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
        </div>                
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- <script src="js/ocultarMensaje.js"></script>     -->
<script src="../../js/contraseña.js"></script>
<script src="../../js/validacion.js"></script>
<script src="../../js/validacion2.js"></script>
<?php require 'footer.php'; ?>   