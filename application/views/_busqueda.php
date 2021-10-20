<table id="tbBuscar" class="table table-striped table-bordered dt-responsive table-hover table-condensed" cellspacing="0" width="100%" style="background: white!important">
  <thead>
    <tr>
      <th class="bg-primary"><span>Codigos</span></th>
      <th class="bg-primary"><span>Descripcion</span></th>
      <th class="bg-primary"><span>Precio</span></th>
      <th class="bg-primary"><span>Stock</span></th>
      <th class="bg-primary"><span>Agregar</span></th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($inventario as $item) {
      ?>
      <tr data-id="<?=$item['id']?>">
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
        <td class="text-center"><nobr><?=$monedaString?> <?=number_format($item['precio'],2)?></td>
        <td class="text-center"><nobr><?=$item['cantidad']?></td>
        <td class="text-center"><button class="btn btn-sm btn-success addCar" data-code="<?=$item['codigo']?>"><i class="fa fa-cart-plus fa-lg"></i></button></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
