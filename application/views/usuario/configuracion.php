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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="default-tab">
                            <ul class="nav nav-tabs mb-3" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#email_config">Configuración del sistema</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#canvas_data">Actualización de información</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="email_config" role="tabpanel">
                                    <div class="mt-4">
                                        <h4 class="card-title">Configuración de notificaciones por correo</h4>
                                        <div class="basic-form">
                                            <form id="FRM_CONFIGURACION" class="form-profile mt-4" action="<?php echo base_url(); ?>UsuarioControlador/actualizar_configuracion_usuario" method="POST">
                                                <?php if (isset($cfg_html_user)) {
                                                    echo $cfg_html_user;
                                                } ?>
                                                <button type="submit" class="btn mb-1 mt-3 btn-info">Actualizar configuración <span class="btn-icon-right"><i class="fa fa-check"></i></span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="canvas_data">
                                    <div class="mt-4">
                                        <h4>Actualización de información académica</h4>
                                        <p>
                                            Estimado estudiante, esta opción puede ser usada solo en el caso de que requiera obtener la información académica de su plataforma educativa del CANVAS, esto solo incluye Cursos y tareas <b>pendientes</b>.
                                        </p>
                                        <p>
                                            Para empezar con el proceso solo debe dar clic en el botón <b>"Extraer información actualizada"</b>, luego de ello solo tendrá que esperar a que el proceso termine para que el sistema traiga su información actualizada.
                                        </p>
                                        <button type="button" class="btn btn-primary btn-block" onclick="actualizar_informacion()">Extraer información actualizada &nbsp;<i class="icon-refresh"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>