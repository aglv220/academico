<!DOCTYPE html>
<html class="h-100" lang="en">
<style>
    @mixin modal-fullscreen() {
        padding: 0 !important; // override inline padding-right added from js

        .modal-dialog {
            width: 100%;
            max-width: none;
            height: 100%;
            margin: 0;
        }

        .modal-content {
            height: 100%;
            border: 0;
            border-radius: 0;
        }

        .modal-body {
            overflow-y: auto;
        }

    }

    @each $breakpoint in map-keys($grid-breakpoints) {
        @include media-breakpoint-down($breakpoint) {
            $infix: breakpoint-infix($breakpoint, $grid-breakpoints);

            .modal-fullscreen#{$infix} {
                @include modal-fullscreen();
            }

        }
    }
</style>

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
                                <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                </svg>
                                <h2 style="text-align: center;">Registro</h2>
                                <span>Ingresa tu correo institucional y tu contraseña de Canvas</span> <br>
                                <span>para ser registrado.</span>
                                <form id="FRM_REGISTRO" class="mt-5 mb-5 login-input" method="POST">
                                    <div class="form-group">
                                        <input type="email" name="usuario_correo" class="form-control" placeholder="Correo institucional" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="usuario_clave" class="form-control" placeholder="Contraseña" minlength="8" required>
                                    </div>
                                </form>
                                <button class="btn login-form__btn submit w-100 " onclick="registrar()">Validar y registrar</button>

                                <a href="<?= base_url() ?>inicio-sesion" class="btn mt-3 btn-cancel-register btn-danger w-100 ">Cancelar operación</a>

                                <p class="mt-5 login-form__footer"><a href="#" class="text-primary">Ver terminos y condiciones</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</body>

</html>