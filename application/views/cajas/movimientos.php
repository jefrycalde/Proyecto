<!-- ******************************************************************************************************************* -->
<!-- ******************************************************************************************************************* -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Registro de Movimientos
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">Movimiento de cajas</h3>
          </div>
          <div class="box-body">
            <div class="col-lg-12 col-xs-12">
              <!-- ñññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññ           -->
              <div class="table-responsive">
                <!-- <table cellspacing="0" cellpadding="0" id="tbInventario" class="table table-striped table-bordered table-hover table-condensed"> -->
                <table id="tbMovimientosCaja" class="table table-striped table-bordered dt-responsive nowrap table-hover table-condensed" cellspacing="0" width="100%" style="background: white!important">
                  <thead>
                    <tr>
                      <th class="bg-primary text-center"><span>Id</span></th>
                      <th class="bg-primary text-center"><span>Caja</span></th>
                      <th class="bg-primary"><span>Usuario</span></th>
                      <th class="bg-primary"><span>Tipo</span></th>
                      <th class="bg-primary"><span>Razón</span></th>
                      <th class="bg-primary"><span>Monto</span></th>
                      <th class="bg-primary"><span>Fecha y hora</span></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($movimientos as $movimiento) {

                      if($movimiento['tipo']==0){
                        $movimiento['tipo']="<span class=\"label label-success\">&nbsp;&nbsp;SALIDA&nbsp;&nbsp;</span>"; //"Salida";
                      }
                      else{
                        $movimiento['tipo']="<span class=\"label label-primary\">ENTRADA</span>"; //"Entrada";
                      }
                      ?>
                      <tr data-id="<?=$movimiento['id']?>">
                        <td class="text-center"><?=$movimiento['id']?></td>
                        <td class="text-center"><?=$movimiento['descripcion']?></td>
                        <td><?=$movimiento['nombre']?></td>
                        <td class="text-center"><?=$movimiento['tipo']?></td>
                        <td class="text-center"><?=$movimiento['razon']?></td>
                        <td class="text-center"><?=$monedaString?><?=number_format($movimiento['monto'],2)?></td>
                        <td class="text-center"><?=date('d-m-Y H:i:s', strtotime($movimiento['fecha']))?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <!-- ñññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññ           -->
              </div>
            </div>
          </div>
          <!-- ========================================================================================================================= -->

          <!-- Your Page Content Here -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- ******************************************************************************************************************* -->
      <!-- ******************************************************************************************************************* -->
