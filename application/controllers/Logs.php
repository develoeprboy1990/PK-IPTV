<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(32);
        $this->load->model('logs_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Logs');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "logs";
        $this->data['activeTab'] = 1;
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Logs', 'logs');
    }

	public function index($user_id="",$tab=1)
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'logs/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'logs/index';
        $this->data['page_title'] = "Logs";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* Logs */
        $this->data['activeTab'] = $tab;
        $this->data['customer_logs']=$this->logs_m->getLogs($user_id);
        $this->data['user_logs']=$this->logs_m->getUserLogs($user_id);
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL,$tab = NULL){
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'customers' ) : '';
        $this->logs_m->delete($id);
        $this->session->set_flashdata('success',"Log Deleted Successfully.");
        if($tab)
            redirect( BASE_URL . 'logs/index/admin/2' );
        else
            redirect( BASE_URL . 'logs' );
    }
}
