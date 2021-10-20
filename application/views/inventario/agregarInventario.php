






<!-- ******************************************************************************************************************* -->
<!-- ******************************************************************************************************************* -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Inventario
      <small>Agregar Inventario</small>
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
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Agregar inventario</h3>
        </div>
        <div class="box-body">
          <form id="addItem" autocomplete="off">
            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Código del producto:</label>
            </div>

            <div class="col-md-4 col-lg-4 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="Código" autofocus="" maxlength="13" name="codigo" id="codigoAdd">
              </div>
            </div>

            <div class="clearfix"></div><br>

            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Descripción:</label>
            </div>
            <div class="col-md-4 col-lg-4 col-xs-12">
              <div id="descripcion">
                <label>---</label>
              </div>
            </div>

            <div class="clearfix"></div><br>

            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Cantidad Actual:</label>
            </div>
            <div class="col-md-4 col-lg-4 col-xs-12">
              <div id="cantidadActual">
                <label >0.00</label>
              </div>
            </div>

            <!-- <div class="clearfix"></div><br>

            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Precio Actual:</label>
            </div>
            <div class="col-md-2 col-lg-2 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-plus" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="0.00" maxlength="13" name="cantidad" id="cantidad">
              </div>
            </div> -->

            <div class="clearfix"></div><br>

            <div class="col-md-3 col-lg-2 col-xs-12">
              <label for="codigo">Cantidad a Agregar:</label>
            </div>

            <div class="col-md-2 col-lg-2 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-plus" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="0.00" maxlength="13" name="cantidad" id="cantidad">
              </div>
            </div>

            <div class="clearfix"></div><br>

            <div class="col-md-7 col-lg-7 col-xs-12">
              <button type="submit" class="btn btn-block btn-success btn-lg">Agregar al Inventario</button>
            </div>
          </form>
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
