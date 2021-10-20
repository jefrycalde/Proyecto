$( document ).ready(function(){
  //campos numericos
  $("#cantidad").numeric({ decimalPlaces: 2, negative: false });
  $("#costo").numeric({ decimalPlaces: 2, negative: false });
  $("#precio").numeric({ decimalPlaces: 2, negative: false });
  $("#pmayoreo").numeric({ decimalPlaces: 2, negative: false });
  $("#cmayoreo").numeric({ decimalPlaces: 2, negative: false });
  $("#stockCritico").numeric({ decimalPlaces: 2, negative: false });
  $("#codigo").numeric({ decimal: false, negative: false });
  $("#makecodigo").numeric({ decimal: false, negative: false });
  /* ********************************************************
  Modificar stock
  ********************************************************* */
  $('body').on('click', '.miStock', function () {
    var id=$(this).data("id");
    var bdg=$(this).data("bdg");
    $.ajax({
      url: base_url + 'modificar/stockHtml',
      data: {id:id,bdg:bdg},
      type: 'POST',
      // dataType: "json",
      success: function (html) {
        $(".modal-header-mini").html('<span class="text-right" style="font-size:17px"><i class="fa fa-check-square-o" aria-hidden="true"></i> Ajustar Stock</span><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
        $(".modal-body-mini").html(html);
        $(".modal-footer-mini").html("<center>     <button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>          <button type='submit' class='btn btn-success' style='margin-left:15px' onclick='goFormModStock();'>Ajustar stock</button>        </center>");
        $("#ModalMini").modal("show");
      }
    });
    return false;
  });

  $('body').on('submit', '#formModStock', function () {
    $(".modal-footer-mini").html("");
    $(".modal-body-mini").html("<center><i class=\"fa fa-spinner fa-spin fa-5x fa-fw\"></i><span class=\"sr-only\">Cargando...</span><br>Cargando... Por favor espere.</center>");
    $.ajax({
      url: base_url + 'modificar/newStock',
      data: $(this).serialize(),
      type: 'POST',
      // dataType: "json",
      success: function (resultado) {
        if(resultado == "1"){
          location.reload();
        }
      },
      error: function (data) {
        $("#msj").html(data['responseText']);
        return false;
      }
    });
    return false;
  });



  /* ********************************************************
  formulario Modificar  producto
  ********************************************************* */
  $('body').on('submit', '#modItem', function () {
    $.ajax({
      url: base_url + 'modificar/modItem',
      data: $(this).serialize(),
      type: 'POST',
      // dataType: "json",
      success: function (resultado) {
        if(resultado == "1"){
          var msj = miAlerta("success","Item Actualizado", "El articulo se ha actualizado correctamente");
          $("#msj").html(msj);
          $("#codigoAdd").val("");
          $("#descripcion").html("<label>---</label>");
          $("#cantidadActual").html("<label >0.00</label>");
          $("#cantidad").val("");
          esconderAlerta();
        }
      },
      error: function (data) {
        alerta('Error interno', data['responseText'], '');
      }
    });
    return false;
  });

/*****
*****/

$('body').on('submit', '#formUpdateOffer', function () {
    $.ajax({
      url: base_url + 'ofertas/actualiza',
      data: $(this).serialize(),
      type: 'POST',
      // dataType: "json",
      success: function (resultado) {
        if(resultado == "1"){
          var msj = miAlerta("success","Item Actualizado", "La oferta se ha actualizado correctamente");
          $("#msj").html(msj);
          esconderAlerta();
        }
      },
      error: function (data) {
        alerta('Error interno', data['responseText'], '');
      }
    });
    return false;
  });




  $('body').on('click', '.makecodebar', function () {
    var codigo = $("#makecodigo").val();
    $("#barcodeimg").html("<img src = '"+base_url+"codbarras/makeBarCode/"+codigo+"'  />");
  });




  $('body').on('click', '.gencodebar', function () {
    $.ajax({
      url: base_url + 'nuevoProducto/gencodebar',
      data: $(this).serialize(),
      type: 'POST',
      // dataType: "json",
      success: function (resultado) {
        $("#codigo").val(resultado);
      },
      error: function (data) {
        alerta('Error interno', data['responseText'], '');
      }
    });
  });




  /* ********************************************************
  formulario agragegar cantidad a un producto
  ********************************************************* */
  $('body').on('submit', '#addItem', function () {
    $.ajax({
      url: base_url + 'agregarInventario/setItem',
      data: $(this).serialize(),
      type: 'POST',
      // dataType: "json",
      success: function (resultado) {
        if(resultado == "0"){
          alerta("Error","El código no fue encontrado en la base de datos.<br><br>Para agregar un producto diríjase a <a href='"+base_url+"nuevoProducto'>nuevoProducto</a>","<a href='"+base_url+"nuevoProducto' class='btn btn-default'>Ir a Agregar Nuevo Producto</a>");
        }
        else if(resultado == "1"){
          var msj = miAlerta("success","Item Actualizado", "El articulo se ha actualizado correctamente");
          $("#msj").html(msj);
          $("#codigoAdd").val("");
          $("#descripcion").html("<label>---</label>");
          $("#cantidadActual").html("<label >0.00</label>");
          $("#cantidad").val("");
          esconderAlerta();
        }
      },
      error: function (data) {
        alerta('Error interno', data['responseText'], '');
      }
    });
    return false;
  });


  /* ********************************************************
  detecta un producto por el codigo y busca sus datos
  ********************************************************* */
  $("#codigoAdd").delayPasteKeyUp(function(){
    var codigo = $("#codigoAdd").val();
    $.ajax({
      url: base_url + 'agregarInventario/addInventario',
      data: {codigo: codigo},
      type: 'POST',
      dataType: "json",
      success: function (r) {
        if(r.encontrado)
        {
          $("#descripcion").html("<label>"+r.descripcion+"</label>");
          $("#cantidadActual").html("<label>"+r.cantidadActual+"</label>");
        }
      }
    });
  }, 200);



  /* ********************************************************
  detecta nuvo registro ya existente
  ********************************************************* */
  $("#codigo").delayPasteKeyUp(function(){
    var codigo = $("#codigo").val();
    $.ajax({
      url: base_url + 'nuevoProducto/verificarProducto',
      data: {codigo: codigo},
      type: 'POST',
      // dataType: "json",
      success: function (resultado) {
        if(resultado)
        {
          alerta("Error","El código que intenta agregar ya esta en la base de datos.<br><br>Para agregar cantidad de un producto ya existente diríjase a <a href='"+base_url+"AgregarInventario'>Agregar Inventario</a>","<a href='"+base_url+"AgregarInventario' class='btn btn-default'>Ir a Agregar Inventario</a>");
        }
      }
    });
  }, 200);



  $('body').on('click', '.delp', function () {
    var idp=$(this).data("idp");
    $(".modal-header").html('<span class="text-right" style="font-size:17px"><i class="fa fa-user-secret" aria-hidden="true"></i> Eliminar Producto</span><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
    alertaMini("Confirmación","<center>¿Estás seguro de eliminar este Producto?</center>","<button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button> <a href='#' id='confirmarBorrar' data-id='"+idp+"' class='btn btn-danger'>Si, aceptar</a>")
    return false;
  });


  $('body').on('click', '#confirmarBorrar', function () {
    var  idp=$(this).data("id");
    $.ajax({
      url: base_url + 'Inventario/delInventario',
      data: {idp:idp},
      type: 'POST',
      success: function (resultado) {
        location.reload();
      },
      error: function (data) {
        alerta('Error interno', data['responseText'], '');
      }
    });
    return false;
  });


  /* ********************************************************
  Agregar un nuevo departamento
  ********************************************************* */
  $('body').on('click', '.addDepartamento', function () {
    $.ajax({
      url: base_url + 'configuraciones/depHtml',
      data: {},
      type: 'POST',
      // dataType: "json",
      success: function (html) {
        $(".modal-header-mini").html('<span class="text-right" style="font-size:17px"><i class="fa fa-tags" aria-hidden="true"></i> Nuevo Departamento</span><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
        $(".modal-body-mini").html(html);
        $(".modal-footer-mini").html("");
        $("#ModalMini").modal("show");
      }
    });
    return false;
  });


  $('body').on('submit', '#formAddDep', function () {
    $("#Modal").modal("hide");
    $.ajax({
      url: base_url + 'nuevoProducto/addDepartamento',
      data: $(this).serialize(),
      type: 'POST',
      dataType: "json",
      success: function (resultado) {
        if(resultado!="x"){
          $("#ModalMini").modal("hide");
          $('#listDepartamentos').append(new Option(resultado['nombre'], resultado['id'], true, true));
        }
        else {
          $("#ModalMini").modal("hide");
          var msj = miAlerta("danger","Departamento duplicado", "No se agregó el nuevo departamento pues ya hay uno con ese mismo nombre");
          $("#msj").html(msj);
          esconderAlerta();
          $(".nombre").html(resultado);
        }
      },
      error: function (data) {
        alerta('Error interno', data['responseText'], '');
      }
    });
    return false;
  });

  /* ********************************************************
  formulario nuevo producto
  ********************************************************* */
  $('body').on('submit', '#formNewItem', function () {
    var xcodigox =  $("#codigo").val();
      if(xcodigox.length < 13){
          alert("El código debe tener 13 digitos.");
          return false;
      }
    $.ajax({
      url: base_url + 'nuevoProducto/addNewItem',
      data: $(this).serialize(),
      type: 'POST',
      // dataType: "json",
      success: function (resultado) {
        if(resultado == "1"){
          // $(location).attr('href',base_url+"nuevoProducto/index/1");
          var msj = miAlerta("success","Articulo Agregado", "El articulo ha sido agregado correctamente");
          $("#msj").html(msj);
          $("#codigo").val("");
          $("#descripcion").val("");
          $("#costo").val("");
          $("#precio").val("");
          $("#pmayoreo").val("");
          $("#cmayoreo").val("");
          esconderAlerta();
        }
        else if(resultado == "2"){
          alerta("Error","El código que intenta agregar ya esta en la base de datos.<br><br>Para agregar cantidad de un producto ya existente diríjase a <a href='"+base_url+"AgregarInventario'>Agregar Inventario</a>","<a href='"+base_url+"AgregarInventario' class='btn btn-default'>Ir a Agregar Inventario</a>");
        }

        // location.reload();
        return false;
      },
      error: function (data) {
        alerta('Error interno', data['responseText'], '');
      }
    });
    return false;
  });



  /* ********************************************************
  DataTable
  ********************************************************* */
  var table = $('#tbInventario').DataTable( {

    language: {
      processing: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      search: "<i class='fa fa-search' aria-hidden='true'></i>",
      lengthMenu:     "Mostrando _MENU_ productos",
      info:           "Mostrando del _START_ al _END_ de _TOTAL_ productos",
      infoEmpty:      "Mostrando 0 al 0 de 0 coincidencias",
      infoFiltered: "(filtrado de un total de _MAX_ elementos)",
      infoPostFix: "",
      loadingRecords: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      zeroRecords: "No se encontraron coincidencias",
      emptyTable: "No hay datos para mostrar",
      paginate: {
        first: "<i class='fa fa-fast-backward fa-lg' aria-hidden='true'></i>",
        previous: "<i class='fa fa-backward fa-lg' aria-hidden='true'></i>",
        next: "<i class='fa fa-forward fa-lg' aria-hidden='true'></i>",
        last: "<i class='fa fa-fast-forward fa-lg' aria-hidden='true'></i>"
      }
      //,
      //aria: {
      //    sortAscending: ": activate to sort column ascending",
      //    sortDescending: ": activate to sort column descending"
      //}
    },
    lengthMenu: [
      [ 5,10, 25, 50, -1 ],
      [ '5','10', '25', '50', 'Todo' ]
    ],
    buttons: [
    { extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i>' }

    ],
    columnDefs:[
      { orderable: false, targets: [0] },{ orderable: false, targets: [4] }
    ],
    order:[
      [ 1, 'asc' ]
    ],
    stateSave: true
  } );
  table.buttons().container()
  .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );


  var table = $('#tbInventarioCritico').DataTable( {

    language: {
      processing: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      search: "<i class='fa fa-search' aria-hidden='true'></i>",
      lengthMenu:     "Mostrando _MENU_ productos",
      info:           "Mostrando del _START_ al _END_ de _TOTAL_ productos",
      infoEmpty:      "Mostrando 0 al 0 de 0 coincidencias",
      infoFiltered: "(filtrado de un total de _MAX_ elementos)",
      infoPostFix: "",
      loadingRecords: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      zeroRecords: "No se encontraron coincidencias",
      emptyTable: "No hay datos para mostrar",
      paginate: {
        first: "<i class='fa fa-fast-backward fa-lg' aria-hidden='true'></i>",
        previous: "<i class='fa fa-backward fa-lg' aria-hidden='true'></i>",
        next: "<i class='fa fa-forward fa-lg' aria-hidden='true'></i>",
        last: "<i class='fa fa-fast-forward fa-lg' aria-hidden='true'></i>"
      }
      //,
      //aria: {
      //    sortAscending: ": activate to sort column ascending",
      //    sortDescending: ": activate to sort column descending"
      //}
    },
    lengthMenu: [
      [ 5,10, 25, 50, -1 ],
      [ '5','10', '25', '50', 'Todo' ]
    ],
    buttons: [
      { extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i>' }
    ],
    columnDefs:[
      { orderable: false, targets: [0] },{ orderable: false, targets: [4] }
    ],
    order:[
      [ 1, 'asc' ]
    ],
    stateSave: true
  } );
  table.buttons().container()
  .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );

  /**************************************************************/
   var table = $('#tbOfertas').DataTable( {

    language: {
      processing: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      search: "<i class='fa fa-search' aria-hidden='true'></i>",
      lengthMenu:     "Mostrando _MENU_ ofertas",
      info:           "Mostrando del _START_ al _END_ de _TOTAL_ ofertas",
      infoEmpty:      "Mostrando 0 al 0 de 0 coincidencias",
      infoFiltered: "(filtrado de un total de _MAX_ elementos)",
      infoPostFix: "",
      loadingRecords: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      zeroRecords: "No se encontraron coincidencias",
      emptyTable: "No hay datos para mostrar",
      paginate: {
        first: "<i class='fa fa-fast-backward fa-lg' aria-hidden='true'></i>",
        previous: "<i class='fa fa-backward fa-lg' aria-hidden='true'></i>",
        next: "<i class='fa fa-forward fa-lg' aria-hidden='true'></i>",
        last: "<i class='fa fa-fast-forward fa-lg' aria-hidden='true'></i>"
      }
      //,
      //aria: {
      //    sortAscending: ": activate to sort column ascending",
      //    sortDescending: ": activate to sort column descending"
      //}
    },
    lengthMenu: [
      [ 5,10, 25, 50, -1 ],
      [ '5','10', '25', '50', 'Todo' ]
    ],
    buttons: [
      { extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i>' }
    ],
    columnDefs:[
      { orderable: false, targets: [0] },{ orderable: false, targets: [4] }
    ],
    order:[
      [ 1, 'asc' ]
    ],
    stateSave: true
  } );

  table.buttons().container()
  .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );

  /**************************************************************/
  var table = $('#tbCompras').DataTable( {

    language: {
      processing: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      search: "<i class='fa fa-search' aria-hidden='true'></i>",
      lengthMenu:     "Mostrando _MENU_ compras",
      info:           "Mostrando del _START_ al _END_ de _TOTAL_ compras",
      infoEmpty:      "Mostrando 0 al 0 de 0 coincidencias",
      infoFiltered: "(filtrado de un total de _MAX_ elementos)",
      infoPostFix: "",
      loadingRecords: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      zeroRecords: "No se encontraron coincidencias",
      emptyTable: "No hay datos para mostrar",
      paginate: {
        first: "<i class='fa fa-fast-backward fa-lg' aria-hidden='true'></i>",
        previous: "<i class='fa fa-backward fa-lg' aria-hidden='true'></i>",
        next: "<i class='fa fa-forward fa-lg' aria-hidden='true'></i>",
        last: "<i class='fa fa-fast-forward fa-lg' aria-hidden='true'></i>"
      }
      //,
      //aria: {
      //    sortAscending: ": activate to sort column ascending",
      //    sortDescending: ": activate to sort column descending"
      //}
    },
    lengthMenu: [
      [ 5,10, 25, 50, -1 ],
      [ '5','10', '25', '50', 'Todo' ]
    ],
    buttons: [
      { extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i>' }
    ],
    columnDefs:[
      { orderable: false, targets: [0] },{ orderable: false, targets: [4] }
    ],
    order:[
      [ 1, 'asc' ]
    ],
    stateSave: true
  } );

  table.buttons().container()
  .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );

  /* ********************************************************
  DataTable
  ********************************************************* */
  var table = $('#tb_ventas').DataTable( {

    language: {
      processing: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      search: "<i class='fa fa-search' aria-hidden='true'></i>",
      lengthMenu:     "Mostrando _MENU_ productos",
      info:           "Mostrando del _START_ al _END_ de _TOTAL_ productos",
      infoEmpty:      "Mostrando 0 al 0 de 0 coincidencias",
      infoFiltered: "(filtrado de un total de _MAX_ elementos)",
      infoPostFix: "",
      loadingRecords: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      zeroRecords: "No se encontraron coincidencias",
      emptyTable: "No hay datos para mostrar",
      paginate: {
        first: "<i class='fa fa-fast-backward fa-lg' aria-hidden='true'></i>",
        previous: "<i class='fa fa-backward fa-lg' aria-hidden='true'></i>",
        next: "<i class='fa fa-forward fa-lg' aria-hidden='true'></i>",
        last: "<i class='fa fa-fast-forward fa-lg' aria-hidden='true'></i>"
      }
      //,
      //aria: {
      //    sortAscending: ": activate to sort column ascending",
      //    sortDescending: ": activate to sort column descending"
      //}
    },
    lengthMenu: [
      [ 5,10, 25, 50, -1 ],
      [ '5','10', '25', '50', 'Todo' ]
    ],
    buttons: [
      { extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i>' }
    ],
    columnDefs:[
      { orderable: false, targets: [4] }
    ],
    order:[
      [ 3, 'asc' ]
    ],
    stateSave: true
  } );
  table.buttons().container()
  .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );

  //****

  //****






}); // fin ready


function goFormModStock() {
  $("#formModStock").submit();
}



// ****************************************************************
// funciones
// ****************************************************************
$.fn.delayPasteKeyUp = function(fn, ms)
{
  var timer = 0;
  $(this).on("propertychange input", function()
  {
    clearTimeout(timer);
    timer = setTimeout(fn, ms);
  });
};


function miAlerta(tipo,titulo,mensaje) {
  var msj='<div class="alert alert-'+tipo+' alert-dismissible" role="alert">'+
  '<button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>'+
  '<strong>'+titulo+' </strong>'+mensaje+'.'+
  '</div>';
  return msj;
}



function esconderAlerta(){
  setTimeout(function() {
    $("#msj").fadeOut(1500);
  },1500);
  setTimeout(function() {
    $("#msj").html("");
    $("#msj").fadeIn(1);
  },3000);
}
