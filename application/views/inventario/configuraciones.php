<style media="screen">
#radioBtn .notActive{
  color: #282828;
  background-color: #edecec;
}

</style>


<!-- ******************************************************************************************************************* -->
<!-- ******************************************************************************************************************* -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Configuraciones
      <!-- <small>Nuevo Producto</small> -->
    </h1>

</section>

<!-- Main content -->
<section class="content">
  <div id="msj"></div>
  <section class="content">
    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <img src="data:image/jpeg;base64,<?=base64_encode( $logo )?>" class="profile-user-img img-responsive "/>

            <h3 class="profile-username text-center mayus nombre"><?=htmlspecialchars(addslashes(stripslashes(strip_tags(trim($nombreEmpresa)))));?></h3>

            <button class="btn btn-success btn-block" id="btnChangeLogo"><b>Cambiar Logo</b></button>
          </div>   <!-- /.box-body -->
        </div>   <!-- /.box -->


        <div class="clearfix"></div><br>

        <!-- Impuesto -->
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title">Impuesto</h3>
          </div>
          <div class="box-body box-profile">
            <form  id="formImpuesto" autocomplete="off">
              <div class="container-fluid">

                <center>
                  <div class="form-group">
                    <label class="control-label">
                      Manejar Impuesto:
                    </label>
                    <br>
                    <div class="input-group">
                      <div id="radioBtn" class="btn-group">
                        <a class="btn btn-success btn-sm <?=$impuesto_si?>" data-toggle="impuesto" data-title="1"><i class="fa fa-check" aria-hidden="true"></i> SI</a>
                        <a class="btn btn-success btn-sm <?=$impuesto_no?>" data-toggle="impuesto" data-title="0"><i class="fa fa-times" aria-hidden="true"></i> NO</a>
                      </div>
                      <input type="hidden" name="impuesto" id="impuesto" value="<?=$configs->impuesto?>">
                    </div>
                  </div>
                </center>

                <div class="<?=$impuesto_ok?>">

                  <div class="form-group">
                    <label for="exampleInputEmail1">Nombre del Impuesto:</label>
                    <input type="text" maxlength="8" class="form-control" name="nombreImpuesto" id="nombreImpuesto" placeholder="Mi negocio" value="<?=$configs->nombreImpuesto?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Valor de Impuesto:</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="impuestoPorciento" placeholder="16.00" name="impuestoPorciento" value="<?=$configs->impuestoPorciento?>">
                      <div class="input-group-addon"><i class="fa fa-percent" aria-hidden="true"></i></div>
                    </div>
                  </div>

                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-success"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Guardar</button>
                </div>

              </form>
            </div>
          </div>
        </div>   <!-- /Impuesto -->

      </div>

      <div class="col-md-9">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Datos de tu negocio</h3>
          </div>
          <div class="box-body box-profile">
            <form  id="formName" autocomplete="off">
              <div class="container-fluid">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nombre de tu negocio</label>
                  <input type="text" maxlength="50" class="form-control" name="nombre" id="exampleInputEmail1" placeholder="Mi negocio" value="<?=$nombreEmpresa?>">
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-success"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Guardar</button>
                </div>


              </form>
            </div>
          </div>
        </div>
      </div>





      <div class="col-md-9">

        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Departamentos</h3>
            <div class="pull-right box-tools">
              <button type="button" class="btn btn-primary btn-sm" id="btnNuevoDep" data-toggle="tooltip" title="Agregar nuevo Departamento" data-original-title="Agregar nuevo Departamento">
                <i class="fa fa-bookmark" aria-hidden="true"></i> Nuevo
              </button>
            </div>
          </div>
          <div class="box-body box-profile">
            <!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%5 -->
            <table id="tbDepartamentos" class="table table-striped table-bordered dt-responsive nowrap table-hover table-condensed" cellspacing="0" width="100%" style="background: white!important">
              <thead>
                <tr>
                  <th class="bg-primary"><span>&nbsp;</span></th>
                  <th class="bg-primary"><span>Id</span></th>
                  <th class="bg-primary"><span>Nombre</span></th>
                  <th class="bg-primary text-center"><span>Modificar</span></th>
                  <!-- <th class="bg-primary text-center"><span>Eliminar</span></th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($departamentos as $departamento) {
                  ?>
                  <tr data-id="<?=$departamento['id']?>">
                    <td class="text-center"><i class="fa fa-bookmark" aria-hidden="true"></i></td>
                    <td class="text-left"><?=$departamento['id']?></td>
                    <td class="text-left"><?=$departamento['departamento']?></td>
                    <td class="text-center">
                      <a href="#" class="btn btn-primary btn-xs editarDep" title="Editar" data-idd="<?=$departamento['id']?>"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
                    </td>
                    <!-- <td class="text-center">
                    <a href="#" class="btn btn-danger btn-xs delDep" title="Eliminar" data-idd="<?=$departamento['id']?>"><i class="fa fa-trash-o" aria-hidden="true"> Eliminar</i></a>
                  </td> -->
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%5 -->
        </div>
      </div>
    </div>







  </section>



</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- ******************************************************************************************************************* -->
<!-- ******************************************************************************************************************* -->
