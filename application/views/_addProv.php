<form class='form' id='<?=$idForm?>' autocomplete='off'>
  <input type='hidden' name='idp' value='<?=$idProv?>'/>
  <div class='form-group'>
    <label>Nombre del proveedor</label>
    <input type='text' class='form-control' placeholder='Nombre' name='nombre' maxlength='50' required='required' value='<?=$nombre?>'/>
  </div>

    <div class='form-group'>
      <label>RFC</label>
      <input type='text' class='form-control' placeholder='RFC' name='rfc' maxlength='13' required='required' value='<?=$proveedor['rfc']?>'/>
    </div>

    <div class='form-group'>
      <label>Teléfono</label>
      <input type='text' class='form-control' placeholder='0000000000' name='tel' maxlength='10' required='required' value='<?=$proveedor['telefono']?>'/>
    </div>





  <br/><br/>
  <button type='submit' class='btn btn-success pull-right'><?=$textoBoton?></button>
  <div class='pull-right'>&nbsp;&nbsp;&nbsp;&nbsp;</div>
  <button type='button' class='btn btn-default pull-right' data-dismiss='modal'>Cancelar</button>
</form>
