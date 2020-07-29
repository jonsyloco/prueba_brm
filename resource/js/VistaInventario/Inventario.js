/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$("document").ready(function () {
    obtenerDatosBd();

});


function guardar(nombrePrdcto, precio, cantidad, numLote, fecVencimiento, codigo) {
    $.ajax({
        type: 'post',
        url: 'index.php',
        data: {
            controlador: 'Inventario', metodo: 'guardarPrdcto', nombrePrdcto: nombrePrdcto,
            precio: precio, cantidad: cantidad, numLote: numLote, fecVencimiento: fecVencimiento,
            codigo: codigo
        },
        beforeSend: function () {
            $("#guardar").button('loading');
            $('#guardar').prop('disabled', true);
        },
        complete: function (data) {
            $("#guardar").button('reset');
            $('#guardar').prop('disabled', false);

        },
        success: function (data) {
            if (data == '0' || data == 0) {
                alerta("Se a guardado el producto con éxito", 'success');
                obtenerDatosBd();
            } else {
                alerta("Ha ocurrido un error Guardando el producto, porfavor recargue la pagina y vuelva a intentarlo", 'error');
                console.log("error",data);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#guardar").button('reset');
            $('#guardar').prop('disabled', false);
            alert("Ha ocurrido un error en el ajax: " + jqXHR + " / " + textStatus + " / " + errorThrown);
        }
    });
}

/**al presionar el boton de registrar**/
$("#guardarPrdcto").on("click", function (e) {
    e.preventDefault();
    let nombrePrdcto = $("#nombrePrdcto").val();
    let precio = $("#precio").val();
    let cantidad = $("#cantidad").val();
    let numLote = $("#numLote").val();
    let fecVencimiento = $("#fecVencimiento").val();
    let codigo = $("#codigo").val();

    if (nombrePrdcto != "" && precio != "" && cantidad != "" && numLote != "" && fecVencimiento != "") {

        guardar(nombrePrdcto, precio, cantidad, numLote, fecVencimiento, codigo);
        return;
    }

    alert("Debe llenar todos los campos");
    return;



});

function obtenerDatosBd() {

    $.ajax({
        type: 'post',
        url: 'index.php',
        data: {
            controlador: 'Inventario', metodo: 'traerDatos'
        },
        dataType: "json",
        beforeSend: function () {
            // btn.button('loading');
        },
        complete: function () {
            // btn.button('reset');

        },
        success: function (data) {
            // datosBusquedas = data['datos_aux'];/*datos para busquedas agiles mediante consecutivos*/
            crearTabla(data['datos_tabla']);/*datos organizados para DATATBLE*/

        },
        error: function (jqXHR, textStatus, errorThrown) {
            // btn.button('reset');
            alert('Ha ocurrido un error grave en el ajax: ' + jqXHR.responseText + " / " + textStatus + " / " + errorThrown);
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

/*
 * Metodo encargado de dibujar la tabla para las busquedas
 * @param array data
 * @returns DataTable
 */
function crearTabla(data) {
    var i = 0;
    tableFil = $('#tblConfig').DataTable({
        "deferRender": true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o fa-2x"></i>',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
        ],
        "pagingType": "full_numbers",
        "bPaginate": true,
        "bFilter": true,
        "destroy": true,
        "aaSorting": [], //quitamo el ordenamiento inicial
        "ordering": true, //quitamos el ordenamiento total

        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json",
        },
        data: data,
        columns: [
            { title: "id" },
            { title: "Producto" },
            { title: "Precio" },
            { title: "Cantidad" },
            { title: "Lote" },
            { title: "Fecha Vencimiento" },

        ],
        //aqui se pintan como se quiere renderizar las columnas ¿con que HTML?
        //target por target se especifica
        "columnDefs": [
            {
                "targets": i,
                "data": function (row, type, val, meta) {
                    consecutivo = row.id;
                    return consecutivo;
                },
                "render": function (data, type, full, meta) {
                    var registro = new Object();
                    registro.consec = data
                    var json = JSON.stringify(registro);
                    return "<a class='modificar' href='#' data-factura=" + json + " />" + data;

                }
            },
            {
                "targets": i += 1,
                "data": function (row, type, val, meta) {
                    nombre = row.nombre;

                    return nombre;
                },
                "render": function (data, type, full, meta) {
                    return data;
                }
            },

            {
                "targets": i += 1,
                "data": function (row, type, val, meta) {
                    precio = row.precio;
                    return precio;
                },
                "render": function (data, type, full, meta) {
                    return data;
                }
            },
            {
                "targets": i += 1,
                "data": function (row, type, val, meta) {
                    cantidad = row.cantidad;
                    return cantidad;
                },
                "render": function (data, type, full, meta) {
                    return data;
                }
            },
            {
                "targets": i += 1,
                "data": function (row, type, val, meta) {
                    numero_lote = row.numero_lote;
                    return numero_lote;
                },
                "render": function (data, type, full, meta) {
                    return data;
                }
            },
            {
                "targets": i += 1,
                "data": "fecha_vencimiento",
                "render": function (data, type, full, meta) {
                return data;

                }
            },


        ],
    });

}



