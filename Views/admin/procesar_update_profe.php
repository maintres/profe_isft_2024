<?php
require '../../conn/connection.php';

// Recibe los datos enviados por el formulario
$id = $_POST['id'];
$nombreyapellido = $_POST['nombreyapellido'];
$dni = $_POST['dni'];
$domicilio = $_POST['domicilio'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$fechadeingreso = $_POST['fechadeingreso'];
$fechadebaja = $_POST['fechadebaja'];

// Manejo del archivo de foto
$foto = $_FILES['foto']['name'];
$cv = $_FILES['cv']['name'];

$updateQuery = "UPDATE profesores SET 
    nombreyapellido = :nombreyapellido, 
    dni = :dni, 
    domicilio = :domicilio, 
    telefono = :telefono, 
    email = :email, 
    fechadeingreso = :fechadeingreso, 
    fechadebaja = :fechadebaja";

if ($foto) {
    $updateQuery .= ", foto = :foto";
    $target_dir_foto = "../../profesores/uploads/";
    $target_file_foto = $target_dir_foto . basename($foto);
    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file_foto);
}

if ($cv) {
    $updateQuery .= ", cv = :cv";
    $target_dir_cv = "../../profesores/cv/";
    $target_file_cv = $target_dir_cv . basename($cv);
    move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file_cv);
}

$updateQuery .= " WHERE id = :id";

try {
    $stmt = $db->prepare($updateQuery);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombreyapellido', $nombreyapellido);
    $stmt->bindParam(':dni', $dni);
    $stmt->bindParam(':domicilio', $domicilio);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':fechadeingreso', $fechadeingreso);
    $stmt->bindParam(':fechadebaja', $fechadebaja);

    if ($foto) {
        $stmt->bindParam(':foto', $foto);
    }

    if ($cv) {
        $stmt->bindParam(':cv', $cv);
    }

    if ($stmt->execute()) {
        $mensaje = "Profesor actualizado exitosamente";
        header("Location: list_profe.php?mensaje=" . urlencode($mensaje));
        exit;
    } else {
        echo "Error: No se pudo actualizar el profesor.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>