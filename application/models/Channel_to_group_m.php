<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Channel_to_group_m extends MY_Model {

	protected $_table_name = 'channel_to_groups';
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
	
	public function get_channel_groups_by_customer($id){
		$this->db->select('channel_group_id');
		$this->db->where(array('customer_id'=>$id));
		$query = $this->db->get('customer_to_channel_groups');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['channel_group_id'];
		}
		return $ids;
	}	

	public function get_channel_groups_customer($id){
		$sql="SELECT cg.* FROM channel_group cg 
			  JOIN customer_to_channel_groups ccg on ccg.channel_group_id=cg.id
			  WHERE ccg.customer_id=$id";
		$query = $this->db->query($sql);
		return $query->result();
	}	

	public function get_channel_by_channel_groups($user_id){
		$sql="SELECT c.* FROM channel c 
			  WHERE id IN ( 
			  	SELECT channel_id 
			  	FROM channel_to_group cg 
			  	JOIN customer_to_channel_groups ccg on ccg.channel_group_id=cg.group_id
			  	WHERE ccg.customer_id=$user_id
			  	)";
		$query = $this->db->query($sql);

		return $query->result();
	}

	public function delete_channel_groups_by_customer($id){
			$this->db->delete('customer_to_channel_groups', array('customer_id' =>$id));
	}
}

/* End of file Channel_to_group_m.php */
/* Location: ./application/models/Channel_to_group_m.php */