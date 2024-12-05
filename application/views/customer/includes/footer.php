<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2019 <a href="https://ums.com"><?= $site_name; ?></a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?= DEFAULT_ASSETS ?>bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?= DEFAULT_ASSETS ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- DataTables -->
<script src="<?= DEFAULT_ASSETS ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= DEFAULT_ASSETS ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- SweetAlert js -->
<script src="<?= DEFAULT_ASSETS ?>dist/js/sweetalert.min.js"></script>
<!-- SlimScroll -->
<script src="<?= DEFAULT_ASSETS ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= DEFAULT_ASSETS ?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= DEFAULT_ASSETS ?>dist/js/adminlte.min.js"></script>
<!-- Bootstrap Toggle CDN -->
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!-- Dropify Plugin -->
<script src="<?= DEFAULT_ASSETS ?>dist/js/dropify.js"></script>

<!-- Datepicker -->
<script src="<?= DEFAULT_ASSETS ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= DEFAULT_ASSETS ?>dist/js/demo.js"></script>
<script src="<?= DEFAULT_ASSETS ?>dist/js/multiselect.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?= DEFAULT_ASSETS ?>plugins/iCheck/icheck.min.js"></script>

<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable();
  })
</script>
<?php isset($_extra_scripts) ? $this->load->view($_extra_scripts) : ''; ?>

</body>
</html>
