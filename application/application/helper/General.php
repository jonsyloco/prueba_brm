<?php

class General {

  /**
   * Obtiene el ultimo dia de un determinado año o mes, en caso de no indicarse los parametros, toca por defecto el año y mes actual
   * @param date $ano año a calcular
   * @param date $mes mes a calcular
   * @return interger  el ultimo dia del mes
   * @autor Alvaro Javier Vanegas Ochoa, alvarovanegas18@gmail.com
   * @date 2015/02/17
   */
  public function get_ultimo_dia_mes($ano = FALSE, $mes = FALSE) {
    if ($ano === FALSE)
      $ano = date("Y");
    if ($mes === FALSE)
      $mes = date("m");
    return date("d", (mktime(0, 0, 0, $mes + 1, 1, $ano) - 1));
  }
  
  // ------------------------------------------------------------------------

  public function hola_general() {
    return 'hola general';
  }

  /* $date = new DateTime($datos->fec_rad);
    $fecha_creacion = $date->format('m/d/Y');
    $fecha_solicitud = date('m/d/Y'); */
}

?>