<body>

    <!--*******************
    Preloader start
********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
    Preloader end
********************-->


    <!--**********************************
    Main wrapper start
***********************************-->
    <div id="main-wrapper">
        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="<?= base_url() ?>pagina_principal">
                    <b class="logo-abbr"><img src="<?= base_url() ?>assets/images/logo.png" alt=""> </b>
                    <span class="logo-compact"><img src="<?= base_url() ?>assets/images/logo-compact.png" alt=""></span>
                    <span class="brand-title">
                        <!-- <h1 class="menu-titulo">DAGY</h1> -->
                        <h1 class="menu-img img-fluid"><img src="<?= base_url() ?>assets/images/logo-dagy.png" alt=""></h1>
                    </span>
                </a>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content clearfix">

                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">
                    <img class="logo_utp" src="<?= base_url() ?>assets/images/logo_utp.png" width="200" alt="">
                </div>
                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                                <i class="mdi mdi-bell-outline"></i>
                                <span class="badge badge-pill gradient-2 count-notify-pending notify-number">
                                    <?php if (isset($data_notify)) {
                                        echo $data_notify["NOTIFYPENDALL"];
                                    } ?>
                                </span>
                            </a>
                            <div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
                                <div class="dropdown-content-heading d-flex justify-content-between">
                                    <span class="count-notify-pending notify-text">
                                        <?php if (isset($data_notify)) {
                                            echo $data_notify["NOTIFYPENDALL"] == 0 ? "Sin notificaciones" : $data_notify["NOTIFYPENDALL"] . " notificaciones";
                                        } ?></span>
                                    <a href="<?= base_url() ?>usuario/notificaciones" class="d-inline-block" data-toggle="tooltip" data-placement="top" title="Ver todas las notificaciones">
                                        <span class="badge badge-pill gradient-2 count-notify-pending notify-number">
                                            <?php if (isset($data_notify)) {
                                                echo $data_notify["NOTIFYPENDALL"];
                                            } ?>
                                        </span>
                                    </a>
                                </div>
                                <div class="dropdown-content-body">
                                    <ul class="lst-notificaciones">
                                        <?php if (isset($data_notify)) {
                                            echo $data_notify["HTMLNOTIFY"];
                                        } ?>
                                    </ul>
                                    <div class="c-notify-pending-none mt-4 mb-4 <?php if (isset($data_notify) && $data_notify["NOTIFYPENDALL"] > 0) {
                                                                                    echo "display-none";
                                                                                } ?>">
                                        <a class="notify-pending-none">
                                            <div class="notification-content">
                                                <h6 class="notification-heading">No tienes notificaciones pendientes</h6>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <a class="d-flex justify-content-between gradient-4 px-4 text-white notify-pending-deleteall">
                                    <span>Eliminar todas las notificaciones</span>
                                    <span><i class="icon-trash"></i></span>
                                </a>
                            </div>
                        </li>
                        <li class="icons dropdown d-none d-md-flex">
                            <span>Hola, <?= $this->session->userdata('SESSION_NOMBRES') ?></span>
                        </li>
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="<?= base_url() ?>assets/images/user-photo-utp.png" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="<?= base_url() ?>usuario/perfil_personal"><i class="icon-user"></i> <span>Perfil</span></a>
                                        </li>
                                        <li>
                                            <a href="<?= base_url() ?>usuario/configuracion">
                                                <i class="icon-settings"></i> <span>Configuración</span>
                                                <div class="badge gradient-3 badge-pill gradient-1"></div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= base_url() ?>usuario/historial">
                                                <i class="mdi mdi-history"></i> <span>Mi historial</span>
                                                <div class="badge gradient-3 badge-pill gradient-1"></div>
                                            </a>
                                        </li>
                                        <hr class="my-2">
                                        <li><a href="<?= base_url() ?>LoginControlador/cerrar_sesion"><i class="icon-logout"></i> <span>Cerrar Sesión</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->
        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label">Tablero</li>
                    <li>
                        <a href="<?= base_url() ?>calendario" aria-expanded="false">
                            <i class="icon-calender menu-icon"></i><span class="nav-text">Calendario</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() ?>pizarra" aria-expanded="false">
                            <i class="icon-grid  menu-icon"></i><span class="nav-text">Pizarra</span>
                        </a>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-chart menu-icon"></i><span class="nav-text">Reportes</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?= base_url() ?>reporte/actividades">Reporte de Actividades</a></li>
                            <li><a href="<?= base_url() ?>reporte/tareas">Reporte de Tareas</a></li>
                            <!-- <li><a href="./index-2.html">Home 2</a></li> -->
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->