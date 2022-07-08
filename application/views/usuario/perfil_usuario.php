<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-4 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>
                            <div class="media-body">
                                <h4 class="mb-0 ml-4"><?= $info_usuario->alumno_nombre . " " . $info_usuario->alumno_apellidos ?></h4>
                            </div>
                        </div>
                        <ul class="card-profile__info">
                            <li class="mb-1"><strong class="text-left text-dark mr-4">Código</strong> <span><?= $info_usuario->alumno_codigo ?></span></li>
                            <li class="mb-1"><strong class="text-left text-dark mr-4">Celular</strong> <span><?= $info_usuario->alumno_celular ?></span></li>
                            <li><strong class="text-left text-dark mr-4">Correo</strong> <span><?= $info_usuario->usuario_correo ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <form id="FRM_RECOVER_PASS" class="form-profile" action="<?php echo base_url(); ?>UsuarioControlador/actualizar_perfil_personal" method="POST">
                            <div class="row">
                                <div class="col-lg-6 col-xs-12 mt-2">
                                    <h4 class="card-title">Datos personales</h4>
                                    <div class="basic-form">
                                        <div class="form-group">
                                            <label>Nombre</label>
                                            <input type="text" name="usuario_nombre" class="form-control input-flat" placeholder="Ingresa tu nombre" value="<?= $info_usuario->alumno_nombre ?>" onkeypress="return solo_texto(event);" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Apellidos</label>
                                            <input type="text" name="usuario_apellidos" class="form-control input-flat" placeholder="Ingresa tus apellidos" value="<?= $info_usuario->alumno_apellidos ?>" onkeypress="return solo_texto(event);" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Celular</label>
                                            <input type="phone" name="usuario_celular" class="form-control input-flat" placeholder="Ingresa tu número de celular" value="<?= $info_usuario->alumno_celular ?>" minlength="9" maxlength="9" onkeypress="return numeros_enteros(event);" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Fecha de nacimiento</label>
                                            <input type="date" name="usuario_fecnac" class="form-control input-flat" placeholder="Ingresa tu fecha de nacimiento" value="<?= $info_usuario->alumno_fecnac ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-xs-12 mt-2">
                                    <h4 class="card-title">Datos académicos</h4>
                                    <div class="basic-form">
                                        <div class="form-group">
                                            <label>Carrera</label>
                                            <select class="form-control input-flat" name="usuario_carrera" required>
                                                <option value="">Seleccione su carrera</option>
                                                <?php if (isset($lst_carreras)) {
                                                    echo $lst_carreras;
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Ciclo</label>
                                            <input type="number" name="usuario_ciclo" class="form-control input-flat" placeholder="Ingresa tu nro. de ciclo actual" value="<?= $info_usuario->alumno_ciclo ?>" min="1" max="10" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-xs-12 mt-2">
                                    <h4 class="card-title">Actualizar contraseña</h4>
                                    <div class="basic-form">
                                        <div class="form-group">
                                            <label>Nueva contraseña</label>
                                            <input type="password" name="usuario_newpass" class="form-control input-flat" placeholder="Ingrese su nueva contraseña si desea actualizarla" minlength="8">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-block mb-1 btn-success">Actualizar datos<span class="btn-icon-right"><i class="fa fa-check"></i></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>
</div>

<!--**********************************
            Content body end
        ***********************************-->
</body>

</html>