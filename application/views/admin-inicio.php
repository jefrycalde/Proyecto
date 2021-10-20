
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Accesos Frecuentes
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">

    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?=$articulos?></h3>

              <p>Articulos</p>
            </div>
            <div class="icon">
              <i class="fa fa-book" aria-hidden="true"></i>
            </div>
            <a href="<?=base_url()?>inventario" class="small-box-footer">Administrar Inventario <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?=$monedaString?><?=number_format($recaudado,2)?>
              </h3>

              <p>Recaudado hoy</p>
            </div>
            <div class="icon">
              <i class="fa fa-money" aria-hidden="true"></i>
            </div>
            <a href="<?=base_url()?>ventas" class="small-box-footer">Examinar ventas <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>



        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?=$usuarios?></h3>

              <p>Usuarios</p>
            </div>
            <div class="icon">
              <i class="fa fa-users" aria-hidden="true"></i>
            </div>
            <?php
            if($this->session->userdata('rol')=="1")
            {
              ?>
              <a href="<?=base_url()?>usuarios" class="small-box-footer">Administrar Usuarios <i class="fa fa-arrow-circle-right"></i></a>
              <?php
            }
            else {
              ?>
              <a href="#" class="small-box-footer">Administrar Usuarios Denegado</a>
              <?php
            }
            ?>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>&nbsp;</h3>
              <p>Configuraciones</p>
            </div>
            <div class="icon">
              <i class="fa fa-cog fa-spin" aria-hidden="true"></i>
            </div>
            <?php
            if($this->session->userdata('rol')=="1")
            {
              ?>
              <a href="<?=base_url()?>" class="small-box-footer">Ir a Configuraciones <i class="fa fa-arrow-circle-right"></i></a>
              <?php
            }
            else {
              ?>
              <a href="#" class="small-box-footer">Configuraciones Denegado</a>
              <?php
            }
            ?>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- Your Page Content Here -->





      <!-- ######################################################################################################################################## -->
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Recaudación del día por usuario</h3>
        </div>
        <div class="box-body">
          <div class="col-lg-12 col-xs-12">
            <!-- ñññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññ           -->
            <div class="table-responsive">
              <!-- <table cellspacing="0" cellpadding="0" id="tbInventario" class="table table-striped table-bordered table-hover table-condensed"> -->
              <table id="tbUsuarios" class="table table-striped table-bordered dt-responsive nowrap table-hover table-condensed" cellspacing="0" width="100%" style="background: white!important">
                <thead>
                  <tr>
                    <th class="bg-primary"><span>&nbsp;</span></th>
                    <th class="bg-primary"><span>Nombre(s)</span></th>
                    <th class="bg-primary"><span>Alias</span></th>
                    <th class="bg-primary"><span>Recaudación</span></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($listaUsuarios as $user) {
                    if($user['idRol']==1 || $user['idRol']==3){
                    continue;
                    }
                    ?>
                    <tr data-id="<?=$user['id']?>" >
                      <td class="text-center"><i class="fa fa-user" aria-hidden="true"></i></td>
                      <td class="text-left"><?=$user['nombre']?></td>

                      <td class="text-left"><?=$user['username']?></td>
                      <td class="text-center"><?=$monedaString?> <?= number_format($this->consultas->recaudacionByUserHoy($user['id']),2)?></td>

                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- ñññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññ           -->
            </div>
          </div>
        </div>
      <!-- ######################################################################################################################################## -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
