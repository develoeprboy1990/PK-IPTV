<script type="text/javascript">
    $(document).ready(function(){

    $('.chkrow').change(function() {
      var parent=$(this).attr("data-id");
      $('.child-'+parent).prop('checked', $(this).is(':checked'));
      $(this).parent().siblings().children('input:checkbox').prop('checked', $(this).is(':checked'));
    });

    });
  </script>