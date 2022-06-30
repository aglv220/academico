<style>
    .login-form-bg{
        margin-top: 15%;
    }
</style>
<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-12">                        
                        <form id="FRM_REGISTRO_2" class="step-form-horizontal">
                            <div>
                                <h4>Datos personales</h4>
                                <?php //if(isset($correo_registrado)){ echo $correo_registrado; }?>
                                <section>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>1. Nombres</label>                                                
                                                <input type="text" name="u_nombres" class="form-control" placeholder="Ingrese su nombre" onkeypress="return solo_texto(event);" required>                                                
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>2. Apellidos</label>
                                                <input type="text" name="u_apellidos" class="form-control" placeholder="Ingrese sus apellidos" onkeypress="return solo_texto(event);" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>3. Número de celular</label>
                                                <input type="phone" class="form-control" id="u_celular" minlength="9" maxlength="9" name="u_celular" placeholder="999-999-999" onkeypress="return numeros_enteros(event);" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>4. Fecha de nacimiento (día / mes / año)</label>
                                                <input type="date" name="u_fecnac" class="form-control" required>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </section>
                                <h4>Datos Inst.</h4>
                                <section>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>5. Código de estudiante</label>
                                                <input type="text" name="u_codigo" class="form-control" placeholder="Ingrese su código de estudiante" onkeypress="return numeros_enteros(event);" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>6. Carrera universitaria</label>
                                                <select class="form-control" id="u_carrera" name="u_carrera" required>
                                                    <option value="">Seleccione su carrera</option>
                                                    <?php if(isset($LST_CARRERAS)){echo $LST_CARRERAS;} ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>7. Ciclo relativo</label>
                                                <input type="number" name="u_ciclo" class="form-control" placeholder="Ingrese su ciclo relativo" min="1" max="10" required>
                                            </div>
                                        </div>
                                        <input type="hidden" name="u_user" value="<?php if(isset($ID_USUARIO)){echo $ID_USUARIO;} ?>" />
                                    </div>
                                </section>
                                <h4>Confirmación</h4>
                                <section>
                                    <div class="row h-100">
                                        <div class="col-12 h-100 d-flex flex-column justify-content-center align-items-center">
                                            <h2>¡Has llenado el formulario correctamente!</h2>
                                            <p>Para <b>CONFIRMAR</b> el envío de tus datos da clic en el botón <b>Guardar</b>.</p>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
</body>
</html>