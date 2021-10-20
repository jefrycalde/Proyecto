<!-- ******************************************************************************************************************* -->
<!-- ******************************************************************************************************************* -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper ">

  <!-- Main content -->
  <section class="content ">

    <section class="content ">
      <div class="row">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">Venta Temporal </h3>
          </div>
          <div class="box-body" id="general">

          	<?php if(!empty($ventastemp)){ ?>

          	<table class="table table-stripped">
          		<?php foreach ($ventastemp as $venta) { ?>
          			<tr>
          				<td>Id Venta Pendiente</td>
          				<td><?=$venta['id_venta']?></td>
          				<td><a class="btn btn-primary" href="<?=base_url('pventap/ventatemp/'.$venta['id_venta'])?>">Ir a la Venta</a></td>
          			</tr>
          		<?php } ?>
          	</table>

          	<?php }else{ ?>
          	<h3>No se encontraron ventas temporales</h3>

          	<?php } ?>
          </div>
      </div>
  </div>
</section>
</section>
</div>