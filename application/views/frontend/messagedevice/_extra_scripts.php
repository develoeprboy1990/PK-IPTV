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

       // $('.nav li a[href="#tab_<?=$activeTab?>"]').click();

         var dateFormat = "yy-mm-dd",
      from = $( "#start_date" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: false,
          numberOfMonths: 1,
		  dateFormat:"yy-mm-dd"
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#end_date" ).datepicker({
        defaultDate: "+1w",
        changeMonth: false,
        numberOfMonths: 1,
		dateFormat:"yy-mm-dd"
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
	
    });
  </script>`