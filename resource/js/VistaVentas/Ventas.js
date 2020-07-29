/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$("document").ready(function () {
    console.log("inicio..");
    if(productos!=undefined && productos!="" && productos!=null){

        crearSelectPrdcto();
    }

});

let contador = 0;
var selectPrdcto="";
var factuNoEnviadas=new Object();

function crearSelectPrdcto(){
    selectPrdcto +="<option value=''></option>";
    $.each(productos.datos_tabla, function (clave,valor) {
        selectPrdcto +="<option value='"+valor.id+"'>"+valor.nombre+"</option>";
        // console.log("datos",valor.nombre);
    });
}




/*aqui se verifica si una factura tiene productos
 * para ser pinbtados en la interfaz*/
function addprcto(e) {

    e.preventDefault();


    $("#tblConfig2 tbody").append("\n\
                                    <tr id=" + contador + ">\n\
                                    <td><a onclick='eliminarProducto(" + contador + ")' class='modal-with-move-anim b-xs mt-xs mr-xs btn btn-xs button-1 btn-danger' href='#modalAnim'><i class='fa fa-times'></i></a></td>\n\
                                    <td><select name='fila[" + contador + "][nomb]' class='form-control' id='nomb" + contador + "' required >"+selectPrdcto+"</select></td>\n\
                                    <td> <input class='form-control solonumero' id='base" + contador + "' name='fila[" + contador + "][base]' value='0' onchange='cambioValor(" + contador + ")'></td>\n\
                                    <td><input  name='fila[" + contador + "][cant]' class='form-control solonumero' id='cant" + contador + "'value='1' onchange='cambioValor(" + contador + ")'></td>\n\
                                    <td><input  name='fila[" + contador + "][total]' class='form-control' id='total" + contador + "'  value='0' readonly='readonly'></td>\n\
                                </tr>");

    contador++;

    agregarTotalEtiqueta();



}

/* clase que permite bloquear un input para que solo acepte numeros y no textos*/
var specialKeys = new Array();
specialKeys['push'](8, 46, 9);

$("body").on('keydown', '.solonumero', function (event) {

  var key = event['which'] ? event['which'] : event['keyCode'];

  var char_value = ((key >= 96 && key <= 105) || (key >= 48 && key <= 57) || specialKeys['indexOf'](key) != -1 || key == 37 || key == 39);

  return char_value;

});




function agregarTotalEtiqueta() {
    var totalPrdctos = 0;

    $("table#tblConfig2 tbody tr").each(function () {/*recorremos todas las filas*/
        var id = $(this).attr('id');
        totalPrdctos += Number($(this).find('input#total' + id).val());
    });

    console.log("total", totalPrdctos);
    $(".labelTotal").text(totalPrdctos);/*asignamos*/
}



/*cambio de valor de los campos cantidad, total y descuento
 * del popup de los productos..
 * se envia por parametro el contador , que es la fila donde se produjo
 * el evento change..*/
function cambioValor(conta) {
    //    console.log("llegue..."+conta);
        if (conta === "") {
            console.log("Error obteniendo el evento de la fila");
            return;
        }
    
        var base = $("#base" + conta).val();
        var cant = $("#cant" + conta).val();
    
        /*area de validaciones*/
        if (isNaN(base) == true) {/*convertimos en entero numero y corroboramos que sea asi...*/
            alert("Es necesario que la base del producto sea Numérico entero");
            $("#total" + conta).val(0);
            $("#base" + conta).val(0);
            return;
        }
    
        if (isNaN(cant) == true) {/*convertimos en entero numero y corroboramos que sea asi...*/
            alert("Es necesario que la cantidad del producto sea Numérico entero");
            $("#total" + conta).val(0);
            $("#cant" + conta).val(0);
            return;
        }
    
        var total = base * cant;
    //    console.log("llegue a introducir el valor "+total);
    
        /*asignamos el total*/
        $("#total" + conta).val(total);
    
        /*asignamos el total productos.. a la etiqueta*/
        agregarTotalEtiqueta();
    
    
    }


    /**
 * funtion dedicada a eliminar de la interfaz productos
 * @returns void
 */
function eliminarProducto(idFila) {
    if (idFila === "") {
        alert("no se puede eliminar la fila, hay un error!");
        return;
    }

    bootbox.confirm({
        message: "Seguro desea eliminar el producto?",
        className: 'bb-alternate-modal',
        size: 'small',
        callback: function (result) {
            if (result == true) {
                $("tr#" + idFila).remove();
                agregarTotalEtiqueta();
            }
        }
    });
}


$("#guardarPrdcto").on("click",function(e){

    e.preventDefault();
    guardarProductos();
});

/**
 * 
 * Metodo encargado de obtener los productos de la interfaz
 * y colocarlos en objetos que a su vez se colocan en el objeto global
 * de facturas no enviadas factuNoEnviadas[productos]
 */
function guardarProductos() {

    factuNoEnviadas['productos']= new Object();
    var formulario = [];
    formulario = $("#formulario2").serializeArray();
    if (formulario.length == 0) {
        alert("Debe haber minimo 1 producto");
        return;
    }
    var producto_s = [];
    var error = 0;
    var total1 = 0;/*total prodcutos*/
    var total2 = 0;/*total base factura*/

    /*recorremos la tabla*/
    $("table#tblConfig2 tbody tr").each(function () {
        var producto = new Object();

        var id = $(this).attr('id');
        var codigoPrdcto = $(this).find('select#nomb' + id).val();
        var nombPrdcto = $(this).find('select#nomb' + id).val();
        var basePrdcto = $(this).find('input#base' + id).val();
        var cantPrdcto = $(this).find('input#cant' + id).val();
        var totalPrdcto = $(this).find('input#total' + id).val();
        /*area de validaciones*/
        if (codigoPrdcto == "") {
            alert("Es necesario el codigo del producto en todos los items");
            error += 1;
            return false;
        }       

        if (nombPrdcto == "") {
            alert("Es necesario el nombre del prodcuto en todos los items");
            error += 1;
            return false;
        }
        if (cantPrdcto == "") {
            alert("Es necesario que la cantidad sea minimo 1");
            error += 1;
            return false;
        }
        
        /*fin-area de validaciones*/


        /*se hace el objeto de productos*/
        producto.codigo = codigoPrdcto;
        producto.nombre = nombPrdcto;
        producto.base = basePrdcto;
        producto.cant = cantPrdcto;
        producto.total = totalPrdcto;
        producto_s.push(producto);

        total1 += Number(totalPrdcto);
//        console.log("codigo->",id, "codigoPrdcto->",codigoPrdcto,"basePrdcto->",basePrdcto,"cantPrdcto->",cantPrdcto,"totalPrdcto->",totalPrdcto," nomb->",nombPrdcto);/*id fila*/

    });

    if (error == 0) {/*si no hay errores */
        //agregamos los productos al objeto global que guarda las facturas sin seleccionar
        console.log("productos", producto_s);
        /*area de validacion*/
        if (producto_s.length == 0) {
            alert("Debe haber minimo 1 producto");
            return;
        }       
        

        console.log("llegue al final",factuNoEnviadas);
        /*fin-area de validacion*/
        
        factuNoEnviadas['productos'] = producto_s;/*agregamos los productos al array GLOBAL*/       
        guardarVenta(factuNoEnviadas);

    }
    return;


}


function guardarVenta(facturas) {
let nombreCliente= $("#nombreCliente").val();

    $.ajax({
        type: 'post',
        url: 'index.php',
        data: {
            controlador: 'VentasClientes', metodo: 'guardarVenta',
            facturas:facturas, cliente: nombreCliente
        },
        beforeSend: function () {
            $("#guardarPrdcto").button('loading');
            $('#guardarPrdcto').prop('disabled', true);
        },
        complete: function (data) {
            $("#guardarPrdcto").button('reset');
            $('#guardarPrdcto').prop('disabled', false);

        },
        success: function (data) {
            if (data == '0' || data == 0) {
                alerta("Se a guardado el producto con éxito", 'success');

                setTimeout(function(){  location.reload(); }, 3000);

            } else {
                alerta("Ha ocurrido un error Guardando el producto, porfavor recargue la pagina y vuelva a intentarlo", 'error');
                console.log("error",data);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#guardarPrdcto").button('reset');
            $('#guardarPrdcto').prop('disabled', false);
            alert("Ha ocurrido un error en el ajax: " + jqXHR + " / " + textStatus + " / " + errorThrown);
        }
    });
}





/**mensaje de alerta**/
function alerta(mesaje, tipo) {
    var tipo2 = "";
    if (tipo == "success") {
        tipo2 = "Éxito";
    } else {
        tipo2 = "Error";
    }
    var notice = new PNotify({
        title: tipo2,
        text: mesaje,
        type: tipo,
        addclass: 'stack-bar-top',
        stack: '',
        width: "100%"
    });
}