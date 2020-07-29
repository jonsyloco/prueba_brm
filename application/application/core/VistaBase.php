<?php

/**
 * Description of VistaBase
 *
 * @author user
 */
class VistaBase {

  /**
   * Carga una vista, hace lo mismo que el metodo cargarView con la diferencia de buscara las vistas desde la carpeta template
   * @param String $template nombre de la plantilla a cargar
   * @return boolean
   */
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
  
  // ------------------------------------------------------------------------

  /**
   * Se encarga de pasar variables del controlador a la vista
   * @param cualquiera $datos
   */
  public function asignarVariable($datos) {
    foreach ($datos as $id_assoc => $valor) {
      $this->$id_assoc = $valor;
    }
  }
  
  // ------------------------------------------------------------------------

  public function imprimirVar($variable) {
    echo "<pre>";
    print_r($variable);
    echo "</pre>";
  }
  
  // ------------------------------------------------------------------------

}

?>
