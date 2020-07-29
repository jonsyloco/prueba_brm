<?php

/* FUNCIONES PARA EL CONTROLADOR FRONTAL */

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

function redirect($controlador = CONTROLADOR_DEFECTO, $accion = ACCION_DEFECTO) {
  header("Location:index.php?controlador=" . $controlador . "&metodo=" . $accion);
}

function cargarHelper($nombre_helper) {
  if (file_exists('../helper/' . $nombre_helper . '.php'))
    require_once '../helper/' . $nombre_helper . '.php';
  else if (file_exists('helper/' . $nombre_helper . '.php'))
    require_once 'helper/' . $nombre_helper . '.php';
  else if (file_exists( $_SERVER['DOCUMENT_ROOT'] . '/application/helper/' . $nombre_helper . '.php'))
    require_once $_SERVER['DOCUMENT_ROOT'] . '/application/helper/' . $nombre_helper . '.php';
  else {
    echo "$nombre_helper no encontrado";
    exit;
  }
}

function cargarAccion($controllerObj, $action) {
  $accion = $action;
  $controllerObj->$accion();
}

function lanzarAccion($controllerObj) {
  if (isset($_REQUEST["metodo"]) && method_exists($controllerObj, $_REQUEST["metodo"])) {
    cargarAccion($controllerObj, $_REQUEST["metodo"]);
  } else {
    cargarAccion($controllerObj, ACCION_DEFECTO);
  }
}

/**
 *  Base para los controladores, de esta forma llamara al odbc por defecto
 */
class ControladorBase {

  public function __construct() {
    require_once 'Odbc.php';
  }

}

?>
