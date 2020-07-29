<!DOCTYPE html>
<?php echo "Cargando..." ?>
<html lang="es" class="fixed">
    <head>

        <!--NADA CON LA CACHE, NO SE ALMACENARA-->
        <meta charset="UTF-8">

        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">



        <link rel="stylesheet" type="text/css" href="<?php echo RUTA_RECURSOS; ?>resources/librerias/css/bootstrap/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo RUTA_RECURSOS; ?>resources/librerias/css/tooltipster/tooltipster.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo RUTA_RECURSOS; ?>resources/librerias/css/alertify/alertify.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo RUTA_RECURSOS; ?>resources/librerias/css/alertify/themes/default.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo RUTA_RECURSOS; ?>resources/librerias/css/alertify/themes/semantic.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo RUTA_RECURSOS; ?>resources/librerias/css/tooltipster/themes/tooltipster-light.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo RUTA_RECURSOS; ?>resources/librerias/css/tooltipster/themes/tooltipster-noir.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo RUTA_RECURSOS; ?>resources/librerias/css/tooltipster/themes/tooltipster-punk.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo RUTA_RECURSOS; ?>resources/librerias/css/tooltipster/themes/tooltipster-shadow.css"/>



        <script type="text/javascript" src="<?php echo RUTA_RECURSOS; ?>resources/librerias/js/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo RUTA_RECURSOS; ?>resources/librerias/js/jquery/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo RUTA_RECURSOS; ?>resources/librerias/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo RUTA_RECURSOS; ?>resources/librerias/js/datatable/jquery.dataTables.min.js"></script> 
        <script type="text/javascript" src="<?php echo RUTA_RECURSOS; ?>resources/librerias/js/jquery.tooltipster.min.js"></script>
        <script type="text/javascript" src="<?php echo RUTA_RECURSOS; ?>resources/librerias/js/alertify.min.js"></script>

        <link rel="stylesheet" href="resource/assets/vendor/bootstrap-datepicker-1.6.4/css/bootstrap-datepicker.min.css" />
        <link rel="stylesheet" href="resource/assets/vendor/bootstrap-datepicker-1.6.4/css/bootstrap-datepicker3.min.css" />






        <!-- Opcionales para fancy-->
        <!--<script type="text/javascript" src="resources/js/jquery.fancybox-buttons.js?v=1.0.5"></script>-->

        <!-- Basic -->


        <title>Iventarios</title>
        <meta name="keywords" content="HTML5 Admin Template" />
        <meta name="description" content="Porto Admin - Responsive HTML5 Template">
        <meta name="author" content="okler.net">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />









        <!-- Vendor CSS -->
        <link rel="stylesheet" href="resource/assets/vendor/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="resource/assets/vendor/font-awesome/css/font-awesome.css" />
        <link rel="stylesheet" href="resource/assets/vendor/magnific-popup/magnific-popup.css" />
        <link rel="stylesheet" href="resource/css/style.css" />



        <!-- Head Libs -->
        <script src="resource/assets/vendor/modernizr/modernizr.js"></script>
        <script src="resource/js/spin.js"></script>

        <link rel="resource/stylesheet" href="resource/assets/vendor/pnotify/pnotify.custom.css" />
        <script src="resource/assets/vendor/pnotify/pnotify.custom.js"></script>
        <script src="resource/assets/javascripts/ui-elements/examples.notifications.js"></script>

        <script src="resource/assets/vendor/magnific-popup/magnific-popup.js"></script>
        <script src="resource/js/vistaFormulario/formulairo.js"></script>

        <link rel="stylesheet" href="resource/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
        <link rel="stylesheet" href="resource/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

        <link rel="stylesheet" href="resource/assets/vendor/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="resource/assets/vendor/font-awesome/css/font-awesome.css" />
        <link rel="stylesheet" href="resource/assets/vendor/magnific-popup/magnific-popup.css" />
        <!--<link rel="stylesheet" href="resource/assets/vendor/bootstrap-datepicker/css/datepicker3.css" />-->

        <!-- Specific Page Vendor CSS -->
        <link rel="stylesheet" href="resource/assets/vendor/pnotify/pnotify.custom.css" />

        <!-- Theme CSS -->
        <link rel="stylesheet" href="resource/assets/stylesheets/theme.css" />

        <!-- Skin CSS -->
        <link rel="stylesheet" href="resource/assets/stylesheets/skins/default.css" />

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="resource/assets/stylesheets/theme-custom.css"/>

        <script src="resource/assets/vendor/jquery/jquery.js"></script>


        <script src="resource/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>


        <script src="resource/assets/vendor/bootstrap/js/bootstrap.js"></script>







        <link rel="stylesheet" type="text/css" href="resource/assets/dataTableExport/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="resource/assets/dataTableExport/buttons.dataTables.min.css">

<!--<script type="text/javascript" src="code.jquery.com/jquery-1.12.4.js"></script>-->
        <script type="text/javascript" src="resource/assets/dataTableExport/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="resource/assets/dataTableExport/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="resource/assets/dataTableExport/buttons.flash.min.js"></script>
        <script type="text/javascript" src="resource/assets/dataTableExport/jszip.min.js"></script>
        <script type="text/javascript" src="resource/assets/dataTableExport/pdfmake.min.js"></script>
        <script type="text/javascript" src="resource/assets/dataTableExport/vfs_fonts.js"></script>
        <script type="text/javascript" src="resource/assets/dataTableExport/buttons.html5.min.js"></script>
        <script type="text/javascript" src="resource/assets/dataTableExport/buttons.print.min.js"></script>

        <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
        
        <script type="text/javascript" src="code.jquery.com/jquery-1.12.4.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>-->


<!--                        <script src="resource/assets/javascripts/theme.init.js"></script>-->


    </head>


    <body>
        <section class="body">

            <!--start: header--> 
            <header class="header">
                <div class="logo-container">
                    <a href="index.php" class="logo">v1.0 pruebas
                        <img src="resource/img/titulo_IBG_TRASPARENTE.png" height="35" alt="Porto Admin" />
                    </a>
                    <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                        <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                    </div>
                </div>


            </header>
            <!--end: header--> 

            <div class="inner-wrapper">
                <!--start: sidebar--> 
                <aside id="sidebar-left" class="sidebar-left">

                    <div class="sidebar-header">
                        <div class="sidebar-title">
                            Navegacion
                        </div>
                        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                        </div>
                    </div>

                    <div class="nano">
                        <div class="nano-content">
                            <nav id="menu" class="nav-main" role="navigation">
                                <ul class="nav nav-main">
                                    <li class='nav-parent'>                                        
                                        <a>
                                            <i class="fa fa-gears" aria-hidden="true"></i>
                                            <span>Parametrización</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                            
                                                <a href="index.php?controlador=Inventario">
                                                <i class="fa fa-print" aria-hidden="true"></i>
                                                    Productos
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                <a href="index.php?controlador=VentasClientes">
                                                <i class="fa fa-sliders" aria-hidden="true"></i>
                                                    Ventas - clientes
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                <a href="index.php?controlador=Compras">
                                                <i class="fa fa-sliders" aria-hidden="true"></i>
                                                    Compras - Proveedores
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <!--<a href="#" onclick="javascript:dibujarVista()">-->
                                        <a href="#">
                                            <i class="fa fa-file-text" aria-hidden="true"></i>
                                            <span>Inventario</span>
                                        </a>
                                    </li>
                                    
                                </ul>
                            </nav>


                        </div>

                    </div>

                </aside>

                <section role="main" class="content-body">
                    <header class="page-header">

                        <!--<h2>Menú</h2>-->

                        <!--                            <div class="right-wrapper pull-right">
                                                     
                                                        <div data-toggle="tooltip" title="(Ctrl + q)" id="hola" data-lock-screen="true" onclick="javascript:inicializacionLockScreen(this)">
                                                            <ul  class="nav nav-main" style="cursor:pointer">
                                                                <li class="nav-parent" style="cursor:pointer">
                                                                    <i class="fa fa-user" aria-hidden="true" style="cursor:pointer"></i><span><?php // echo $_SESSION['session_intranet_login']  ?></span>                                            
                                                                    <i class="fa fa-lock" aria-hidden="true" style="cursor:pointer"></i><span>Bloqueo pantalla</span>                                            
                                                                </li >
                                                            </ul>
                                                        </div>                                
                                                    </div>-->
                        <!--                        <h2>Menú</h2>
                                                <div class="right-wrapper pull-right">
                        
                        
                                                    <ol class="breadcrumbs">
                                                        <li >
                                                            <a><span><i class="fa fa-user"></i><?php // echo $_SESSION['session_intranet_login']  ?></span></a>
                        
                        
                                                        </li>            
                                                        <li>
                                                            <a href="index.html">
                                                                <i class="fa fa-home"></i>
                                                            </a>
                                                        </li>
                                                        <li><span>Forms</span></li>
                                                        <li><span>Advanced</span></li>
                                                        <li><a><i class="fa fa-chevron-left"></i></a></li>
                                                    </ol>
                                                </div>
                                            </header>-->