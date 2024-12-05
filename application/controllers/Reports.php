<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends User_Controller {

    public function __construct()
    {
        parent::__construct(); 
        $this->data['is_allow']= check_permission(7);
        $this->load->model('reports_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Reports');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "reports";
        $this->data['sub_nav'] = "analytics";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Reports', 'reports');
    }

    public function index()
    {
        check_allow('view',$this->data['is_allow']);
        redirect(site_url('reports/analytics'));
    }
	public function analytics()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'reports/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'reports/analytics';
        $this->data['page_title'] = "Analytics";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements */
        $this->data['analytics']= $this->reports_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function getAnalytics(){
        $id=$this->input->post('id');
        $this->data['details']= $this->reports_m->get_by(array('id'=>$id), TRUE);
        echo $this->load->view(DEFAULT_THEME . 'reports/_analytics_details',$this->data, TRUE);
    }
}
