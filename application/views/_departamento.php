<form class='form' id='<?=$idForm?>' autocomplete='off'>
<input type='hidden' name='idDep' value='<?=$idDep?>'/>
<div class='form-group'>
  <label>Nombre del Departamento</label>
  <input type='text' class='form-control' placeholder='Nombre' name='nombre' maxlength='50' required='required' value='<?=$nombre?>'/>
</div>

<button type='submit' class='btn btn-success pull-right'><?=$textoBoton?></button>
<div class='pull-right'>&nbsp;&nbsp;&nbsp;&nbsp;</div>
<button type='button' class='btn btn-default pull-right' data-dismiss='modal'>Cancelar</button>
</form>
