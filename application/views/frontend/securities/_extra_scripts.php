<script type="text/javascript">
    $(document).ready(function(){
      $('#securities,#tokens').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
        });

      $('.nav li a[href="#tab_<?=$activeTab?>"]').click();

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

    function update(id){

        var button_id = id;  // Get the ID of the button that was clicked on
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
                  //$('#data-'+button_id).val(input_value); // updates input new value
                  $("#column_key_"+button_id).html(input_value);
                  $("#row_btn_"+button_id).html('<a href="javascript:void(0);" data-id="'+button_id+'" id="edit_btn_'+button_id+'" class="edit-btn" onclick="edit('+button_id+');"><i class="fa fa-edit"></i></a>');
                  $(this).html('Update');
                  $('#message-' + button_id).html('<span class="help-block">'+response+'</span>');
              }
          });
        }
    }

    function updateToken(id){
        var button_id = id;  // Get the ID of the button that was clicked on
        var input_value = $('#dt-' + button_id).val();
          
        if(input_value==""){
          $('#message-' + button_id).removeClass("has-success").addClass('has-error');
          $('#message-' + button_id).html('<span class="help-block">Please Enter the value</span>');
        }else{
          $.ajax({ // AJAX request
               type: 'POST',
               url: '<?= BASE_URL ?>settings/updateToken',
               data: { id: button_id , value: input_value},
               beforeSend: function() {
                  $(this).html('Updating...');
               },
               success: function(response) {
                  //$('#data-'+button_id).val(input_value); // updates input new value
                  $("#column_key_"+button_id).html(input_value);
                  $("#row_btn_"+button_id).html('<a href="javascript:void(0);" data-id="'+button_id+'" id="edit_btn_'+button_id+'" class="edit-btn" onclick="edit('+button_id+');"><i class="fa fa-edit"></i></a>');
                  $(this).html('Update');
                  $('#message-' + button_id).html('<span class="help-block">'+response+'</span>');
              }
          });
        }
    }

    function cancel(id){
      var value = $("#dt-"+id).val();
      $("#column_key_"+id).html(value);
      $("#row_btn_"+id).html('<a href="javascript:void(0);" data-id="'+id+'" id="edit_btn_'+id+'" class="edit-btn" onclick="edit('+id+');"><i class="fa fa-edit"></i></a>');
    }

    function edit(id){      
      var value = $("#column_key_"+id).html();
      var name = $("#name_"+id).html();
      $("#column_key_"+id).html('<input type="text" id="dt-'+id+'" name="'+name+'" class="form-control" style="width:100%;" value="'+value+'">');
      $("#row_btn_"+id).html('<button type="button" data-id="'+id+'" class="btn large btn-success btn-flat" onclick="update('+id+');">Update</button> <button type="button" data-id="'+id+'" class="btn large btn-alert" onclick="cancel('+id+')">Cancel</button>');
    }

    function editToken(id){
      var value = $("#column_key_"+id).html();
      var name = $("#name_"+id).html();
      $("#column_key_"+id).html('<input type="text" id="dt-'+id+'" name="'+name+'" class="form-control" style="width:100%;" value="'+value+'">');
      $("#row_btn_"+id).html('<button type="button" data-id="'+id+'" class="btn large btn-success btn-flat" onclick="updateToken('+id+');">Update</button> <button type="button" data-id="'+id+'" class="btn large btn-alert" onclick="cancel('+id+')">Cancel</button>');
    }
  </script>