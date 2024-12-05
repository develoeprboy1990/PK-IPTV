<!-- CK Editor -->
<script src="<?=DEFAULT_ASSETS?>bower_components/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#news').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
        });
        
        CKEDITOR.replace('news_descriptionx');
    });
  </script>