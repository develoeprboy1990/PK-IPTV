<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movies_m extends MY_Model {

	protected $_table_name = 'movie';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
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
		'ott_platforms' => array(
		'field' => 'ott_platforms',
		'label' => 'OTT Platforms',
		'rules' => 'required'
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
		'dbselect' => array(
			'field' => 'dbselect',
			'label' => 'Dbselect',
			'rules' => ''
		),
		'age_rating' => array(
			'field' => 'age_rating',
			'label' => 'age_rating',
			'rules' => ''
		),
		'vast_url' => array(
			'field' => 'vast_url',
			'label' => 'vast_url',
			'rules' => ''
		),
		'subtitle_url' => array(
			'field' => 'subtitle_url',
			'label' => 'subtitle_url',
			'rules' => ''
		),
		'store_id' => array(
			'field' => 'store_id',
			'label' => 'store_id',
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
		),*/
		'server_url_trailer'=> array(
			'field' => 'server_url_trailer',
			'label' => 'Trailer',
			'rules' => ''
		),
		'trailer'=> array(
			'field' => 'trailer',
			'label' => 'Trailer Stream Name',
			'rules' => 'required|trim'
		),
		'token_trailer'=> array(
			'field' => 'token_trailer',
			'label' => 'Tokenize',
			'rules' => 'required'
		),
		/*'server_url_1'=> array(
			'field' => 'server_url_1',
			'label' => 'Movie Url',
			'rules' => ''
		),
		'stream_name_1'=> array(
			'field' => 'stream_name_1',
			'label' => 'Movie Stream Name',
			'rules' => 'required|trim'
		),
		'movie_token_1'=> array(
			'field' => 'movie_token_1',
			'label' => 'Tokenize',
			'rules' => 'required'
		),*/
		'rating'=> array(
			'field' => 'rating',
			'label' => 'Rating',
			'rules' => ''
		),
		/*'age_category'=> array(
			'field' => 'age_category',
			'label' => 'Age Category',
			'rules' => ''
		),*/
		'subtitles'=> array(
			'field' => 'subtitles',
			'label' => 'Sub Titles',
			'rules' => ''
		),
		/*'accessrule'=> array(
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
		'user_id'=> array(
			'field' => 'user_id',
			'label' => 'User',
			'rules' => ''
		)
	);
	
	public function __construct(){
		parent::__construct();
		//Do your magic here
	}

	public function get_movies(){
		$this->db->select('m.*,j.name language_name');
		$this->db->from($this->_table_name.' as m');
		$table_join = "m.language = j.id"; 
		$this->db->join('languages as j', $table_join);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function countmovies(){
		$this->db->select('count(`id`) as total_movies');		
		$this->db->from($this->_table_name);		
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_allmovies($start_limit, $row_peg){
		$this->db->select('*');
		/*$this->db->select('m.*,j.name language_name');
		$this->db->from($this->_table_name.' as m');
		$table_join = "m.language = j.id"; 
		$this->db->join('languages as j', $table_join);*/
		$this->db->order_by('id', 'desc');
		//$this->db->limit($row_peg,$start_limit);
		$this->db->from($this->_table_name);		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_allmovies_search($start_limit, $row_peg, $search_string){
		//$this->db->select('*');
		/*$this->db->select('m.*,j.name language_name');
		$this->db->from($this->_table_name.' as m');
		$table_join = "m.language = j.id"; 
		$this->db->join('languages as j', $table_join, 'INNER');
		$this->db->order_by('m.id', 'desc');
		$this->db->limit($row_peg,$start_limit);
		$this->db->like('m.name', $search_string);
		$this->db->like('m.description', $search_string);*/	
		
		$sql = "SELECT m.*, lan.code AS l_code
					FROM `movie` as m 
					INNER join languages as lan ON m.language = lan.id 
					WHERE m.`name` LIKE '%".$search_string."%' OR lan.code LIKE '%".$search_string."%' order by m.id desc  LIMIT 0, ".$row_peg;
					
		//echo $sql;exit;
		$query=$this->db->query($sql);
		//$this->db->from($this->_table_name);
			
		//$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_movie_urls($id){
		$this->db->where(array('movie_id'=>$id));
		$query = $this->db->get('movie_stream_urls');
		return $query->result();
	}

	public function deleteMovieUrls($id){
		$this->db->delete('movie_stream_urls', array('movie_id' =>$id));
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

	public function get_genres_by_movie($movie_id){
		$this->db->select('genre_id');
		$this->db->where(array('movie_id'=>$movie_id));
		$query = $this->db->get('movie_to_genres');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['genre_id'];
		}
		return $ids;
	}

	public function get_genres_by_store($store_id){
		//$this->db->where(array('store_id'=>$store_id));
		$query = $this->db->get('movie_genre');
		return $query->result();
	}

	public function delete_genres_by_movie($movie_id){
		$this->db->delete('movie_to_genres', array('movie_id' =>$movie_id));
	}

	public function get_movies_count(){
        return $this->db->count_all('movie');
    }

	public function get_server_url($server_url_id) {
	    $this->db->select('url');
	    $this->db->from('server_items_urls');
	    $this->db->where('id', $server_url_id);
	    $query = $this->db->get();
	    
	    if ($query->num_rows() > 0) {
	        return $query->row()->url;
	    }
	    return false;
	}

	public function get_movie_urls_with_server($movie_id) {
	    // Get trailer URL
	    $this->db->select('m.server_url_trailer, m.trailer, s1.url as trailer_server_url');
	    $this->db->from('movie m');
	    $this->db->join('server_items_urls s1', 'm.server_url_trailer = s1.id', 'left');
	    $this->db->where('m.id', $movie_id);
	    $trailer_query = $this->db->get();
	    $trailer_result = $trailer_query->row_array();

	    $trailer_url = $trailer_result['trailer_server_url'] .'/'. $trailer_result['trailer'];

	    // Get movie URLs
	    $this->db->select('msu.stream_name, msu.language_id, l.name as language_name, s2.url as movie_server_url');
	    $this->db->from('movie_stream_urls msu');
	    $this->db->join('server_items_urls s2', 'msu.server_url_id = s2.id', 'left');
	    $this->db->join('languages l', 'msu.language_id = l.id', 'left');
	    $this->db->where('msu.movie_id', $movie_id);
	    $movie_urls_query = $this->db->get();
	    $movie_urls_result = $movie_urls_query->result_array();

	    $movie_urls = array();
	    foreach ($movie_urls_result as $url) {
	        $movie_urls[] = array(
	            'url' => $url['movie_server_url'] .'/'. $url['stream_name'],
	            'language' => $url['language_name']
	        );
	    }

	    return array(
	        'trailer_url' => $trailer_url,
	        'movie_urls' => $movie_urls
	    );
	}

	// Add these methods to Movies_m model

	public function get_total_movies() {
	    return $this->db->count_all($this->_table_name);
	}

	public function get_filtered_movies($start, $length, $search, $order) {
	    $this->_get_movies_query($search, $order);
	    
	    if($length != -1) {
	        $this->db->limit($length, $start);
	    }
	    
	    $query = $this->db->get();
	    return $query->result_array();
	}

	public function get_filtered_count($search) {
	    $this->_get_movies_query($search);
	    return $this->db->count_all_results();
	}

	private function _get_movies_query($search, $order = null) {
		//TRIM(CONCAT(u.first_name, " ", u.last_name)) AS user
	    $this->db->select('m.*, l.name as language_name, TRIM(CONCAT(u.first_name, " ", u.last_name)) AS user');
	    $this->db->from($this->_table_name . ' as m');
	    $this->db->join('languages as l', 'm.language = l.id', 'left');
	    $this->db->join('movie_store as ms', 'm.store_id = ms.id', 'left');
	    $this->db->join('users as u', 'm.user_id = u.id', 'left');
	    
	    if(!empty($search)) {
	        $this->db->group_start();
	        $this->db->like('m.name', $search);
	        $this->db->or_like('m.description', $search);
	        $this->db->or_like('m.actor', $search);
	        $this->db->or_like('m.year', $search);
	        $this->db->or_like('l.name', $search);
	        $this->db->group_end();
	    }
	    
	    if($order) {
	        $column_index = $order['column'];
	        //echo $column_index;exit();
	        $direction = $order['dir'];
	        
	        
	        // Define sortable columns
	        $columns = array(
	            0 => 'm.id',
	            1 => 'm.name',
	            4 => 'ms.name',
	            8 => 'l.name',
	            9 => 'm.year',
	            12 => 'm.rating',
	            14 => 'm.show_on_home',
	            15 => 'm.status'
	        );
	        
	        if(isset($columns[$column_index])) {
	            $this->db->order_by($columns[$column_index], $direction);
	        }
	    } else {
	        $this->db->order_by('m.id', 'desc');
	    }
	}

	public function count_movies_by_store($store_id) {
	    $this->db->from('movie');
	    $this->db->where("FIND_IN_SET('".$store_id."', store_id) >", 0);
	    return $this->db->count_all_results();
	}

	public function get_all_movie_growth_data() {
	    $sql = "SELECT 
	        DATE(created_at) as date,
	        COUNT(*) as count
	        FROM movie 
	        GROUP BY DATE(created_at)
	        ORDER BY date ASC";
	        
	    $query = $this->db->query($sql);
	    return $query->result_array();
	}

	public function get_user_details($user_id) {
	    $this->db->select('CONCAT(first_name, " ", last_name) as full_name');
	    $this->db->from('users');
	    $this->db->where('id', $user_id);
	    $query = $this->db->get();
	    
	    if($query->num_rows() > 0) {
	        return $query->row()->full_name;
	    }
	    return 'Unknown User';
	}
	// In Movies_m.php
	public function validatePosterRatio($imagePath) {
	    if (!file_exists($imagePath)) {
	        return ['valid' => false, 'message' => 'Image file not found'];
	    }

	    list($width, $height) = getimagesize($imagePath);
	    $ratio = $width / $height;

	    if ($ratio >= 0.5 && $ratio <= 0.7) {
	        return [
	            'valid' => true,
	            'message' => 'Valid portrait dimensions',
	            'ratio' => $ratio,
	            'dimensions' => ['width' => $width, 'height' => $height]
	        ];
	    }

	    return [
	        'valid' => false,
	        'message' => 'Invalid poster ratio. Please upload a portrait image with width/height ratio between 0.5 and 0.7',
	        'ratio' => $ratio,
	        'dimensions' => ['width' => $width, 'height' => $height]
	    ];
	}
	public function getPosterValidation($url) {
	    if (empty($url)) {
	        return [
	            'valid' => false,
	            'message' => 'No poster URL provided'
	        ];
	    }

	    try {
	        $imageSize = @getimagesize($url);
	        if (!$imageSize) {
	            return [
	                'valid' => false,
	                'message' => 'Unable to get image dimensions'
	            ];
	        }

	        $width = $imageSize[0];
	        $height = $imageSize[1];
	        $ratio = $width / $height;

	        return [
	            'valid' => ($ratio >= 0.5 && $ratio <= 0.7),
	            'ratio' => $ratio,
	            'dimensions' => [
	                'width' => $width,
	                'height' => $height
	            ],
	            'message' => ($ratio >= 0.5 && $ratio <= 0.7)
	                ? 'Valid poster dimensions'
	                : sprintf('Invalid ratio: %.2f. Required ratio: 0.5-0.7 (current: %dx%d)', 
	                    $ratio, $width, $height)
	        ];
	    } catch (Exception $e) {
	        return [
	            'valid' => false,
	            'message' => 'Error validating image dimensions'
	        ];
	    }
	}

}
/* End of file Movies_m.php */
/* Location: ./application/models/Movies_m.php */