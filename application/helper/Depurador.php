<?php

class Depurador {

  public $puntos = array();

  /**
   * Establece el nombre de la marca
   * @param String $name: nombre de la marca
   */
  public function marca($name) {
    $this->puntos[$name] = microtime(TRUE);
  }

  // --------------------------------------------------------------------

  /**
   * Retorna el tiempo de ejecucion en milisegundos de una marca a otra
   * @param String $point1: nombre de la marca inicial
   * @param String $point2: nombre de la marca final
   * @param int $decimales: la cantidad de decimales que devolvera
   */
  public function tiempo_ejecucion($point1 = '', $point2 = '', $decimales = 4) {
    if ($point1 === '' || $point2 === '')
      return 'No ha establecido ninguna marca';
    return $this->tiempo_humano(number_format($this->puntos[$point2] - $this->puntos[$point1], $decimales), $point1, $point2);
  }
  
  // ------------------------------------------------------------------------

  /**
   * Convierte los microsegundos en formato humano
   * @param int $timestamp: microsegundos de la marca
   */
  private function tiempo_humano($timestamp, $marca_1, $marca_2) {
    if ($timestamp < 0)
      return '-1';

    $return = $marca_1 . ' A ' . $marca_2 . ' = ';
    # Obtenemos el numero de dias
    $days = floor((($timestamp / 60) / 60) / 24);
    if ($days > 0) {
      $timestamp-=$days * 24 * 60 * 60;
      $return.= ' [Dias:' . $days . '] |';
    }
    # Obtenemos el numero de horas
    $hours = floor(($timestamp / 60) / 60);
    if ($hours > 0) {
      $timestamp-=$hours * 60 * 60;
      $return.=' [Horas:' . str_pad($hours, 2, '0', STR_PAD_LEFT) . '] | ';
    }
    # Obtenemos el numero de minutos
    $minutes = floor($timestamp / 60);
    if ($minutes > 0) {
      $timestamp-=$minutes * 60;
      $return.=' [Minutos:' . str_pad($minutes, 2, '0', STR_PAD_LEFT) . '] | ';
    }
    # Obtenemos el numero de segundos
    $return.= ' [Segundos:' . str_pad($timestamp, 2, "0", STR_PAD_LEFT) . ']';
    return $return;
  }

  // --------------------------------------------------------------------

  /**
   * Devuelve la cantidad de memoria usada por el script PHP, en bytes.
   */
  public function memoria_usada() {
    return 'Memoria usada: ' . round(memory_get_usage() / 1024, 1) . ' KB de ' . round(memory_get_usage(1) / 1024, 1) . ' KB';
  }

}

?>