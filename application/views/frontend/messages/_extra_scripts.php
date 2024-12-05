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
<!-- CK Editor -->
<script src="<?=DEFAULT_ASSETS?>bower_components/ckeditor/ckeditor.js"></script>
<script src="<?=DEFAULT_ASSETS?>jquery.validate.min.js"></script>


<link rel="stylesheet" href="<?=DEFAULT_ASSETS?>dist/dist/bootstrap-tagsinput.css">
<script src="<?=DEFAULT_ASSETS?>dist/dist/bootstrap-tagsinput.min.js"></script>

<script type="text/javascript">
var ppBtnDom;
var _dataTable_items; 
var rowDeleteBtnDom;

$(function(){
    var $ckfield = CKEDITOR.replace('body');
    $ckfield.on('change', function() {
      $ckfield.updateElement();         
    });
});

$(function(){
    var $ckfield = CKEDITOR.replace('updated-body');
    $ckfield.on('change', function() {
      $ckfield.updateElement();         
    });
});

if($('#messages').length > 0){    
    _dataTable_items=$('#messages').DataTable({
      "processing": true,
      "serverSide": true,
      "order":[],
      "ajax":{
    url:"<?=site_url('messages/fetchmessages')?>",
    type:"POST",
    data:{},
    dataType:"json"
  },
  "columnDefs":[{"targets":[3],"orderable":false}],          
    });
} 
  
$.message ={
  editInit: function () {
    $('.loader-parent').addClass('loading');
    var id = ppBtnDom.parents('tr').attr('id');
    for (instance in CKEDITOR.instances) 
    {
        CKEDITOR.instances[instance].updateElement();
    }
    var params = {'id': id};
    $.ajax({
      type: 'post',
      url: '<?=site_url('messages/fetch_message_data')?>',
      data: params,
      dataType: 'json',
      success: function(response) {
        if(response.status == 1) {
          var fields = {
            'id': 'id',             
            'subject': 'subject',
            'body': 'body'
          };
          $.each(fields, function (field, fieldId) {
            $('#form-update-message').find('[name="'+field+'"]').val(response['message_data'][field]);
          });
          CKEDITOR.instances['updated-body'].setData(response.message_data.body);
        
          $.app.message_box(response.message, 'success', '#page-content');
          $('.message-container div').fadeOut(5000);
        }
        else {
          $.app.message_box(response.message, 'error', '#page-content');
        }
        $('.loader-parent').removeClass('loading');
      },
      error: function (error) {
        $.app.message_box('Error Occured', 'error', '#page-content');
        $('.loader-parent').removeClass('loading');
      }
    });
  },
  update: function (formDom, actiontype) {
    $('.loader-parent').addClass('loading');
    for (instance in CKEDITOR.instances) 
    {
        CKEDITOR.instances[instance].updateElement();
    }
    var params = $(formDom).serialize()+'&actiontype='+actiontype;
    $.ajax({
      type: 'post',
      url: '<?=site_url('messages/updatemessage')?>',
      data: params,
      dataType: 'json',
      success: function(response) {
        if(response.status == 1) {
          $.app.message_box(response.message, 'success', '.content');
          $('.message-container div').fadeOut(5000);
          // reload the items table 
          _dataTable_items.ajax.reload();

          $('#form-create-message')[0].reset();
          $('#form-update-message')[0].reset();
          
          CKEDITOR.instances.body.setData('');

          if(response.utype=='add'){
                $('#modal-create-message').modal('hide');
              }else{
                $('#modal-edit-message').modal('hide');
              }
        }
        else {
          $.app.message_box(response.message, 'error', '.content');
        }
        $('.loader-parent').removeClass('loading');
      },
      error: function (error) {
        $.app.message_box('An error occurred.', 'error', '.content');
        $('.loader-parent').removeClass('loading');
      }
    });
  },
  delete: function ($this) {
    $('.loader-parent').addClass('loading');
    var id = rowDeleteBtnDom.parents('tr').attr('id');
    var params = {'id': id};
    $.ajax({
      type: 'post',
      url: '<?=site_url('messages/deletemessage')?>',
      data: params,
      dataType: 'json',
      success: function(response) {
        if(response.status == 1) {
          $.app.message_box(response.message, 'success', '.content');
          $('.message-container div').fadeOut(5000);
          _dataTable_items.ajax.reload();
          //var deletedRow = _dataTable_items.fnDeleteRow( $this.parents('tr')[0] );
        }
        else {
          $.app.message_box(response.message, 'error', '.content');
        }
        $('.loader-parent').removeClass('loading');
      },
      error: function (error) {
        $.app.message_box('An error occurred.', 'error', '.content');
        $('.loader-parent').removeClass('loading');
      }
    });
  },
  send: function ($this,emails) {
    $('.loader-parent').addClass('loading');
    var id = rowDeleteBtnDom.parents('tr').attr('id');
    var params = {'id': id,'emails': emails};
    
    $.ajax({
      type: 'post',
      url: '<?=site_url('messages/sendmessage')?>',
      data: params,
      dataType: 'json',
      success: function(response) {
        if(response.status == 1) {
          $.app.message_box(response.message, 'success', '.content');
          $('.message-container div').fadeOut(5000);
          _dataTable_items.ajax.reload();
          //var deletedRow = _dataTable_items.fnDeleteRow( $this.parents('tr')[0] );
        }
        else {
          $.app.message_box(response.message, 'error', '.content');
        }
        $('.loader-parent').removeClass('loading');
      },
      error: function (error) {
        $.app.message_box('An error occurred.', 'error', '.content');
        $('.loader-parent').removeClass('loading');
      }
    });
  }  
}

  $(document).on('click', '.btn-add-message', function () {
    $('#modal-create-message').modal('show');  
  });

  if($('#form-create-message').length > 0) {
    $('#form-create-message').validate({
      ignore: "",
      rules: {
        'subject':{
          'required': true  
        }
      },
      highlight: function(element, errorClass, validClass) {
        $(element).parents('.form-group').addClass('has-error');
        $(element).addClass('error');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).parents('.form-group').removeClass('has-error');
        $(element).removeClass('error');
      },
      errorPlacement: function(error, element) {
        if(element.attr("name") == "email") {
              error.insertAfter(element);
          }       
      },
      messages: {},
      submitHandler: function (form) {
        $.message.update('#form-create-message', 'add');
        return false;
      }
    });
  }
  
  $(document).on('click', '.btn-edit-message', function () {
    ppBtnDom = $(this);

    $('#modal-edit-message').modal('show');
    $.message.editInit();
  });

  if($('#form-update-message').length > 0) {
    $('#form-update-message').validate({
        ignore: "",
        rules: {
          'subject':{
            'required': true  
          }
        },
        highlight: function(element, errorClass, validClass) {
          $(element).parents('.form-group').addClass('has-error');
          $(element).addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).parents('.form-group').removeClass('has-error');
          $(element).removeClass('error');
        },
        errorPlacement: function(error, element) {
          if(element.attr("name") == "email") {
                error.insertAfter(element);
            }
        },
        messages: {},
        submitHandler: function (form) {
          $.message.update('#form-update-message', 'edit');
          return false;
        }
    });
  }

  $(document).on('click', '.btn-delete-message-confirmed', function () {
    $('#modal-delete-confirmation-message').modal('hide');
    $.message.delete(rowDeleteBtnDom);
    return false;
  });

  $(document).on('click', '.btn-delete-message', function () {
    rowDeleteBtnDom = $(this);
    $('#modal-delete-confirmation-message').modal('show');
  });
  
  $(document).on('click', '.btn-send-message', function () {
    rowDeleteBtnDom = $(this);
    $('#modal-send-confirmation-message').modal('show');
  });

  $(document).on('click', '.btn-send-message-confirmed', function () {
    $('#modal-send-confirmation-message').modal('hide');
    send_to_emails = $('#send-to').val();
    $.message.send(rowDeleteBtnDom, send_to_emails);
    return false;
  });


  $('#extend_date').datetimepicker({
      format:'YYYY-MM-DD HH:mm:ss',
      minDate:new Date()
  });
</script>