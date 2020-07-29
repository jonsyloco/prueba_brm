<?php

/* ----------- FUNCIONES PARA EL CONTROLADOR FRONTAL ------------ */

/**
 * Carga el controlador especificado
 * @param String $controller el nombre del controlador a cargar
 */
function cargarControlador($controller) {
  $controlador = $controller . '_controller';
  $strFileController = 'controller/' . $controlador . '.php';

  if (!is_file($strFileController)) {
    $strFileController = 'controller/' . CONTROLADOR_DEFECTO . '_controller.php';
  }

  require_once $strFileController;
  $controllerObj = new $controlador();
  return $controllerObj;
}

// ------------------------------------------------------------------------

/**
 * Carga la vista especificada
 * @param String $view el nombre de la vista a cargar
 */
function cargarView($view) {
  $vista = $view . '_view';
  $strFileView = 'view/' . $vista . '.php';

  if (!is_file($strFileView)) {
    $strFileView = 'view/' . CONTROLADOR_DEFECTO . '_view.php';
  }

  if (file_exists($strFileView)) {
    require_once $strFileView;

    $viewObj = new $vista();
    return $viewObj;
  } else {
    echo "$view no encontrado";
    exit;
  }
}

// ------------------------------------------------------------------------

/**
 * Carga el modelo especificado
 * @param String $model el nombre del modelo a cargar
 * @return \modelo
 */
function cargarModel($model) {
  $modelo = $model . '_model';
  $strFileModel = 'model/' . $modelo . '.php';

  if (!is_file($strFileModel)) {
    $strFileModel = 'model/' . CONTROLADOR_DEFECTO . '_model.php';
  }

  if (file_exists($strFileModel)) {
    require_once $strFileModel;

    $modelObj = new $modelo();
    return $modelObj;
  } else {
    echo "$model no encontrado";
    exit;
  }
}

// ------------------------------------------------------------------------

/**
 * Hace una redireccion a un controlador y un metodo especificado, en caso de no poner parametros se redijira al controlador y metodo por defecto.
 * @param type $controlador: el controlador a llamar
 * @param type $accion: el metodo a llamar
 */
function redirect($controlador = CONTROLADOR_DEFECTO, $accion = ACCION_DEFECTO) {
  header("Location:index.php?controlador=" . $controlador . "&metodo=" . $accion);
}

// ------------------------------------------------------------------------

/**
 * Carga un helper. si el nombre del helper a cargar no se encuentra en application/helper, el mvc buscara en la carpeta helper del proyecto
 * @param String $nombre_helper: el nombre del helper a cargar
 */
function cargarHelper($nombre_helper) {
  if (file_exists(RUTA_MVC . '/helper/' . $nombre_helper . '.php'))
    require_once RUTA_MVC . '/helper/' . $nombre_helper . '.php';
  else if (file_exists('helper/' . $nombre_helper . '.php'))
    require_once 'helper/' . $nombre_helper . '.php';
  else {
    echo "$nombre_helper no encontrado";
    exit;
  }
}

// ------------------------------------------------------------------------

/**
 * Carga un archivo antiguo o version antigua de alguna clase ubicada en la carpeta old 
 * @param String $ruta_archivo_old la ruta del archivo a cargar junto con su nombre y sin la extension .php
 */
function cargarArchivosAnteriores($ruta_archivo_old) {
  if (file_exists(RUTA_MVC . '/old/' . $ruta_archivo_old . '.php'))
    require_once RUTA_MVC . '/old/' . $ruta_archivo_old . '.php';
  else {
    echo "$ruta_archivo_old no encontrado";
    exit;
  }
}

// ------------------------------------------------------------------------

function cargarAccion($controllerObj, $action) {
  $accion = $action;
  $controllerObj->$accion();
}

// ------------------------------------------------------------------------

function lanzarAccion($controllerObj) {
  if (isset($_REQUEST["metodo"]) && method_exists($controllerObj, $_REQUEST["metodo"])) {
    cargarAccion($controllerObj, $_REQUEST["metodo"]);
  } else {
    cargarAccion($controllerObj, ACCION_DEFECTO);
  }
}

// ------------------------------------------------------------------------

/**
 *  Base para los controladores, de esta forma llamara al odbc por defecto
 */
class ControladorBase {

  public function __construct() {
    require_once 'Odbc.php';
  }

}

?>
