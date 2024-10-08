<?php
require '../conn/connection.php';
session_start();
if($_POST){
    $messages = [
        "1" => "Credenciales incorrectas",
        "2" => "No ha iniciado sesión",
        "3" => "No tienes permisos"
    ];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dni = $_POST['dni'];
        $contrasena = $_POST['password']; // Cambiado para coincidir con el nuevo nombre del campo

        if (!empty($dni) && !empty($contrasena)) {
            $sql = "SELECT * FROM usuarios WHERE dni = :dni AND password = :contrasena";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
            $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['id_usuario'] = $usuario['id_usuario']; // Cambiado para coincidir con el nuevo nombre del campo
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['apellido'] = $usuario['apellido'];
                $_SESSION['id_rol'] = $usuario['id_rol']; // Guardar el rol del usuario

                // Redireccionar basado en el rol del usuario
                if ($usuario['id_rol'] == 1) {
                    header('Location: admin/index.php');
                    exit;
                } elseif ($usuario['id_rol'] == 2) {
                    header('Location: docente/index.php');
                    exit;
                } elseif ($usuario['id_rol'] == 3) {
                    header('Location: preceptor/index.php');
                    exit;
                } else {
                    $_SESSION['message'] = $messages[3]; // Mensaje de permisos insuficientes
                }
            } else {
                $_SESSION['message'] = $messages[1];
            }
        } else {
            $_SESSION['message'] = $messages[1];
        }
    }
    header('Location: home.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta name="description" content="Inicio de Sesión" />
    <title>Instituto Superior de Formación Técnica Angaco</title>
    <link rel="shortcut icon" href="../img/LOGO3.ico" type="image/x-icon" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Roboto&display=swap');
        body {
            background: linear-gradient(135deg, #0085b7, #192a68);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body class="container d-flex justify-content-center">
    <div class="bg-white p-4 rounded-5 text-secondary shadow my-2" style="width: 25rem">
        <div class="d-flex justify-content-center">
            <img src="../img/LOGO.ico" alt="login-icon" style="height: 10rem" class="w-100 mb-4" />
        </div>
        <div class="text-center fs-1 fw-bold">Bienvenid@</div>
        <p>Admin:4423189</p>
        <p>Prece:44232168</p>
        <p>Profe:45470152</p>
        <p>123</p>
        <form method="post" class="form" action="">
            <div class="input-group mt-4">
                <div class="input-group-text bg-info">
                    <img src="../img/username-icon.svg" alt="username-icon" style="height: 1rem" />
                </div>
                <input class="form-control bg-light" type="text" placeholder="DNI" name="dni" required autocomplete="off" inputmode="numeric" pattern="\d*"/>
            </div>
            <div class="input-group mt-2">
                <div class="input-group-text bg-info">
                    <img src="../img/padlock-svgrepo-com.svg" alt="password-icon" style="height: 1rem" />
                </div>
                <input class="form-control bg-light" type="password" placeholder="Contraseña" name="password" id="password" required autocomplete="off" />
                <!-- <button type="button" class="btn btn-outline-primary" name="toggle-eye" id="toggle-eye" onclick="togglePasswordVisibility()">
                    <i class="fas fa-eye p-1"></i>
                </button> -->
            </div>
            <button type="submit" class="btn btn-primary text-white w-100 mt-4 fs-5 fw-semibold shadow-sm">Inicio</button>
            <?php
            if (isset($_SESSION['message'])) {
                echo '<div class="error text-danger border border-danger w-100 justify-content-center text-center d-inline-block mt-2 rounded-3 p-1" id="myAlert" style="background-color: #f5c2c7">' . $_SESSION['message'] . '</div>';
                unset($_SESSION['message']);
            }
            ?>
        </form>
    </div>
</body>
</html>
