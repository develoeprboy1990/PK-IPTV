<script type="text/javascript">
    $(document).ready(function(){
      $('.btn-success').click(function() { // onclick handler to each of the buttons

          var button_id = $(this).attr("data-id");  // Get the ID of the button that was clicked on
          var input_value = $('#dt-' + button_id).val();
          
          if(input_value==""){
            $('#message-' + button_id).removeClass("has-success").addClass('has-error');
            $('#message-' + button_id).html('<span class="help-block">Please Enter the value</span>');
          }else{
            $.ajax({ // AJAX request
                 type: 'POST',
                 url: '<?= BASE_URL ?>settings/update',
                 data: { id: button_id , value: input_value},
                 beforeSend: function() {
                    $(this).html('Updating...');
                 },
                 success: function(response) {
                    $('#data-'+button_id).val(input_value); // updates input new value
                    $(this).html('Update');
                    $('#message-' + button_id).html('<span class="help-block">'+response+'</span>');
                }
            });
          }
        });
    });  
  </script>