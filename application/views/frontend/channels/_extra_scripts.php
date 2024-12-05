<script type="text/javascript">
    $(document).ready(function(){
        $('#channels').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,
          'lengthMenu': [ 50, 100, 200, 500 ],
          "order": [[ 1, "asc" ]]
        });

        $('#epgs').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,
          'lengthMenu': [ 50, 100, 200, 500 ]
        });

var epg_chanel_info = '<?php echo $epg_chanel_info;?>';
var epg_info_json = JSON.parse(epg_chanel_info);
var availableTags = [];
//var projects = [];
var d = 0;

<?php
if(isset($channel_detail)){
?>
var chanelid = '<?php echo $channel_detail->epg_name; ?>';
<?php
} else{
?>
var chanelid ='';
<?php } ?>
//alert(chanelid);	
for (val of epg_info_json) {
	
	for (val of epg_info_json) {
		if(val.epgs_id == chanelid){
			availableTags[d] = val.chanel_name;
			d++;
		}
	}
}

/*$( "#channel_epg_name" ).autocomplete({
		  	source: availableTags
});*/


//=========================================================================================
var id_get = $('#epg_name').val(); 
		var epg_info_json_get = JSON.parse(epg_chanel_info);
		var availableTagscm_get = [];		
		var c_get = 0;
		for (val of epg_info_json_get) {
			//console.log(val.chanel_name);
			if(val.epgs_id == id_get){
				//availableTagscm[c] = val.chanel_name;
				availableTagscm_get[c_get] = {
										value: val.clanel_id,
										label: val.chanel_name
									  }
				c_get++;
			}
		}
		$( "#channel_epg_name" ).autocomplete({
		  	source: availableTagscm_get,
			 select: function( event, ui ) {
												$( "#channel_epg_name" ).val( ui.item.label );
												$( "#channel_epg_id" ).val( ui.item.value );
																					 
												return false;
											  }
		});
		
//==========================================================================================
		
	$('.nav li a[href="#tab_<?=$activeTab?>"]').click();

      
	$('#epg_name').change(function(){
	//function selectEpg(){
		var id = $('#epg_name').val(); 
		var epg_info_json = JSON.parse(epg_chanel_info);
		var availableTagscm = [];		
		var c = 0;
		for (val of epg_info_json) {
			//console.log(val.chanel_name);
			if(val.epgs_id == id){
				//availableTagscm[c] = val.chanel_name;
				availableTagscm[c] = {
										value: val.clanel_id,
										label: val.chanel_name
									  }
				c++;
			}
		}
		$( "#channel_epg_name" ).autocomplete({
		  	source: availableTagscm,
			 select: function( event, ui ) {
												$( "#channel_epg_name" ).val( ui.item.label );
												$( "#channel_epg_id" ).val( ui.item.value );
																					 
												return false;
											  }
		});
	});
	
	});
	
	$(() => {
  let options = {
            search: true,
            hover: false,
            responsive: true,
            checkboxes: true,
            scrollToSelect: true,
            closeAfterSelect: true,
            beforeRenderList: (item) => {
				var valbm = item.value;
				var select_image = $('#select_logo_'+valbm).val();
               /*return `<img src="https://cdn.jsdelivr.net/gh/hampusborgos/country-flags@main/svg/${item.value.toLowerCase()}.svg" width="20" /> ${item.text}`*/
			   // console.log(select_image);
			  return `<img src="${select_image}" width="30" /> ${item.text}`
            },
            onSelect: (element, item) => {
               console.log(element, item);
			  // alert(item.html);
			  var valbm = item.value;
			  var select_image = $('#select_logo_'+valbm).val();
			  $('#selected_img').html('<img src="'+select_image+'" width="100" />');
			  $('#channel_image_icon').val(select_image);
            }
         }
    $('#chanel_logo').customSelect(options)
 })	;
 
 
 function copyhigh_urldata(){
 	var server_url_high = $('#server_url_high').val();
	var url_high = $('#url_high').val();
	var token_high = $('#token_high').val();
		
	$('#url_low').val(url_high);
	$('#url_standard').val(url_high);
	//$('#url_interactivetv').val(url_high);
	$('#url_ios_tvos').val(url_high);
	$('#url_tizen_webos').val(url_high);
	
	$('select[name^="token_low"] option[value="'+token_high+'"]').attr("selected","selected");
	$('select[name^="token_standard"] option[value="'+token_high+'"]').attr("selected","selected");
	$('select[name^="token_interactivetv"] option[value="'+token_high+'"]').attr("selected","selected");
	$('select[name^="token_ios_tvos"] option[value="'+token_high+'"]').attr("selected","selected");
	$('select[name^="token_tizen_webos"] option[value="'+token_high+'"]').attr("selected","selected");
	
	$('select[name^="server_url_low"] option[value="'+server_url_high+'"]').attr("selected","selected");
	$('select[name^="server_standard"] option[value="'+server_url_high+'"]').attr("selected","selected");
	$('select[name^="server_url_interactivetv"] option[value="'+server_url_high+'"]').attr("selected","selected");
	$('select[name^="server_ios_tvos"] option[value="'+server_url_high+'"]').attr("selected","selected");
	$('select[name^="server_tizen_webos"] option[value="'+server_url_high+'"]').attr("selected","selected");
	
 }
 
 function check_available(){
 	var channel_number = $('#channel_number').val();
	$.ajax({
			type: 'POST',
			url: '<?php echo base_url()."channels/check_available";?>',
			data: {channel_number : channel_number},					
			beforeSend: function() {
				$('#channel_number_msg').html();
					/*$("#import_btn").html('Fetching...');
					$("#result").empty();
						$("#tmbm_searchresult").html("<div style='text-align:center;font-size:20px;font-waight:bold;'>Loading...</div>");
					*/
			},
			success: function(response) { 
				if(response == 'duplicate'){
					$('#channel_number_msg').html('<span style="color:red;">Already exits</span>');
				} else if(response == 'available'){
					$('#channel_number_msg').html('<span style="color:green;">Available</span>');
				} else{
					$('#channel_number_msg').html('<span style="color:green;">Try another Time</span>');
				}		
			}
						
	});
 }
  </script>`