<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="<?=DEFAULT_ASSETS?>plugins/timepicker/bootstrap-timepicker.min.css">
<!-- bootstrap time picker -->
<script src="<?=DEFAULT_ASSETS?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
      $('#playlists,#playlist_content_items,#playlist_items').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,
          'pageLength'  : 25
        });

      //Timepicker
      $('.timepicker').timepicker({
        showInputs: false
      });

      $('.nav li a[href="#tab_<?=$active_tab?>"]').click();

    }); 

    function cancel(id){
      var value = $("#dt-"+id).val();
      $("#column_position_"+id).html(value);
      $("#row_btn_"+id).html('<a href="javascript:void(0);" data-id="'+id+'" id="edit_btn_'+id+'" class="edit-btn" onclick="editPlaylistItem('+id+');"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" data-id="'+id+'" onclick="deletePlaylistItem('+id+')"><i class="fa fa-trash"></i></a>');
    }

    function editPlaylistItem(id){
      var value = $("#column_position_"+id).html();
      $("#column_position_"+id).html('<input type="text" id="dt-'+id+'" class="form-control" style="width:100%;" value="'+value+'">');
      $("#row_btn_"+id).html('<button type="button" data-id="'+id+'" class="btn large btn-success btn-flat" onclick="updatePlaylistItem('+id+');">Update</button> <button type="button" data-id="'+id+'" class="btn large btn-alert" onclick="cancel('+id+')">Cancel</button>');
    }

    function updatePlaylistItem(id){

        var button_id = id;  // Get the ID of the button that was clicked on
        var input_value = $('#dt-' + button_id).val();
          
        if(input_value==""){
          $('#message-' + button_id).removeClass("has-success").addClass('has-error');
          $('#message-' + button_id).html('<span class="help-block">Please Enter the value</span>');
        }else{
          $.ajax({ // AJAX request
               type: 'POST',
               url: '<?= BASE_URL ?>playlists/updateItem',
               data: { id: button_id , value: input_value},
               beforeSend: function() {
                  $(this).html('Updating...');
               },
               success: function(response) {
                  //$('#data-'+button_id).val(input_value); // updates input new value
                  $("#column_position_"+button_id).html(input_value);
                  $("#row_btn_"+button_id).html('<a href="javascript:void(0);" data-id="'+button_id+'" id="edit_btn_'+button_id+'" class="edit-btn" onclick="editPlaylistItem('+button_id+');"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" data-id="'+button_id+'" onclick="deletePlaylistItem('+button_id+')"><i class="fa fa-trash"></i></a>');
                  $(this).html('Update');
                  $('#message-' + button_id).html('<span class="help-block">'+response+'</span>');
              }
          });
        }
    }

    function deletePlaylistItem(id){
        var x = confirm("Are you sure you want to delete this Playlist Item?");
        if(x == true) {
          $.ajax({ // AJAX request
             type: 'POST',
             url: '<?= BASE_URL ?>playlists/deleteItem',
             data: { id: id},
             beforeSend: function() {
                $(this).html('Updating...');
             },
             success: function(response) {
                $("#row_"+id).hide('slow');
            }
        });
      }
    }

    function editContentItem(id){
      var name = $("#column_name_"+id).html();
      var length = $("#column_length_"+id).html();
      var url = $("#column_url_"+id).html();

      $("#column_name_"+id).html('<input type="text" id="name-'+id+'" class="form-control" style="width:100%;" value="'+name+'">');
      $("#column_length_"+id).html('<input type="text" id="length-'+id+'" class="form-control" style="width:100%;" value="'+length+'">');
      $("#column_url_"+id).html('<input type="text" id="url-'+id+'" class="form-control" style="width:100%;" value="'+url+'">');
      $("#row_btn_"+id).html('<button type="button" data-id="'+id+'" class="btn large btn-success btn-flat" onclick="updateContentItem('+id+');">Update</button> <button type="button" data-id="'+id+'" class="btn large btn-alert" onclick="cancelUpdateContent('+id+')">Cancel</button>');
    }
    
    function updateContentItem(id){

        var button_id = id;  // Get the ID of the button that was clicked on
        var name = $('#name-' + button_id).val();
        var length = $('#length-' + button_id).val();
        var url = $('#url-' + button_id).val();
        $.ajax({ // AJAX request
             type: 'POST',
             url: '<?= BASE_URL ?>playlists/updateContentItem',
             data: { id: button_id , name: name, length:length , url:url },
             beforeSend: function() {
                $(this).html('Updating...');
             },
             success: function(response) {
                 $("#column_name_"+id).html(name);
                 $("#column_length_"+id).html(length);
                 $("#column_url_"+id).html(url);
                 $("#row_btn_"+id).html('<a href="javascript:void(0);" onclick="editContentItem('+id+')"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" onclick="deleteContentItem('+id+')"><i class="fa fa-trash"></i></a>');
            }
        });
    }

    function deleteContentItem(id){
        var x = confirm("Are you sure you want to delete this Playlist Content Item and all Playlist items associated with this?");
        if(x == true) {
          $.ajax({ // AJAX request
             type: 'POST',
             url: '<?= BASE_URL ?>playlists/deleteContentItem',
             data: { id: id},
             beforeSend: function() {
                $(this).html('Updating...');
             },
             success: function(response) {
                $("#row_"+id).hide('slow');
            }
        });
      }
    }

    function cancelUpdateContent(id){
      var name = $("#name-"+id).val();
      var length = $("#length-"+id).val();
      var url = $("#url-"+id).val();
      $("#column_name_"+id).html(name);
      $("#column_length_"+id).html(length);
      $("#column_url_"+id).html(url);

      $("#row_btn_"+id).html('<a href="javascript:void(0);" onclick="editContentItem('+id+')"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" onclick="deleteContentItem('+id+')"><i class="fa fa-trash"></i></a>');
    }


</script>