<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Episodes_m extends MY_Model {

	protected $_table_name = 'series_episode';
	public $rules = array(
		'season_id' => array(
			'field' => 'season_id',
			'label' => 'Season ID',
			'rules' => ''
		),
		'title' => array(
			'field' => 'title',
			'label' => 'Title',
			'rules' => 'required|trim'
		),
		'description' => array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => ''
		),
		'actor' => array(
			'field' => 'actor',
			'label' => 'Actor',
			'rules' => ''
		),
		'url' => array(
			'field' => 'url',
			'label' => 'Url',
			'rules' => 'required|trim'
		),
		'server_url_id' => array(
			'field' => 'server_url_id',
			'label' => 'Server Url',
			'rules' => ''
		),
		/*'secure_stream' => array(
			'field' => 'secure_stream',
			'label' => 'Secure Stream',
			'rules' => ''
		),*/
		'language_id' => array(
			'field' => 'language_id',
			'label' => 'Language ID',
			'rules' => ''
		),
		'sequence_id' => array(
			'field' => 'sequence_id',
			'label' => 'Order',
			'rules' => 'required|trim|numeric|greater_than[0]|callback_check_sequence_unique'
       
		),
		
		'season_number' => array(
			'field' => 'season_number',
			'label' => 'Season Number',
			'rules' => ''
		),
		'episode_number' => array(
			'field' => 'episode_number',
			'label' => 'Episode Number',
			'rules' => ''
		),
		'tmdb_id' => array(
			'field' => 'tmdb_id',
			'label' => 'Tmdb Id',
			'rules' => ''
		),
		'token_id' => array(
			'field' => 'token_id',
			'label' => 'Tokenize',
			'rules' => 'required|trim'
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
	
	public function delete_episodes_by_series_id($series_id){
		$sql="DELETE FROM series_episode 
			  WHERE season_id IN 
			  (Select id FROM  series_seasons 
			  	WHERE series_id='$series_id')";
		$this->db->query($sql);
	}
	
	public function get_series_seasons_episode_id($tmbd_idbm, $season_number, $episode_number, $season_id){ 
		$this->db->select('*');	
		$this->db->where(array('season_id' => $season_id, 'tmdb_id' => $tmbd_idbm, 'season_number'=>$season_number,'episode_number' => $episode_number));
		$query = $this->db->get('series_episode');
		return $query->row();
	}
	
	public function get_max_sequence($season_id){
		$sql = 'SELECT MAX(`sequence_id`) as seq_id FROM `series_episode` where season_id="'.$season_id.'"';
		//echo $sql;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function get_series_seasons_episode_by_seasonid($season_id,$season_number, $tmbd_idbm){ 
		$this->db->select('*');	
		$this->db->where(array('season_id' => $season_id, 'tmdb_id' => $tmbd_idbm, 'season_number'=>$season_number));
		$query = $this->db->get('series_episode');
		$episode_added = array();
		foreach($query->result_array() as $row){ 
			//print_r($row);
			array_push($episode_added,$row['episode_number']);
			//$episode_added[] = $row['episode_number'];
		}
		return $episode_added;
	}

	// Add new method to get the next available sequence number
    public function get_next_sequence($season_id) {
        $this->db->select_max('sequence_id');
        $this->db->where('season_id', $season_id);
        $query = $this->db->get($this->_table_name);
        $result = $query->row();
        return ($result->sequence_id > 0) ? $result->sequence_id + 1 : 1;
    }

    // Add method to check if sequence is unique for a season
    public function is_sequence_unique($sequence_id, $season_id, $episode_id = null) {
        $this->db->where('season_id', $season_id);
        $this->db->where('sequence_id', $sequence_id);
        if ($episode_id) {
            $this->db->where('id !=', $episode_id);
        }
        return $this->db->get($this->_table_name)->num_rows() === 0;
    }


}

/* End of file Episodes_m.php */
/* Location: ./application/models/Episodes_m.php */