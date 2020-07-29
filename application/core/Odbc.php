<?php

/**
  Clase que se encarga de las solicitudes a la BD
 */
include('DatosOdbc.php');

class Odbc {

  public $datosOdbc;
  public $salir = '';
  public $dsn = '';
  public $usuario = '';
  public $clave = '';
  public $simulador = false;

  /**
    contructor
    dsn = nombre de la ODBC
    usuario = usuaridio de la BD
    clave = clave de la BD
    salir =
    simulador = (true) activa la opcion de desarrollador que evita que se hagan consultas a la BD. solo se consulta 1 vez y los datos son cargados en la SESSION
    (false) metodo por defecto. habilidato para produccion.
   */
  function __construct($dsn = '', $usuario = '', $clave = '', $salir = true, $simulador = false) {
    $this->salir = $salir;
    $this->dsn = $dsn;
    $this->usuario = $usuario;
    $this->clave = $clave;
    $this->simulador = $simulador;
    $this->conectado = $this->conectar();
  }

  function conectar($dsn = '', $usuario = '', $clave = '', $salir = true, $simulador = false)  {
	$this->salir = $salir;
    $this->dsn = $dsn;
    $this->usuario = $usuario;
    $this->clave = $clave;
    $this->simulador = $simulador;

    $conexion = @odbc_connect($this->dsn, $this->usuario, $this->clave);

    if (!$conexion) {
      if ($this->salir === true) {
        echo @odbc_errormsg();
		$this->conectado =false;
        exit("<hr> odbc.lib::conectar <hr>");
      } else {
	  $this->conectado =false;
        return false;
      }
    }
	$this->conectado =true;
    $this->conexion = $conexion;
    return true;
  }

  /**
    funcion que consulta a la BD y que soporta la opcion de simulador.
    consulta = string de la consulta
    nomSimulador = alias de la consulta para ser guardada en la session y no ser reescribida.
   */
  function consultar($consulta, $nomSimulador = "") {

    if ($this->conectado === false) {
      return 1;
    }
    $this->datosOdbc = new DatosOdbc();

    if ($this->simulador && $nomSimulador == "") {
      echo "consulta no Simulada <br>";
    }

    if (!$this->simulador || $nomSimulador == "") {
      $this->datosOdbc = new DatosOdbc();
      $this->datosOdbc->reset();

      $this->datosOdbc->setConsulta($consulta);
      {
        $result = @odbc_exec($this->conexion, $this->datosOdbc->getConsulta());
        if (!$result) {
          if ($this->salir === true) {
            echo @odbc_errormsg();
            echo " $this->dsn <hr> odbc.lib::consultar <hr> " . $this->datosOdbc->getConsulta();
          }
          return 1;
        }

        $this->datosOdbc->setCampos(@odbc_num_fields($result));
        $registros = array();
        $i = 0;

        while ($registro = @odbc_fetch_array($result)) {
          @array_push($registros, $registro);
          $i++;
          $registrotmp = $registro;
        }
        $this->datosOdbc->setRegistro($registros);

        $this->datosOdbc->setRegistros($i);
      }

      $campos = @array_keys($registrotmp);
      $arrCampos = array();

      @reset($campos);
      while ($campo = @current($campos)) {
        @next($campos);
        @array_push($arrCampos, $campo);
      }
      $this->datosOdbc->setCampo($arrCampos);

      $this->datosOdbc->resetCampo();
      $this->datosOdbc->resetRegistro();

      odbc_free_result($result);
    } else {
      
      @session_start();

      $this->datosOdbc->reset();
      $this->datosOdbc->setConsulta($consulta);

      $registros = array();

      if (!$this->iniciarTmp($nomSimulador)) {

        $result = @odbc_exec($this->conexion, $this->datosOdbc->getConsulta());

        while ($registro = @odbc_fetch_array($result)) {
          @array_push($registros, $registro);
        }

        $this->simuladorBd($nomSimulador, $registros);
      }

      $registros = $this->traerSimuladorBd($nomSimulador);

      $this->datosOdbc->setRegistro($registros);

      @session_write_close();
    }


    return 0;
  }

  /**
    retorna el objeto con el resultado de la consulta.
   */
  function getDatosOdbc() {
    return $this->datosOdbc;
  }

  /*metodo usado para insertar, borrar o actualizar*/
  function ejecutar($consulta) {
    $this->datosOdbc = new DatosOdbc();
    $this->datosOdbc->reset();
    $this->datosOdbc->setConsulta($consulta);

    $result = @odbc_exec($this->conexion, $this->datosOdbc->getConsulta());
    $this->datosOdbc->setFilasAfectadas(@odbc_num_rows($result));
    if (!$result) {
      if ($this->salir === true) {
        echo @odbc_errormsg();
        echo "<hr> odbc.lib::ejecutar <hr>" . $this->datosOdbc->getConsulta();
      }
      return 1; //si hubo error
    }
    return 0; //no hubo error
  }

  /*metodo usado para insertar, borrar o actualizar. si surge un error da aviso en pantalla*/
  function ejecutarSeguro($consulta, $mensaje = 'Error Ejecutando!') {
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

  /* funcion para insertar a la BD. todos los campor por defecto tiene comillas('), para no poner las comillas usar $this->comillas
  $this->tabla = Nombre de la Bd 
  $this->datos = arreglo donde el indice es el nombre del campo y el value es el valor a insertar
  $this->comillas = son los campos que no tienen comillas EJ-> fecadd = today <> nombre = 'Pedro'
    $verSql = echo del sql a ejecutar
    $activo =  activa o inactiva la opcion de insertar informacion.
  */
  
  function insertar( $verSql = false, $activo = true) {       
    $campos = "";
    $valores = "";
    $token = "";
    
    foreach ($this->datos as $campo => $valor):
      $campos .= "" . $campo . ", ";
      
        if( isset($this->comillas[$campo])){
          $token = "'";
        }else{
          $token = "";
        }
  
      
      $valores .= "$token" . $valor . "$token, ";
    endforeach;
    
    $campos = substr($campos, 0, -2);
    $valores = substr($valores, 0, -2);

    $insert = " INSERT INTO " . $this->tabla;
    $insert .= " ( " . $campos . " )";
    $insert .= " VALUES ( " . $valores . " )";
    
    if($verSql){
      echo "<pre>$insert</pre>";
    }
    
    if($activo){
      $result = @odbc_exec($this->conexion, $insert);
    }
    if(!$result)
     return 1;
    else
     return 0;
  }

  /*Iniciar el comportamiento transaccional
  TRUE -> el auto envío está activado en una conexión
  FALSE -> el auto NO envío está activado en una conexión (al final debe usar rollBack o commit)
  */
  function autocommit($auto = FALSE) {
    return odbc_autocommit($this->conexion, $auto);
  }

  /*Reversa las operaciones en la base de datos. No hace cambios en la BD*/
  function rollback() {
    return odbc_rollback($this->conexion);
  }

  /*Confirma y aplica los cambios en la base de datos*/
  function commit() {
    return odbc_commit($this->conexion);
  }

  /*   * * funciones para el simlador ******************* */

  /* función que trasforma el arreglo a una cadena y lo escribe en un archivo */

  function simuladorBd($archivo, $arreglo) {

    $cadena = json_encode($arreglo);
    $_SESSION['simulador_' . $archivo] = trim($cadena);
  }

  /* función que trae el texto y lo pasa de nuevo a un arreglo */

  function traerSimuladorBd($archivo) {
    $fichero = $_SESSION['simulador_' . $archivo];
    return json_decode(trim($fichero));
  }

  /* función que verifica la existencia del archivo
    -existe solo llama a traerSimuladorBd()
    -no existe llama a simuladorBd() y traerSimuladorBd()
   */

  function iniciarTmp($archivo) {
    if ( isset($_SESSION['simulador_' . $archivo]) ) {
      return true;
    } else {
      return false;
    }
  }

}

?>
