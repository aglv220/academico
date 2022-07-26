<style>

</style>
<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Página principal</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="div-actividad card">
                    <div class="card-body">
                        <!-- <button type="button" class="test-notification btn btn-primary">Probar</button> -->
                        <div class="cartitle">
                            <p>Actividades próximas</p>
                        </div>
                        <div class="content-actividades">
                            <?php
                            if (count($tareas) > 0) {
                                foreach ($tareas as $val) {
                                    $dia_v = $val["dia_actividad"];
                                    $mes_v = strtolower($lstmeses[$val["mes_actividad"]]);
                                    $year_v = $val["year_actividad"];
                                    $fecha_v = "disponible hasta el " . $val["dia_actividad"] . " de " . $mes_v . " del " . $year_v;
                            ?>
                                    <div class="actividades">
                                        <i class="mdi mdi-calendar-blank icono-calendario" data-toggle="tooltip" data-placement="top" title="<?=$fecha_v?>"><label><?= $dia_v ?></label></i>
                                        <span><?php echo "<b>" . $mes_v . " " . $year_v . "</b> - " . ucwords($val["nombreCurso"]) ?>: <?php echo $val["descpCurso"] ?></span>
                                    </div>
                                <?php
                                }
                            } else {
                                ?>
                                <div class="actividades">
                                    <span>No hay tareas pendientes</span>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="cargar-mas">
                            <a href="<?= base_url() ?>calendario"><i class="icon-arrow-down"></i>&nbsp;<span>Ver todas</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="div-actividad card">
                    <div class="card-body">
                        <div class="cartitle">
                            <p>Tareas próximas</p>
                        </div>
                        <div class="content-actividades">
                            <?php
                            if (count($actividades) > 0) {
                                foreach ($actividades as $val) {
                                    $dia_v = $val["dia_actividad"];
                                    $mes_v = strtolower($lstmeses[$val["mes_actividad"]]);
                                    $year_v = $val["year_actividad"];
                                    $fecha_v = "disponible hasta el " . $dia_v . " de " . $mes_v . " del " . $year_v;
                            ?>
                                    <div class="actividades">
                                        <i class="mdi mdi-calendar-blank icono-calendario" data-toggle="tooltip" data-placement="top" title="<?=$fecha_v?>"><label><?= $dia_v ?></label></i>
                                        <span><?php echo "<b>" . $mes_v . " " . $year_v. "</b> - " . ucwords($val["nombreCurso"]) ?>: <?php echo $val["descpCurso"] ?></span>
                                    </div>

                                <?php
                                }
                            } else {
                                ?>
                                <div class="actividades">
                                    <span>No hay tareas pendientes</span>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="cargar-mas">
                            <a href="<?= base_url() ?>calendario"><i class="icon-arrow-down"></i>&nbsp;<span>Ver todas</span></a>
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