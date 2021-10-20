$( document ).ready(function(){

  $("#impuestoPorciento").numeric({ decimalPlaces: 2, negative: false });

  $('#radioBtn a').on('click', function () {
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#' + tog).prop('value', sel);
    $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
    if(sel==0)
    {
      $(".impuesto_ok").addClass("hide");
    }
    else {
      $(".impuesto_ok").removeClass("hide");
    }
  });


  $('body').on('click', '#btnNuevaImpresora', function () {
    $(".modal-header").html('<span class="text-right" style="font-size:17px"><i class="fa fa-plus" aria-hidden="true"></i><i class="fa fa-print" aria-hidden="true"></i> Nueva impresora</span><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
    $(".modal-body").html("<form id=\"formNewImpresora\">"+
    "<label>Direccion de la impresora</label>"+
    "<input type=\"text\" name=\"impresora\" class=\"form-control\">");
    $(".modal-footer").html("<center>     <button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>          <button type='submit' class='btn btn-success' style='margin-left:15px' onclick='gonewimpresora();'>Agregar</button>        </center>");
    $("#Modal").modal("show");
  });

  $('body').on('submit', '#formNewImpresora', function () {
    $.ajax({
      url: base_url + 'configuraciones/addImpresora',
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

  /* ********************************************************
  DataTable
  ********************************************************* */
  var table = $('#tbDepartamentos').DataTable( {

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
    columnDefs:[
      { orderable: false, targets: [0] },{ orderable: false, targets: [3] }
      // ,{ orderable: false, targets: [4] }
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
  $('body').on('click', '#btnNuevoDep', function () {
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
  });

  $('body').on('submit', '#formAddDep', function () {
    $("#Modal").modal("hide");
    $.ajax({
      url: base_url + 'configuraciones/addDepartamento',
      data: $(this).serialize(),
      type: 'POST',
      success: function (resultado) {
        if(resultado=="1"){
          location.reload();
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


  $('body').on('submit', '#formImpuesto', function () {
    $("#Modal").modal("hide");
    $.ajax({
      url: base_url + 'configuraciones/saveImpuesto',
      data: $(this).serialize(),
      type: 'POST',
      success: function (resultado) {
        if(resultado=="1"){
          // location.reload();
          $("#ModalMini").modal("hide");
          var msj = miAlerta("success","Configuración de impuesto guardada", "La configuración con respecto al impuesto fue modificada correctamente");
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


  $('body').on('click', '.editarDep', function () {
    var  idDep=$(this).data("idd");
    $.ajax({
      url: base_url + 'configuraciones/depHtml/'+idDep,
      data: {},
      type: 'POST',
      success: function (html) {
        $(".modal-header-mini").html('<span class="text-right" style="font-size:17px"><i class="fa fa-tags" aria-hidden="true"></i> Editar Departamento</span><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
        $(".modal-body-mini").html(html);
        $(".modal-footer-mini").html("");
        $("#ModalMini").modal("show");
      },
      error: function (data) {
        alerta('Error interno', data['responseText'], '');
      }
    });
    return false;
  });



  $('body').on('submit', '#formModDep', function () {
    $("#Modal").modal("hide");
    $.ajax({
      url: base_url + 'configuraciones/modDep',
      data: $(this).serialize(),
      type: 'POST',
      success: function (resultado) {
        if(resultado=="1"){
          location.reload();
        }
        else {
          $("#ModalMini").modal("hide");
          var msj = miAlerta("danger","Departamento duplicado", "No se modificó el departamento pues intenta asignarle un nombre repetido");
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








  $('body').on('click', '.delDep', function () {
    var  idDep=$(this).data("idd");
    $(".modal-header").html('<span class="text-right" style="font-size:17px"><i class="fa fa-eraser" aria-hidden="true"></i> Eliminar Departamento</span><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
    // $(".modal-body").html("Estas Seguro");
    // $(".modal-footer").html("");
    // $("#ModalMini").modal("show");
    alertaMini("Confirmación","<center>¿Estás seguro de eliminar este departamento?</center>","<button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button> <a href='#' id='confirmarBorrar' data-id='"+idDep+"' class='btn btn-danger'>Si, eliminar</a>")
    return false;
  });


  $('body').on('click', '#confirmarBorrar', function () {
    var  idDep=$(this).data("id");
    $.ajax({
      url: base_url + 'configuraciones/delDep',
      data: {idDep:idDep},
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










  $('body').on('submit', '#formName', function () {
    $.ajax({
      url: base_url + 'configuraciones/saveName',
      data: $(this).serialize(),
      type: 'POST',
      success: function (resultado) {
        var msj = miAlerta("success","Datos Actualizados", "El nombre de su negocio se ha actualizado correctamente");
        $("#msj").html(msj);
        esconderAlerta();
        $(".nombre").html(resultado);
      },
      error: function (data) {
        alerta('Error interno', data['responseText'], '');
      }
    });
    return false;
  });



  $('body').on('submit', '#formTiketera', function () {
    $.ajax({
      url: base_url + 'configuraciones/saveTiketera',
      data: $(this).serialize(),
      type: 'POST',
      success: function (resultado) {
        var msj = miAlerta("success","Datos Actualizados", "Se ha guardado la configuración de su tiketera correctamente");
        $("#msj").html(msj);
        esconderAlerta();
      },
      error: function (data) {
        alerta('Error interno', data['responseText'], '');
      }
    });
    return false;
  });




  $('body').on('click', '#btnChangeLogo', function () {
    $("#setBody").html(getMiscFormL());
    $("#logo").click();
    return false;
  });
  $('body').on('change', '#logo', function () {
    $('#formLogo').submit();
  });

  $('body').on('submit', '#formLogo', function () {
    var formData = new FormData($("#formLogo")[0]);
    $.ajax({
      url: base_url + 'configuraciones/saveLogo',
      type: 'POST',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
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
  },2000);
  setTimeout(function() {
    $("#msj").html("");
    $("#msj").fadeIn(1);
  },3000);
}






function getMiscFormL() {
  var html =
  '<div class="modal-header">' +
  '<h3 class="modal-title" id="modalLabel"> Cargar Archivo Miscelaneo</h3>' +
  '</div>' +
  '</div>' +

  '<div class="modal-body">' +
  '<div class="row">' +
  '<div class="col-md-11">' +
  '<form id="formLogo" accept-charset="utf-8" method="post" ' +
  'enctype="multipart/form-data">' +

  '<div class="form-group">' +
  '<label for="comentario">Logo</label>' +
  '<input type="file" id="logo" name="logo" accept="image/*" required>' +
  '</div>' +

  '<div class="form-group">' +
  '<button type="submit" class="btn btn-yellow" ><i class="fa fa-folder-open"></i>Cargar</button>' +
  '</div>' +
  '</form>' +
  '</div>' +
  '</div>';

  return html;
}


function gonewimpresora() {
  $("#formNewImpresora").submit();
}
