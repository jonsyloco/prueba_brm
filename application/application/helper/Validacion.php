<?php

/**
 *  Una clase que sirve para realizar algunas validaciones y filtros en los datos que se reciben del cliente.
 *  usa varias metodos de validacion de la libreria  Form Validation de Codeigniter.
 */
class Validacion {

  public $reglas = array();
  public $errores = array();
  public $mensajes_personalizados = array();

  /* --------------------- inicio metodos de filtracion y limpieza de datos ----------------- */

  /**
   * Elimina todos los caracteres execpto letras, numeros y !#$%&â€™*+-/=?^_`{|}~@.[].
   * @param String $email: el email a limpiar
   * @return type
   */
  public function limpiar_email($email) {
    return filter_var($email, FILTER_SANITIZE_EMAIL);
  }

  // ------------------------------------------------------------------------

  /**
   * Elimina todos los caracteres excepto digitos y los signos de suma y resta. 
   * @param integer $entero: el numero entero a limpiar
   */
  public function limpiar_entero($entero) {
    return filter_var($entero, FILTER_SANITIZE_NUMBER_INT);
  }

  // ------------------------------------------------------------------------

  /**
   * Elimina todos los caracteres a excepción de los dígitos, +- y, opcionalmente, .,eE.
   * @param float $float: el numero double o flotante a limpiar
   * @param boolean $separador_coma : Permite usar un punto (.) como separador de decimales en los numeros. 
   */
  public function limpiar_float($float, $separador_coma = TRUE) {
    if ($separador_coma)
      return filter_var($float, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    return filter_var($float, FILTER_SANITIZE_NUMBER_FLOAT);
  }

  // ------------------------------------------------------------------------

  /**
   * Elimina etiquetas html y de php que vayan alojadas en la variable
   * @param String $cadena: la cadena a limpiar
   */
  public function filtro_xss($cadena) {
    // FILTER_SANITIZE_STRING --  Elimina etiquetas, opcionalmente elimina o codifica caracteres especiales.
    $cadena = filter_var($cadena, FILTER_SANITIZE_STRING);
    // Retira las etiquetas HTML y PHP de un string
    return strip_tags($cadena);
  }

  // ------------------------------------------------------------------------

  /* --------------------fin metodos de filtracion y limpieza de datos ------------------ */
  /* ------------------------------------------------------------------------------------------------------------------------------------------------- */
  /* ------------------- inicio metodos de validacion de datos-------------------------- */

  public function required($cadena, $label, $mensaje_personalizado = '') {
    $resultado = 0;

    if (is_array($cadena))
      $resultado = count($cadena);
    else
      $resultado = strlen($cadena);

    if ($resultado > 0)
      return TRUE;
    if ($mensaje_personalizado !== '') {
      $mensaje_personalizado = str_replace('%s', $label, $mensaje_personalizado);
      return $mensaje_personalizado;
    }
    return 'El campo ' . $label . ' es requerido';
  }

  // ------------------------------------------------------------------------

  public function min_length($cadena, $tamaño, $label, $mensaje_personalizado = '') {
    $resultado = strlen($cadena);
    if ($tamaño <= $resultado)
      return TRUE;
    if ($mensaje_personalizado !== '') {
      $mensaje_personalizado = str_replace('%s', $label, $mensaje_personalizado);
      return $mensaje_personalizado;
    }
    return 'El campo ' . $label . ' tiene un tama&ntilde;o menor a ' . $tamaño;
  }

  // ------------------------------------------------------------------------

  public function max_length($cadena, $tamaño, $label, $mensaje_personalizado = '') {
    $resultado = strlen($cadena);
    if ($tamaño >= $resultado)
      return TRUE;
    if ($mensaje_personalizado !== '') {
      $mensaje_personalizado = str_replace('%s', $label, $mensaje_personalizado);
      return $mensaje_personalizado;
    }
    return 'El campo ' . $label . ' tiene un tama&ntilde;o mayor a ' . $tamaño;
  }

  // ------------------------------------------------------------------------

  public function alpha($cadena, $label, $mensaje_personalizado = '') {
    if (ctype_alpha($cadena))
      return TRUE;
    if ($mensaje_personalizado !== '') {
      $mensaje_personalizado = str_replace('%s', $label, $mensaje_personalizado);
      return $mensaje_personalizado;
    }
    return 'El campo ' . $label . ' no es solo de letras';
  }

  // ------------------------------------------------------------------------

  public function alpha_numeric($cadena, $label, $mensaje_personalizado = '') {
    if (ctype_alnum($cadena))
      return TRUE;
    if ($mensaje_personalizado !== '') {
      $mensaje_personalizado = str_replace('%s', $label, $mensaje_personalizado);
      return $mensaje_personalizado;
    }
    return 'El campo ' . $label . ' no es solo letras y numeros';
  }

  // ------------------------------------------------------------------------

  public function alpha_numeric_spaces($cadena, $label, $mensaje_personalizado = '') {
    if (preg_match('/^[A-Z0-9 ]+$/i', $cadena))
      return TRUE;
    if ($mensaje_personalizado !== '') {
      $mensaje_personalizado = str_replace('%s', $label, $mensaje_personalizado);
      return $mensaje_personalizado;
    }
    return 'El campo ' . $label . ' no es solo letras, numeros y espacios';
  }

  // ------------------------------------------------------------------------

  public function email($cadena, $label, $mensaje_personalizado = '') {
    if (filter_var($cadena, FILTER_VALIDATE_EMAIL))
      return TRUE;
    if ($mensaje_personalizado !== '') {
      $mensaje_personalizado = str_replace('%s', $label, $mensaje_personalizado);
      return $mensaje_personalizado;
    }
    return 'El campo ' . $label . ' no es un email valido';
  }

  // ------------------------------------------------------------------------

  public function numeric($cadena, $label, $mensaje_personalizado = '') {
    if (preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $cadena))
      return TRUE;
    if ($mensaje_personalizado !== '') {
      $mensaje_personalizado = str_replace('%s', $label, $mensaje_personalizado);
      return $mensaje_personalizado;
    }
    return 'El campo ' . $label . ' no es numerico';
  }

  // ------------------------------------------------------------------------

  public function integer($cadena, $label, $mensaje_personalizado = '') {
    if (preg_match('/^[\-+]?[0-9]+$/', $cadena))
      return TRUE;
    if ($mensaje_personalizado !== '') {
      $mensaje_personalizado = str_replace('%s', $label, $mensaje_personalizado);
      return $mensaje_personalizado;
    }
    return 'El campo ' . $label . ' no es un numero entero';
  }

  // ------------------------------------------------------------------------

  public function decimal($cadena, $label, $mensaje_personalizado = '') {
    if (preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $cadena))
      return TRUE;
    if ($mensaje_personalizado !== '') {
      $mensaje_personalizado = str_replace('%s', $label, $mensaje_personalizado);
      return $mensaje_personalizado;
    }
    return 'El campo ' . $label . ' no es un decimal';
  }

  // ------------------------------------------------------------------------

  public function is_natural($cadena, $label, $mensaje_personalizado = '') {
    if (ctype_digit((string) $cadena))
      return TRUE;
    if ($mensaje_personalizado !== '') {
      $mensaje_personalizado = str_replace('%s', $label, $mensaje_personalizado);
      return $mensaje_personalizado;
    }
    return 'El campo ' . $label . ' no es un numero natural';
  }

  // ------------------------------------------------------------------------

  public function is_natural_no_zero($cadena, $label, $mensaje_personalizado = '') {
    if ($cadena != 0 && ctype_digit((string) $cadena))
      return TRUE;
    if ($mensaje_personalizado !== '') {
      $mensaje_personalizado = str_replace('%s', $label, $mensaje_personalizado);
      return $mensaje_personalizado;
    }
    return 'El campo ' . $label . ' no es un numero natural';
  }

  // ------------------------------------------------------------------------

  public function valid_base64($cadena, $label, $mensaje_personalizado = '') {
    if ((base64_encode(base64_decode($cadena)) === $cadena))
      return TRUE;
    if ($mensaje_personalizado !== '') {
      $mensaje_personalizado = str_replace('%s', $label, $mensaje_personalizado);
      return $mensaje_personalizado;
    }
    return 'El campo ' . $label . ' contiene algo que no es un caracter Base64';
  }

  // ------------------------------------------------------------------------

  /**
   * Establece las reglas de validacion por las cuales se procesara un determinado dato.el orden en que se ingresen sera el orden en que se ejecuten.
   * @param String $campo : es el indice con el cual se asociara la regla de validacion, generalmente es el mismo indice del valor obtenido por el metodo POST O GET.
   * @param String $label : Es el nombre del campo al cual se dara la validacion, es solo para especificar el nombre del campo cuando se obtenga un mensaje de error.
   *                        generalmente es el mismo nombre del campo a validar, es el nombre visual el cual ve el usuario no el name
   * @param cualquier tipo $valor : es el valor a validar
   * @param array $reglas: es un arreglo con las diferentes reglas de validacion definidas para procesar en forma secuencial , en el mismo orden en que son especificadas.
   *  
   * NOTA: las reglas de validacion estan en continuo desarrollo, las reglas que ya estan definidas y se pueden ejecutar son las siguientes:
   * 
   * NOTA: existen dos tipos de reglas de validacion, las que no necesitan parametro y las que si
   *       las que necesitan de un parametro para su validacion se meten dentro de un array asociativo como en el ejemplo dado.
   *       las unicas reglas con dos parametros son min_length y max_length
   * 
   *  1- required:       verifica que el dato no venga vacio, sea requerido: array('required'). NOTA: el required funciona con un array. las demas reglas no los soporta <br> 
   *  2- min_length:     verifica que el dato tenga un tamaño minimo especificado por el desarrollador : array(array('min_length'=> 10)) <br>
   *  3- max_length:     verifica que el dato tenga un tamaño maximo especificado por el desarrollador : array(array('max_length'=> 5)) <br>
   *  4- alpha:          verifica que el dato sea solo de caracteres alfabeticos <br> 
   *  5- alpha_numeric:  verifica que el dato sea alfanumerico <br>
   *  6- alpha_numeric_spaces: verifica que el dato sea alfanumerico y pueda contener espacios <br>
   *  7- email :         verifica que el dato sea un email valido <br>
   *  8- numeric:        verifica que el dato sea de caracteres numericos <br>
   *  9- integer:        verifica que el dato se aun numero entero <br>
   *  10- decimal:       verifica que el dato sea un numero decimal <br>
   *  11- is_natural:    verifica que el dato sea un numero natural <br>
   *  12- is_natural_no_zero: verifica que el dato sea un numero natural excluyendo el cero <br>
   *  13- valid_base64:  verifica que el dato solo contenga caracteres  en Base64 <br>
   */
  public function poner_regla($campo, $label, $valor, $reglas) {
    $this->reglas[$campo] = array($campo, $label, $valor, $reglas);
  }

  // ------------------------------------------------------------------------

  /**
   * Se encarga de obtener el error de validacion generado. se obtiene atravez del indice asociado a la regla de validacion
   * @param String $campo: es el indice con el cual se asocio la regla de validacion cuando fue creada.
   */
  public function obtener_error($campo) {
    if (isset($this->errores[$campo]))
      return $this->errores[$campo];
    return '';
  }

  // ------------------------------------------------------------------------

  /**
   * Ejecuta todas las reglas de validacion establecidas y en caso de error de validacion guardara su correspondiente mensaje de error en un arreglo de errores
   */
  public function run() {
    foreach ($this->reglas as $valor) {
      $campo = $valor[0];
      $label = $valor[1];
      $valor_variable = $valor[2];
      $reglas = $valor[3];

      foreach ($reglas as $valor_reglas) {
        if (is_array($valor_reglas)) {
          $nombre_metodo = key($valor_reglas);
          if (isset($this->mensajes_personalizados[$nombre_metodo]))
            $metodo_respuesta = $this->$nombre_metodo($valor_variable, $valor_reglas[$nombre_metodo], $label, $this->mensajes_personalizados[$nombre_metodo]);
          else
            $metodo_respuesta = $this->$nombre_metodo($valor_variable, $valor_reglas[$nombre_metodo], $label);
        } else {
          if (isset($this->mensajes_personalizados[$valor_reglas]))
            $metodo_respuesta = $this->$valor_reglas($valor_variable, $label, $this->mensajes_personalizados[$valor_reglas]);
          else
            $metodo_respuesta = $this->$valor_reglas($valor_variable, $label);
        }

        if ($metodo_respuesta !== TRUE) {
          $this->errores[$campo] = $metodo_respuesta;
          break;
        }
      }
    }
  }

  // ------------------------------------------------------------------------

  /**
   * Retorna TRUE cuando no se violo ninguna regla de validacion, devuelve FALSE cuando minimo una regla de validacion no fue exitosa.
   * @return boolean: TRUE O FALSE
   */
  public function obtener_estado_validacion() {
    if (count($this->errores) > 0)
      return FALSE;
    return TRUE;
  }

  // ------------------------------------------------------------------------

  /**
   * Especifica un mensaje de error para una determinada regla en caso de que no se quiera usar la que viene por defecto.
   * @param String $regla: el nombre de la regla de validacion.
   * @param String $mensaje: el mensaje que se le quiera aplicar a la regla en caso de que haya un error de esta.
    NOTA: si indica en el mensaje personalizado los caracteres %s el metodo lo remplazara por el label o nombre que espesifico cuando
   *               creo la regla de validacion en el segundo parametro, el cual es un nombre del campo que vera el usuario final en la vista. 
   */
  public function poner_mensaje($regla, $mensaje) {
    $this->mensajes_personalizados[$regla] = $mensaje;
  }

  /* -------------------- fin metodos de validacion de datos----------------------------- */
}

?>