<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tv_show_platforms_m extends MY_Model {
    protected $_table_name = 'tv_show_platforms';
    public $rules = array(
        'name' => array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|trim'
        ),
        'order_no' => array(
            'field' => 'order_no',
            'label' => 'Display Order',
            'rules' => 'trim|integer'
        ),
        'language_id' => array(
            'field' => 'language_id',
            'label' => 'Language',
            'rules' => 'required|numeric'
        )
    );
    
    public function __construct()
    {
        parent::__construct();
    }

    // Modify the get method to join with languages table
    public function get($id = NULL, $single = FALSE)
    {
        $this->db->select('tv_show_platforms.*, languages.name as language_name');
        $this->db->join('languages', 'languages.id = tv_show_platforms.language_id', 'left');
        return parent::get($id, $single);
    }



    public function get_platforms_by_tv_show($series_id){
        $this->db->select('platform_id');
        $this->db->where(array('series_id'=>$series_id));
        $query = $this->db->get('series_to_tv_platforms');
        $ids=array();
        foreach($query->result_array() as $row){
            $ids[]=$row['platform_id'];
        }
        return $ids;
    }

    public function delete_platforms_by_tv_show($series_id){
        $this->db->delete('series_to_tv_platforms', array('series_id' =>$tv_show_id));
    }
}