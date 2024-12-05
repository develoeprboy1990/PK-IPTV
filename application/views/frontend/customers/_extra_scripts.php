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

<script type="text/javascript">
  var ppBtnDom;
  var _dataTable_items; 
  var rowDeleteBtnDom; 

  $(document).ready(function(){
  	
    var datatable;
    $('#devices').DataTable({ 
    'paging'      : true,
    'lengthChange': true,
    'searching'   : true,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : false,
    'lengthMenu': [ 50, 100, 200, 500 ],
    });
    $('#debug_logs,#logs').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        'pageLength'  : 100,
        'lengthMenu': [ 50, 100, 200, 500 ],
        'order'       :[0, 'desc'],
        'dom'         : 'Bfrtip',
        'buttons': [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });

    //CKEDITOR.replace('email-message-body');
	  const filterStatus = document.querySelector('[data-kt-ecommerce-product-filter="resellers"]');
    $(filterStatus).on('change', e => {
            let value = e.target.value;
            if(value === 'all'){
                value = '';
            }
            datatable.column(9).search(value).draw();
        });
		
    $('.nav li a[href="#tab_<?=$activeTab?>"]').click();

    $('#billing_country').change(function(){
        var country_id = $('#billing_country').val();
      
        if(country_id != ''){
         $.ajax({
            url:"<?php echo base_url(); ?>dynamic_dependent/fetch_state",
            method:"POST",
            data:{country_id:country_id},
            success:function(data){
               $('#billing_state').html(data);
               //$('#billing_city').html('<option value="">Select City</option>');
            }
          });
        }
        else{
             $('#billing_state').html('<option value="">Select State</option>');
             //$('#billing_city').html('<option value="">Select City</option>');
          }
      });
    /*$('#billing_state').change(function(){
      var state_id = $('#billing_state').val();
      if(state_id != '')
      {
       $.ajax({
          url:"<?php echo base_url(); ?>dynamic_dependent/fetch_city",
          method:"POST",
          data:{state_id:state_id},
          success:function(data){
           $('#billing_city').html(data);
          }
       });
      }
      else{
      $('#billing_city').html('<option value="">Select City</option>');
      }
    });*/
    $('#shipping_country').change(function(){
      var country_id = $('#shipping_country').val();
    
      if(country_id != ''){
       $.ajax({
          url:"<?php echo base_url(); ?>dynamic_dependent/fetch_state",
          method:"POST",
          data:{country_id:country_id},
          success:function(data){
             $('#shipping_state').html(data);
             $('#shipping_city').html('<option value="">Select City</option>');
          }
        });
      }
      else{
           $('#shipping_state').html('<option value="">Select State</option>');
           $('#shipping_city').html('<option value="">Select City</option>');
        }
    });

    $('#shipping_state').change(function(){
      var state_id = $('#shipping_state').val();
      if(state_id != '')
      {
       $.ajax({
          url:"<?php echo base_url(); ?>dynamic_dependent/fetch_city",
          method:"POST",
          data:{state_id:state_id},
          success:function(data){
           $('#shipping_city').html(data);
          }
       });
      }
      else{
      $('#shipping_city').html('<option value="">Select City</option>');
      }
    });

    // movies_stores
    $('#btn_leftSelected_movie_stores').click(function () {
        // pass id select lists as parameters
        moveItemsToLeft('#multiselect_left_movie_stores', '#multiselect_right_movie_stores');
    });

    $('#btn_rightSelected_movie_stores').on('click', function () {
      moveItemsToRight('#multiselect_left_movie_stores', '#multiselect_right_movie_stores');
    });

    $('#btn_leftAll_movie_stores').on('click', function () {
      moveAllItemsToSource('#multiselect_left_movie_stores', '#multiselect_right_movie_stores');
    });

    $('#btn_rightAll_movie_stores').on('click', function () {
      moveAllItemsToDest('#multiselect_left_movie_stores', '#multiselect_right_movie_stores');
    });

    $('#btn_move_up_movie_stores').click(function(){
      moveUp('#multiselect_right_movie_stores');
    });

    $('#btn_move_down_movie_stores').click(function(){
        moveDown('#multiselect_right_movie_stores');
    });
   
    // Series Stores Group
    $('#btn_leftSelected_series_stores').click(function () {
        // pass id select lists as parameters
        moveItemsToLeft('#multiselect_left_series_stores', '#multiselect_right_series_stores');
    });

    $('#btn_rightSelected_series_stores').on('click', function () {
      moveItemsToRight('#multiselect_left_series_stores', '#multiselect_right_series_stores');
    });

    $('#btn_leftAll_series_stores').on('click', function () {
      moveAllItemsToSource('#multiselect_left_series_stores', '#multiselect_right_series_stores');
    });

    $('#btn_rightAll_series_stores').on('click', function () {
      moveAllItemsToDest('#multiselect_left_series_stores', '#multiselect_right_series_stores');
    });

    $('#btn_move_up_series_stores').click(function(){
      moveUp('#multiselect_right_series_stores');
    });

    $('#btn_move_down_series_stores').click(function(){
        moveDown('#multiselect_right_series_stores');
    });

    // Music Categories Group
    $('#btn_leftSelected_music_categories').click(function () {
        // pass id select lists as parameters
        moveItemsToLeft('#multiselect_left_music_categories', '#multiselect_right_music_categories');
    });

    $('#btn_rightSelected_music_categories').on('click', function () {
      moveItemsToRight('#multiselect_left_music_categories', '#multiselect_right_music_categories');
    });

    $('#btn_leftAll_music_categories').on('click', function () {
      moveAllItemsToSource('#multiselect_left_music_categories', '#multiselect_right_music_categories');
    });

    $('#btn_rightAll_music_categories').on('click', function () {
      moveAllItemsToDest('#multiselect_left_music_categories', '#multiselect_right_music_categories');
    });

    $('#btn_move_up_music_categories').click(function(){
      moveUp('#multiselect_right_music_categories');
    });

    $('#btn_move_down_music_categories').click(function(){
        moveDown('#multiselect_right_music_categories');
    });

    // Initialize DataTables
    var regularTable = $('#customers').DataTable({ 
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false,
      'lengthMenu': [ 50, 100, 200, 500 ],
    });
    var migratedTable = $('#migrated-customers').DataTable({ 
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false,
      'lengthMenu': [ 50, 100, 200, 500 ],
    });
    var unverifiedTable = $('#unverified-customers').DataTable({ 
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false,
      'lengthMenu': [ 50, 100, 200, 500 ],
    });
    var trialTable = $('#trial-customers').DataTable({ 
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false,
      'lengthMenu': [ 50, 100, 200, 500 ],
    });

    // Trigger the tab change event for the initial active tab
    $('.nav-tabs li.active a').trigger('shown.bs.tab');

    $('.resend-verification').click(function() {
        var customerId = $(this).data('id');
        $.ajax({
            url:"<?php echo base_url(); ?>customers/resend_verification",
            method: 'POST',
            data: {customer_id: customerId},
            success: function(response) {
                alert('Verification email resent successfully');
            },
            error: function() {
                alert('Error resending verification email');
            }
        });
    });

    $('.manual-verify').click(function() {
      var customerId = $(this).data('id');
      $.ajax({
          url:"<?php echo base_url(); ?>customers/manual_verify",
          method: 'POST',
          data: {customer_id: customerId},
          success: function(response) {
              var data = JSON.parse(response);
              if (data.status === 'success') {
                  alert('Customer verified successfully');
                  location.reload(); // Reload the page to reflect the change
              } else {
                  alert('Error: ' + data.message);
              }
          },
          error: function() {
              alert('Error verifying customer');
          }
      });
  });

    // Search functionality
    $('#search-button').on('click', function(e){
        e.preventDefault(); // Prevent the default anchor tag behavior
        var searchTerm = $('#main-search').val().toLowerCase();
        var foundResults = false;
        var tabToShow = null;

        // Search function
        var searchFunction = function(settings, data, dataIndex) {
            var rowData = data.join(' ').toLowerCase();
            return rowData.indexOf(searchTerm) !== -1;
        };

        // Apply search to all tables
        $.fn.dataTable.ext.search.push(searchFunction);

        // Function to check results and update tab
        function checkResults(table, tabNumber) {
            if (!foundResults && table.rows({ search: 'applied' }).any()) {
                foundResults = true;
                tabToShow = tabNumber;
            }
        }

        // Check each table and draw
        regularTable.search(searchTerm).draw();
        checkResults(regularTable, 1);

        migratedTable.search(searchTerm).draw();
        checkResults(migratedTable, 2);

        unverifiedTable.search(searchTerm).draw();
        checkResults(unverifiedTable, 3);

        trialTable.search(searchTerm).draw();
        checkResults(trialTable, 4);

        // Remove the search function from the extension array
        $.fn.dataTable.ext.search.pop();

        // Switch to the appropriate tab if results were found
        if (foundResults) {
            switchToTab(tabToShow);
        } else {
            alert('No results found');
        }
      });

    // Optional: Trigger search on Enter key press in the search input
    $('#main-search').on('keypress', function(e) {
        if (e.which === 13) {  // 13 is the Enter key code
            $('#search-button').click();
        }
    });

    if($('#product_id').val() != '') {
      $('#product_id').trigger('change');
    }  
     
  });

  // Function to switch tabs
  function switchToTab(tabNumber) {
      $('.nav-tabs a[href="#tab_' + tabNumber + '"]').tab('show');
  }

  $('#decrement').click(function(){
      var current_value=($('#devices-allowed').text());
      if(parseInt(current_value)>1){
      var new_value=parseInt(current_value)-1;
      var id=$('#customer-id').val();
      $.ajax({
        url:"<?php echo base_url(); ?>customers/updateDevicesAllowed",
        method:"POST",
        data:{devices_allowed:new_value,customer_id: id},
        success:function(data){
         $('#devices-allowed').text(new_value);
        }
     });
    }else{
        alert('You cannot decrease Allowed Device to Zero.');
    }
  });

  $('#increment').click(function(){
      var current_value=($('#devices-allowed').text());
      if(parseInt(current_value)<5){
        var new_value=parseInt(current_value)+1;

        var id=$('#customer-id').val();
        $.ajax({
          url:"<?php echo base_url(); ?>customers/updateDevicesAllowed",
          method:"POST",
          data:{devices_allowed:new_value,customer_id: id},
          success:function(data){
           $('#devices-allowed').text(new_value);
          }
       });
      }else{
          alert('Maximum Limit is 5.');
      }
  });

  $('#product_id').change(function(){
        var product_id = $('#product_id').val();
        var selected_plan = '<?php echo set_value('plan_id'); ?>';

        if(product_id != ''){
         $.ajax({
          url:"<?php echo base_url(); ?>customers/productselect",
          method:"POST",
          data:{
            product_id:product_id,
            selected_plan: selected_plan
          },
          success:function(data){
            $('#plan_id').html(data);
            if(selected_plan) {
              $('#plan_id').val(selected_plan);
            }
          }
          });
        }
        else{
           $('#plan_id').html('<option value="">Select Plan</option>');             
          }
      });

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
        url:"<?=site_url('customers/fetchmessages')?>",
        type:"POST",
        data:{customer_id:$('#customer-id').val()},
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
        url: '<?=site_url('customers/fetch_message_data')?>',
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
          
            $.app.message_box(response.message, 'success', '.content');
            $('.message-container div').fadeOut(5000);
          }
          else {
            $.app.message_box(response.message, 'error', '.content');
          }
          $('.loader-parent').removeClass('loading');
        },
        error: function (error) {
          $.app.message_box('Error Occured', 'error', '.content');
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
        url: '<?=site_url('customers/updatemessage')?>',
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
        url: '<?=site_url('customers/deletemessage')?>',
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
    send: function ($this) {
      $('.loader-parent').addClass('loading');
      var id = rowDeleteBtnDom.parents('tr').attr('id');
      var params = {'id': id};
      $.ajax({
        type: 'post',
        url: '<?=site_url('customers/sendmessage')?>',
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
    $.message.send(rowDeleteBtnDom);
    return false;
  });
  
  $('#extend_date').datetimepicker({
    format:'YYYY-MM-DD HH:mm:ss'
    //  endDate : today,
    //todayHighlight: true
    //minDate:new Date()
  });
</script>