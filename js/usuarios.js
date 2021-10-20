$( document ).ready(function(){


  /* ********************************************************
  DataTable
  ********************************************************* */
  var table = $('#tbUsuarios').DataTable( {

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
     // { extend: 'colvis', text: '<i class="fa fa-eye" aria-hidden="true"></i>' },{ extend: 'copy', text: '<i class="fa fa-clipboard" aria-hidden="true"></i>' }, { extend: 'excel', text: '<i class="fa fa-file-excel-o text-success" aria-hidden="true"></i>',title: 'Mi Inventario' }, { extend: 'pdf', text: '<i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i>',title: 'Mi Inventario' },{ extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i>' }

    ],
    columnDefs:[
      { orderable: false, targets: [0] },{ orderable: false, targets: [6] }
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
  Nuevo Usuario
  ********************************************************* */
  $('body').on('click', '#btnNuevoUser', function () {
    $.ajax({
      url: base_url + 'usuarios/addHtml',
      data: {},
      type: 'POST',
      // dataType: "json",
      success: function (html) {
        $(".modal-header").html('<span class="text-right" style="font-size:17px"><i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo Usuario</span><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
        $(".modal-body").html(html);
        $(".modal-footer").html("");
        $("#Modal").modal("show");
      }
    });
  });

  $('body').on('submit', '#formAddUser', function () {
    $.ajax({
      url: base_url + 'usuarios/addUser',
      data: $(this).serialize(),
      type: 'POST',
      success: function (resultado) {
        if(resultado=="x1"){
          $("#msjModal").html('<div class="callout callout-danger alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><p><b>Usuario duplicado.</b> El nombre de usuario ya exista, elija otro e inténtelo de nuevo.</p></div>');
        }
        else{
          location.reload();
        }
      },
      error: function (data) {
        // $("#msjModal").html('<div class="callout callout-danger">'+data['responseText']+'</div>');
        // alerta('Error interno', data['responseText'], '');
      }
    });
    return false;
  });






  $('body').on('click', '.editaru', function () {
    var  idUser=$(this).data("idu");
    $.ajax({
      url: base_url + 'usuarios/addHtml/'+idUser,
      data: {},
      type: 'POST',
      success: function (html) {
        $(".modal-header").html('<span class="text-right" style="font-size:17px"><i class="fa fa-pencil" aria-hidden="true"></i> Editar Usuario</span><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
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


  $('body').on('submit', '#formModUser', function () {
    $("#Modal").modal("hide");
    $.ajax({
      url: base_url + 'usuarios/modUser',
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




  $('body').on('click', '.delu', function () {
    var  idu=$(this).data("idu");
    $(".modal-header").html('<span class="text-right" style="font-size:17px"><i class="fa fa-user-plus" aria-hidden="true"></i> Eliminar Usuario</span><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
    // $(".modal-body").html("Estas Seguro");
    // $(".modal-footer").html("");
    // $("#ModalMini").modal("show");
    alertaMini("Confirmación","¿Estás seguro de eliminar este usuario?","<button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button> <a href='#' id='confirmarBorrar' data-id='"+idu+"' class='btn btn-danger'>Si, aceptar</a>")
    return false;
  });


  $('body').on('click', '#confirmarBorrar', function () {
    var  idu=$(this).data("id");
    $.ajax({
      url: base_url + 'usuarios/delUsuario',
      data: {idu:idu},
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
