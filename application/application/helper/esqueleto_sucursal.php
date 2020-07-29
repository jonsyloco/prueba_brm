<?php

/**
 * Crea el esquema de la tabla sucursal y regional (Como lo hace el modeloBase de V4),
 * @param String $tipo son de 3 tipos: C, R, S
 * @param String $suc el codigo de la sucursal
 * @param String $no_reg codigo de la region
 * @param object $mi_modelo recibe un modelo ya instanciado desde el controlador para poder tener acceso a los metodos que consultan la bd
 * @param Boolean $simulador el simulador que posee el odbc no funciona con consultas multiples, por lo cual se creo uno especifico para este metodo
 *                           y funciona igual
 * @param String $nomSimulador el nombre por defecto que tendra el nombre de la consulta en session
 */
function crearEsqueletoSuc($tipo, $suc, $no_reg = '', $mi_modelo, $simulador = FALSE, $nomSimulador = 'crearEsqueletoSuc') {

  if ($simulador === TRUE) {
    @session_start();
    if (@$_SESSION['simulador_' . $nomSimulador] == '') {
      $arreglo = getEsqueletoSuc($tipo, $suc, $no_reg, $mi_modelo);
      $cadena = json_encode($arreglo);
      $_SESSION['simulador_' . $nomSimulador] = trim($cadena);
    } else {
      $fichero = $_SESSION['simulador_' . $nomSimulador];
      $arreglo = json_decode(trim($fichero));
    }
    return $arreglo;
  }

  return getEsqueletoSuc($tipo, $suc, $no_reg, $mi_modelo);
}

// ------------------------------------------------------------------------

function getEsqueletoSuc($tipo, $suc, $no_reg = '', $mi_modelo) {
  $tituloT->codigo->valor = "C&oacute;digo";
  $tituloT->nombre->valor = "Descripci&oacute;n";

  $cond_no_suc = '';
  $cond_no_reg = '';

  if (trim($no_reg) != "") {
    $cond_no_reg = "and codigo not in ($no_reg)";
    $cond_no_suc = "and codregion not in ($no_reg)";
  }

  if ($tipo == 'C') {
    $consulta = "
          select trunc(codigo) as codsuc, nombre as nomsuc, codregion
          from sucursales
          where estado = 'A'
            and codregion > 0
            $cond_no_suc
          order by 3,1
          ";
    $mi_modelo->consultar($consulta);
    //$this->verDatos ();
    while ($registro = $mi_modelo->getDatosOdbc()->getRegistro()) {
      $codSuc = trim($registro['codsuc']);
      $nomSuc = minusculas($registro['nomsuc']);
      $codRegion = trim($registro['codregion']);

      $arreglo->$codRegion->titulo = $tituloT;

      $arreglo->$codRegion->$codSuc->codigo->valor = $codSuc;
      $idFila = "idFila" . $codRegion;
      $arreglo->$codRegion->$codSuc->codigo->idfila = $idFila;
      $arreglo->$codRegion->$codSuc->nombre->valor = $nomSuc;

      $sucursal->$codSuc->codSuc = $codSuc;
      $sucursal->$codSuc->nomSuc = $nomSuc;
      $sucursal->$codSuc->codRegion = $codRegion;
    }
    $arreglo->total->titulo = $tituloT;
    $arreglo->total->total->codigo->valor = "-";
    $arreglo->total->total->nombre->valor = "Compa&ntilde;ia";
    //echo "Compa&ntilde;ia";
    $consulta = "
          select nombre, codigo
          from regionales
          where codigo > 0
          $cond_no_reg
          order by 2
          ";
    $mi_modelo->consultar($consulta);
    //$this->verDatos ();
    while ($registro = $mi_modelo->getDatosOdbc()->getRegistro()) {
      $codRegion = trim($registro['codigo']);
      $nomRegion = minusculas($registro['nombre']);

      $arreglo->$codRegion->titulo = $tituloT;
      $arreglo->$codRegion->total->codigo->valor = $codRegion;
      $idFila = "idFila" . $codRegion;
      $classImgFila = "classImgFila" . $codRegion;
      $arreglo->$codRegion->total->codigo->enlace = "javascript:guiaClase('$idFila','$classImgFila');";
      $arreglo->$codRegion->total->codigo->prefijo = "<img class=\"$classImgFila\" src=\"img/contraer.gif\" width=\"10\" height=\"10\" border=\"0\" />&nbsp;";
      $arreglo->$codRegion->total->nombre->valor = $nomRegion;
    }
  } else if ($tipo == 'R') {
    //echo "Regional";
    if ($suc > 90) {
      $consulta = "
            select nombre, codigo
            from regionales
            where cod_intranet = $suc
            $cond_no_reg
            order by 1
            ";
    } else {
      $consulta = "
            select nombre, codigo
            from regionales
            where codigo = $suc
            $cond_no_reg
            order by 1
            ";
    }
    $mi_modelo->consultar($consulta);

    while ($registro = $mi_modelo->getDatosOdbc()->getRegistro()) {
      $codRegion = trim($registro['codigo']);
      $nomRegion = minusculas($registro['nombre']);

      $arreglo->$codRegion->titulo = $tituloT;
      $arreglo->$codRegion->total->codigo->valor = $codRegion;
      $idFila = "idFila" . $codRegion;
      $classImgFila = "classImgFila" . $codRegion;
      $arreglo->$codRegion->total->codigo->enlace = "javascript:guiaClase('$idFila','$classImgFila');";
      $arreglo->$codRegion->total->codigo->prefijo = "<img class=\"$classImgFila\" src=\"img/contraer.gif\" width=\"10\" height=\"10\" border=\"0\" />&nbsp;";
      $arreglo->$codRegion->total->nombre->valor = $nomRegion;
    }
    $consulta = "
          select trunc(codigo) as codsuc, nombre as nomsuc
          from sucursales
          where estado = 'A'
            and codregion = $codRegion
            $cond_no_suc
          order by 1
          ";
    $mi_modelo->consultar($consulta);
    //$this->verDatos ();
    while ($registro = $mi_modelo->getDatosOdbc()->getRegistro()) {
      $codSuc = trim($registro['codsuc']);
      $nomSuc = minusculas($registro['nomsuc']);

      $arreglo->$codRegion->$codSuc->codigo->valor = $codSuc;
      $idFila = "idFila" . $codRegion;
      $arreglo->$codRegion->$codSuc->codigo->idfila = $idFila;
      $arreglo->$codRegion->$codSuc->nombre->valor = $nomSuc;

      $sucursal->$codSuc->codSuc = $codSuc;
      $sucursal->$codSuc->nomSuc = $nomSuc;
      $sucursal->$codSuc->codRegion = $codRegion;
      $sucursal->$codSuc->nomRegion = $nomRegion;
    }
  } else if ($tipo == 'S') {
    $consulta = "
          select trunc(codigo) as codsuc, nombre as nomsuc, codregion
          from sucursales
          where codigo = $suc
          $cond_no_suc
          order by 1
          ";
    //echo "<pre>$consulta</pre>";
    $mi_modelo->consultar($consulta);
    //$this->verDatos ();
    while ($registro = $mi_modelo->getDatosOdbc()->getRegistro()) {
      $codSuc = trim($registro['codsuc']);
      $nomSuc = minusculas($registro['nomsuc']);
      $codRegion = trim($registro['codregion']);

      $arreglo->$codRegion->titulo = $tituloT;
      $arreglo->$codRegion->$codSuc->codigo->valor = $codSuc;
      $arreglo->$codRegion->$codSuc->nombre->valor = $nomSuc;

      $sucursal->$codSuc->codSuc = $codSuc;
      $sucursal->$codSuc->nomSuc = $nomSuc;
      $sucursal->$codSuc->codRegion = $codRegion;
      //$sucursal->$codSuc->nomRegion = $nomRegion;
    }
  } else {
    exit("Incorrecto!!!");
  }
  //echo "$suc";
  $retorno->arreglo = $arreglo;
  $retorno->sucursal = $sucursal;
  return $retorno;
}

// ------------------------------------------------------------------------

function minusculas($cadena, $remplazar = true) {

  $cadenaAscii = '';
  $cadena = trim(ucwords(strtolower($cadena)));

  for ($l = 0; $l < strlen($cadena); $l++) {
    $cat = ord($cadena[$l]);
    $cadenaAscii .= "($cat)";
    if ($cat == 224) {
      $cadena[$l] = "o";
    }
    if ($cat == 165) {
      $cadena[$l] = "n";
    }
    if ($cat == 162) {
      $cadena[$l] = "o";
    }
    if ($cat == 161) {
      $cadena[$l] = "i";
    }
    if ($cat == 227) {
      $cadena[$l] = "_";
    }
  }

  $cadena = str_replace("_", "", $cadena);
  $cadena = trim(ucwords(strtolower($cadena)));

  if ($remplazar) {
    $cadena = ereg_replace('[áàâãª]', '&aacute;', $cadena);
    $cadena = ereg_replace("[�?ÀÂÃ]", "&Aacute;", $cadena);
    $cadena = ereg_replace("[�?ÌÎ]", "&Iacute;", $cadena);
    $cadena = ereg_replace("[íìî]", "&iacute;", $cadena);
    $cadena = ereg_replace("[éèê]", "&eacute;", $cadena);
    $cadena = ereg_replace("[ÉÈÊ]", "&Eacute;", $cadena);
    $cadena = ereg_replace("[óòôõº]", "&oacute;", $cadena);
    $cadena = ereg_replace("[ÓÒÔÕ]", "&Oacute;", $cadena);
    $cadena = ereg_replace("[úùû]", "&uacute;", $cadena);
    $cadena = ereg_replace("[ÚÙÛ]", "&Uacute;", $cadena);
    $cadena = ereg_replace("[ñ¥¤]", "&ntilde;", $cadena);
    $cadena = ereg_replace("[Ñ]", "&Ntilde;", $cadena);
    $cadena = str_replace("ç", "c", $cadena);
    $cadena = str_replace("Ç", "C", $cadena);
    $cadena = str_replace('à', '&oacute;', $cadena);
    $cadena = str_replace("\"", "&quot;", $cadena);

    $cadena = ereg_replace("[����]", "&aacute;", $cadena);
    $cadena = ereg_replace("[����]", "&Aacute;", $cadena);
    $cadena = ereg_replace("[���]", "&Iacute;", $cadena);
    $cadena = ereg_replace("[���]", "&iacute;", $cadena);
    $cadena = ereg_replace("[���]", "&eacute;", $cadena);
    $cadena = ereg_replace("[���]", "&Eacute;", $cadena);
    $cadena = ereg_replace("[�����]", "&oacute;", $cadena);
    $cadena = ereg_replace("[����]", "&Oacute;", $cadena);
    $cadena = ereg_replace("[���]", "&uacute;", $cadena);
    $cadena = ereg_replace("[���]", "&Uacute;", $cadena);
    $cadena = ereg_replace("[�]", "&ntilde;", $cadena);
    $cadena = ereg_replace("[�]", "&Ntilde;", $cadena);
    $cadena = str_replace("�", "c", $cadena);
    $cadena = str_replace("�", "C", $cadena);
    $cadena = str_replace("ò", "o", $cadena);
    $cadena = str_replace("\"", "&quot;", $cadena);
    $cadena = utf8_decode($cadena);
  }
  //Eliminar espacios repetidos
  while (substr_count($cadena, "  ") > 0) {
    $cadena = str_replace("  ", " ", $cadena);
  }
  return $cadena;
}

?>