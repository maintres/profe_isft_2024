<?php
require '../../conn/connection.php';
//-------------BORRADO------------------ 

?>
<!-- ------------------------------------------ -->

<!-- ------------------------------ -->
<?php require 'navbar.php'; ?>  
<br>    
                        </div>
                            <div class="col">
                            <div class="card rounded-2 border-0">
                                <h5 class="card-header bg-dark text-white">Agregar Profesor</h5>
                                <div class="card-body bg-light">
                                  
                                    <form action="procesar_profe.php" method="post" enctype="multipart/form-data">
                                        <!-- --------------------------------- -->                
                                                <div class="form-group">
                                                    <label for="nombre">Nombre y apellido:</label>
                                                    <input type="text" class="form-control" id="nombreyapellido" name="nombreyapellido" placeholder="Ingrese nombre y apellido"  required>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label for="nombre">DNI:</label>
                                                    <input type="number" class="form-control" id="dni" name="dni" placeholder="Ingrese DNI"  required>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label for="nombre">Domicilio:</label>
                                                    <input type="text" class="form-control" id="domicilio" name="domicilio" placeholder="Ingrese Domicilio"  required>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label for="nombre">Telefono:</label>
                                                    <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ingrese Telefono"  required>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label for="nombre">Email:</label>
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese Email"  required>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label for="nombre">Foto:</label>
                                                    <input type="file" class="form-control" id="foto" name="foto"   required>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label for="nombre">CV:</label>
                                                    <input type="file" class="form-control" id="cv" name="cv"  required>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label for="nombre">Fecha de ingreso:</label>
                                                    <input type="date" class="form-control" id="fechadeingreso" name="fechadeingreso"  required>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label for="nombre">Fecha de Baja:</label>
                                                    <input type="date" class="form-control" id="fechadebaja" name="fechadebaja"  >
                                                </div>
                                       
                                        <!-- --------------------------------- -->
                                        <!-- Agregamos un botón para guardar con un evento JavaScript -->
                                        <button type="submit" class="btn btn-primary btn-block">Guardar</button>
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
                        <br>
                        <br><br>
                    </div>                
        </div>
    </section>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- <script src="js/ocultarMensaje.js"></script>     -->
<script src="../../js/contraseña.js"></script>
<script src="../../js/validacion.js"></script>
<script src="../../js/validacion2.js"></script>
<?php require 'footer.php'; ?>   