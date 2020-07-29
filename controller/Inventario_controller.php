<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmprSucursales_controller
 *
 * @author Desarrollo
 */
class Inventario_controller extends ControladorBase{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $modelo= cargarModel('Inventario');        
        $modelo->conectar(ODBC, ODBC_USER, ODBC_PASS, '', INICIAR_SIMULADOR);
        $productos=$modelo->traerProductos();        
        $datos_vista['productos']=$productos;        
        
        $vista=  cargarView('Inventario');
        $vista->asignarVariable($datos_vista);        
        $vista->cargarTemplate("head");
        $vista->index();
        $vista->cargarTemplate("foot");
    }

    /**
     * Metodo para traer los datos de BD
     */
    public function traerDatos()
    {
        $modelo= cargarModel('Inventario');        
        $modelo->conectar(ODBC, ODBC_USER, ODBC_PASS, '', INICIAR_SIMULADOR);
        $productos=$modelo->traerProductos();
        echo json_encode($productos);
        return;
    }

    /**
     * Metodo para guardar productos
     */
    public function guardarPrdcto()
    {
        $data = ($_POST);       

        $nombrePrdcto = $_POST['nombrePrdcto'];
        $precio = $_POST['precio'];        
        $cantidad = $_POST['cantidad'];
        $numLote = $_POST['numLote'];
        $fecVencimiento = $_POST['fecVencimiento'];       
        $codigoPrdcto = $_POST['codigo'];       

        /** area de validaciones********* */           
        if($nombrePrdcto == null || $precio == null || $cantidad == null || $numLote==null || $fecVencimiento== null ){
            return "Datos incompletos"; 
        }
        /** fin-area de validaciones******* */


        
            $miModelo = cargarModel("Inventario");
            $miModelo->conectar(ODBC, ODBC_USER, ODBC_PASS, '', INICIAR_SIMULADOR);
            $miModelo->autocommit(); //desactivo el commit
            $resp = $miModelo->guardarProducto($nombrePrdcto, $precio, $cantidad , $numLote, $fecVencimiento,$codigoPrdcto);
            if ($resp != 0 || $resp != "0") {
                $miModelo->rollback();
                echo 1;// ha salido un error    
                echo $resp;
                            
                return;
            }
        
        $miModelo->commit();
        echo 0;
        return;
    }
}
