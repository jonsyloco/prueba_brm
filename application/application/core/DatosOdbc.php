<?php

/**
 * Objeto que contiene los datos de la consulta Odbc
 *
 * @author: user
 */
class DatosOdbc {

  private $numRegistros; /* Cantidad de registros */
  private $registro; /* Los datos de la consulta un array() */
  private $numCampos; /* Numero de columnas de un resultado */
  private $nombreCampos; /* Nombre de las columnas de la consulta sql */
  private $consulta; /* la cadena sql de la consulta realizada */
  private $filasAfectadas; /* cantidad de filas afectadas cuando se hace un insert, update o delete */

  // ------------------------------------------------------------------------
  
  public function getFilasAfectadas() {
    return $this->filasAfectadas;
  }
  
  // ------------------------------------------------------------------------

  public function setFilasAfectadas($filasAfectadas) {
    $this->filasAfectadas = $filasAfectadas;
  }
  
  // ------------------------------------------------------------------------

  public function getNumRegistros() {
    return $this->numRegistros;
  }
  
  // ------------------------------------------------------------------------

  public function setNumRegistros($registros) {
    $this->numRegistros = $registros;
  }
  
  // ------------------------------------------------------------------------

  /**
   * Obtiene los registros de la consulta uno por uno
   */
  public function getRegistro() {
    if ($registro = @current($this->registro)) {
      @next($this->registro);
      $registro = (array) $registro;
      return $registro;
    } else {
      return false;
    }
  }
  
  // ------------------------------------------------------------------------

  /**
   * Retorna todo el resultado de la consulta en un array tal cual como esta en la base de datos 
   */
  public function getRegistroAll() {
    return $this->registro;
  }
  
  // ------------------------------------------------------------------------

  public function setRegistro($registro) {
    $this->registro = $registro;
  }
  
  // ------------------------------------------------------------------------

  public function getNumCampos() {
    return $this->numCampos;
  }
  
  // ------------------------------------------------------------------------

  public function setNumCampos($campos) {
    $this->numCampos = $campos;
  }
  
  // ------------------------------------------------------------------------

  public function getNombreCampo() {
    return $this->nombreCampos;
  }
  
  // ------------------------------------------------------------------------

  public function setNombreCampo($campo) {
    $this->nombreCampos = $campo;
  }
  
  // ------------------------------------------------------------------------

  public function getConsulta() {
    return $this->consulta;
  }
  
  // ------------------------------------------------------------------------

  public function setConsulta($consulta) {
    $this->consulta = $consulta;
  }
  
  // ------------------------------------------------------------------------

  /**
   * Reinicia los valores
   */
  function reset() {
    $this->numRegistros = 0;
    $this->numCampos = 0;
    $this->consulta = '';
    $this->nombreCampos = array();
    $this->registro = array();
    $this->filasAfectadas = 0;
  }
  
  // ------------------------------------------------------------------------

  function resetNombreCampos() {
    @reset($this->nombreCampos);
  }
  
  // ------------------------------------------------------------------------

  function resetRegistro() {
    @reset($this->registro);
  }
  
  // ------------------------------------------------------------------------

  function prevRegistro() {
    if (@prev($this->registro)) {
      return true;
    } else {
      return false;
    }
  }
  
  // ------------------------------------------------------------------------

  function firstRegistro() {
    @reset($this->registro);
  }
  
  // ------------------------------------------------------------------------

  /**
   * Pinta el resultado de los datos de la consulta en una tabla
   */
  function verdatos() {
    $tabla = '<table border = "1"> <tr>';
    @reset($this->nombreCampos);
    while ($campo = @current($this->nombreCampos)) {
      @next($this->nombreCampos);
      $tabla.= '<td>';
      $tabla.= $campo;
      $tabla.= '</td>';
    }
    $tabla.= '</tr>';

    @reset($this->registro);
    while ($registro = @current($this->registro)) {
      @next($this->registro);
      @reset($this->nombreCampos);
      $tabla.= '<tr>';
      while ($campo = @current($this->nombreCampos)) {
        @next($this->nombreCampos);
        $tabla.= '<td>';
        $tabla.= $registro[$campo] . '&nbsp;';
        $tabla.= '</td>';
      }
      $tabla.= '</tr>';
    }
    $tabla.= '</table>';
    @reset($this->nombreCampos);
    @reset($this->registro);
    return $tabla;
  }
  
  // ------------------------------------------------------------------------

  /**
   * Visualiza el estado de los atributos de la consulta
   */
  function verAtributos() {
    $campos = '';
    foreach ($this->nombreCampos as $registro)
      $campos = $registro . ',' . $campos;

    $cadena = "<pre>
    getNumCampos = $this->numCampos
    getNombreCampos = $campos
    getConsulta = $this->consulta
    getNumRegistros =  $this->numRegistros
    </pre>";

    return $cadena;
  }

}

?>
