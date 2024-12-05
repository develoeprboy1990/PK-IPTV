<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Series_m extends MY_Model {

	protected $_table_name = 'series';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		'tmbd_id' => array(
			'field' => 'tmbd_id',
			'label' => 'tmbd_id',
			'rules' => ''
		),
		'dbselect' => array(
			'field' => 'dbselect',
			'label' => 'DB Select',
			'rules' => ''
		),
		/*'is_kids_friendly' => array(
			'field' => 'is_kids_friendly',
			'label' => 'Kids Friendly',
			'rules' => ''
		),*/
		'childlock' => array(
			'field' => 'childlock',
			'label' => 'Childlock',
			'rules' => ''
		),
		/*'year' => array(
			'field' => 'year',
			'label' => 'Year',
			'rules' => ''
		), 
		'actor' => array(
			'field' => 'actor',
			'label' => 'Actor',
			'rules' => ''
		),
		'language' => array(
			'field' => 'language',
			'label' => 'Language',
			'rules' => ''
		),
		'tags' => array(
			'field' => 'tags',
			'label' => 'Tags',
			'rules' => ''
		),
		'description' => array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => ''
		),
		'duration' => array(
			'field' => 'duration',
			'label' => 'Duration',
			'rules' => ''
		),
		'producer' => array(
			'field' => 'producer',
			'label' => 'Producer',
			'rules' => ''
		),
		'director'=> array(
			'field' => 'director',
			'label' => 'Director',
			'rules' => ''
		),
		'studio'=> array(
			'field' => 'studio',
			'label' => 'Studio',
			'rules' => ''
		),
		'trailer'=> array(
			'field' => 'trailer',
			'label' => 'Trailer',
			'rules' => ''
		),
		'rating'=> array(
			'field' => 'rating',
			'label' => 'Rating',
			'rules' => ''
		),
		'age_category'=> array(
			'field' => 'age_category',
			'label' => 'Age Category',
			'rules' => ''
		),
		'overlay_enabled'=> array(
			'field' => 'overlay_enabled',
			'label' => 'Overlay',
			'rules' => ''
		),
		'preroll_enabled'=> array(
			'field' => 'preroll_enabled',
			'label' => 'Preroll',
			'rules' => ''
		),
		'ticker_enabled'=> array(
			'field' => 'ticker_enabled',
			'label' => 'Ticker Enabled',
			'rules' => ''
		),
		
		'day_select'=> array(
			'field' => 'day_select',
			'label' => 'Day Select',
			'rules' => ''
		),*/
		'ott_platforms' => array(
		    'field' => 'ott_platforms',
		    'label' => 'OTT Platforms',
		    'rules' => ''
		),
		'tv_show_platform_status' => array(
		'field' => 'tv_show_platform_status',
		'label' => 'TV Show Platform Status',
		'rules' => ''
		),
		'tv_show_platforms' => array(
		    'field' => 'tv_show_platforms',
		    'label' => 'TV Show Platforms',
		    'rules' => ''
		),
		'position'=> array(
			'field' => 'position',
			'label' => 'Position',
			'rules' => ''
		),
		'language_id'=> array(
			'field' => 'language_id',
			'label' => 'Language',
			'rules' => ''
		),
		'show_on_home'=> array(
			'field' => 'show_on_home',
			'label' => 'Show on Home',
			'rules' => ''
		),
		'active'=> array(
			'field' => 'active',
			'label' => 'Active',
			'rules' => ''
		),
		'sun_day'=> array(
			'field' => 'sun_day',
			'label' => 'Sun Day',
			'rules' => ''
		),
		'mon_day'=> array(
			'field' => 'mon_day',
			'label' => 'Mon Day',
			'rules' => ''
		),
		'tues_day'=> array(
			'field' => 'tues_day',
			'label' => 'Tues Day',
			'rules' => ''
		),
		'wednes_day'=> array(
			'field' => 'wednes_day',
			'label' => 'Wednes Day',
			'rules' => ''
		),
		'thirs_day'=> array(
			'field' => 'thirs_day',
			'label' => 'Thirs Day',
			'rules' => ''
		),
		'fri_day'=> array(
			'field' => 'fri_day',
			'label' => 'Fri Day',
			'rules' => ''
		),
		'satur_day'=> array(
			'field' => 'satur_day',
			'label' => 'Satur Day',
			'rules' => ''
		),
		'episode_update' => array(
			'field' => 'episode_update',
			'label' => 'Episode Update',
			'rules' => ''
		),
		'user_id' => array(
			'field' => 'user_id',
			'label' => 'User',
			'rules' => ''
		)		
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getSeries(){
		/*$sql="SELECT s.*,ss.name store_name FROM series s
		     JOIN series_store ss on ss.id=s.store_id";*/
		/*$sql="SELECT s.*,ss.name store_name FROM series s
		     JOIN series_store ss on ss.id=s.store_id order by s.id DESC";*/
		$sql="SELECT s.*,ss.name store_name,l.name language_name 
			 FROM series s
		     LEFT JOIN series_store ss on ss.id=s.store_id
		     LEFT JOIN languages l on l.id=s.language_id";	 
		//echo $sql;exit;
		$query = $this->db->query($sql);
		/*echo '<pre>';
		print_r($query->result_array());exit;*/
		return $query->result_array();
	}

	public function getSeriesDailyUpdate(){
		/*$sql="SELECT s.*,ss.name store_name FROM series s
		     JOIN series_store ss on ss.id=s.store_id";*/
		/*$sql="SELECT s.*,ss.name store_name FROM series s
		     JOIN series_store ss on ss.id=s.store_id order by s.id DESC";*/
		$sql="SELECT s.*,ss.name store_name FROM series s
		     JOIN series_store ss on ss.id=s.store_id where s.episode_update='1'";	 
		//echo $sql;exit;
		$query = $this->db->query($sql);
		/*echo '<pre>';
		print_r($query->result_array());exit;*/
		return $query->result_array();
	}
	
	/*public function check_daily_episode_seasion($values){
		$this->db->select('*');		
		$this->db->from('daily_episode_update');
		$this->db->where('episode_date', $values['episode_date']);
		$this->db->where_in('season_id', $values['season_set']);
		$query = $this->db->get(); 
		$results = $query->result_array();
		return $results;
	}*/
	public function check_daily_episode_seasion($values) {
	    // Convert date from 'DD-MM-YYYY' to 'YYYY-MM-DD'
	   
	    $date = DateTime::createFromFormat('d-m-Y', $values['episode_date']);
	    if ($date) {
	        $formatted_date = $date->format('Y-m-d'); // Convert date to 'YYYY-MM-DD' format
	    } else {
	        // Handle invalid date format error
	        return []; // Or handle the error as per your requirements
	    }

	    $this->db->select('*');		
	    $this->db->from('daily_episode_update');
	    $this->db->where('episode_date', $formatted_date);
	    $this->db->where_in('season_id', $values['season_set']);
	    $query = $this->db->get(); 
	    $results = $query->result_array();
	    return $results;
	}
	
	public function deleted_daily_episode_seasion($id){
		$this -> db -> where('id', $id);
		$this -> db -> delete('daily_episode_update');
		if ($this->db->affected_rows() == '1') {
			return TRUE;
		} else {
			return false;
		}
	}

	public function daily_episode_update(){
			$this->db->select('*');		
			$this->db->from('daily_episode_update');
			//$this->db->where_in('id', $values['season_set']);
			$query = $this->db->get(); 
			$results = $query->result_array();
			return $results;
	}
	
	public function daily_episode_update_active(){
			$this->db->select('*');		
			$this->db->from('daily_episode_update');
			$this -> db -> where('is_added', '0');	
			$query = $this->db->get(); 
			$results = $query->result_array();
			return $results;
	}
	
	public function daily_episode_update_log($select_log_data){
			$this->db->select('*');		
			$this->db->from('daily_episode_update');
			$this -> db -> where('episode_date', $select_log_data);	
			$this -> db -> where('is_added', '1');	
			$query = $this->db->get(); 
			$results = $query->result_array();
			return $results;
	}
	
	public function daily_episode_update_where($key, $val){
			$this->db->select('*');				
			$this->db->from('daily_episode_update');
			$this -> db -> where($key, $val);	
			//$this->db->where_in('id', $values['season_set']);
			$query = $this->db->get(); 
			$results = $query->result_array();
			return $results;
			/*$sql="SELECT * from daily_episode_update where episode_date='".$val."'";
			echo $sql;
			$query = $this->db->query($sql);			
			return $query->result_array();*/
	}
	
	public function season_fetch($episode_day , $reries_array){
			$sql="SELECT * from series_seasons where series_id in(". implode(',',$reries_array).")";
			if($episode_day == 0){
				$sql.=" and sun_day=1";
			}elseif($episode_day == 1){
				$sql.="and mon_day=1";
			}elseif($episode_day == 2){
				$sql.="and tues_day=1";
			}elseif($episode_day == 3){
				$sql.="and wednes_day=1";
			}elseif($episode_day == 4){
				$sql.="and thirs_day=1";
			}elseif($episode_day == 5){
				$sql.="and fri_day=1";
			}elseif($episode_day == 6){
				$sql.="and satur_day=1";
			}
//echo $sql;
			$query = $this->db->query($sql);			
			return $query->result_array();
	}
	
	public function update_season($data, $id){
		$this->db->where('id', $id);
		$this->db->update('daily_episode_update', $data);
		if ($this->db->affected_rows() == '1') {
			return TRUE;
		} else {
			return false;
		}
	}
	
	public function get_episode_id($id){ 
		$this->db->select('*');
		$this->db->where(array('id'=>$id));
		$query = $this->db->get('daily_episode_update'); 
		$res = $query->row_array();
		//print_r($res);exit;
		return $res;
	}
	
	public function insert_episode_daily($data){ 
		$this->db->insert('series_episode', $data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	public function create_daily_episode($values){
		$this->db->select('*');		
		$this->db->from('series_seasons');
		$this->db->where_in('id', $values['season_set']);
		$query = $this->db->get(); 
		$results = $query->result_array();
		
		/*echo '<pre>';
		print_r($results);exit;*/
		
		$sequence = 1;
		$sql = "INSERT INTO daily_episode_update(episode_date, series_name, season_id, season_name, title, url, seasons_description, sequence) VALUES ";
		foreach($results as $key=>$val){
		
			$sql_sequence = 'SELECT MAX(`sequence_id`) as seq_id FROM `series_episode` where season_id="'.$val['id'].'"';
			$query_sequence = $this->db->query($sql_sequence);
			$res_sequence = $query_sequence->result_array();
			$sequenceId = $res_sequence[0]['seq_id'] + $sequence;
			
			
			$date_format = date_format (date_create($values['episode_date']),DATE_FORMAT);
			
			
			$replace = array( '<day>' => date('D',strtotime($values['episode_date'])),
							   '<Day>' => date('D',strtotime($values['episode_date'])),
							   '<DAY>' => date('D',strtotime($values['episode_date'])),
							   '<Date>' => $date_format,
							   '<date>' => $date_format,
							   '<DATE>' => $date_format,
							   '<sequence>' => $sequenceId,
							   '<Sequence>' => $sequenceId,
							   '<SEQUENCE>' => $sequenceId
							);
//die ($values['episode_date']);
			$date_for_title = date_format (date_create($values['episode_date']),DATE_FORMAT_TITLE);
			
			
			$replace2 = array( '<day>' => date('D',strtotime($values['episode_date'])),
							'<Day>' => date('D',strtotime($values['episode_date'])),
							'<DAY>' => date('D',strtotime($values['episode_date'])),
							  
							'<Date>' => $date_for_title,
							'<date>' => $date_for_title,
							'<DATE>' => $date_for_title,
							'<sequence>' => $sequenceId,
							'<Sequence>' => $sequenceId,
							'<SEQUENCE>' => $sequenceId
						 );

			//echo 'Title :'.str_replace("<day>",date('D',strtotime($values['episode_date'])),str_replace("<date>",$values['episode_date'],$val['title'])).'</br>';
			$title = $this->strReplaceAssoc($replace2, $val['title']);
			$session_url = $this->strReplaceAssoc($replace, $val['session_url']);
			$url_description = $this->strReplaceAssoc($replace, $val['url_description']);
			$sql.='("'. date ('Y-m-d', strtotime($values['episode_date'])).'","'.$val['series_id'].'","'.$val['id'].'","'.$val['name'].'","'.$title.'","'.$session_url.'","'.$url_description.'","'.$sequence.'"),';
			$sequence++;
		}	
		//echo $sql;	
		$query = $this->db->query(rtrim($sql,','));	
		
	}

	public function strReplaceAssoc(array $replace, $subject) {
   		return str_replace(array_keys($replace), array_values($replace), $subject);   

	}

	public function get_channels_groups($channel_id){
		$this->db->select('group_id');
		$this->db->where(array('channel_id'=>$channel_id));
		$query = $this->db->get('channel_to_group');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['group_id'];
		}
		return $ids;
	}

	public function get_tokens(){
		$query = $this->db->get('token');
		return $query->result();
	}

	public function delete_channels_groups($channel_id){
			$this->db->delete('channel_to_group', array('channel_id' =>$channel_id));
	}

	public function get_packages_by_channel($channel_id){
		$this->db->select('package_id');
		$this->db->where(array('channel_id'=>$channel_id));
		$query = $this->db->get('package_to_channel');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['package_id'];
		}
		return $ids;
	}

	public function delete_channels_package($channel_id){
			$this->db->delete('package_to_channel', array('channel_id' =>$channel_id));
	}
	
	public function get_store_info_tmbd($tmbd){ 
		$this->db->select('*');
		$this->db->where(array('tmbd_id'=>$tmbd));
		$query = $this->db->get('series'); 
		return $query->row();
	}
	
	public function get_store_info_all_tmbd($tmbd_id){ //echo $tmbd;exit;
		$this->db->select('*');
		$this->db->where(array('tmbd_id'=>$tmbd_id));
		$query = $this->db->get('series');
		
		
		//echo '<pre>';
		$ids=array();
		foreach($query->result_array() as $row){
			//print_r($row);
			$ids[]=$row['store_id'];
		}
		return $ids;
	}
	
	public function get_store_info_id($id){ 
		$this->db->select('*');
		$this->db->where(array('id'=>$id));
		$query = $this->db->get('series'); 
		return $query->row();
	}
	
	public function get_series_seasons_info_id($id){ 
		$this->db->select('*');
		$this->db->where(array('id'=>$id));
		$query = $this->db->get('series_seasons'); 
		return $query->row();
	}

	public function get_series_and_tvshows_count()
	{
	    $sql = "SELECT 
	                SUM(CASE WHEN ss.name NOT LIKE '%TV Show%' THEN 1 ELSE 0 END) as series_count,
	                SUM(CASE WHEN ss.name LIKE '%TV Show%' THEN 1 ELSE 0 END) as tvshows_count
	            FROM series s
	            JOIN series_store ss ON ss.id = s.store_id";
	    
	    $query = $this->db->query($sql);
	    return $query->row_array();
	}

	// Add these methods to Series_m class:
	public function get_tv_show_platforms_by_series($series_id){
	    $this->db->select('platform_id');
	    $this->db->where(array('series_id'=>$series_id));
	    $query = $this->db->get('series_to_tv_platforms');
	    $ids=array();
	    foreach($query->result_array() as $row){
	        $ids[]=$row['platform_id'];
	    }
	    return $ids;
	}

	public function delete_tv_show_platforms_by_series($series_id){
	    $this->db->delete('series_to_tv_platforms', array('series_id' =>$series_id));
	}

	public function count_series_by_store($store_id) {
    $this->db->from('series');
    $this->db->where("store_id", $store_id);
    return $this->db->count_all_results();
}

public function get_all_series_growth_data() {
    $sql = "SELECT 
        DATE(s.created_at) as date,
        SUM(CASE WHEN ss.name NOT LIKE '%TV Show%' THEN 1 ELSE 0 END) as series_count,
        SUM(CASE WHEN ss.name LIKE '%TV Show%' THEN 1 ELSE 0 END) as tvshows_count
        FROM series s
        JOIN series_store ss ON ss.id = s.store_id
        GROUP BY DATE(s.created_at)
        ORDER BY date ASC";
        
    $query = $this->db->query($sql);
    return $query->result_array();
}

}

/* End of file Movies_m.php */
/* Location: ./application/models/Movies_m.php */