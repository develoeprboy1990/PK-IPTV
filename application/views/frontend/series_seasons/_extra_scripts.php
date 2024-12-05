<script type="text/javascript">
    $(document).ready(function(){
        $('#seasons').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,
          'lengthMenu': [ 50, 100, 200, 500 ]
        });


$('#episode_update').click(function(){
	$('#days_select').toggle();
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
	}
});


        $('#result').html('');
        $(document).on('click', '#import_btn', function() {
            var from = $("#from").val();
            var id = $("#tmdbid").val();
            if (from != '' && id != '') {
                $.ajax({
                    type: 'POST', 
                    url: '<?php echo base_url()."series_seasons/import_season";?>',
                    data: "id=" + encodeURIComponent(id) + "&from=" + encodeURIComponent(from),
                    dataType: 'json',
                    beforeSend: function() {
                        $("#import_btn").html('Fetching...');
                    },
                    success: function(response) {
                        var imdb_status     = response.imdb_status;
                        var tmdb_id         = response.tmdb_id;
                        var title           = response.title;
                        var plot            = response.plot;
                        var runtime         = response.runtime;                    
                        //var country         = JSON.parse("["+response.country+"]");
                        //var genre           = JSON.parse("["+response.genre+"]");
                        var rating          = response.rating;;
                        var release         = new Date(response.release).toString('yyyy-MM-dd');
                        var thumbnail       = response.thumbnail;
                        var poster          = response.poster;
                        if (imdb_status == 'success') {
                            // actor
                            $('#actor').val(response.actor);
                            $('#tags').val(response.genre);
                            $('#result').html('<div class="alert alert-success alert-dismissable m-t-15"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Data imported successfully.</div>');
                            $("#name").val(title);
                                                     
                            $("#tmdb_id").val(response.tmdb_id);
                            $("#imported").val('1');
                            $("#description").val(response.plot);
                            $("#rating").val(rating);
                            $("#duration").val(runtime);
                            $("#year").val(response.release);
                            $("#studio").val(response.studio);
                            $("#director").val(response.director);
                            $("#producer").val(response.producer);
                            //$("#release_date").datepicker("setDate", release);
                            $('#thumbnail_content').html('<input type="text" name="thumb_link" value="' + thumbnail + '" class="form-control">');
                            $('#thumb_image').attr('src', thumbnail);
                            $('#poster_content').html('<input type="text" name="poster_link" value="' + poster + '" class="form-control">');
                            $('#poster_image').attr('src', poster);
                            $('#import_btn').html('Fetch');                        
                        } else if(imdb_status == 'fail') {
                            $('#result').html('<div class="alert alert-danger alert-dismissable m-t-15"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+response.error_message+'</div>');
                            $('#import_btn').html('Fetch');
                        }else{
                            $('#result').html('<div class="alert alert-danger alert-dismissable m-t-15"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No data found in database..</div>');
                            $('#import_btn').html('Fetch');
                        }
                    }
                });
            } 
            else {
                alert('Please input IMDb/TMDB ID');
            }
        });
    });
    
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

    function showImg2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#poster_image')
                    .attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
	
	function open_edit_form(){
		$('#edit_form').toggle();
	}
	function select_serese(tmbd_idbm,id,sesice_id, dbselect){
		$('#dbselect').val(dbselect);
		if(dbselect == 'imdb'){
			$('#series_show_list').hide();
			$('#edit_form').show();
			$('#name').val('Season '+id);
			$('#season_number').val(id);
			var thumbnailbm = $('#serise_'+id).attr('src');
			//alert(thumbnailbm);
			$('#thumbnail_content').html('<input type="text" name="thumb_link" value="' + thumbnailbm + '" class="form-control">');
            $('#thumb_image').attr('src', thumbnailbm);
            $('#poster_content').html('<input type="text" name="poster_link" value="' + thumbnailbm + '" class="form-control">');
            $('#poster_image').attr('src', thumbnailbm);
					
			/*$('#poster_row').css({'display':'none'});
			$('#year_row').css({'display':'none'});
			$('#moviecost_row').css({'display':'none'});
			$('#description_row').css({'display':'none'});
			$('#backdrop_row').css({'display':'none'});*/
			
		}else if(dbselect == 'tmdb'){
		$.ajax({
              url:"<?php echo base_url(); ?>series_seasons/add_seasion",
              method:"POST",
              data:{ tmbd_idbm: tmbd_idbm, id:id, sesice_id:sesice_id, dbselect:dbselect},
			  beforeSend: function() {
              },
              success:function(response){
			  	var responsejsondata = JSON.parse(response);
				
				if(responsejsondata.status == 'success'){
				var poster = responsejsondata.data.backdrop;
				var thumbnail = responsejsondata.data.poster;
					//window.location.href = "<?php echo base_url(); ?>series/seasons/"+sesice_id;
					$('#series_show_list').hide();
					$('#edit_form').show();
					$('#name').val(responsejsondata.data.name);
					$('#season_number').val(responsejsondata.data.season_number);
					$('#year').val(responsejsondata.data.year);
					$('#actor').val(responsejsondata.data.actor);
					$('#description').val(responsejsondata.data.description);
					
					$('#rating').val(responsejsondata.data.rating).change();
					//$('select>option:eq(3)').attr('selected', true);
					
					$('#thumbnail_content').html('<input type="text" name="thumb_link" value="' + thumbnail + '" class="form-control">');
                    $('#thumb_image').attr('src', thumbnail);
                    $('#poster_content').html('<input type="text" name="poster_link" value="' + poster + '" class="form-control">');
                    $('#poster_image').attr('src', poster);
				}else{
					alert(responsejsondata.status);
				}
			  	//alert(responsejsondata.status);
			  }
			  
			  })
		}
	}
	
	
  </script>