<script type="text/javascript">
    $(document).ready(function(){
        $('#menus').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
        });

              
        if($('input[type="radio"][name="is_module"]').is(':checked')) { 
            
            var checked_value = $("input[name='is_module']:checked").val();
            if(checked_value=='no')
                $('#module-name-box').hide();
            else
                $('#module-name-box').show();
        }

        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass   : 'iradio_flat-green'
        });

        $('input[type="radio"][name="is_module"]').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass   : 'iradio_flat-green'
        }).on('ifChanged', function(e) {
            if(e.target.value=='yes'){
                $('#module-name-box').show();
            }else{
                 $('#module-name-box').hide();
            }
        });
    });
  </script>`