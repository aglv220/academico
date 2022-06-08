        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Tablero</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Inicio</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h4>Calendario</h4>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 mt-5">
                                        <a href="#" data-toggle="modal" data-target="#add-category" class="btn btn-primary btn-block"><i class="ti-plus f-s-12 m-r-5"></i> Crear Nueva Tarea</a>
                                        <div id="external-events" class="m-t-20">
                                            <p>Arrastra y suelta tu evento o haz clic en el calendario</p>
                                            <div class="external-event bg-primary text-white" data-class="bg-primary"><i class="fa fa-move"></i>Tarea 1</div>
                                            <div class="external-event bg-success text-white" data-class="bg-success"><i class="fa fa-move"></i>Tarea 2</div>
                                            <div class="external-event bg-warning text-white" data-class="bg-warning"><i class="fa fa-move"></i>Tarea 3</div>
                                            <div class="external-event bg-dark text-white" data-class="bg-dark"><i class="fa fa-move"></i>Tarea 4</div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-box m-b-50">
                                            <div id="calendar"></div>
                                        </div>
                                    </div>

                                    <!-- end col -->
                                    <!-- BEGIN MODAL -->
                                    <div class="modal fade none-border" id="event-modal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><strong>Añadir actividad</strong></h4>
                                                </div>
                                                <div class="modal-body"></div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                                                    <button type="button" class="btn btn-success save-event waves-effect waves-light">Crear</button>
                                                    <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Borrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Add Category -->
                                    <div class="modal fade none-border" id="add-category">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><strong>Añadir actividad</strong></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="control-label">Nombre de la actividad</label>
                                                                <input class="form-control form-white" placeholder="Ingrese nombre" type="text" name="category-name">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="control-label">Tipo de actividad</label>
                                                                <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                                                                    <option value="success">Proyecto</option>
                                                                    <option value="danger">Casual</option>
                                                                    <option value="info">Info</option>
                                                                </select>
                                                            </div><br>
                                                            <div class="col-md-6">
                                                                <label class="control-label">Fecha limite de la actividad</label>
                                                                <input class="form-control form-white"  type="date" name="category-name">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="control-label">Hora limite de la actividad</label>
                                                                <input class="form-control form-white"  type="time" name="category-name">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="control-label">detalle</label>
                                                                <textarea name="" id="" cols="30" rows="10"></textarea>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                                                    <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END MODAL -->
                                </div>
                            </div>
                        </div>
                        <!-- /# card -->
                    </div>
                    <!-- /# column -->
                </div>
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->