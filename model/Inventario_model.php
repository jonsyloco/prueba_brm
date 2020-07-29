<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmprSucursales_model
 *
 * @author Desarrollo
 */
class Inventario_model extends odbc {
    //put your code here
    
    public function __construct() {
        
    }

    /**
     * Traer Productos
     */
    public function traerProductos() {
        $sql="SELECT id,nombre,precio, cantidad, numero_lote, fecha_vencimiento, fecha_creacion,codigo_prdcto FROM producto where cantidad > 0";
        $resp = $this->consultar($sql, __FUNCTION__);
        $datos = array();
        $datosOdbc = $this->getDatosOdbc();        
        
        while ($reg = $datosOdbc->getRegistro()) {                       
            $id=trim($reg['id']);

            $datos[$id]['id'] = trim($reg['id']);
            $datos[$id]['nombre'] = trim($reg['nombre']);            
            $datos[$id]['numero_lote'] = trim($reg['numero_lote']);            
            $datos[$id]['cantidad'] = trim($reg['cantidad']);            
            $datos[$id]['precio'] = trim($reg['precio']);            
            $datos[$id]['codigo_prdcto'] = trim($reg['codigo_prdcto']);            
            $datos[$id]['fecha_vencimiento'] = empty($reg['fecha_vencimiento']) ? "" : date_format(date_create($reg['fecha_vencimiento']), 'm/d/Y');
            $datos[$id]['fecha_creacion'] = empty($reg['fecha_creacion']) ? "" : date_format(date_create($reg['fecha_creacion']), 'm/d/Y');
            
        }
        if (count($datos) > 0) {/* si tenemos datos */

            /* proceso de restar los datos, de la BD -> IBG vs CONTAB para saber que facturas vamos a mostrar en interfaz */
            $datos_final = array();
            $datos_final['datos_aux'] = $datos; //datos para hacer busquedas agiles por consecutivo en interfaz grafica
            $datos_final['datos_tabla'] = array_values($datos); //datos organizados para el dataTAble
            return $datos_final;
        }
        return $datos;
    }


    /**
     * Guardado de productos
     */
    public function guardarProducto($nombrePrdcto, $precio, $cantidad , $numLote, $fecVencimiento, $codigo) {

        
        $fecVencimiento_ = DateTime::createFromFormat('d/m/Y', $fecVencimiento);        
        $fecVencimiento_=$fecVencimiento_->format('Y-m-d');
        
        $sql = "INSERT INTO producto( nombre, precio, cantidad, numero_lote, fecha_vencimiento, fecha_creacion,codigo_prdcto) VALUES ('$nombrePrdcto', $precio, $cantidad, '$numLote', '$fecVencimiento_', now(),'$codigo')";
        $resp = $this->ejecutar($sql);
        return $resp;
        // return $sql;
    }


    /**
     * guardando el maestro de la venta
     */
    public function guardarVenta($cliente)
    {
                
        $sql = "INSERT INTO venta( nombre_cliente, fecha, estado) VALUES ('$cliente',now(),'A')";
        $resp = $this->ejecutar($sql);
        return $resp;
    }

    public function guardarDetalleVenta($idVenta,$idProducto,$cantidad,$valorUnidad,$total)
    {
        $sql = "INSERT INTO venta_detalle( id_venta, id_producto, cantidad, vlr_unidad, vlr_total) VALUES ($idVenta,$idProducto,$cantidad,$valorUnidad,$total)";
        $resp = $this->ejecutar($sql);
        return $resp;
    }
  
    /**
     * guardando el maestro de la venta
     */
    public function guardarCompra($cliente)
    {
                
        $sql = "INSERT INTO compra( nombre_proveedor, fecha, estado) VALUES ('$cliente',now(),'A')";
        $resp = $this->ejecutar($sql);
        return $resp;
    }

    public function guardarDetalleCompra($idVenta,$idProducto,$cantidad,$valorUnidad,$total)
    {
        $sql = "INSERT INTO compra_detalle( id_compra, id_producto, cantidad, vlr_unidad, vlr_total) VALUES ($idVenta,$idProducto,$cantidad,$valorUnidad,$total)";
        $resp = $this->ejecutar($sql);
        return $resp;
    }



/**
 * obtenemos el ultimo id insertado de cualquier tabla
 */
    public function obtenerId()
    {
        $sql="SELECT @@identity AS id";
        $resp = $this->consultar($sql, __FUNCTION__);
        $datos = -1;
        $datosOdbc = $this->getDatosOdbc();    
        while ($reg = $datosOdbc->getRegistro()) {                       
            $datos = trim($reg['id']);
        }
        return $datos;
        
    }
   
}
