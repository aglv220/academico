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
                <div class="row" id="contenedor-report">
                    <div class="col-lg-6">
                        <div class="card" style="height: 715px;">
                            <div class="card-body">
                                <select class="form-control" id="select-mes" name="select-mes">
                                    <option value="" selected>Todos los meses</option>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                                <div id="chart_actividades" class="flot-chart" style="margin-top: 15%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" id="div-porcentajes"></div>
                </div>
            </div>
        </div>

        <!--**********************************
            Content body end
        ***********************************-->
        </body>

        </html>