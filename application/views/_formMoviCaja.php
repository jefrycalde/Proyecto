  <form class="form" action="" method="post" id="formMoviCaja" autocomplete="off">

    <input type="hidden" name="tipo" value="<?=$tipo?>">

    <div class="form-group">
      <label for="monto">Monto:</label><br>
      <div class="input-group">
        <div class="input-group-addon">$</div>
        <input type="text" class="form-control" id="monto" autofocus name="monto" maxlength="7" required="required" placeholder="0.00">
      </div>
    </div>

    <div class="form-group" id="ftpago">
      <label for="razon"><?=$txtlabel?>:</label><br>
        <TEXTAREA class="form-control" id="razon" name="razon" rows="2" maxlength="200"></TEXTAREA>
    </div>

    <div class="form-group">
      <label for="monto">Clave del administrador:</label><br>
      <div class="input-group">
        <div class="input-group-addon"><i class="fa fa-key"></i></div>
        <input type="password" class="form-control" id="key" name="key" maxlength="20" required="required" placeholder="***********">
      </div>
    </div>

    <button type="submit" class="btn btn-success btn-block"><?=$txtbutton?></button>
  </form>
