<!-- <center>
<table class="table">
<thead>
<tr>

</tr>
</thead>
<tbody>
<tr>

</tr>
</tbody>
</table>
</center> -->

<h4>Venta: <u><?=$detalleVenta['id']?></u></h4>
<h4>Vendedor: <u><?=$vendedor['nombre']?></u></h4>
<h4>Fecha y Hora: <u><?=date('d-m-Y H:i:s', strtotime($detalleVenta['Fecha']))?></u></h4>
<h4>Cliente: <u><?=$detalleVenta['cliente']?></u></h4>
<?php
if($detalleVenta['tipoPago']==1){
  ?>
  <h4>Folio de pago por tarjeta: <u><?=$detalleVenta['operacionBaucher']?></u></h4>
  <?php
}
 ?>
<table id="tbventa" class="table table-striped table-bordered dt-responsive nowrap table-hover table-condensed" cellspacing="0" width="100%" style="background: white!important">
  <thead>
    <tr>
      <th class="bg-default"><span>Codigo</span></th>
      <th class="bg-default"><span>Descripcion</span></th>
      <th class="bg-default"><span>Costo Unitario</span></th>
      <th class="bg-default text-center"><span>Cantidad</span></th>
      <th class="bg-default text-center"><span>Importe</span></th>
      <th class="hidden"><span>Descartar</span></th>
      <th class="hidden"><span>importex</span></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $valorTotal=0;
    foreach ($detalle as $fila){
      $importeFila = $fila['costoUnitario']*$fila['cantidad'];
      $item = $this->consultas->getInventariobyId($fila['idInventario']);
      ?>
      <tr>
        <td class="text-center"><?=$item['codigo']?></td>
        <td><?=$item['descripcion']?></td>
        <td class="text-right"><?=$monedaString?> <?=number_format($fila['costoUnitario'],2)?></td>
        <td class="text-center"><?=number_format($fila['cantidad'],2)?></td>
        <td class="text-right"><?=$monedaString?> <?=number_format($importeFila,2)?></td>
      </tr>
      <?php
      $valorTotal+=$importeFila;
    }
    ?>
    </tbody>
  </table>

  <div class="text-right">
    <h4>
      <?php
      if($detalleVenta['impuestoPorciento']>0){
        ?>
        Subtotal: <?=$monedaString?> <?=number_format($valorTotal,2)?></br>
        Impuesto: <?=$monedaString?> <?=number_format($detalleVenta['Total']-$valorTotal,2)?></br>

        <b>Total: <?=$monedaString?> <?=number_format($detalleVenta['Total'],2)?></b>
        <?php
      }
      else {
        ?>
        <?php if($detalleVenta['impuestoDescuento']>0){ ?>
        <b>Descuento Oferta: <?=$monedaString?> <?=number_format($detalleVenta['impuestoDescuento'],2)?></b><br>
        <?php } ?>
        <b>Total: <?=$monedaString?> <?=number_format($detalleVenta['Total'],2)?></b>
        <?php
      }
      ?>
    </h4>
  </div>
