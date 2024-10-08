function eliminar1 (id_persona){
  Swal.fire({
      icon: "error",
      title: "¿Borrar?",        
      showCancelButton: true,
      confirmButtonText: "Si",   
      confirmButtonColor: "#007bff",
      cancelButtonColor: '#dc3545',     
    }).then((result) => {  
          if (result.isConfirmed) { 
            window.location = "../admin/alumno_index.php?txtID="+id_persona;
           }          
    });
}
function eliminar2 (id_persona){
  Swal.fire({
      icon: "error",
      title: "¿Borrar?",        
      showCancelButton: true,
      confirmButtonText: "Si",   
      confirmButtonColor: "#007bff",
      cancelButtonColor: '#dc3545',     
    }).then((result) => {  
          if (result.isConfirmed) { 
            window.location = "../admin/profe_index.php?txtID="+id_persona;
           }          
    });
}
function eliminar3 (id_persona){
  Swal.fire({
      icon: "error",
      title: "¿Borrar?",        
      showCancelButton: true,
      confirmButtonText: "Si",   
      confirmButtonColor: "#007bff",
      cancelButtonColor: '#dc3545',     
    }).then((result) => {  
          if (result.isConfirmed) { 
            window.location = "../admin/materia_index.php?txtID="+id_persona;
           }          
    });
}
function eliminar4 (id_persona){
  Swal.fire({
      icon: "error",
      title: "¿Borrar?",        
      showCancelButton: true,
      confirmButtonText: "Si",   
      confirmButtonColor: "#007bff",
      cancelButtonColor: '#dc3545',     
    }).then((result) => {  
          if (result.isConfirmed) { 
            window.location = "../admin/admin_index.php?txtID="+id_persona;
           }          
    });
}
function eliminar5 (id_mesa){
  Swal.fire({
      icon: "error",
      title: "¿Borrar?",        
      showCancelButton: true,
      confirmButtonText: "Si",   
      confirmButtonColor: "#007bff",
      cancelButtonColor: '#dc3545',     
    }).then((result) => {  
          if (result.isConfirmed) { 
            window.location = "../admin/listadomesa.php?txtID="+id_mesa;
           }          
    });
}
function eliminar_carrera (id_carrera){
  Swal.fire({
      icon: "error",
      title: "¿Borrar?",        
      showCancelButton: true,
      confirmButtonText: "Si",   
      confirmButtonColor: "#007bff",
      cancelButtonColor: '#dc3545',     
    }).then((result) => {  
          if (result.isConfirmed) { 
            window.location = "../admin/carrera_index.php?txtID="+id_carrera;
           }          
    });
}

function elimina_licencia_tipo (id_licencia_tipo){
  Swal.fire({
      icon: "error",
      title: "¿Borrar?",        
      showCancelButton: true,
      confirmButtonText: "Si",   
      confirmButtonColor: "#007bff",
      cancelButtonColor: '#dc3545',     
    }).then((result) => {  
          if (result.isConfirmed) { 
            window.location = "../admin/licencia_tipo_index.php?txtID="+id_licencia_tipo;
           }          
    });
}
function elimina_licencia (id_licencia){
  Swal.fire({
      icon: "error",
      title: "¿Borrar?",        
      showCancelButton: true,
      confirmButtonText: "Si",   
      confirmButtonColor: "#007bff",
      cancelButtonColor: '#dc3545',     
    }).then((result) => {  
          if (result.isConfirmed) { 
            window.location = "../admin/licencia_index.php?txtID="+id_licencia;
           }          
    });
}





function cerrar (){
  Swal.fire({
      icon: "question",
      iconColor: 'red',
      title: "¿Desea Salir?",        
      showDenyButton: true,
      confirmButtonText: "Si",
      confirmButtonColor: "#007bff", 
      denyButtonText: "No",
      customClass: {
        confirmButton: 'px-5 ',
        denyButton: 'px-5 ',
      }
    }).then((result) => {        
      if (result.isConfirmed) {
        window.location="../logout.php";
      } 
    });    
}
