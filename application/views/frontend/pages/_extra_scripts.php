<style>
.export-icon{font-size: 24px; margin: 2px;}
.csv, .pdf{color: red}
.excel{color: green}
</style>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<!-- CK Editor -->
<script src="<?=DEFAULT_ASSETS?>bower_components/ckeditor/ckeditor.js"></script>
<script src="<?=DEFAULT_ASSETS?>jquery.validate.min.js"></script>

<script type="text/javascript">

  $(document).ready(function(){
  	
       var datatable;
	   datatable = $('#page_templates').DataTable({ 
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        'lengthMenu': [ 10, 20, 50, 100 ],
      });
 CKEDITOR.replace('email-message-body');
 
});
</script>