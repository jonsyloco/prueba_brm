<?php

/**
 * Description of Index_controller
 * @description: clase incial, encargada por primera vez de iniciar la interfaz
 * @author jhonatan wagner ocampo
 */
class Index_controller extends ControladorBase {

    public function __construct() {
        parent::__construct();
        
        include 'helper/funciones.php';    
    }

    
    public function index() {
        
    }
}

?>