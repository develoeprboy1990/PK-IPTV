<script type="text/javascript">
$(document).ready(function(){
    $('#movies_old').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,        
        'lengthMenu': [ 50, 100, 200, 500 ],
	    'order': [[0, 'desc']]
      });
	// Replace the existing DataTable initialization in _extra_scripts.php

    // Initialize DataTable
    var moviesTable = $('#movies').DataTable({
        'processing': true,
        'serverSide': true,
        'ajax': {
            'url': '<?php echo base_url("movies/get_movies_data"); ?>',
            'type': 'POST',
            'data': function(data) {
                data.store_filter = $('#store-filter').val();
                data.language_filter = $('#language-filter').val();
            }
        },
        'scrollX': true, // Enable horizontal scrolling
    	'autoWidth': false, // Disable auto-width calculation
        'columns': [
			{ data: 0, width: '40px' }, // ID
			{ data: 1, width: '150px' }, // Name  
			{ data: 2, width: '60px' }, // Poster
			{ data: 3, width: '80px' }, // Backdrop
			{ data: 4, width: '100px' }, // Store
			{ data: 5, width: '180px' }, // Tags
			{ data: 6, width: '180px' }, // Genres
			{ data: 7, width: '180px' }, // OTT Platforms 
			{ data: 8, width: '80px' }, // Language
			{ data: 9, width: '60px' }, // Year
			{ data: 10, width: '180px' }, // Movie Cast
			{ data: 11, width: '100px' }, // Trailer
			{ data: 12, width: '60px' }, // Rating
			{ data: 13, width: '80px' }, // Content Rating
			{ data: 14, width: '80px' }, // Show Home
			{ data: 15, width: '70px' }, // Status
			{ data: 16, width: '70px' }, // User
			{ data: 17, width: '180px' }  // Actions
        ],
        'columnDefs': [
            {
                'targets': [2, 3], // Poster and Backdrop columns
                'orderable': false,
                'searchable': false
            },
            {
                'targets': [3, 9, 10, 11, 13], // Initially hidden columns
                'visible': false
            },
            {
                'targets': 17, // Actions column
                'orderable': false,
                'searchable': false
            }
        ],
        'fixedHeader': true,
        'order': [[0, 'desc']],
        'pageLength': 50,
        'lengthMenu': [50, 100, 200, 500]
    });

    // Column visibility toggle handler
    var columnMap = {
        'store': 4,
        'movie_tag': 5,
        'movie_gen': 6,
        'poster': 2,
        'backdrop': 3,
        'myear': 9,
        'mcast': 10,
        'trailer': 11,
        'language': 8,
        'rating': 12,
        'crating': 13,
        'user_id': 16
    };

    // Handle column visibility toggles
    $('#searchbm_select input[type="checkbox"]').on('change', function() {
        var columnId = $(this).attr('id');
        if (columnMap.hasOwnProperty(columnId)) {
            var columnIndex = columnMap[columnId];
            moviesTable.column(columnIndex).visible(this.checked);
        }
    });

    // Set initial column visibility based on checkboxes
    $('#searchbm_select input[type="checkbox"]').each(function() {
        var columnId = $(this).attr('id');
        if (columnMap.hasOwnProperty(columnId)) {
            var columnIndex = columnMap[columnId];
            moviesTable.column(columnIndex).visible(this.checked);
        }
    });

	//var imdb = $("#imdb:checked").val();
	//var tmdb = $("#tmdb:checked").val();
	//$('#takenBefore')[0].checked
    $('#result').html('');
    $(document).on('click', '#import_btn', function() {
      var from = $("#from").val();
      var id = $("#tmdbid").val();
			var imdb = $("#imdb:checked").val();
			var tmdb = $("#tmdb:checked").val();
		
			var dbselect = '';
			if(imdb == 'imdb'){
				dbselect = 'imdb';
			}else if(tmdb == 'tmdb'){
				dbselect = 'tmdb'
			}
		
			if(imdb == 'imdb' && tmdb == 'tmdb'){
				alert('Please Select One check BOX');
			}else if(imdb == 'imdb' || tmdb == 'tmdb'){
			
				if (from != '' && id != '') {
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url()."movies/import_movie";?>',
						data: "dbselect="+dbselect+"&id=" + encodeURIComponent(id) + "&from=" + encodeURIComponent(from),
					   /* dataType: 'json',*/
						beforeSend: function() {
							$("#import_btn").html('Fetching...');
							$("#result").empty();
							$("#tmbm_searchresult").html("<div style='text-align:center;font-size:20px;font-waight:bold;'>Loading...</div>");
						},
						success: function(responsebm) { 
						//alert(JSON.parse(responsebm));
						var responsejsondata = JSON.parse(responsebm);
						if(responsejsondata.resultist == 'one'){
							$('#movie_boxbm_select').css({'display':'block'});
							$("#movie_boxbm").css({'display':'none'});
							//$('#tmbm_searchresult').html();		
							//var response = JSON.parse(responsebm);
							var response = responsejsondata.resdata;
							var imdb_status     = response.imdb_status;
							var tmdb_id         = response.tmdb_id;
							var title           = response.title;
							var plot            = response.plot;
							var runtime         = response.runtime;                    
							//var country         = JSON.parse("["+response.country+"]");
							//var genre           = JSON.parse("["+response.genre+"]");
							var rating          = response.rating;;
							var release         = new Date(response.release).toString('yyyy');
							var thumbnail       = response.thumbnail;
							var poster          = response.poster;
							
							
							if (imdb_status == 'success') { 
								// actor
								$('#actor').val(response.actor);
								$('#tags').val(response.genre);
								$('#result').html('<div class="alert alert-success alert-dismissable m-t-15"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Data imported successfully.</div>');
								
								
								$("#name").val(title);															   
								$("#settim_id").html(response.tmdb_id);
								$("#tmdb_id").val(response.tmdb_id);
								$("#imported").val('1');
								$("#description").val(response.plot);
								$("#rating").val(rating);
								$("#duration").val(runtime);
								$("#year").val(response.release);								
								if(thumbnail!=""){
								  $('#thumbnail_content').html('<input type="text" name="thumb_link" value="' + thumbnail + '" class="form-control">');
								  $('#thumb_image').attr('src', thumbnail);
								}
								if(poster!=""){
								  $('#poster_content').html('<input type="text" name="poster_link" value="' + poster + '" class="form-control">');
								  $('#poster_image').attr('src', poster);
								}
								$('#import_btn').html('Fetch');                        
							} 
							else if(imdb_status == 'fail') {
								$("#settim_id").html('');
								$('#actor').val('');
								$('#tags').val('');
								$("#name").val('');
								$("#tmdb_id").val('');
								$("#imported").val('');
								$("#description").val('');
								$("#rating").val('');
								$("#duration").val('');
								$("#year").val('');
								$('#thumbnail_content').html('');
								$('#thumb_image').attr('src', '');
								$('#poster_content').html('');
								$('#poster_image').attr('src', '');
								
								$('#result').html('<div class="alert alert-danger alert-dismissable m-t-15"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+response.error_message+'</div>');
								$('#import_btn').html('Fetch');
							}
							else{
								$("#settim_id").html();
								$('#actor').val('');
								$('#tags').val('');
								$("#name").val('');
								$("#tmdb_id").val('');
								$("#imported").val('');
								$("#description").val('');
								$("#rating").val('');
								$("#duration").val('');
								$("#year").val('');
								$('#thumbnail_content').html('');
								$('#thumb_image').attr('src', '');
								$('#poster_content').html('');
								$('#poster_image').attr('src', '');
								$('#result').html('<div class="alert alert-danger alert-dismissable m-t-15"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No data found in database..</div>');
								$('#import_btn').html('Fetch');
							}
						} 
						else if(responsejsondata.resultist == 'all'){
							$('#movie_boxbm_select').css({'display':'none'});
							$("#movie_boxbm").css({'display':'block'});
							$("#resbmbm").empty();
							
							var dbselect = responsejsondata.dbselect;
							
							if(dbselect == 'tmdb'){
							var movie_array = responsejsondata.resdata;
							$mobile_list_html = '<div style="width:100%;float:left;padding:20px 0; border-bottom: 2px solid #ccc;">'
														+'<div style="width:20%;float:left;">.</div>'
														+'<div style="width:20%;float:left;">Title</div>'
														+'<div style="width:30%;float:left;">Release Year</div>'
														+'<div style="width:20%;float:left;">Language</div>'
														+'<div tyle="width:10%;float:left;font-size:18px;font-waight:bold;">Delete</div>'
													+'</div>';
								for (val of movie_array) {
								 // http://image.tmdb.org/t/p/w500//zvZBNNDWd5LcsIBpDhJyCB2MDT7.jpg
								  $mobile_list_html+='<div style="width:100%;float:left;padding:20px 0; border-bottom: 1px solid #ccc;">'
														+'<div style="width:20%;float:left;"><img src="http://image.tmdb.org/t/p/w500'+val.poster_path+'" height="100" width="100"/></div>'
														+'<div style="width:20%;float:left;">'+val.original_title+'</div>'
														+'<div style="width:30%;float:left;">'+val.release_date+'</div>'
														+'<div style="width:20%;float:left;">'+val.original_language+'</div>'
														+'<div class="select_bmclass"><a href="#" id="selectid_'+val.id+'" onclick="select_movie(\''+val.id+'\',\''+dbselect+'\'); return false;" style="float:left;font-size:18px;font-waight:bold;color:#45b010;">Select</a></div>'
													+'</div>';
								}
							$('#movie_boxbm').css({'display':'block'});
							$('#tmbm_searchresult').html($mobile_list_html);
		
						} 
							else if(dbselect == 'imdb'){
									var movie_array = responsejsondata.resdata.results;
									$mobile_list_html = '<div style="width:100%;float:left;padding:20px 0; border-bottom: 2px solid #ccc;">'
															+'<div style="width:20%;float:left;">.</div>'
															+'<div style="width:20%;float:left;">Title</div>'
															+'<div style="width:28%;float:left;margin-left: 2%;">Description</div>'															
															+'<div style="width:28%;float:left;font-size:18px;font-waight:bold;margin-left: 2%;">Action</div>'
														+'</div>';
									for (val of movie_array) { 
									 // http://image.tmdb.org/t/p/w500//zvZBNNDWd5LcsIBpDhJyCB2MDT7.jpg
									  $mobile_list_html+='<div style="width:100%;float:left;padding:20px 0; border-bottom: 1px solid #ccc;">'
															+'<div style="width:20%;float:left;"><img src="'+val.image+'" height="100" width="100"/></div>'
															+'<div style="width:20%;float:left;">'+val.title+'</div>'
															+'<div style="width:28%;float:left;margin-left: 2%;">'+val.description+'</div>'															
															+'<div style="width:28%;float:left;font-size:18px;font-waight:bold;margin-left: 2%;" class="select_bmclass"><a  id="selectid_'+val.id+'"  href="#" onclick="select_movie(\''+val.id+'\',\''+dbselect+'\'); return false;" style="float:left;font-size:18px;font-waight:bold;color:#45b010;">Select</a></div>'
													+'</div>';
									}
								$('#movie_boxbm').css({'display':'block'});
								$('#tmbm_searchresult').html($mobile_list_html);
		
							}
								 $("#import_btn").html('Fetch');
						}
						/**/
							 
							
						}
					});
				} 
				else {
					alert('Please input IMDb/TMDB ID');
				}
						
			} else{
				alert('Please select any check BOX');
			}
    });

    $('#parent-store').change(function(){
			$('#multiselect_right').html('');
	    var parent_id = $('#parent-store').val();
	    if(parent_id != ''){
	         $.ajax({
	            url:"<?php echo base_url(); ?>movie_stores/fetch_sub_stores_and_genres",
	            method:"POST",
	            data:{parent_id:parent_id},
	            dataType: 'JSON',
	            success:function(data){
			  	if(data.stores == 'blank'){
			  		checksubstorebm('1');
	             		$('#sub-store').html('No Sub Store Avaible');
			   }else{
			   		$('#sub-store').html(data.stores);
			   }
	             $('#multiselect_left').html(data.genres);
	            } 
	         });
	        }
	        else{
          $('#sub-store').html('<option value="">Select Sub Store</option>');
        }
    });

    // $('#sub-store').change(function(){ });
    
    var cloneCount = 1;

    $(".add-more").on('click', function(){
        var dd = $('div[id^="box-"]:last');
        var num = parseInt( dd.prop("id").match(/\d+/g), 10 ) +1;
        
        var cloned = $("#box-" + (num-1)).clone(true, true).get(0);
        cloned.id = "box-" + num;                  // Change the div itself.
       
        $(cloned).find("*").each(function(index, element) {   // And all inner elements.
           //console.log(element.labels);
            if(element.id)
            {
                var matches = element.id.match(/(.+)_\d+/);
                if(matches && matches.length >= 2) {           // Captures start at [1].
                    element.id = matches[1] + "_" + num;
                  }
            }
            if(element.name)
            {
                var matches = element.name.match(/(.+)_\d+/);
                if(matches && matches.length >= 2)            // Captures start at [1].
                    element.name = matches[1] + "_" + num;
            }
        });
     

		// Clear input values in the cloned section
		$(cloned).find('input[type="text"]').val('');

		// Reset the verify button
	    $(cloned).find('.verify-url')
	        .attr('data-url-id', 'stream_name_' + num)
	        .removeClass('btn-success btn-danger')
	        .addClass('btn-info')
	        .text('Verify');

	    console.log('Added new verify button with ID:', 'stream_name_' + num);

	    $(cloned).find('.play-url')
	        .attr('data-url-id', 'stream_name_' + num);

		// Clear the url-message div
    	$(cloned).find('.url-message').empty();
		//$(cloned).find('select').prop('selectedIndex', 0);

		$(cloned).appendTo($("#main"));
        $("#count_"+num).html(num);
        $("#movie_url_count").val(num);

      });
      
    $(".glyphicon-remove").click(function () {
        var dd = $('div[id^="box-"]:last');
        var num = parseInt( dd.prop("id").match(/\d+/g), 10 ) -1;
        $("#count_"+num).html(num);
        $("#movie_url_count").val(num);
    
        if(num!=0){
          $(this).parent('div').remove();
          
        }
        else
          alert("Cannot remove this last Movie Url");
      });
		
	$('#imdb').click(function(){
		if($('#imdb').is(':checked')){
			//alert($("#imdb:checked").val());
			$('#tmdb').prop('checked', false); 
			$('#manual').prop('checked', false);
			$('#movie_boxbm_select').css({'display':'none'});
			
			var htmlstring = '<div class="input-group input-group-sm" style="padding-left: 5px;padding-right: 5px;">'
              +'<input type="text" id="tmdbid" name="tmdbid" placeholder="Enter IMDB ID or Name. Ex: 141052 or Jack" required="" class="form-control">'
              +'<span class="input-group-btn">'
                +'<button type="button" class="btn large btn-info btn-flat w-sm waves-effect waves-light" id="import_btn">Fetch</button>'
              +'</span>'
            +'</div>';
			$('#search_boxbm').html(htmlstring);
		} else{
			$('#search_boxbm').html('');
			$('#movie_boxbm_select').css({'display':'none'});
		}
	});

	$('#tmdb').click(function(){
		if($('#tmdb').is(':checked')){
			//alert($("#imdb:checked").val());
			$('#imdb').prop('checked', false);
			$('#manual').prop('checked', false);
			$('#movie_boxbm_select').css({'display':'none'});
			 
			var htmlstring = '<div class="input-group input-group-sm" style="padding-left: 5px;padding-right: 5px;">'
              +'<input type="text" id="tmdbid" name="tmdbid" placeholder="Enter TMDB ID or Name. Ex: 141052 or Jack" required="" class="form-control">'
              +'<span class="input-group-btn">'
                +'<button type="button" class="btn large btn-info btn-flat w-sm waves-effect waves-light" id="import_btn">Fetch</button>'
              +'</span>'
            +'</div>';
			$('#search_boxbm').html(htmlstring);
		} else{
			$('#search_boxbm').html('');
			$('#movie_boxbm_select').css({'display':'none'});
		}
	});
		
	$('#manual').click(function(){
		if($('#manual').is(':checked')){
			$('#imdb').prop('checked', false); 
			$('#tmdb').prop('checked', false); 
			
			$('#search_boxbm').html('');
			$('#movie_boxbm_select').css({'display':'block'});
		} else {
			$('#search_boxbm').html('');
			$('#movie_boxbm_select').css({'display':'none'});
		}
	});
	
	$(document).on('click', '.paginate_button', function() {		
		if($('#backdrop').is(':checked')){
			$('.backdrop_row').css({'display':''});				
		} else{
			$('.backdrop_row').css({'display':'none'});				
		}
		
		if($('#poster').is(':checked')){
			$('.poster_row').css({'display':''});				
		} else{
			$('.poster_row').css({'display':'none'});				
		}
		
		if($('#store').is(':checked')){
			$('.store_row').css({'display':''});				
		} else{
			$('.store_row').css({'display':'none'});
		}
		
		if($('#sub_store').is(':checked')){
			$('.sub_store_row').css({'display':''});				
		} else{
			$('.sub_store_row').css({'display':'none'});				
		}
		
		if($('#myear').is(':checked')){
			$('.myear_row').css({'display':''});				
		} else{
			$('.myear_row').css({'display':'none'});
		}
		
		if($('#mcast').is(':checked')){
			$('.mcast_row').css({'display':''});
		} else{
			$('.mcast_row').css({'display':'none'});
		}
		
		if($('#rating').is(':checked')){
			$('.rating_row').css({'display':''});
		} else{
			$('.rating_row').css({'display':'none'});
		}
		
		if($('#crating').is(':checked')){
			$('.crating_row').css({'display':''});
		} else{
			$('.crating_row').css({'display':'none'});
		}
		
		if($('#language').is(':checked')){
			$('.language_row').css({'display':''});
		} else{
			$('.language_row').css({'display':'none'});
		}
		
		if($('#trailer').is(':checked')){
			$('.trailer_row').css({'display':''});
		} else{
			$('.trailer_row').css({'display':'none'});
		}
		
		if($('#movie_tag').is(':checked')){
			$('.movie_tag_row').css({'display':''});
		} else{
			$('.movie_tag_row').css({'display':'none'});
		}
		
		if($('#movie_gen').is(':checked')){
			$('.movie_gen_row').css({'display':''});
		} else{
			$('.movie_gen_row').css({'display':'none'});
		}

		if($('#user_id').is(':checked')){
			$('.user_id_row').css({'display':''});
		} else{
			$('.user_id_row').css({'display':'none'});
		}
	});
	
	$('#backdrop').click(function(){
		if($('#backdrop').is(':checked')){
			$('.backdrop_row').css({'display':''});				
		} else{
			$('.backdrop_row').css({'display':'none'});				
		}
	});
	
	$('#poster').click(function(){
		if($('#poster').is(':checked')){
			$('.poster_row').css({'display':''});				
		} else{
			$('.poster_row').css({'display':'none'});				
		}
	});
	
	$('#store').click(function(){
		if($('#store').is(':checked')){
			$('.store_row').css({'display':''});				
		} else{
			$('.store_row').css({'display':'none'});				
		}
	});
	
	$('#sub_store').click(function(){
		if($('#sub_store').is(':checked')){
			$('.sub_store_row').css({'display':''});				
		} else{
			$('.sub_store_row').css({'display':'none'});				
		}
	});
	
	$('#myear').click(function(){
		if($('#myear').is(':checked')){
			$('.myear_row').css({'display':''});				
		} else{
			$('.myear_row').css({'display':'none'});
		}
	});
	
	$('#mcast').click(function(){
		if($('#mcast').is(':checked')){
			$('.mcast_row').css({'display':''});
		} else{
			$('.mcast_row').css({'display':'none'});
		}
	});
	
	$('#rating').click(function(){
		if($('#rating').is(':checked')){
			$('.rating_row').css({'display':''});
		} else{
			$('.rating_row').css({'display':'none'});
		}
	});
	
	$('#crating').click(function(){
		if($('#crating').is(':checked')){
			$('.crating_row').css({'display':''});
		} else{
			$('.crating_row').css({'display':'none'});
		}
	});
	
	$('#language').click(function(){
		if($('#language').is(':checked')){
			$('.language_row').css({'display':''});
		} else{
			$('.language_row').css({'display':'none'});
		}
	});
	
	$('#trailer').click(function(){
		if($('#trailer').is(':checked')){
			$('.trailer_row').css({'display':''});
		} else{
			$('.trailer_row').css({'display':'none'});
		}
	});
	
	$('#movie_tag').click(function(){
		if($('#movie_tag').is(':checked')){
			$('.movie_tag_row').css({'display':''});
		} else{
			$('.movie_tag_row').css({'display':'none'});
		}
	});
	
	$('#movie_gen').click(function(){
		if($('#movie_gen').is(':checked')){
			$('.movie_gen_row').css({'display':''});
		} else{
			$('.movie_gen_row').css({'display':'none'});
		}
	});
	
	$('#moviesearch').on( "keyup", function(){
		//$('#movie_search').hide();
		
		var moviesearch_val = $('#moviesearch').val();
		//alert(moviesearch_val);
		if(moviesearch_val == ''){
			$('#movie_pagination').show();
		}else{
			$('#movie_pagination').hide();
		}
		 $.ajax({
                type: 'POST',
                url: '<?php echo base_url()."movies/movieSearch";?>',
                data: {moviesearch_val:moviesearch_val},
				 dataType : 'html',
				/*beforeSend: function() {
						$('#selectid_'+id).html('Please wait...');	
						$('.select_bmclass').css("pointer-events","none");	
				},*/
				success: function(response) { 
					//var response_str = JSON.parse(response);	
					//var response_str = response;	
					//alert(response);
					$('#movie_search').html(response);
					//$('#movie_pagination').html(response_str.pagi_string);
				}
			});
			
	});

	$(document).on('click', '.verify-url', function(e) {
	    e.preventDefault(); // Prevent any default action
	    
	    var $this = $(this);
	    console.log('Clicked button:', this);
	    console.log('Button HTML:', $this.prop('outerHTML'));

	    //var urlType = $this.data('url-type');
	    //var urlId = $this.data('url-id');
	    
	    var urlType = $this.attr('data-url-type');
	    var urlId = $this.attr('data-url-id');
	    
	    console.log('data-url-type attribute:', urlType);
	    console.log('data-url-id attribute:', urlId);
	    
	    verifyUrl(urlType, urlId);
	});
	
	//.play-url
	$(document).on('click', '.play-url', function(e) {
	    e.preventDefault();
	    
	    var $this = $(this);
	    var urlId = $this.attr('data-url-id');
	    var $verifyButton = $this.siblings('.verify-url');
	    
	    // First, trigger verification
	    verifyUrl($verifyButton.attr('data-url-type'), urlId).then(function(result) {
	        if (result.status === 'success') {
	          	var url = result.url_with_token;
	          	showVideoPlayer(url);
	        } 
	    });
	});

	//.play-movie
	$(document).on('click', '.play-movie', function(e) {
	    e.preventDefault();
	    var movieId = $(this).data('movie-id');
	    playMovieInNewTab(movieId);
	    //playMovie(movieId);
	});

	
	if ($('#copyUrlBtn').length) {
		$('#copyUrlBtn').on('click', function() {
			var videoPlayer = document.getElementById('videoPlayer');
			var urlToCopy = videoPlayer.src;

			navigator.clipboard.writeText(urlToCopy).then(function() {
			  //alert('URL copied to clipboard');
			}).catch(function(err) {
			  console.error('Could not copy text: ', err);
			});
		});
	}

	$('#videoSelector').on('change', function() {
	   var videoPlayer = document.getElementById('videoPlayer');
	   videoPlayer.src = this.value;
	   videoPlayer.play();
	});

	// Simple form submission check
	$('form').on('submit', function(e) {
	    // Check URLs
	    let allUrlsVerified = true;
	    $('.verify-url').each(function() {
	        if (!$(this).hasClass('btn-success')) {
	            allUrlsVerified = false;
	            return false;
	        }
	    });

	    // Check poster ratio if a new image was uploaded
	    const posterInput = $('#poster')[0];
	    if (posterInput.files && posterInput.files[0]) {
	        const ratio = $('#poster').attr('data-ratio');
	        if (ratio < 0.5 || ratio > 0.7) {
	            alert('Please ensure the poster image has the correct aspect ratio (between 0.5 and 0.7)');
	            e.preventDefault();
	            return false;
	        }
	    }

	    if (!allUrlsVerified) {
	        alert('Please verify all URLs before submitting the form.');
	        e.preventDefault();
	        return false;
	    }
	});

});
//End of $(document).ready

	//Verify URL
	function verifyUrlXXX(urlType, urlId) {
	    return new Promise(function(resolve, reject) {
	        var serverUrlId = $('#server_url_' + urlId.split('_').pop()).val();
	        var url = $('#' + urlId).val();
	        
	        var $verifyButton = $('[data-url-id="' + urlId + '"].verify-url');    
	        var $messageDiv = $verifyButton.closest('.col-sm-7').find('.url-message');

	        if (!url) {
	            showMessage($messageDiv, 'error', 'Please enter a URL before verifying.');
	            resolve({status: 'error', message: 'No URL provided'});
	            return;
	        }

	        $verifyButton.prop('disabled', true).text('Verifying...');

	        $.ajax({
	            url: '<?php echo base_url("movies/verify_url"); ?>',
	            method: 'POST',
	            data: {
	                url_type: urlType,
	                server_url_id: serverUrlId,
	                url: url
	            },
	            dataType: 'json',
	            success: function(response) {
	                if (response.status === 'success') {
	                    showMessage($messageDiv, 'success', response.message);
	                    $verifyButton.removeClass('btn-info btn-danger').addClass('btn-success').text('Verified');
	                    resolve({
	                        status: 'success', 
	                        message: response.message, 
	                        url_with_token: response.url_with_token  // Add this line
                    	});
	                } else {
	                    showMessage($messageDiv, 'error', response.message);
	                    $verifyButton.removeClass('btn-info btn-success').addClass('btn-danger').text('Verify Failed');
	                    resolve({status: 'error', message: response.message});
	                }
	            },
	            error: function() {
	                showMessage($messageDiv, 'error', 'An error occurred during verification');
	                $verifyButton.removeClass('btn-info btn-success').addClass('btn-danger').text('Verify Failed');
	                resolve({status: 'error', message: 'Verification failed'});
	            },
	            complete: function() {
	                $verifyButton.prop('disabled', false);
	            }
	        });
	    });
	}
	function showMessageXXX($element, type, message) {
	    $element.removeClass('text-success text-danger').addClass(type === 'success' ? 'text-success' : 'text-danger').text(message);
	}

	function showMessage($element, type, message, details = null) {
	    let messageText = message;
	    if (details) {
	        messageText += '<br><small>Format: ' + details.format + 
	                      ' | Size: ' + details.size + 
	                      ' | Type: ' + details.type + '</small>';
	    }
	    $element.removeClass('text-success text-danger')
	            .addClass(type === 'success' ? 'text-success' : 'text-danger')
	            .html(messageText);
	}
	function verifyUrl(urlType, urlId) {
	    return new Promise(function(resolve, reject) {
	        var serverUrlId = $('#server_url_' + urlId.split('_').pop()).val();
	        var url = $('#' + urlId).val();
	        
	        var $verifyButton = $('[data-url-id="' + urlId + '"].verify-url');    
	        var $messageDiv = $verifyButton.closest('.col-sm-7').find('.url-message');

	        if (!url) {
	            showMessage($messageDiv, 'error', 'Please enter a URL before verifying.');
	            resolve({status: 'error', message: 'No URL provided'});
	            return;
	        }

	        $verifyButton.prop('disabled', true).text('Verifying...');

	        $.ajax({
	            url: '<?php echo base_url("movies/verify_url"); ?>',
	            method: 'POST',
	            data: {
	                url_type: urlType,
	                server_url_id: serverUrlId,
	                url: url
	            },
	            dataType: 'json',
	            success: function(response) {
	                if (response.status === 'success') {
	                    showMessage($messageDiv, 'success', response.message, response.video_details);
	                    $verifyButton.removeClass('btn-info btn-danger')
	                               .addClass('btn-success')
	                               .text('Verified');
	                    resolve({
	                        status: 'success',
	                        message: response.message,
	                        url_with_token: response.url_with_token
	                    });
	                } else {
	                    showMessage($messageDiv, 'error', response.message);
	                    $verifyButton.removeClass('btn-info btn-success')
	                               .addClass('btn-danger')
	                               .text('Verify Failed');
	                    resolve({status: 'error', message: response.message});
	                }
	            },
	            error: function() {
	                showMessage($messageDiv, 'error', 'An error occurred during verification');
	                $verifyButton.removeClass('btn-info btn-success')
	                           .addClass('btn-danger')
	                           .text('Verify Failed');
	                resolve({status: 'error', message: 'Verification failed'});
	            },
	            complete: function() {
	                $verifyButton.prop('disabled', false);
	            }
	        });
	    });
	}


	function showVideoPlayer(url) {
		//open in new tab
        window.open(url, '_blank', 'noopener,noreferrer');
        /*var videoPlayer = document.getElementById('videoPlayer');
        videoPlayer.src = url;
        $('#videoPlayerModal').modal('show');
        videoPlayer.play();

        $('#videoPlayerModal').on('hidden.bs.modal', function () {
            videoPlayer.pause();
        });*/
    }

	//.play-movie
	function playMovieInNewTab(movieId) {
	    $.ajax({
	        url: '<?php echo base_url("movies/get_movie_urls"); ?>',
	        method: 'POST',
	        data: { movie_id: movieId },
	        dataType: 'json',
	        success: function(response) {
	            if (response.status === 'success' && response.movie_urls && response.movie_urls.length > 0) {
	                verifyAndOpenUrl(response.movie_urls[0].url);
	            } else {
	                alert('Error getting movie URL: ' + response.message);
	            }
	        },
	        error: function() {
	            alert('An error occurred while getting the movie URL.');
	        }
	    });
	}

	function verifyAndOpenUrl(movieUrl) {
	    $.ajax({
	        url: '<?php echo base_url("movies/verify_url"); ?>',
	        method: 'POST',
	        data: {
	            url_type: 'movie',
	            url: movieUrl
	        },
	        dataType: 'json',
	        success: function(response) {
	            if (response.status === 'success') {
	                window.open(response.url_with_token, '_blank', 'noopener,noreferrer');
	            } else {
	                alert('Error verifying movie URL.');
	            }
	        },
	        error: function() {
	            alert('An error occurred during URL verification.');
	        }
	    });
	}
	function playMovie(movieId) {
	  $.ajax({
	    url: '<?php echo base_url("movies/get_movie_urls"); ?>',
	    method: 'POST',
	    data: { movie_id: movieId },
	    dataType: 'json',
	    success: function(response) {
	      if (response.status === 'success') {
	        verifyAndPlayUrls(response.trailer_url, response.movie_urls);
	      } else {
	        alert('Error getting movie URLs: ' + response.message);
	      }
	    },
	    error: function() {
	      alert('An error occurred while getting the movie URLs.');
	    }
	  });
	}
	function verifyAndPlayUrls(trailerUrl, movieUrls) {
	  var allUrls = [{ url: trailerUrl, type: 'trailer' }].concat(movieUrls.map(function(movie) {
	    return { url: movie.url, type: 'movie', language: movie.language };
	  }));

	  var verificationPromises = allUrls.map(function(urlObj) {
	    return $.ajax({
	      url: '<?php echo base_url("movies/verify_url"); ?>',
	      method: 'POST',
	      data: {
	        url_type: urlObj.type,
	        url: urlObj.url
	      },
	      dataType: 'json'
	    });
	  });

	  Promise.all(verificationPromises).then(function(results) {
	    var verifiedUrls = results.filter(function(result) {
	      return result.status === 'success';
	    }).map(function(result, index) {
	      return {
	        url: result.url_with_token,
	        type: allUrls[index].type,
	        language: allUrls[index].language
	      };
	    });

	    if (verifiedUrls.length > 0) {
	      showVideoPlayerMain(verifiedUrls);
	    } else {
	      alert('No valid URLs found for this movie.');
	    }
	  }).catch(function(error) {
	    alert('An error occurred during URL verification: ' + error);
	  });
	}
	function showVideoPlayerMain(urls) {
	  var videoPlayer = document.getElementById('videoPlayer');
	  var videoSelector = document.getElementById('videoSelector');

	  // Clear previous options
	  videoSelector.innerHTML = '<option value="">Select Video</option>';

	  // Add new options
	  urls.forEach(function(urlObj) {
	    var option = document.createElement('option');
	    option.value = urlObj.url;
	    option.textContent = urlObj.type.charAt(0).toUpperCase() + urlObj.type.slice(1) + 
	                         (urlObj.language ? ' (' + urlObj.language + ')' : '');
	    videoSelector.appendChild(option);
	  });

	  // Set the first URL as the initial video
	  videoPlayer.src = urls[0].url;

	  $('#videoPlayerModal').modal('show');
	  videoPlayer.play();

	  $('#videoPlayerModal').on('hidden.bs.modal', function () {
	    videoPlayer.pause();
	  });
	}

	function list_image_select(id){
		var img_select = $('#list_img_'+id).attr('alt');
		var selected_image = $('#poster_image').attr('src');
		$('#poster_image').attr('src', img_select);
		$('#list_img_'+id).attr('alt',selected_image);
		$('#list_img_'+id).attr('src',selected_image);
		$('#poster_link').val(img_select);
		//alert(img_select);
	}
	function list_image_select_edit(id){
		var poster_link = $('#poster_link').val();
		//alert(poster_link);
		if(!poster_link){
		$('#poster_content').html('<input style="width: 48%;" type="text" id="poster_link" name="poster_link" value="" class="form-control">');
		}
		var img_select = $('#list_img_'+id).attr('alt');
		var selected_image = $('#poster_image').attr('src');
		$('#poster_image').attr('src', img_select);
		$('#list_img_'+id).attr('alt',selected_image);
		$('#list_img_'+id).attr('src',selected_image);
		$('#poster_link').val(img_select);

		var poster_link = $('#poster_link').val();
		if(poster_link == ''){
		$('#poster_content').html('<input style="width: 48%;" type="text" id="poster_link" name="poster_link" value="' + poster + '" class="form-control">');
		}

		}
	function showImg(input) {
		//new validate function
		validatePosterDimensions(input);
		if (input.files && input.files[0]) {
		  	var reader = new FileReader();
		  	reader.onload = function(e) {
		    $('#thumb_image').attr('src', e.target.result)
		  };
		reader.readAsDataURL(input.files[0]);
		$('#poster_remote').val('');
		}
	}
	function showImg2(input) {
		if (input.files && input.files[0]) {
		    var reader = new FileReader();
		    reader.onload = function(e) {
		        $('#poster_image').attr('src', e.target.result)
		    };
		    reader.readAsDataURL(input.files[0]);
			$('#backdrop_remote').val('');
		}
	}
	function select_movie(id, dbselect){ 
		//$('#movie_boxbm_select').css({'display':'block'});
		//$('#movie_boxbm').css({'display':'none'});

		$.ajax({
		    type: 'POST',
		    url: '<?php echo base_url()."movies/import_movieselect";?>',
		    data: "chooseselect=one&dbselect="+dbselect+"&id=" + encodeURIComponent(id),
			beforeSend: function() {
				$('#selectid_'+id).html('Please wait...');	
				$('.select_bmclass').css("pointer-events","none");	
			},
			success: function(response) { 
				var responsejsondata 	= JSON.parse(response);
				console.log(responsejsondata);						
				var response 			= responsejsondata.resdata;
				var imdb_status     	= response.imdb_status;
				var tmdb_id         	= response.tmdb_id;
				var title           	= response.title;
				var plot            	= response.plot;
				var runtime         	= response.runtime;
				var rating          	= response.rating;
				var release         	= new Date(response.release).toString('yyyy');
				var thumbnail       	= response.thumbnail;
				var poster          	= response.poster;						
				var dbselect        	= response.dbselect;
				var age_rating			= response.age_rating;
				var selected_store_substore			= response.selected_store_substore;
				var selected_store = response.selected_store;
				//alert(selected_store);
					
				$( "#parent-store > option" ).each(function() {
					var parentstore = $(this).val();
					//alert($(this).html());
					if(parseInt(parentstore) == parseInt(selected_store)){
					$('#message_dataselect').html('<span style="color:red">Movie is already in store '+$(this).html()+' ('+selected_store_substore+ '). Please select Other.</span>');
						//$(this).remove();
					}
					//alert(parentstore);
				});

		        if (imdb_status == 'success') { 
					$('#movie_boxbm_select').css({'display':'block'});
					$("#movie_boxbm").css({'display':'none'});
					$('#settim_id_label').html(dbselect.toUpperCase()+' ID : ');
					//alert(response.genre);
					if(dbselect == 'tmdb'){
						var tagsbm = response.genre;
						var tagArr = tagsbm.split(',');
						//const actionbm = [];
						var taglistbm = '';
						var textValbm = '';
						$ccc = 0;
						$('#tags option').each(function(i, sel){ 
							textValbm = $(this).text();
							for (val of tagArr) {
								if(textValbm.trim() == val.trim()){
										$(this).attr('selected',true);
										$(this).css({'background-color' : '#ccc'});
										$ccc = i+1;
										if(taglistbm == ''){
											taglistbm+=$ccc;
										}else{
											taglistbm+=','+$ccc;
										}
								}
							}		
							
						});
					}
					if(dbselect == 'imdb'){
						//Animation, Action, Adventure
						var list_images	= response.list_image;
						var tagsbm = response.tags;
						var tagArr = tagsbm.split(',')
						const actionbm = [];
						var taglistbm = '';
						var textValbm = '';
						$ccc = 0;
						$('#tags option').each(function(i, sel){ 
							textValbm = $(this).text();
							for (val of tagArr) {
								if(textValbm.trim() == val.trim()){
										$(this).attr('selected',true);
										$(this).css({'background-color' : '#ccc'});
										$ccc = i+1;
										if(taglistbm == ''){
											taglistbm+=$ccc;
										}else{
											taglistbm+=','+$ccc;
										}
								}
							}		
							
						});
						
						
					   	var list_images_string = '';
					   	var lc = 0
					   	if(list_images != null){
						   	for (val of list_images) {
						   		list_images_string+= '<div style="float:left;cursor: pointer;margin-top: 5px;" onclick="list_image_select('+lc+');"><img id="list_img_'+lc+'" src="'+val+'" alt="'+val+'" width="200" class="img-thumbnail" /></div>';
								lc++;
						   	}	
						}
					   $('#list_images').html(list_images_string);
					   
					}
				    $("#settim_id").html(response.tmdb_id);
					$('#tag_bm').val(taglistbm);
	                // actor
	                $('#actor').val(response.actor);
	                $('#tags').val(response.genre);
	                $('#resbmbm').html('<div class="alert alert-success alert-dismissable m-t-15">Data imported successfully.</div>');
					
					$('#dbselect').val(dbselect);
					$('#age_rating').val(age_rating);
	                $("#name").val(title);                           
	                     
                  	$("#tmdb_id").val(response.tmdb_id);
                  	$("#imported").val('1');
                  	$("#description").val(response.plot);
                  	$("#rating").val(rating);
                  	$("#duration").val(runtime);
                  	$("#year").val(response.release);
		                     
					  
					   
					if(thumbnail!=""){
						$('#thumbnail_content').html('<input type="text" name="thumb_link" value="' + thumbnail + '" class="form-control">');
						$('#thumb_image').attr('src', thumbnail);
					}
                  	if(poster!=""){
                    	$('#poster_content').html('<input style="width: 48%;" type="text" id="poster_link" name="poster_link" value="' + poster + '" class="form-control">');
                    	$('#poster_image').attr('src', poster);
                  	}
		            $('#import_btn').html('Fetch');                        
		        }
		        else if(imdb_status == 'fail') {
					$('#movie_boxbm_select').css({'display':'none'});
					$("#movie_boxbm").css({'display':'block'});
					$("#settim_id").html('');
					$('#actor').val('');
					$('#tags').val('');
					$("#name").val('');
					$("#tmdb_id").val('');
					$("#imported").val('');
					$("#description").val('');
					$("#rating").val('');
					$("#duration").val('');
					$("#year").val('');
					$('#thumbnail_content').html('');
					$('#thumb_image').attr('src', '');
					$('#poster_content').html('');
					$('#poster_image').attr('src', '');
					$('#result').html('<div class="alert alert-danger alert-dismissable m-t-15"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+response.error_message+'</div>');
					$('#import_btn').html('Fetch');
		        }
		        else{
					$('#movie_boxbm_select').css({'display':'none'});
					$("#movie_boxbm").css({'display':'block'});
					$("#settim_id").html();
					$('#actor').val('');
					$('#tags').val('');
					$("#name").val('');
					$("#tmdb_id").val('');
					$("#imported").val('');
					$("#description").val('');
					$("#rating").val('');
					$("#duration").val('');
					$("#year").val('');
					$('#thumbnail_content').html('');
					$('#thumb_image').attr('src', '');
					$('#poster_content').html('');
					$('#poster_image').attr('src', '');
					$('#result').html('<div class="alert alert-danger alert-dismissable m-t-15"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No data found in database..</div>');
					$('#import_btn').html('Fetch');
		        }
				
			}
		});		
	}
	function update_select_movie(id, dbselect){
		$.ajax({
		              type: 'POST',
		              url: '<?php echo base_url()."movies/edit_import_movieselect";?>',
		              data: "dbselect="+dbselect+"&id=" + encodeURIComponent(id),
				success: function(responsebm) { 
					var response = JSON.parse(responsebm);
		                  var imdb_status     = response.imdb_status;
		                  var tmdb_id         = response.tmdb_id;
		                  var title           = response.title;
		                  var plot            = response.plot;
		                  var runtime         = response.runtime; 
		                  var rating          = response.rating;;
		                  var release         = new Date(response.release).toString('yyyy');
		                  var thumbnail       = response.thumbnail;
		                  var poster          = response.poster;
					
					 	$('#title').val(title);						    
		                      // actor
		                      $('#actor').val(response.actor);
		                      $('#tags').val(response.genre);
		                      /*$('#result').html('<div class="alert alert-success alert-dismissable m-t-15"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Data imported successfully.</div>');*/
						/*$("#thumb_image").attr("src", "http://image.tmdb.org/t/p/w500"+response.thumbnail);
						$("#poster_image").attr("src", "http://image.tmdb.org/t/p/w500"+response.poster);
						$("#poster_remote").val(response.thumbnail);
						$("#backdrop_remote").val(response.poster);*/
						
		                      $("#name").val(title);                                                      
		                      //$("#tmdb_id").val(response.tmdb_id);
		                      $("#imported").val('1');
		                      $("#description").val(response.plot);
		                      $("#rating").val(rating);
		                      $("#duration").val(runtime);
		                      $("#year").val(response.release); 
						                     
		                      if(thumbnail!=""){
		                        $('#thumbnail_content').html('<input type="text" name="thumb_link" value="' + thumbnail + '" class="form-control">');
		                        $('#thumb_image').attr('src', thumbnail);
		                      }
		                      if(poster!=""){
		                        $('#poster_content').html('<input type="text" name="poster_link" value="' + poster + '" class="form-control">');
		                        $('#poster_image').attr('src', poster);
		                      }
						
						if(dbselect == 'tmdb'){
						var tagsbm = response.genre;
						var tagArr = tagsbm.split(',');
						//const actionbm = [];
						var taglistbm = '';
						var textValbm = '';
						$ccc = 0;
						$('#tags option').each(function(i, sel){ 
							textValbm = $(this).text();
							for (val of tagArr) {
								if(textValbm.trim() == val.trim()){
										$(this).attr('selected',true);
										$(this).css({'background-color' : '#ccc'});
										$ccc = i+1;
										if(taglistbm == ''){
											taglistbm+=$ccc;
										}else{
											taglistbm+=','+$ccc;
										}
								}
							}		
							
						});
					}
						if(dbselect == 'imdb'){
						//Animation, Action, Adventure
						var list_images	= response.list_image;
						var tagsbm = response.genre;
						var tagArr = tagsbm.split(',')
						const actionbm = [];
						var taglistbm = '';
						var textValbm = '';
						$ccc = 0;
						$('#tags option').each(function(i, sel){ 
							textValbm = $(this).text();
							for (val of tagArr) {
								if(textValbm.trim() == val.trim()){
										$(this).attr('selected',true);
										$(this).css({'background-color' : '#ccc'});
										$ccc = i+1;
										if(taglistbm == ''){
											taglistbm+=$ccc;
										}else{
											taglistbm+=','+$ccc;
										}
								}
							}		
							
						});
						
						
					   var list_images_string = '';
					   var lc = 0
					   for (val of list_images) {
					   		list_images_string+= '<div style="float:left;cursor: pointer;margin-top: 5px;" onclick="list_image_select('+lc+');"><img id="list_img_'+lc+'" src="'+val+'" alt="'+val+'" width="200" class="img-thumbnail" /></div>';
							lc++;
					   }
					   $('#list_images').html(list_images_string);
					   
					}
		                                     
		                  
				}
		});
	}
	function checksubstorebm(store_id){ 
	//alert(store_id);
		  //  var store_id = $('#sub-store').val();
		var anyvalchecked = '';
			
		$("#sub-store input[type=checkbox]:checked").each(function () {
		        anyvalchecked = 'checked';
		  });
		  
		// alert($(this).val());
		$('#multiselect_right').html('');
		$('#multiselect_left').html('');
		/*if(anyvalchecked == 'checked') {*/
		//alert(dbselect);
		     $.ajax({
		        url:"<?php echo base_url(); ?>movie_stores/fetch_genres",
		        method:"POST",
		        data:{store_id:store_id},
		        success:function(data){
		  $('#multiselect_left').html(data);
		  
		  var dbselect = $('#dbselect').val();
		  //alert(dbselect);
		 	 if(dbselect == 'imdb'){
					  var tag_bm = $('#tag_bm').val();
					  //alert(tag_bm);
					  var tagArr = tag_bm.split(',');
					  var textValbm = '';
					  var valValbm = '';
					  var textValbm_mul = '';
					  
					  const selected_gen = [];
					  var c =0;
					 // cars[0]= "Saab";
					  var mulselect_bm = '';
					  $('#tags option').each(function(i, sel){ 
							valValbm = $(this).val();
							//alert(valValbm);
							for (val of tagArr) {
								if(valValbm.trim() == val.trim()){
									//textValbm = 
									selected_gen[c] = $(this).text();
									c++;
								}
							}			
											
						});
					  $('#multiselect_left option').each(function(i, sel){ 
							textValbm_mul = $(this).text();
							//$('#multiselect_right').html('');
								for (val of selected_gen) {
									if(textValbm_mul.trim() == val.trim()){
										$('#multiselect_right').append('<option value="'+$(this).val()+'">'+$(this).text()+'</option>');
										$(this).css({'display': 'none'});
										
										if(mulselect_bm == ''){
											mulselect_bm+= $(this).val();
										} else{
											mulselect_bm+= ','+$(this).val();
										}
									}
								}
										
						});
					   $('#genres_bm').val(mulselect_bm);
		   		}else if(dbselect == 'tmdb'){
					  var tag_bm = $('#tag_bm').val();
					  //alert(tag_bm);
					  var tagArr = tag_bm.split(',');
					  var textValbm = '';
					  var valValbm = '';
					  var textValbm_mul = '';
					  
					  const selected_gen = [];
					  var c =0;
					 // cars[0]= "Saab";
					  var mulselect_bm = '';
					  $('#tags option').each(function(i, sel){ 
							valValbm = $(this).val();
							//alert(valValbm);
							for (val of tagArr) {
								if(valValbm.trim() == val.trim()){
									//textValbm = 
									selected_gen[c] = $(this).text();
									c++;
								}
							}			
											
						});
					  $('#multiselect_left option').each(function(i, sel){ 
							textValbm_mul = $(this).text();								
								for (val of selected_gen) {
									if(textValbm_mul.trim() == val.trim()){
										$('#multiselect_right').append('<option value="'+$(this).val()+'">'+$(this).text()+'</option>');
										$(this).css({'display': 'none'});
										
										if(mulselect_bm == ''){
											mulselect_bm+= $(this).val();
										} else{
											mulselect_bm+= ','+$(this).val();
										}
									}
								}
										
						});
					   $('#genres_bm').val(mulselect_bm);
		   		}
		        } 
		     });
		    /* 
		}else{
		      $('#multiselect_left').html('');
		    }*/
	}
	function showsearchoption(){
		if($('#searchbm_select').is(':hidden')){
		$('#searchbm_select').show('slow');
		$('#showsearchoptionbm').html('View Details &darr;');
		}else{
		$('#searchbm_select').hide('slow');
		$('#showsearchoptionbm').html('View Details &uarr;');
		}
	}
	function validatePosterDimensions(input) {
	    if (input.files && input.files[0]) {
	        const reader = new FileReader();
	        reader.onload = function(e) {
	            const img = new Image();
	            img.onload = function() {
	                const ratio = this.width / this.height;
	                const warningElement = $('#poster-ratio-warning');
	                
	                // Store the ratio for form submission check
	                $('#poster').attr('data-ratio', ratio);
	                
	                if (ratio < 0.5 || ratio > 0.7) {
	                    if (warningElement.length === 0) {
	                        $('#poster').after('<div id="poster-ratio-warning" class="alert alert-warning">' +
	                            'Warning: Image ratio should be between 0.5 and 0.7 (portrait orientation). ' +
	                            'Current ratio: ' + ratio.toFixed(3) + ' (' + this.width + 'x' + this.height + ')' +
	                            '</div>');
	                    }
	                } else {
	                    warningElement.remove();
	                }
	            };
	            img.src = e.target.result;
	        };
	        reader.readAsDataURL(input.files[0]);
	    }
	}
</script>