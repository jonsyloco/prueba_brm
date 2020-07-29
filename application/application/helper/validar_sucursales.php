<?php
/**
 * helper que ayuda al manejo de las sucursales y regionales.
 * @author steven jimenez
 */
class ValidarSucursal {

 private $consultaSucReg;
 private $sucRegRequest;
 private $sucRegSession;
 private $tipoSession;
 private $conexion;
 private $arrSucReg = array();
 private $arrRegSuc = array();
 private $arrRegIntraSuc = array();
 private $arrDatosConexion = array();
 private $flag = true;

 /**
  * constructor ; Segun el ingreso el hace el arreglo de las sucursales y regione 
  * que puede ver
  * 
  * 
  * $db -> la conexion a la base de datos por Obdc
  * $sucRegRequest -> es la sucursal enviada por parametros $_get o $_post
  * $flag -> (true) indica que el objeto $db es la vercion que tiene un objeto de datosOdbc (false) es el Odbc que tiene el arreglo de datos
  */
 public function __construct($db, $sucRegRequest = '', $flag = true) {
	
  $this->flag = $flag;
  $this->sucRegRequest = $sucRegRequest + 0;
  $this->sucRegSession = $_SESSION['session_intranet_suc'];
  $this->tipoSession = $_SESSION['session_intranet_tiposuc'];

  $this->consultaSucReg = "select s.codigo as codsuc,
                           s.nombre as nomsuc,
                           r.codigo+0 as codreg,
                           r.nombre as nomreg,
                           r.cod_intranet as codreg_intra
                           from sucursales s,regionales r
                           where s.codregion = r.codigo
                           and s.estado = 'A'";

  if ($this->tipoSession == 'R') {
   $this->consultaSucReg .=" and r.cod_intranet = '" . $this->sucRegSession . "'";
  }
  if ($this->tipoSession == 'S') {
   $this->consultaSucReg .=" and s.codigo = '" . $this->sucRegSession . "'";
  }


  $this->conexion = $db;
  $this->conexion->consultar($this->consultaSucReg);

  if ($flag) {
   $datosOdbc = $this->conexion->getDatosOdbc();
   $datosResultado = $datosOdbc->getAllRegistros();
  }else{
   $datosResultado = $this->conexion->registro;
  }
  reset($datosResultado);
   while ($reg = current($datosResultado)) {
    next($datosResultado); 
    
    $codSuc = trim($reg['codsuc']) + 0;
    $nomSuc = trim($reg['nomsuc']);
    $codReg = trim($reg['codreg']) + 0;
    $nomReg = trim($reg['nomreg']);
    $codReg_Intra = trim($reg['codreg_intra']) + 0;

    $this->arrSucReg[$codSuc]['codsuc'] = $codSuc;
    $this->arrSucReg[$codSuc]['nomsuc'] = $nomSuc;
    $this->arrSucReg[$codSuc]['codreg'] = $codReg;
    $this->arrSucReg[$codSuc]['nomreg'] = $nomReg;
    $this->arrSucReg[$codSuc]['codreg_intra'] = $codReg_Intra;

    $this->arrRegSuc[$codReg]['nomreg'] = $nomReg;
    $this->arrRegSuc[$codReg]['codreg'] = $codReg;
    $this->arrRegSuc[$codReg]['codreg_intra'] = $codReg_Intra;
    $this->arrRegSuc[$codReg]['sucursales'][$codSuc] = $this->arrSucReg[$codSuc];

    $this->arrRegIntraSuc[$codReg_Intra]['nomreg'] = $nomReg;
    $this->arrRegIntraSuc[$codReg_Intra]['codreg'] = $codReg;
    $this->arrRegIntraSuc[$codReg_Intra]['codreg_intra'] = $codReg_Intra;
    $this->arrRegIntraSuc[$codReg_Intra]['sucursales'][$codSuc] = $this->arrSucReg[$codSuc];
   }
                  /*
    echo "<pre>";
     var_dump($this->arrRegSuc);
     echo "</pre>"; 
  
   /* echo "<pre>";
     var_dump($this->arrRegSuc);
     echo "</pre>"; */
 }

 /**
  * verifica en la aplicacion si la sucursal que esta mirando esta en la lista de suc habilitadas para el usuario.
  * 
  * retorna (true) si el ingreso es correcto (false) si el ingreso es a una sucursal no habilitada
  * 
  */
 
 public function verificarVistaSuc() {

  if ($this->tipoSession == 'C') {
   return true;
  }

  if ($this->tipoSession == 'R') {
   return (isset($this->arrRegIntraSuc[$this->sucRegSession]['sucursales'][$this->sucRegRequest]) || $this->sucRegSession == $this->sucRegRequest) ? true : false;
  }
  if ($this->tipoSession == 'S') {
   return ($this->sucRegSession == $this->sucRegRequest) ? true : false;
  }
  
  return false;
 }

 /**
 Retorna segun la sucursal el nombre del Odbc, el servidor y la ip del equipo en la sucursal donde esta la BD, si no hay una datos por 
 defecto retorna el de direccion general
 
 $suc -> sucursal a consultar, por defento consulta los datos de la variable sucRegRequest
 */
  public function nombreConexion($suc = null){
	
	if( !isset($suc) ){
		$suc = $this->sucRegRequest;
	}
	
	$sql = "select sucurs,ip_local,server,odbc
			from stmconfig_digital
			where odbc != 'no'
			and sucurs = '$suc' ";
	
	$this->conexion->consultar($sql);

  if ($this->flag) {
   $datosOdbc = $this->conexion->getDatosOdbc();
   $datosResultado = $datosOdbc->getAllRegistros();
  }else{
   $datosResultado = $this->conexion->registro;
  }
  
  reset($datosResultado);
   while ($reg = current($datosResultado)) {
    next($datosResultado); 
	
	$ip = trim($reg['ip_local']);
	$server = trim($reg['server']);
	$odbc = trim($reg['odbc']);
	
	$this->arrDatosConexion['ip'] = $ip;
	$this->arrDatosConexion['server'] = $server;
	$this->arrDatosConexion['odbc'] = $odbc;
	
   }
   
   if(count($datosResultado) <= 0){
		$this->arrDatosConexion['ip'] = "192.168.100.1";
		$this->arrDatosConexion['server'] = "ibg";
		$this->arrDatosConexion['odbc'] = "ifxibgdir";
   }
   
   return $this->arrDatosConexion;
   
  }
  
  
  /**
  * metodo copiado del actual. hace exactamente lo mismo.. no tiene la logina de cedula y cargo
  */
  
 public function tipoDeConsulta($cargo = 0, $cedula = 0) {

  if (isset($this->arrRegIntraSuc[$this->sucRegRequest])) {
   $retorno->tipo = 'R';
   $retorno->valor = $this->arrRegIntraSuc[$this->sucRegRequest]['codreg'];
  } elseif (isset($this->arrSucReg[$this->sucRegRequest])) {
   $retorno->tipo = 'S';
   $retorno->valor = $this->arrSucReg[$this->sucRegRequest]['codsuc'];
  } elseif ($this->tipoSession == 'C') {
   $retorno->tipo = 'C';
   $retorno->valor = 0;
  }

  return $retorno;
 }
 
/**
 * Retorna el el dato de la sucursal
 * los posibles valores son: codsuc - nomsuc - codreg - nomreg - codreg_intra
 * si la suc es null consulta la suc del constructor
 */
 public function getDatosSuc($valor, $suc = null) {
  if (!isset($suc)) {
   $suc = $this->sucRegRequest;
  }
  
  if (isset($this->arrSucReg[$suc])) {
   return $this->arrSucReg[$suc][$valor];
  } else {
   return 'No encontrada';
  }
 }

 public function getDatosReg($valor, $reg = null) {
  if (!isset($reg)) {
   $reg = $this->sucRegRequest;
  }

  if (isset($this->arrRegSuc[$reg])) {
   return $this->arrRegSuc[$reg][$valor];
  } else {
   return 'No encontrada';
  }
 }

 public function getDatosReg_Intra($valor, $reg = null) {
  if (!isset($reg)) {
   $reg = $this->sucRegRequest;
  }
  if (isset($this->arrRegIntraSuc[$reg])) {
   return $this->arrRegIntraSuc[$reg][$valor];
  } else {
   return 'No encontrada';
  }
 }

 public function getArrSucReg() {
  return $this->arrSucReg;
 }

 public function getArrRegSuc() {
  return $this->arrRegSuc;
 }

 public function getArrRegIntraSuc() {
  return $this->arrRegIntraSuc;
 }

}

?>
