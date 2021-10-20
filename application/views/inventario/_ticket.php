<html>
<head>
</head>
<body>
<style>
.sin-margen{
  margin: 0;
  padding: 0;
}
.text-center{
  text-align: center;
}
.text-right{
  text-align: left;
}
</style>

<h2 class="text-center"><?=$nombreEmpresa?></h2>
<label>Venta: <u><?=$detalleVenta['id']?></u></label>
<br>
<label>Vendedor: <u><?=$vendedor['nombre']?></u></label>
<br>
<label>Fecha y Hora: <u><?=date('d-m-Y H:i:s', strtotime($detalleVenta['Fecha']))?></u></label>
<br>
<br>
<table id="tbventa" class="table table-striped table-bordered dt-responsive nowrap table-hover table-condensed" cellspacing="0" width="100%" style="background: white!important">
  <thead>
    <tr>
      <th class="bg-default"><span>Código</span></th>
      <th class="bg-default"><span>Descripción</span></th>
      <th style="text-align: left"><span>P.U.</span></th>
      <th style="text-align: left"><span>Cantidad</span></th>
      <th style="text-align: left"><span>Importe</span></th>

    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($detalle as $fila){
      $item = $this->consultas->getInventariobyId($fila['idInventario']);
      ?>
      <tr>
        <td class="text-center"><?=$item['codigo']?></td>
        <td><?=$item['descripcion']?></td>
        <td class="text-right"><?=$monedaString?> <?=number_format($fila['costoUnitario'],2)?></td>
        <td class="text-center"><?=$fila['cantidad']?></td>
        <td class="text-right"><?=$monedaString?> <?=number_format($fila['costoUnitario']*$fila['cantidad'],2)?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <br>
  <div style="text-align: right">
    <label>
      <?php
      if($detalleVenta['impuestoPorciento']>0){
        $subtotal=$detalleVenta['Total']/(1+($detalleVenta['impuestoPorciento']/100));
        ?>
        Subtotal: <?=$monedaString?> <?=number_format($subtotal,2)?></br>
        <?=$detalleVenta['nombreImpuesto']?> (<?=$detalleVenta['impuestoPorciento']?>%): $ <?=number_format($detalleVenta['Total']-$subtotal,2)?></br>
        <b>Total: <?=$monedaString?> <?=number_format($detalleVenta['Total'],2)?></b>
        <?php
      }
      else {
        ?>
        <b>Total: <?=$monedaString?> <?=number_format($detalleVenta['Total'],2)?></b>
        <?php
      }
      ?>
    </label>
  </div>
  <div style="text-align: center;">
    <br>
    <label>, que tenga un buen día.</label>
    <br>
    VA
    <!-- <label>Dirección.</label> -->
  </div>
</body>
</html>
