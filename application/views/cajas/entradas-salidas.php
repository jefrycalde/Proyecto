<!-- ******************************************************************************************************************* -->
<!-- ******************************************************************************************************************* -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Cajas
      <small>Entradas y Salidas</small>
    </h1>
</section>



<!-- Main content -->
<section class="content">
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Registro Entradas y Salidas</h3>
        </div>
        <div class="box-body">
          <div class="col-lg-12 col-xs-12">
            <?php foreach ($cajas as $caja) {
            ?>
              <button class="btn btn-primary btn-lg es-reg" data-id="<?=$caja['id']?>"><?=$caja['descripcion']?></button>
            <?php  
            } ?>
          
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

