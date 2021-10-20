
<!-- Theme style -->
<link rel="stylesheet" href="<?=base_url()?>css/AdminLTE.min.css">
<!-- AdminLTE Skins. We have chosen the skin-blue for this starter
page. However, you can choose any other skin. Make sure you
apply the skin class to the body tag so the changes take effect.
-->
<!-- <link rel="stylesheet" href="<?=base_url()?>css/skins/skin-blue.min.css"> -->
<link rel="stylesheet" href="<?=base_url()?>css/skins/_all-skins.min.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- </head> -->
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
-->
<body class="hold-transition <?=$tema?>  sidebar-mini " id="mymain">
  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
      <a href="<?= base_url()?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>Selcal</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Multiservicios calderon</b></span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
           
            </select></li>
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="nolink">
                <!-- The user image in the navbar-->
                <?php
                $logo=$this->consultas->configLogo();
                $nombreEmpresa=$this->consultas->configNombreEmpresa();
                $nombreEmpresa = htmlspecialchars(addslashes(stripslashes(strip_tags(trim($nombreEmpresa)))));
                ?>
                <!-- <img src="data:image/jpeg;base64,<?=base64_encode( $logo )?>" class="user-image"/> -->
                <!-- <img src="<?= base_url()?>img/logo.png" class="user-image" alt="User Image"> -->
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <?=$usuario['nombre']?>
              </a>
            </li>
            <!-- Boton se matar session -->
            <li>
              <a href="<?= base_url()?>principal/logout" title="Salir"><i class="fa fa-power-off" aria-hidden="true"></i><span class="hidden-xs"> Salir</span></a>
            </li>

          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="data:image/jpeg;base64,<?=base64_encode( $logo )?>" class="user-image"/>
            <!-- <img src="<?= base_url()?>img/logo.png" class="img-circle" alt="User Image"> -->
          </div>
          <div class="pull-left info">
            <p class="nombre"><?=$nombreEmpresa?></p>
            <!-- Status -->
            <a href="#"><i class="fa fa-circle text-success"></i> <?=$usuario['rol']?></a>
          </div>
        </div>


        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
          <?php
          if($this->session->userdata('rol')=="1" || $this->session->userdata('rol')=="3"){
            ?>
            <li class="header">Navegación</li>
            <!-- ************************************************************************************************ -->
            <!--    ************************************************************************************************ -->
            <!-- ************************************************************************************************ -->
            <li class="treeview">
              <a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Vender</span>
                <span class="pull-right-container">
                  <i class="fa fa-caret-down pull-right" aria-hidden="true"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class=""><a href="<?=base_url()?>pventa"><i class="fa fa-cart-plus" aria-hidden="true"></i>Nueva Venta</a></li>
              </ul>
            </li>
            <!-- ************************************************************************************************ -->
            <!--    ************************************************************************************************ -->
            <!-- ************************************************************************************************ -->
            <li class="treeview <?=$classInventario?>">
              <a href="#"><i class="fa fa-book" aria-hidden="true"></i> <span>Inventario</span>
                <span class="pull-right-container">
                  <i class="fa fa-caret-down pull-right" aria-hidden="true"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="<?=$classInventarioGeneral?>"><a href="<?=base_url()?>inventario"><i class="fa fa-eye" aria-hidden="true"></i>Vista General</a></li>
                
                <?php
                if($this->session->userdata('rol')=="1")
                {
                  if($classInventarioModificar=="active")
                  {
                    ?>

                    <?php
                  }
                  ?>
                  <li class="<?=$classInventarioNuevo?>"><a href="<?=base_url()?>nuevoProducto"><i class="fa fa-cubes" aria-hidden="true"></i>Nuevo Producto</a></li>
                  <li class="<?=$classInventarioModificar?>"><a href="<?=base_url()?>agregarInventario" class="fa fa"><i class="fa fa-pencil" aria-hidden="true"></i>agregarInventario</a></li>

                 <?php
                }
                ?>
              </ul>
            </li>
            <!-- ************************************************************************************************ -->
            <!--    ************************************************************************************************ -->
            <!-- ************************************************************************************************ -->

    <?php
    if($this->session->userdata('rol')=="1")
    {
      ?>
      <li class="<?=$classUsuarios?>"><a href="<?=base_url()?>usuarios"><i class="fa fa-users" aria-hidden="true"></i> <span>Usuarios</span></a></li>
      <li class="<?=$classProveedores?>"><a href="<?=base_url()?>proveedores"><i class="fa fa-user-secret" aria-hidden="true"></i> <span>Proveedores</span></a></li>
      <li class="<?=$classClientes?>"><a href="<?=base_url()?>clientes"><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i> <span>Clientes</span></a></li>
      <?php
    }
    ?>
    <li class="<?=$classVentas?>"><a href="<?=base_url()?>ventas"><i class="fa fa-money" aria-hidden="true"></i> <span>Ventas</span></a></li>

    <?php
    if($this->session->userdata('rol')=="1")
    {
      ?>

      <li class="treeview">
       
      <?php
    }
  }
  ?>

  <?php
  if($this->session->userdata('rol')=="2"){
    ?>
    <li class="header"><!-- Herramientas --></li>
    <li id="libuscar"><a href="#" id="buscarpr" ><i class="fa fa-binoculars"  aria-hidden="true"></i> <span>Buscar [ F3 ]</span></a></li>
    <li><a href="<?=base_url()?>"><i class="fa fa-cart-plus" aria-hidden="true"></i> <span>Nueva Venta</span></a></li>
    <!--  -->

    <!--  -->
    <!--  -->
    <?php
  }
  ?>
</ul>
<!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
</aside>
