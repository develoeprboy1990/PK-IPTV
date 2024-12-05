<script type="text/javascript">
  $(document).ready(function(){
    $('#tv_show_platforms').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'order'       : [[1, 'asc']], // Sort by order_no column by default
      'info'        : true,
      'autoWidth'   : false,
      'pageLength'  : 25
    });
  });

  function editItem(item_id){
    var name = $("#column-name-"+item_id).html();
    var order = $("#column-order-"+item_id).html();
    var language = $("#column-language-"+item_id).html();
    
    // Get languages via AJAX
    $.ajax({
      type: 'GET',
      url: '<?= BASE_URL ?>languages/getLanguages',
      success: function(response) {
        var languages = JSON.parse(response);
        var languageDropdown = '<select id="language-'+item_id+'" class="form-control">';
        languageDropdown += '<option value="">Select Language</option>';
        
        languages.forEach(function(lang) {
          var selected = (lang.name === language) ? 'selected' : '';
          languageDropdown += '<option value="'+lang.id+'" '+selected+'>'+lang.name+'</option>';
        });
        
        languageDropdown += '</select>';
        
        $("#column-name-"+item_id).html('<input type="text" id="name-'+item_id+'" class="form-control" style="width:100%;" value="'+name+'">');
        $("#column-order-"+item_id).html('<input type="number" id="order-'+item_id+'" class="form-control" style="width:100%;" value="'+order+'">');  
        $("#column-language-"+item_id).html(languageDropdown);
        $("#btn-"+item_id).html('<button type="button" data-id="'+item_id+'" class="btn large btn-success btn-flat" onclick="updateItem('+item_id+');">Update</button> <button type="button" data-id="'+item_id+'" class="btn large btn-alert" onclick="cancelUpdate('+item_id+')">Cancel</button>');
      }
    });
  }

  function updateItem(id){
    var name = $('#name-'+ id).val();
    var order = $('#order-'+ id).val() || 0;
    var language_id = $('#language-'+ id).val();
    
    if(name=="" && name!=undefined){
      alert("Please enter the TV Show Platform Name");
      $('#name-'+ id).css({border: "1px solid red"});
      return false;
    }
    
    if(language_id==""){
      alert("Please select a Language");
      $('#language-'+ id).css({border: "1px solid red"});
      return false;
    }

    $.ajax({
      type: 'POST',
      url: '<?= BASE_URL ?>tv_show_platforms/updateItem',
      data: { 
        id: id, 
        name: name,
        order_no: order,
        language_id: language_id
      },
      beforeSend: function() {
        $(this).html('Updating...');
      },
      success: function(response) {
        // Get the language name from the selected option
        var language_name = $("#language-"+id+" option:selected").text();
        $("#column-name-"+id).html(name);
        $("#column-order-"+id).html(order);
        $("#column-language-"+id).html(language_name);
        $("#btn-"+id).html('<a href="javascript:void(0);" onclick="editItem('+id+')"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" onclick="deleteItem('+id+')"><i class="fa fa-trash"></i></a>');
      }
    });
  }

  function addItem(){
    var table = document.getElementById("tv_show_platforms");
    
    var latest_row_id = $('#tv_show_platforms tr:last').attr('id');
    if(latest_row_id!=undefined){
        var str_array = latest_row_id.split('-');
        var latest_item_id=str_array[1];
        var item_id=parseInt(latest_item_id)+1;
    }else{
        var item_id=1;
    }
    
    // Get languages via AJAX
    $.ajax({
        type: 'GET',
        url: '<?= BASE_URL ?>languages/getLanguages',
        success: function(response) {
            var languages = JSON.parse(response);
            var languageDropdown = '<select id="language-'+item_id+'" class="form-control">';
            languageDropdown += '<option value="">Select Language</option>';
            
            languages.forEach(function(lang) {
                languageDropdown += '<option value="'+lang.id+'">'+lang.name+'</option>';
            });
            
            languageDropdown += '</select>';

            var row = table.insertRow(-1);
            row.id = 'row-'+item_id;

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            
            cell1.id = 'column-id-'+item_id;
            cell2.id = 'column-order-'+item_id;
            cell3.id = 'column-name-'+item_id;
            cell4.id = 'column-language-'+item_id;
            cell5.id = 'btn-'+item_id;
            
            cell1.innerHTML = '';
            cell2.innerHTML = '<input type="number" id="order-'+item_id+'" name="order_no" value="0" class="form-control">';
            cell3.innerHTML = '<input type="text" id="name-'+item_id+'" name="name" value="" class="form-control">';
            cell4.innerHTML = languageDropdown;
            cell5.innerHTML = '<button type="button" data-id="'+item_id+'" class="btn large btn-success btn-flat" onclick="add('+item_id+');">Add</button> <button type="button" data-id="'+item_id+'" class="btn large btn-alert" onclick="cancelAdd('+item_id+')">Cancel</button>';
        }
    });
  }
  function add(id){
    var name = $('#name-'+ id).val();
    var order = $('#order-'+ id).val() || 0;
    var language_id = $('#language-'+ id).val();
    
    if(name=="" && name!=undefined){
      alert("Please enter the TV Show Platform Name");
      $('#name-'+ id).css({border: "1px solid red"});
      return false;
    }
    
    if(language_id==""){
      alert("Please select a Language");
      $('#language-'+ id).css({border: "1px solid red"});
      return false;
    }

    $.ajax({
      type: 'POST',
      url:"<?php echo base_url(); ?>tv_show_platforms/addItem",
      data: { 
        id: id, 
        name: name,
        order_no: order,
        language_id: language_id
      },
      beforeSend: function() {
        $(this).html('Adding...');
      },
      success: function(response) {
        var language_name = $("#language-"+id+" option:selected").text();
        $("#column-id-"+id).html(response);
        $("#column-order-"+id).html(order);
        $("#column-name-"+id).html(name);
        $("#column-language-"+id).html(language_name);
        $("#btn-"+id).html('<a href="javascript:void(0);" onclick="editItem('+id+')"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" onclick="deleteItem('+id+')"><i class="fa fa-trash"></i></a>');
      }
    });
  }

  function cancelUpdate(id){
    $.ajax({
        type: 'POST',
        url: '<?= BASE_URL ?>tv_show_platforms/getItem',
        data: { id: id },
        success: function(response) {
            var data = JSON.parse(response);
            $("#column-name-"+id).html(data.name);
            $("#column-order-"+id).html(data.order_no);  // Add this line
            $("#column-language-"+id).html(data.language_name);
            $("#btn-"+id).html('<a href="javascript:void(0);" onclick="editItem('+id+')"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" onclick="deleteItem('+id+')"><i class="fa fa-trash"></i></a>');
        }
    });
  }

  function cancelAdd(id){
    $("#row-"+id).remove();
  }

  function deleteItem(id){
    var result = confirm("Do you really want to delete this TV Show Platform?");
    if (result) {
      $.ajax({
        type: 'POST',
        url: '<?= BASE_URL ?>tv_show_platforms/deleteItem',
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
</script>