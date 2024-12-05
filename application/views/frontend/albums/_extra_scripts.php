<script type="text/javascript">
    $(document).ready(function(){
        $('#songs,#albums').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,
          'lengthMenu': [ 50, 100, 200, 500 ]        
        });

        $('.nav li a[href="#tab_<?=$activeTab?>"]').click();

        $('#date_start').datepicker({
           format: "yyyy-mm-dd", 
           autoclose: true
        })

        $('#date_end').datepicker({
           format: "yyyy-mm-dd", 
           autoclose: true
        })
    });
  </script>`