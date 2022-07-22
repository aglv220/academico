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
                        <h4 class="card-title">Mis notificaciones</h4>
                        <table id="tblnotifys" class="display dataTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Actividad</th>
                                    <th>Título notificación</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?= $notifys_user ?>
                            </tbody>
                        </table>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>