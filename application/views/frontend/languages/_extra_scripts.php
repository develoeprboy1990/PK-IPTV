<script type="text/javascript">
  $(document).ready(function(){
    $('#languages').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'pageLength'  : 25
    });
  });

    function editItem(item_id){
      var name = $("#column-name-"+item_id).html();
      $("#column-name-"+item_id).html('<input type="text" id="name-'+item_id+'" class="form-control" style="width:100%;" value="'+name+'">');
      $("#btn-"+item_id).html('<button type="button" data-id="'+item_id+'" class="btn large btn-success btn-flat" onclick="updateItem('+item_id+');">Update</button> <button type="button" data-id="'+item_id+'" class="btn large btn-alert" onclick="cancelUpdate('+item_id+')">Cancel</button>');
    }

    function updateItem(id){
        var name = $('#name-'+ id).val();
        if(name=="" && name!=undefined){
          alert("Please enter the Language Name");
          $('#name-'+ id).css({border: "1px solid red"});
          return false;
        }
        $.ajax({ // AJAX request
             type: 'POST',
             url: '<?= BASE_URL ?>languages/updateItem',
             data: { id: id , name: name},
             beforeSend: function() {
                $(this).html('Updating...');
             },
             success: function(response) {
                 $("#column-name-"+id).html(name);
                 $("#btn-"+id).html('<a href="javascript:void(0);" onclick="editItem('+id+')"><i class="fa fa-edit"></i> <a href="javascript:void(0);" onclick="deleteItem('+id+')"><i class="fa fa-trash"></i></a>');
            }
        });
    }

    function addItem(){
      var table = document.getElementById("languages");
      
      //get latest row's id of table 
      var latest_row_id = $('#languages tr:last').attr('id');
      if(latest_row_id!=undefined){
        var str_array = latest_row_id.split('-');
        var latest_item_id=str_array[1];
        var item_id=parseInt(latest_item_id)+1;
      }else{
        var item_id=1;
      }
      var row = table.insertRow(-1);
      row.id = 'row-'+item_id;

      var cell1 = row.insertCell(0);
      cell1.id = 'column-id-'+item_id;

      var cell2 = row.insertCell(1);
      cell2.id = 'column-name-'+item_id;

      var cell3 = row.insertCell(2);
      cell3.id = 'btn-'+item_id;
      
      cell1.innerHTML = '';
      cell2.innerHTML = '<input type="text" id="name-'+item_id+'" name="name" value="" class="form-control">';
      cell3.innerHTML = '<button type="button" data-id="'+item_id+'" class="btn large btn-success btn-flat" onclick="add('+item_id+');">Add</button> <button type="button" data-id="'+item_id+'" class="btn large btn-alert" onclick="cancelAdd('+item_id+')">Cancel</button>';
    }

    function add(id){
        var name = $('#name-'+ id).val();
        if(name=="" && name!=undefined){
          alert("Please enter the Language Name");
          $('#name-'+ id).css({border: "1px solid red"});
          return false;
        }

        $.ajax({ // AJAX request
             type: 'POST',
             url: '<?= BASE_URL ?>languages/addItem',
             data: { id: id , name: name},
             beforeSend: function() {
                $(this).html('Updating...');
             },
             success: function(response) {
                 $("#column-id-"+id).html(response);
                 $("#column-name-"+id).html(name);
                 $("#btn-"+id).html('<a href="javascript:void(0);" onclick="editItem('+id+')"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" onclick="deleteItem('+id+')"><i class="fa fa-trash"></i></a>');
            }
        });
    }

    function cancelUpdate(id){
      var name = $('#name-'+ id).val();
      // if cancel need to get the original
      $.ajax({ // AJAX request
               type: 'POST',
               url: '<?= BASE_URL ?>languages/getItem',
               data: { id: id },
               success: function(response) {
                  $("#column-name-"+id).html(response);
              }
      });
      
      $("#btn-"+id).html('<a href="javascript:void(0);" onclick="editItem('+id+')"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" onclick="deleteItem('+id+')"><i class="fa fa-trash"></i></a>');
    }

    function cancelAdd(id){
      $("#row-"+id).remove();
    }

    function deleteItem(id){
        var result = confirm("Do you really want to delete?");
        if (result) {
          $.ajax({ // AJAX request
               type: 'POST',
               url: '<?= BASE_URL ?>languages/deleteItem',
               data: { id: id },
               beforeSend: function() {
                  $(this).html('Deleting...');
               },
               success: function(response) {
                  $("#row-"+id).hide('slow');
                  $("#row-"+id).remove();
              }
          });
        }
    }
 
  </script>`