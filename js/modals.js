
  /************************************************************************
    Modal de Alerta
*************************************************************************/
function alerta(titulo, mensaje, pie){
  $("#ModalMini").modal("hide");
  $("#Modal").modal("hide");
    /*  titulo:     Titulo de la ventana de alerta.
                    Si contiene "Error", el mensaje se mostrará de color rojo.
                    Si contiene "Exito", el mensaje se mostrará de color verde.
        mensaje:    Mensaje de la alerta.
        pie:        Botones de la ventana de alerta.
                    Si se deja en blanco, se mostrará un botón para cerrar la ventana.
    */
    if( titulo.indexOf("Error") != -1 ){
        mensaje='<div class="alert alert-danger">' + mensaje + '</div>';
        if(pie==''){
            pie='<button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>';
        }
    }
    else if( titulo.indexOf("Exito") != -1 ){
        mensaje='<div class="alert alert-success">' + mensaje + '</div>';
        if(pie==''){
            pie='<button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>';
        }
    }
    else{
        if(pie==''){
            pie='<button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>';
        }
    }

    $("#tituloModal").html(titulo);
    $("#contenidoModal").html(mensaje);
    $("#pieModal").html(pie);
    $('#Modal').modal({
        backdrop: 'static',
        keyboard: false
    });
    $("#Modal").modal("show");
}









/************************************************************************
  Modal de Alerta Mini
*************************************************************************/
function alertaMini(titulo, mensaje, pie){
  $("#ModalMini").modal("hide");
  $("#Modal").modal("hide");
    /*  titulo:     Titulo de la ventana de alerta.
                    Si contiene "Error", el mensaje se mostrará de color rojo.
                    Si contiene "Exito", el mensaje se mostrará de color verde.
        mensaje:    Mensaje de la alerta.
        pie:        Botones de la ventana de alerta.
                    Si se deja en blanco, se mostrará un botón para cerrar la ventana.
    */
    if( titulo.indexOf("Error") != -1 ){
        mensaje='<div class="alert alert-danger">' + mensaje + '</div>';
        if(pie==''){
            pie='<button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>';
        }
    }
    else if( titulo.indexOf("Exito") != -1 ){
        mensaje='<div class="alert alert-success text-center">' + mensaje + '</div>';
        if(pie==''){
            pie='<button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>';
        }
    }
    else{
        if(pie==''){
            pie='<button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>';
        }
    }

    $("#tituloModalMini").html(titulo);
    $("#contenidoModalMini").html(mensaje);
    $("#pieModalMini").html(pie);
    $('#ModalMini').modal({
        backdrop: 'static',
        keyboard: false
    });
    $("#ModalMini").modal("show");
}
