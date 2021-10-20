





<!-- ******************************************************************************************************************* -->
<!-- ******************************************************************************************************************* -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Inventario
      <small>Nuevo Producto</small>
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
          <h3 class="box-title">Agregar Nuevo Producto</h3>
        </div>
        <div class="box-body">
          <form id="formNewItem" autocomplete="off">
            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Código de producto:</label>
            </div>

            <div class="col-md-4 col-lg-4 col-xs-12">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Código" maxlength="13" name="codigo" id="codigo" autofocus="" required="required">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-info  gencodebar">Generar</button>
                </span>
              </div>
            </div>

            <div class="clearfix"></div><br>

            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Descripción del producto:</label>
            </div>
            <div class="col-md-9 col-lg-9 col-xs-12">
              <input type="text" class="form-control" placeholder="Descripción del producto" maxlength="60" name="descripcion" id="descripcion" required="required">
            </div>

            <div class="clearfix"></div><br>

            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Costo:</label>
            </div>
            <div class="col-md-2 col-lg-2 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><b><?=$monedaString?></b></span>
                <input type="text" class="form-control" placeholder="0" maxlength="13" name="costo" id="costo" required="required">
              </div>
            </div>

            <div class="clearfix"></div><br>

            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Precio al publico:</label>
            </div>
            <div class="col-md-2 col-lg-2 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><b><?=$monedaString?></b></span>
                <input type="text" class="form-control" placeholder="0"  name="precio" id="precio" required="required">
              </div>
            </div>

            <div class="clearfix"></div><br>

            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Precio al Mayoreo:</label>
            </div>
            <div class="col-md-2 col-lg-2 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><b><?=$monedaString?></b></span>
                <input type="text" class="form-control" placeholder="0"  name="pmayoreo" id="pmayoreo" required="required">
              </div>
            </div>

            <div class="clearfix"></div><br>

            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Cantidad para Mayoreo:</label>
            </div>
            <div class="col-md-2 col-lg-2 col-xs-12">
              <div class="input-group">
                <!-- <span class="input-group-addon"><i class="fa fa-bolt" aria-hidden="true"></i></span> -->
                <input type="text" class="form-control" placeholder="0"  name="cmayoreo" id="cmayoreo" required="required">
              </div>
            </div>

            <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
            <div class="clearfix"></div><br>

            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Se vende por:</label>
            </div>
            <div class="col-md-2 col-lg-2 col-xs-12">
              <select class="form-control" name="tipoVenta">
                <?php
                foreach ($tiposVenta as $tipo) {
                  ?>
                  <option value="<?=$tipo['id']?>"><?=$tipo['nombreTipo']?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

            <div class="clearfix"></div><br>

            <div class="col-md-2 col-lg-2 col-xs-12">
              <label for="codigo">Departamento:</label>
            </div>
            <div class="col-md-3 col-lg-3 col-xs-12">
              <div class="input-group">
                <select class="form-control input-group-addon" name="departamento" id="listDepartamentos">
                  <?php
                  foreach ($departamentos as $departamento) {
                    ?>
                    <option value="<?=$departamento['id']?>"><?=$departamento['departamento']?></option>
                    <?php
                  }
                  ?>
                </select>
                <span class="input-group-btn">
                  <button class="btn btn-primary addDepartamento"><i class="fa fa-plus" aria-hidden="true"></i></button>
                </span>
              </div>
            </div>


            <div class="clearfix"></div><br>

            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Proveedor:</label>
            </div>
            <div class="col-md-5 col-lg-5 col-xs-12">
              <select class="form-control" name="proveedor">
                <?php
                foreach ($proveedores as $proveedor) {
                  ?>
                  <option value="<?=$proveedor['id']?>"><?=strtoupper($proveedor['nombre'])?></option>
                  <?php
                }
                ?>
              </select>
            </div>

            <div class="clearfix"></div><br>

            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Stock Crítico:</label>
            </div>
            <div class="col-md-2 col-lg-2 col-xs-12">
              <div class="input-group">
                <!-- <span class="input-group-addon"><i class="fa fa-bolt" aria-hidden="true"></i></span> -->
                <input type="text" class="form-control" placeholder="0"  name="stockCritico" id="stockCritico" required="required">
              </div>
            </div>
             </div>

            <div class="clearfix"></div><br>

            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Stock :</label>
            </div>
            <div class="col-md-2 col-lg-2 col-xs-12">
              <div class="input-group">
                <!-- <span class="input-group-addon"><i class="fa fa-bolt" aria-hidden="true"></i></span> -->
                <input type="text" class="form-control" placeholder="0"  name="cantidad" id="cantidad" required="required">
              </div>
            </div>

            <div class="clearfix"></div><br>

            <div class="col-md-7 col-lg-7 col-xs-12">
              <button type="submit" class="btn btn-block btn-primary btn-lg">Agregar Nuevo Producto</button>
            </div>
          </form>
        </div>
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
