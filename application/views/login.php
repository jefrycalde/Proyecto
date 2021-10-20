<link rel="stylesheet" href="<?php echo base_url(); ?>css/login.css"/>
<br/>
<!-- ******************************** -->
<?php
if($error!="")
{
  ?>
  <div class="container">
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;&nbsp;</button>
      <strong>Error de Acceso.</strong> <?= $error?>, por favor verifique los datos e intente de nuevo.
    </div>
  </div>
  <?php
}
?>
<!-- ******************************** -->
<br/>

<div class="container">
  <div class="row">
    <div class="col-sm-6 col-md-4 col-md-offset-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>Ingrese sus datos de acceso</strong>
        </div>
        <div class="panel-body">


          <form class="form" method="post" action="<?= base_url()?>login" id="mylogin">


            <fieldset>
              <div class="row">
                <div class="center-block">
                  <?php
                  $logo=$this->consultas->configLogo();
                  ?>
                  <div class="col-sm-10 col-md-10  col-md-offset-1 col-sm-offset-1 ">
                    <img class="img-responsive" src="data:image/jpeg;base64,<?=base64_encode( $logo )?>" alt="">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-user" aria-hidden="true"></i>
                      </span>
                      <input class="form-control" placeholder="Usuario" name="usuario" type="text" autofocus>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-key" aria-hidden="true"></i>
                      </span>
                      <input class="form-control" placeholder="Contraseña" name="pass" type="password" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <input type="submit" class="btn btn-lg btn-primary btn-block"  value="Acceder">
                  </div>
                </div>
              </div>
            </fieldset>
          </form>
        </div>
        <div class="panel-footer ">
          ¿No tiene una cuenta? Contacte al administrador.
        </div>
      </div>
    </div>
  </div>
</div>
