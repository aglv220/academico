<html class="h-100">
<body class="h-100">
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
    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <img src="<?= base_url() ?>assets/images/logo_utp.png" alt="">
                                <h2 style="text-align: center;">Recupera tu contraseña</h2>

                                <form id="FRM_RECOVER_PASS" class="mt-5 mb-5 login-input" action="<?php echo base_url(); ?>LoginControlador/validar_correo_usuario" method="POST">
                                    <input type="hidden" name="operation_phase" value="validate">
                                    <div class="form-group">
                                        <input type="email" class="form-control control_validate" placeholder="Ingresa tu correo institucional" name="usuario_correo" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control control_recover" placeholder="Ingresa tu código de recuperación" name="usuario_codigorecover">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control control_recover" placeholder="Ingresa tu nueva contraseña" name="usuario_password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control control_recover" placeholder="Confirma tu nueva contraseña" name="usuario_password_c">
                                    </div>
                                    <button type="submit" class="btn login-form__btn submit w-100">Enviar correo de recuperación</button>

                                    <a href="<?= base_url() ?>iniciar_sesion" class="btn mt-3 btn-cancel-register btn-danger w-100 ">Cancelar operación</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>