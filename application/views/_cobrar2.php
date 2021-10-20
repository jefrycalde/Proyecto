<center>
  <h2>Pago por Tarjeta</h2>
  <form class="form form-inline" action="" method="post" id="formrecibido" autocomplete="off">
    <input type="hidden" name="idVenta" value="<?=$idVenta?>">
    <input type="hidden" name="total" value="<?=$total?>">
    <input type="hidden" name="impuesto" value="<?=$impuesto?>">
    <input type="hidden" name="descuento" value="<?=$descuento?>">
    <input type="hidden" name="tipo" value="<?=$tipo?>">
    <?php
    if($impuesto)
    {
      ?>
      <input type="hidden" name="impuestoPorciento" value="<?=$impuestoPorciento?>">
      <input type="hidden" name="nombreImpuesto" value="<?=$nombreImpuesto?>">
      <?php
    }
    ?>
    <div class="form-group">
      <label for="recibido">Código de Operación:</label>
        <input type="text" class="form-control" id="codigo" autofocus name="codigo" maxlength="20" required="required">
      
    </div>
    <br>
    <br>
    <button type="submit" class="btn btn-success btn-block">Continuar</button>
  </form>
</center>
