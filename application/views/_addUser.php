<div id="msjModal"></div>
<form class='form' id='<?=$idForm?>' autocomplete='off'>
  <input type='hidden' name='idu' value='<?=$idUser?>'/>
  <div class='form-group'>
    <label>Nombre(s) del Usuario</label>
    <input type='text' class='form-control' placeholder='Nombre Completo' name='nombre' maxlength='50' required='required' value='<?=$nombre?>'/>
  </div>

  <?php
  if($idUser!=1)
  {
    ?>


    <div class='form-group'>
      <label>Alias del Usuario</label>
      <input autocomplete='off' type='text' class='form-control' placeholder='Alias' name='alias' maxlength='20' id='nnu'  required='required' value='<?=$alias?>'/>
    </div>

    <div class='form-group'>
      <label>Dirección <small>(opcional)</small></label>
      <input type='text' class='form-control' placeholder='Dirección completa' name='direccion' maxlength='254' value='<?=$usuario['direccion']?>'/>
    </div>

    <div class='form-group'>
      <label>Telefono <small>(opcional)</small></label>
      <input type='text' class='form-control' placeholder='0000000000' name='telefono' maxlength='10' value='<?=$usuario['telefono']?>'/>
    </div>
    <?php
  }
  ?>

  <?php
  if($textoBoton=="Modificar"){
    if($idRol==1){
      ?>
      <div class='form-group'>
        <label>Rol</label>
        <input type='text' class='form-control' placeholder='Alias' value='<?=$usuario['rol']?>' disabled/>
      </div>
      <input type='hidden' name='idrol' value='<?=$idRol?>'/>
      <?php
    }
    else{
      ?>
      <div class='form-group'>
        <label>Rol</label>
        <select name="idrol" class="form-control">
          <?php
          foreach ($roles as $rol) {
            if($rol['id']==1) continue;
            if ($rol['id'] == $idRol) {
              $sel = ' selected';
            } else {
              $sel = '';
            }
            ?>
            <option value="<?=$rol['id']?>" <?=$sel?> ><?=$rol['rol']?></option>';
            <?php
          }
          ?>
        </select>
      </div>
      <?php
    }
  }
  else{
    ?>
    <div class='form-group'>
      <label>Rol</label>
      <select name="idrol" class="form-control">
        <?php
        foreach ($roles as $rol) {
          if($rol['id']==1) continue;
          ?>
          <option value="<?=$rol['id']?>" ><?=$rol['rol']?></option>';
          <?php
        }
        ?>
      </select>
    </div>
    <?php
  }
  ?>

  <div class='form-group'>
    <label>Contraseña</label>
    <input autocomplete='off' type='text' class='form-control' placeholder='Contraseña' name='pass' id='pwdnu' maxlength='20' required='required' value='<?=$pass?>'/>
  </div>

  <br/><br/>
  <button type='submit' class='btn btn-success pull-right'><?=$textoBoton?></button>
  <div class='pull-right'>&nbsp;&nbsp;&nbsp;&nbsp;</div>
  <button type='button' class='btn btn-default pull-right' data-dismiss='modal'>Cancelar</button>
</form>
