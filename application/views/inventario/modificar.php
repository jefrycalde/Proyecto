





<!-- ******************************************************************************************************************* -->
<!-- ******************************************************************************************************************* -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Modificar elemento
      <small>Inventario</small>
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
      <div class="box box-warning">
        <div class="box-header">
          <h3 class="box-title">Modificar elemento</h3>
        </div>
        <div class="box-body">
          <form id="modItem" autocomplete="off">
            <input type="hidden" name="id" value="<?=$item['id']?>">
            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Código de producto:</label>
            </div>

            <div class="col-md-4 col-lg-4 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="Código" maxlength="13" name="codigo" id="codigo" value="<?=$item['codigo']?>" required="required" readonly="readonly">
                <!-- <span class="input-group-btn">
                <button type="button" class="btn btn-info  buscarItem"><i class="fa fa-search" aria-hidden="true"></i></button>
              </span> -->
            </div>
          </div>

          <div class="clearfix"></div><br>

          <div class="col-md-3 col-lg-2 col-xs-12">
            <label for="codigo">Descripción del producto:</label>
          </div>
          <div class="col-md-9 col-lg-9 col-xs-12">
            <input type="text" class="form-control input-sm" placeholder="Descripción del producto" maxlength="60" name="descripcion" id="descripcion" required="required" value="<?=$item['descripcion']?>">
          </div>

          <div class="clearfix"></div><br>

          <div class="col-md-3 col-lg-2 col-xs-12">
            <label for="codigo">Costo:</label>
          </div>
          <div class="col-md-2 col-lg-2 col-xs-12">
            <div class="input-group">
              <span class="input-group-addon"><b><?=$monedaString?></b></span>
              <input type="text" class="form-control input-sm" placeholder="0.00" maxlength="13" name="costo" id="costo" required="required" value="<?=$item['costo']?>">
            </div>
          </div>

          <div class="clearfix"></div><br>

          <div class="col-md-3 col-lg-2 col-xs-12">
            <label for="codigo">Precio al publico:</label>
          </div>
          <div class="col-md-2 col-lg-2 col-xs-12">
            <div class="input-group">
              <span class="input-group-addon"><b><?=$monedaString?></b></span>
              <input type="text" class="form-control input-sm" placeholder="0.00"  name="precio" id="precio" required="required" value="<?=$item['precio']?>">
            </div>
          </div>

          <div class="clearfix"></div><br>

          <div class="col-md-3 col-lg-2 col-xs-12">
            <label for="codigo">Precio al Mayoreo:</label>
          </div>
          <div class="col-md-2 col-lg-2 col-xs-12">
            <div class="input-group">
              <span class="input-group-addon"><b><?=$monedaString?></b></span>
              <input type="text" class="form-control input-sm" placeholder="0.00"  name="pmayoreo" id="pmayoreo" required="required" value="<?=$item['precioMayoreo']?>">
            </div>
          </div>

          <div class="clearfix"></div><br>

          <div class="col-md-3 col-lg-2 col-xs-12">
            <label for="codigo">Cantidad para Mayoreo:</label>
          </div>
          <div class="col-md-2 col-lg-2 col-xs-12">
            <div class="input-group">
              <!-- <span class="input-group-addon"><i class="fa fa-bolt" aria-hidden="true"></i></span> -->
              <input type="text" class="form-control input-sm" placeholder="0"  name="cmayoreo" id="cmayoreo" required="required"  value="<?=$item['cantidadMayoreo']?>">
            </div>
          </div>

          <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
          <div class="clearfix"></div><br>

          <div class="col-md-3 col-lg-2 col-xs-12">
            <label for="codigo">Se vende por:</label>
          </div>
          <div class="col-md-2 col-lg-2 col-xs-12">
            <select class="form-control input-sm" name="tipoVenta">
              <?php
              foreach ($tiposVenta as $tipo) {
                $select="";
                if($tipo['id']==$item['idTipo'])
                {
                  $select="selected";
                }
                ?>
                <option  value="<?=$tipo['id']?>"  <?=$select?>><?=$tipo['nombreTipo']?></option>
                <?php
              }
              ?>
            </select>
          </div>
          <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

          <div class="clearfix"></div><br>

          <div class="col-md-3 col-lg-2 col-xs-12">
            <label for="codigo">Departamento:</label>
          </div>
          <div class="col-md-2 col-lg-2 col-xs-12">
            <select class="form-control input-sm" name="departamento">
              <?php
              foreach ($departamentos as $departamento) {
                $select="";
                if($departamento['id']==$item['idDepartamento'])
                {
                  $select="selected";
                }
                ?>
                <option value="<?=$departamento['id']?>" <?=$select?>><?=$departamento['departamento']?></option>
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
              <input type="text" class="form-control" placeholder="0"  name="stockCritico" id="stockCritico" value="<?=$item['stockCritico']?>" required="required">
            </div>
          </div>

          <div class="clearfix"></div><br>

          <div class="col-md-7 col-lg-7 col-xs-12">
            <button type="submit" class="btn btn-block btn-warning btn-lg"><i class="fa fa-pencil" aria-hidden="true"></i> Modificar Elemento</button>
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
