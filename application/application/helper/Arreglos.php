<?php

/**
 *
 * Le permite extraer un elemento desde un array. La funcion prueba si el indice del array esta establecido y si tiene valor.
 * Si el valor existe se devuelve. Si el valor no existe, devuelve FALSE, o lo que haya especificado como valor por defecto en el tercer parametro.
 *
 * @param	string $valor El valor a buscar en el array
 * @param	array $arreglo El arreglo a analizar
 * @param	String $default (opcional) cambia el valor por default del retorno en caso de no encontrar nada
 */
function element($valor, $arreglo, $default = NULL) {
  return array_key_exists($valor, $arreglo) ? $arreglo[$valor] : $default;
}

// ------------------------------------------------------------------------

/**
 * Toma como entrada un array y devuelve un elemento suyo al azar.
 *
 * @param	array
 */
function random_element($arreglo) {
  return is_array($arreglo) ? $arreglo[array_rand($arreglo)] : $arreglo;
}

// --------------------------------------------------------------------

/**
 *
 * Le permite extraer una cantidad de elementos desde un array.
 * La funcion prueba si cada uno de los indices del array esta establecido. 
 * Si un indice no existe se establece a FALSE, o lo que sea que se haya especificado como valor por defecto a traves del tercer parametro.
 *
 * @param	array $items Los indices que seran buscandos en el array
 * @param	array $arreglo el arreglo a procesar
 * @param   String $default (opcional) cambia el valor por default del retorno en caso de no encontrar nada
 */
function elements($items, $arreglo, $default = NULL) {
  $return = array();

  is_array($items) OR $items = array($items);

  foreach ($items as $item) {
    $return[$item] = array_key_exists($item, $arreglo) ? $arreglo[$item] : $default;
  }

  return $return;
}

// ------------------------------------------------------------------------

/**
 * Su funcionamiento es identico al order by de sql.
 * @param array $datos: los datos que se van a ordenar
 * @param array $campos_ordenar: un arreglo especificando los campos con los cuales se desean ordenar
 * @param String $order_by: puede ser ASC o DESC
 * @param array $tipo_ordenamiento: (es opcional) el tamano de este arreglo debe ser igual al array de los campos de ordenamiento y la posicion de sus indices
 * se referencian entre si, en este arreglo se especifica como debe ser ordenado el campo correspondiente a la posicion de ambos arreglos, puede ser ASC O DESC
 * @return retorna un arreglo ordenado
 */
function order_by($datos, $campos_ordenar, $order_by = 'ASC', $tipo_ordenamiento = array()) {
  if ($order_by === 'ASC')
    $order_by = 'SORT_ASC';
  else if ($order_by === 'DESC')
    $order_by = 'SORT_DESC';
  else
    $order_by = 'SORT_ASC';

  /* Obtener una lista de columnas */
  $arreglos = '';
  $cadena_multisort = 'array_multisort(';

  if (!empty($tipo_ordenamiento)) {
    for ($i = 0; $i < count($campos_ordenar); $i++) {
      $nombre_campo = $campos_ordenar[$i];
      $tipo_orden = $tipo_ordenamiento[$i];

      if ($tipo_orden === 'ASC')
        $tipo_orden = 'SORT_ASC';
      else if ($tipo_orden === 'DESC')
        $tipo_orden = 'SORT_DESC';
      else
        $tipo_orden = 'SORT_ASC';

      $arreglos = $arreglos . '$' . "$nombre_campo [" . '$' . "clave] = $" . "fila['$nombre_campo'];";
      $cadena_multisort = $cadena_multisort . '$' . "$nombre_campo, $tipo_orden,";
    }
  } else
    foreach ($campos_ordenar as $campos) {
      $nombre_campo = $campos;
      $arreglos = $arreglos . '$' . "$nombre_campo [" . '$' . "clave] = $" . "fila['$nombre_campo'];";
      $cadena_multisort = $cadena_multisort . '$' . "$nombre_campo, $order_by,";
    }
  // $cadena_multisort = 'array_multisort($volumen, SORT_DESC, $edici�n, SORT_D, $nombre, SORT_ASC, $datos);';
  $cadena_multisort .= '$datos);';

  foreach ($datos as $clave => $fila) {
    eval($arreglos);
  }

  eval($cadena_multisort);
  return $datos;
}

// ------------------------------------------------------------------------

/**
 * Elimina los registros repetidos y devuelte un arreglo con valores unicos en todos sus campos
 * @param Array $array: el arreglo a procesar
 */
function registros_unicos($array) {
  $result = array_map("unserialize", array_unique(array_map("serialize", $array)));

  foreach ($result as $key => $value) {
    if (is_array($value)) {
      $result[$key] = registros_unicos($value);
    }
  }

  return $result;
}

// ------------------------------------------------------------------------

/**
 * Obtiene los valores que se duplican en un array
 * @param type $array: el arreglo a procesar
 */
function get_duplicados($array) {
  if (!is_array($array)) {
    return false;
  }

  $duplicates = array();
  foreach ($array as $key => $val) {
    end($array);
    $k = key($array);
    $v = current($array);

    while ($k !== $key) {
      if ($v === $val) {
        $duplicates[$key] = $v;
        break;
      }

      $v = prev($array);
      $k = key($array);
    }
  }

  return $duplicates;
}

// ------------------------------------------------------------------------

/**
 * Busca un valor en el arreglo y devuelve y retorna el arreglo de datos que lo posee
 * @param Array $arreglo el arreglo a procesar
 * @param String $filtro_busqueda El valor a buscar en el arreglo
 */
function buscar_registro($arreglo, $filtro_busqueda) {

  $arreglo_final = array();
  foreach ($arreglo as $key => $fila) {
    if (is_array($fila)) {
      foreach ($fila as $registro) {
        if ($registro == $filtro_busqueda) {
          $arreglo_final[$key] = $fila;
        }
      }
    } else {
      if ($fila == $filtro_busqueda)
        $arreglo_final[] = $fila;
    }
  }

  return $arreglo_final;
}

?>