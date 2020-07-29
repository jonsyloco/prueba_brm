<?php

/**
 * Description of Index_controller
 * @description: clase incial, encargada por primera vez de iniciar la interfaz
 * @author jhonatan wagner ocampo
 */
class Compras_controller extends ControladorBase {

public function __construct() {
    parent::__construct();
}

public function index()
{
    $modelo= cargarModel('Inventario');        
    $modelo->conectar(ODBC, ODBC_USER, ODBC_PASS, '', INICIAR_SIMULADOR);
    $productos=$modelo->traerProductos();        
    $datos_vista['productos']=$productos;        
    
    $vista=  cargarView('Compras');
    $vista->asignarVariable($datos_vista);        
    $vista->cargarTemplate("head");
    $vista->index();
    $vista->cargarTemplate("foot");
}


    /**
     * Metodo para guardar las ventas
     */
    public function guardarCompras()
    {
        
        /**area de validaciones */
        if(count($_POST['facturas']['productos']) == 0){
            echo "Error, no hay productos";
            return;
            
        }

        $prdcto = $_POST['facturas']['productos'];
        $cliente = $_POST['cliente'];

        $miModelo = cargarModel("Inventario");
        $miModelo->conectar(ODBC, ODBC_USER, ODBC_PASS, '', INICIAR_SIMULADOR);
        $miModelo->autocommit(FALSE); //desactivamos el guardado autmatico

        $respuesta=$miModelo->guardarCompra($cliente);

        if($respuesta == 0){            
            $idMaestro = $miModelo->obtenerId();
            if($idMaestro !=-1  && $idMaestro != null && $idMaestro!="") { //insertamos el detalle
                foreach ($prdcto as $item) {
                    $resulDetalle = $miModelo->guardarDetalleCompra($idMaestro,$item['nombre'],$item['cant'],$item['base'],$item['total']);
                    if($resulDetalle!=0 || $resulDetalle !="0"){
                        echo "Error guardando los detalles de la factura $idMaestro";
                        $miModelo->rollback(); //devolvemos los cambios
                        return;
                    }
                }

                $miModelo->commit(); //acentamos cambios
                echo 0;
                return;
            }else{
                echo "error obteniendo el id de la factura";
                $miModelo->rollback(); //devolvemos los cambios
                return;
            }
            
        }else{
            echo "error grabando el maestro de la factura";
            $miModelo->rollback(); //devolvemos los cambios
            return;
        }

        echo 0;
        return;
    }

}

?>