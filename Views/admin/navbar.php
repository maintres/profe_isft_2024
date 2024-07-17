<?php session_start();
if(!isset($_SESSION['nombre'])){
  header("Location:../home.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instituto Superior de Formación Técnica Angaco</title>
  <link rel="shortcut icon" href="../../img/LOGO3.ico" type="image/x-icon" />
  <!--font awesome con CDN para iconos-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <!-- -----------ARCHIVO CSS----------- -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- ---------FIN ARCHIVO CSS----------- -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- ------------DATATABLES----- -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
  <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script defer src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script defer src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.bootstrap5.min.css" />
  <!-- Bootstrap-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" />
  <!--Script de Bootstrap-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- JQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- DataTable -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.print.min.js"></script>
  <!-- Bootstrap-->
  <script defer src="../../js/tabla.js"></script>
  <!-- ------------FIN-DATATABLES----- -->
  <!-- -------------sweetalert2(alertas emergentes)------------------   -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../../js/alertas.js"></script>
  <!-- ------------------------------ -->
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Roboto&display=swap');
  </style>
  <!-- ----------------------------- -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- ------------------------------- -->
</head>
<style>
  body {
    background: linear-gradient(135deg,#0085b7, #192a68);
  }
</style>
<body>
<!-- ---------------MENSAJE REGISTROS-------------- -->
<?php
  $mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
  $error = isset($_GET['error']) ? $_GET['error'] : '';
  ?>
  <!-- Muestra la alerta para mensajes de éxito -->
  <?php if (!empty($mensaje)) { ?>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
          icon: "success",
          title: "<?php echo $mensaje; ?>",
          showConfirmButton: false,
          timer: 1700
        }).then(() => {
          // Eliminar parámetro de la URL
          const url = new URL(window.location);
          url.searchParams.delete('mensaje');
          window.history.replaceState(null, null, url);
        });
      });
    </script>
  <?php } ?>

  <!-- Muestra la alerta para errores -->
  <?php if (!empty($error)) { ?>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "<?php echo $error; ?>",
          showConfirmButton: true,
          confirmButtonText: "OK",
          confirmButtonColor: "#d33"
        }).then(() => {
          // Eliminar parámetro de la URL
          const url = new URL(window.location);
          url.searchParams.delete('error');
          window.history.replaceState(null, null, url);
        });
      });
    </script>
  <?php } ?>
  <!-- ------------------------------------- -->
  <div style="height:60px">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container-fluid ml-2 ">
        <a href="index.php" class="navbar-brand mb-0 pr-3 ">
          <img class="d-line-block align-top " src="../../img/LOGO3.png" width="100px" style="margin-right:10px">
        </a>
        <!-- Toggle Btn-->
        <button type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" class="navbar-toggler shadow-none border-0 bg-dark" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- ------------------------------------------------------- -->
        <div class="collapse navbar-collapse d-flex" id="navbarNav">
          <ul class="navbar-nav mr-auto flex-grow-1 bd-highlight">

            <div class="collapse navbar-collapse " id="navbarNav">
              <ul class="navbar-nav mr-auto ">
            <!-- ------------------------------------------------------- -->
            <li class="nav-item dropdown pr-3">
              <a class="nav-link dropdown-toggle  " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Profesor
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="agregar_profe.php">Agregar Profesor</a></li>
                <li><a class="dropdown-item" href="list_profe.php">Listado de Profesores</a></li>
                <li><a class="dropdown-item" href="asigna_index.php">Listado de Asignaciones</a></li>
              </ul>
            </li>
              <!-- ------------------------------------------------------- -->
            <li class="nav-item  pr-3">
              <a class="nav-link " href="materia_index.php">Asignatura </a>
            </li>
            <!-- ------------------------------------------------------- -->
            <li class="nav-item  pr-3">
              <a class="nav-link " href="carrera_index.php">Carreras</a>
            </li>
             <!-- ------------------------------------------------------- -->
             <li class="nav-item  pr-3">
              <a class="nav-link " href="list_asist.php">Asistencia</a>
            </li>
            <!-- ------------------------------------------------------- -->
          </ul>     
          <!-- ------------------------------------------------------- -->
          <form class="form-inline d-flex justify-content-end">
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- iconos sacados de "fontawesome" -->
                    <i class="fas fa-user pr-2"></i>
                    Administrador:
                    <?php if (isset($_SESSION['nombre']) ) : ?>                    
                    <?php echo $_SESSION['nombre'] ; ?>
                    <?php endif; ?>
                    </a>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <!-- <li><a class="dropdown-item" href="#"> <i class="fas fa-user-alt pe-2"></i>My Profile</a></li> -->
                <li><a class="dropdown-item" href="#"> <i class="fas fa-cog pe-2"></i>Configuración</a></li>
                <li><a class="dropdown-item" href="javascript:cerrar()"> <i class="fa fa-power-off pe-2"></i>Cerrar Sesión</a></li>
              </ul>
              </li>
            </div>
            </ul>
          </form>
          <!-- ------------------------------------------------------- -->
        </div>
      </div>
    </nav>
  </div>