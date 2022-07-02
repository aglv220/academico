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
                        <h4 class="card-title">Configuración de notificaciones por correo</h4>
                        <div class="basic-form">
                            <form id="FRM_CONFIGURACION" class="form-profile mt-4" action="<?php echo base_url(); ?>UsuarioControlador/actualizar_configuracion_usuario" method="POST">
                                <?php if(isset($cfg_html_user)){ echo $cfg_html_user; } ?>
                                <button type="submit" class="btn mb-1 mt-3 btn-info">Actualizar configuración <span class="btn-icon-right"><i class="fa fa-check"></i></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>