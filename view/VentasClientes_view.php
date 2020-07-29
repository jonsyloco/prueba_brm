<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmprSucursales_view
 *
 * @author Desarrollo
 */
class VentasClientes_view extends VistaBase{
    //put your code here
    public function __construct() {
        
    }
        public function index() {
        if (isset($this->productos)) {
            $productos = array();
            $productos = $this->productos;

            // print_r($productos);
        } else {
            $productos = array();
        }
       

//        variables que vienen desde el controlador
        ?>
<!-- Specific Page Vendor CSS -->
<h2>Ventas clientes</h2>
<div class="right-wrapper pull-right">


    <ol class="breadcrumbs">
        <li>
            <a><span><i class="fa fa-user"></i><?php echo " - JHONATAN WAGNER O." ?></span></a>
        </li>
        <li>
            <a href="index.php">
                <i class="fa fa-home"></i>
            </a>
        </li>
        <li><span>Ventas</span></li>
        <li><a><i class="fa fa-chevron-left"></i></a></li>

    </ol>
</div>
<!--el header tiene que estar con error, porque viene de otra vista el complemento-->
</header>
<div id="contenidoPagina">
    <form id='formulario2' action="#">
        <div class="row">
            <div class="col-md-12">
                <section class="panel panel-featured panel-featured-dark">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <!--<a href="#" class="fa fa-times"></a>-->
                        </div>

                        <h2 class="panel-title">Cliente</h2>
                    </header>
                    <div class="panel-body">

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="nombrePrdcto">Nombre Cliente</label>
                                <input type="text" class="form-control"  name="nombreCliente" id="nombreCliente">
                            </div>                         
                            
                        </div>
                        
                        
                        <div class="row">                         

                            <div class="form-group col-md-3">
                                <label for="fecCrea">Fecha Creación</label>
                                <input type="text" id="fecCrea" readonly=true value="<?php echo date('d/m/Y H:i:s');?>" class="form-control">
                            </div>
                            <br>
                            <br>
                            <br>
                            <br>
                        </div>

                        <div class="row">

                            <div class="panel-footer">
                                <button type="button" id="guardarPrdcto" class="btn btn-primary">guardar</button>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
        <div class="row">
            <!-- validacion del select list servidores para los administradores-->
            <div class="col-md-9">
                <div class="form-group">
                    <button id="btnAgregar" onclick="addprcto(event);" class="btn btn-xs btn-success">
                        <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Agregar
                    </button>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label id="labelTotal" class="labelTotal" style="font: bold 100% caption;font-size: 15px;color: red;">0</label>
                </div>
            </div>

            <div class="col-md-12">

                <div class="panel-body">
                    <table id='tblConfig2' class='table table-bordered table-striped mb-none'>
                        <thead>
                            <th>Eliminar</th>                            
                            <th>Producto</th>
                            <th>Valor</th>
                            <th style="width: 5%;">Cantidad</th>
                            <th>Total</th>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div>

            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label id="labelTotal" class="labelTotal" style="font: bold 100% caption;font-size: 15px;color: red;">0</label>
                </div>
            </div>
         
        </div>
    </form>
</div>
<script>
     var productos =<?php echo json_encode($productos); ?>;   
    console.log(productos);
</script>
<script src="resource/js/VistaVentas/Ventas.js?v=1" type="text/javascript"></script>



<?php
    }
}