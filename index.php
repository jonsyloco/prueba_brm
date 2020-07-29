<?php

/* La ruta del archivo donde se guardan las credenciales de los ODBC Y FTP */
//require_once $_SERVER['DOCUMENT_ROOT'] . '/informix/connection/connection2.php';

/* Configuración global */
//

////session_unset();
//session_destroy();
//setcookie(session_name(), '', 0, '/');
//session_regenerate_id(true);


session_start();
$_SESSION['progress'] = "0%";
$_SESSION['session_intranet_login'] = "wagner";
$_SESSION['session_intranet_login_dir'] = "DDDD";
$_SESSION['session_intranet_cedula'] = "1144041321";
$_SESSION['session_intranet_cod_cargo'] = "1";
$_SESSION['session_intranet_cod_cargo_dir'] = "08";
$_SESSION['session_intranet_cod_emp'] = "1980-E";
$_SESSION['session_intranet_es'] = "JHONATAN WAGNER OCAMPO";
$_SESSION['session_intranet_fechas'] = 0;
$_SESSION['session_intranet_login'] = "rgomez";
$_SESSION['session_intranet_login'] = "hectorf";
$_SESSION['session_intranet_login_dir'] = "jwagner";
$_SESSION['session_intranet_nivel'] = "0";
$_SESSION['session_intranet_seccion'] = "1-S";
$_SESSION['session_intranet_seccion'] = "1-S";
$_SESSION['session_intranet_suc_dir'] = "2";
$_SESSION['session_intranet_tipo_acceso'] = "v";
$_SESSION['session_intranet_valGestor'] = 0;
$_SESSION['session_intranet_tiposuc'] = "R"; 
session_write_close();

//ini_set('memory_limit', '700M');
//set_time_limit(120);
//
//set_time_limit(3600);
//ini_set('memory_limit', '700M');

require_once 'config/global.php';
//aqui coloco la persona encargada como administrador del sistema

if(isset($_SESSION['session_intranet_login'])){
    if(!empty($_SESSION['session_intranet_login'])){
        if($_SESSION['session_intranet_login']=='lvidal' || $_SESSION['session_intranet_login']=='jwagner' || $_SESSION['session_intranet_login']=='hectorf'){
             $_SESSION['ADMIN']=$_SESSION['session_intranet_login'];
        }else{
            $_SESSION['ADMIN']="";
        }
        
    }
}


/* Funciones para el controlador frontal */
require_once RUTA_MVC . 'core/ControladorBase.php';
require_once RUTA_MVC . 'core/VistaBase.php';


                
/* Cargamos controladores y acciones */

if (isset($_REQUEST["controlador"])) {
    $controllerObj = cargarControlador($_REQUEST["controlador"]);
    lanzarAccion($controllerObj);
} else {
    $controllerObj = cargarControlador(CONTROLADOR_DEFECTO);
    lanzarAccion($controllerObj);
}
?>
