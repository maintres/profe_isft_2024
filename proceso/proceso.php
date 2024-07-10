<?php
include('../conn/connection.php');

$NombreCarrera = $_POST['Ncarrera'];
$AbrebiaturaCarrera = $_POST['Abrev'];

// Sentencia preparada: INSERT INTO carreras (nombre, descripcion) VALUES (?, ?)
$consultaSQL = "INSERT INTO carreras (nombre, descripcion) VALUES (?, ?)";

// Preparación de la sentencia
if (!($sentenciaPreparada = mysqli_prepare($conexion,$consultaSQL))) {
    echo "Falló la preparación: (" . $conexion->errno . ") " . $conexion->error;
} else {
    // Vinculación de parámetros
    $sentenciaPreparada->bind_param("ss", $NombreCarrera, $AbrebiaturaCarrera);

    // Ejecución de la sentencia
    if ($sentenciaPreparada->execute()) {
        echo "Los datos se han guardado correctamente";
        // Redirige al usuario a la página de inicio después de guardar los datos
        header('Location: ../Views/admin/carrera_index.php');
    } else {
        echo "Se ha producido un error: " . $sentenciaPreparada->error;
    }

    // Cierra la sentencia
    $sentenciaPreparada->close();
}

// Cierra la conexión a la base de datos
$conexion->close();
