<?php
include '../../conn/connection.php';

// Recibe los datos enviados por el formulario
$nombreyapellido = $_POST['nombreyapellido'];
$dni = $_POST['dni'];
$domicilio = $_POST['domicilio'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$fechadeingreso = $_POST['fechadeingreso'];
$fechadebaja = $_POST['fechadebaja'];

// Manejo del archivo de foto
$foto = $_FILES['foto']['name'];
$target_dir_foto = "../../profesores/uploads/";
$target_file_foto = $target_dir_foto . basename($foto);

// Manejo del archivo de CV
$cv = $_FILES['cv']['name'];
$target_dir_cv = "../../profesores/cv/";
$target_file_cv = $target_dir_cv . basename($cv);

// Crear las carpetas si no existen
if (!is_dir($target_dir_foto)) {
    mkdir($target_dir_foto, 0777, true);
}
if (!is_dir($target_dir_cv)) {
    mkdir($target_dir_cv, 0777, true);
}

try {
    // Verificar si el DNI ya existe en la base de datos
    $sql_check_dni = "SELECT * FROM profesores WHERE dni=:dni";
    $stmt = $db->prepare($sql_check_dni);
    $stmt->bindParam(':dni', $dni);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Error: Ya existe un profesor con el mismo DNI.";
        echo "<br> <a href='agregar_profe.php' class='btn btn-warning'>Volver</a>";
    } else {
        // Mover los archivos subidos a las carpetas correspondientes
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file_foto);
        move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file_cv);

        // Insertar los datos en la tabla profesores
        $sql_insert = "INSERT INTO profesores (nombreyapellido, dni, domicilio, telefono, email, foto, cv, fechadeingreso, fechadebaja) 
                VALUES (:nombreyapellido, :dni, :domicilio, :telefono, :email, :foto, :cv, :fechadeingreso, :fechadebaja)";
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

        if ($stmt->execute()) {
            echo "Nuevo profesor agregado exitosamente";
            echo "<br><a href='agregar_profe.php' class='btn btn-warning'>Volver</a>";
        } else {
            echo "Error: No se pudo agregar el profesor.";
            echo "<br><a href='agregar_profe.php' class='btn btn-warning'>Volver</a>";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cierra la conexión a la base de datos
$conexion->close();
?>