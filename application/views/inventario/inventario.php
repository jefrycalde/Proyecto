<!-- ******************************************************************************************************************* -->
<!-- ******************************************************************************************************************* -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Inventario
      <small>Vista General</small>
    </h1>
    <!-- <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
    <li class="active">Here</li>
  </ol> -->
</section>

<!-- Main content -->
<section class="content">
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="box box-danger collapsed-box">

        <div class="box-header">
          <h3 class="box-title">Lista de Productos en Stock Crítico</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="col-lg-12 col-xs-12">
            <!-- ñññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññ           -->
            <div class="table-responsive">
              <!-- <table cellspacing="0" cellpadding="0" id="tbInventario" class="table table-striped table-bordered table-hover table-condensed"> -->
              <table id="tbInventarioCritico" class="table table-striped table-bordered dt-responsive table-hover table-condensed" cellspacing="0" width="100%" style="background: white!important">
                <thead>
                  <tr>
                    <th class="bg-primary"><span>Codigo</span></th>
                    <th class="bg-primary"><span>Descripcion</span></th>
                    <th class="bg-primary"><span>Costo</span></th>
                    <th class="bg-primary"><span>Precio</span></th>
                    <th class="bg-primary"><span>Precio<br>Mayoreo</span></th>
                    <th class="bg-primary"><span>Cantidad<br>Mayoreo</span></th>
                    <th class="bg-primary"><span>Departamento</span></th>
                    <th class="bg-primary"><span>Stock</span></th>
                    <th class="bg-primary"><span>Tipo<br>venta</span></th>
                    <th class="bg-primary"><span>Proveedor</span></th>
                    <th class="bg-primary"><span>Stock<br>crítico</span></th>
       
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($inventario as $item) {
                    $classStock = "";
                    if($item['cantidad']<=$item['stockCritico']){
                      $classStock = "bg-red";
                    }
                    else{
                      continue;
                    }
                    ?>
                    <tr data-id="<?=$item['id']?>" class="<?=$classStock?>">
                      <td class="text-center">
                        <?php
                        if($this->session->userdata('rol')==1){
                          ?>
                          <a href="<?=base_url()?>modificar/m/<?=$item['codigo']?>">
                            <?=$item['codigo']?>
                          </a>
                          <?php
                        }
                        else{
                          echo $item['codigo'];
                        }
                        ?>
                      </td>
                      <td><?=$item['descripcion']?></td>
                      <td class="text-center"><nobr><?=$monedaString?> <?=number_format($item['costo'],2)?></nobr></td>
                      <td class="text-center"><nobr><?=$monedaString?> <?=number_format($item['precio'],2)?></td>
                        <td class="text-center"><nobr><?=$monedaString?> <?=number_format($item['precioMayoreo'],2)?></td>
                          <td class="text-center"><?=$item['cantidadMayoreo']?></td>
                          <td class="text-center"><?=$item['departamento']?></td>
                          <td class="text-center">
                            <?php
                            if($this->session->userdata('rol')==1){
                              ?>
                              <a href="#" class="miStock" data-id="<?=$item['id']?>">
                                <?=$item['cantidad']?>
                              </a>
                              <?php
                            }
                            else{
                              echo $item['cantidad'];
                            }
                            ?>
                          </td>
                          <td class=""><?=$item['nombreTipo']?></td>
                          <td class=""><?=$item['proveedor']?></td>
                          <td class="text-center"><?=$item['stockCritico']?></td>
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
          <div class="box box-success">

            <div class="box-header">
              <h3 class="box-title">Lista de Productos en General</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="col-lg-12 col-xs-12">
                <!-- ñññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññ           -->
                <div class="table-responsive">
                  <!-- <table cellspacing="0" cellpadding="0" id="tbInventario" class="table table-striped table-bordered table-hover table-condensed"> -->
                  <table id="tbInventario" class="table table-striped table-bordered dt-responsive table-hover table-condensed" cellspacing="0" width="100%" style="background: white!important">
                    <thead>
                      <tr>
                        <th class="bg-primary"><span>Codigo</span></th>
                        <th class="bg-primary"><span>Descripcion</span></th>
                        <th class="bg-primary"><span>Costo</span></th>
                        <th class="bg-primary"><span>Precio</span></th>
                        <th class="bg-primary"><span>Precio<br>Mayoreo</span></th>
                        <th class="bg-primary"><span>Cantidad<br>Mayoreo</span></th>
                        <th class="bg-primary"><span>Departamento</span></th>
                        <th class="bg-primary"><span>Stock</span></th>
                        <th class="bg-primary"><span>Tipo<br>venta</span></th>
                        <th class="bg-primary"><span>Proveedor</span></th>
                        <th class="bg-primary"><span>Stock<br>minimo</span></th>
                        <th class="bg-primary"><span>accion</span></th>
                        <
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($inventario as $item) {
                        $classStock = "";
                        if($item['cantidad']<=$item['stockCritico']){
                          $classStock = "bg-red";
                        }
                        ?>
                        <tr data-id="<?=$item['id']?>" class="<?=$classStock?>">
                          <td class="text-center">
                            <?php
                            if($this->session->userdata('rol')==1){
                              ?>
                          
                                <?=$item['codigo']?>
                              </a>
                              <?php
                            }
                            else{
                              echo $item['codigo'];
                            }
                            ?>
                          </td>
                          <td><?=$item['descripcion']?></td>
                          <td class="text-center"><nobr><?=$monedaString?> <?=number_format($item['costo'],2)?></nobr></td>
                          <td class="text-center"><nobr><?=$monedaString?> <?=number_format($item['precio'],2)?></td>
                            <td class="text-center"><nobr><?=$monedaString?> <?=number_format($item['precioMayoreo'],2)?></td>
                              <td class="text-center"><?=$item['cantidadMayoreo']?></td>
                              <td class="text-center"><?=$item['departamento']?></td>
                              <td class="text-center">
                                <?php
                                if($this->session->userdata('rol')==1){
                                  ?>
                                  <a href="#" class="miStock" data-id="<?=$item['id']?>">
                                    <?=$item['cantidad']?>
                                  </a>
                                  <?php
                                }
                                else{
                                  echo $item['cantidad'];
                                }
                                ?>
                              </td>
                              <td class=""><?=$item['nombreTipo']?></td>
                              <td class=""><?=$item['proveedor']?></td>
                              <td class="text-center"><?=$item['stockCritico']?></td>
                              ?>
                            
                          <td class="text-center">

                            <?php
                            if($this->session->userdata('rol')==1){
                              ?>
                               <a href="<?=base_url()?>modificar/m/<?=$item['codigo']?>" class="btn btn-primary btn-xs editaru" title="Editar" data-idu="<?=$item['codigo']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                               <a href="#" class="btn btn-danger btn-xs delp" title="Eliminar" data-idp="<?=$item['id']?>"><i class="fa fa-trash" aria-hidden="true"></i></a>

                              </a>
                              <?php
                            }
                            else{
                              echo $item['codigo'];
                            }
                            
                            ?>
                              </td>

                              </tr>
                  
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    <!-- ñññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññññ           -->
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
