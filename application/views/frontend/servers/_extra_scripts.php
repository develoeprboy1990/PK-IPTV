<script type="text/javascript">
    $(document).ready(function(){
        $('#locations,#items').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
        });

        $('.nav li a[href="#tab_<?=$activeTab?>"]').click();
    
    });

    function edit(id){
      var name = $("#server_"+id + " a").html();
      $("#server_"+id).html('<input type="text" id="name-'+id+'" class="form-control" style="width:100%;" value="'+name+'">');
      $("#btn_"+id).html('<button type="button" data-id="'+id+'" class="btn large btn-success btn-flat" onclick="update('+id+');">Update</button> <button type="button" data-id="'+id+'" class="btn large btn-alert" onclick="cancel('+id+')">Cancel</button>');
    }

    function update(id){
        var name = $('#name-' + id).val();
        $.ajax({ // AJAX request
             type: 'POST',
             url: '<?= BASE_URL ?>servers/update',
             data: { id: id , name: name},
             beforeSend: function() {
                $(this).html('Updating...');
             },
             success: function(response) {
                 $("#server_"+id).html('<a href="<?= BASE_URL ?>servers/items/'+id+ '">'+name+'</a>');
                 $("#btn_"+id).html('<a href="javascript:void(0);" onclick="edit('+id+')"><i class="fa fa-edit"></i></a>');
            }
        });
    }

    function cancel(id){
      var name = $("#name-"+id).val();
      $("#server_"+id).html('<a href="<?= BASE_URL ?>servers/items/'+id+ '">'+name+'</a>');
      $("#btn_"+id).html('<a href="javascript:void(0);" onclick="edit('+id+')"><i class="fa fa-edit"></i></a>');
    }

    function editItem(id){
      var url = $("#url_"+id).html();
      $("#url_"+id).html('<input type="text" id="url-'+id+'" class="form-control" style="width:100%;" value="'+url+'">');
      $("#btn_"+id).html('<button type="button" data-id="'+id+'" class="btn large btn-success btn-flat" onclick="updateItem('+id+');">Update</button> <button type="button" data-id="'+id+'" class="btn large btn-alert" onclick="cancelItem('+id+')">Cancel</button>');
    }

    function updateItem(id){
        var url = $('#url-' + id).val();
        $.ajax({ // AJAX request
             type: 'POST',
             url: '<?= BASE_URL ?>servers/updateItem',
             data: { id: id , url: url},
             beforeSend: function() {
                $(this).html('Updating...');
             },
             success: function(response) {
                 $("#url_"+id).html(url);
                 $("#btn_"+id).html('<a href="javascript:void(0);" onclick="editItem('+id+')"><i class="fa fa-edit"></i></a>');
            }
        });
    }

    function cancelItem(id){
      var url = $("#url-"+id).val();
      $("#url_"+id).html(url);
      $("#btn_"+id).html('<a href="javascript:void(0);" onclick="editItem('+id+')"><i class="fa fa-edit"></i></a>');
    }

  </script>