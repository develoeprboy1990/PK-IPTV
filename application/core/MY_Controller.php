<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

 	var $data = array();

	public function __construct()
	{
		parent::__construct();
		

		$this->load->model('groups_channel_m');
		$this->load->model('channels_m');
		$this->load->model('packages_m');
		$this->load->model('channel_to_group_m');
		$this->load->model('employee_m');
		$this->load->model('group_m');
		$this->load->model('language_m');
		$this->load->model('operator_m');
		$this->load->model('permission_m');
		$this->load->model('role_m');
		$this->load->model('service_menu_item_m');
		$this->load->model('service_menu_package_item_m');
		$this->load->model('service_menu_package_m');
		$this->load->model('user_m');
        $this->load->model('settings_m');

        $ims= $this->settings_m->getValue('ims');
        $cms= $this->settings_m->getValue('cms');

        $this->data['site_name'] = $ims ." AND ". $cms;
	}


	public function do_upload($upload_path,$filename)
    {
        $config['upload_path']          = $upload_path;
        $config['allowed_types']        = 'jpg|png|jpeg';
        $config['max_size']             = 0;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $this->load->library('upload', $config, $filename);
        $this->$filename->initialize($config);
        if ( ! $this->$filename->do_upload($filename))
        {
                $error = $this->$filename->display_errors();
                $this->session->set_flashdata($filename . '_error', $error);
        }
        else
        {
                $data = array('upload_data' => $this->$filename->data());
                /*$image = strtolower($data['upload_data']['file_name']);*/
				$image = $data['upload_data']['file_name'];
                $image = addslashes($image);
               	return $image;
        }
    }


	public function array_from_post($data){
        $result = array();
        foreach ($data as $key => $d) {
            $current_data = $this->input->post($d);

            $current_data = $current_data;

            if (!is_array($current_data)) {
                $result[$d] = addslashes($current_data);
            } 
        }    
        return $result;
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */