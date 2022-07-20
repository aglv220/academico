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
                        <h4 class="card-title">Mi historial de acciones</h4>
                        <table id="tblhistory" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Módulo</th>
                                    <th>Acción</th>
                                    <th>Título</th>
                                    <th>Detalle</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?= $history_user ?>
                            </tbody>
                        </table>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>