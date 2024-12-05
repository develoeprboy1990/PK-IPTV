<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Epgs_chanels_m extends MY_Model {
	protected $_table_name = 'epgs_chanels';
	public $rules = array(
		'chanel_name' => array(
			'field' => 'chanel_name',
			'label' => 'chanel_name',
			'rules' => 'required|trim'
		),
		'epgs_id' => array(
			'field' => 'epgs_id',
			'label' => 'epgs_id',
			'rules' => 'required|trim'
		),
		'clanel_id' => array(
			'field' => 'clanel_id',
			'label' => 'clanel_id',
			'rules' => 'required|trim'
		),
		'icon' => array(
			'field' => 'icon',
			'label' => 'icon',
			'rules' => 'required|trim'
		)
		
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function deletemultiplerow($id){
		$this->db->select('id');
		$this->db->where(array('epgs_id'=>$id));
		$query = $this->db->get('epgs_chanels');
		
		if(count($query->result()) > 0){
			$this->db->where('epgs_id', $id);
			$this->db->delete('epgs_chanels');
			return $this->db->affected_rows();			
		}else {
			return '1'; 
		}
	}
	
	/*public function getValue($slug){
		$this->db->select('value');
		$this->db->where(array('slug'=>$slug));
		$query = $this->db->get('settings');
		$data=$query->row();
		return $data->value;
	}
*/
	public function chanel_logo($id){
		$this->db->select('*');
		$this->db->where(array('url_type'=>'1'));
		$query = $this->db->get('epgs_chanels');
		return $query->result();
	}


}

/* End of file Settings_m.php */
/* Location: ./application/models/Settings_m.php */