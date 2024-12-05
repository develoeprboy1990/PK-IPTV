<script type="text/javascript">
    $(document).ready(function(){

        $('#episodes').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,
          'lengthMenu': [ 50, 100, 200, 500 ]
        });

		$('#episodeshow').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,
          'lengthMenu': [ 10, 20, 30, 40, 50, 60, 70, 80, 90, 100 ]
        });

        // For index.php
        $(document).on('click', '.play-url', function(e) {
            e.preventDefault();
            var $this = $(this);
            var url = $this.data('url');
            var serverUrlId = $this.data('server-url-id');
            var title = $this.data('title');
            verifyAndPlayIndex(url, serverUrlId, title, $this);
            //playUrl(url, serverUrlId, title);
        });
        // For edit.php
        $(document).on('click', '.verify-url', function(e) {
		    e.preventDefault();
		    var $this = $(this);
		    var urlType = $this.attr('data-url-type');
		    var urlId = $this.attr('data-url-id');
		    console.log('Clicked button:', this);
		    console.log('Button HTML:', $this.prop('outerHTML'));
		    console.log('data-url-type attribute:', urlType);
		    console.log('data-url-id attribute:', urlId);
		    verifyUrl(urlType, urlId, $this);
		});
		$(document).on('click', '.play-url-edit', function(e) {
            e.preventDefault();
            var $this = $(this);
            var urlType = $this.attr('data-url-type');
            var urlId = $this.attr('data-url-id');
            //playUrlEdit(urlType, urlId);
            verifyAndPlay(urlType, urlId);
        });
        $('form').on('submit', function(e) {
		    var allVerified = true;
		    $('.verify-url').each(function() {
		        if (!$(this).hasClass('btn-success')) {
		            allVerified = false;
		            return false;
		        }
		    });
		    if (!allVerified) {
		        e.preventDefault();
		        alert('Please verify all URLs before submitting the form.');
		    }
		});

        if ($('#copyUrlBtn').length) {
			$('#copyUrlBtn').on('click', function() {
			    var videoPlayer = document.getElementById('videoPlayer');
			    var urlToCopy = videoPlayer.src;

			    navigator.clipboard.writeText(urlToCopy).then(function() {
			       // alert('URL copied to clipboard');
			    }).catch(function(err) {
			        console.error('Could not copy text: ', err);
			    });
			});
		}
        
    });

    // In _extra_scripts.php

	function verifyAndPlayIndex(url, serverUrlId, title) {
	    $.ajax({
	        url: '<?php echo base_url("episodes/verify_url"); ?>',
	        method: 'POST',
	        data: {
	            url_type: 'episode',
	            server_url_id: serverUrlId,
	            url: url
	        },
	        dataType: 'json',
	        success: function(response) {
	            if (response.status === 'success') {
	                playVideo(response.url_with_token);
	            } else {
	                alert('Verification failed: ' + response.message);
	            }
	        },
	        error: function() {
	            alert('An error occurred during verification');
	        }
	    });
	}


    // For edit.php
	function verifyUrl(urlType, urlId, $button) {
	    console.log('verifyUrl called with:', urlType, urlId);
	    
	    var serverUrlId = $('#server_url_id').val();
	    var url = $('#' + urlId).val();
	    
	    console.log('server_url_id:', serverUrlId);
	    console.log('url:', url);

	    var $messageDiv = $button.closest('.col-sm-7').find('.url-message');

	    // Check if URL is empty
	    if (!url) {
	        showMessage($messageDiv, 'error', 'Please enter a URL before verifying.');
	        return;
	    }

	    $button.prop('disabled', true).text('Verifying...');

	    $.ajax({
	        url: '<?php echo base_url("episodes/verify_url"); ?>',
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
	                $button.removeClass('btn-info btn-danger').addClass('btn-success').text('Verified');
	            } else {
	                showMessage($messageDiv, 'error', response.message);
	                $button.removeClass('btn-info btn-success').addClass('btn-danger').text('Verify Failed');
	            }
	        },
	        error: function() {
	            showMessage($messageDiv, 'error', 'An error occurred during verification');
	            $button.removeClass('btn-info btn-success').addClass('btn-danger').text('Verify Failed');
	        },
	        complete: function() {
	            $button.prop('disabled', false);
	        }
	    });
	}
	function showMessage($element, type, message) {
	    $element.removeClass('text-success text-danger').addClass(type === 'success' ? 'text-success' : 'text-danger').text(message);
	}
	function verifyAndPlay(urlType, urlId) {
	    var serverUrlId = $('#server_url_id').val();
	    var url = $('#' + urlId).val();

	    $.ajax({
	        url: '<?php echo base_url("episodes/verify_url"); ?>',
	        method: 'POST',
	        data: {
	            url_type: urlType,
	            server_url_id: serverUrlId,
	            url: url
	        },
	        dataType: 'json',
	        success: function(response) {
	            if (response.status === 'success') {
	                playVideo(response.url_with_token);
	            } else {
	                alert('Verification failed: ' + response.message);
	            }
	        },
	        error: function() {
	            alert('An error occurred during verification');
	        }
	    });
	}


	function playVideo(url) {
	    var videoPlayer = document.getElementById('videoPlayer');
	    videoPlayer.src = url;
	    $('#videoPlayerModal').modal('show');
	    videoPlayer.play();

	    $('#videoPlayerModal').on('hidden.bs.modal', function () {
            videoPlayer.pause();
        });
	}



	function select_episodes(tmbd_idbm,sesice_id,episode_number,season_number,series_id,dbselect){ 
		var urlvalue =  $('#episodes_'+tmbd_idbm+'_'+sesice_id+'_'+episode_number).val();
		var server_url_id = $('#server_url_'+tmbd_idbm+'_'+sesice_id+'_'+episode_number).val();
		//var token_id = $('#token_'+tmbd_idbm+'_'+sesice_id+'_'+episode_number).val();
		$('.bminbox').css({'border':'1px solid #d2d6de'});
		//alert(urlvalue);
		$('#msgggg').empty();
		if(server_url_id == ''){	
			$('#server_url_'+tmbd_idbm+'_'+sesice_id+'_'+episode_number).css({'border':'1px solid red'});
		} /*else if(token_id == ''){
			$('#token_'+tmbd_idbm+'_'+sesice_id+'_'+episode_number).css({'border':'1px solid red'});
		}*/else if(urlvalue == ''){
			$('#episodes_'+tmbd_idbm+'_'+sesice_id+'_'+episode_number).css({'border':'1px solid red'});			
		}else {
			$.ajax({
				  url:"<?php echo base_url(); ?>episodes/add_episodes",
				  method:"POST",
				  data:{ tmbd_idbm: tmbd_idbm, sesice_id:sesice_id, episode_number:episode_number,season_number:season_number,urlvalue:urlvalue,server_url : server_url_id,series_id,dbselect:dbselect},
				  beforeSend: function() {
					 
					  
				  },
				  success:function(response){
					var responsejsondata = JSON.parse(response);
					//alert(responsejsondata);
				//
					if(responsejsondata.status == 'success'){
						$('#msgggg').append('Add Success');
						
						//$('#episodesdiv_'+tmbd_idbm+'_'+sesice_id+'_'+episode_number).css({'display':'none'});
						$('#episodesdiv_'+tmbd_idbm+'_'+sesice_id+'_'+episode_number).empty();
						//window.location.href = "<?php echo base_url(); ?>series_seasons/episodes/"+sesice_id;
					}else{
						alert(responsejsondata.status);
					}
				  }
				  
				  });
			  
		}
	}
	
	function setepisode_url(){
		var user_episode_url = $('#user_episode_url').val().split("\n");
		var c = 0;
		$( ".episodeurlbm" ).each(function() {
				var parentstore = $(this).val(user_episode_url[c]);
				//alert(parentstore);
				c++;
							
		});
		 $('#user_episode_url').val('');
	}
	
	function showImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#thumb_image')
                    .attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
	
	function showManually(){
		$('#msgggg').toggle();
		$('#episodeshow_wrapper').toggle();
		$('#manully_add').toggle();
		$('#set_episode_url').toggle();
		
		$('#manully_text').toggle();
		$('#imdbtmdb_text').toggle();
	}
	
	function addallepisove(){
		var all_episode_json = $('#all_episode_json').val();
		var responsejsondata = JSON.parse(all_episode_json);
		var tmbd_idbm = '';
		var sesice_id = '';
		var episode_number = '';
		var season_number = '';
		var urlvalue = '';
		var server_url_id = '';
		var series_id = '';
		var dbselect = '';
		//alert(responsejsondata[0].tmbd_idbm);
		//responsejsondata.length
		var dataaddcounter = 0;
		if(responsejsondata.length > 10){
			dataaddcounter = 10;
		} else{
			dataaddcounter = responsejsondata.length;
		}
		var ajaxcounter = 1;
		for(var i=0; i< dataaddcounter; i++){
			//select_episodes(responsejsondata[1].tmbd_idbm, responsejsondata[1].season_id, responsejsondata[1].episode_number, responsejsondata[i].season_number);
			tmbd_idbm = responsejsondata[i].tmbd_idbm;
			sesice_id = responsejsondata[i].season_id;
			episode_number = responsejsondata[i].episode_number;
			season_number =  responsejsondata[i].season_number;
			series_id = responsejsondata[i].series_id;
			dbselect =  responsejsondata[i].dbselect;
			urlvalue = $('#episodes_'+tmbd_idbm+'_'+sesice_id+'_'+episode_number).val();
			server_url_id = $('#server_url_'+tmbd_idbm+'_'+sesice_id+'_'+episode_number).val();
					
			if(urlvalue == ''){			
			}else {
			$.ajax({
				  url:"<?php echo base_url(); ?>episodes/add_episodes_all",
				  method:"POST",
				  data:{ tmbd_idbm: tmbd_idbm, sesice_id:sesice_id, episode_number:episode_number,season_number:season_number,series_id:series_id, urlvalue:urlvalue,server_url : server_url_id, dbselect : dbselect},
				  beforeSend: function() {
					 
					  
				  },
				  success:function(response){
					var responsejsondata = JSON.parse(response);
				
					if(responsejsondata.status == 'success'){
						$('#msgggg').html(ajaxcounter+' Episode Added');
						//$('#episodesdiv_'+responsejsondata.tmbd_idbm+'_'+responsejsondata.id+'_'+responsejsondata.episode_number).css({'display':'none'});
						$('#episodesdiv_'+responsejsondata.tmbd_idbm+'_'+responsejsondata.id+'_'+responsejsondata.episode_number).empty();
						//window.location.href = "<?php echo base_url(); ?>series_seasons/episodes/"+sesice_id;
						ajaxcounter++;
						//alert('#episodesdiv_'+tmbd_idbm+'_'+sesice_id+'_'+episode_number);
						if(ajaxcounter == dataaddcounter){
							location.href = window.location.href;
						}
					}else{
						//alert(responsejsondata.status);
					}
				  }
				  
				  });
			  
		}
		}
		
	}
 </script>