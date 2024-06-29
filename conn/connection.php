<!-- base datos cami -->
<?php
// Variables de conexión a la base de datos
$db_host = 'localhost'; // Host de la base de datos
$db_name = 'abm_escuela'; // Nombre de la base de datos
$db_user = 'root'; // Usuario de la base de datos
$db_password = ''; // Contraseña de la base de datos

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
$conexion = new mysqli($db_host, $db_user, $db_password, $db_name);
?>

