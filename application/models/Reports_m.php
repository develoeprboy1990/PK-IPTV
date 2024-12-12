<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_m extends MY_Model {
	protected $_table_name = 'analytics_report';

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getAnalytics(){
		$sql="SELECT ar.*,c.first_name,c.last_name FROM analytics_report ar
		      JOIN customer c on c.id=ar.user_id";
		$query=$this->db->query($sql);
		return $query->result();
	}

	public function get_devices_by_product($product_id){
		$sql="SELECT * FROM devices d
		      JOIN product_to_devices pd on d.id=pd.device_id
		      WHERE pd.product_id=".$product_id;
		$query=$this->db->query($sql);

		/*echo $this->db->last_query();
		exit;*/
		return $query->result();
	}

	public function get_devices_by_customer($id){
		$sql="SELECT * FROM customer_to_devices 
		      WHERE customer_id=".$id;
		$query=$this->db->query($sql);
		return $query->result();
	}
	// Add these methods to Reports_m class

	public function get_user_quarterly_movies($user_id, $year = null) {
	    if (!$year) {
	        $year = date('Y');
	    }
	    
	    $sql = "SELECT 
	        COUNT(CASE WHEN QUARTER(created_at) = 1 THEN 1 END) as q1,
	        COUNT(CASE WHEN QUARTER(created_at) = 2 THEN 1 END) as q2,
	        COUNT(CASE WHEN QUARTER(created_at) = 3 THEN 1 END) as q3,
	        COUNT(CASE WHEN QUARTER(created_at) = 4 THEN 1 END) as q4
	        FROM movie 
	        WHERE user_id = ? 
	        AND YEAR(created_at) = ?";
	    
	    $query = $this->db->query($sql, array($user_id, $year));
	    $result = $query->row_array();
	    
	    // Format for sparkline
	    return implode(', ', array($result['q1'], $result['q2'], $result['q3'], $result['q4']));
	}

	public function get_user_quarterly_series($user_id, $year = null) {
	    if (!$year) {
	        $year = date('Y');
	    }
	    
	    $sql = "SELECT 
	        COUNT(CASE WHEN QUARTER(created_at) = 1 THEN 1 END) as q1,
	        COUNT(CASE WHEN QUARTER(created_at) = 2 THEN 1 END) as q2,
	        COUNT(CASE WHEN QUARTER(created_at) = 3 THEN 1 END) as q3,
	        COUNT(CASE WHEN QUARTER(created_at) = 4 THEN 1 END) as q4
	        FROM series 
	        WHERE user_id = ? 
	        AND YEAR(created_at) = ?";
	    
	    $query = $this->db->query($sql, array($user_id, $year));
	    $result = $query->row_array();
	    
	    // Format for sparkline
	    return implode(', ', array($result['q1'], $result['q2'], $result['q3'], $result['q4']));
	}

	public function get_user_total_movies($user_id) {
	    $this->db->where('user_id', $user_id);
	    return $this->db->count_all_results('movie');
	}

	public function get_user_total_series($user_id) {
	    $this->db->where('user_id', $user_id);
	    return $this->db->count_all_results('series');
	}

	public function get_chart_data() {
	    $sql = "SELECT 
	            u.id,
	            CONCAT(u.first_name, ' ', u.last_name) as user_name,
	            (SELECT COUNT(*) FROM movie WHERE user_id = u.id) as movie_count,
	            (SELECT COUNT(*) FROM series WHERE user_id = u.id) as series_count
	            FROM users u 
	            ORDER BY u.id";
	    
	    $query = $this->db->query($sql);
	    $results = $query->result_array();
	    
	    $chart_data = array(
	        'categories' => array(),
	        'movies' => array(),
	        'series' => array()
	    );
	    
	    foreach ($results as $row) {
	        $chart_data['categories'][] = $row['user_name'];
	        $chart_data['movies'][] = (int)$row['movie_count'];
	        $chart_data['series'][] = (int)$row['series_count'];
	    }
	    
	    return $chart_data;
	}
}
/* End of file Reports_m.php */
/* Location: ./application/models/Reports_m.php */