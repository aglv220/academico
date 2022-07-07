<style>
    .card-body p{
        font-weight: bold;
        font-size: 1.50rem;
        max-width: 100%;
    }
    .cartitle{
        width: 100%;
        border-bottom: 1px solid #000;
    }
    .content-actividades{
        margin-top: 20px;
    }
    .actividades{
        margin-top: 5px;
    }
    .actividades span{
        font-size: 1.10rem;
        margin-left: 5px;
    }
    .cargar-mas{
        margin-top: 10px;
    }
</style>

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
                    <div class="col">
                        <div class="card">
                            <div class="card-body">

                                <button type="button" class="test-notification btn btn-primary">Probar</button>

                                <div class="cartitle">
                                    <p>Actividades próximas</p>
                                </div>
                                <?php
                                    foreach($tareas as $val){
                                ?>
                                <div class="content-actividades">
                                    <div class="actividades">
                                        <svg style="vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-calendar-date" viewBox="0 0 16 16">
                                        <path d="M6.445 11.688V6.354h-.633A12.6 12.6 0 0 0 4.5 7.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675zm1.188-1.305c.047.64.594 1.406 1.703 1.406 1.258 0 2-1.066 2-2.871 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684zm2.953-2.317c0 .696-.559 1.18-1.184 1.18-.601 0-1.144-.383-1.144-1.2 0-.823.582-1.21 1.168-1.21.633 0 1.16.398 1.16 1.23z"/>
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                        </svg>
                                        <span><?php echo ucwords($val["nombreCurso"])?>: <?php echo $val["descpCurso"]?></span>
                                    </div>
                                </div>
                                <?php
                                    }
                                ?>
                                <div class="cargar-mas">
                                    <a href="./UsuarioControlador/calendario"><i class="icon-arrow-down"></i><span>ver más</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="cartitle">
                                    <p>Tareas próximas</p>
                                </div>
                                <div class="content-actividades">
                                    <?php
                                        if(count($actividades) > 0){
                                            foreach($actividades as $val){
                                    ?>
                                    <div class="actividades">
                                        <svg style="vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-calendar-date" viewBox="0 0 16 16">
                                        <path d="M6.445 11.688V6.354h-.633A12.6 12.6 0 0 0 4.5 7.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675zm1.188-1.305c.047.64.594 1.406 1.703 1.406 1.258 0 2-1.066 2-2.871 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684zm2.953-2.317c0 .696-.559 1.18-1.184 1.18-.601 0-1.144-.383-1.144-1.2 0-.823.582-1.21 1.168-1.21.633 0 1.16.398 1.16 1.23z"/>
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                        </svg>
                                        <span><?php echo ucwords($val["nombreCurso"])?>: <?php echo $val["descpCurso"]?></span>
                                    </div>
                                    <?php
                                        }   
                                    }else{
                                    ?>
                                    <div class="actividades">
                                        <span>No hay Tareas pendientes</span>
                                    </div>
                                    <?php
                                        }   
                                    ?>
                                </div>
                                <div class="cargar-mas">
                                    <a href="./UsuarioControlador/calendario"><i class="icon-arrow-down"></i><span>Cargar más</span></a>
                                </div>
                            </div>
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