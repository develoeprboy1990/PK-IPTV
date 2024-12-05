<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Securities extends User_Controller {

    public function __construct()
    {
        parent::__construct();

        $is_allow = $this->ion_auth->checkPermission(12); 
        $this->data['is_allow']= $is_allow;
        
        if(!isset($is_allow))
        {
           redirect('unauthorize', 'refresh');
        }

        $this->load->model('settings_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Securities');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "security";
        
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Securities', 'securities');
    }

	public function index123()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'securities/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'securities/edit';
        $this->data['page_title'] = "Securities";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['securities']= $this->settings_m->get_settings_by_type('4');
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function index($tab=1)
    { 
        check_allow('view',$this->data['is_allow']);
        $this->load->model('channels_m');
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'securities/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'securities/index';
        $this->data['page_title'] = "Securities";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['securities']= $this->settings_m->get_settings_by_type('4');
        $this->data['tokens']=$this->channels_m->get_tokens();
        $this->data['smtps']= $this->settings_m->get_settings_by_type('5');
        $this->data['drms']= $this->settings_m->get_settings_by_type('7');
        $this->data['activeTab'] = $tab;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function update(){
        check_allow('edit',$this->data['is_allow']);
        $id=$this->input->post('id');
        $data=array('value'=>$this->input->post('value'));
        $this->settings_m->save($id,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('securities').'" target="_blank">Security Settings Updated</a>');   
        echo "Updated Successfully";
    }
}
