<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dynamic_dependent_m extends CI_Model
{
	 function fetch_country()
	 {
	  	$this->db->order_by("name", "ASC");
	  	$query = $this->db->get("countries");
	  	return $query->result();
	 }

	 function fetch_state($country_id)
	 {
		  $this->db->where('country_id', $country_id);
		  $this->db->order_by('name', 'ASC');
		  $query = $this->db->get('states');
		  $output = '<option value="">Select State</option>';
		  foreach($query->result() as $row)
		  {
		   $output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
		  }
		  return $output;
	 }

	 function fetch_city($state_id)
	 {
		  $this->db->where('state_id', $state_id);
		  $this->db->order_by('name', 'ASC');
		  $query = $this->db->get('cities');
		  $output = '<option value="">Select City</option>';
		  foreach($query->result() as $row)
		  {
		   $output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
		  }
		  return $output;
	 }

	 function get_states($country_id)
	 {
		  $this->db->where('country_id', $country_id);
		  $this->db->order_by('name', 'ASC');
		  $query = $this->db->get('states');
		  return $query->result();
	 }

	 function get_cities($state_id)
	 {
		  $this->db->where('state_id', $state_id);
		  $this->db->order_by('name', 'ASC');
		  $query = $this->db->get('cities');
		  return $query->result();
	 }

	function get_country_name_by_id($id){
		$this->db->select("name");
		$this->db->where('id', $id);
	  	$query = $this->db->get("countries");
	  	return $query->row()->name;
	}
}
?>