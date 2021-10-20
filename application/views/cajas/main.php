<!-- ******************************************************************************************************************* -->
<!-- ******************************************************************************************************************* -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Cajas
      <small>Vista General</small>
    </h1>
</section>



<!-- Main content -->
<section class="content">
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Lista de cajas</h3>
        </div>
        <div class="box-body">
            <button id="add-modal"class="btn btn-success pull-right">Agregar <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
            <br>
            <br>
            <br>
            <br>
          <div class="col-lg-12 col-xs-12">
            <div class="table-responsive">
              <table id="tbCajas" class="table table-striped table-bordered dt-responsive table-hover table-condensed" cellspacing="0" width="100%" style="background: white!important">
                <thead>
                  <tr>
                    <th class="bg-primary"><span>id</span></th>
                    <th class="bg-primary"><span>Descripción</span></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($cajas as $item) {
                    ?>
                    <tr data-id="<?=$item['id']?>">
                      <td><?=$item['id']?></td>
                      <td><?=$item['descripcion']?></td>
                      <!--td><button class="btn btn-warning btn-xs editar" data-id="<?=$item['id']?>">Editar</button></td-->
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- Your Page Content Here -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- ******************************************************************************************************************* -->
    <!-- ******************************************************************************************************************* -->

