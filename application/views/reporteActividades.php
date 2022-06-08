<style>
    .color{
        color: #7CD9E2;
        font-weight: bold;
    }
    .porcentaje{
        font-size: 4rem;
    }
    .nombre{
        font-size: 3rem;
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
                    <div class="col-lg-6">
                        <div class="card" style="height: 715px;">
                            <div class="card-body">
                            <select class="form-control" id="val-skill" name="val-skill">
                                                    <option value="">Seleccione mes</option>
                                                    <option value="html">Enero</option>
                                                    <option value="css">Febreo</option>
                                                    <option value="javascript">Marzo</option>
                                                    <option value="angular">Abril</option>
                                                    <option value="angular">Mayo</option>
                                                    <option value="vuejs">Junio</option>
                                                    <option value="ruby">Julio</option>
                                                    <option value="php">Agosto</option>
                                                    <option value="asp">Setiembre</option>
                                                    <option value="python">Octubre</option>
                                                    <option value="mysql">Noviembre</option>
                                                    <option value="mysql">Diciembre</option>
                            </select>
                                <div id="flotPie1" class="flot-chart" style="margin-top: 15%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body" style="text-align: center;">
                               <span class="color porcentaje">20%</span> <span class="color nombre">Clases</span> 
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body" style="text-align: center;">
                                <span class="color porcentaje">32%</span> <span class="color nombre">Trabajo</span> 
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body" style="text-align: center;">
                                <span class="color porcentaje">35%</span> <span class="color nombre">Reuniones</span>  
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body" style="text-align: center;">
                                <span class="color porcentaje">13%</span> <span class="color nombre">Exposiciones</span>    
                            </div>
                        </div>
                    </div>
                    
                </div>
             </div>
        </div>
            
        <!--**********************************
            Content body end
        ***********************************-->
</body>

</html>