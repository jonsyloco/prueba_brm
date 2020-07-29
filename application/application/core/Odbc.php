<?php

/**
 * Clase que se encarga de las solicitudes a la BD
 */
include('DatosOdbc.php');

class Odbc {

  public $datosOdbc;
  public $salir = '';
  public $dsn = '';
  public $usuario = '';
  public $clave = '';
  public $simulador = false;
  
  // ------------------------------------------------------------------------

  /**
   * Constructor 
   * @param String $dsn nombre de la ODBC
   * @param String $usuario usuaridio de la BD
   * @param String $clave clave de la BD
   * @param Boolean $salir
   * @param Boolean $simulador (true) activa la opcion de desarrollador que evita que se hagan consultas a la BD. solo se consulta 1 vez y los datos son cargados en la SESSION
   * (false) metodo por defecto. habilidato para produccion.
   */
  function odbc($dsn = '', $usuario = '', $clave = '', $salir = true, $simulador = false) {
    $this->salir = $salir;
    $this->dsn = $dsn;
    $this->usuario = $usuario;
    $this->clave = $clave;
    $this->simulador = $simulador;
    $this->conectado = $this->conectar();
  }
  
  // ------------------------------------------------------------------------

  /**
   * Establece la conexion con el ODBC
   */
  function conectar() {
    $conexion = @odbc_connect($this->dsn, $this->usuario, $this->clave);

    if (!$conexion) {
      if ($this->salir === true) {
        echo @odbc_errormsg();
        exit("<hr> odbc.lib::conectar <hr>");
      } else {
        return false;
      }
    }
    $this->conexion = $conexion;
    return true;
  }
  
  // ------------------------------------------------------------------------

  /**
   * funcion que consulta a la BD y que soporta la opcion de simulador.
   * @param String $consulta string de la consulta
   * @param String $nomSimulador alias de la consulta para ser guardada en la session y no ser reescribida.
   */
  function consultar($consulta, $nomSimulador = '') {
    /* No se pudo conectar al odbc */
    if ($this->conectado === false) {
      echo @odbc_errormsg();
      exit("<hr> odbc.lib::conectar <hr>");
    }

    /* Se activo el simulador pero no se especifico la consulta a simular  */
    if ($this->simulador && $nomSimulador == '')
      exit('Ingrese nombre de la consulta simulada o desactive el simulador <br>');

    /* Se hace la consulta normalmente */
    if (!$this->simulador || $nomSimulador == "") {
      $this->datosOdbc = new DatosOdbc();
      $this->datosOdbc->reset();

      $this->datosOdbc->setConsulta($consulta);

      $result = @odbc_exec($this->conexion, $this->datosOdbc->getConsulta());
      if (!$result) {
        if ($this->salir === true) {
          echo @odbc_errormsg();
          echo " $this->dsn <hr> odbc.lib::consultar <hr> " . $this->datosOdbc->getConsulta();
        }
        return 1;
      }

      $this->datosOdbc->setNumCampos(@odbc_num_fields($result)); /* Numero de columnas de un resultado */
      $registros = array();
      $i = 0;

      while ($registro = @odbc_fetch_array($result)) {
        //@array_push($registros, $registro);
        $registros[] = $registro;
        $i++;
      }
      $this->datosOdbc->setRegistro($registros);
      $this->datosOdbc->setNumRegistros($i);

      $campo = array();
      if (!empty($registros)) {
        $campo = @array_keys($registros[0]); /* Devuelve todas las claves de un array o un subconjunto de claves de un array */
      }
      $this->datosOdbc->setNombreCampo($campo);

      $this->datosOdbc->resetNombreCampos();
      $this->datosOdbc->resetRegistro();

      odbc_free_result($result); /* Libera los recursos asociados con un resultado */
    } else { /* Logica del simulador */
      @session_start();
      $this->datosOdbc = new DatosOdbc();
      $this->datosOdbc->reset();

      $this->datosOdbc->setConsulta($consulta);

      $registros = array();
      if (!$this->iniciarTmp($nomSimulador)) { /* si la consulta no ha sido simulada antes entonces se haca la peticion a la bd */
        $result = @odbc_exec($this->conexion, $this->datosOdbc->getConsulta());

        while ($registro = @odbc_fetch_array($result)) {
          $registros[] = $registro;
        }
        $this->simuladorBd($nomSimulador, $registros); /* guarda los datos en session */
      }

      $registros = $this->traerSimuladorBd($nomSimulador); /* trae los datos que estan en session */
      $this->datosOdbc->setRegistro($registros);
      $this->datosOdbc->setNumRegistros(count($registros));

      if (!empty($registros))
        $this->datosOdbc->setNumCampos(count($registros[0]));
      else
        $this->datosOdbc->setNumCampos(0);

      $campo = array();
      if (!empty($registros)) {
        $campo = @array_keys($registros[0]); /* Devuelve todas las claves de un array o un subconjunto de claves de un array */
      }
      $this->datosOdbc->setNombreCampo($campo);

      session_write_close();
    }
    return 0;
  }
  
  // ------------------------------------------------------------------------

  /**
   * retorna el objeto con el resultado de la consulta.
   */
  function getDatosOdbc() {
    return $this->datosOdbc;
  }
  
  // ------------------------------------------------------------------------

  /**
   * Se usa para las consultas de tipo insert, update y delete.
   * @param String $consulta: Consulta sql
   * @return int
   */
  function ejecutar($consulta) {

    if ($this->simulador)
      exit('El simulador solo funciona con sentencias de tipo SELECT');

    $this->datosOdbc = new DatosOdbc();
    $this->datosOdbc->reset();
    $this->datosOdbc->setConsulta($consulta);

    $result = odbc_exec($this->conexion, $this->datosOdbc->getConsulta());
    $this->datosOdbc->setFilasAfectadas(@odbc_num_rows($result));
    if (!$result) {
      if ($this->salir === true) {
        echo odbc_errormsg();
        echo '<hr> odbc.lib::ejecutar <hr>' . $this->datosOdbc->getConsulta();
      }
      return 1; //si hubo error
    }
    return 0; //no hubo error
  }
  
  // ------------------------------------------------------------------------

  /**
   * FALTA DOCUMENTAR
   * @param String $consulta
   * @param String $mensaje
   */
  function ejecutarSeguro($consulta, $mensaje = 'Error Ejecutando!') {
    $this->datosOdbc = new DatosOdbc();
    $this->datosOdbc->setConsulta($consulta);

    $result = @odbc_exec($this->conexion, $this->datosOdbc->getConsulta());
    if (!$result) {
      $error = @odbc_error();
      odbc_rollback($this->conexion);
      $consulta = str_replace("'", "\'", $consulta);
      echo
      "<script language='javascript'>
            alert('$mensaje ($error) - $consulta');
          </script>
          ";
      exit;
    }
  }
  
  // ------------------------------------------------------------------------

  /**
   * Iniciar una transaccion al poner false
   */
  function autocommit($auto = FALSE) {
    return odbc_autocommit($this->conexion, $auto);
  }
  
  // ------------------------------------------------------------------------

  /**
   * Revierte todas las sentencias pendientes de la conexion.
   */
  function rollback() {
    return odbc_rollback($this->conexion);
  }
  
  // ------------------------------------------------------------------------

  /**
   * Envia todas las transacciones pendientes en una conexion.
   */
  function commit() {
    return odbc_commit($this->conexion);
  }
  
  // ------------------------------------------------------------------------

  /*   * *************    funciones para el simulador   ****************   */

  /**
   * funcion que trasforma el arreglo a una cadena y lo escribe en un archivo
   */
  function simuladorBd($archivo, $arreglo) {
    $cadena = json_encode($arreglo);
    $_SESSION['simulador_' . $archivo] = trim($cadena);
  }
  
  // ------------------------------------------------------------------------

  /**
   * funcionque trae el texto y lo pasa de nuevo a un arreglo 
   */
  function traerSimuladorBd($archivo) {
    $fichero = $_SESSION['simulador_' . $archivo];
    return json_decode(trim($fichero), true);
  }
  
  // ------------------------------------------------------------------------

  /** funcion que verifica la existencia del archivo
   * -existe solo llama a traerSimuladorBd()
   * -no existe llama a simuladorBd() y traerSimuladorBd()
   */
  function iniciarTmp($archivo) {
    if (empty($_SESSION))
      return false;

    if (@$_SESSION['simulador_' . $archivo] == "") { /* A veces tira error porque no encuentra la variable de session establecida, se ignora porque no importa */
      return false;
    }
    return true;
  }
  
  // ------------------------------------------------------------------------

  /* ------------------------------------------------ METODO PARA HABLAR. PENDIENTE ----------------------------------------------- */

  /** funcion para insertar a la BD. todos los campor por defecto tiene comillas('), para no poner las comillas usar $this->comillas
    $this->tabla = Nombre de la Bd
    $this->datos = arreglo donde el indice es el nombre del campo y el value es el valor a insertar
    $this->comillas = son los campos que no tienen comillas EJ-> fecadd = today <> nombre = 'Pedro'
    $verSql = echo del sql a ejecutar
    $activo =  activa o inactiva la opcion de insertar informacion.
   */
  function insertar($verSql = false, $activo = true) {
    $campos = "";
    $valores = "";
    $token = "";

    foreach ($this->datos as $campo => $valor):
      $campos .= "" . $campo . ", ";

      if (isset($this->comillas[$campo])) {
        $token = "'";
      } else {
        $token = "";
      }

      $valores .= "$token" . $valor . "$token, ";
    endforeach;

    $campos = substr($campos, 0, -2);
    $valores = substr($valores, 0, -2);

    $insert = " INSERT INTO " . $this->tabla;
    $insert .= " ( " . $campos . " )";
    $insert .= " VALUES ( " . $valores . " )";

    if ($verSql) {
      echo "<pre>$insert</pre>";
    }

    if ($activo) {
      $result = @odbc_exec($this->conexion, $insert);
    }

    if (!$result)
      return 1;
    else
      return 0;
  }
  
  // ------------------------------------------------------------------------

}

?>
