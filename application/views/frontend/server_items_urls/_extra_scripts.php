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
    
    });

    function editItem(server_id,item_id){
      var name = $("#column-name-"+server_id+"-"+item_id).html();
      var url = $("#column-url-"+server_id+"-"+item_id).html();
      $("#column-name-"+server_id+"-"+item_id).html('<input type="text" id="name-'+server_id+"-"+item_id+'" class="form-control" style="width:100%;" value="'+name+'">');
      $("#column-url-"+server_id+"-"+item_id).html('<input type="text" id="url-'+server_id+"-"+item_id+'" class="form-control" style="width:100%;" value="'+url+'">');
      $("#btn-"+server_id+"-"+item_id).html('<button type="button" data-id="'+item_id+'" class="btn large btn-success btn-flat" onclick="updateItem('+server_id +','+item_id+');">Update</button> <button type="button" data-id="'+item_id+'" class="btn large btn-alert" onclick="cancelUpdate('+server_id +','+item_id+')">Cancel</button>');
    }

    function updateItem(server_id,id){
        var name = $('#name-'+server_id+'-'+ id).val();
        var url = $('#url-'+server_id+'-'+ id).val();
        $.ajax({ // AJAX request
             type: 'POST',
             url: '<?= BASE_URL ?>server_items_urls/updateItem',
             data: { id: id , name: name, url: url},
             beforeSend: function() {
                $(this).html('Updating...');
             },
             success: function(response) {
                 $("#column-name-"+server_id+'-'+id).html(name);
                 $("#column-url-"+server_id+'-'+id).html(url);
                 $("#btn-"+server_id+'-'+id).html('<a href="javascript:void(0);" onclick="editItem('+server_id+','+id+')"><i class="fa fa-edit"></i> <a href="javascript:void(0);" onclick="deleteItem('+server_id+','+id+')"><i class="fa fa-trash"></i></a>');
            }
        });
    }

    function addItem(id){
      var table = document.getElementById("table-"+id);
      
      //get latest row's id of table 
      var latest_row_id = $('#table-'+id+' tr:last').attr('id');
      if(latest_row_id!=undefined){
        var str_array = latest_row_id.split('-');
        var latest_item_id=str_array[2];
        var item_id=parseInt(latest_item_id)+1;
      }else{
        var item_id=1;
      }
      var row = table.insertRow(-1);
      row.id = 'row-'+id+'-'+item_id;
      var cell1 = row.insertCell(0);
      cell1.id = 'column-name-'+id+'-'+item_id;
      var cell2 = row.insertCell(1);
      cell2.id = 'column-url-'+id+'-'+item_id;
      var cell3 = row.insertCell(2);
      cell3.id = 'btn-'+id+'-'+item_id;
      cell1.innerHTML = '<input type="text" id="name-'+id+'-'+item_id+'" name="name" value="" class="form-control">';
      cell2.innerHTML = '<input type="text" id="url-'+id+'-'+item_id+'" name="url" value="" class="form-control">';
      cell3.innerHTML = '<button type="button" data-id="'+item_id+'" class="btn large btn-success btn-flat" onclick="add('+id+','+item_id+');">Add</button> <button type="button" data-id="'+item_id+'" class="btn large btn-alert" onclick="cancelAdd('+id+','+item_id+')">Cancel</button>';
    }

    function add(id, item_id){
        var name = $('#name-'+id+'-'+ item_id).val();
        var url = $('#url-'+id+'-'+ item_id).val();
        $.ajax({ // AJAX request
             type: 'POST',
             url: '<?= BASE_URL ?>server_items_urls/addItem',
             data: { id: id , name: name, url: url},
             beforeSend: function() {
                $(this).html('Updating...');
             },
             success: function(response) {
                 $("#column-name-"+id+'-'+item_id).html(name);
                 $("#column-url-"+id+'-'+item_id).html(url);
                 $("#btn-"+id+'-'+item_id).html('<a href="javascript:void(0);" onclick="editItem('+id+','+item_id+')"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" onclick="deleteItem('+id+','+item_id+')"><i class="fa fa-trash"></i></a>');
            }
        });
    }

    function cancelUpdate(server_id,id){
      var name = $('#name-'+server_id+'-'+ id).val();
      var url = $('#url-'+server_id+'-'+ id).val();
      $("#column-name-"+server_id+'-'+id).html(name);
      $("#column-url-"+server_id+'-'+id).html(url);
      $("#btn-"+server_id+'-'+id).html('<a href="javascript:void(0);" onclick="editItem('+server_id+','+id+')"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" onclick="deleteItem('+server_id+','+id+')"><i class="fa fa-trash"></i></a>');
    }

    function cancelAdd(id,item_id){
      $("#row-"+id+'-'+item_id).remove();
    }

     function deleteItem(server_id,id){
       
        $.ajax({ // AJAX request
             type: 'POST',
             url: '<?= BASE_URL ?>server_items_urls/deleteItem',
             data: { id: id },
             beforeSend: function() {
                $(this).html('Deleting...');
             },
             success: function(response) {
                $("#row-"+server_id+'-'+id).hide('slow');
                $("#row-"+server_id+'-'+id).remove();
            }
        });
    }

  </script>