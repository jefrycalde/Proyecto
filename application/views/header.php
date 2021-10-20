<!DOCTYPE html>
<html>
<head>

    <title>Servicios calderon | <?=$titulo?></title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $logo=$this->consultas->configLogo();
     ?>
     <!-- <img src="data:image/jpeg;base64,<?=base64_encode( $logo )?>" class="user-image"/> -->
    <link type="image/x-icon" href="data:image/jpeg;base64,<?=base64_encode( $logo )?>" rel="icon"/>

    <link rel="stylesheet" href="<?= base_url(); ?>css/font-awesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>css/bootstrap-switch.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>css/jquery-ui.min.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>css/hover.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>css/multi-select.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/select2/select2.min.css"/>

    <!-- datatables -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables.min.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/Buttons-1.2.2/css/buttons.bootstrap.min.css"/>

    <link rel="stylesheet" href="<?= base_url(); ?>css/style.css"/>
</head>

<body>


  <!-- Modal de Alerta -->
  <div class="modal fade " id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="setBody">
        <div class="modal-header">
          <h4 class="modal-title" id="tituloModal"></h4>
        </div>
        <div class="modal-body" id="contenidoModal">
        </div>
        <div class="modal-footer" id="pieModal">
        </div>

      </div>
    </div>
  </div>



  <!-- Modal de Alerta mini-->
  <div class="modal fade " id="ModalMini" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header modal-header-mini">
          <h4 class="modal-title modal-title-mini" id="tituloModalMini"></h4>
        </div>
        <div class="modal-body modal-body-mini" id="contenidoModalMini">
        </div>
        <div class="modal-footer modal-footer-mini" id="pieModalMini">
        </div>

      </div>
    </div>
  </div>





  <!-- Modal de Alerta XL-->
  <div class="modal fade " id="ModalLG" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header modal-header-lg">
          <h4 class="modal-title" id="tituloModalLG"></h4>
        </div>
        <div class="modal-body modal-body-lg" id="contenidoModalLG">
        </div>
        <div class="modal-footer modal-footer-lg" id="pieModalLG">
        </div>

      </div>
    </div>
  </div>
<!-- <div class="container-fluid"> -->
