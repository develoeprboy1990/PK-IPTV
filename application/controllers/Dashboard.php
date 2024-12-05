<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		
        $this->data['is_allow']= check_permission(3);
		$this->lang->load('users');
		$this->lang->load('actions');
		$this->load->model('customers_m');
		$this->load->model('movies_m');
		$this->load->model('series_m');

		$this->load->library('breadcrumbs');
		$this->load->library('page_title');
		
		/* Load Highcharts library */
	    $this->load->library('highcharts');

		$this->data['total_users'] = count($this->user_m->get());
		$this->data['total_employees'] = count($this->employee_m->get());
		$this->data['total_group'] = count($this->group_m->get());
		//Do your magic here
	}

	/*public function index()
	{
		$this->data['_view'] = DEFAULT_THEME . 'dashboard/index';
		$this->data['page_title'] = "Dashboard";
		
		// logged in customers
		$this->data['logged_in_customers'] = $this->customers_m->get_logged_in_customers();

		// expiring customers
		$this->data['expiring_customers'] = $this->customers_m->get_expiring_customers();

		// expiring customers
		$this->data['latest_subscriptions'] = $this->customers_m->get_latest_subscription();

		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	} */

	public function index(){
		if (!$this->ion_auth->logged_in())
		{
			redirect('login', 'refresh');
		}

		$id=$this->session->user_id;

		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_users_profile'), 'admin/groups/profile');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		/* Data */
		$id = (int) $id;
		$this->data['user_info'] = $this->ion_auth->user($id)->result();
              
        $role = $this->db->get_where('groups', array('id' => $this->data['user_info'][0]->role))->row();
        $this->data['user_info'][0]->role = $role->name; 
        $this->data['page_title'] = "Profile";
        $this->data['pagetitle'] = "Profile";
		$this->data['_view'] = DEFAULT_THEME . 'dashboard/profile';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function profile()
	{	

		if (!$this->ion_auth->logged_in())
		{
			redirect('login', 'refresh');
		}

		$id=$this->session->user_id;

		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_users_profile'), 'admin/groups/profile');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		/* Data */
		$id = (int) $id;
		$this->data['user_info'] = $this->ion_auth->user($id)->result();
              
        $role = $this->db->get_where('groups', array('id' => $this->data['user_info'][0]->role))->row();
        $this->data['user_info'][0]->role = $role->name; 
        $this->data['page_title'] = "Profile";
        $this->data['pagetitle'] = "Profile";
		$this->data['_view'] = DEFAULT_THEME . 'dashboard/profile';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}


	public function stats()
	{	
		$this->data['is_allow'] = check_permission(83);
		check_allow('view',$this->data['is_allow']);
		
	    if (!$this->ion_auth->logged_in())
	    {
	        redirect('login', 'refresh');
	    }

	    $id = $this->session->user_id;


	    /* Breadcrumbs */
	    $this->breadcrumbs->unshift(2, 'Statistics', 'dashboard/stats');
	    $this->data['breadcrumb'] = $this->breadcrumbs->show();
		/* Fetch customer statistics Start*/
	    $this->data['customer_stats'] = array(
	        'activated' => $this->customers_m->get_activated_count(),
	        'new' => $this->customers_m->get_new_count(),
	        'disabled' => $this->customers_m->get_disabled_count(),
	        'expired' => $this->customers_m->get_expired_count()
	    );
	    /* Fetch customer statistics End*/

	    

	    /* Fetch VOD statistics Start*/
	    $movie_count = $this->movies_m->get_movies_count();
		$series_tvshows_counts = $this->series_m->get_series_and_tvshows_count();	

		$this->data['vod_stats'] = array(
		    'movies' => (int)$movie_count,
		    'series' => (int)$series_tvshows_counts['series_count'],
		    'tv_show' => (int)$series_tvshows_counts['tvshows_count']
		);
		/* Fetch VOD statistics End*/

	    
	    /* Prepare chart data Start */
	    $this->data['customer_pie_chart'] = $this->highcharts->pie_chart('customer_distribution', $this->data['customer_stats']);
	    $this->data['vod_bar_chart'] = $this->highcharts->bar_chart('vod_distribution', $this->data['vod_stats']);
	    /* Prepare chart data End */


	    
		////////////////Start Customer Stats//////////////////
    	$this->data['customer_chart_data'] = $this->customers_m->get_all_customer_growth_data();
	    ////////////////END Customer Stats//////////////////


		////////////////Start Movies Stats//////////////////
		$this->data['movie_chart_data'] = $this->movies_m->get_all_movie_growth_data();
		////////////////END Movies Stats//////////////////


		////////////////Start Series Stats//////////////////
		$this->data['seies_chart_data'] = $this->series_m->get_all_series_growth_data();
		////////////////END Series Stats//////////////////

	    $this->data['page_title'] = "Statistics";
	    $this->data['pagetitle'] = "Statistics";
	    $this->data['_view'] = DEFAULT_THEME . 'dashboard/stats';
	    $this->load->view(DEFAULT_THEME . '_layout', $this->data);
	}

	public function edit(){
		$this->lang->load('users');
		$this->lang->load('actions');
		if (!$this->ion_auth->logged_in())
		{
			redirect('login', 'refresh');
		}

		$id=$this->session->user_id;

		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, 'Update Profile', 'dashboard/edit');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		/* Data */
		$user          = $this->ion_auth->user($id)->row();
		$groups        = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		/* Validate form input */
		$this->form_validation->set_rules('first_name', 'lang:edit_user_validation_fname_label', 'required');
		$this->form_validation->set_rules('last_name', 'lang:edit_user_validation_lname_label', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check_other_than');
		$this->form_validation->set_rules('phone', 'lang:edit_user_validation_phone_label', 'required');
		$this->form_validation->set_rules('company', 'lang:edit_user_validation_company_label', 'required');

		if (isset($_POST) && ! empty($_POST))
		{
			if ($this->_valid_csrf_nonce() === FALSE OR $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required');
			}

			if ($this->form_validation->run() == TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone')                 
				);

				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}

				if($this->ion_auth->update($user->id, $data))
				{
					$this->session->set_flashdata('success', 'Your Profile has been updated successfully');
					redirect('profile', 'refresh');
				}
				else
				{
					$this->session->set_flashdata('error', $this->ion_auth->errors());

					if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}
				}
			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user']          = $user;
		$this->data['groups']        = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'class' => 'form-control',
            'required' => 'required',
			'value' => $this->form_validation->set_value('first_name', $user->first_name)
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'class' => 'form-control',
            'required' => 'required',
			'value' => $this->form_validation->set_value('last_name', $user->last_name)
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('company', $user->company)
		);
		$this->data['email'] = array(
			'name'  => 'email',
			'id'    => 'email',
			'type'  => 'email',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('email', $user->email)
		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'tel',
			'pattern' => '^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('phone', $user->phone)
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'class' => 'form-control',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'class' => 'form-control',
			'type' => 'password'
		);

		/* Load Template */
		//$this->template->admin_render('admin/users/edit', $this->data);
		$this->data['page_title'] = "Update Profile";
        $this->data['pagetitle'] = "Update Profile";
		$this->data['_view'] = DEFAULT_THEME . 'dashboard/edit';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}

	public function readJson(){
		// Get the contents of the JSON file 
		//$strJsonFileContents = file_get_contents("./json-provided/3_movies_stores_store_with_substore.json");
		$strJsonFileContents = file_get_contents("./jsons/series/21_series_stores.json");
		// Convert to array 
		$array = json_decode($strJsonFileContents, true);
		echo "<pre>";
		var_dump($array); // print array
		echo "</pre>";
	}

	public function readSampleJson(){
		// Get the contents of the JSON file 
		$strJsonFileContents = file_get_contents("./json-provided/30_series_stores.json");
		//$strJsonFileContents = file_get_contents("./jsons/movies/48_movie_details.json");
		// Convert to array 
		$array = json_decode($strJsonFileContents, true);
		echo "<pre>";
		var_dump($array); // print array
		echo "</pre>";
	}

	public function testApi(){

		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.themoviedb.org/3/movie/384018?language=en-US&api_key=e028c2212fa961f28073b276e49dad4c",
		//CURLOPT_URL => "https://api.themoviedb.org/3/movie/384018/videos?api_key=e028c2212fa961f28073b276e49dad4c&language=en-US",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_POSTFIELDS => "{}",
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
	}

	public function xmlt(){
		$epg="AND TV HD";
		//$this->testXML($epg);

		//$time =strtotime('20190910083000 +0000');
		$time =strtotime('20190910013500 +0200');
		echo date('Y-m-d H:i:s', $time);
	}

	public function testXML($epg_name,$channel_id){
		$url="http://45.55.178.116/hybrid_guide1.xml";
		//$url="https://tvprofil.net/xmltv/data/nova.hr/weekly_nova.hr_tvprofil.net.xml";
		$xmlfile = file_get_contents($url);
		$ob= (array)simplexml_load_string($xmlfile);
		$json  = json_encode($ob);
		$configData = json_decode($json, true);
		/*echo "<pre>";
		print_r($configData);
		echo "</pre>";*/
		foreach ($configData['programme'] as $epg) {
			// echo "<pre>";
			//print_r($epg['@attributes']);
			$channel_name= $epg['@attributes']['channel'];
			// echo "</pre>";
			if($epg_name==$channel_name){
				echo $channel_name = $epg['@attributes']['channel']."<br \>";
				echo $program_name = $epg['title']."<br \>";
				echo $start = $epg['@attributes']['start']."<br \>";
				echo $stop = $epg['@attributes']['stop'];
			}
		}
	}

	public function email_check_other_than($email){
	 	$this->load->model('user_m');
        $result=$this->user_m->check_other_emails($email,$this->input->post('id'));
        foreach ($result as $eml) {
            if($eml->email==$email){
                $this->form_validation->set_message('email_check_other_than', 'The {field} is already exist.');
                return FALSE;
            } 
        }
        return TRUE;
    }

	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	public function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE && $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */