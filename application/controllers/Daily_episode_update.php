<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Daily_episode_update extends User_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(80);
        $this->lang->load('groups');
        $this->lang->load('actions');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        //$this->load->model('series_m');
        /* Title Page :: Common */
        $this->page_title->push('Series');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['main_nav'] = "sod";
        $this->data['sub_nav'] = "daily_episode_update";
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Series', 'series');
		
		 $this->load->model('series_m');
    }
	
	public function index(){  
		$this->data['page_title'] = "Daily Episode Update";
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
		$this->data['sub_nav'] = "daily_episode_update";
        check_allow('view',$this->data['is_allow']);
		
		if(isset($_REQUEST['daily_episode_update'])){ //print_r($_REQUEST);
			$daily_episode_update_array = array('episode_date' => $_REQUEST['episode_date'], 'season_set' =>$_REQUEST['season_set']);
			
			$res = $this->series_m->check_daily_episode_seasion($daily_episode_update_array);
			if(count($res) >0){			      
				$this->session->set_flashdata('failure',"Already data inserted.");
				redirect( BASE_URL . 'daily_episode_update' );
			} else{
				$this->series_m->create_daily_episode($daily_episode_update_array);
				$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('daily_episode_update').'" target="_blank">Create Data Success</a>');          
				$this->session->set_flashdata('success',"Create Data Success.");
			}
		}
		
		$series = $this->series_m->getSeriesDailyUpdate();
		//$seasons = $this->series_seasons_m->get_by(array('series_id'=>$series_id));
		$this->data['series'] = $series;
		
		$series_all = $this->series_m->getSeries();
		//$this->data['seasons'] =  
		
		foreach($series_all as $key_all=>$val_all){
			$series_all_array[$val_all['id']] = $val_all['name'];
		}
		$this->data['series_all_array'] = $series_all_array;
		/*echo '<pre>';
		print_r($series_all_array);*/
		
		
		$this->data['daily_episode_update'] = $this->series_m->daily_episode_update_active();
		
        //$this->data['subscription_renewal_keys_view'] = $this->load->view( DEFAULT_THEME . 'daily_episode_update/_add_series.php',$this->data, TRUE);
        //$this->data['subscription_renewal_keys_list_view']= $this->load->view( DEFAULT_THEME . 'daily_episode_update/_list_series',$this->data, TRUE);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'daily_episode_update/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'daily_episode_update/index';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }
	
	public function fetch_logdata(){
		$series_all = $this->series_m->getSeries();
		//$this->data['seasons'] =  
		
		foreach($series_all as $key_all=>$val_all){
			$series_all_array[$val_all['id']] = $val_all['name'];
		}
		$this->data['series_all_array'] = $series_all_array;

		
		$select_log_data = $_REQUEST['select_log_data'];
		$daily_episode_update_log = $this->series_m->daily_episode_update_log($select_log_data);
		$html = ' <thead>
										<tr>
										<th>Season Date</th>
										<th>Title</th>
										  
										  
										  <th>Series Name</th>
										   <th>Season Name</th>
										  <th>URL</th>
										  <th>Description</th>			 
										 
										  <th>Action</th>
										
										</tr> 
									  </thead>
									  <tbody>';
			foreach($daily_episode_update_log as $key){
					$html.= ' <tr>
										 	<td>'.$key['episode_date'].'</td>
											<td>'.$key['title'].'</td>
											
											<td>'.$series_all_array[$key['series_name']].'</td>
											<td>'.$key['season_name'].'</td>
											<td>'.$key['url'].'</td>
											<td>'.$key['seasons_description'].'</td>
											<td>'.btn_delete(BASE_URL.'daily_episode_update/deleted/'.$key['id']);
			}
							
									  
		$html.='</tbody>';
		echo $html;
	}
	
	public function add($id = NULL){ 
		$this->load->model('series_seasons_m');
		$added_episode_details = $this->series_m->get_episode_id($id); 
		$info = $this->series_seasons_m->get($added_episode_details['season_id'],TRUE);
		
		///*
		//echo '<pre>';
		//
		//print_r($added_episode_details);
		//
	//	print_r($info);
		//exit;
		//*/
		
		//========================================================================================================
			$this->load->model('episodes_m');
			$get_max_sequence = $this->episodes_m->get_max_sequence($added_episode_details['season_id']);
			
			//print_r($get_max_sequence[0]['seq_id']);exit;
			$sequenceId = $get_max_sequence[0]['seq_id'] + 1;
		//========================================================================================================
	$date_format = date_format (date_create($added_episode_details['episode_date']),DATE_FORMAT);
		//echo $date_format; exit;
		
			$date_for_title = date_format (date_create($added_episode_details['episode_date']),DATE_FORMAT_TITLE);
		
			
			$replace = array( '<day>' => date('D',strtotime($added_episode_details['episode_date'])),
							   '<Day>' => date('D',strtotime($added_episode_details['episode_date'])),
							   '<DAY>' => date('D',strtotime($added_episode_details['episode_date'])),
							   '<Date>' => $date_format,
							   '<date>' => $date_format,
							   '<DATE>' => $date_format,
							   '<sequence>' => $sequenceId,
							   '<Sequence>' => $sequenceId,
							   '<SEQUENCE>' => $sequenceId
							);

			
			$replace2 = array( '<day>' => date('D',strtotime($added_episode_details['episode_date'])),
							'<Day>' => date('D',strtotime($added_episode_details['episode_date'])),
							'<DAY>' => date('D',strtotime($added_episode_details['episode_date'])),
							  
							'<Date>' => $date_for_title,
							'<date>' => $date_for_title,
							'<DATE>' => $date_for_title,
							'<sequence>' => $sequenceId,
							'<Sequence>' => $sequenceId,
							'<SEQUENCE>' => $sequenceId
						 );
		//echo $date_format; exit;
			//echo 'Title :'.str_replace("<day>",date('D',strtotime($values['episode_date'])),str_replace("<date>",$values['episode_date'],$val['title'])).'</br>';
		
		//echo $this
		$title=$added_episode_details['title'];
		$session_url=$added_episode_details['url'];
		$url_description=$added_episode_details['seasons_description'];
	//echo "TITLE: ".	$title."</br>";
	//	echo $session_url."</br>";
	//	echo $url_description."</br>";
	//	exit;
		//@raj
		//	$title = $this->strReplaceAssoc($replace2, $info->title);
		//	$session_url = $this->strReplaceAssoc($replace, $info->session_url);
		//	$url_description = $this->strReplaceAssoc($replace, $info->url_description);
		//========================================================================================================
		
		$data = array('season_id' => $added_episode_details['season_id'],
						 //'title' => $added_episode_details['title'],
							//'description' => $added_episode_details['seasons_description'],
								//'url' => $added_episode_details['url'],
								'title' => $title,
								'description' => $url_description,
								'url' => $session_url,
								'sequence_id' => $sequenceId,
								'language_id' => $info->language,
								'image' => $info->backdrop,
								'server_url_id' => '12',
								'series_id' => $info->series_id);
		//print_r($data);	exit;					
		if($this->series_m->insert_episode_daily($data)){
			$this->series_m->update_season(array('is_added' => 1), $added_episode_details['id']);
			$this->session->set_flashdata('success',"Add Data Success.");
			redirect( BASE_URL . 'daily_episode_update' );
		} else {
			$this->session->set_flashdata('failure',"Add Fail.");			
			redirect( BASE_URL . 'daily_episode_update' );
		}
	}
	
	public function strReplaceAssoc(array $replace, $subject) {
   		return str_replace(array_keys($replace), array_values($replace), $subject);   

	}
  
  public function addalldata(){ 
		$this->load->model('series_seasons_m');
		$series = $this->series_m->daily_episode_update_active();
		// echo '<pre>';
		// print_r($series);exit;
		$this->load->model('episodes_m');
		
		
		foreach($series as $key=>$val){ 
			if($val['is_added'] == '0'){ //print_r($val['season_id']);
			$info = $this->series_seasons_m->get($val['season_id'],TRUE);
			
			$get_max_sequence = $this->episodes_m->get_max_sequence($val['season_id']);
		
			//print_r($get_max_sequence[0]['seq_id']);exit;
			$sequenceId = $get_max_sequence[0]['seq_id'] + 1;	
			
		$title=$val['title'];
		$session_url=$val['url'];
		$url_description=$val['seasons_description'];
							
				$data = array('season_id' => $val['season_id'],
								/* 'title' => $val['title'],
									'description' => $val['seasons_description'],
										'url' => $val['url'],*/
										'title' => $title,
										'description' => $url_description,
										'url' => $session_url,
										'sequence_id' => $sequenceId,
										'language_id' => $info->language,
										'image' => $info->backdrop,
										'server_url_id' => '12',
										'series_id' => $info->series_id);
				//echo '<pre>';
				//print_r($data);	
							
				$this->series_m->insert_episode_daily($data);
				$this->series_m->update_season(array('is_added' => 1), $val['id']);
				$this->session->set_flashdata('success',"Add Data Success.");
			}
		}
		redirect( BASE_URL . 'daily_episode_update' );
		
	}
	public function addalldataXXXXNOUSE(){ 
		$this->load->model('series_seasons_m');
		$series = $this->series_m->daily_episode_update();
		/*echo '<pre>';
		print_r($series);exit;*/
		$this->load->model('episodes_m');
		
		
		foreach($series as $key=>$val){ 
			if($val['is_added'] == '0'){ //print_r($val['season_id']);
			$info = $this->series_seasons_m->get($val['season_id'],TRUE);
			
			$get_max_sequence = $this->episodes_m->get_max_sequence($val['season_id']);
		
			//print_r($get_max_sequence[0]['seq_id']);exit;
			$sequenceId = $get_max_sequence[0]['seq_id'] + 1;	
			//========================================================================================================
			$replace = array( '<day>' => date('D',strtotime($val['episode_date'])),
							   '<Day>' => date('D',strtotime($val['episode_date'])),
							   '<DAY>' => date('D',strtotime($val['episode_date'])),
							   '<Date>' => $val['episode_date'],
							   '<date>' => $val['episode_date'],
							   '<DATE>' => $val['episode_date'],
							   '<sequence>' => $sequenceId,
							   '<Sequence>' => $sequenceId,
							   '<SEQUENCE>' => $sequenceId
							);
			//echo 'Title :'.str_replace("<day>",date('D',strtotime($values['episode_date'])),str_replace("<date>",$values['episode_date'],$val['title'])).'</br>';
			//$title = $this->strReplaceAssoc($replace, $info->title);
			//$session_url = $this->strReplaceAssoc($replace, $info->session_url);
			//$url_description = $this->strReplaceAssoc($replace, $info->url_description);
		$title=$added_episode_details['title'];
		$session_url=$added_episode_details['url'];
		$url_description=$added_episode_details['seasons_description'];
			//========================================================================================================	
							
				$data = array('season_id' => $val['season_id'],
								/* 'title' => $val['title'],
									'description' => $val['seasons_description'],
										'url' => $val['url'],*/
										'title' => $title,
										'description' => $url_description,
										'url' => $session_url,
										'sequence_id' => $sequenceId,
										'language_id' => $info->language,
										'image' => $info->backdrop,
										'server_url_id' => '12',
										'series_id' => $info->series_id);
				//echo '<pre>';
				//print_r($data);	
							
				$this->series_m->insert_episode_daily($data);
				$this->series_m->update_season(array('is_added' => 1), $val['id']);
				$this->session->set_flashdata('success',"Add Data Success.");
			}
		}
		redirect( BASE_URL . 'daily_episode_update' );
		/*$this->load->model('series_seasons_m');
		$added_episode_details = $this->series_m->get_episode_id($id); 
		$info = $this->series_seasons_m->get($added_episode_details['season_id'],TRUE);
		
		$data = array('season_id' => $added_episode_details['season_id'],
						 'title' => $added_episode_details['title'],
							'description' => $added_episode_details['seasons_description'],
								'url' => $added_episode_details['url'],
								'sequence_id' => $added_episode_details['sequence'],
								'language_id' => $info->language,
								'image' => $info->backdrop,
								'series_id' => $info->series_id);
								
		if($this->series_m->insert_episode_daily($data)){
			$this->series_m->update_season(array('is_added' => 1), $added_episode_details['id']);
			$this->session->set_flashdata('success',"Add Data Success.");
			redirect( BASE_URL . 'daily_episode_update' );
		} else {
			$this->session->set_flashdata('failure',"Add Fail.");			
			redirect( BASE_URL . 'daily_episode_update' );
		}*/
	}
	
	public function deleted($id = NULL){ 
		if($this->series_m->deleted_daily_episode_seasion($id)){
			$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('daily_episode_update').'" target="_blank">Delete Data Success</a>');          
			$this->session->set_flashdata('success',"Delete Data Success.");
		}else{
			$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('daily_episode_update').'" target="_blank">Delete Data fail</a>');          
			$this->session->set_flashdata('failure',"Delete Fail.");
		}
		redirect( BASE_URL . 'daily_episode_update' );
	}
	
	public function edit($id = NULL){ 
		
        if(isset($_REQUEST['episode_edit'])){
		   print_r($_REQUEST);
		   $data_array = array('season_name' => $_REQUEST['season_name'], 
		   							'sequence' => $_REQUEST['sequence'], 
										'url' => $_REQUEST['url'], 
											'seasons_description' => $_REQUEST['seasons_description']);
           if($this->series_m->update_season($data_array, $id)){
		   		$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('daily_episode_update').'" target="_blank">Deleted</a>');          
				$this->session->set_flashdata('success',"Deleted successfully.");
				redirect( BASE_URL . 'daily_episode_update' );
		   }
		}
		
		$this->data['episode_details'] = $this->series_m->get_episode_id($id); 
		$this->data['_view'] = DEFAULT_THEME . 'daily_episode_update/edit';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function fetch_season(){
		$episode_day = $_REQUEST['episode_day']; 
		$episode_date = $_REQUEST['episode_date']; 
		//echo $episode_day;
		$series = $this->series_m->getSeriesDailyUpdate();
		
		$reries_array = array();
		foreach($series as $key=>$val){
			$reries_array[] = "'".$val['id']."'";
		}
		//echo $episode_day;
		$season_fetch_by_date = $this->series_m->season_fetch($episode_day, $reries_array);
		
		/*echo '<pre>';
		print_r($season_fetch_by_date);*/
		
		$get_all_daily_episode = $this->series_m->daily_episode_update_where('episode_date',date('Y-m-d', strtotime($episode_date)));
		$set_season_id = array();
		foreach($get_all_daily_episode as $key=>$val){
			//$set_season_id[] = $val['season_id'];
			array_push($set_season_id,$val['season_id']);
		}
		
		foreach($series as $serieskey=>$seriesval){
			echo '<optgroup label="'.$seriesval['name'].'">';
				foreach($season_fetch_by_date as $seasonkey=>$seasonval){
					if($seriesval['id'] == $seasonval['series_id']){
						$already_add = '';
						$already_add_color = '';
						if(in_array($seasonval['id'], $set_season_id)){
							$already_add = ' - Added';
							$already_add_color = 'red';
						}
						echo '<option value="'.$seasonval['id'].'" style="color:'.$already_add_color.';">'.$seasonval['name'].' ('.$seriesval['name'].') '.$already_add.'</option>';
						
					}
			    }							
			echo '</optgroup>';
		}
	}
	
}
