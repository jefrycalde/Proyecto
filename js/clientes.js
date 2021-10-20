$( document ).ready(function(){


  /* ********************************************************
  DataTable
  ********************************************************* */
  var table = $('#tbClientes').DataTable( {

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
    // buttons: [
    //   { extend: 'colvis', text: 'Columnas' },{ extend: 'copy', text: 'Copiar Contenido' }, { extend: 'excel', text: 'Exportar a Excel',title: 'Mi Inventario' }, { extend: 'pdf', text: 'Generar PDF',title: 'Mi Inventario' },{ extend: 'print', text: 'Imprimir' }
    //
    // ],
    columnDefs:[
      { orderable: false, targets: [0] },{ orderable: false, targets: [2] },{ orderable: false, targets: [3] },{ orderable: false, targets: [4] }
    ],
    order:[
      [ 1, 'asc' ]
    ],
    stateSave: true
  });
  table.buttons().container()
  .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
  // ----------------------------
  // Fin DataTable
  // ----------------------------










  /* ********************************************************
  Nuevo cliente
  ********************************************************* */
  $('body').on('click', '#btnNuevoCliente', function () {
    $.ajax({
      url: base_url + 'clientes/addHtml',
      data: {},
      type: 'POST',
      // dataType: "json",
      success: function (html) {
        $(".modal-header").html('<span class="text-right" style="font-size:17px"><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i> Nuevo Cliente</span><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
        $(".modal-body").html(html);
        $(".modal-footer").html("");
        $("#Modal").modal("show");
      }
    });
  });

  $('body').on('submit', '#formAddCliente', function () {
    $("#Modal").modal("hide");
    $.ajax({
      url: base_url + 'clientes/addCliente',
      data: $(this).serialize(),
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






  $('body').on('click', '.editarc', function () {
    var  idcliente=$(this).data("idc");
    $.ajax({
      url: base_url + 'clientes/addHtml/'+idcliente,
      data: {},
      type: 'POST',
      success: function (html) {
        $(".modal-header").html('<span class="text-right" style="font-size:17px"><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i> Editar Cliente</span><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
        $(".modal-body").html(html);
        $(".modal-footer").html("");
        $("#Modal").modal("show");
      },
      error: function (data) {
        alerta('Error interno', data['responseText'], '');
      }
    });
    return false;
  });


  $('body').on('submit', '#formModCliente', function () {
    $("#Modal").modal("hide");
    $.ajax({
      url: base_url + 'clientes/modCliente',
      data: $(this).serialize(),
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




  $('body').on('click', '.delc', function () {
    var  idc=$(this).data("idc");
    $(".modal-header").html('<span class="text-right" style="font-size:17px"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Eliminar Cliente</span><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
    alertaMini("Confirmación","¿Estás seguro de eliminar este Cliente?","<button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button> <a href='#' id='confirmarBorrar' data-id='"+idc+"' class='btn btn-danger'>Si, aceptar</a>")
    return false;
  });


  $('body').on('click', '#confirmarBorrar', function () {
    var  idc=$(this).data("id");
    $.ajax({
      url: base_url + 'clientes/delCliente',
      data: {idc:idc},
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






});








// *********************************************
// funciones
// *********************************************
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
