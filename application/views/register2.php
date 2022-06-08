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
                        <form action="#" id="step-form-horizontal" class="step-form-horizontal">
                            <div>
                                <h4>Datos personales</h4>
                                <section>
                                <h1 style="text-align: center; margin-bottom: 30px;">Cuéntanos más sobre ti</h1>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" name="u_nombres" class="form-control" placeholder="Ingrese su nombre" >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" name="u_apellidos" class="form-control" placeholder="Ingrese sus apellidos" >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                            <input type="text" class="form-control" id="u_celular" name="u_celular" placeholder="999-999-999" >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="date" name="u_fecnac" class="form-control"  >
                                            </div>
                                        </div>
                                        
                                    </div>
                                </section>
                                <h4>Datos institu.</h4>
                                <section>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" name="u_codigo" class="form-control" placeholder="Ingrese su código de estudiante" >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                            <select class="form-control" id="u_carrera" name="u_carrera">
                                                    <option value="">Seleccione su carrera</option>
                                                    <option value="html">HTML</option>
                                                    <option value="css">CSS</option>
                                                    <option value="javascript">JavaScript</option>
                                                    <option value="angular">Angular</option>
                                                    <option value="angular">React</option>
                                                    <option value="vuejs">Vue.js</option>
                                                    <option value="ruby">Ruby</option>
                                                    <option value="php">PHP</option>
                                                    <option value="asp">ASP.NET</option>
                                                    <option value="python">Python</option>
                                                    <option value="mysql">MySQL</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <input type="text" name="u_ciclo" class="form-control" placeholder="Ingrese su ciclo relativo" >
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h4>Confirmación</h4>
                                <section>
                                    <div class="row h-100">
                                        <div class="col-12 h-100 d-flex flex-column justify-content-center align-items-center">
                                            <h2>¡Has enviado el formulario con éxito!</h2>
                                            <p>Muchas gracias por tu información.</p>
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