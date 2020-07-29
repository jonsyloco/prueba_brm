<?php

/**
  Objeto que contiene los datos de la consulta Odbc

  @author: Steven Jimenez
 */
class DatosOdbc {

  private $registros;
  private $registro;
  private $campos;
  private $campo;
  private $consulta;
  private $filasAfectadas;

  public function getFilasAfectadas() {
    return $this->filasAfectadas;
  }

  public function setFilasAfectadas($filasAfectadas) {
    $this->filasAfectadas = $filasAfectadas;
  }

  public function getRegistros() {
    return $this->registros;
  }

  public function setRegistros($registros) {
    $this->registros = $registros;
  }

  public function getRegistro() {

    if ($registro = @current($this->registro)) {
      @next($this->registro);
      $registro = (array) $registro;
      return $registro;
    } else {
      return false;
    }
  }

  public function getRegistroAll() {
    return $this->registro;
  }

  public function setRegistro($registro) {
    $this->registro = $registro;
  }

  public function getCampos() {
    return $this->campos;
  }

  public function setCampos($campos) {
    $this->campos = $campos;
  }

  public function getCampo() {
    return $this->campo;
  }

  public function setCampo($campo) {
    $this->campo = $campo;
  }

  public function getConsulta() {
    return $this->consulta;
  }

  public function setConsulta($consulta) {
    $this->consulta = $consulta;
  }

  function reset() {
    $this->registros = 0;
    $this->campos = 0;
    $this->consulta = '';
    $this->campo = array();
    $this->registro = array();
    $this->filasAfectadas = 0;
  }

  function resetCampo() {
    @reset($this->campo);
  }

  function resetRegistro() {
    @reset($this->registro);
  }

  function prevRegistro() {
    if (@prev($this->registro)) {
      return true;
    } else {
      return false;
    }
  }

  function firstRegistro() {
    @reset($this->registro);
  }

  function verdatos() {
    echo '<table border = "1">
  		';
    echo '<tr>
  		';
    @reset($this->campo);
    while ($campo = @current($this->campo)) {
      @next($this->campo);
      echo '<td>
        ';
      echo $campo;
      echo '</td>
        ';
    }
    echo '</tr>
  		';

    @reset($this->registro);
    while ($registro = @current($this->registro)) {
      @next($this->registro);
      @reset($this->campo);
      echo '<tr>
    		';
      while ($campo = @current($this->campo)) {
        @next($this->campo);
        echo '<td>
          ';
        echo $registro[$campo] . '&nbsp;
          ';
        echo '</td>
          ';
      }
      echo '</tr>
    		';
    }

    echo '</table>
  		';
    @reset($this->campo);
    @reset($this->registro);
  }

}

?>
