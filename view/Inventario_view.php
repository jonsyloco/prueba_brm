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
class Inventario_view extends VistaBase{
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
<h2>Parametrización de productos</h2>
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
        <li><span>Empresas</span></li>
        <li><a><i class="fa fa-chevron-left"></i></a></li>

    </ol>
</div>
<!--el header tiene que estar con error, porque viene de otra vista el complemento-->
</header>
<div id="contenidoPagina">
    <form id='formulario' action="index.php?controlador=ParametriSucur">
        <div class="row">
                <section class="panel panel-featured panel-featured-dark">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <!--<a href="#" class="fa fa-times"></a>-->
                        </div>

                        <h2 class="panel-title">Creación de productos</h2>
                    </header>
                    <div class="panel-body">

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="nombrePrdcto">Nombre</label>
                                <input type="text" class="form-control"  name="nombrePrdcto" id="nombrePrdcto">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="precio">Precio</label>
                                <input type="number" class="form-control" id="precio" name="precio">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="cantida">Cantidad</label>
                                <input type="number" class="form-control" maxlength="3" id="cantidad"  name="cantidad" placeholder="0">
                            </div>
                        </div>
                        
                        
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="codigo">Código único Producto</label>
                                <input type="text" class="form-control" id="codigo" name="codigo"/>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="numLot">Numero de Lote</label>
                                <input type="text" class="form-control" id="numLote" name="numLote"/>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="fecVencimiento">Fecha Vencimiento</label>
                                <input type="text" class="form-control" value="<?php echo date('d/m/Y');?>" id="fecVencimiento" name="fecVencimiento"> 
                            </div>

                            <div class="form-group col-md-3">
                                <label for="fecCrea">Fecha Creación</label>
                                <input type="text" id="fecCrea" readonly=true value="<?php echo date('d/m/Y H:i:s');?>" class="form-control">
                            </div>
                        </div>

                        <div class="row">

                            <div class="panel-footer">
                                <button type="button" id="guardarPrdcto" class="btn btn-primary">guardar</button>
                            </div>
                        </div>

                    </section>
        </div>

        <div class="row">

        <section class="panel panel-featured panel-featured-dark">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <!--<a href="#" class="fa fa-times"></a>-->
                        </div>

                        <h2 class="panel-title">Visualización Inventario</h2>
                    </header>
                    <div class="panel-body">

                    <div class="panel-body" style="overflow:auto">
                        <table id='tblConfig' class='table table-bordered table-striped mb-none'>                                    
                        </table> 
                    </div> 
                        

                    </section>
        </div>



        <div class="row">
            <!-- validacion del select list servidores para los administradores-->
            <script src="resource/js/VistaInventario/Inventario.js?v=1" type="text/javascript"></script>

            <!--fin validacion select list servidores para los administradores-->
        </div>
    </form>
</div>


<?php
    }
}