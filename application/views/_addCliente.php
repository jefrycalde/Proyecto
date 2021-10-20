<form class='form' id='<?=$idForm?>' autocomplete='off'>
  <input type='hidden' name='idc' value='<?=$idCliente?>'/>
  <div class='form-group'>
    <label>Nombre del cliente</label>
    <input type='text' class='form-control' placeholder='Nombre completo' name='nombre' maxlength='70' required='required' value='<?=$nombre?>'/>
  </div>

  <div class='form-group'>
    <label>cédula de identidad [DNI, RFC]</label>
    <input type='text' class='form-control' placeholder='cédula de identidad' name='identidad' maxlength='20' value='<?=$cliente['identidad']?>'/>
  </div>

  <div class='form-group'>
    <label>Dirección</label>
    <input type='text' class='form-control' placeholder='Direccioón completa' name='direccion' maxlength='100' value='<?=$cliente['direccion']?>'/>
  </div>

  <div class='form-group'>
    <label>Teléfono</label>
    <input type='text' class='form-control' placeholder='0000000000' name='telefono' maxlength='15' value='<?=$cliente['telefono']?>'/>
  </div>

  <div class='form-group'>
    <label>Correo</label>
    <input type='email' class='form-control' placeholder='ejemplo@mail.com' name='correo' maxlength='100' value='<?=$cliente['correo']?>'/>
  </div>



  <br/><br/>
  <button type='submit' class='btn btn-success pull-right'><?=$textoBoton?></button>
  <div class='pull-right'>&nbsp;&nbsp;&nbsp;&nbsp;</div>
  <button type='button' class='btn btn-default pull-right' data-dismiss='modal'>Cancelar</button>
</form>
