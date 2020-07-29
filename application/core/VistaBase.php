<?php

/**
 * Description of VistaBase
 *
 * @author user
 */
class VistaBase {

  function cargarTemplate($template) {
    $template = strtolower($template);
    $template = 'view/template/' . $template . '_view.php';

    if (file_exists($template)) {
      require_once $template;
      return true;
    } else {
      return false;
    }
  }

  public function asignarVariable($datos) {
    foreach ($datos as $id_assoc => $valor) {
      $this->$id_assoc = $valor;
    }
  }

 
  public function imprimirVar($variable) {
    echo "<pre>";
    print_r($variable);
    echo "</pre>";
  }

}

?>
