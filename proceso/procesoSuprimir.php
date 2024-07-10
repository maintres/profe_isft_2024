<?php
require_once('../conn/connection.php');
$msg = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta preparada para eliminar un registro de la base de datos
    $query = "DELETE FROM carreras WHERE id = ?";

    // Preparación de la consulta
    if ($sentenciaPreparada = mysqli_prepare($conexion, $query)) {
        // Vinculación de los parámetro de la consulta
        mysqli_stmt_bind_param($sentenciaPreparada, "i", $id);

        // Ejecución de la consulta preparada
        if (mysqli_stmt_execute($sentenciaPreparada)) {
            /*
            si la consulta se ejecuto correctamente, mostrara un mensaje y
            el usuario sera redirigido al menu de "opcarreras.html".
            */
            $msg = 'La eliminación del registro ha sido exitosa';
            header('Location:../Views/admin/carrera_index.php');
        } else {
            $msg = 'Ocurrió un error durante la eliminación';
        }

        // Cierre de la sentencia preparada
        mysqli_stmt_close($sentenciaPreparada);
    } else {
        # si no se ejecuta la consulta preparada, mostrara el siguiente mensaje a continuación
        $msg = 'Error al preparar la consulta';
    }
}
//cierre de la conexion a la base de datos
mysqli_close($conexion);
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <span><?php echo $msg; ?></span>
</body>

</html>