<?php

/* El controlador que se ejecutara por defecto junto con su metodo por defecto */
define('CONTROLADOR_DEFECTO', 'Inventario');
define('ACCION_DEFECTO', 'index');

/*
  todos los proyectos apuntaran a la raiz de la carpeta que contiene el MVC junto con todas las funciones y librerias que se usaran
  y de esa forma reutilizar codigo y ahorrar espacio en disco.
 */
define('RUTA_MVC', $_SERVER['DOCUMENT_ROOT'] . '/application/');
define('RUTA_RECURSOS', '/application/');
define("INICIAR_SIMULADOR", false);


/* Se deben usar las constantes del archivo que posee las credenciales ODBC Y FTP 'connection2.php' para la conexion a la base de datos.
  Si necesita usar mas de una conexion diferente puede agregar mas constantes */
define("ODBC", 'hmvc_prueba_'); //ifxibgdir
define("ODBC_USER", 'root');
define("ODBC_PASS", '');



/*Configuracion para ver los errores de programacion*/
ini_set('error_reporting', E_ALL);
?>
