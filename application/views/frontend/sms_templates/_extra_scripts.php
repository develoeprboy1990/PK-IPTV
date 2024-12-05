<!-- CK Editor -->
<script src="<?=DEFAULT_ASSETS?>bower_components/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#sms_templates').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
        });
        
        CKEDITOR.replace('sms-message-body');
    });
  </script>