$( document ).ready(function(){

  $('#from').datetimepicker({
    language: 'es',
    format: "YYYY-MM-DD"//"DD-MM-YYYY"
  });
  $('#to').datetimepicker({
    language: 'es',
    format: "YYYY-MM-DD"//"DD-MM-YYYY"
  });




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
      [ 10, 25, 50, -1 ],
      [ '10', '25', '50', 'Todo' ]
    ],
    buttons: [
    { extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i>' }

    ],
    // columnDefs:[
    //   { orderable: false, targets: [4] }
    // ],
    order:[
      [ 3, 'asc' ]
    ],
    stateSave: true
  } );
  table.buttons().container()
  .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );






  $('body').on('click', '.detalle', function () {
    var idVenta=$(this).data("id");
    $.ajax({
      url: base_url + 'ventas/verDetalle',
      data: {idVenta:idVenta},
      type: 'POST',
      success: function (html) {
        // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
        $(".modal-header-lg").html('<span class="text-right" style="font-size:17px"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Detalles de Venta '+idVenta+'</span><button type="button" class="close" data-dismiss="modal"  aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
        $(".modal-body-lg").html(html);
        $(".modal-footer-lg").html('<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>');
        $('#ModalLG').modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#ModalLG").modal("show");
        return false;
        // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
      },
      error: function (data) {
        alerta('Error interno x7', data['responseText'], '');
      }
    });

  });





$('body').on('submit', '#formFechasCompras', function () {
  if(!reporte){
    $.ajax({
      url: base_url + 'vercompras/resultado',
      data: $(this).serialize(),
      type: 'POST',
      success: function (resultado) {
        debugger;
        if(resultado=="x1" || resultado=="x2" || resultado=="x3")
        {
          if(resultado=="x1"){
            miAlerta("danger","Error de datos","La fecha final es menor a la fecha inicial");
          }
          if(resultado=="x2"){
            miAlerta("danger","Error de datos","Alguna de las fechas esta pasada del día actual");
          }
          if(resultado=="x3"){
            miAlerta("danger","Error de datos","Debe de agregar las 2 fechas");
          }
          return false;
        }
        else {
          reporte=true;
          $("#formFechasCompras").submit();
        }

      },
      error: function (data) {
        alerta('Error interno', data['responseText'], '');
      }
    });
    return false;
  }
});





  var reporte=false;
    $('body').on('submit', '#formFechasVentas', function () {
      if(!reporte){
        $.ajax({
          url: base_url + 'ventas/resultado',
          data: $(this).serialize(),
          type: 'POST',
          success: function (resultado) {
            debugger;
            if(resultado=="x1" || resultado=="x2" || resultado=="x3")
            {
              if(resultado=="x1"){
                miAlerta("danger","Error de datos","La fecha final es menor a la fecha inicial");
              }
              if(resultado=="x2"){
                miAlerta("danger","Error de datos","Alguna de las fechas esta pasada del día actual");
              }
              if(resultado=="x3"){
                miAlerta("danger","Error de datos","Debe de agregar las 2 fechas");
              }
              return false;
            }
            else {
              reporte=true;
              $("#formFechasVentas").submit();
            }

          },
          error: function (data) {
            alerta('Error interno', data['responseText'], '');
          }
        });
        return false;
      }
    });

    $("body").on('click', '.reImpVenta', function () {
      var idVenta=$(this).data("idv");
      $.ajax({
        url: base_url + 'pventa/reImpVenta',
        data: {idVenta:idVenta},
        type: 'POST',
        success: function (html) {
          alertaMini("Reimpresión",
          "<center><div class='callout callout-info'><h4>Reimpresión lista.</h4></div></center>",
           "")
        },
        error: function (data) {
          debugger;
          alerta('Error interno', data['responseText'], '');
        }
      });
    });


}); // fin ready



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
  $("#msj").html(msj);
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
