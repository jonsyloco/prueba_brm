<?php
date_default_timezone_set("America/Bogota");
set_time_limit(3600);

function minusculas($cadena, $remplazar = true) {

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

function incluirScript() {
    ?>
    <script language="JavaScript">
        /*en funciones de v4*/
        function abrirVentana(url, ancho, alto, nombre) {
            var opciones = "titlebar=NO,toolbar=0,location=0,directories=0,status=1,menubar=0,scrollbars=YES,resizable=1,width=" + ancho + ",height=" + alto;
            var Nueva_ventana;
            var tiempo = new Date();
            var hora = tiempo.getHours();
            var minuto = tiempo.getMinutes();
            var segundo = tiempo.getSeconds();
    //		var nombre=hora+minuto+segundo;//nombre;//
    //		url='prod_lista.php'; 
            Nueva_ventana = window.open(url, nombre, opciones);
            Nueva_ventana.moveTo(0, 0);
            Nueva_ventana.focus();
        }

        function registra_salida(aplicacion)
        {
            url = '/informix/v2/general/registra_usuarios/salir.php?aplicacion=' + aplicacion;
            window.open(url, 'oculto');
        }

        function borrarTabla(tabla)
        {
            tabla = document.getElementById(tabla);
            padre = tabla.parentNode;
            padre.removeChild(tabla);
        }

        function cambiaMensaje(mensaje)
        {
            document.getElementById('labelCargando').innerHTML = mensaje;
        }
        window.status = ': )';

        function mouse(padre)
        {
            //var padre=obj.parentNode;

            var hijos = padre.childNodes.length;
            longitud = 0;
            for (var i = 0; i < hijos; i++) {
                if (padre.childNodes[i].nodeType == 1) {
                    nodo = padre.childNodes[i];
                    nodo.style.backgroundColor = <?php echo "'$color_resaltado'"; ?>;
                    longitud++;
                    //alert(nodo.tagName);
                }
            }

            //alert(longitud);
            /*
             for (i=0;i<celdas.length;i++)
             {        
             celdas[i].onmouseover = new Function("cambia('red','black')");
             celdas[i].onmouseout = new Function("nada()");
             
             }*/
        }

        function quitamouse(padre)
        {
            //var padre=obj.parentNode;

            var hijos = padre.childNodes.length;
            longitud = 0;
            for (var i = 0; i < hijos; i++) {
                if (padre.childNodes[i].nodeType == 1) {
                    nodo = padre.childNodes[i];
                    nodo.style.backgroundColor = '';
                    longitud++;
                    //alert(nodo.tagName);
                }
            }
        }

        function Ventana(URL, Nombre)
        {
            margenx = 0;
            margeny = 50;
            Flags = 'status=no, scrollbars=yes, resizable=yes';
            hijo = window.open('', Nombre, Flags);
            setTimeout("hijo.close();", 200);
            setTimeout("hijo=window.open('" + URL + "','" + Nombre + "','" + Flags + "');", 1000);
            //alert ("ok");
        }

        function Ventana1(URL, Nombre, Flags)
        {
            margenx = 0;
            margeny = 50;

            hijo = window.open(URL, Nombre, Flags);
            hijo.focus();
        }

        function ColorFila()
        {
            var rows = document.getElementsByTagName("tr");
            for (var i in rows)
            {
                rows[i].onmouseover = function()
                {
                    this.className = "resaltar";
                }
                rows[i].onmouseout = function()
                {
                    this.className = null;
                }
            }
        }

        function activar(formulario)
        {
            i = 1;
            while (formulario.elements[i])
            {
                formulario.elements[i].disabled = 0;
                i = i + 1;
            }
        }

        function desactivar(formulario)
        {
            i = 1;
            while (formulario.elements[i])
            {
                formulario.elements[i].disabled = 1;
                i = i + 1;
            }
        }

        onload = ColorFila;
    </script>
    <?php
}

/* Crear tabla de datos */

function crearTabla($tablaArr, $repetirTitulo = false, $tituloT = '', $widthT = '', $idT = 'tablaPrincipal') {
    $i = 0;
    echo '<table border=0 width="' . $widthT . '" class="visible" id="' . $idT . '" name="' . $idT . '">
    ';
    @reset($tablaArr);

    while ($tabla = @current($tablaArr)) {
        @reset($tabla);
        $fila = @current($tabla);
        @reset($fila);
        unset($campos);
        while ($registro = @current($fila)) {
            $campo = key($fila);
            $campos->$campo = $campo;
            @next($fila);
        }
        @reset($tabla);
        if ($i > 0 && !$repetirTitulo) {
            @next($tabla);
        } else {
            echo $tituloT;
        }
        $i ++;

        while ($fila = @current($tabla)) {
            $confila = 0;
            @reset($campos);
            while ($campo = @current($campos)) {
                if ($confila == 0) {
                    $id = $fila->$campo->idfila;
                    $clase = $fila->$campo->class_tr;
                    if ($fila->$campo->resaltar)
                        $eventos = 'onClick="mouse(this);" onDblClick="quitamouse(this)"';
                    if ($clase)
                        echo '<tr id="' . $id . '" name="' . $id . '" ' . $eventos . ' class="' . $clase . '" >';
                    else
                        echo '<tr id="' . $id . '" name="' . $id . '" ' . $eventos . ' >';
                    $confila = 1;
                }

                if (isset($fila->$campo->valor)) {
                    if (isset($fila->$campo->titulo)) {
                        if ($fila->$campo->titulo == '#') {
                            $fila->$campo->titulo = formatear($fila->$campo->valor);
                        } else if ($fila->$campo->titulo == '$') {
                            $fila->$campo->titulo = '$' . formatear($fila->$campo->valor) . '=';
                        }
                        $tittem = substr($fila->$campo->titulo, 0, 1);
                        if ($tittem == '?') {
                            $fila->$campo->titulo = str_replace('?', '', $fila->$campo->titulo);
                            echo '<td id="' . $campo . '" name="' . $campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true, STICKY, true)">
                ';
                        } else if ($tittem == '|') {
                            $fila->$campo->titulo = str_replace('|', '', $fila->$campo->titulo);
                            echo '<td id="' . $campo . '" name="' . $campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true, STICKY, true, CLICKCLOSE, true)">
                ';
                        } else {
                            echo '<td id="' . $campo . '" name="' . $campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true)">
                ';
                        }
                    } else {
                        echo '<td id="' . $campo . '" name="' . $campo . '" class="' . $fila->$campo->clase . '">
              ';
                    }
                } else {
                    echo '<td id="' . $campo . '" name="' . $campo . '" class="vacio">
            ';
                }
                if ($fila->$campo->enlace) {
                    echo '<a class="' . $fila->$campo->clase . '" href="' . $fila->$campo->enlace . '" target="' . $fila->$campo->target . '">';
                }

                if (isset($fila->$campo->prefijo)) {
                    echo $fila->$campo->prefijo;
                }

                if (isset($fila->$campo->decimales) || isset($fila->$campo->divisor)) {
                    if (!isset($fila->$campo->decimales)) {
                        $decimalesT = 0;
                    } else {
                        $decimalesT = $fila->$campo->decimales;
                    }
                    if (!isset($fila->$campo->divisor)) {
                        $divisorT = 1;
                    } else {
                        $divisorT = $fila->$campo->divisor;
                    }
                    echo formatear($fila->$campo->valor, $decimalesT, $divisorT);
                } else {
                    echo $fila->$campo->valor;
                }

                if (isset($fila->$campo->sufijo)) {
                    echo $fila->$campo->sufijo;
                }

                if ($fila->$campo->enlace) {
                    echo '</a>';
                }
                echo '</td>
          ';
                @next($campos);
            }
            echo '<td></td></tr>
        ';
            @next($tabla);
        }
        @next($tablaArr);

        echo '<tr id="' . $id . '"><td></td></tr>
      ';
    }
    echo '</table>
    ';
    echo '</center>
    ';
}

/* Crear combo con sucursales vigentes */

function agregaCampo($arreglo, $grupo, $registro, $campo, $valor, $clase = '', $enlace = '', $titulo = '', $divisor = '', $decimales = '', $prefijo = '', $sufijo = '', $acumula = false, $idfila = '', $resaltar = '', $ancho = '', $idcolumna = '', $class_tr = '') {
  
      ini_set('memory_limit', '256M');

  if ($acumula) {
        $arreglo->$grupo->$registro->$campo->valor += $valor;
    } else {
        $arreglo->$grupo->$registro->$campo->valor = $valor;
        //echo "$grupo,$registro,$campo,$valor<hr>";
    }
    if ($clase != '') {
        $arreglo->$grupo->$registro->$campo->clase = $clase;
    }
    if ($enlace != '') {
        $arreglo->$grupo->$registro->$campo->enlace = $enlace;
    }
    if ($titulo != '') {
        $arreglo->$grupo->$registro->$campo->titulo = $titulo;
    }
    if ($divisor != '') {
        $arreglo->$grupo->$registro->$campo->divisor = $divisor;
    }
    if ($decimales != '') {
        $arreglo->$grupo->$registro->$campo->decimales = $decimales;
    }
    if ($prefijo != '') {
        $arreglo->$grupo->$registro->$campo->prefijo = $prefijo;
    }
    if ($sufijo != '') {
        $arreglo->$grupo->$registro->$campo->sufijo = $sufijo;
    }
    if ($idfila != '') {
        $arreglo->$grupo->$registro->$campo->idfila = $idfila;
    }
    if ($resaltar != '') {
        $arreglo->$grupo->$registro->$campo->resaltar = $resaltar;
    }
    if ($ancho != '') {
        $arreglo->$grupo->$registro->$campo->ancho = $ancho;
    }
    if ($idcolumna != '') {
        $arreglo->$grupo->$registro->$campo->idcolumna = $idcolumna;
    }
    if ($class_tr != '') {
        $arreglo->$grupo->$registro->$campo->class_tr = $class_tr;
    }
    return $arreglo;
}

function crearXls($tablaArr, $nombre, $mensaje = 'Descargar Archivo Xls', $reemplazo = '') {
    $i = 0;
    @reset($tablaArr);
    while ($tabla = @current($tablaArr)) {
        @reset($tabla);
        $fila = @current($tabla);
        unset($campos);
        @reset($fila);
        while ($registro = @current($fila)) {
            $campo = key($fila);
            $campos->$campo = $campo;
            @next($fila);
        }
        @reset($tabla);
        //@next ($tabla);//Quitar titulos
        while ($fila = @current($tabla)) {
            $i ++;
            @reset($campos);
            while ($campo = @current($campos)) {
                if ($fila->$campo->valor == '0') {
                    $fila->$campo->valor = 0;
                }
                if (isset($fila->$campo->valor)) {
                    $arregloXls[$i][$campo] = str_replace('<br>', ' ', $fila->$campo->valor);
                    if (is_numeric($arregloXls[$i][$campo])) {
                        $arregloXls[$i][$campo] += 0;
                    }
                } else {
                    $arregloXls[$i][$campo] = $reemplazo;
                }
                @next($campos);
            }
            $arregloXls[$i]['_'] = '';
            @next($tabla);
        }
        @next($tablaArr);
    }

    require_once "../../excel.php";
    $dir = getcwd();
    $dir = str_replace('\\', '/', $dir);
    $dir = strtolower($dir);
    $dir = str_replace('c:/', 'xlsfile://', $dir);
    $archivo = "xls/" . $nombre . ".xls";
    $export_file = "$dir/$archivo";
    $fp = fopen($export_file, "wb");
    if (!is_resource($fp)) {
        die("No pudo crear $export_file");
    }
    echo "<center><a href='$archivo'> $mensaje </a></center>";
    fwrite($fp, serialize($arregloXls));
    fclose($fp);
}

function crearTablaFelipeSinVacio($tablaArr, $repetirTitulo = false, $tituloT = '', $widthT = '', $idT = 'tablaPrincipal', $mostrar = '') {
    $i = 0;
    //echo '<center>';
    //echo '<table border=0 width="' . $widthT . '" class="visible" id="' . $idT . '" name="' . $idT . '">';
    echo '<tbody>';
    @reset($tablaArr);

    while ($tabla = @current($tablaArr)) {
        @reset($tabla);
        $fila = @current($tabla);
        @reset($fila);
        unset($campos);
        while ($registro = @current($fila)) {
            $campo = key($fila);
            $campos->$campo = $campo;
            $idcolumna->$campo = $registro->idcolumna;
            @next($fila);
        }
        @reset($tabla);
        if ($i > 0 && !$repetirTitulo) {
            @next($tabla);
        } else {
            echo $tituloT;
        }
        $i ++;

        while ($fila = @current($tabla)) {
            $confila = 0;
            @reset($campos);
            while ($campo = @current($campos)) {
                if ($confila == 0) {
                    $id = $fila->$campo->idfila;
                    if ($fila->$campo->class_tr)
                        $clase = $fila->$campo->class_tr;
                    else
                        $clase = "";
                    if ($fila->$campo->resaltar)
                        $eventos = 'onClick="mouse(this);" onDblClick="quitamouse(this)"';
                    //$clase= $fila->$campo 
                    if (!isset($fila->$campo->valor) || trim($fila->$campo->valor) == '') {
                        @next($campos);
                        continue;
                    }
                    echo '<tr id="' . $id . '" name="' . $id . '" ' . $eventos . ' class="' . $clase . '" >';
                    $confila = 1;
                }

                //oculta las columnas en principio
                if (isset($idcolumna->$campo) and $mostrar == '')
                    $detalle_estilo = 'style="display:none"';
                else
                    $detalle_estilo = '';
                //fin ocultar columnas

                $ancho = '';
                if ($fila->$campo->ancho) {
                    $ancho = $fila->$campo->ancho;
                }

                if (isset($fila->$campo->valor)) {
                    if (isset($fila->$campo->titulo)) {
                        if ($fila->$campo->titulo == '#') {
                            $fila->$campo->titulo = formatear($fila->$campo->valor);
                        }
                        $tittem = substr($fila->$campo->titulo, 0, 1);
                        if ($tittem == '?') {
                            $fila->$campo->titulo = str_replace('?', '', $fila->$campo->titulo);

                            echo '<td width="' . $ancho . '" id="' . $idcolumna->$campo . '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true, STICKY, true)" ' . $detalle_estilo . '>';
                        } else if ($tittem == '|') {
                            $fila->$campo->titulo = str_replace('|', '', $fila->$campo->titulo);

                            echo '<td width="' . $ancho . '" id="' . $idcolumna->$campo . '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true, STICKY, true, CLICKCLOSE, true)" ' . $detalle_estilo . '>';
                        } else {
                            echo '<td width="' . $ancho . '" id="' . $idcolumna->$campo . '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true)" ' . $detalle_estilo . '>';
                        }
                    } else {
                        echo '<td width="' . $ancho . '" id="' . $idcolumna->$campo . '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" ' . $detalle_estilo . '>';
                    }
                } else {
                    echo '<td width="' . $ancho . '" id="' . $idcolumna->$campo . '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" ' . $detalle_estilo . '>';
                }
                if ($fila->$campo->enlace) {
                    echo '<a width="' . $ancho . '" class="' . $fila->$campo->clase . '" href="' . $fila->$campo->enlace . '" target="' . $fila->$campo->target . '">';
                }

                if (isset($fila->$campo->prefijo)) {
                    echo $fila->$campo->prefijo;
                }

                if (isset($fila->$campo->decimales) || isset($fila->$campo->divisor)) {
                    if (!isset($fila->$campo->decimales)) {
                        $decimalesT = 0;
                    } else {
                        $decimalesT = $fila->$campo->decimales;
                    }
                    if (!isset($fila->$campo->divisor)) {
                        $divisorT = 1;
                    } else {
                        $divisorT = $fila->$campo->divisor;
                    }
                    echo formatear($fila->$campo->valor, $decimalesT, $divisorT);
                } else {
                    echo $fila->$campo->valor;
                }

                if (isset($fila->$campo->sufijo)) {
                    echo $fila->$campo->sufijo;
                }

                //echo  '&nbsp';

                if ($fila->$campo->enlace) {
                    echo '</a>';
                }
                echo '</td>';
                @next($campos);
            }
            //echo '<td></td></tr>';
            @next($tabla);
        }
        @next($tablaArr);

        // echo '<tr id="'.$id.'"><td></td></tr>';
    }
    echo '</tbody>';
    // echo '</center>';
    //sleep(1);
}

function crearTabla2($tablaArr, $repetirTitulo = false) {
    $i = 0;
    echo '<center>
  	';
    echo '<table class="visible" id="tablaPrincipal">
  	';
    @reset($tablaArr);
    while ($tabla = @current($tablaArr)) {
        $tabla->reset();
        while ($registro = $tabla->getRegistro()) {
            $registro->reset();
            while ($campo = $registro->getCampo()) {
                $nombreCampo = $campo->getNombre();
                $campos->$nombreCampo = $nombreCampo;
            }
        }
        $tabla->reset();
        if ($i > 0 && !$repetirTitulo) {
            $tabla->getRegistro(); //Suprimir primera fila para mas de una tabla
        }
        $i ++;
        while ($registro = $tabla->getRegistro()) {
            echo '<tr>
    	  ';
            @reset($campos);
            while ($nombreCampo = @current($campos)) {
                @next($campos);
                $campo = $registro->getCampoPorNombre($nombreCampo);
                echo '<td class="' . $campo->getClase() . '" ';
                if ($campo->getTitulo()) {
                    echo 'onmouseover="Tip(\'' . $campo->getTitulo() . '\', SHADOW, true)"';
                }
                echo ' >
      	  ';

                if ($campo->getEnlace()) {
                    echo '<a class="' . $campo->getClase() . '" href="' . $campo->getEnlace() . '">';
                }

                if ($campo->getPrefijo()) {
                    echo $campo->getPrefijo();
                }

                if ($campo->getDecimales()) {
                    $decimalesT = $campo->getDecimales();
                } else {
                    $decimalesT = 0;
                }

                if ($campo->getDivisor()) {
                    $divisorT = $campo->getDivisor();
                } else {
                    $divisorT = 1;
                }

                if ($campo->getDivisor() || $campo->getDecimales()) {
                    echo formatear($campo->getValor(), $decimalesT, $divisorT);
                } else {
                    echo $campo->getValor();
                }

                if ($campo->getSufijo()) {
                    echo $campo->getSufijo();
                }

                if ($campo->getEnlace()) {
                    echo '</a>
      	    ';
                }

                echo '</td>
      	  ';
            }
            echo '<td></td></tr>
    	  ';
        }
        @next($tablaArr);
        echo '<tr><td></td></tr>
  	  ';
    }
    echo '</table>
 	  ';
    echo '</center>
   	';
}

/* creartabla1 yency */

function crearTabla1($tablaArr, $repetirTitulo = false, $tituloT = '', $widthT = '', $idT = 'tablaPrincipal', $mostrar = '') {
    $i = 0;
    echo '<center>';
    echo '<table border=0 width="' . $widthT . '" class="visible" id="' . $idT . '" name="' . $idT . '">';
    @reset($tablaArr);

    while ($tabla = @current($tablaArr)) {
        @reset($tabla);
        $fila = @current($tabla);
        @reset($fila);
        unset($campos);
        while ($registro = @current($fila)) {
            $campo = key($fila);
            $campos->$campo = $campo;
            $idcolumna->$campo = $registro->idcolumna;
            @next($fila);
        }
        @reset($tabla);
        if ($i > 0 && !$repetirTitulo) {
            @next($tabla);
        } else {
            echo $tituloT;
        }
        $i ++;

        while ($fila = @current($tabla)) {
            $confila = 0;
            @reset($campos);
            while ($campo = @current($campos)) {
                if ($confila == 0) {
                    $id = $fila->$campo->idfila;
                    if ($fila->$campo->class_tr)
                        $clase = $fila->$campo->class_tr;
                    else
                        $clase = "";
                    if ($fila->$campo->resaltar)
                        $eventos = 'onClick="mouse(this);" onDblClick="quitamouse(this)"';
                    //$clase= $fila->$campo 
                    if (!isset($fila->$campo->valor) || trim($fila->$campo->valor) == '') {
                        @next($campos);
                        continue;
                    }
                    echo '<tr id="' . $id . '" name="' . $id . '" ' . $eventos . ' class="' . $clase . '" >';
                    $confila = 1;
                }

                //oculta las columnas en principio
                if (isset($idcolumna->$campo) and $mostrar == '')
                    $detalle_estilo = 'style="display:none"';
                else
                    $detalle_estilo = '';
                //fin ocultar columnas

                $ancho = '';
                if ($fila->$campo->ancho) {
                    $ancho = $fila->$campo->ancho;
                }

                if (isset($fila->$campo->valor)) {
                    if (isset($fila->$campo->titulo)) {
                        if ($fila->$campo->titulo == '#') {
                            $fila->$campo->titulo = formatear($fila->$campo->valor);
                        }
                        $tittem = substr($fila->$campo->titulo, 0, 1);
                        if ($tittem == '?') {
                            $fila->$campo->titulo = str_replace('?', '', $fila->$campo->titulo);

                            echo '<td width="' . $ancho . '" id="' . $idcolumna->$campo . '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true, STICKY, true)" ' . $detalle_estilo . '>';
                        } else if ($tittem == '|') {
                            $fila->$campo->titulo = str_replace('|', '', $fila->$campo->titulo);

                            echo '<td width="' . $ancho . '" id="' . $idcolumna->$campo . '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true, STICKY, true, CLICKCLOSE, true)" ' . $detalle_estilo . '>';
                        } else {
                            echo '<td width="' . $ancho . '" id="' . $idcolumna->$campo . '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true)" ' . $detalle_estilo . '>';
                        }
                    } else {
                        echo '<td width="' . $ancho . '" id="' . $idcolumna->$campo . '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" ' . $detalle_estilo . '>';
                    }
                } else {
                    echo '<td width="' . $ancho . '" id="' . $idcolumna->$campo . '" name="' . $idcolumna->$campo . '" class="vacio" ' . $detalle_estilo . '>';
                }
                if ($fila->$campo->enlace) {
                    echo '<a width="' . $ancho . '" class="' . $fila->$campo->clase . '" href="' . $fila->$campo->enlace . '" target="' . $fila->$campo->target . '">';
                }

                if (isset($fila->$campo->prefijo)) {
                    echo $fila->$campo->prefijo;
                }

                if (isset($fila->$campo->decimales) || isset($fila->$campo->divisor)) {
                    if (!isset($fila->$campo->decimales)) {
                        $decimalesT = 0;
                    } else {
                        $decimalesT = $fila->$campo->decimales;
                    }
                    if (!isset($fila->$campo->divisor)) {
                        $divisorT = 1;
                    } else {
                        $divisorT = $fila->$campo->divisor;
                    }
                    echo formatear($fila->$campo->valor, $decimalesT, $divisorT);
                } else {
                    echo $fila->$campo->valor;
                }

                if (isset($fila->$campo->sufijo)) {
                    echo $fila->$campo->sufijo;
                }

                //echo  '&nbsp';

                if ($fila->$campo->enlace) {
                    echo '</a>';
                }
                echo '</td>';
                @next($campos);
            }
            //echo '<td></td></tr>';
            @next($tabla);
        }
        @next($tablaArr);

        // echo '<tr id="'.$id.'"><td></td></tr>';
    }
    echo '</table>';
    echo '</center>';
    //sleep(1);
}

/* creartabla1 yency */

/* creartabla7 vivi */

function crearTabla7($tablaArr, $repetirTitulo = false, $tituloT = '', $widthT = '', $idT = 'tablaPrincipal', $mostrar = '') {
    $i = 0;
    echo '<center>';
    echo '<table border=0 width="' . $widthT . '" class="visible" id="' . $idT . '" name="' . $idT . '">';
    @reset($tablaArr);

    while ($tabla = @current($tablaArr)) {
        @reset($tabla);
        $fila = @current($tabla);
        @reset($fila);
        unset($campos);
        while ($registro = @current($fila)) {
            $campo = key($fila);
            $campos->$campo = $campo;
            $idcolumna->$campo = $registro->idcolumna;
            $ocultar->$campo = $registro->ocultar;
            @next($fila);
        }
        @reset($tabla);
        if ($i > 0 && !$repetirTitulo) {
            @next($tabla);
        } else {
            echo $tituloT;
        }
        $i ++;

        while ($fila = @current($tabla)) {
            $confila = 0;
            @reset($campos);
            while ($campo = @current($campos)) {
                if ($confila == 0) {
                    $id = $fila->$campo->idfila;
                    if ($fila->$campo->class_tr)
                        $clase = $fila->$campo->class_tr;
                    else
                        $clase = "";
                    if ($fila->$campo->resaltar)
                        $eventos = 'onClick="mouse(this);" onDblClick="quitamouse(this)"';
                    //$clase= $fila->$campo
                    if (!isset($fila->$campo->valor) || trim($fila->$campo->valor) == '') {
                        @next($campos);
                        continue;
                    }
                    echo '<tr id="' . $id . '" name="' . $id . '" ' . $eventos . ' class="' . $clase . '" >';
                    $confila = 1;
                }

                //oculta las columnas en principio
                if (isset($idcolumna->$campo) and $ocultar->$campo != true and $mostrar == '')
                    $detalle_estilo = 'style="display:none"';
                else
                    $detalle_estilo = '';
                //fin ocultar columnas

                $ancho = '';
                if ($fila->$campo->ancho) {
                    $ancho = $fila->$campo->ancho;
                }

                if (isset($fila->$campo->valor)) {
                    if (isset($fila->$campo->titulo)) {
                        if ($fila->$campo->titulo == '#') {
                            $fila->$campo->titulo = formatear($fila->$campo->valor);
                        }
                        $tittem = substr($fila->$campo->titulo, 0, 1);
                        if ($tittem == '?') {
                            $fila->$campo->titulo = str_replace('?', '', $fila->$campo->titulo);

                            echo '<td width="' . $ancho . '" id="' . $idcolumna->$campo . '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true, STICKY, true)" ' . $detalle_estilo . '>';
                        } else if ($tittem == '|') {
                            $fila->$campo->titulo = str_replace('|', '', $fila->$campo->titulo);

                            echo '<td width="' . $ancho . '" id="' . $idcolumna->$campo . '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true, STICKY, true, CLICKCLOSE, true)" ' . $detalle_estilo . '>';
                        } else {
                            echo '<td width="' . $ancho . '" id="' . $idcolumna->$campo . '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true)" ' . $detalle_estilo . '>';
                        }
                    } else {
                        echo '<td width="' . $ancho . '" id="' . $idcolumna->$campo . '" name="' . $idcolumna->$campo . '" class="' . $fila->$campo->clase . '" ' . $detalle_estilo . '>';
                    }
                } else {
                    echo '<td width="' . $ancho . '" id="' . $idcolumna->$campo . '" name="' . $idcolumna->$campo . '" class="vacio" ' . $detalle_estilo . '>';
                }
                if ($fila->$campo->enlace) {
                    echo '<a width="' . $ancho . '" class="' . $fila->$campo->clase . '" href="' . $fila->$campo->enlace . '" target="' . $fila->$campo->target . '">';
                }

                if (isset($fila->$campo->prefijo)) {
                    echo $fila->$campo->prefijo;
                }

                if (isset($fila->$campo->decimales) || isset($fila->$campo->divisor)) {
                    if (!isset($fila->$campo->decimales)) {
                        $decimalesT = 0;
                    } else {
                        $decimalesT = $fila->$campo->decimales;
                    }
                    if (!isset($fila->$campo->divisor)) {
                        $divisorT = 1;
                    } else {
                        $divisorT = $fila->$campo->divisor;
                    }
                    echo formatear($fila->$campo->valor, $decimalesT, $divisorT);
                } else {
                    echo $fila->$campo->valor;
                }

                if (isset($fila->$campo->sufijo)) {
                    echo $fila->$campo->sufijo;
                }

                //echo  '&nbsp';

                if ($fila->$campo->enlace) {
                    echo '</a>';
                }
                echo '</td>';
                @next($campos);
            }
            //echo '<td></td></tr>';
            @next($tabla);
        }
        @next($tablaArr);

        // echo '<tr id="'.$id.'"><td></td></tr>';
    }
    echo '</table>';
    echo '</center>';
//sleep(1);
}

/* creartabla7 vivi */

function crearTablaOrdenar1($tablaArr, $nrofilas, $repetirTitulo = false, $idT = 'tablaPrincipal') {
    $i = 0;
    $cont = 0;
    echo '<center>
  	';
    echo '<table class="sortable"  id="' . $idT . '" name="' . $idT . '">
  	';
    @reset($tablaArr);
    while ($tabla = @current($tablaArr)) {
        @reset($tabla);
        $fila = @current($tabla);
        unset($campos);
        while ($registro = @current($fila)) {
            $campo = key($fila);
            $campos->$campo = $campo;
            @next($fila);
        }
        @reset($tabla);
        if ($i > 0 && !$repetirTitulo) {
            @next($tabla);
        }
        $i ++;

        while ($fila = @current($tabla)) {
            if ($cont == 0)
                echo "<thead>";
            if ($cont == 1)
                echo "<tbody>";

            //echo '<tr>';
            $confila = 0;
            @reset($campos);
            while ($campo = @current($campos)) {
                if ($confila == 0) {
                    $id = $fila->$campo->idfila;
                    if ($fila->$campo->resaltar)
                        $eventos = 'onClick="mouse(this);" onDblClick="quitamouse(this)"';
                    if ($fila->$campo->class_tr)
                        $clase = $fila->$campo->class_tr;
                    else
                        $clase = "";

                    echo '<tr id="' . $id . '" name="' . $id . '" ' . $eventos  . ' class="' . $clase . '" >';
                    $confila = 1;
                }

                if (isset($fila->$campo->valor)) {
                    if (isset($fila->$campo->titulo)) {
                        echo '<td id="' . $campo . '" class="' . $fila->$campo->clase . '" onmouseover="Tip(\'' . $fila->$campo->titulo . '\', SHADOW, true)">
          	  ';
                    } else {
                        echo '<td id="' . $campo . '" class="' . $fila->$campo->clase . '">
          	  ';
                    }
                } else {
                    echo '<td id="' . $campo . '" class="vacio">
        	  ';
                }
                if ($fila->$campo->enlace) {
                    echo '<a class="' . $fila->$campo->clase . '" href="' . $fila->$campo->enlace . '" target="' . $fila->$campo->target . '">';
                }

                if (isset($fila->$campo->prefijo)) {
                    echo $fila->$campo->prefijo;
                }

                if (isset($fila->$campo->decimales) || isset($fila->$campo->divisor)) {
                    if (!isset($fila->$campo->decimales)) {
                        $decimalesT = 0;
                    } else {
                        $decimalesT = $fila->$campo->decimales;
                    }
                    if (!isset($fila->$campo->divisor)) {
                        $divisorT = 1;
                    } else {
                        $divisorT = $fila->$campo->divisor;
                    }
                    echo formatear($fila->$campo->valor, $decimalesT, $divisorT);
                } else {
                    echo $fila->$campo->valor;
                }

                if (isset($fila->$campo->sufijo)) {
                    echo $fila->$campo->sufijo;
                }

                //echo  '&nbsp';

                if ($fila->$campo->enlace) {
                    echo '</a>';
                }
                echo '</td>
      	  ';
                @next($campos);
            }
            //  echo '<td></td></tr>';
            @next($tabla);

            if ($cont == 0)
                echo "</thead>";
            if ($cont == $nrofilas - 1)
                echo "</body><tfoot>";


            ++$cont;
        }
        @next($tablaArr);
        // echo '<tr><td></td></tr>';
    }
    echo '</tfoot></table>
 	  ';
    echo '</center>
   	';
}

function armadorProgramas($lista, $programas) {
    print"<table>";
    $tres = 0;
    $cat = 0;
    foreach ($programas as $fila) {
        if ($cat == 0) {
            $categoriaInicial = $fila["grupo"];
            echo "<tr><td style='padding:10px'><label class='h4'><b>" . $categoriaInicial . "</b></label></td></tr>";
            print "<tr>";
            $cat++;
        }
        if ($categoriaInicial != $fila["grupo"]) {
            $categoriaInicial = $fila["grupo"];
            $tres = 0;
            print "</tr><tr class='border_bottom'><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
            echo "<tr><td style='padding:10px'><label class='h4'><b>" . $fila["grupo"] . "</b></label></td></tr>";
            print "<tr>";
        }
        if ($lista[trim($fila["orden"])] != '') {
            print "<td style='padding-left:10px' valign='middle'><input style='float:left' type='checkbox' checked='checked' name='selecionados[" . trim($fila["orden"]) . "]' value='" . trim($fila["orden"]) . "' /><label class='h5'>" . $fila["descrip"] . "</label></td>";
        } else {
            print "<td style='padding-left:10px' valign='middle'><input style='float:left'
                type='checkbox' name='selecionados[" . trim($fila["orden"]) . "]' value='" . trim($fila["orden"]) . "' /><label class='h5'>" . $fila["descrip"] . "</label></td>";
        }
        $tres++;
        if ($tres == 6) {
            $tres = 0;
            print "</tr><tr>";
        }
    }
    print "</table>";
}

Function nombreConexionX($codsuc) {
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
    else if ($codsuc > 69 || $codsuc == 1)
        $conexion = 'ifxibgdir';
    else {
        echo "<hr><center>SERVICIO NO DISPONIBLE PARA SU SUCURSAL</center><hr>";
        exit;
    }
    return $conexion;
}

function agregaCelda(&$objeto, $params, $separador1 = ";", $separador2 = ":") {
    $arr_param = explode($separador1, $params);
    $flag_sumar = false;
    foreach ($arr_param as $param) {
        $arr_campo = explode($separador2, $param);
        $campo = trim($arr_campo[0]);
        $valor = trim($arr_campo[1]);
        if ($campo == "" || $valor == "") {
            continue;
        }
        if ($campo == "sumar") {
            if ($valor == true) {
                $flag_sumar = true;
            }
        } else if ($campo == "valor" && $flag_sumar == true) {
            $objeto->$campo += $valor;
        } else {
            $objeto->$campo = $valor;
        }
    }
}

function agregaPromedio(&$objeto, $campo, $campo1, $campo2) {
    if ($objeto->$campo2->valor > 0) {
        $objeto->$campo->valor = $objeto->$campo1->valor / $objeto->$campo2->valor * 100;
    } else {
        $objeto->$campo->valor = 0;
    }
    $objeto->$campo->decimales = 2;
    $objeto->$campo->sufijo = '%';
}

function formatear($valor, $decimales = 0, $divisor = 1, $carDecimales = ',', $carMiles = '.') {
    $valort = number_format($valor / $divisor, $decimales, $carDecimales, $carMiles);
    return $valort;
}

function nombremes($mes) {
    setlocale(LC_TIME, 'spanish');
    $nombre = strftime("%B", mktime(0, 0, 0, $mes, 1, 2000));
    return $nombre;
}

function retornarTablaOrdenar1($tablaArr, $nrofilas, $repetirTitulo = false, $idT = 'tablaPrincipal') {
    $i = 0;
    $cont = 0;
    $html ="<center>";
    $html .=  "<table class='sortable'  id='$idT' name='$idT'>";
    @reset($tablaArr);
    while ($tabla = @current($tablaArr)) {
        @reset($tabla);
        $fila = @current($tabla);
        unset($campos);
        while ($registro = @current($fila)) {
            $campo = key($fila);
            $campos->$campo = $campo;
            @next($fila);
        }
        @reset($tabla);
        if ($i > 0 && !$repetirTitulo) {
            @next($tabla);
        }
        $i ++;

        while ($fila = @current($tabla)) {
            if ($cont == 0)
                $html .=  "<thead>";
            if ($cont == 1)
                $html .=  "<tbody>";

            //$html .=  '<tr>';
            $confila = 0;
            @reset($campos);
            while ($campo = @current($campos)) {
                if ($confila == 0) {
                    $id = $fila->$campo->idfila;
                    if ($fila->$campo->resaltar)
                        $eventos = "onClick='mouse(this);' onDblClick='quitamouse(this)'";
                    if ($fila->$campo->class_tr)
                        $clase = $fila->$campo->class_tr;
                    else
                        $clase = "";

                    $html .=  "<tr id='$id' name='$id' $eventos class='$clase'>";
                    $confila = 1;
                }

                if (isset($fila->$campo->valor)) {
                    if (isset($fila->$campo->titulo)) {
                        $html .=  "<td id='$campo' class='".$fila->$campo->clase."' onmouseover='Tip(\"".$fila->$campo->titulo."\",SHADOW,true)'>";
                    } else {
                        $html .=  "<td id='$campo' class='". $fila->$campo->clase ."'>";
                    }
                } else {
                    $html .=  "<td id='$campo' class='vacio'>";
                }
                if ($fila->$campo->enlace) {
                    $html .=  "<a class='" . $fila->$campo->clase . "' href='" . $fila->$campo->enlace . "' target='" . $fila->$campo->target . "'>";
                }

                if (isset($fila->$campo->prefijo)) {
                    $html .=  $fila->$campo->prefijo;
                }

                if (isset($fila->$campo->decimales) || isset($fila->$campo->divisor)) {
                    if (!isset($fila->$campo->decimales)) {
                        $decimalesT = 0;
                    } else {
                        $decimalesT = $fila->$campo->decimales;
                    }
                    if (!isset($fila->$campo->divisor)) {
                        $divisorT = 1;
                    } else {
                        $divisorT = $fila->$campo->divisor;
                    }
                    $html .=  formatear($fila->$campo->valor, $decimalesT, $divisorT);
                } else {
                    $html .=  $fila->$campo->valor;
                }

                if (isset($fila->$campo->sufijo)) {
                    $html .=  $fila->$campo->sufijo;
                }

                //$html .=   '&nbsp';

                if ($fila->$campo->enlace) {
                    $html .=  "</a>";
                }
                $html .=  "</td>";
                @next($campos);
            }
            //  $html .=  '<td></td></tr>';
            @next($tabla);

            if ($cont == 0)
                $html .=  "</thead>";
            if ($cont == $nrofilas - 1)
                $html .=  "</body><tfoot>";


            ++$cont;
        }
        @next($tablaArr);
        // $html .=  '<tr><td></td></tr>';
    }
    $html .=  "</tfoot></table>";
    $html .=  "</center>";
	return $html;
}
?>