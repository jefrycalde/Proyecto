<!-- ******************************************************************************************************************* -->
<!-- ******************************************************************************************************************* -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Administrar Proveedores
      <small>&nbsp;</small>
    </h1>
    <!-- <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
    <li class="active">Here</li>
  </ol> -->

</section>

<!-- Main content -->
<section class="content">
  <div id="msj"></div>
  <!-- ========================================================================================================================= -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Lista de Usuarios</h3>
          <!-- ****************************** -->
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-primary btn-sm" id="btnNuevoProv" data-toggle="tooltip" title="Agregar nuevo usuario" data-original-title="Agregar nuevo usuario">
              <i class="fa fa-user-secret" aria-hidden="true"></i> Nuevo proveedor
            </button>
          </div>
          <!-- ****************************** -->
        </div>
        <div class="box-body">
          <div class="col-lg-12 col-xs-12">
            <!-- ñññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññ           -->
            <div class="table-responsive">
              <!-- <table cellspacing="0" cellpadding="0" id="tbInventario" class="table table-striped table-bordered table-hover table-condensed"> -->
              <table id="tbProveedores" class="table table-striped table-bordered dt-responsive nowrap table-hover table-condensed" cellspacing="0" width="100%" style="background: white!important">
                <thead>
                  <tr>
                    <th class="bg-primary"><span>&nbsp;</span></th>
                    <th class="bg-primary"><span>RFC</span></th>
                    <th class="bg-primary"><span>Nombre</span></th>
                    <th class="bg-primary"><span>Teléfono</span></th>
                    <th class="bg-primary max-width-100"><span>Editar</span></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($proveedores as $proveedor) {
                    ?>
                    <tr data-id="<?=$proveedor['id']?>">
                      <td class="text-center"><i class="fa fa-user-secret" aria-hidden="true"></i></td>
                      <td class="text-center text-uppercase"><?=$proveedor['rfc']?></td>
                      <td class="text-left text-uppercase"><?=$proveedor['nombre']?></td>
                      <td class="text-center"><?=$proveedor['telefono']?></td>
                      <td class="text-center">
                        <a class="btn btn-primary btn-xs editarp" data-idp="<?=$proveedor['id']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a href="#" class="btn btn-danger btn-xs delp" title="Eliminar" data-idp="<?=$proveedor['id']?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                      </td>
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
