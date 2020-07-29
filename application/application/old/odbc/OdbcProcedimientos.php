<?php

/** Libreria ODBC
 * 	
 * 2008 : ) Alejo (ibg_alejo_sistemas@hotmail.com)
 * 	
 */
class OdbcProcedimientos {

  function OdbcProcedimientos($dsn = '', $usuario = '', $clave = '') {
    $this->reset();
    $this->dsn = $dsn;
    if (trim($usuario) != '') {
      $this->usuario = $usuario;
    } else {
      $this->usuario = USER100_1_ODBC;
    }
    if (trim($clave) != '') {
      $this->clave = $clave;
    } else {
      $this->clave = PASS100_1_ODBC;
    }
    $this->reset();
    $this->conectar();
    if ($dsn != "intranet") {
      $this->ejecutar("set isolation to dirty read");
    }
  }

  /**
   * Initializa el Odbc
   *
   * @privada
   */
  function reset() {
    $this->registros = 0;
    $this->campos = 0;
    $this->consulta = '';
    $this->campo = array();
    $this->registro = array();
    $this->encabezado = array();
  }

  /**
   * Conectar con Odbc
   *
   * @privada
   */
  function conectar() {
    $conexion = @odbc_connect($this->dsn, $this->usuario, $this->clave);
    if (!$conexion) {
      echo @odbc_errormsg();
      exit("<hr> odbc.lib::conectar <hr>");
    }
    $this->conexion = $conexion;
  }

  /**
   * Agregar un nuevo campo
   *
   * @publica
   * @parametro: $nombre: nombre del campo
   */
  function addCampo($campo) {
    @array_push($this->campo, $campo);
  }

  /**
   * Agregar un nuevo registro
   *
   * @publica
   * @parametro: $registro: registro nuevo
   */
  function addRegistro($registro) {
    @array_push($this->registro, $registro);
  }

  /**
   * Obtener el registro actual
   *
   * @publica
   * @parametro: 
   */
  function getRegistro() {
    if ($registro = @current($this->registro)) {
      @next($this->registro);
      return $registro;
    } else {
      return false;
    }
  }

  /**
   * Pasar al anterior registro
   *
   * @publica
   * @parametro: 
   */
  function prevRegistro() {
    if (@prev($this->registro)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Pasar al siguiente registro
   *
   * @publica
   * @parametro: 
   */
  function nextRegistro() {
    if (@next($this->registro)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Pasar al primer registro
   *
   * @publica
   * @parametro: 
   */
  function firstRegistro() {
    @reset($this->registro);
  }

  /**
   * Asignar una consulta
   *
   * @publica
   * @parametro: $consulta: sentencia sql
   */
  function setConsulta($consulta) {
    unset($this->consulta);
    $this->consulta = $consulta;
  }

  /**
   * Ejecutar una sentencia
   *
   * @publica
   * @parametro: $consulta: sentencia sql
   */
  function ejecutar($consulta) {
    $this->setConsulta($consulta);
    $result = @odbc_exec($this->conexion, $this->consulta);
    if (!$result) {
      echo @odbc_errormsg();
      echo "<hr> odbc.lib::ejecutar <hr> $this->consulta ";
      return 1; //si hubo error
    }
    return 0; //no hubo error
  }

  /**
   * Obtener n�mero de campos
   *
   * @publica
   * @parametro: 
   */
  function asignartitulo($linea) {//-NUEVAS FUNCIONES---------------------------
    $this->encabezado = explode("|", $linea);
    $longitud = count($this->encabezado);
    $this->campos = $longitud;
    for ($i = 0; $i < $longitud; $i++) {
      $campo = $this->encabezado[$i];
      $this->addCampo("$campo");
    }
  }

  function getCampos() {
    return $this->campos;
  }

  /**
   * Ejecutar una consulta
   *
   * @publica
   * @parametro: $consulta: sentencia sql
   */
  function consultar($consulta) {
    //$this->reset();
    $this->setConsulta($consulta);
    $result = @odbc_exec($this->conexion, $this->consulta);
    if (!$result) {
      echo @odbc_errormsg();
      echo "<hr> odbc.lib::consultar <hr> $this->consulta";
      return 1; //si hubo error
    }
    $this->campos = @odbc_num_fields($result);
    $i = 0;
//        while ($registro = @odbc_fetch_array($result))
    while (@odbc_fetch_row($result)) {
      $i ++;
      for ($c = 0; $c < $this->campos; $c++) {
        $campo = $this->encabezado[$c];
        $columna = odbc_result($result, $c + 1);
        if (isset($columna) and $columna != "")
          $registro[$campo] = $columna;
      }
      $this->addRegistro($registro);
      unset($registro);
    }
    $this->registros = $i;

    odbc_free_result($result);
    return 0; //no hubo error
  }

  /**
   * Desplegar los datos de una consulta en registros
   *
   * @publica
   * @parametro:
   */
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

  function autocommit($auto = FALSE) {
    return odbc_autocommit($this->conexion, $auto);
  }

  function rollback() {
    return odbc_rollback($this->conexion);
  }

  function commit() {
    return odbc_commit($this->conexion);
  }

}

?>