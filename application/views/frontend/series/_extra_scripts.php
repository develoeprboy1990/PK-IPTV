<script type="text/javascript">
$(document).ready(function(){
    $('#series').DataTable({
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'    : true,
       'info'        : true,
       'autoWidth'   : false,
       'lengthMenu': [ 50, 100, 200, 500 ],
	     'order': [[0, 'desc']]
    });
	$('#episode_update').click(function(){
		/*$('#days_select').toggle();
		if($(this).is(':checked')){
			$('#sun_day').val('1');
			$('#mon_day').val('1');
			$('#tues_day').val('1');
			$('#wednes_day').val('1');
			$('#thirs_day').val('1');
			$('#fri_day').val('1');
			$('#satur_day').val('1');
		}else{
			$('#sun_day').val('0');
			$('#mon_day').val('0');
			$('#tues_day').val('0');
			$('#wednes_day').val('0');
			$('#thirs_day').val('0');
			$('#fri_day').val('0');
			$('#satur_day').val('0');
		}*/
	});
	$('#imdb').click(function(){
		if($('#imdb').is(':checked')){
			//alert($("#imdb:checked").val());
			$('#tmdb').prop('checked', false); 
			$('#manually_insert').prop('checked', false);
			$('#serese_boxbm_select').css({'display':'none'});
			
			var htmlstring = '<div class="input-group input-group-sm" style="padding-left: 5px;padding-right: 5px;">'
              +'<input type="text" id="tmdbid" name="tmdbid" placeholder="Enter IMDB ID or Name. Ex: 141052 or Jack" required="" class="form-control">'
              +'<span class="input-group-btn">'
                +'<button type="button" class="btn large btn-info btn-flat w-sm waves-effect waves-light" id="import_btn">Fetch</button>'
              +'</span>'
            +'</div>';
			$('#search_boxbm').html(htmlstring);
		} else{
			$('#search_boxbm').html('');
			$('#serese_boxbm_select').css({'display':'none'});
		}
	});
	$('#tmdb').click(function(){
		if($('#tmdb').is(':checked')){
			//alert($("#imdb:checked").val());
			$('#imdb').prop('checked', false);
			$('#manually_insert').prop('checked', false);
			$('#serese_boxbm_select').css({'display':'none'});
			 
			var htmlstring = '<div class="input-group input-group-sm" style="padding-left: 5px;padding-right: 5px;">'
	          +'<input type="text" id="tmdbid" name="tmdbid" placeholder="Enter TMDB ID or Name. Ex: 141052 or Jack" required="" class="form-control">'
	          +'<span class="input-group-btn">'
	            +'<button type="button" class="btn large btn-info btn-flat w-sm waves-effect waves-light" id="import_btn">Fetch</button>'
	          +'</span>'
	        +'</div>';
			$('#search_boxbm').html(htmlstring);
		}
		else{
			$('#search_boxbm').html('');
			$('#serese_boxbm_select').css({'display':'none'});
		}
	});
	$('#manually_insert').click(function(){
		if($('#manually_insert').is(':checked')){
			$('#imdb').prop('checked', false); 
			$('#tmdb').prop('checked', false); 
			
			$('#search_boxbm').html('');
			$('#serese_boxbm_select').css({'display':'block'});
		} else {
			$('#search_boxbm').html('');
			$('#serese_boxbm_select').css({'display':'none'});
		}
	});
	$('#parent-store').change(function(){
      var parent_id = $('#parent-store').val();
      if(parent_id != '')
      {
       $.ajax({
          url:"<?php echo base_url(); ?>series_stores/fetch_sub_stores",
          method:"POST",
          data:{parent_id:parent_id},
          success:function(data){
           $('#sub-store').html(data);
          }
       });
      }
      else{
      $('#sub-store').html('<option value="">Select Sub Store</option>');
      }
    });	
		// $('#import_btn').click(function(){
	$(document).on('click', '#import_btn', function() {
	 	var tmdbid = $('#tmdbid').val();
		
		var imdb = $("#imdb:checked").val();
		var tmdb = $("#tmdb:checked").val();
		
		var dbselect = '';
		if(imdb == 'imdb'){
			dbselect = 'imdb';
		}else if(tmdb == 'tmdb'){
			dbselect = 'tmdb'
		}
		
	 	$.ajax({
          url:"<?php echo base_url(); ?>series/import_series",
          method:"POST",
          data:{id:tmdbid, dbselect:dbselect, sall:'all'},
		  beforeSend: function() {
		  	  $('#ssss_ggg').html('');
			  $('#ssss_gggdd').html('');
              $("#import_btn").html('Fetching...');
			  $("#result").empty();
			  $('#serese_boxbm').css({'display':'block'});
			  $('#serese_boxbm_select').css({'display':'none'});
			  $("#tmbm_searchresult").html("<div style='text-align:center;font-size:20px;font-waight:bold;'>Loading...</div>");
			  
          },
          success:function(responsebm){
           		$("#import_btn").html('Fetch');
				var responsejsondata = JSON.parse(responsebm);
				
				if(responsejsondata.resultist == 'one'){
					$('#serese_boxbm').css({'display':'none'});
			  		$('#serese_boxbm_select').css({'display':'block'});
					//$('#parent-store').empty();
					var response = responsejsondata.resdata;
					console.log(response);
                	var imdb_status     = response.imdb_status;
					var name 			= response.name;
					var thumbnail       = response.backdrop_path;
					var genres			= response.genres;
					var tmdb_id 		= response.tmdb_id; 
					if (imdb_status == 'success') { 
						$('#name').val(name);
						$('#tmbd_id').val(tmdb_id);
						if(thumbnail!=""){
                          $('#thumbnail_content').html('<input type="text" name="thumb_link" value="' + thumbnail + '" class="form-control"><img id="thumb_image" src="" width="150" class="img-thumbnail" alt="">');
                          $('#thumb_image').attr('src', thumbnail);
                        }
						var option_part_store = '<option value="">Select a Store</option>';
						
						/*for (val of genres) {
							option_part_store+= '<option value="'+val.id+'">'+val.name+'</option>';
						}
						$('#parent-store').html(option_part_store);*/
					} else if (imdb_status == 'fail') { 
						$('#ssss_gggdd').html('<span style="color:red;font-size: 20px;font-weight: bold;">'+response.error_message+'</span>');
					}
				} 
				else if(responsejsondata.resultist == 'all'){
					var resise_array = responsejsondata.resdata;
					console.log(resise_array);
					
					if(imdb == 'imdb'){
						$serise_list_html = '<div style="width:100%;float:left;padding:20px 0; border-bottom: 2px solid #ccc;">'
												+'<div style="width:40%;float:left;">.</div>'
												+'<div style="width:40%;float:left;">Title</div>'
												+'<div tyle="width:20%;float:left;font-size:18px;font-waight:bold;">Action</div>'
											+'</div>';
						for (val of resise_array) {
						 	// http://image.tmdb.org/t/p/w500//zvZBNNDWd5LcsIBpDhJyCB2MDT7.jpg

							$aaaa = val.first_air_date ? val.first_air_date.split('_') : [];
						 	//$aaaa = val.first_air_date.split('_');
						 	
						 	//$aaa_1 = $aaaa.substr($aaaa.length - 5);
						  	
						  	$serise_list_html+='<div style="width:100%;float:left;padding:20px 0; border-bottom: 1px solid #ccc;">'
												+'<div style="width:40%;float:left;"><img src="'+val.poster_path+'" height="100" width="100"/></div>'
												+'<div style="width:40%;float:left;">'+val.name+'</div>'																							
												+'<div><a href="#" onclick="select_serese(\''+val.tmdb_id+'\',\''+imdb+'\'); return false;" style="width:10%;float:left;font-size:18px;font-waight:bold;color:#45b010;">Add</a></div>'
											+'</div>';
						}
					}else if(tmdb == 'tmdb'){
							$serise_list_html = '<div style="width:100%;float:left;padding:20px 0; border-bottom: 2px solid #ccc;">'
												+'<div style="width:20%;float:left;">.</div>'
												+'<div style="width:20%;float:left;">Title</div>'
												+'<div style="width:30%;float:left;">Release Year</div>'
												+'<div style="width:20%;float:left;">Language</div>'
												+'<div tyle="width:10%;float:left;font-size:18px;font-waight:bold;">Action</div>'
											+'</div>';
							for (val of resise_array) {
						 	// http://image.tmdb.org/t/p/w500//zvZBNNDWd5LcsIBpDhJyCB2MDT7.jpg
						  	$serise_list_html+='<div style="width:100%;float:left;padding:20px 0; border-bottom: 1px solid #ccc;">'
												+'<div style="width:20%;float:left;"><img src="http://image.tmdb.org/t/p/w500'+val.poster_path+'" height="100" width="100"/></div>'
												+'<div style="width:20%;float:left;">'+val.name+'</div>'
												+'<div style="width:30%;float:left;">'+val.first_air_date+'</div>'
												+'<div style="width:20%;float:left;">'+val.original_language+'</div>'
												+'<div><a href="#" onclick="select_serese(\''+val.tmdb_id+'\',\''+tmdb+'\'); return false;" style="width:10%;float:left;font-size:18px;font-waight:bold;color:#45b010;">Add</a></div>'
											+'</div>';
						}
					}
					$('#serese_boxbm').css({'display':'block'});
					$('#serese_boxbm_select').css({'display':'none'});
					$('#tmbm_searchresult').html($serise_list_html);
				}
          }
       });
	 });


		// TV Show Platform Status Toggle Handler
    $('#tv_show_platform_status').change(function() {
        if($(this).is(':checked')) {
            $('.tv-show-platforms-section').slideDown();
            $('#tv_show_platforms').prop('required', true);
        } else {
            $('.tv-show-platforms-section').slideUp();
            $('#tv_show_platforms').prop('required', false);
            $('#tv_show_platforms').val(''); // Reset to No Selection
            $('.tv-show-platforms-error').hide();
        }
    });

    // Form Validation
	$('form').submit(function(e) {
	    if($('#tv_show_platform_status').is(':checked')) {
	        var selectedPlatforms = $('#tv_show_platforms').val();
	        if(!selectedPlatforms || selectedPlatforms.length === 0 || 
	           (selectedPlatforms.length === 1 && selectedPlatforms[0] === '')) {
	            e.preventDefault();
	            $('.tv-show-platforms-error').show();
	            $('#tv_show_platforms').focus();
	            return false;
	        }
	    }
	    $('.tv-show-platforms-error').hide();
	    return true;
	});

    // Initial state check
    if($('#tv_show_platform_status').is(':checked')) {
        $('.tv-show-platforms-section').show();
    }

    // Add language change handler
    $('#language_id').change(function() {
        var languageId = $(this).val();
        updateTvShowPlatforms(languageId);
    });

    function updateTvShowPlatforms(languageId) {
        if(!languageId) return;

        $.ajax({
            type: 'POST',
            url: '<?= BASE_URL ?>tv_show_platforms/getPlatformsByLanguage',
            data: { language_id: languageId },
            success: function(response) {
                var platforms = JSON.parse(response);
                var $platformSelect = $('#tv_show_platforms');
                
                // Store currently selected values
                var selectedValues = $platformSelect.val();
                
                // Clear and rebuild options
                $platformSelect.empty();
                $platformSelect.append('<option value="">--No Selection--</option>');
                
                platforms.forEach(function(platform) {
                    var isSelected = selectedValues && selectedValues.includes(platform.id.toString());
                    $platformSelect.append(
                        $('<option></option>')
                            .val(platform.id)
                            .text(platform.name)
                            .prop('selected', isSelected)
                    );
                });

                // If TV show platform status is enabled but no matching platforms
                if($('#tv_show_platform_status').is(':checked') && platforms.length === 0) {
                    alert('No TV show platforms available for selected language');
                }
            }
        });
    }

    // Trigger on page load if editing
    var initialLanguageId = $('#language_id').val();
    if(initialLanguageId) {
        updateTvShowPlatforms(initialLanguageId);
    }

});	
function select_serese(id, dbselect){
	$.ajax({
          url:"<?php echo base_url(); ?>series/import_series",
          method:"POST",
          data:{id:id,dbselect:dbselect,sall:'one'},
		  beforeSend: function() {
		  	  $('#ssss_ggg').html('');                 		  
          },
          success:function(responsebm){
           		$("#import_btn").html('Fetch');
				var responsejsondata = JSON.parse(responsebm);					
				if(responsejsondata.resultist == 'one'){						
					//$('#parent-store').empty();
					var response = responsejsondata.resdata;
					console.log(response);
                	var imdb_status     = response.imdb_status;
					var name 			= response.name;
					var thumbnail       = response.backdrop_path;
					var genres			= response.genres;
					var selected_store = response.selected_store;
					//var dbselect = response.dbselect;
					//alert(selected_store);
					
					if (imdb_status == 'success') { 
						var messagealert = '';
						$( "#parent-store > option" ).each(function() {
							var parentstore = $(this).val();								
							if(selected_store.includes(parseInt(parentstore))){
								messagealert+= $(this).html()+' , ';
									$(this).remove();
									//alert($(this).html());
							}
							//alert(parentstore);
						});
						if(messagealert != ''){
							$('#message_dataselect').html('<span style="color:red">Series is in store '+messagealert.slice(0, -3)+'. Please select Other.</span>');
						}
					
					
						$('#serese_boxbm').css({'display':'none'});
			  			$('#serese_boxbm_select').css({'display':'block'});
						$('#name').val(name);
						$('#tmbd_id').val(id);
						$('#dbselect').val(dbselect);
						$('#dbidshow').html('<span style="font-weight:bold;font-size:14px;text-transform: uppercase;">'+dbselect+' : </span><span>'+id+'</span>');
						
						if(thumbnail!=""){
                          $('#thumbnail_content').html('<input type="text" name="thumb_link" value="' + thumbnail + '" class="form-control"><img id="thumb_image" src="" width="150" class="img-thumbnail" alt="">');
                          $('#thumb_image').attr('src', thumbnail);
                        }
						/*var option_part_store = '<option value="">Select a Store</option>';
						
						for (val of genres) {
							option_part_store+= '<option value="'+val.id+'">'+val.name+'</option>';
						}
						$('#parent-store').html(option_part_store);*/
					} else if (imdb_status == 'fail') { 
						$('#ssss_ggg').html('<span style="color:red;font-size: 20px;font-weight: bold;">Already Added In all Stores.</span>');
						$('#serese_boxbm').css({'display':'block'});
			  			$('#serese_boxbm_select').css({'display':'none'});	
					}else{
						$('#ssss_ggg').html('<span style="color:red;font-size: 20px;font-weight: bold;">Try Another Time</span>');
						$('#serese_boxbm').css({'display':'block'});
			  			$('#serese_boxbm_select').css({'display':'none'});							
					}
				} 
          }
       });
}
</script>