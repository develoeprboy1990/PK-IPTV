<style>
.export-icon{font-size: 24px; margin: 2px;}
.csv, .pdf{color: red}
.excel{color: green}
.switch {
  position: relative;
  display: inline-block;
  width: 30px;
  height: 17px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 10px;
  width: 11px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(13px);
  -ms-transform: translateX(13px);
  transform: translateX(13px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 17px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-bold-straight/css/uicons-bold-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-solid-straight/css/uicons-solid-straight.css'> 
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#apps,#package-keys,#activation-keys').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'lengthMenu': [ 50, 100, 200, 500 ],
      'dom'         : 'Bfrtip',
      'buttons': [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });
    $('.nav li a[href="#tab_<?=$activeTab?>"]').click();

    $('.status-toggle').on('change', function() {
      var id = $(this).data('id');
      var status = $(this).prop('checked') ? 1 : 0;
      var type = $(this).data('type');
      var $toggle = $(this);
            
      $.ajax({
          url:"<?php echo base_url(); ?>app_publish/updateStatus",
          method: 'POST',
          data: {
              id: id,
              status: status,
              type: type
          },
          success: function(response) {
              var result = JSON.parse(response);
              if (result.status === 'success') {
                  Swal.fire("Success", type + " Status updated successfully", "success");
              } else {
                  Swal.fire("Error", result.message, "error");
                  // Revert the checkbox state
                  $toggle.prop('checked', !$toggle.prop('checked'));
              }
          },
          error: function() {
              Swal.fire("Error", "Failed to update status", "error");
              // Revert the checkbox state
              $toggle.prop('checked', !$toggle.prop('checked'));
          }
      });
    });

    $('.view-details').on('click', function() {
    var id = $(this).data('id');
    
    $.ajax({
        url: "<?php echo base_url(); ?>app_publish/getDetails",
        method: 'POST',
        data: { id: id },
        success: function(response) {
            var details = JSON.parse(response);
            var modalContent = '<table class="table">';
            for (var key in details) {
                var label = key.charAt(0).toUpperCase() + key.slice(1).replace(/_/g, ' ');
                var value = details[key];
                
                // Format specific fields
                if (key === 'forceupdate') {
                    value = value == '1' ? 'True' : 'False';
                }
                if (key === 'update_without_login') {
                    value = value == '1' ? 'True' : 'False';
                }
                if (key === 'status') {
                    value = value == '1' ? 'Active' : 'Inactive';
                }
                
                modalContent += '<tr><th>' + label + '</th><td>' + value + '</td></tr>';
            }
            modalContent += '</table>';

            if(details.type == 'General')
            {
                $('#modalGeneralBody').html(modalContent);
                $('#detailsGeneralModal').modal('show');
            }
            if(details.type == 'SetUp')
            {
                $('#modalSetUpBody').html(modalContent);
                $('#detailsSetUpModal').modal('show');
            }
            if(details.type == 'Beta')
            {
                $('#modalBetaBody').html(modalContent);
                $('#detailsBetaModal').modal('show');
            }

            
        },
        error: function() {
            Swal.fire("Error", "Failed to fetch details", "error");
        }
    });
});
    
    $('.edit-record').on('click', function() {
        var id = $(this).data('id');
        window.location.href = "<?php echo base_url('app_publish/editAppPublish/'); ?>" + id;
    });
    $('.delete-record').on('click', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:"<?php echo base_url(); ?>app_publish/deleteAppPublish",
                    method: 'POST',
                    data: { id: id },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if(result.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'The record has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Failed to delete the record.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the record.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    $('.publish-app').on('click', function() {
        var type = $(this).data('type');
        $.ajax({
            url:"<?php echo base_url(); ?>app_publish/publishApp",
            method: 'POST',
            data: { type: type },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    Swal.fire("Success", type + " App published successfully", "success");
                } else {
                    Swal.fire("Error", result.message, "error");
                }
            },
            error: function() {
                Swal.fire("Error", "Failed to publish " + type + " App", "error");
            }
        });
    });

    // Add this to your existing scripts
    /*function copyToClipboard(text) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(text).select();
        document.execCommand("copy");
        $temp.remove();
    }

    $('.copy-download-link').on('click', function(e) {
        e.preventDefault();
        var type = $(this).data('type');
        $.ajax({
            url:"<?php echo base_url(); ?>app_publish/copyLink/"+ type,
            type: 'GET',
            success: function(response) {
                var result = JSON.parse(response);
                if(result.status === 'success') {
                    copyToClipboard(result.link);
                    Swal.fire({
                        title: 'Success!',
                        text: 'Download link copied to clipboard',
                        icon: 'success',
                        timer: 2000
                    });
                }
            }
        });
    });*/
    // Add/modify in your existing scripts
    function copyToClipboard(text) {
        // Modern browsers
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(() => {
                Swal.fire({
                    title: 'Success!',
                    text: 'App URL copied to clipboard',
                    icon: 'success',
                    timer: 2000
                });
            });
        } else {
            // Fallback for older browsers
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(text).select();
            try {
                document.execCommand("copy");
                Swal.fire({
                    title: 'Success!',
                    text: 'App URL copied to clipboard',
                    icon: 'success',
                    timer: 2000
                });
            } catch (err) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to copy URL',
                    icon: 'error',
                    timer: 2000
                });
            }
            $temp.remove();
        }
    }

    // Copy App URL handler
    $('.copy-app-url').on('click', function() {
        var url = $(this).data('url');
        if(url) {
            copyToClipboard(url);
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'No active app URL available',
                icon: 'error',
                timer: 2000
            });
        }
    });


  });  
</script>