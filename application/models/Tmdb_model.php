<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tmdb_model extends CI_Model {
  private $api_key;
  public function __construct(){
      parent::__construct();
      $this->load->model('settings_m');
      $api= $this->settings_m->getValue('tmdb_api_key');
      $this->api_key =$api;
  }

  public function getMovieDetail($tmdb_id){
      $url = TMDB_API_MOVIE.$tmdb_id."?language=en-US&api_key=".$this->api_key;
      $response= $this->fetchRequest($url);
      return $response; 
  }
 public function getMovieDetailIbdm($ibdm){ //echo IMDB_KEY;exit;
 	  $url =IMDB_API_TITLE.IMDB_KEY."/".$ibdm;
      //$url = TMDB_API_MOVIE.$ibdm."?language=en-US&api_key=".$this->api_key;
      $response= $this->fetchRequest($url);
      return $response; 
  }
 public function getMovieDetailImageIbdm($ibdm){
 	  $url = IMDB_API_IMAGES.IMDB_KEY."/".$ibdm;
      //$url = TMDB_API_MOVIE.$ibdm."?language=en-US&api_key=".$this->api_key;
      $response= $this->fetchRequest($url);
      return $response; 
  } 
  
  public function getMovieImageResizeIbdm($ibdm, $width, $height){
  	   $url = IMDB_RESIZE_API_URL."?apiKey=".IMDB_KEY."&size=".$width."x".$height."&url=".$ibdm;
	   
	        $curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			));
			
			$response = curl_exec($curl);
			$redirect_url = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
			curl_close($curl);
			
			
	  //print_r($redirect_url); exit;
      return $redirect_url; 
  } 
  
  public function getMovieCasts($tmdb_id){ //echo $this->api_key;exit;
      $url = TMDB_API_MOVIE.$tmdb_id."/credits?api_key=".$this->api_key;
	 // echo $url;exit;
      $response= $this->fetchRequest($url);
      return $response; 
  }

  public function getMovieVideos($tmdb_id){
      $url = TMDB_API_MOVIE.$tmdb_id."/videos?api_key=".$this->api_key;
      $response= $this->fetchRequest($url);
      return $response; 
  }

  public function getTVSeasonDetailsIMDB($id){
  	  //$url = IMDB_API_ADVANCE_SEARCH.IMDB_KEY.'?title='.$id.'&title_type=tv_series&languages='; 
	   $url = IMDB_API_TITLE.IMDB_KEY.'/'.$id;
  	  //$url = IMDB_API_SEARCH_SERIES.IMDB_KEY.'/'.$id;
      
      $response= $this->fetchRequest($url);
      return $response;
  }
  public function getTVSeasonDetails($id){
      $url = TMDB_API_TV.$id."?api_key=".$this->api_key."&language=en-US";
      $response= $this->fetchRequest($url);
      return $response;
  }
  public function getAllMoviesList($id){
      $url = TMDB_API_SEARCH_MOVIE."?query=".$id."&api_key=".$this->api_key;
      $response= $this->fetchRequest($url);
      return $response;
  }
  
  public function getAllMoviesListIMDBCurl($id){
	  $url = IMDB_API_SEARCH_MOVIE.IMDB_KEY."/".$id;
      $response= $this->fetchRequest($url);
      return $response;
  }
  public function getAllSeriesList($id){
  	  $url = TMDB_API_SEARCH_TV."?query=".$id."&api_key=".$this->api_key;
      $response= $this->fetchRequest($url);
      return $response;
  }
   public function getAllSeriesListIMDB($id){
   	  $url = IMDB_API_ADVANCE_SEARCH.IMDB_KEY.'?title='.$id.'&title_type=tv_series&languages=';  	 
      $response= $this->fetchRequest($url);
      return $response;
  }
  public function getSeriesByID($id){
  	  $url = TMDB_API_TV.$id."?&api_key=".$this->api_key;
	  //echo $url;exit;
      $response= $this->fetchRequest($url);
      return $response;
  }

   public function getSeasonsByIDtmdbIMDB($id , $dbselect){
   		if($dbselect == 'tmdb'){
  	  		$url = TMDB_API_TV.$id."?&api_key=".$this->api_key;
		}
		if($dbselect == 'imdb'){
			$url = IMDB_API_TITLE.IMDB_KEY.'/'.$id.''; 
  	  		//$url = IMDB_API_ADVANCE_SEARCH.IMDB_KEY.'?title='.$id.'&title_type=tv_series&languages=';  	 
		}
	  //echo $url;exit;
      $response= $this->fetchRequest(@$url);
	  //print_r($response);exit;
      return $response;
  }
  
  public function getSeriesByIDcredits($id){
  	  $url = TMDB_API_TV.$id."/credits?&api_key=".$this->api_key;
	  //echo $url;exit;
      $response= $this->fetchRequest($url);
      return $response;
  }
  
  public function getepisodeAllJson($tmdb_id, $season_number, $dbselect){
  	  //$url = TMDB_API_TV.$id."?&api_key=".$this->api_key;
	  if($dbselect == 'tmdb'){
	  		$url = TMDB_API_TV.$tmdb_id."/season/".$season_number."?&api_key=".$this->api_key;
	  } elseif($dbselect == 'imdb'){
	  		$url =IMDB_API_SEARCH_EPISODES.IMDB_KEY.'/'.$tmdb_id.'/'.$season_number;
	  }
	  //echo $url;exit;
      $response= $this->fetchRequest($url);
      return $response;
  }
  public function getepisodeByIDJson($tmdb_id, $season_number, $episode_number){
  	  //$url = TMDB_API_TV.$id."?&api_key=".$this->api_key;
	  $url = TMDB_API_TV.$tmdb_id."/season/".$season_number."/episode/".$episode_number."?&api_key=".$this->api_key;
	  //echo $url;exit;
      $response= $this->fetchRequest($url);
      return $response;
  }
  
  public function getepisodeByIDJsonImdbTmdb($tmdb_id, $season_number, $episode_number,$dbselect){
  	  //$url = TMDB_API_TV.$id."?&api_key=".$this->api_key;
	  if($dbselect == 'tmdb'){
	  		$url = TMDB_API_TV.$tmdb_id."/season/".$season_number."/episode/".$episode_number."?&api_key=".$this->api_key;
	  } elseif($dbselect == 'imdb'){
	  		$url =IMDB_API_SEARCH_EPISODES.IMDB_KEY.'/'.$tmdb_id.'/'.$season_number;
	  }
	  //echo $url;exit;
      $response= $this->fetchRequest($url);
      return $response;
  }
  
  public function getMovieInfoAll($id){
   	       /* $curl = curl_init();
			$url = TMDB_API_SEARCH_MOVIE.'?query='.$id.'&api_key=a83559c521ceb090cf76725350a6399d';
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			));
			
			$response = curl_exec($curl);
			
			curl_close($curl);*/
			$movie_info = $this->getAllMoviesList($id);
			$dd = json_decode($movie_info);
			$ddd = $dd->results;
			foreach($ddd as $key=>$val){
				//if($val->backdrop_path != ''){
					$dddd[]= array(
									'adult'=>$val->adult,
									'backdrop_path'=>$val->backdrop_path,
									'genre_ids'=>$val->genre_ids,
									'id'=>$val->id,
									'original_language'=> ($val->original_language == '') ? 'Null' : $val->original_language,
									'original_title'=>$val->original_title,
									'overview'=>$val->overview,
									'popularity'=>$val->popularity,
									'poster_path'=>$val->poster_path,
									'release_date'=> ($val->release_date == '') ? 'Null' : date("Y", strtotime($val->release_date)),
									'title'=> ($val->title == '') ? 'Null' : $val->title,
									'video'=>$val->video,
									'vote_average'=>$val->vote_average,
									'vote_count'=>$val->vote_count,
									'tmdb_id'=>$val->tmdb_id
								 );
				//}
			}
			return $dddd;
  }
  
  public function getMovieInfoAllIMDB($id){
   	      	$movie_info = $this->getAllMoviesListIMDBCurl($id);
			$dd = json_decode($movie_info);
			return $dd;
			/*echo '<pre>';
			print_r($dd);*/
			/*$ddd = $dd->results;
			foreach($ddd as $key=>$val){
				//if($val->backdrop_path != ''){
					$dddd[]= array(
									'adult'=>$val->adult,
									'backdrop_path'=>$val->backdrop_path,
									'genre_ids'=>$val->genre_ids,
									'id'=>$val->id,
									'original_language'=> ($val->original_language == '') ? 'Null' : $val->original_language,
									'original_title'=>$val->original_title,
									'overview'=>$val->overview,
									'popularity'=>$val->popularity,
									'poster_path'=>$val->poster_path,
									'release_date'=> ($val->release_date == '') ? 'Null' : date("Y", strtotime($val->release_date)),
									'title'=> ($val->title == '') ? 'Null' : $val->title,
									'video'=>$val->video,
									'vote_average'=>$val->vote_average,
									'vote_count'=>$val->vote_count,
									'tmdb_id'=>$val->tmdb_id
								 );
				//}
			}
			return $dddd;*/
  }
  
  public function getseasonsAll($id){
  		$series_info = $this->getSeriesByID($id);
		$dd = json_decode($series_info);
			$ddd = $dd->seasons;
		return $ddd;
  }
  
  public function getseasonsAllIMDBtmdb($id, $dbselect){
  		//$series_info = $this->getSeriesByID($id);
		$series_info = $this->getSeasonsByIDtmdbIMDB($id,$dbselect);
		
		$seasons_array = json_decode($series_info);
		
		/*echo '<pre>';
		print_r($seasons_array);exit;*/
		if($dbselect == 'tmdb'){
			$seasons = $seasons_array->seasons;
		}elseif($dbselect == 'imdb'){
			foreach($seasons_array->tvSeriesInfo->seasons as $val){
				$seasons[] = (object)array('name' => 'Season '.$val,
									'poster_path' => $seasons_array->image,
									'air_date' => '',
									'episode_count' => count($seasons_array->tvSeriesInfo->seasons),
									'id' => $val,
									'vote_average' => '',
									'season_number' => $val,
									'overview' => '');
			}
			//print_r($seasons);
			//$seasons = $seasons_array->tvSeriesInfo->seasons;
		}
		return @$seasons;
  }
  
  public function getepisodeAll($tmdb_id, $season_number,$dbselect){
  		$series_info = $this->getepisodeAllJson($tmdb_id, $season_number, $dbselect);
		$dd = json_decode($series_info);
		/*echo '<pre>';
		print_r($dd);exit;*/
		$ddd = $dd->episodes;
		return $ddd;
  }
  public function getepisodeByID($tmdb_id, $season_number,$episode_number){
  		$series_info = $this->getepisodeByIDJson($tmdb_id, $season_number,$episode_number);
		$dd = json_decode($series_info);
		//$ddd = $dd->episodes;
		return $dd;
  }
  
   public function getepisodeByIDimdbTMDB($tmdb_id, $season_number,$episode_number,$dbselect){
  		$series_info = $this->getepisodeByIDJsonImdbTmdb($tmdb_id, $season_number,$episode_number,$dbselect);
		$dd = json_decode($series_info);
		//echo '<pre>';
		if($dbselect == 'tmdb'){
			$ddd = $dd->episodes;
			return $dd;
		} elseif($dbselect == 'imdb'){
			$allEpisode = $dd->episodes;
			foreach($allEpisode as $key=>$val){
				if(($val->seasonNumber == $season_number) && ($val->episodeNumber == $episode_number)){
					return $val;
				}
			}
		/*	print_r();
			exit;
		*/
			
		}
  }
  public function getseasonsmyid($id){
  		$series_info = $this->getSeriesByID($id);
		$dd = json_decode($series_info);		
		return $dd;
  }
  
  public function getseasonsbycredits($id){
  		$series_info = $this->getSeriesByIDcredits($id);
		$dd = json_decode($series_info);		
		return $dd->cast;
  }
  public function getSeriesInfoAll($id){
			$series_info = $this->getAllSeriesList($id);
			$dd = json_decode($series_info);
			$ddd = $dd->results;
			foreach($ddd as $key=>$val){
				//if($val->backdrop_path != ''){
					$dddd[]= array(
									/*'adult'=>$val->adult,
									'backdrop_path'=>$val->backdrop_path,
									'genre_ids'=>$val->genre_ids,
									'id'=>$val->id,
									'original_language'=> ($val->original_language == '') ? 'Null' : $val->original_language,
									'original_title'=>$val->original_title,
									'overview'=>$val->overview,
									'popularity'=>$val->popularity,
									'poster_path'=>$val->poster_path,
									'release_date'=> ($val->release_date == '') ? 'Null' : date("Y", strtotime($val->release_date)),
									'title'=> ($val->title == '') ? 'Null' : $val->title,
									'video'=>$val->video,
									'vote_average'=>$val->vote_average,
									'vote_count'=>$val->vote_count,*/
									'tmdb_id' => $val->id,
									'name' => $val->name,
									'poster_path' => $val->poster_path,
									'original_language' => $val->original_language,
									'first_air_date'=> ($val->first_air_date == '') ? 'Null' : date("Y", strtotime($val->first_air_date))
								 );
				//}
			}
			return $dddd;
  }
  
  public function getSeriesInfoAllIMDB($id){
			$series_info = $this->getAllSeriesListIMDB($id);
			$dd = json_decode($series_info);
			
			/*echo '<pre>';
			print_r($dd);*/
			$ddd = $dd->results;
			foreach($ddd as $key=>$val){
				//if($val->backdrop_path != ''){
					$dddd[]= array(
									/*'adult'=>$val->adult,
									'backdrop_path'=>$val->backdrop_path,
									'genre_ids'=>$val->genre_ids,
									'id'=>$val->id,
									'original_language'=> ($val->original_language == '') ? 'Null' : $val->original_language,
									'original_title'=>$val->original_title,
									'overview'=>$val->overview,
									'popularity'=>$val->popularity,
									'poster_path'=>$val->poster_path,
									'release_date'=> ($val->release_date == '') ? 'Null' : date("Y", strtotime($val->release_date)),
									'title'=> ($val->title == '') ? 'Null' : $val->title,
									'video'=>$val->video,
									'vote_average'=>$val->vote_average,
									'vote_count'=>$val->vote_count,*/
									'tmdb_id' => $val->id,
									'name' => $val->title,
									'poster_path' => $val->image,
									'original_language' => '' ,
									'first_air_date'=> $val->description //($val->first_air_date == '') ? 'Null' : date("Y", strtotime($val->first_air_date))
								 );
				//}
			}
			return $dddd;
  }
  
  public function fetchRequest($url){
      $curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      //CURLOPT_URL => TMDB_API_MOVIE."384018/videos?api_key=e028c2212fa961f28073b276e49dad4c&language=en-US",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      /*CURLOPT_POSTFIELDS => "{}",*/
      //CURLOPT_SSL_VERIFYPEER => false // Disable SSL verification - NOT recommended for production!
      ));
      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      if ($err) {
        return ;
        //echo "cURL Error #:" . $err;
      } else {
        //echo $response;
        return $response;
      }
  }

public function get_movie_info_ibdm($ibdm=''){
           
      $response = array();

      $movie_info = $this->getMovieDetailIbdm($ibdm);
      $data= json_decode($movie_info);
	  /*echo '<pre>';
	  print_r($data);*/
	  return $data;
}	

public function get_movie_info_image_ibdm($ibdm=''){
           
      $response = array();

      $movie_info = $this->getMovieDetailImageIbdm($ibdm);
      $data= json_decode($movie_info);
	  /*echo '<pre>';
	  print_r($data);*/
	  return $data;
}
  
  public function get_movie_info($tmdb_id=''){
      if($tmdb_id =='' || $tmdb_id==NULL):
        $tmdb_id  = '00000000';
      endif;
      /*$data           = file_get_contents('http://ovoo.spagreen.net/scrapper/v20/get_movie_json/none/'.$tmdb_id);
      $data           = json_decode($data, true);*/
      
      $response = array();

      $movie_info = $this->getMovieDetail($tmdb_id);
      $data= json_decode($movie_info);
	 /* echo '<pre>';
      print_r($data);*/
      if(isset($data->status_code) && $data->status_code==34){
           $response['status']    = 'fail';
      }else{

          //get cast info
          $casts = $this->getMovieCasts($tmdb_id);
          $casts_array= json_decode($casts);
          
          $actors="";
       
          if(isset($casts)){
		  	$cc =0;
            foreach ($casts_array->cast as $actor) {
				if($cc < 6){
                	$actors .=$actor->name.", ";
				}
				$cc++;
            }
          }

          $genres="";

          foreach ($data->genres as $genre) {
              $genres .=$genre->name.", ";
          }
//echo $genres;exit;
          //get director 
          $director="";
          $producer="";
          foreach ($casts_array->crew as $crew) {
             if($crew->job=="Director"){
                $director.=$crew->name .", ";
             }

             if($crew->job=="Producer"){
                $producer.=$crew->name .", ";
             }
          }

          $studio ="";
          if(count($data->production_companies)>0){
            $studio= $data->production_companies[0]->name;
          }

          //$actors        = $this->filter_actors($casts_array->cast);
          //$directors     = $this->filter_directors($casts_array->crew);
          //$writters      = $this->filter_writters($data['credits']['crew']);
          //$countries     = $this->filter_countries($data['production_countries']);
          //$genres        = $this->filter_genres($data->genres);

          $response['status']         = 'success';
          $response['tmdb_id']         = $data->id;//$data['imdbID'];
          $response['title']          = $data->title;
          $response['plot']           = $data->overview;
          $response['runtime']        = $data->runtime;
          $response['actor']          = rtrim($actors,', ');
          $response['director']       = rtrim($director,', ');
          $response['producer']       = rtrim($producer,', ');
         // $response['writer']         = $writters;//$this->common_model->get_star_ids('writer',$data['Writer']);
          //$response['country']        = $countries;//$this->common_model->get_country_ids($data['Country']);
          $response['genre']          = rtrim($genres,', ');//$this->common_model->get_genre_ids($movie->getGenres());
          $response['rating']         = $data->vote_average;
          $response['release']        = $data->release_date;
          $response['studio']         = $studio;
          $response['thumbnail']      = ($data->poster_path!="") ? TMDB_IMAGE_W342.$data->poster_path : '';
          $response['poster']         = ($data->backdrop_path!="") ? TMDB_IMAGE_W1280.$data->backdrop_path : '';
      }
	  //print_r($response);exit; 
      return $response; 
  }

  function get_tvseries_info($tmdb_id='')
  {
      if($tmdb_id =='' || $tmdb_id==NULL):
        $tmdb_id  = '00000000';
      endif;
  
      $response = array();

      $season_info = $this->getTVSeasonDetails($tmdb_id);
      $data= json_decode($season_info);
     // print_r($data);
      if(isset($data->status_code) && $data->status_code==34){
           $response['status']    = 'fail';
      }else{

          //get cast info
          /*$casts = $this->getMovieCasts($tmdb_id);
          $casts_array= json_decode($casts);*/
          
          $actors="";
          /*foreach ($casts_array->cast as $actor) {
              $actors .=$actor->name.", ";
          }*/

          $genres="";
         /* foreach ($data->genres as $genre) {
              $genres .=$genre->name.", ";
          }*/

          //get director 
          $director="";
          $producer="";
         /* foreach ($casts_array->crew as $crew) {
             if($crew->job=="Director"){
                $director.=$crew->name .", ";
             }

             if($crew->job=="Producer"){
                $producer.=$crew->name .", ";
             }
          }*/

          $studio ="";
          if(count($data->production_companies)>0){
            $studio= $data->production_companies[0]->name;
          }
          $response['status']         = 'success';
          $response['tmdb_id']        = $data->id;//$data['imdbID'];
          $response['title']          = $data->name;
          $response['plot']           = $data->overview;
          $response['runtime']        = '';
          $response['actor']          = rtrim($actors,', ');
          $response['director']       = rtrim($director,', ');
          $response['producer']       = rtrim($producer,', ');
          $response['genre']          = rtrim($genres,', ');//$this->common_model->get_genre_ids($movie->getGenres());
          $response['rating']         = $data->vote_average;
          $response['release']        = $data->last_air_date;
          $response['studio']         = $studio;
          $response['thumbnail']      = TMDB_IMAGE_W342.$data->poster_path;
          $response['poster']         = TMDB_IMAGE_W1280.$data->backdrop_path;
      }
      return $response; 
  }
function get_tvseriesinfoIMDB($tmdb_id){
   	  $season_info = $this->getTVSeasonDetailsIMDB($tmdb_id);
      $data = json_decode($season_info);
	 /* echo '<pre>';
	  print_r($data);*/
	   if(isset($data->status_code) && $data->status_code==34){
           $response['status']    = 'fail';
      }else{
	  	  $response['status']         = 'success';
          $response['name']           = $data->title;
          $response['tmdb_id']        = $data->id;          
          $response['genres']         = $data->genres;
		  $response['backdrop_path']  = $data->image;
	  }
	  return $response;
}
function get_tvseriesinfo($tmdb_id='')
  {
      if($tmdb_id =='' || $tmdb_id==NULL):
        $tmdb_id  = '00000000';
      endif;
  
      $response = array();

      $season_info = $this->getTVSeasonDetails($tmdb_id);
      $data= json_decode($season_info);
     // print_r($data);
      if(isset($data->status_code) && $data->status_code==34){
           $response['status']    = 'fail';
      }else{

          //get cast info
          /*$casts = $this->getMovieCasts($tmdb_id);
          $casts_array= json_decode($casts);*/
          
          $actors="";
          /*foreach ($casts_array->cast as $actor) {
              $actors .=$actor->name.", ";
          }*/

          $genres="";
         /* foreach ($data->genres as $genre) {
              $genres .=$genre->name.", ";
          }*/

          //get director 
          $director="";
          $producer="";
         /* foreach ($casts_array->crew as $crew) {
             if($crew->job=="Director"){
                $director.=$crew->name .", ";
             }

             if($crew->job=="Producer"){
                $producer.=$crew->name .", ";
             }
          }*/

          $studio ="";
          if(count($data->production_companies)>0){
            $studio= $data->production_companies[0]->name;
          }
		  
		  $response['status']         = 'success';
          $response['name']           = $data->name;
          $response['tmdb_id']        = $data->id;          
          $response['genres']         = $data->genres;
		  $response['backdrop_path']  = TMDB_IMAGE_W1280.$data->backdrop_path;
          /*$response['runtime']        = ' Min';
          $response['actor']          = rtrim($actors,', ');
          $response['director']       = rtrim($director,', ');
          $response['producer']       = rtrim($producer,', ');
          $response['genre']          = rtrim($genres,', ');//$this->common_model->get_genre_ids($movie->getGenres());
          $response['rating']         = $data->vote_average;
          $response['release']        = $data->last_air_date;
          $response['studio']         = $studio;
          $response['thumbnail']      = TMDB_IMAGE_W342.$data->poster_path;
          $response['poster']         = TMDB_IMAGE_W1280.$data->backdrop_path;*/
      }
      return $response; 
  }
  
  function get_movie_actor_info($tmdb_id='')
  {
      $added_star     = 0;
      if($tmdb_id =='' || $tmdb_id==NULL):
        $tmdb_id  = '00000000';
      endif;
      //$data           = file_get_contents('http://ovoo.spagreen.net/scrapper/v20/get_movie_json/xxxxxxxxxx/'.$tmdb_id);
      $data           = file_get_contents('http://ovoo.spagreen.net/scrapper/v20/get_movie_json/none/'.$tmdb_id);
      $data           = json_decode($data, true);
      if(isset($data['error_message'])){
        $response['status']    = 'fail';
      }else{
        //var_dump($data);
        $actors         = array();
        $directors      = array();
        $writters       = array();        
        if(count($data) >0){
          $actors       = $this->update_actors($data['credits']['cast']);
          $stars        = $this->update_directors_writers($data['credits']['crew']);
          $added_star   = $actors + $stars;
        }
      }
      return $added_star;    
  }

  function get_tvshow_actor_info($tmdb_id='')
    {
      $added_star     = 0;
      if($tmdb_id =='' || $tmdb_id==NULL):
        $tmdb_id  = '00000000';
      endif;
      $data           = file_get_contents('http://ovoo.spagreen.net/scrapper/v20/get_tvshow_json/none/'.$tmdb_id);
      $data           = json_decode($data, true);
      if(isset($data['error_message'])){
        $response['status']    = 'fail';
      }else{
        //var_dump($data);
        $actors         = array();
        $directors      = array();
        $writters       = array();        
        if(count($data) >0){
          $actors       = $this->update_actors($data['credits']['cast']);
          $stars        = $this->update_directors_writers($data['credits']['crew']);
          $added_star   = $actors + $stars;
        }
      }
      return $added_star;    
  }


  function update_actors($actors){
    $added_star =0;
    for ($i=0; $i<sizeof($actors); $i++) {      
      $actors_name        = trim($actors[$i]['name']);
      $org_profile_path   = trim($actors[$i]['profile_path']);
      $profile_path       = TMDB_IMAGE_PROFILE.$org_profile_path;
      $num_rows           = $this->db->get_where('star', array('star_name'=>$actors_name))->num_rows();
      if($num_rows==0):
        $added_star++;
        $data['star_type']  ='actor';
        $data['star_name']  = $actors_name;
        $data['slug']       = $this->common_model->get_seo_url($actors_name);
        $this->db->insert('star',$data);
        $insert_id = $this->db->insert_id();
        if($org_profile_path !='' && $org_profile_path !=NULL && $org_profile_path !='null'):
          $save_to = 'uploads/star_image/'.$insert_id.'.jpg';
          $cron_data['type']       = "image";       
          $cron_data['action']     = "download";       
          $cron_data['image_url']  = $profile_path;       
          $cron_data['save_to']    = $save_to;
          $this->db->insert('cron',$cron_data);       
          //$this->common_model->grab_image($profile_path,$save_to);
        endif;
      endif;
    }
    return $added_star;
  }
  function update_directors_writers($stars){
    $added_star =0;
    for ($i=0; $i<sizeof($stars); $i++) {      
      $actors_name        = trim($stars[$i]['name']);
      $org_profile_path   = trim($stars[$i]['profile_path']);
      $profile_path       = TMDB_IMAGE_PROFILE.$org_profile_path;
      $num_rows           = $this->db->get_where('star', array('star_name'=>$actors_name))->num_rows();
      if($num_rows==0):
        $added_star++;
        if($stars[$i]['department'] =='Directing' && $stars[$i]['job'] =='Director'){
          $data['star_type']  ='director';
        }else if($stars[$i]['department'] =='Writing'){
          $data['star_type']  ='writer';
        }else{
          $data['star_type']  ='actor';
        }
        $data['star_name']  = $actors_name;
        $data['slug']       = $this->common_model->get_seo_url($actors_name);
        $this->db->insert('star',$data);
        $insert_id = $this->db->insert_id();
        if($org_profile_path !='' && $org_profile_path !=NULL && $org_profile_path !='null'):
          $save_to = 'uploads/star_image/'.$insert_id.'.jpg';
          $cron_data['type']       = "image";       
          $cron_data['action']     = "download";       
          $cron_data['image_url']  = $profile_path;       
          $cron_data['save_to']    = $save_to;
          $this->db->insert('cron',$cron_data);           
          //$this->common_model->grab_image($profile_path,$save_to);
        endif;
      endif;
    }
    return $added_star;
  }

  //echo $movie->getJSON();
  function filter_actors($actors){
    $actors_name = '';
    for ($i=0; $i<sizeof($actors); $i++) {
      if($i>0){
         $actors_name .=',';
      }
      $actors_name .= trim($actors[$i]['name']);
    }
    return $actors_name;
  }

  function filter_directors($directors){
    $j=0;
    $directors_name = '';
    for ($i=0; $i<sizeof($directors); $i++) {        
      if($directors[$i]['department'] =='Directing' && $directors[$i]['job'] =='Director'){
        if($j>0){
           $directors_name .=',';
        }
        $j++;
        $directors_name .= trim($directors[$i]['name']);
      }
    }
    return $directors_name;
  }
  function filter_writters($writters){
    $writter_name = '';
    $j=0;
    for ($i=0; $i<sizeof($writters); $i++) {        
      if($writters[$i]['department'] =='Writing'){
        if($j>0){
           $writter_name .=',';
        }
        $j++;
        $writter_name .= trim($writters[$i]['name']);
      }
    }
    return $writter_name;
  }

  function filter_genres($genres){
    $genres_name = '';
    for ($i=0; $i<sizeof($genres); $i++) {
      if($i>0){
         $genres_name .=',';
      }
      $genres_name .= trim($genres[$i]['name']);
    }
    return $genres_name;
  }

  function filter_countries($countries){
    $countries_name = '';
    for ($i=0; $i<sizeof($countries); $i++) {
      if($i>0){
         $countries_name .=',';
      }
      $countries_name .= trim($countries[$i]['name']);
    }
    return $countries_name;
  }

  function filter_tv_countries($countries){
    $countries_name = '';
    for ($i=0; $i<sizeof($countries); $i++) {
      if($i>0){
         $countries_name .=',';
      }
      $countries_name .= trim($countries[$i]);
    }
    return $countries_name;
  }


  function search($title='',$to=''){
      if($title =='' || $title==NULL):
        $title  = '00000000';
      endif;
      //$data           = file_get_contents('http://ovoo.spagreen.net/scrapper/v20/get_movie_json/xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx/'.$title);
      if($to =='tv'):
        $data           = file_get_contents('http://ovoo.spagreen.net/scrapper/v30/search_tvseries/none/'.$title);
      else:
        $data           = file_get_contents('http://ovoo.spagreen.net/scrapper/v30/search_movie/none/'.rawurlencode($title));
      endif;
      $data           = json_decode($data, true);
      if(isset($data['status'])):
        $data['error_message']    = $data['error_message'];
      endif;
    return $data;
  }

  function import_movie_info($tmdb_id=''){
      $response      = TRUE;
      if($tmdb_id =='' || $tmdb_id==NULL):
        $tmdb_id  = '00000000';
      endif;
      //$data           = file_get_contents('http://ovoo.spagreen.net/scrapper/v20/get_movie_json/xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx/'.$tmdb_id);
      $data           = file_get_contents('http://ovoo.spagreen.net/scrapper/v20/get_movie_json/none/'.$tmdb_id);
      $data           = json_decode($data, true);
      if(isset($data['error_message'])){
        $response      = FALSE;
      }else{
        $actors         = array();
        $directors      = array();
        $writters       = array();
        $countries      = array();
        $genres         = array();
        if(count($data) >0){
          $actors        = $this->filter_actors($data['credits']['cast']);
          $directors     = $this->filter_directors($data['credits']['crew']);
          $writters      = $this->filter_writters($data['credits']['crew']);
          $countries     = $this->filter_countries($data['production_countries']);
          $genres        = $this->filter_genres($data['genres']);
        }
        if(count($data) >0 && $data['title'] !='' && $data['title'] !=NULL){
          $this->update_actors($data['credits']['cast']);
          $this->update_directors_writers($data['credits']['crew']);
          //$this->get_movie_actor_info($tmdb_id);
          $movie_data['imdbid']         = $data['imdb_id'];//$data['imdbID'];
          $movie_data['title']          = $data['title'];
          $movie_data['seo_title']      = $data['title'];
          $movie_data['description']    = $data['overview'];
          $movie_data['runtime']        = $data['runtime'];
          $movie_data['stars']          = $this->common_model->get_star_ids('actor',$actors);
          $movie_data['director']       = $this->common_model->get_star_ids('director',$directors);
          $movie_data['writer']         = $this->common_model->get_star_ids('writer',$writters);
          $movie_data['country']        = $this->country_model->get_country_ids($countries);
          $movie_data['genre']          = $this->genre_model->get_genre_ids($genres);
          $movie_data['imdb_rating']    = $data['vote_average'];
          $movie_data['release']        = $data['release_date'];
          $movie_data['video_quality']  = 'HD';
          $movie_data['publication']    = '1';
          $movie_data['enable_download']= '0';
          $this->db->insert('videos',$movie_data);
          $insert_id                    = $this->db->insert_id();
          //save thumbnail
          $image_source                 = TMDB_IMAGE_W342.'/'.$data['poster_path'];
          $save_to                      = 'uploads/video_thumb/'.$insert_id.'.jpg';           
          $this->common_model->grab_image($image_source,$save_to);
          // save poster
          if($data['backdrop_path'] !='' && $data['backdrop_path'] !=NULL):            
            $image_source                 = TMDB_IMAGE_W1280.'/'.$data['backdrop_path'];
            $save_to                      = 'uploads/poster_image/'.$insert_id.'.jpg';           
            $this->common_model->grab_image($image_source,$save_to);
          endif;
          // update slug
          $slug                         = url_title($data['title'], 'dash', TRUE);
          $slug_num                     = $this->common_model->slug_num('videos',$slug);
          if($slug_num > 0):
              $slug= $slug.'-'.$insert_id;
          endif;
          $data_update['slug']               = $slug;
          $this->db->where('videos_id', $insert_id);
          $this->db->update('videos', $data_update);

        }else{
          $response      = FALSE;
        }
      }
    return $response;    
  }

  function import_tvseries_info($tmdb_id=''){
      $response      = TRUE;
      if($tmdb_id =='' || $tmdb_id==NULL):
        $tmdb_id  = '00000000';
      endif;
      //$data           = file_get_contents('http://ovoo.spagreen.net/scrapper/v20/get_movie_json/xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx/'.$tmdb_id);
      $data           = file_get_contents('http://ovoo.spagreen.net/scrapper/v20/get_tvshow_json/none/'.$tmdb_id);
      $data           = json_decode($data, true);
      if(isset($data['error_message'])){
        $response      = FALSE;
      }else{
        $actors         = array();
        $directors      = array();
        $writters       = array();
        $countries      = array();
        $genres         = array();
        if(count($data) >0){
          $actors       = $this->filter_actors($data['credits']['cast']);
          $directors    = $this->filter_directors($data['credits']['crew']);
          $writters     = $this->filter_writters($data['credits']['crew']);
          $countries    = $this->filter_tv_countries($data['origin_country']);
          $genres       = $this->filter_genres($data['genres']);
        }
        if(count($data) >0 && $data['name'] !='' && $data['name'] !=NULL){
          $this->update_actors($data['credits']['cast']);
          $this->update_directors_writers($data['credits']['crew']);
          //$this->get_movie_actor_info($tmdb_id);
          $movie_data['imdbid']         = '';//$data['imdbID'];
          $movie_data['title']          = $data['name'];
          $movie_data['seo_title']      = $data['name'];
          $movie_data['description']    = $data['overview'];
          $movie_data['runtime']        = '';
          $movie_data['stars']          = $this->common_model->get_star_ids('actor',$actors);
          $movie_data['director']       = $this->common_model->get_star_ids('director',$directors);
          $movie_data['writer']         = $this->common_model->get_star_ids('writer',$writters);
          $movie_data['country']        = $this->country_model->get_country_ids($countries);
          $movie_data['genre']          = $this->genre_model->get_genre_ids($genres);
          $movie_data['imdb_rating']    = $data['vote_average'];
          $movie_data['release']        = $data['first_air_date'];
          $movie_data['video_quality']  = 'HD';
          $movie_data['publication']    = '1';
          $movie_data['enable_download']= '0';
          $movie_data['is_tvseries']    = '1';
          $this->db->insert('videos',$movie_data);
          $insert_id                    = $this->db->insert_id();
          //save thumbnail
          $image_source                 = TMDB_IMAGE_W342.'/'.$data['poster_path'];
          $save_to                      = 'uploads/video_thumb/'.$insert_id.'.jpg';           
          $this->common_model->grab_image($image_source,$save_to);
          // save poster
          if($data['backdrop_path'] !='' && $data['backdrop_path'] !=NULL):            
            $image_source                 = TMDB_IMAGE_W1280.'/'.$data['backdrop_path'];
            $save_to                      = 'uploads/poster_image/'.$insert_id.'.jpg';           
            $this->common_model->grab_image($image_source,$save_to);
          endif;
          // update slug
          $slug                         = url_title($data['name'], 'dash', TRUE);
          $slug_num                     = $this->common_model->slug_num('videos',$slug);
          if($slug_num > 0):
              $slug= $slug.'-'.$insert_id;
          endif;
          $data_update['slug']               = $slug;
          $this->db->where('videos_id', $insert_id);
          $this->db->update('videos', $data_update);

        }else{
          $response      = FALSE;
        }
      }
    return $response;    
  }
}

