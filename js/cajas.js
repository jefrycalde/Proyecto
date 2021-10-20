  
  $('body').on('click', '#add-modal', function () {
        $(".modal-header-lg").html('<span class="text-right" style="font-size:17px"> Agregar Nueva Caja </span><button type="button" class="close" data-dismiss="modal" onclick="location.reload();" aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
        $(".modal-body-lg").html('<div class="col-md-12 col-lg-12 col-xs-12"><input type="text" class="form-control" placeholder="Descripción" maxlength="100" name="descripcion" id="descripcion" required="required"></div>');
        $(".modal-footer-lg").html('<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button><button type="button" id="guarda-caja" class="btn btn-primary" data-dismiss="modal" >Guardar</button>');
        $('#ModalLG').modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#ModalLG").modal("show");

  });

    $('body').on('click', '.es-reg', function () {
        var id=$(this).data("id");
        $(".modal-header-lg").html('<span class="text-right" style="font-size:17px"> Registrar Entrada-Salida </span><button type="button" class="close" data-dismiss="modal" onclick="location.reload();" aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
        $(".modal-body-lg").html('<input type="hidden" id="id-caja" value="'+id+'"> <div class="form group col-md-4 col-lg-4 col-xs-12"><label>Monto: </label><div class="input-group"><span class="input-group-addon"><b>$</b></span><input type="text" class="form-control" placeholder="0.00" maxlength="13" name="monto" id="monto" required="required"></div></div> <div class="clearfix"></div><br><div class="form group col-md-4 col-lg-4 col-xs-12"><label>Tipo: </label><select class="form-control" id="tipo"><option value="1">Entrada</option><option value="0">Salida</option></select></div><div class="clearfix"></div><br><div class="col-md-12 col-lg-12 col-xs-12 form-group"><label>Razón</label><textarea class="form-control" maxlength="100" name="razon" id="razon" required="required"></textarea></div>');
        $(".modal-footer-lg").html('<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button><button type="button" id="guarda-es" class="btn btn-primary" data-dismiss="modal" >Guardar</button>');
        $('#ModalLG').modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#ModalLG").modal("show");


  });

    //var id=$(this).data("id");


 /* $('body').on('click', '.editar', function () {
        $(".modal-header-lg").html('<span class="text-right" style="font-size:17px"> Agregar Nueva Caja </span><button type="button" class="close" data-dismiss="modal" onclick="location.reload();" aria-label="Close"><span aria-hidden="true"><font color="#FF0000"><i class="fa fa-times" aria-hidden="true"></i></font></span></button><br>');
        $(".modal-body-lg").html('<div class="col-md-12 col-lg-12 col-xs-12"><input type="text" class="form-control" placeholder="Descripción" maxlength="100" name="descripcion" id="descripcion" required="required"></div>');
        $(".modal-footer-lg").html('<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button><button type="button" id="guarda-caja" class="btn btn-primary" data-dismiss="modal" >Guardar</button>'); <div class="form group col-md-4 col-lg-4 col-xs-12"><label>Monto: </label>
        $('#ModalLG').modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#ModalLG").modal("show");

  });*/

  $('body').on('click', '#guarda-es', function () {
    var raz = $('#razon').val();
    var idc = $('#id-caja').val();
    var mont = $('#monto').val();
    var tip = $('#tipo').val();
    $.ajax({
      url: base_url + 'mcaja/guardaMovimiento',
      data: {razon: raz,id:idc,monto:mont,tipo:tip},
      type: 'POST',
      // dataType: "json",
      success: function () {
        location.reload();
      }
    });

  });

   $('body').on('click', '#guarda-caja', function () {
    var des = $('#descripcion').val();
    $.ajax({
      url: base_url + 'cajas/guardar',
      data: {descripcion: des},
      type: 'POST',
      // dataType: "json",
      success: function () {
        location.reload();
      }
    });

  });

  var table = $('#tbMovimientosCaja').DataTable( {

    language: {
      processing: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      search: "<i class='fa fa-search' aria-hidden='true'></i>",
      lengthMenu:     "Mostrando _MENU_ movimientos",
      info:           "Mostrando del _START_ al _END_ de _TOTAL_ movimientos",
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
      //{ extend: 'colvis', text: '<i class="fa fa-eye" aria-hidden="true"></i>' },{ extend: 'copy', text: '<i class="fa fa-clipboard" aria-hidden="true"></i>' }, { extend: 'excel', text: '<i class="fa fa-file-excel-o text-success" aria-hidden="true"></i>',title: 'ofertas' }, { extend: 'pdf', text: '<i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i>',title: 'ofertas' },{ extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i>' }

    ],
    order:[
      [ 1, 'asc' ]
    ],
    stateSave: true
  } );

    table.buttons().container()
  .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );


   var table = $('#tbCajas').DataTable( {

    language: {
      processing: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      search: "<i class='fa fa-search' aria-hidden='true'></i>",
      lengthMenu:     "Mostrando _MENU_ cajas",
      info:           "Mostrando del _START_ al _END_ de _TOTAL_ cajas",
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
      //{ extend: 'colvis', text: '<i class="fa fa-eye" aria-hidden="true"></i>' },{ extend: 'copy', text: '<i class="fa fa-clipboard" aria-hidden="true"></i>' }, { extend: 'excel', text: '<i class="fa fa-file-excel-o text-success" aria-hidden="true"></i>',title: 'ofertas' }, { extend: 'pdf', text: '<i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i>',title: 'ofertas' },{ extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i>' }

    ],
    order:[
      [ 1, 'asc' ]
    ],
    stateSave: true
  } );
   
  table.buttons().container()
  .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );