    <!--**********************************
        Scripts
    ***********************************-->
    <!-- JQUERY -->
    <?php
    /*$url = explode("/", current_url());
    $validar_page = "";
    if (isset($url[6])) {
        $validar_page = $url[6] == "v_datos_personales" ? true : false;
    }*/
    ?>
    <script src="<?= base_url() ?>assets/plugins/common/common.min.js"></script>
    <script src="<?= base_url() ?>assets/js/custom.min.js"></script>
    <script src="<?= base_url() ?>assets/js/settings.js"></script>
    <script src="<?= base_url() ?>assets/js/gleek.js"></script>
    <script src="<?= base_url() ?>assets/js/styleSwitcher.js"></script>
    <!-- BASE 64 -->
    <script src="<?= base_url() ?>assets/plugins/jquery-base64/jquery.base64.min.js"></script>
    <!--  PUSHER js -->
    <script src="https://js.pusher.com/7.1/pusher.min.js"></script>
    <!--  FUNCIONES FOOTER js -->
    <script src="<?= base_url() ?>assets/functions-js/funciones-footer.js"></script>
    <!-- PUSHER INIT -->
    <script src="<?= base_url() ?>assets/js/plugins-init/pusher-init.js"></script>

    <!-- Chartjs -->
    <script src="<?= base_url() ?>assets/plugins/chart.js/Chart.bundle.min.js"></script>
    <!-- Circle progress -->
    <script src="<?= base_url() ?>assets/plugins/circle-progress/circle-progress.min.js"></script>
    <!-- Datamap 
    <script src="<?= base_url() ?>assets/plugins/d3v3/index.js"></script>
    <script src="<?= base_url() ?>assets/plugins/topojson/topojson.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/datamaps/datamaps.world.min.js"></script>-->
    <!-- Morrisjs -->
    <script src="<?= base_url() ?>assets/plugins/raphael/raphael.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/morris/morris.min.js"></script>
    <!-- Pignose Calender -->
    <script src="<?= base_url() ?>assets/plugins/moment/moment.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/pg-calendar/js/pignose.calendar.min.js"></script>

    <script src="<?= base_url() ?>assets/plugins/chartist/js/chartist.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>
    <!-- DASHBOARD 1
    <script src="<?= base_url() ?>assets/js/dashboard/dashboard-1.js"></script>-->
    <script src="<?= base_url() ?>assets/plugins/jqueryui/js/jquery-ui.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/moment/moment.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/fullcalendar/js/fullcalendar.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins-init/fullcalendar-init.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($footer_validar_page) && $footer_validar_page == true) { ?>
        <script src="<?= base_url() ?>assets/plugins/jquery-steps/build/jquery.steps.min.js"></script>
        <script src="<?= base_url() ?>assets/js/plugins-init/jquery-steps-init.js"></script>
    <?php } ?>

    <!-- Data Table -->
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <!--  flot-chart js -->
    <script src="<?= base_url() ?>assets/plugins/flot/js/jquery.flot.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/flot/js/jquery.flot.pie.js"></script>
    <script src="<?= base_url() ?>assets/plugins/flot/js/jquery.flot.resize.js"></script>
    <script src="<?= base_url() ?>assets/plugins/flot/js/jquery.flot.spline.js"></script>
    <script src="<?= base_url() ?>assets/plugins/flot/js/jquery.flot.init.js"></script>

    <script src="<?= base_url() ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins-init/jquery.validate-init.js"></script>
    <!--  FUNCIONES SISTEMA js -->
    <script src="<?= base_url() ?>assets/functions-js/funciones-sistema.js"></script>

    <?php
    if(isset($footer_script_file)){
        echo $footer_script_file;
    }
    /*$file_js = "funciones-" . $url[5] . ".js";
    $folder_js = "assets/functions-js/";
    $ruta_file_js = base_url() . $folder_js . $url[5] . "/" . $file_js;
    //RUTA RELATIVA DEL ARCHIVO
    $url_sistema = explode("/", $_SERVER["REQUEST_URI"]);
    $ruta_rel_file = $_SERVER["DOCUMENT_ROOT"] . "/" . $url_sistema[1] . "/" . $folder_js .  $url[5] . "/" . $file_js;
    echo $ruta_rel_file;
    //VALIDAR SI ARCHIVO JS EXISTE
    if (file_exists($ruta_rel_file)) {
        echo '<script src="' . $ruta_file_js . '" type="module"></script>';
    }*/
    ?>