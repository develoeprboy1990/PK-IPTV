<style>
.export-icon{font-size: 24px; margin: 2px;}
.csv, .pdf{color: red}
.excel{color: green}
</style>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
         var table = $('#analytics').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,
          'pageLength'  : 100,
          'order'       : [[ 0, "desc" ]],
          'dom'         : 'Bfrtip',
          'buttons': [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ]
        });

        $('#analytics tbody tr').on('click', function () {
          var id=$(this).attr('data');
          $.ajax({
              type: 'POST',
              url: '<?=site_url("reports/getAnalytics/")?>',
              data:{id: id},
              success: function(data) {
                $('.modal-body').html(data);
                //$('#myModalLabel').html('');
                $('#myModal').modal({show:true});
              },
              error:function(err){
                alert("error"+JSON.stringify(err));
              }
          });
        });
    });
  </script>