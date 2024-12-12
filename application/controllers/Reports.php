<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends User_Controller {

    public function __construct()
    {
        parent::__construct(); 
        $this->data['is_allow']= check_permission(7);
        $this->lang->load('users');

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


    public function users_report()
    {
        check_allow('view', $this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'reports/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'reports/users_report';
        $this->data['page_title'] = "User Report";
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['users'] = $this->ion_auth->users()->result();
        
        // Get current year
        $year = date('Y');
        
        // Get chart data
        $this->data['chart_data'] = $this->reports_m->get_chart_data();
        
        // Prepare user statistics
        foreach ($this->data['users'] as &$user) {
            $user->details_url = site_url('reports/user_details/' . $user->id);
            // Get quarterly data
            $user->movies_quarterly = $this->reports_m->get_user_quarterly_movies($user->id, $year);
            $user->series_quarterly = $this->reports_m->get_user_quarterly_series($user->id, $year);
            
            // Get totals
            $user->total_movies = $this->reports_m->get_user_total_movies($user->id);
            $user->total_series = $this->reports_m->get_user_total_series($user->id);
            
            // Calculate total
            $user->total_difference = $user->total_movies + $user->total_series;
            
            // Calculate quarterly total
            $movies_quarters = explode(', ', $user->movies_quarterly);
            $series_quarters = explode(', ', $user->series_quarterly);
            $differences = array();
            
            for ($i = 0; $i < 4; $i++) {
                $differences[] = $movies_quarters[$i] + $series_quarters[$i];
            }
            $user->quarterly_difference = implode(', ', $differences);
        }

        $this->data['analytics'] = $this->reports_m->get();
        $this->load->view(DEFAULT_THEME . '_layout', $this->data);
    }

    public function user_details($user_id)
    {
        check_allow('view', $this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'reports/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'reports/user_details';
        $this->data['page_title'] = "User Statistics";
        
        /* Breadcrumbs */
        //$this->breadcrumbs->push('User Statistics', 'reports/user_details');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        // Get user info
        $this->data['user'] = $this->ion_auth->user($user_id)->row();
        
        if (!$this->data['user']) {
            show_404();
        }

        // Get yearly stats for the past 3 years
        $years = array(date('Y'), date('Y', strtotime('-1 year')), date('Y', strtotime('-2 year')));
        $this->data['yearly_stats'] = array();
        
        foreach ($years as $year) {
            $this->data['yearly_stats'][$year] = array(
                'movies_quarterly' => $this->reports_m->get_user_quarterly_movies($user_id, $year),
                'series_quarterly' => $this->reports_m->get_user_quarterly_series($user_id, $year),
                'total_movies' => $this->reports_m->get_user_total_movies($user_id),
                'total_series' => $this->reports_m->get_user_total_series($user_id)
            );
        }

        $this->load->view(DEFAULT_THEME . '_layout', $this->data);
    }

    public function user_details_wise($user_id)
    {
        check_allow('view', $this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'reports/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'reports/user_details_wise';
        $this->data['page_title'] = "User Statistics";
        
        /* Breadcrumbs */
        //$this->breadcrumbs->push('User Statistics', 'reports/user_details');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        // Get user info
        $this->data['user'] = $this->ion_auth->user($user_id)->row();
        
        if (!$this->data['user']) {
            show_404();
        }

        // Get yearly stats for the past 3 years
        $years = array(date('Y'), date('Y', strtotime('-1 year')), date('Y', strtotime('-2 year')));
        $this->data['yearly_stats'] = array();
        
        foreach ($years as $year) {
            $this->data['yearly_stats'][$year] = array(
                'movies_quarterly' => $this->reports_m->get_user_quarterly_movies($user_id, $year),
                'series_quarterly' => $this->reports_m->get_user_quarterly_series($user_id, $year),
                'total_movies' => $this->reports_m->get_user_total_movies($user_id),
                'total_series' => $this->reports_m->get_user_total_series($user_id)
            );
        }

        $this->load->view(DEFAULT_THEME . '_layout', $this->data);
    }
}