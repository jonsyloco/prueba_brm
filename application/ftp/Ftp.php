<?php

/** Librería Ftp
 * 	
 * 2009 : ) Alejo (ibg_alejo_sistemas@hotmail.com)
 * 	
 */
class Ftp {

    function __construct($servidor = '', $usuario = '', $clave = '', $debug = false) {
        $this->debug = $debug;
        if ($this->debug)
            echo "Entra Ftp<br>";
        $this->reset();
        if (trim($servidor) != '') {
            $this->servidor = $servidor;
        } else {
            exit("Ftp Error 001");
        }
        if (trim($usuario) != '') {
            $this->usuario = $usuario;
        } else {
            exit("Ftp Error 002");
        }
        if (trim($clave) != '') {
            $this->clave = $clave;
        } else {
            exit("Ftp Error 003");
        }
        $this->conectar();
        if ($this->debug)
            echo "Sale Ftp<br>";
    }

    function reset() {
        if ($this->debug)
            echo "Entra Reset<br>";
        @$this->conexion = '';
        @$this->archivo = '';
        @$this->directorio = '';
        @$this->registros = 0;
        @$this->registro = array();
        @$this->campo = array();
        if ($this->debug)
            echo "Sale Reset<br>";
    }

    function reset2() {
        if ($this->debug)
            echo "Entra Reset<br>";

        @$this->archivo = '';
        @$this->directorio = '';
        @$this->registros = 0;
        @$this->registro = array();
        @$this->campo = array();
        if ($this->debug)
            echo "Sale Reset<br>";
    }

    function conectar() {
        if ($this->debug)
            echo "Entra Conectar<br>";
        $conexion = @ftp_connect($this->servidor);
        if (!$conexion) {
            exit("Ftp Error 004");
        }
        $conectado = @ftp_login($conexion, $this->usuario, $this->clave);
        if (!$conectado) {
            exit("Ftp Error 005");
        }
        $this->conexion = $conexion;
        if ($this->debug)
            echo "Sale Conectar<br>";
    }

    function directorio($directorio) {
        if ($this->debug)
            echo "Entra directorio<br>";
        if (@ftp_chdir($this->conexion, $directorio)) {
            $this->directorio = $directorio;
        } else {
            exit("Ftp Error 006 ($directorio)");
        }
        if ($this->debug)
            echo "Sale directorio<br>";
    }

    function ftp_fetch($stream, $archivo) {
        if ($this->debug)
            echo "Entra ftp_fetch<br>";
        //ob_end_flush();
        ob_start();
        $out = fopen('php://output', 'w');
        if (!@ftp_fget($stream, $out, $archivo, FTP_ASCII)) {
            // exit ("Ftp Error 007 ($archivo)");
            return false;
        }
        fclose($out);
        $data = ob_get_clean();
        if ($this->debug)
            echo "Sale ftp_fetch<br>";
        return $data;
    }

    function traerPlano($archivo) {
        $this->archivo = $archivo;
        if ($this->debug)
            echo "Entra traer<br>";
        $contenido = $this->ftp_fetch($this->conexion, $archivo);
        return trim($contenido);
    }

    function traer($archivo) {
        $this->archivo = $archivo;
        if ($this->debug)
            echo "Entra traer<br>";

        $contenido = $this->ftp_fetch($this->conexion, $archivo);
        if (!$contenido) {
            return false;
        }

        $contenido = explode("\n", $contenido);
        @reset($contenido);
        $campos = @current($contenido);
        @next($contenido);
        $campos = explode("|", $campos);
        $this->campo = $campos;
        $contador = 0;
        while ($registros = @current($contenido)) {
            @reset($campos);
            $registros = explode("|", $registros);
            while ($campo = @current($campos)) {
                $registro = @current($registros);
                if ($campo == trim($registro)) {
                    @next($campos);
                    @next($registros);
                    continue;
                }
                $arreglo[$contador][$campo] = $registro;
                @next($campos);
                @next($registros);
            }
            @next($contenido);
            $contador ++;
        }
        $this->registros = $contador;

        @reset($arreglo);
        $this->registro = $arreglo;
        if ($this->debug)
            echo "Sale traer<br>";
        return true;
    }

    function getRegistro() {
        if ($registro = @current($this->registro)) {
            @next($this->registro);
            return $registro;
        } else {
            return false;
        }
    }

    function prevRegistro() {
        if (@prev($this->registro)) {
            return true;
        } else {
            return false;
        }
    }

    function nextRegistro() {
        if (@next($this->registro)) {
            return true;
        } else {
            return false;
        }
    }

    function firstRegistro() {
        @reset($this->registro);
    }

    function verdatos() {
        echo '<table border = "1">';

        echo '<tr>';
        @reset($this->campo);
        while ($campo = @current($this->campo)) {
            @next($this->campo);
            echo '<td>';
            echo $campo;
            echo '</td>';
        }

        echo '</tr>';

        @reset($this->registro);
        while ($registro = @current($this->registro)) {
            @next($this->registro);
            @reset($this->campo);
            echo '<tr>';
            while ($campo = @current($this->campo)) {
                @next($this->campo);
                echo '<td>';
                echo $registro[$campo] . '&nbsp;';
                echo '</td>';
            }
            echo '</tr>';
        }

        echo '</table>';
        @reset($this->campo);
        @reset($this->registro);
    }

}

?>