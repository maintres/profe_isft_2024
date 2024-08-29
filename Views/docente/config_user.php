<?php
require 'navbar.php';
include('../../conn/connection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id_usuario = $_SESSION['id_usuario'];


function verificarContrasenaActual($db, $id_usuario, $contrasena_actual)
{
    $stmt = $db->prepare("SELECT password FROM usuarios WHERE id_usuario = ?");
    $stmt->execute([$id_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    return $contrasena_actual === $usuario['password'];
}


function mostrarMensaje($tipo, $titulo, $texto)
{
    echo '<script>
        Swal.fire({
            icon: "' . $tipo . '",
            title: "' . $titulo . '",
            text: "' . $texto . '"
        });
    </script>';
}


function procesarFormulario($db, $id_usuario)
{
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $contrasena_actual = $_POST['current_password'];
    $nueva_contrasena = $_POST['new_password'];
    $confirmar_contrasena = $_POST['confirm_password'];

    $stmt = $db->prepare("SELECT correo, celular, direccion, password FROM usuarios WHERE id_usuario = ?");
    $stmt->execute([$id_usuario]);
    $usuario_actual = $stmt->fetch(PDO::FETCH_ASSOC);

  
    $campos = [];
    $valores = [];

   
    if ($correo !== $usuario_actual['correo']) {
        $campos[] = 'correo = ?';
        $valores[] = $correo;
    }
    if ($celular !== $usuario_actual['celular']) {
        $campos[] = 'celular = ?';
        $valores[] = $celular;
    }
    if ($direccion !== $usuario_actual['direccion']) {
        $campos[] = 'direccion = ?';
        $valores[] = $direccion;
    }


    if (!empty($nueva_contrasena)) {
        if (!verificarContrasenaActual($db, $id_usuario, $contrasena_actual)) {
            mostrarMensaje('error', 'Error', 'La contraseña actual es incorrecta.');
            return;
        }

        if (strlen($nueva_contrasena) < 6) {
            mostrarMensaje('warning', 'Advertencia', 'La nueva contraseña debe tener al menos 6 caracteres.');
            return;
        }

        if ($nueva_contrasena !== $confirmar_contrasena) {
            mostrarMensaje('error', 'Error', 'Las contraseñas nuevas no coinciden.');
            return;
        }

        $campos[] = 'password = ?';
        $valores[] = $nueva_contrasena;
    }

    
    if (!empty($campos)) {
        $valores[] = $id_usuario;
        $sql = "UPDATE usuarios SET " . implode(', ', $campos) . " WHERE id_usuario = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute($valores);
        mostrarMensaje('success', 'Éxito', 'Datos actualizados correctamente.');
    } else {
        mostrarMensaje('info', 'Info', 'No se realizaron cambios.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    procesarFormulario($db, $id_usuario);
}

$stmt = $db->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<body>
    <div class="container mt-4 w-50">
        <div class="card">
            <div class="card-header">
                <h3>Configuración de Usuario</h3>
            </div>
            <div class="card-body">
                <form method="post" action="">
                  
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingPersonal">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePersonal" aria-expanded="true" aria-controls="collapsePersonal">
                                    Datos Personales
                                </button>
                            </h2>
                            <div id="collapsePersonal" class="accordion-collapse collapse show" aria-labelledby="headingPersonal" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" value="<?= $usuario['nombre']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido">Apellido</label>
                                        <input type="text" class="form-control" id="apellido" value="<?= $usuario['apellido']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="dni">DNI</label>
                                        <input type="text" class="form-control" id="dni" value="<?= $usuario['dni']; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                     
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingContacto">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContacto" aria-expanded="false" aria-controls="collapseContacto">
                                    Datos de Contacto
                                </button>
                            </h2>
                            <div id="collapseContacto" class="accordion-collapse collapse" aria-labelledby="headingContacto" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="form-group">
                                        <label for="correo">Correo</label>
                                        <input type="email" class="form-control" id="correo" name="correo" value="<?= $usuario['correo']; ?>" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="celular">Celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular" value="<?= $usuario['celular']; ?>" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="direccion">Dirección</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?= $usuario['direccion']; ?>" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                    
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingCuenta">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCuenta" aria-expanded="false" aria-controls="collapseCuenta">
                                    Datos de Cuenta
                                </button>
                            </h2>
                            <div id="collapseCuenta" class="accordion-collapse collapse" aria-labelledby="headingCuenta" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="form-group">
                                        <label for="current_password">Contraseña Actual</label>
                                        <input type="password" class="form-control" id="current_password" name="current_password">
                                    </div>
                                    <div class="form-group position-relative">
                                        <label for="new_password">Nueva Contraseña</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" oninput="validatePasswordLength()">
                                        <button type="button" class="btn btn-secondary position-absolute top-50 end-0 translate-middle-y" onclick="togglePasswordVisibility('new_password', this)">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <div id="passwordHelp" class="form-text text-danger" style="display: none;">
                                            La contraseña debe tener al menos 6 caracteres.
                                        </div>
                                    </div>

                                    <div class="form-group position-relative">
                                        <label for="confirm_password">Confirmar Nueva Contraseña</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                        <button type="button" class="btn btn-secondary position-absolute top-50 end-0 translate-middle-y" onclick="togglePasswordVisibility('confirm_password', this)">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const type = input.type === "password" ? "text" : "password";
            input.type = type;
            button.querySelector('i').classList.toggle('bi-eye');
            button.querySelector('i').classList.toggle('bi-eye-slash');
        }

        function validatePasswordLength() {
            const newPassword = document.getElementById('new_password');
            const passwordHelp = document.getElementById('passwordHelp');
            if (newPassword.value.length < 6) {
                passwordHelp.style.display = 'block';
            } else {
                passwordHelp.style.display = 'none';
            }
        }
    </script>
</body>
<?php require 'footer.php'; ?> 