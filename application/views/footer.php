
<!-- </div> -->
<!-- Fin del container del header -->
<script language="javascript">
var base_url = '<?php echo base_url(); ?>';
</script>

<!-- JS SECTION-->
<script src="<?php echo base_url(); ?>js/jquery-2.1.3.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-switch.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.formatCurrency-1.4.0.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.uitablefilter.js"></script>
<script src="<?php echo base_url(); ?>js/modals.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.numeric.min.js"></script>



<!-- DataTable -->
<script src="<?= base_url()?>plugins/datatables.min.js"></script>
<script src="<?= base_url()?>plugins/Buttons-1.2.2/js/buttons.bootstrap.min.js"></script>
<script src="<?= base_url()?>plugins/Buttons-1.2.2/js/buttons.colVis.min.js"></script>

<!-- select2 -->
<script src="<?= base_url()?>plugins/select2/select2.min.js"></script>

<!-- AdminLTE -->
<script src="<?= base_url()?>js/AdminLTE.min.js"></script>

<!-- formato de numeros -->
<script src="<?= base_url()?>js/formatNumber.js"></script>

<!-- SlimScroll -->
<!-- <script src="<?= base_url()?>js/jquery.slimscroll.min.js"></script> -->

<!-- scrips del sitio -->
<?=$scripts?>

<!-- Usuarios -->
<?php
if (strpos(current_url(), "usuarios") !== false) {
  ?>
  <script src="<?php echo base_url(); ?>js/usuarios.js"></script>
  <?php
}
?>




</body>

</html>
