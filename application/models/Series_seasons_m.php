<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Series_seasons_m extends MY_Model {
	protected $_table_name = 'series_seasons';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		'series_id' => array(
			'field' => 'series_id',
			'label' => 'Series ID',
			'rules' => ''
		),
		'season_number' => array(
			'field' => 'season_number',
			'label' => 'Season Number',
			'rules' => ''
		),
		'is_kids_friendly' => array(
			'field' => 'is_kids_friendly',
			'label' => 'Kids Friendly',
			'rules' => ''
		),
		'childlock' => array(
			'field' => 'childlock',
			'label' => 'Childlock',
			'rules' => ''
		),
		'year' => array(
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
		'rating'=> array(
			'field' => 'rating',
			'label' => 'Rating',
			'rules' => ''
		),
		'token_id' => array(
			'field' => 'token_id',
			'label' => 'token_id',
			'rules' => ''
		),
		'dbselect' => array(
			'field' => 'dbselect',
			'label' => 'dbselect',
			'rules' => ''
		),
		/*'producer' => array(
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
		'url'=> array(
			'field' => 'url',
			'label' => 'Url',
			'rules' => ''
		),
		'age_category'=> array(
			'field' => 'age_category',
			'label' => 'Age Category',
			'rules' => ''
		),
		'subtitles'=> array(
			'field' => 'subtitles',
			'label' => 'Sub Titles',
			'rules' => ''
		),
		'accessrule'=> array(
			'field' => 'accessrule',
			'label' => 'Access Rule',
			'rules' => ''
		),*/
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
		'show_on_home'=> array(
			'field' => 'show_on_home',
			'label' => 'Show on Home',
			'rules' => ''
		),
		/*'is_payperview'=> array(
			'field' => 'is_payperview',
			'label' => 'Is Pay Per View',
			'rules' => ''
		),
		'rule_payperview'=> array(
			'field' => 'rule_payperview',
			'label' => 'Rule Pay Per View',
			'rules' => ''
		),
		'has_drm'=> array(
			'field' => 'has_drm',
			'label' => 'Has DRM',
			'rules' => ''
		),
		'secure_stream'=> array(
			'field' => 'secure_stream',
			'label' => 'Secure Stream',
			'rules' => ''
		),
		'tokenize'=> array(
			'field' => 'tokenize',
			'label' => 'Tokenize',
			'rules' => ''
		),
		'token_id'=> array(
			'field' => 'token_id',
			'label' => 'Token',
			'rules' => ''
		),*/
		'tmdb_id'=> array(
			'field' => 'tmdb_id',
			'label' => 'Tmdb_id',
			'rules' => ''
		),
		'imported'=> array(
			'field' => 'imported',
			'label' => 'Imported',
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
		'session_url' => array(
			'field' => 'session_url',
			'label' => 'URL',
			'rules' => ''
		),
		'url_description' => array(
			'field' => 'url_description',
			'label' => 'URL Description',
			'rules' => ''
		),
		'title' => array(
			'field' => 'title',
			'label' => 'Title',
			'rules' => ''
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function get_tokens(){
		$query = $this->db->get('token');
		return $query->result();
	}

	public function delete_seasons_series_id($series_id){
		$this->db->delete('series_seasons', array('series_id' =>$series_id));
	}
	
	public function get_seasons_series_id($tmdb_id,$season_number){ //echo $tmdb_id;
		$this->db->select('*');
		$this->db->where(array('tmdb_id'=>$tmdb_id, 'season_number' => $season_number));
		$query = $this->db->get('series_seasons');
		return $query->row();
	}
}

/* End of file Series_seasons_m.php */
/* Location: ./application/models/Series_seasons_m.php */