<?php

/**
 * Función que toma por parámetro la cadena entrante  y retorna una nueva cadena
 * reemplazando caracteres como eñes y vocales en mayuscula y con tilde encontrados en la cadena de entrada.
 * @param String $cadena es la cadena de entrada.
 * @return String una nueva cadena con caracteres compatibles con el formato HTML
 * para eñes y vocales con tilde.
 */
function formatearCadena($cadena) {
    /* $array_entrada = array('&ntilde;', '&Ntilde;', '&aacute;', '&Aacute;', '&eacute;', '&Eacute;', '&iacute;', '&Iacute;', '&oacute;', '&Oacute;', '&uacute;', '&Uacute;', '&AMP;');
      $array_replace = array('ñ', 'Ñ', 'á', 'Á', 'é', 'É', 'í', 'Í', 'ó', 'Ó', 'ú', 'Ú', '&');
      return str_replace($array_entrada, $array_replace, htmlentities($cadena)); */

    $reg = '';
    for ($l = 0; $l < strlen($cadena); $l++) {
        $cat = ord($cadena[$l]);
        //printConsole($cadena[$l]."  - cod: $cat");
        if ($cat == 193)// Caracer Á
            $reg.= "&Aacute;";
        elseif ($cat == 225)// Caracer á
            $reg.= "&aacute;";
        elseif ($cat == 201)// Caracer É
            $reg.= "&Eacute;";
        elseif ($cat == 233)// Caracer é
            $reg.= "&eacute;";
        elseif ($cat == 205)// Caracer Í
            $reg.= "&Iacute;";
        elseif ($cat == 237)// Caracer í
            $reg.= "&iacute;";
        elseif ($cat == 211)// Caracer Ó
            $reg.= "&Oacute;";
        elseif ($cat == 243)// Caracer ó
            $reg.= "&oacute;";
        elseif ($cat == 218)// Caracer Ú
            $reg.= "&Uacute;";
        elseif ($cat == 250)// Caracer ú
            $reg.= "&uacute;";
        elseif ($cat == 209)// Caracer Ñ
            $reg.= "&Ntilde;";
        elseif ($cat == 241)// Caracer ñ
            $reg.= "&ntilde;";
        elseif ($cat == 160)// Caracer desconocido
            $reg.= "";
        elseif ($cat == 186)// Semicolon
            $reg.= "°";
        else
            $reg .= $cadena[$l];
    }
    return $reg;
}

/**
 * Función que reemplaza todas las posibles vocales con tilde,
 * eñes, simbolos especiales entre otros en vocales sin tilde
 * y en mayúsculas, enes mayúsculas y en espacio para cada caracter
 * correspondientemente.
 */
function reemplazarAcentos($cadena) {
    $aes = array('à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä');
    $cadena = str_replace($aes, "á", $cadena);

    $ees = array('è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë');
    $cadena = str_replace($ees, "é", $cadena);

    $ies = array('ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î');
    $cadena = str_replace($ies, "í", $cadena);

    $oes = array('ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô');
    $cadena = str_replace($oes, "ó", $cadena);

    $ues = array('ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü');
    $cadena = str_replace($ues, "ú", $cadena);

    $enies = array('Ñ', 'ç', 'Ç');
    $cadena = str_replace($enies, "ñ", $cadena);

    $caracteres = array("\\", "¨", "·", "`", "¨", "´", "°", "'", "\"");
    $cadena = str_replace($caracteres, "", $cadena);

    //$cadena = utf8_encode($cadena);

    return $cadena;
}

function formatearFecha($fecha) {
    if (trim($fecha) != '') {
        $n1 = substr($fecha, 0, 2);
        $n2 = substr($fecha, 3, 2);
        $anio = substr($fecha, 6);

        $fecDecode = "$n2/$n1/$anio";
        return $fecDecode;
    } else {
        return $fecha;
    }
}

/**
 * Funcion que busca y elimina dentro del directorio indicado por parámetro
 * todos los archivos existentes, incluido el direcotrio.
 * 
 * Si no se especifica el directorio, busca dentro del directorio de archivos (raiz)
 * los que esten vacios y los elimina.
 * 
 * @param string $directorio es el nombre del directorio que se desea eliminar.
 * @return boolean <code>true</code> si fué posible borrar el directorio con todo
 * su contenido.
 */
function eliminarDirectorioTemporal($directorio = '') {

    if ($directorio == '') {
        $ruta = DIR_ARCHIVOS;
        foreach (glob($ruta . '/*') as $archivos_carpeta) {
            $carpeta = @scandir($archivos_carpeta);
            if (count($carpeta) <= 2) {  // directorio vacio
                @rmdir($archivos_carpeta);
            }
        }
    } else {
        $ruta = DIR_ARCHIVOS . $directorio;
        foreach (glob($ruta . '/*') as $archivos_carpeta) {
            unlink($archivos_carpeta);
        }
        @rmdir($ruta);
    }
    return true;
}

/**
 * Función que elimina el fichero 
 * que se encuentra en la ruta ingresada por parámetro
 * @param type $ruta es la ruta del archivo a eliminar.
 */
function eliminarFichero($ruta) {
    @unlink($ruta);
}

function salir() {
    echo "<br/><br/><br/><div align='center'><h2>Acceso no autorizado</h2></div><script>alert('Accceso no autorizado');</script>";
    printConsole("Sin Acceso");
    printConsole($_SESSION);
    //session_write_close();
    //session_destroy();
}

function printConsole($element, $indice = '') {
    echo "<script>";
    if ($indice != '') {
        echo "console.log('> > > " . $indice . "');";
    }
    echo "console.log(" . json_encode($element) . ");</script>";
}

/**
 * @autor: jhonatan wagner 
 * @descripcion: funcion sencilla que encripta en base 64
 * @param type $string
 * @param type $key
 * @return cadena encriptada
 */
function encrypt($string, $key) {
    $result = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) + ord($keychar));
        $result.=$char;
    }

    return urlencode(base64_encode($result));
}

/**
 * @autor: jhonatan wagner ocampo 
 * @descripcion: funcion sencilla que desencripta
 * @param type $string
 * @param type $key
 * @return cadena limpia
 */
function decrypt($string, $key) {
    $string = urldecode($string);
    $result = '';
    $string = base64_decode($string);
    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) - ord($keychar));
        $result.=$char;
    }
    return $result;
}

function strToHex($string) {
    $hex = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $ord = ord($string[$i]);
        $hexCode = dechex($ord);
        $hex .= substr('0' . $hexCode, -2);
    }
    return strToUpper($hex);
}

function hexToStr($hex) {
    $string = '';
    for ($i = 0; $i < strlen($hex) - 1; $i+=2) {
        $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
    }
    return $string;
}

/**
 * Reemplaza todos los acentos por sus equivalentes sin ellos
 *
 * @param $string
 *  string la cadena a sanear
 *
 * @return $string
 *  string saneada
 */
function limpiarCadena($string) {

    $string = trim($string);

    $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string
    );

    $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string
    );

    $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string
    );

    $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string
    );

    $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string
    );

    $string = str_replace(
            array("ñ", "Ñ", "ç", "Ç"), array('n', 'N', 'c', 'C'), $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
//    $string = str_replace(array("", "¨", "º", "-", "~", "#", "@", "|", "!", '"', "·", "$", "%", "&", "/", "(", ")", "?", "'", "¡","¿", "[", "^", "<code>", "]","+", "}", "{", "¨", "´",">", "< ", ";", ",", ":",".", " "),'', $string );
    $string = str_replace(array("\\", "¨", "º", "-", "~", "#", "@", "|", "!", '"', "·", "$", "%", "&", "/", "?", "'", "¡", "¿", "[", "^", "<code>", "]", "+", "}", "{", "¨", "´", ">", "< ", ";", ":"), '', $string);
    $string = strtoupper($string);

    return $string;
}
Function verVariable ( $variable, $msj='->' )
    {
    echo '<hr><textarea cols=80 rows=25>' . $msj . ': ';
    var_dump ($variable);
    echo '</textarea><hr>';
    }
    
  function cargando()
    {
    echo
      "
      <div id='waitDiv' style='position:absolute;left:44%;top:20%;visibility:hidden'>      
      <center>
      <img src='../../img/cargando.gif' border='0'> <br>      
      <font color='#002200' face='Verdana' size='4'>
        <label id='labelCargando' name='labelCargando'>
          Cargando Datos...
        </label>
      </font>
      </center>
      </div>
      <script type='text/javascript' src='../../js/cargando.js'></script>
      ";
    for ($i = 0; $i < 1000; $i++) {
      echo "          ";
    }
    refrescar();
    }

  function cargando2()
    {
    echo
      "
      <div id='waitDivv' style='position:absolute;left:36%;top:50%;visibility:hidden'>
      <center>
      <img src='../../img/cargando.gif' border='0'> <br> <font color='#002200' face='Verdana' size='4'>Cargando Series Sin Factura De Compra...</font>
      </center>
      </div>
      <script type='text/javascript' src='../../js/cargando2.js'></script>
      ";
    refrescar();
    }

  function cargandopeq()
    {
    echo
      "
      <div id='waitDiv' style='position:absolute;left:20%;top:5%;visibility:hidden'>      
      <center>
      <img src='../../img/cargando.gif' border='0'> <br>      
      <font color='#002200' face='Verdana' size='2'>
        <label id='labelCargando' name='labelCargando'>
          Procesando Informacion...
        </label>
      </font>
      </center>
      </div>
      <script type='text/javascript' src='../../js/cargando.js'></script>
      ";
    refrescar();
    }

    
  function refrescar()
    {
    ob_implicit_flush();
    ob_flush();
    flush();
    }
    
  Function nombreMes ( $mesact,$largo=false )
    {
    if ($largo)
      {
      if ($mesact == 1)
      return "Enero";
      if ($mesact == 2)
      return "Febrero";
      if ($mesact == 3)
      return "Marzo";
      if ($mesact == 4)
      return "Abril";
      if ($mesact == 5)
      return "Mayo";
      if ($mesact == 6)
      return "Junio";
      if ($mesact == 7)
      return "Julio";
      if ($mesact == 8)
      return "Agosto";
      if ($mesact == 9)
      return "Septiembre";
      if ($mesact == 10)
      return "Octubre";
      if ($mesact == 11)
      return "Noviembre";
      if ($mesact == 12)
      return "Diciembre";
      }
    else
      {
      if ($mesact == 1)
      return "Ene";
      if ($mesact == 2)
      return "Feb";
      if ($mesact == 3)
      return "Mar";
      if ($mesact == 4)
      return "Abr";
      if ($mesact == 5)
      return "May";
      if ($mesact == 6)
      return "Jun";
      if ($mesact == 7)
      return "Jul";
      if ($mesact == 8)
      return "Ago";
      if ($mesact == 9)
      return "Sep";
      if ($mesact == 10)
      return "Oct";
      if ($mesact == 11)
      return "Nov";
      if ($mesact == 12)
      return "Dic";
      }
    }

  function traeNomSuc($codigo)
    {
    $con1 = new Odbc('ifxibgdir','','');
    $consulta =
      "
      select nombre
      from sucursales
      where codigo = '$codigo'
      ";
    $con1->consultar ($consulta);
    while ($registro = $con1->getRegistro())
      {
      $nombre = trim (minusculas($registro['nombre']));
      }
    return $nombre;
    }


Function obtenerNumero ($cadena)
 {
 $cadena = trim($cadena);
 $tmp = str_replace ( '.', '', $cadena );
 $tmp = str_replace ( ',', '.', $tmp );
 return $tmp;
 }
 
Function formatear ( $valor, $decimales=0, $divisor=1, $carDecimales=',', $carMiles='.' )
 {
 $valort = number_format($valor/$divisor,$decimales,$carDecimales,$carMiles);
 return $valort;
 }
 
Function formatear1 ( $valor, $decimales, $divisor, $car='.' )
 {
 $valort = number_format($valor/$divisor,$decimales,"$car",",");
 return $valort;
 }
 
Function redondear ( $valor, $divisor )
 {
 $valort = number_format($valor/$divisor,0,"","");
 return $valort;
 }
 
Function minusculas ( $cadena, $remplazar=true )
 {
 $cadena = trim(ucwords(strtolower($cadena)));
  
  for($l=0;$l<strlen($cadena);$l++) {
    $cat = ord($cadena[$l]);
    $cadenaAscii .= "($cat)";
    if( $cat == 224) {  $cadena[$l] = "o";}
    if( $cat == 165) {  $cadena[$l] = "n";}
    if( $cat == 162) {  $cadena[$l] = "o";}
    if( $cat == 161) {  $cadena[$l] = "i";}    
    if( $cat == 227) {  $cadena[$l] = "_";}    
    }
  
  $cadena = str_replace("_", "", $cadena);
  $cadena = trim(ucwords(strtolower($cadena)));
  
 if ($remplazar)
  {
  $cadena = ereg_replace('[Ã¡Ã Ã¢Ã£Âª]','&aacute;',$cadena);
  $cadena = ereg_replace("[Ã?Ã€Ã‚Ãƒ]","&Aacute;",$cadena);
  $cadena = ereg_replace("[Ã?ÃŒÃŽ]","&Iacute;",$cadena);
  $cadena = ereg_replace("[Ã­Ã¬Ã®]","&iacute;",$cadena);
  $cadena = ereg_replace("[Ã©Ã¨Ãª]","&eacute;",$cadena);
  $cadena = ereg_replace("[Ã‰ÃˆÃŠ]","&Eacute;",$cadena);
  $cadena = ereg_replace("[Ã³Ã²Ã´ÃµÂº]","&oacute;",$cadena);
  $cadena = ereg_replace("[Ã“Ã’Ã”Ã•]","&Oacute;",$cadena);
  $cadena = ereg_replace("[ÃºÃ¹Ã»]","&uacute;",$cadena);
  $cadena = ereg_replace("[ÃšÃ™Ã›]","&Uacute;",$cadena);
  $cadena = ereg_replace("[Ã±Â¥Â¤]","&ntilde;",$cadena);
  $cadena = ereg_replace("[Ã‘]","&Ntilde;",$cadena);
  $cadena = str_replace("Ã§","c",$cadena);
  $cadena = str_replace("Ã‡","C",$cadena);
  $cadena = str_replace('Ã ','&oacute;',$cadena);
  $cadena = str_replace("\"","&quot;",$cadena);
  
  $cadena = ereg_replace("[áàâãª]","&aacute;",$cadena);
  $cadena = ereg_replace("[ÁÀÂÃ]","&Aacute;",$cadena);
  $cadena = ereg_replace("[ÍÌÎ]","&Iacute;",$cadena);
  $cadena = ereg_replace("[íìî]","&iacute;",$cadena);
  $cadena = ereg_replace("[éèê]","&eacute;",$cadena);
  $cadena = ereg_replace("[ÉÈÊ]","&Eacute;",$cadena);
  $cadena = ereg_replace("[óòôõº]","&oacute;",$cadena);
  $cadena = ereg_replace("[ÓÒÔÕ]","&Oacute;",$cadena);
  $cadena = ereg_replace("[úùû]","&uacute;",$cadena);
  $cadena = ereg_replace("[ÚÙÛ]","&Uacute;",$cadena);
  $cadena = ereg_replace("[ñ¥¤]","&ntilde;",$cadena);
  $cadena = ereg_replace("[Ñ]","&Ntilde;",$cadena);
  $cadena = str_replace("ç","c",$cadena);
  $cadena = str_replace("Ç","C",$cadena);
  $cadena = str_replace("\"","&quot;",$cadena);
  $cadena = utf8_decode($cadena);
  }
 return $cadena;
 }
 
Function maxDia ( $mes, $anio)
 {
 if ($anio % 4 == 0)//año bisiesto
  $ultimodia = array (0,31,29,31,30,31,30,31,31,30,31,30,31);
 else
  $ultimodia = array (0,31,28,31,30,31,30,31,31,30,31,30,31);
  
 $mestmp = $mes + 0;
 $maxdia = $ultimodia [$mestmp];
 return $maxdia;
 }
 
  function traeMaxDiaOE ()
    {
    $con1 = new Odbc('ifxibgdir','','');
    $consulta =
      "
      select day (fechaoe) as dia
      from sucursales
      where codigo = 1
      ";
    $con1->consultar ($consulta);
    while ($registro = $con1->getRegistro())
      {
      $dia = trim ($registro[dia]);
      }
    return $dia;
    }
    
  function traeFechaOE ()
    {
    $con1 = new Odbc('ifxibgdir','','');
    $consulta =
      "
      select to_char (fechaoe) as fecha
      from sucursales
      where codigo = 1
      ";
    $con1->consultar ($consulta);
    while ($registro = $con1->getRegistro())
      {
      $fecha = trim ($registro[fecha]);
      }
    return $fecha;
    }
    
  function traeFechaAPR ()
    {
    $con1 = new Odbc('ifxibgdir','','');
    $consulta =
      "
      select to_char (fechaapr) as fecha
      from sucursales
      where codigo = 1
      ";
    $con1->consultar ($consulta);
    while ($registro = $con1->getRegistro())
      {
      $fecha = trim ($registro[fecha]);
      }
    return $fecha;
    }
    
  function traeFechaPOP ()
    {
    $con1 = new Odbc('ifxibgdir','','');
    $consulta =
      "
      select to_char (fechapop) as fecha
      from sucursales
      where codigo = 1
      ";
    $con1->consultar ($consulta);
    while ($registro = $con1->getRegistro())
      {
      $fecha = trim ($registro[fecha]);
      }
    return $fecha;
    }
    
Function domingos ( $diaact, $mes, $anio)
 {
 //$maxdia = maxDia ( $mes, $anio);
 $maxdia = traeMaxDiaOE ();
 $van   = 0;
 $total = 0;
 for ($dia = 1; $dia <= $maxdia; $dia ++)
  {
  $ndia = nombreDia ($dia, $mes, $anio);
  if ($ndia == 'Dom')
   {
   $total ++;  
   if ($dia <= $diaact)
    $van ++;
   }
  }
 $domingos->van = $van;
 $domingos->total = $total;
 return $domingos;
 }
 
Function diaHabil ( $dia, $mes, $anio)
  {
  $con1 = new Odbc('ifxibgdir','','');
  $consulta = 
    "
    select dia
    from dias_hab
    where fecha = '$mes/$dia/$anio'
    ";  
  $con1->consultar ($consulta);
  $dia = 0;
  while ($registro = $con1->getRegistro())
    {
    $dia = trim ($registro[dia]);
    }
  return $dia;
  }
  
Function nombreDia ( $dia, $mes, $anio,$largo=false)
  {
  $tiempo = mktime(0,0,0,$mes,$dia,$anio); 
  $ndia = date('D',$tiempo);
  if (!$largo)
    {
    $semana = array(
      "Mon" => "Lun", 
      "Tue" => "Mar", 
      "Wed" => "Mie", 
      "Thu" => "Jue", 
      "Fri" => "Vie", 
      "Sat" => "Sáb", 
      "Sun" => "Dom", 
      );
    }  
  else
    {
    $semana = array(
      "Mon" => "Lunes", 
      "Tue" => "Martes", 
      "Wed" => "Miercoles", 
      "Thu" => "Jueves", 
      "Fri" => "Viernes", 
      "Sat" => "Sábado", 
      "Sun" => "Domingo", 
      );
    }  
  $ndia = $semana [$ndia];
  return $ndia;
  }
 

 
 
 
Function borrarArchivos($path,$match)
 {
   $dirs = glob($path."*");
   $files = glob($path.$match);
   foreach($files as $file){
      if(is_file($file)){          
         @unlink($file);
      }
   }
   foreach($dirs as $dir){
      if(is_dir($dir)){
         $dir = basename($dir) . "/";
         borrarArchivos($path.$dir,$match);
      }
   }
 } 

Function creaArchivo ( $nombre, $datos )
 {
 //resaltar filas y columnas
 $max_i = sizeof($datos);
 $max_j = sizeof($datos[0]);
 $f=fopen("$nombre", "wt");
 for ($i = 0;$i < $max_i; $i++)
  {
  $val = $datos[$i][0];
  $linea = "\"$val\"";
  for ($j = 1;$j < $max_j; $j++)
   {
   $val = $datos[$i][$j];
   $linea = $linea.",\"$val\"";
   }
  $linea = $linea."\n";
  fwrite($f, $linea);
  }
 fclose($f);
 echo "
      <a href='$nombre' class='boton'>-Descargar Hoja de Cálculo-</a>
      ";
 }
 
Function tiempo ( $mensaje )
 {
  date_default_timezone_set("America/Bogota"); $fecha = time();
  $hora = date ( 'H' , $fecha );
  $minu = date ( 'i' , $fecha );
  $segu = date ( 's' , $fecha );
  echo "$mensaje ($hora:$minu:$segu)<hr>";
 }
 
 function retornaTabla ($tablaArr, $repetirTitulo=false, $tituloT='', $widthT='', $idT='tablaPrincipal')
  {
    $i = 0;
    /*
    echo "
    <script language='javascript'>
      tabla = document.getElementById('tablaPrincipal');
      padre = tabla.parentNode;
      padre.removeChild(tabla);
    </script>
      ";
      */
  	$retornar .= '<center>
  	';
  	$retornar .= '<table border=0 width="' . $widthT . '" class="visible" id="' . $idT . '" name="' . $idT . '">
  	';
    @reset ($tablaArr);

    while ($tabla = @current($tablaArr))
      {
      @reset ($tabla);
      $fila = @current($tabla);
      @reset($fila);
      unset ($campos);
      while ($registro = @current($fila))
        {
        $campo = key($fila);
    	  $campos->$campo = $campo;
        @next ($fila);
        }
      @reset ($tabla);
      if ($i > 0 && !$repetirTitulo)
        {
        @next ($tabla);
        }
      else
        {
        $retornar .= $tituloT;
        }
      $i ++;

      while ($fila = @current($tabla))
        {
       $confila=0;
    	  @reset($campos);
		  while ($campo = @current($campos))
          {
		  if($confila==0){
  		  $id= $fila->$campo->idfila;
		   if($fila->$campo->resaltar)
		     $eventos='onClick="mouse(this);" onDblClick="quitamouse(this)"';
		   
		   $retornar .= '<tr id="'.$id.'" name="'.$id.'" '.$eventos.' >';
           $confila=1;
		  }
		   
          if (isset($fila->$campo->valor))
            {
        	  if (isset($fila->$campo->titulo))
        	    {
          	  $tittem = substr ($fila->$campo->titulo,0,1);
          	  if ($tittem == '|')
          	    {
          	    $fila->$campo->titulo = str_replace ('|', '', $fila->$campo->titulo);
          	    $retornar .= '<td id="' . $campo .  '" name="' . $campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\\\'' . $fila->$campo->titulo . '\\\', SHADOW, true, STICKY, true, CLICKCLOSE, true)">
              	  ';
          	    }
          	  else
          	    {
          	    $retornar .= '<td id="' . $campo .  '" name="' . $campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\\\'' . $fila->$campo->titulo . '\\\', SHADOW, true)">
              	  ';
          	    }
        	    }
        	  else
        	    {
        	    $retornar .= '<td id="' . $campo .  '" name="' . $campo . '" class="' . $fila->$campo->clase . '">
          	  ';
        	    }
            }
          else
            {
      	    $retornar .= '<td id="' . $campo .  '" name="' . $campo . '" class="vacio">
        	  ';
            }
      	  if ($fila->$campo->enlace)
      	    {
        	  $fila->$campo->enlace = str_replace ("'", "\'", $fila->$campo->enlace);
      	    $retornar .= '<a rel="sexylightbox" class="' . $fila->$campo->clase . '" href="' . $fila->$campo->enlace . '" target="' . $fila->$campo->target . '">';
      	    }
      	    
      	  if (isset($fila->$campo->prefijo))
      	    {
         	  $retornar .= $fila->$campo->prefijo;
       	    }      	    
        	    
      	  if (isset($fila->$campo->decimales) || isset($fila->$campo->divisor))
      	    {
        	  if (!isset($fila->$campo->decimales))
        	    {
        	    $decimalesT = 0;
        	    }
        	  else
        	    {
        	    $decimalesT = $fila->$campo->decimales;
        	    }
        	  if (!isset($fila->$campo->divisor))
        	    {
        	    $divisorT = 1;
        	    }
        	  else
        	    {
        	    $divisorT = $fila->$campo->divisor;
        	    }
        	  $retornar .= formatear ($fila->$campo->valor,$decimalesT,$divisorT);
      	    }
      	  else
      	    {
        	  $retornar .= $fila->$campo->valor;
      	    }
      	  
      	  if (isset($fila->$campo->sufijo))
      	    {
        	  $retornar .= $fila->$campo->sufijo;
      	    }
      	  
      	  //$retornar .=  '&nbsp';
      	  
      	  if ($fila->$campo->enlace)
      	    {
      	    $retornar .= '</a>';
      	    }
      	  $retornar .= '</td>
      	  ';
          @next ($campos);
          }
    	  $retornar .= '<td></td></tr>
    	  ';
        @next ($tabla);
        }
      @next ($tablaArr);
  	  
	  $retornar .= '<tr id="'.$id.'"><td></td></tr>
  	  ';
   	  }
 	  $retornar .= '</table>
 	  ';
   	$retornar .= '</center>
   	';
   	return $retornar;
    }
    
 /*Crear tabla de datos*/
  function crearTabla ($tablaArr, $repetirTitulo=false, $tituloT='', $widthT='', $idT='tablaPrincipal')
    {
    $i = 0;
    /*
    echo "
    <script language='javascript'>
      tabla = document.getElementById('tablaPrincipal');
      padre = tabla.parentNode;
      padre.removeChild(tabla);
    </script>
      ";
      */
  	echo '<center>
  	';
  	echo '<table border=0 width="' . $widthT . '" class="visible" id="' . $idT . '" name="' . $idT . '">
  	';
    @reset ($tablaArr);

    while ($tabla = @current($tablaArr))
      {
      @reset ($tabla);
      $fila = @current($tabla);
      @reset($fila);
      unset ($campos);
      while ($registro = @current($fila))
        {
        $campo = key($fila);
    	  $campos->$campo = $campo;
        @next ($fila);
        }
      @reset ($tabla);
      if ($i > 0 && !$repetirTitulo)
        {
        @next ($tabla);
        }
      else
        {
        echo $tituloT;
        }
      $i ++;

      while ($fila = @current($tabla))
        {
       $confila=0;
    	  @reset($campos);
		  while ($campo = @current($campos))
          {
		  if($confila==0){
  		  $id= $fila->$campo->idfila;
  		  $clase = $fila->$campo->class_tr;  
  		if($fila->$campo->resaltar)
		     $eventos='onClick="mouse(this);" onDblClick="quitamouse(this)"';
		   if($clase)
		   echo '<tr id="'.$id.'" name="'.$id.'" '.$eventos.' class="'.$clase.'" >';
		   else
		        echo  '<tr id="'.$id.'" name="'.$id.'" '.$eventos.' >';
           $confila=1;
		  }
		   
          if (isset($fila->$campo->valor))
            {
        	  if (isset($fila->$campo->titulo))
        	    {
              if ($fila->$campo->titulo == '#')
                {
                $fila->$campo->titulo = formatear ($fila->$campo->valor);
                }
              else if ($fila->$campo->titulo == '$')
                {
                $fila->$campo->titulo = '$' . formatear ($fila->$campo->valor) . '=';
                }
          	  $tittem = substr ($fila->$campo->titulo,0,1);
          	  if ($tittem == '?')
          	    {
          	    $fila->$campo->titulo = str_replace ('?', '', $fila->$campo->titulo);
          	    echo '<td id="' . $campo .  '" name="' . $campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true, STICKY, true)">
              	  ';
          	    }
          	  else if ($tittem == '|')
          	    {
          	    $fila->$campo->titulo = str_replace ('|', '', $fila->$campo->titulo);
          	    echo '<td id="' . $campo .  '" name="' . $campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true, STICKY, true, CLICKCLOSE, true)">
              	  ';
          	    }
          	  else
          	    {
          	    echo '<td id="' . $campo .  '" name="' . $campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true)">
              	  ';
          	    }
        	    }
        	  else
        	    {
        	    echo '<td id="' . $campo .  '" name="' . $campo . '" class="' . $fila->$campo->clase . '">
          	  ';
        	    }
            }
          else
            {
      	    echo '<td id="' . $campo .  '" name="' . $campo . '" class="vacio">
        	  ';
            }
      	  if ($fila->$campo->enlace)
      	    {
      	    echo '<a class="' . $fila->$campo->clase . '" href="' . $fila->$campo->enlace . '" target="' . $fila->$campo->target . '">';
      	    }
      	    
      	  if (isset($fila->$campo->prefijo))
      	    {
         	  echo $fila->$campo->prefijo;
       	    }      	    
        	    
      	  if (isset($fila->$campo->decimales) || isset($fila->$campo->divisor))
      	    {
        	  if (!isset($fila->$campo->decimales))
        	    {
        	    $decimalesT = 0;
        	    }
        	  else
        	    {
        	    $decimalesT = $fila->$campo->decimales;
        	    }
        	  if (!isset($fila->$campo->divisor))
        	    {
        	    $divisorT = 1;
        	    }
        	  else
        	    {
        	    $divisorT = $fila->$campo->divisor;
        	    }
        	  echo formatear ($fila->$campo->valor,$decimalesT,$divisorT);
      	    }
      	  else
      	    {
        	  echo $fila->$campo->valor;
      	    }
      	  
      	  if (isset($fila->$campo->sufijo))
      	    {
        	  echo $fila->$campo->sufijo;
      	    }
      	  
      	  //echo  '&nbsp';
      	  
      	  if ($fila->$campo->enlace)
      	    {
      	    echo '</a>';
      	    }
      	  echo '</td>
      	  ';
          @next ($campos);
          }
    	  echo '<td></td></tr>
    	  ';
        @next ($tabla);
        }
      @next ($tablaArr);
  	  
	  echo '<tr id="'.$id.'"><td></td></tr>
  	  ';
   	  }
 	  echo '</table>
 	  ';
   	echo '</center>
   	';
   	//sleep(1);
   	refrescar();
    }
	
  /*Crear combo con sucursales vigentes*/
  function crearSelect ($nombre, $valoract, $con, $mostrar, $valor)
    {
    echo '<select name="' . $nombre .'"> ';
	  while ($registro = $con->getRegistro())
	    {
	    $val_mostrar = minusculas ($registro[$mostrar]);
	    $val_valor = $registro[$valor];
	    $selected = '';
	    if ($valoract == $val_valor)
	      {
	      $selected = 'selected';
	      $val_retornar = $val_mostrar;
	      }
      echo '<option value="' . $val_valor . '" ' . $selected . '>' .
        $val_mostrar .
        '</option>
        ';
	    }
    echo '</select>
      ';
    return $val_retornar;
    }
    
  function agregaCampo ($arreglo, $grupo, $registro, $campo, $valor, $clase='', $enlace='', $titulo='', $divisor='', $decimales='', $prefijo='', $sufijo='', $acumula=false, $idfila='',$resaltar='',$ancho='',$idcolumna='',$class_tr='')
    {
    if ($acumula)
      {
      $arreglo->$grupo->$registro->$campo->valor += $valor;
      }
    else
      {
      $arreglo->$grupo->$registro->$campo->valor = $valor;
      //echo "$grupo,$registro,$campo,$valor<hr>";
      }
    if ($clase != '')
      {
      $arreglo->$grupo->$registro->$campo->clase = $clase;
      }
    if ($enlace != '')
      {
      $arreglo->$grupo->$registro->$campo->enlace = $enlace;
      }
    if ($titulo != '')
      {
      $arreglo->$grupo->$registro->$campo->titulo = $titulo;
      }
    if ($divisor != '')
      {
      $arreglo->$grupo->$registro->$campo->divisor = $divisor;
      }
    if ($decimales != '')
      {
      $arreglo->$grupo->$registro->$campo->decimales = $decimales;
      }
    if ($prefijo != '')
      {
      $arreglo->$grupo->$registro->$campo->prefijo = $prefijo;
      }
    if ($sufijo != '')
      {
      $arreglo->$grupo->$registro->$campo->sufijo = $sufijo;
      }
    if($idfila != '')
	 {
     $arreglo->$grupo->$registro->$campo->idfila = $idfila;
	 }
    if($resaltar != '')
	 {
     $arreglo->$grupo->$registro->$campo->resaltar = $resaltar;
	 }
	if($ancho != '')
	 {
     $arreglo->$grupo->$registro->$campo->ancho = $ancho;
	 } 
    if($idcolumna != '')
	 {
     $arreglo->$grupo->$registro->$campo->idcolumna = $idcolumna;
	 }
    if($class_tr != '')
	 {
     $arreglo->$grupo->$registro->$campo->class_tr = $class_tr;
	 }
    return $arreglo;
    }
    
	
  function validarFecha ( $dia, $mes, $anio)
    {
    if ($mes <1 || $mes > 12)
      {
      echo "<h1>Mes $mes Incorrecto!!!</h1>";
      return false;
      }
    $maxdia = maxDia ( $mes, $anio);
    if ($dia <1 || $dia > $maxdia)
      {
      echo "<h1>Día $dia Incorrecto!!! (válido de 1 a $maxdia )</h1>";
      return false;
      }
    return true;
    }
    
  function crearXls ( $tablaArr, $nombre, $mensaje='Descargar Archivo Xls', $reemplazo='' )
    {
    $i = 0;
    @reset ($tablaArr);
    while ($tabla = @current($tablaArr))
      {
      @reset ($tabla);
      $fila = @current($tabla);
      unset ($campos);
      @reset ($fila);
      while ($registro = @current($fila))
        {
        $campo = key($fila);
    	  $campos->$campo = $campo;
        @next ($fila);
        }
      @reset ($tabla);
      //@next ($tabla);//Quitar titulos
      while ($fila = @current($tabla))
        {
        $i ++;
    	  @reset($campos);
        while ($campo = @current($campos))
          {
          if ($fila->$campo->valor == '0')
            {
            $fila->$campo->valor = 0;
            }
          if (isset($fila->$campo->valor))
            {
        	  $arregloXls[$i][$campo] = str_replace ('<br>',' ',$fila->$campo->valor);
        	  if ( is_numeric($arregloXls[$i][$campo]) )
        	    {
          	  $arregloXls[$i][$campo] += 0;
        	    }
            }
          else
            {
        	  $arregloXls[$i][$campo] = $reemplazo;
            }
          @next ($campos);
          }
        $arregloXls[$i]['_'] = '';
        @next ($tabla);
        }
      @next ($tablaArr);
   	  }
   	
    require_once "../../../v2/excel.php";
    $dir = getcwd();
    $dir = str_replace ('\\','/',$dir);
    $dir = strtolower ($dir);
    $dir = str_replace ('c:/','xlsfile://',$dir);
    $archivo = "xls/".$nombre.".xls";
    $export_file = "$dir/$archivo";
    $fp = fopen($export_file, "wb");
    if (!is_resource($fp))
      {
      die("No pudo crear $export_file");
      }
    echo "<center><a href='$archivo'> $mensaje </a></center>";
    fwrite($fp, serialize($arregloXls));
    fclose($fp);
    }

  function crearTabla2 ($tablaArr, $repetirTitulo=false)
    {
    $i = 0;
  	echo '<center>
  	';
  	echo '<table class="visible" id="tablaPrincipal">
  	';
    @reset ($tablaArr);
    while ($tabla = @current($tablaArr))
      {
      $tabla->reset();
      while ($registro = $tabla->getRegistro())
        {
        $registro->reset();
        while ($campo = $registro->getCampo())
          {
          $nombreCampo = $campo->getNombre();
          $campos->$nombreCampo = $nombreCampo;
          }
        }
      $tabla->reset();
      if ($i > 0 && !$repetirTitulo)
        {
        $tabla->getRegistro();//Suprimir primera fila para mas de una tabla
        }
      $i ++;
      while ($registro = $tabla->getRegistro())
        {
    	  echo '<tr>
    	  ';
        @reset($campos);
        while ($nombreCampo = @current($campos))
          {
          @next($campos);
          $campo = $registro->getCampoPorNombre($nombreCampo);
          echo '<td class="' . $campo->getClase() . '" ';
      	  if ($campo->getTitulo())
      	    {
      	    echo 'onmouseover="Tip(\'' . $campo->getTitulo() . '\', SHADOW, true)"';
      	    }
    	    echo ' >
      	  ';
      	  
      	  if ($campo->getEnlace())
      	    {
      	    echo '<a class="' . $campo->getClase() . '" href="' . $campo->getEnlace() . '">';
      	    }
      	    
      	  if ($campo->getPrefijo())
      	    {
      	    echo $campo->getPrefijo();
      	    }
      	    
      	  if ($campo->getDecimales())
      	    {
      	    $decimalesT = $campo->getDecimales();
      	    }
      	  else
      	    {
      	    $decimalesT = 0;
      	    }
      	    
      	  if ($campo->getDivisor())
      	    {
      	    $divisorT = $campo->getDivisor();
      	    }
      	  else
      	    {
      	    $divisorT = 1;
      	    }
      	    
      	  if ($campo->getDivisor() || $campo->getDecimales())
      	    {
            echo formatear ($campo->getValor(), $decimalesT, $divisorT);
      	    }
      	  else
      	    {
            echo $campo->getValor();
      	    }
          
      	  if ($campo->getSufijo())
      	    {
      	    echo $campo->getSufijo();
      	    }
          
      	  if ($campo->getEnlace())
      	    {
      	    echo '</a>
      	    ';
      	    }
      	    
      	  echo '</td>
      	  ';
          }
    	  echo '<td></td></tr>
    	  ';
        }
      @next ($tablaArr);
  	  echo '<tr><td></td></tr>
  	  ';
   	  }
 	  echo '</table>
 	  ';
   	echo '</center>
   	';
    }
/*creartabla1 ok*
  function crearTabla1 ($tablaArr, $repetirTitulo=false, $tituloT='', $widthT='', $idT='tablaPrincipal',$mostrar='')
    {
    $i = 0;
  	echo '<center>';
  	echo '<table border=0 width="' . $widthT . '" class="visible" id="' . $idT . '" name="' . $idT . '">';
    @reset ($tablaArr);

    while ($tabla = @current($tablaArr))
      {
      @reset ($tabla);
      $fila = @current($tabla);
      @reset($fila);
      unset ($campos);
      while ($registro = @current($fila))
        {
        $campo = key($fila);
    	  $campos->$campo = $campo;
     	  $idcolumna->$campo = $registro->idcolumna;    	  
        @next ($fila);
        }
      @reset ($tabla);
      if ($i > 0 && !$repetirTitulo)
        {
        @next ($tabla);
        }
      else
        {
        echo $tituloT;
        }
      $i ++;

      while ($fila = @current($tabla))
        {
       $confila=0;
    	  @reset($campos);
		  while ($campo = @current($campos))
          {
		  if($confila==0){
  		  $id= $fila->$campo->idfila;
		   if($fila->$campo->resaltar)
		     $eventos='onClick="mouse(this);" onDblClick="quitamouse(this)"';
		   
		   echo '<tr id="'.$id.'" name="'.$id.'" '.$eventos.' >';
           $confila=1;
		  }
          //oculta las columnas en principio
          if(isset($idcolumna->$campo) and $mostrar=='')
            $detalle_estilo='style="display:none"';
          else
            $detalle_estilo='';
          //fin ocultar columnas

$ancho='';
if ($fila->$campo->ancho)
  {
  $ancho=$fila->$campo->ancho;
  }
  
          if (isset($fila->$campo->valor))
            {
        	  if (isset($fila->$campo->titulo))
        	    {
          	  $tittem = substr ($fila->$campo->titulo,0,1);
          	  if ($tittem == '|')
          	    {
          	    $fila->$campo->titulo = str_replace ('|', '', $fila->$campo->titulo);

                echo '<td width="'. $ancho . '" id="' . $idcolumna->$campo .  '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true, STICKY, true, CLICKCLOSE, true)" '.$detalle_estilo.'>';
          	    }
          	  else
          	    {
          	    echo '<td width="'. $ancho . '" id="' . $idcolumna->$campo .  '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true)" '.$detalle_estilo.'>';
          	    }
        	    }
        	  else
        	    {
        	    echo '<td width="'. $ancho . '" id="' . $idcolumna->$campo .  '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" '.$detalle_estilo.'>';
        	    }
            }
          else
            {
      	    echo '<td width="'. $ancho . '" id="' . $idcolumna->$campo .  '" name="' . $idcolumna->$campo . '" class="vacio" ' .$detalle_estilo.'>';
            }
      	  if ($fila->$campo->enlace)
      	    {
      	    echo '<a width="'. $ancho . '" class="' . $fila->$campo->clase . '" href="' . $fila->$campo->enlace . '" target="' . $fila->$campo->target . '">';
      	    }
      	    
      	  if (isset($fila->$campo->prefijo))
      	    {
         	  echo $fila->$campo->prefijo;
       	    }      	    
        	    
      	  if (isset($fila->$campo->decimales) || isset($fila->$campo->divisor))
      	    {
        	  if (!isset($fila->$campo->decimales))
        	    {
        	    $decimalesT = 0;
        	    }
        	  else
        	    {
        	    $decimalesT = $fila->$campo->decimales;
        	    }
        	  if (!isset($fila->$campo->divisor))
        	    {
        	    $divisorT = 1;
        	    }
        	  else
        	    {
        	    $divisorT = $fila->$campo->divisor;
        	    }
        	  echo formatear ($fila->$campo->valor,$decimalesT,$divisorT);
      	    }
      	  else
      	    {
        	  echo $fila->$campo->valor;
      	    }
      	  
      	  if (isset($fila->$campo->sufijo))
      	    {
        	  echo $fila->$campo->sufijo;
      	    }
      	  
      	  //echo  '&nbsp';
      	  
      	  if ($fila->$campo->enlace)
      	    {
      	    echo '</a>';
      	    }
      	  echo '</td>';
          @next ($campos);
          }
    	  echo '<td></td></tr>';
        @next ($tabla);
        }
      @next ($tablaArr);
  	  
	  echo '<tr id="'.$id.'"><td></td></tr>';
   	  }
 	  echo '</table>';
   	echo '</center>';
   	//sleep(1);
   	refrescar();
    }
/*creartabla1 ok*/

/*creartabla1 yency*/
function crearTabla1 ($tablaArr, $repetirTitulo=false, $tituloT='', $widthT='', $idT='tablaPrincipal',$mostrar='')
    {
    $i = 0;
  	echo '<center>';
  	echo '<table border=0 width="' . $widthT . '" class="visible" id="' . $idT . '" name="' . $idT . '">';
    @reset ($tablaArr);

    while ($tabla = @current($tablaArr))
      {
      @reset ($tabla);
      $fila = @current($tabla);
      @reset($fila);
      unset ($campos);
      while ($registro = @current($fila))
        {
        $campo = key($fila);
    	  $campos->$campo = $campo;
     	  $idcolumna->$campo = $registro->idcolumna;    	  
        @next ($fila);
        }
      @reset ($tabla);
      if ($i > 0 && !$repetirTitulo)
        {
        @next ($tabla);
        }
      else
        {
        echo $tituloT;
        }
      $i ++;

      while ($fila = @current($tabla))
        {
       $confila=0;
    	  @reset($campos);
		  while ($campo = @current($campos))
          {
		  if($confila==0){
  		  $id= $fila->$campo->idfila;
	if($fila->$campo->class_tr)
       $clase =  $fila->$campo->class_tr;
 else
       $clase = "";
		   if($fila->$campo->resaltar)
		     $eventos='onClick="mouse(this);" onDblClick="quitamouse(this)"';
		  //$clase= $fila->$campo 
      if (!isset($fila->$campo->valor) || trim($fila->$campo->valor)=='')
        {
        @next($campos);
        continue;
        }
echo '<tr id="'.$id.'" name="'.$id.'" '.$eventos.' class="'.$clase.'" >';
           $confila=1;
		  }

  //oculta las columnas en principio
          if(isset($idcolumna->$campo) and $mostrar=='')
            $detalle_estilo='style="display:none"';
          else
            $detalle_estilo='';
          //fin ocultar columnas

$ancho='';
if ($fila->$campo->ancho)
  {
  $ancho=$fila->$campo->ancho;
  }
  
          if (isset($fila->$campo->valor))
            {
        	  if (isset($fila->$campo->titulo))
        	    {
              if ($fila->$campo->titulo == '#')
                {
                $fila->$campo->titulo = formatear ($fila->$campo->valor);
                }
          	  $tittem = substr ($fila->$campo->titulo,0,1);
          	  if ($tittem == '?')
          	    {
          	    $fila->$campo->titulo = str_replace ('?', '', $fila->$campo->titulo);

                echo '<td width="'. $ancho . '" id="' . $idcolumna->$campo .  '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true, STICKY, true)" '.$detalle_estilo.'>';
          	    }
          	  else if ($tittem == '|')
          	    {
          	    $fila->$campo->titulo = str_replace ('|', '', $fila->$campo->titulo);

                echo '<td width="'. $ancho . '" id="' . $idcolumna->$campo .  '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true, STICKY, true, CLICKCLOSE, true)" '.$detalle_estilo.'>';
          	    }
          	  else
          	    {
          	    echo '<td width="'. $ancho . '" id="' . $idcolumna->$campo .  '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true)" '.$detalle_estilo.'>';
          	    }
        	    }
        	  else
        	    {
        	    echo '<td width="'. $ancho . '" id="' . $idcolumna->$campo .  '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" '.$detalle_estilo.'>';
        	    }
            }
          else
            {
      	    echo '<td width="'. $ancho . '" id="' . $idcolumna->$campo .  '" name="' . $idcolumna->$campo . '" class="vacio" ' .$detalle_estilo.'>';
            }
      	  if ($fila->$campo->enlace)
      	    {
      	    echo '<a width="'. $ancho . '" class="' . $fila->$campo->clase . '" href="' . $fila->$campo->enlace . '" target="' . $fila->$campo->target . '">';
      	    }
      	    
      	  if (isset($fila->$campo->prefijo))
      	    {
         	  echo $fila->$campo->prefijo;
       	    }      	    
        	    
      	  if (isset($fila->$campo->decimales) || isset($fila->$campo->divisor))
      	    {
        	  if (!isset($fila->$campo->decimales))
        	    {
        	    $decimalesT = 0;
        	    }
        	  else
        	    {
        	    $decimalesT = $fila->$campo->decimales;
        	    }
        	  if (!isset($fila->$campo->divisor))
        	    {
        	    $divisorT = 1;
        	    }
        	  else
        	    {
        	    $divisorT = $fila->$campo->divisor;
        	    }
        	  echo formatear ($fila->$campo->valor,$decimalesT,$divisorT);
      	    }
      	  else
      	    {
        	  echo $fila->$campo->valor;
      	    }
      	  
      	  if (isset($fila->$campo->sufijo))
      	    {
        	  echo $fila->$campo->sufijo;
      	    }
      	  
      	  //echo  '&nbsp';
      	  
      	  if ($fila->$campo->enlace)
      	    {
      	    echo '</a>';
      	    }
      	  echo '</td>';
          @next ($campos);
          }
    	  //echo '<td></td></tr>';
        @next ($tabla);
        }
      @next ($tablaArr);
  	  
	 // echo '<tr id="'.$id.'"><td></td></tr>';
   	  }
 	  echo '</table>';
   	echo '</center>';
   	//sleep(1);
   	refrescar();
    }
/*creartabla1 yency*/


  function miTrim ( $cadena )
    {
    $nueva = str_replace(' ', '', $cadena);
    return $nueva;
    }

//********************************************************* ------------------Araujo-------------------------------- ***************************************************
function crearTablasAraujo ($tablaArr, $repetirTitulo=false, $tituloT='', $widthT='')
    {
    $i = 0;
  	echo '<center>
  	';
  	echo '<table border=0 width="' . $widthT . '" class="visible" id="tablaPrincipal">
  	';
    @reset ($tablaArr);

    while ($tabla = @current($tablaArr))
      {
      @reset ($tabla);
      $fila = @current($tabla);
      @reset($fila);
      unset ($campos);
      while ($registro = @current($fila))
        {
        $campo = key($fila);
    	  $campos->$campo = $campo;
        @next ($fila);
        }
      @reset ($tabla);
      if ($i > 0 && !$repetirTitulo)
        {
        @next ($tabla);
        }
      else
        {
        echo $tituloT;
        }
      $i ++;

      while ($fila = @current($tabla))
        {
       $confila=0;
    	  @reset($campos);
		  while ($campo = @current($campos))
          {
		  if($confila==0){
  		  $id= $fila->$campo->idfila;
		   if($fila->$campo->resaltar)
		     $eventos='onClick="mouse(this);" onDblClick="quitamouse(this)"';
		   
		   echo '<tr id="'.$id.'" name="'.$id.'" '.$eventos.' >';
           $confila=1;
		  }
		   
		   $ancho='';
		   if ($fila->$campo->ancho)
		    {
			 $ancho=$fila->$campo->ancho;
			}
		   
          if (isset($fila->$campo->valor))
            {
        	  if (isset($fila->$campo->titulo))
        	    {
          	  $tittem = substr ($fila->$campo->titulo,0,1);
          	  if ($tittem == '|')
          	    {
          	    $fila->$campo->titulo = str_replace ('|', '', $fila->$campo->titulo);
          	    echo '<td id="' . $campo .  '" name="' . $campo . '" class="' . $fila->$campo->clase . '" width="'.$ancho.'" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true, STICKY, true, CLICKCLOSE, true)">
              	  ';
          	    }
          	  else
          	    {
          	    echo '<td id="' . $campo .  '" name="' . $campo . '" class="' . $fila->$campo->clase . '" width="'.$ancho.'" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true)">
              	  ';
          	    }
        	    }
        	  else
        	    {
        	    echo '<td id="' . $campo .  '" name="' . $campo . '" class="' . $fila->$campo->clase . '" width="'.$ancho.'">
          	  ';
        	    }
            }
          else
            {
      	    echo '<td id="' . $campo .  '" name="' . $campo . '" class="vacio" width="'.$ancho.'">
        	  ';
            }
      	  if ($fila->$campo->enlace)
      	    {
      	    echo '<a class="' . $fila->$campo->clase . '" href="' . $fila->$campo->enlace . '" target="' . $fila->$campo->target . '">';
      	    }
      	    
      	  if (isset($fila->$campo->prefijo))
      	    {
         	  echo $fila->$campo->prefijo;
       	    }      	    
        	    
      	  if (isset($fila->$campo->decimales) || isset($fila->$campo->divisor))
      	    {
        	  if (!isset($fila->$campo->decimales))
        	    {
        	    $decimalesT = 0;
        	    }
        	  else
        	    {
        	    $decimalesT = $fila->$campo->decimales;
        	    }
        	  if (!isset($fila->$campo->divisor))
        	    {
        	    $divisorT = 1;
        	    }
        	  else
        	    {
        	    $divisorT = $fila->$campo->divisor;
        	    }
        	  echo formatear ($fila->$campo->valor,$decimalesT,$divisorT);
      	    }
      	  else
      	    {
        	  echo $fila->$campo->valor;
      	    }
      	  
      	  if (isset($fila->$campo->sufijo))
      	    {
        	  echo $fila->$campo->sufijo;
      	    }
      	  
      	  //echo  '&nbsp';
      	  
      	  if ($fila->$campo->enlace)
      	    {
      	    echo '</a>';
      	    }
      	  echo '</td>
      	  ';
          @next ($campos);
          }
    	  echo '<td></td></tr>
    	  ';
        @next ($tabla);
        }
      @next ($tablaArr);
  	  
	  echo '<tr id="'.$id.'"><td></td></tr>
  	  ';
   	  }
 	  echo '</table>
 	  ';
   	echo '</center>
   	';
   	refrescar();
    }

/*****************************marzo/25/2009************************/
  function crearTablaOrdenar1($tablaArr,$nrofilas, $repetirTitulo=false,$idT='tablaPrincipal'){
    $i = 0;
	 $cont=0;
  	echo '<center>
  	';
  	echo '<table class="sortable"  id="' . $idT . '" name="' . $idT . '">
  	';
    @reset ($tablaArr);
    while ($tabla = @current($tablaArr))
      {
      @reset ($tabla);
      $fila = @current($tabla);
      unset ($campos);
      while ($registro = @current($fila))
        {
        $campo = key($fila);
    	  $campos->$campo = $campo;
        @next ($fila);
        }
      @reset ($tabla);
      if ($i > 0 && !$repetirTitulo)
        {
        @next ($tabla);
        }
      $i ++;
	 
      while ($fila = @current($tabla))
        {
	 		if($cont==0)
		    echo "<thead>";
			if($cont==1)
		    echo "<tbody>";						
			
		  //echo '<tr>';
       $confila=0;
    	  @reset($campos);
        while ($campo = @current($campos))
          {
		  if($confila==0){
  		  $id= $fila->$campo->idfila;
		   if($fila->$campo->resaltar)
		     $eventos='onClick="mouse(this);" onDblClick="quitamouse(this)"';
         		   
		   echo '<tr id="'.$id.'" name="'.$id.'" '.$eventos.' >';
           $confila=1;
		  }
          
          if (isset($fila->$campo->valor))
            {
        	  if (isset($fila->$campo->titulo))
        	    {
        	    echo '<td id="' . $campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true)">
          	  ';
        	    }
        	  else
        	    {
        	    echo '<td id="' . $campo . '" class="' . $fila->$campo->clase . '">
          	  ';
        	    }
            }
          else
            {
      	    echo '<td id="' . $campo . '" class="vacio">
        	  ';
            }
      	  if ($fila->$campo->enlace)
      	    {
      	    echo '<a class="' . $fila->$campo->clase . '" href="' . $fila->$campo->enlace . '" target="' . $fila->$campo->target . '">';
      	    }
      	    
      	  if (isset($fila->$campo->prefijo))
      	    {
         	  echo $fila->$campo->prefijo;
       	    }      	    
        	    
      	  if (isset($fila->$campo->decimales) || isset($fila->$campo->divisor))
      	    {
        	  if (!isset($fila->$campo->decimales))
        	    {
        	    $decimalesT = 0;
        	    }
        	  else
        	    {
        	    $decimalesT = $fila->$campo->decimales;
        	    }
        	  if (!isset($fila->$campo->divisor))
        	    {
        	    $divisorT = 1;
        	    }
        	  else
        	    {
        	    $divisorT = $fila->$campo->divisor;
        	    }
        	  echo formatear1 ($fila->$campo->valor,$decimalesT,$divisorT);
      	    }
      	  else
      	    {
        	  echo $fila->$campo->valor;
      	    }
      	  
      	  if (isset($fila->$campo->sufijo))
      	    {
        	  echo $fila->$campo->sufijo;
      	    }
      	  
      	  //echo  '&nbsp';
      	  
      	  if ($fila->$campo->enlace)
      	    {
      	    echo '</a>';
      	    }
      	  echo '</td>
      	  ';
          @next ($campos);
          }
    	//  echo '<td></td></tr>';
        @next ($tabla);
		
		if($cont==0)
        echo "</thead>";
		if($cont==$nrofilas-1)
        echo "</body><tfoot>";
        
		
		++$cont;
		}
      @next ($tablaArr);
  	 // echo '<tr><td></td></tr>';
   	  }
 	  echo '</tfoot></table>
 	  ';
   	echo '</center>
   	';
  }
  
  Function nombreConexionX($codsuc)
    {
	return 'ifxibgdir';
    if ($codsuc == 2)
      $conexion = 'ifxarmenia';
    else if ($codsuc == 6)
      $conexion = 'ifxcali';
    else if ($codsuc == 8)
      $conexion = 'ifxbuga';
    else if ($codsuc == 9)
      $conexion = 'ifxgirard';
    else if ($codsuc == 10)
      $conexion = 'ifxcarta';	
    else if ($codsuc == 11)
      $conexion = 'ifxmzales1';
    else if ($codsuc == 12)
      $conexion = 'ifxmzales2';
    else if ($codsuc == 14)
      $conexion = 'ifxibague';
    else if ($codsuc == 16)
      $conexion = 'ifxpereira';
    else if ($codsuc == 18)
      $conexion = 'ifxpalmira';	
    else if ($codsuc == 20)
      $conexion = 'ifxpitalito';
    else if ($codsuc == 21)
      $conexion = 'ifxneiva';
    else if ($codsuc == 25)
      $conexion = 'ifxpasto';
    else if ($codsuc == 28)
      $conexion = 'ifxdorada';	
    else if ($codsuc == 38)
      $conexion = 'ifxchinchi';
    else if ($codsuc == 40)
      $conexion = 'ifxcali2';	
    else if ($codsuc == 43)
      $conexion = 'ifxpopayan';
    else if ($codsuc == 44)
      $conexion = 'ifxsantder'; 	
    else if ($codsuc == 45)
      $conexion = 'ifxespinal';
    else if ($codsuc == 47)
      $conexion = 'ifxzipa';
    else if ($codsuc == 48)
      $conexion = 'ifxpuerto';	
    else if ($codsuc == 52)
      $conexion = 'ifxflorencia';
    else if ($codsuc == 53)
      $conexion = 'ifxvillavo';
    else if ($codsuc == 54)
      $conexion = 'ifxyopal';
    else if ($codsuc == 55)
      $conexion = 'ifxduitama';	
    else if ($codsuc == 57)
      $conexion = 'ifxtunja';	
    else if ($codsuc == 61)
      $conexion = 'ifxmocoa';	
    else if ($codsuc == 62)
      $conexion = 'ifxjamundi';	
    else if ($codsuc == 63)
      $conexion = 'ifxmosquera';	
    else if ($codsuc > 69 || $codsuc == 1)
    $conexion = 'ifxibgdir';	
    else
    {
    echo "<hr><center>SERVICIO NO DISPONIBLE PARA SU SUCURSAL</center><hr>";
    exit;
    }
    return $conexion;
  }
  function crearComboSucReg($nombre,$seleccionado)
{
   $consulta=
   "select nombre,codigo||'' as codigo,'S' as tipo
    from sucursales
    where sucursales.estado='A'
    union
    select nombre,cod_intranet as codigo,'R' as tipo
    from regionales";
   
   $con = new Odbc('ifxibgdir','','');
   $con->ejecutar("begin work");
   $con->ejecutar("set transaction isolation level read uncommitted");
   $con->consultar($consulta);
   $con->ejecutar("commit work");
   
   echo ' Sucursales Regionales  :<select name='.$nombre.' id='.$nombre.'>
            <option value="compania">Compa&#241;ia</option>';
    while($reg=$con->getRegistro())
    {
        $codigo  =  trim($reg['codigo']);
        $nombre  =  minusculas(trim($reg['nombre']));
        $tipo    =  trim($reg['tipo']);
        if($codigo.'/'.$tipo==$seleccionado)
        echo '<option value="'.$codigo.'/'.$tipo.'" selected="selected">'.$nombre.'</option>';
        else
        echo '<option value="'.$codigo.'/'.$tipo.'">'.$nombre.'</option>';
    }
      echo '</select>'; 
}

function crearComboSucursal($nombre,$seleccionado,$con)
{
   $consulta=
   "select nombre,codigo
    from sucursales
    where sucursales.estado='A' 
    and codigo < 70
    order by 1 ";
   
   $con->consultar($consulta);

   echo ' Sucursales  :<select name='.$nombre.' id='.$nombre.'>
            <option value="compania">Compa&#241;ia</option>';
    while($reg=$con->getRegistro())
    {
        $codigo  =  trim($reg['codigo']);
        $nombre  =  minusculas(trim($reg['nombre']));

        if($codigo==$seleccionado)
        echo '<option value="'.$codigo.'" selected="selected">'.$nombre.'</option>';
        else
        echo '<option value="'.$codigo.'">'.$nombre.'</option>';
    }
      echo '</select>';
}
  function crearComboasuntos($nombre,$seleccionado,$con)
{
   $consulta=
   "select nombre,codigo from asuntos order by 2";

   $con->consultar($consulta);

   echo ' <select name='.$nombre.' id='.$nombre.' " >
            <option value="ninguna">Ninguno</option>';
    while($reg=$con->getRegistro())
    {
        $nombre  =  minusculas(trim($reg['nombre']));
        $codigo  =  trim($reg['codigo']);

        if($codigo==$seleccionado)
        echo '<option value="'.$codigo.'" selected="selected">'.$nombre.'</option>';
        else
        echo '<option value="'.$codigo.'">'.$nombre.'</option>';
    }
       echo '</select> ';
}
function calcularRestaFechas($dFecIni, $dFecFin)
{
$dFecIni = str_replace("-","",$dFecIni);
$dFecIni = str_replace("/","",$dFecIni);
$dFecFin = str_replace("-","",$dFecFin);
$dFecFin = str_replace("/","",$dFecFin);

ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

$date1 = mktime(0,0,0,$aFecIni[1], $aFecIni[2], $aFecIni[3]);
$date2 = mktime(0,0,0,$aFecFin[1], $aFecFin[2], $aFecFin[3]);

return (($date2 - $date1) / (60 * 60 * 24));
}

//alejo enero 6 2011. Trae la fecha actual en el formato deseado.
function  traerFechaActual ($formato) {
  date_default_timezone_set("America/Bogota");
  $tiempo = time();
  $retorno = date ( $formato, $tiempo );
  return $retorno;
}

/**
Crea una tabla con las sucursales y/o regionales.
@tipo:  C->compañia
        R->regional
        S->sucursal
@suc:   sucursal de intranet.
@con1:  conexión ODBC previamente creada

devuelve un arreglo de tipo:
    arreglo ->  codregion  ->  titulo
                        ->  total
                        ->  codsucursal
    Si es compañía ademas:
    arreglo ->  total   ->  titulo
                        ->  total
/**/
function crearEsqueletoSuc ($tipo, $suc, $con1) {
  //echo "<hr/>$tipo, $suc<hr/>";
  $tituloT->codigo->valor = "C&oacute;digo";
  $tituloT->nombre->valor = "Descripci&oacute;n";
  
  if ($tipo == 'C') {
    //echo "Compa&ntilde;ia";
    $consulta = 
      "
      select nombre, codigo
      from regionales
      where codigo > 0
      order by 2
      ";  
    $con1->consultar ($consulta);
    //$con1->verDatos ();
    while ($registro = $con1->getRegistro()) {
      $codRegion = trim ($registro[codigo]);
      $nomRegion = minusculas ($registro[nombre]);
      
      $arreglo->$codRegion->titulo = $tituloT;
      $arreglo->$codRegion->total->codigo->valor = $codRegion;
      $idFila = "idFila".$codRegion;
      $classImgFila  = "classImgFila".$codRegion;
      $arreglo->$codRegion->total->codigo->enlace = "javascript:guiaClase('$idFila','$classImgFila');";
      $arreglo->$codRegion->total->codigo->prefijo = "<img class=\"$classImgFila\" src=\"img/contraer.gif\" width=\"10\" height=\"10\" border=\"0\" />&nbsp;";
      $arreglo->$codRegion->total->nombre->valor = $nomRegion;
    }
    $consulta = 
      "
      select trunc(codigo) as codsuc, nombre as nomsuc, codregion
      from sucursales
      where estado = 'A'
        and codregion > 0
      order by 1
      ";  
    $con1->consultar ($consulta);
    //$con1->verDatos ();
    while ($registro = $con1->getRegistro()) {
      $codSuc = trim ($registro[codsuc]);
      $nomSuc = minusculas ($registro[nomsuc]);
      $codRegion = trim ($registro[codregion]);
      
      $arreglo->$codRegion->$codSuc->codigo->valor = $codSuc;
      $idFila = "idFila".$codRegion;
      $arreglo->$codRegion->$codSuc->codigo->idfila = $idFila;
      $arreglo->$codRegion->$codSuc->nombre->valor = $nomSuc;
      
      $sucursal->$codSuc->codSuc    = $codSuc;
      $sucursal->$codSuc->nomSuc    = $nomSuc;
      $sucursal->$codSuc->codRegion = $codRegion;
      $sucursal->$codSuc->nomRegion = $nomRegion;
    }
    $arreglo->total->titulo = $tituloT;
    $arreglo->total->total->codigo->valor = "-";
    $arreglo->total->total->nombre->valor = "Compa&ntilde;ia";
  }
  else if($tipo == 'R') {
    //echo "Regional";
    if ($suc > 90) {
      $consulta = 
        "
        select nombre, codigo
        from regionales
        where cod_intranet = $suc
        order by 1
        ";  
    }
    else {
      $consulta = 
        "
        select nombre, codigo
        from regionales
        where codigo = $suc
        order by 1
        ";  
    }
    $con1->consultar ($consulta);
    //$con1->verDatos ();
    while ($registro = $con1->getRegistro()) {
      $codRegion = trim ($registro[codigo]);
      $nomRegion = minusculas ($registro[nombre]);
      
      $arreglo->$codRegion->titulo = $tituloT;
      $arreglo->$codRegion->total->codigo->valor = $codRegion;
      $idFila = "idFila".$codRegion;
      $classImgFila  = "classImgFila".$codRegion;
      $arreglo->$codRegion->total->codigo->enlace = "javascript:guiaClase('$idFila','$classImgFila');";
      $arreglo->$codRegion->total->codigo->prefijo = "<img class=\"$classImgFila\" src=\"img/contraer.gif\" width=\"10\" height=\"10\" border=\"0\" />&nbsp;";
      $arreglo->$codRegion->total->nombre->valor = $nomRegion;
    }
    $consulta = 
      "
      select trunc(codigo) as codsuc, nombre as nomsuc
      from sucursales
      where estado = 'A'
        and codregion = $codRegion
      order by 1
      ";  
    $con1->consultar ($consulta);
    //$con1->verDatos ();
    while ($registro = $con1->getRegistro()) {
      $codSuc = trim ($registro[codsuc]);
      $nomSuc = minusculas ($registro[nomsuc]);
      
      $arreglo->$codRegion->$codSuc->codigo->valor = $codSuc;
      $idFila = "idFila".$codRegion;
      $arreglo->$codRegion->$codSuc->codigo->idfila = $idFila;
      $arreglo->$codRegion->$codSuc->nombre->valor = $nomSuc;
      
      $sucursal->$codSuc->codSuc    = $codSuc;
      $sucursal->$codSuc->nomSuc    = $nomSuc;
      $sucursal->$codSuc->codRegion = $codRegion;
      $sucursal->$codSuc->nomRegion = $nomRegion;
    }
  }
  else if($tipo == 'S') {
    $consulta = 
      "
      select trunc(codigo) as codsuc, nombre as nomsuc, codregion
      from sucursales
      where codigo = $suc
      order by 1
      ";  
    $con1->consultar ($consulta);
    //$con1->verDatos ();
    while ($registro = $con1->getRegistro()) {
      $codSuc = trim ($registro[codsuc]);
      $nomSuc = minusculas ($registro[nomsuc]);
      $codRegion = trim ($registro[codregion]);
      
      $arreglo->$codRegion->titulo = $tituloT;
      $arreglo->$codRegion->$codSuc->codigo->valor = $codSuc;
      $arreglo->$codRegion->$codSuc->nombre->valor = $nomSuc;
      
      $sucursal->$codSuc->codSuc    = $codSuc;
      $sucursal->$codSuc->nomSuc    = $nomSuc;
      $sucursal->$codSuc->codRegion = $codRegion;
      $sucursal->$codSuc->nomRegion = $nomRegion;
    }
  }
  else {
    exit ("Incorrecto!!!");
  }
  //echo "$suc";
  $retorno->arreglo=$arreglo;
  $retorno->sucursal=$sucursal;
  return $retorno;
}

function agregaCelda (&$objeto, $params, $separador1=";", $separador2=":") {
  $arr_param = explode($separador1,$params);
  $flag_sumar = false;
  foreach ( $arr_param as $param ) {
    $arr_campo = explode($separador2,$param);
    $campo = trim($arr_campo[0]);
    $valor = trim($arr_campo[1]);
    if ($campo == "" || $valor == "") {
      continue;
    }
    if ($campo == "sumar") {
      if ($valor == true) {
        $flag_sumar = true;
      }
    }
    else if ($campo == "valor" && $flag_sumar == true) {
      $objeto->$campo += $valor;
    }
    else {
      $objeto->$campo = $valor;
    }
  }
}

function agregaPromedio (&$objeto, $campo, $campo1, $campo2) {
  if ($objeto->$campo2->valor > 0) {
    $objeto->$campo->valor = $objeto->$campo1->valor / $objeto->$campo2->valor * 100;
  }
  else {
    $objeto->$campo->valor = 0;
  }
  $objeto->$campo->decimales = 2;
  $objeto->$campo->sufijo = '%';
}
function diferenciaFechas_laborales ($fecini, $fecfin) {
  $diaini = substr($fecini,3,2) - 1;
  $mesini = substr($fecini,0,2);
  $anoini = substr($fecini,6,4);

  $diafin = substr($fecfin,3,2);
  $mesfin = substr($fecfin,0,2);
  $anofin = substr($fecfin,6,4);

  if ($diaini == 31) {
    $diaini = 30;
  }
  if ($diafin == 31) {
    $diafin = 30;
  }
  if ($diaini >= 28 && $mesini == 2) {
    $diaini = 30;
  }
  if ($diafin >= 28 && $mesfin == 2) {
    $diafin = 30;
  }

  $valano = $anofin - $anoini;
  if ($valano < 0) {
    exit ("error fechas, inicial es mayor que final");
  }
  $valmes = $mesfin - $mesini;
  if ($valmes < 0) {
    $valmes += 12;
    $valano -= 1;
    if ($valano < 0) {
      exit ("error fechas, inicial es mayor que final");
    }
  }
  $valdia = $diafin - $diaini;
  if ($valdia < 0) {
    $valdia += 30;
    $valmes -= 1;
    if ($valmes < 0) {
      $valmes += 12;
      $valano -= 1;
      if ($valano < 0) {
        exit ("error fechas, inicial es mayor que final");
      }
    }
  }
  if ($valdia >= 30) {
    $valdia = 0;
    $valmes += 1;
    if ($valmes >= 12) {
      $valmes -= 12;
      $valano += 1;
      }
  }
  $retorno->anios  = $valano;
  $retorno->meses = $valmes;
  $retorno->dias  = $valdia;
  return $retorno;
}
function quitar_tildes($cadena) {
$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
$texto = str_replace($no_permitidas, $permitidas ,$cadena);
return $texto;
}

/**
 * @autor: jhonatan wagner o.
 * @fecha: 12/junio/2017
 * @descripcion: nueva funcion orientada para excel 2017 que recibe mas 1 millon de registros
 * @return: excel con los registros
 **/
function excel2017 (){
     $variable=1;
	if($variable > 0 ){
						
		date_default_timezone_set('America/Mexico_City');

		if (PHP_SAPI == 'cli')
			die('Este archivo solo se puede ver desde un navegador web');

		/** Se agrega la libreria PHPExcel */
		require_once 'resource/assets/lib/PHPExcel/PHPExcel.php';

		// Se crea el objeto PHPExcel
		$objPHPExcel = new PHPExcel();

		// Se asignan las propiedades del libro
		$objPHPExcel->getProperties()->setCreator("Codedrinks") //Autor
							 ->setLastModifiedBy("Codedrinks") //Ultimo usuario que lo modificó
							 ->setTitle("Reporte Excel con PHP y MySQL")
							 ->setSubject("Reporte Excel con PHP y MySQL")
							 ->setDescription("Reporte de alumnos")
							 ->setKeywords("reporte alumnos carreras")
							 ->setCategory("Reporte excel");

		$tituloReporte = "Relación de alumnos por carrera";
		$titulosColumnas = array('NOMBRE', 'FECHA DE NACIMIENTO', 'SEXO', 'CARRERA','WAGNER');
		
		$objPHPExcel->setActiveSheetIndex(0)
        		    ->mergeCells('A1:E1');
						
		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1',  $tituloReporte)
                                        ->setCellValue('A3',  $titulosColumnas[0])
                                        ->setCellValue('B3',  $titulosColumnas[1])
                                        ->setCellValue('C3',  $titulosColumnas[2])
                                        ->setCellValue('D3',  $titulosColumnas[3])
                                        ->setCellValue('E3',  $titulosColumnas[4]);
		
		//Se agregan los datos de todas las columnas
		$i = 4;
		while ($variable < 300) {
			$objPHPExcel->setActiveSheetIndex(0)
        		    ->setCellValue('A'.$i,  $variable)
		            ->setCellValue('B'.$i,  $variable)
        		    ->setCellValue('C'.$i,  $variable)
                            ->setCellValue('D'.$i, $variable)
                            ->setCellValue('E'.$i, 'Wagner el mejor');
					$i++;
                                        $variable++;
		}
		
		$estiloTituloReporte = array(
        	'font' => array(
	        	'name'      => 'Verdana',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>18,
	            	'color'     => array(
    	            	'rgb' => '000'
        	       	)
            ),
	        'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('argb' => 'FF220835')
			),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_NONE                    
               	)
            ), 
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );

		$estiloTituloColumnas = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => 'FE0800'
                )
            ),
            'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
        		'startcolor' => array(
            		'rgb' => 'c47cf2'
        		),
        		'endcolor'   => array(
            		'argb' => 'FF431a5d'
        		)
			),
            'borders' => array(
            	'allborders'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '143860'
                    )
                ),
            	
            ),
			'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'wrap'          => TRUE
    		));
			
		$estiloInformacion = new PHPExcel_Style();
		$estiloInformacion->applyFromArray(
			array(
           		'font' => array(
               	'name'      => 'Arial',               
               	'color'     => array(
                   	'rgb' => '000000'
               	)
           	),
//           	'fill' 	=> array(
//				'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
//				'color'		=> array('argb' => 'FFd9b7f4')
//			),
           	'borders' => array(
               	'allborders'     => array(
                   	'style' => PHPExcel_Style_Border::BORDER_THIN ,
	                'color' => array(
    	            	'rgb' => '3a2a47'
                   	)
               	)             
           	)
        ));
		 
		$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($estiloTituloColumnas);		
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:E".($i-1));
				
		for($i = 'A'; $i <= 'E'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}
		
		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Alumnos');

		// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
		$objPHPExcel->setActiveSheetIndex(0);
		// Inmovilizar paneles 
		//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
		$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,5);

		// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="prubeba.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//		$objWriter->save('php://output');
                return $objWriter;
		
		
	}
	else{
		print_r('No hay resultados para mostrar');
	}
}


?>