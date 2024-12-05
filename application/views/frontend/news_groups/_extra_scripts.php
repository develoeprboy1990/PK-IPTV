<script type="text/javascript">
    $(document).ready(function(){
        $('#news_groups').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
        });
    });

    function edit(id){
      var name = $("#group_"+id + " a").html();
      $("#group_"+id).html('<input type="text" id="name-'+id+'" class="form-control" style="width:100%;" value="'+name+'">');
      $("#btn_"+id).html('<button type="button" data-id="'+id+'" class="btn large btn-success btn-flat" onclick="update('+id+');">Update</button> <button type="button" data-id="'+id+'" class="btn large btn-alert" onclick="cancel('+id+')">Cancel</button>');
    }

    function update(id){
        var name = $('#name-' + id).val();
        $.ajax({ // AJAX request
             type: 'POST',
             url: '<?= BASE_URL ?>news_groups/update',
             data: { id: id , name: name},
             beforeSend: function() {
                $(this).html('Updating...');
             },
             success: function(response) {
                 $("#group_"+id).html('<a href="<?= BASE_URL ?>news/items/'+id+ '">'+name+'</a>');
                 $("#btn_"+id).html('<a href="javascript:void(0);" onclick="edit('+id+')"><i class="fa fa-edit"></i></a>');
            }
        });
    }

    function cancel(id){
      var name = $("#name-"+id).val();
      $("#group_"+id).html('<a href="<?= BASE_URL ?>news/items/'+id+ '">'+name+'</a>');
      $("#btn_"+id).html('<a href="javascript:void(0);" onclick="edit('+id+')"><i class="fa fa-edit"></i></a>');
    }

  </script>