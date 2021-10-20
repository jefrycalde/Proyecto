<!-- ******************************************************************************************************************* -->
<!-- ******************************************************************************************************************* -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Administrar Usuarios
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
            <button type="button" class="btn btn-primary btn-sm" id="btnNuevoUser" data-toggle="tooltip" title="Agregar nuevo usuario" data-original-title="Agregar nuevo usuario">
              <i class="fa fa-user-plus fa-lg" aria-hidden="true"></i> Agregar usuario
            </button>
          </div>
          <!-- ****************************** -->
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
                    <th class="bg-primary"><span>Dirección</span></th>
                    <th class="bg-primary"><span>Teléfono</span></th>
                    <th class="bg-primary"><span>Rol</span></th>
                    <th class="bg-primary max-width-100"><span>Acciones</span></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($usuarios as $user) {
                    $info="";
                    if($user['idRol']==1){
                      $info="class='info'";
                    }
                    ?>
                    <tr data-id="<?=$user['id']?>" <?=$info?>>
                      <td class="text-center"><i class="fa fa-user" aria-hidden="true"></i></td>
                      <td class="text-left"><?=$user['nombre']?></td>
                      <td class="text-center"><?=$user['username']?></td>
                      <?php
                      if($user['idRol']==1)
                      {
                      ?>
                      <td class="text-left">No aplica</td>
                      <td class="text-left"></td>
                      <?php
                    }
                    else{
                      ?>
                      <td class="text-left"><?=$user['direccion']?></td>
                      <td class="text-left"><?=$user['telefono']?></td>
                      <?php
                    }
                      ?>
                      <td class="text-center"><?=$user['rol']?></td>
                      <td class="text-center">
                        <a href="#" class="btn btn-primary btn-xs editaru" title="Editar" data-idu="<?=$user['id']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <?php
                        if($user['idRol']!=1){
                          ?>
                          <a href="#" class="btn btn-danger btn-xs delu" title="Eliminar" data-idu="<?=$user['id']?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                          <?php
                        }
                        ?>
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
