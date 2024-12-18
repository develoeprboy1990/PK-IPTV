<?php defined('BASEPATH') OR exit('No direct script access allowed');
//For Customer
/**
 * Class Customer Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
//For Custoemr Panel
class Customer extends MY_Controller
{
	public $data = [];
	public $plan_validate = '';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('customers_m');
		$this->load->model('products_m');
		$this->load->model('devices_m');
		$this->load->model('packages_m');
		$this->load->model('messages_m');
		$this->load->model('channel_to_group_m');
		$this->load->library(['ion_customer_auth', 'form_validation'],'cookie');
		$this->load->helper(['url', 'language']);
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');

		$this->load->library('breadcrumbs');
        $this->load->library('page_title');
      
        /* Title Page :: Common */
        $this->page_title->push('Customer');

        $this->data['site_name'] = "IPTV";
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "products";
        $this->data['sub_nav'] = "devices";

        $this->data['activeTab'] = 1; 
		
		$this->load->model('customerpanel_m');
		$userid=$this->session->user_id;
		
		/*$userinfo = $this->customers_m->getCustomerInfo($userid);
		echo '<pre>';
		print_r($this->session);exit;*/
			
		if(isset($userid)){
			$log_text_array = $this->customerpanel_m->getdataall('plan_history',array('used_id' => $userid));					
			$log_text_array_log = json_decode($log_text_array[0]['log_json']);	
							 
			foreach($log_text_array_log as $val){
				$log_array[] = $val;
			}	
			$this->data['log_data'] = $log_array; 
			
			$waller_log_text_array_log = json_decode($log_text_array[0]['waller_log']);	
							 
			foreach($waller_log_text_array_log as $val){
				$waller_log_array[] = $val;
			}	
			$this->data['waller_log'] = $waller_log_array;
			
			
			$panel_subscription = $this->customerpanel_m->getdataallPlans('customers_panel_subscription');
			$this->data['panel_subscription'] = $panel_subscription;
			
			
			$userinfo = $this->customers_m->getCustomerInfo($userid);
			/*echo '<pre>';
			print_r($userinfo);
			exit;*/
			$group_byid = $this->customerpanel_m->getdataall('subscriptiongroup', array('product_id' => $userinfo->product_id, 'active'=>'1','status'=>'1'));
			//print_r($group_byid);exit;
			$this->data['group_product'] = $group_byid;
			
			if($userinfo->reseller_id > 0){
				$this->load->model('reseller_m');
				$resellerInfo = $this->reseller_m->getReseller($userinfo->reseller_id);
				/*echo '<pre>';
				print_r($resellerInfo);exit;*/
								
				$this->data['msg_to_customer'] = ($resellerInfo[0]['reseller_msgedit'] == '1') ? $resellerInfo[0]['messageto_customer_reseller'] : $resellerInfo[0]['customer_msgcontent'] ;
			}else{
				$this->data['msg_to_customer'] = MSG_TO_CUSTOMER;
			}
			
			if(($userinfo->product_activation_key_id > 0) && ($this->session->product_activation_key_id == 0)){
				$this->session->set_userdata(array('product_activation_key_id'=>$userinfo->product_activation_key_id));
			}
			
			$this->data['userinfo'] =  $userinfo;
			
			// get product details      	
			$product_info = $this->products_m->get_product_by_user($userid);			
			$this->data['product'] = $product_info;
			/*echo '<pre>';
			print_r($product_info);exit;*/
			$get_all_products = $this->products_m->get_all_products();
			
			//$get_all_products_array = array();
			foreach($get_all_products as $key=>$val){
				$get_all_products_array['id_'.$val['id']] = array('name' => $val['name'],
																	'plan_name' => $val['plan_name'],
																		'subscription_length' => $val['subscription_length'],
																		'subscription_days_or_month' => $val['subscription_days_or_month'],
																		'price' => $val['price']
																	);
			}
			$this->data['all_product'] = $get_all_products_array;
			/*echo '<pre>';
			print_r($get_all_products_array);exit;*/
			
			
			$this->load->model('activation_keys_m');
			$getkeyInfo = array();
			if($userinfo->sebscription_trpe == 'aplan'){
				$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$userinfo->product_activation_key_id),'activation_keys');
				$this->data['product_details_settype'] = '0';	
				$this->data['plan_details'] = $getkeyDetails;
				$getkeyInfo[] = $getkeyDetails;
			}elseif($userinfo->sebscription_trpe == 'subscript'){
				$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$userinfo->product_activation_key_id),'subscription_renewal_keys');
				$this->data['product_details_settype'] = '0';	
				$this->data['plan_details'] = $getkeyDetails;
				$getkeyInfo[] = $getkeyDetails;
			}elseif($userinfo->sebscription_trpe == 'splan'){
				$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$userinfo->product_activation_key_id),'customers_panel_subscription');
				$this->data['product_details_settype'] = '0';	
				$this->data['plan_details'] = $getkeyDetails;
				$getkeyInfo[] = $getkeyDetails;			
			}elseif($userinfo->sebscription_trpe == 'rcode'){
				$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$userinfo->product_activation_key_id),'subscription_renewal_keys');
				$this->data['product_details_settype'] = '0';	
				$this->data['plan_details'] = $getkeyDetails;
				$getkeyInfo[] = $getkeyDetails;			
			}else{						
				$this->data['product_details_settype'] = '1';		
			}
			
			$diff_time=((strtotime($userinfo->subscription_expire) - strtotime(date("Y-m-d H:i:s")))/(24*60*60));
			//echo $diff_time;exit;
			if($diff_time <= 0){ 
				$walletbalance = $userinfo->walletbalance;
				$requiredBalance = $getkeyInfo[0]->monthly_price*$getkeyInfo[0]->length_months;
				if($walletbalance > 0){
					$this->plan_validate = 'change_plan';
				} else {
					$this->plan_validate = 'rechare_wallet';
				}
			}
		}
		
	}

	public function expiredplans(){	
		if($this->session->product_activation_key_id > 0){ 
			$this->load->model('customerpanel_m');
			$plans = $this->customerpanel_m->getKeys();
			$this->data['plans'] = $plans;
			
			$user_id=$this->session->user_id;
			$user_info = $this->customers_m->getCustomerInfo($user_id);
			$this->data['select_planstype'] = $user_info->sebscription_trpe;
			
			
			
			$product_info = $this->products_m->get_product_by_user($user_id);				
			$group_byid = $this->customerpanel_m->getdataall('subscriptiongroup', array('product_id' => $product_info->product_id, 'active'=>'1','status'=>'1'));
			//$this->data['gui_setting_id'] = $product_info->gui_setting_id;
			if(count($group_byid) > 0){
				//print_r( explode(',',$group_byid[0]['subscription_pans']));exit;
				$this->data['product_select_group'] = explode(',',$group_byid[0]['subscription_pans']);
				//$this->data['product_select_group'] = array();
			} else{ 
				//echo 'test';exit;
				$this->data['product_select_group'] = array();
			}
		
		
		
			if($user_info->sebscription_trpe == 'aplan'){
				$where_plan = array('id'=>$user_info->product_activation_key_id);
				$select_plans = $this->customers_m->selectdatarow($where_plan, 'activation_keys');
				$this->data['select_plans'] = $select_plans[0];				
				$where_products = array('id'=>$select_plans[0]['product_id']);
				$select_products = $this->customers_m->selectdatarow($where_products, 'products');
				$this->data['select_products'] = $select_products[0];
			}elseif($user_info->sebscription_trpe == 'splan'){
				$where_plan = array('id'=>$user_info->product_activation_key_id);
				$select_plans = $this->customers_m->selectdatarow($where_plan, 'customers_panel_subscription');
				$this->data['select_plans'] = $select_plans[0];
			}elseif($user_info->sebscription_trpe == 'rcode'){
				$where_plan = array('id'=>$user_info->product_activation_key_id);
				$select_plans = $this->customers_m->selectdatarow($where_plan, 'subscription_renewal_keys');
				$this->data['select_plans'] = $select_plans[0];
		
			}elseif($user_info->sebscription_trpe == 'aproduct'){
				$where_products = array('id'=>$user_info->product_id);
				$select_products = $this->customers_m->selectdatarow($where_products, 'products');
				$this->data['select_products'] = $select_products[0];
				/*echo '<pre>';
				print_r($user_info);
				exit;*/
		
			}
			
			if($this->plan_validate == 'change_plan'){
				$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/planrenew';
				return false;
			}elseif($this->plan_validate == 'rechare_wallet'){
				//$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/rechargewallet';
				$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/planrenew';
				return false;
			}else{
				return true;
			}
		} else {
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/activatecode';
		}
		
	}
	
	public function renuewplan(){
		$planid = $_REQUEST['planid'];
		$plantype = $_REQUEST['plantype'];
		//echo $planid.'---------------'.$plantype;
		
		$user_id=$this->session->user_id;
		$user_info = $this->customers_m->getCustomerInfo($user_id);
			
		$walet_money = $user_info->walletbalance;
		if($plantype == 'aplan'){
			$where_plan = array('id'=>$planid);
			$select_plans = $this->customers_m->selectdatarow($where_plan, 'activation_keys');
			
			$now_time = date("Y-m-d H:i:s");
			$valid_time = "+".$select_plans[0]['length_months'].' '.$select_plans[0]['month_day'];
			$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
			
			$requiredPrice = $select_plans[0]['length_months']*$select_plans[0]['monthly_price'];
		}elseif($plantype == 'splan'){
			$where_plan = array('id'=>$planid);
			$select_plans = $this->customers_m->selectdatarow($where_plan, 'customers_panel_subscription');
			
			$now_time = date("Y-m-d H:i:s");
			$valid_time = "+".$select_plans[0]['length_months'].' '.$select_plans[0]['month_day'];
			$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
			
			$requiredPrice = $select_plans[0]['length_months']*$select_plans[0]['monthly_price'];
			/*echo '<pre>';
			print_r($select_plans);exit;*/
		}elseif($plantype == 'rcode'){
			$where_plan = array('id'=>$planid);
			$select_plans = $this->customers_m->selectdatarow($where_plan, 'subscription_renewal_keys');
			
			$now_time = date("Y-m-d H:i:s");
			$valid_time = "+".$select_plans[0]['length_months'].' '.$select_plans[0]['month_day'];
			$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));			
			$requiredPrice = $select_plans[0]['length_months']*$select_plans[0]['monthly_price'];
			/*echo '<pre>';
			echo $requiredPrice.'<br>';
			print_r($select_plans);			
			exit;*/
		}
		$finalWalet_money = $walet_money - $requiredPrice;
		
		if($finalWalet_money >= 0){
				$this->load->model('activation_keys_m');
				$data_customers = array('subscription_expire'=>$subscription_expire,
											'walletbalance' => $finalWalet_money,
												'sebscription_trpe' => $plantype 
										);
				$where_customers = array('id' => $user_id);				
				$res =	$this->activation_keys_m->update_key($data_customers,$where_customers, 'customers');
					
			echo 'success';
		} else{
			echo 'shortmoney';
		}
	
	}
	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index($tab=1){	
		if (!$this->ion_customer_auth->logged_in())
		{
			// redirect them to the login page
			redirect('customer/login', 'refresh');
		}
		/*$this->session->set_userdata('dsdsname', 'aaa');
		echo '<pre>';
		print_r($this->session);
		exit;*/
		check_customer();  
		$user_id=$this->session->user_id;
		$this->data['user_id'] = $user_id;

        $this->load->model('dynamic_dependent_m');
        $this->data['page_title'] = "Customer";
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
     	 
		// get product details      	
      	$product_info = $this->products_m->get_product_by_user($user_id);			
		$this->data['product'] = $product_info;

        // get devices by user 
        $this->data['devices'] = $this->devices_m->get_devices_by_customer($user_id);
 		//print_r($this->data['devices']);
        //channels_groups
   		$this->data['channels_groups']=$this->channel_to_group_m->get_channel_groups_customer($user_id);
    	
    	$this->data['channels']=$this->channel_to_group_m->get_channel_by_channel_groups($user_id);
        // get user info
        $info = $this->customers_m->getCustomerInfo($user_id);
        
		/*echo '<pre>';
		print_r($info);exit;*/
        $this->data['user_info'] =  $info;
		
		$this->load->model('activation_keys_m');
		if($info->sebscription_trpe == 'aplan'){
			$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$info->product_activation_key_id),'activation_keys');
			$this->data['product_details_settype'] = '0';	
			$this->data['plan_details'] = $getkeyDetails;
		}elseif($info->sebscription_trpe == 'subscript'){
			$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$info->product_activation_key_id),'subscription_renewal_keys');
			$this->data['product_details_settype'] = '0';	
			$this->data['plan_details'] = $getkeyDetails;
		}elseif($info->sebscription_trpe == 'splan'){
			$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$info->product_activation_key_id),'customers_panel_subscription');
			$this->data['product_details_settype'] = '0';
			$this->data['plan_details'] = $getkeyDetails;
			/*echo '<pre>';
			print_r($getkeyDetails);exit;	*/
		}else{						
			$this->data['product_details_settype'] = '1';		
		}
		
		
        /* Countries */
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();
        /* States */
        $this->data['billing_states']=$this->dynamic_dependent_m->get_states($info->billing_country);
        /* Cities */
        $this->data['billing_cities']=$this->dynamic_dependent_m->get_cities($info->billing_state);
        
        // messages
        $this->data['messages'] = $this->messages_m->get_by(array('customer_id'=>$user_id));
       
        $this->data['activeTab'] = $tab; 
		$this->data['active_tab'] = 'dashboard';
		$this->data['active_menu'] = 'default';
		
		$this->load->model('customerpanel_m');
		$subscription_renewal_keys = $this->customerpanel_m->getKeys();
		
		/*echo '<pre>';
		print_r($subscription_renewal_keys);exit;*/
		$this->data['subscription_renewal_keys']= $subscription_renewal_keys;
		
        /*$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard/_extra_scripts';
        $this->data['_view'] = CUSTOMER_THEME . 'dashboard/index';
        $this->load->view( CUSTOMER_THEME . '_layout',$this->data);*/
		
		//$this->data['_extra_scripts'] = CUSTOMER_THEME . 'registration/_extra_scripts';
		//$this->data['sidebar'] = CUSTOMER_THEME . 'dashboard_new/includes/sidebar';
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard_new/_extra_scripts';
		if($this->expiredplans()){
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/index';
		}
		$this->load->view( CUSTOMER_THEME . 'dashboard_new/_layout_after',$this->data);	
	}
	
	
	/**
	Customer Setting
	By Bhaskar
	**/	

	public function profile(){		
		$user_id=$this->session->user_id;


		if (!$this->ion_customer_auth->logged_in()){
			redirect('customer/login', 'refresh');
		}

		
		$this->load->model('dynamic_dependent_m');
		// get user info
        $info = $this->customers_m->getCustomerInfo($user_id);

         //print_r($info);exit();
        /* Countries */
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country($info->billing_country);
        /* States */
        $this->data['billing_states']=$this->dynamic_dependent_m->get_states($info->billing_country);
        /* Cities */
        $this->data['billing_cities']=$this->dynamic_dependent_m->get_cities($info->billing_state);

        $this->data['user_info'] =  $info;
      
		$this->load->helper(array('form', 'url'));

		$this->data['fname'] = $info->first_name;
		$this->data['lname'] = $info->last_name;
		$this->data['email'] = $info->email;
		$this->data['c_code'] = $info->c_code;
		$this->data['mobile'] = $info->mobile;
		$this->data['billing_country'] = $info->country;
		$this->data['billing_state'] = $info->billing_state;
		$this->data['billing_city'] = $info->billing_city;
		$this->data['billing_street'] = $info->billing_street;
		$this->data['billing_zip'] = $info->billing_zip;

		$this->data['active_tab'] = 'default';
		$this->data['active_menu'] = 'profile';
		$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/profile';
		$this->load->view( CUSTOMER_THEME . 'dashboard_new/_layout_after',$this->data);	

	}


	public function setting(){
		$user_id=$this->session->user_id;
		
		if (!$this->ion_customer_auth->logged_in()){
			redirect('customer/login', 'refresh');
		}
		$this->load->model('dynamic_dependent_m');
		// get user info
        $info = $this->customers_m->getCustomerInfo($user_id);
		/* Countries */
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();
        /* States */
        $this->data['billing_states']=$this->dynamic_dependent_m->get_states($info->billing_country);
        /* Cities */
        $this->data['billing_cities']=$this->dynamic_dependent_m->get_cities($info->billing_state);
		
        $this->data['user_info'] =  $info;
		$this->load->helper(array('form', 'url'));
		
		 $this->data['message'] = '';
		if(isset($_REQUEST['save_change'])){ 			
			$this->load->library('form_validation');		
			$this->form_validation->set_rules('fname', 'First Name', 'trim|required');
			$this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('c_code', 'Country Code', 'trim|required');
		//	$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric|callback_checkphone');
			$this->form_validation->set_rules('billing_country', 'Country', 'trim|required');
			$this->form_validation->set_rules('billing_state', 'State', 'trim|required');
			$this->form_validation->set_rules('billing_city', 'City', 'trim|required');
			
			 // Check if the mobile number has changed
        $new_mobile = $this->input->post('mobile');
        if ($new_mobile != $original_mobile) {
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric|callback_checkphone');
        } else {
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric');
        }

			if ($this->form_validation->run() == FALSE){
				 $this->data['message'] = 'error';
				 $this->data['fname'] = $this->input->post('fname');
				 $this->data['lname'] = $this->input->post('lname');
				 $this->data['email'] = $info->email;
				 $this->data['c_code'] = $this->input->post('c_code');
				 $this->data['mobile'] = $this->input->post('mobile');
				 $this->data['billing_country'] = $this->input->post('billing_country');
				 $this->data['billing_state'] = $this->input->post('billing_state');
				 $this->data['billing_city'] = $this->input->post('billing_city');
				 $this->data['billing_street'] = $this->input->post('billing_street');
				 $this->data['billing_zip'] = $this->input->post('billing_zip');
			}else{
				 $billing_city = $this->input->post('billing_city');
				 $fname = $this->input->post('fname');
				 $lname = $this->input->post('lname');
				 $c_code = $this->input->post('c_code');
				 $mobile = $this->input->post('mobile');
				 $billing_country = $this->input->post('billing_country');
				 $billing_state = $this->input->post('billing_state');
				 $billing_city = $this->input->post('billing_city');
				 $billing_street = $this->input->post('billing_street');
				 $billing_zip = $this->input->post('billing_zip');
				 $data = array(
				 				'first_name' => $fname,
								'last_name' => $lname,
								'c_code' => $c_code,
								'mobile' => $mobile,
								'billing_country' => $billing_country,
								'billing_state' => $billing_state,
								'billing_city' => $billing_city,
								'billing_street' => $billing_street,
								'billing_zip' => $billing_zip
								
				 			);				 
				 $this->customers_m->update_customer($user_id,$data);
				 
				 //Json Create
				//==========================================================================================================================
				//if($plan_keycode != ''){
					$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($info->email))));
					if(!is_dir($json_directory)){
						/* Directory does not exist, so lets create it. */
						mkdir($json_directory, 0777, true);
					}					
					/*$filename = $password . '.json';*/
					$filename = base64_decode($info->alpha_password) . '.json';
						
					$localFilePath = $json_directory.'/'.$filename;
					$final_json_output = $this->publishJsonGenerater(strtolower($info->email), base64_decode($info->password));
					
					$fpt_r = fopen($localFilePath, 'w');
					fwrite($fpt_r, $final_json_output);
					fclose($fpt_r);				
						
						
				//}	
				//===========================================================================================================================		
				 
				 $this->data['fname'] = $fname;
				 $this->data['lname'] = $lname;
				 $this->data['email'] = $info->email;
				 $this->data['c_code'] = $c_code;
				 $this->data['mobile'] = $mobile;
				 $this->data['billing_country'] = $billing_country;
				 $this->data['billing_state'] = $billing_state;
				 $this->data['billing_city'] = $billing_city;
				 $this->data['billing_street'] = $billing_street;
				 $this->data['billing_zip'] = $billing_zip;
			}
			
		} 
		else{
			$this->data['fname'] = $info->first_name;
			$this->data['lname'] = $info->last_name;
			$this->data['email'] = $info->email;
			$this->data['c_code'] = $info->c_code;
			$this->data['mobile'] = $info->mobile;
			$this->data['billing_country'] = $info->billing_country;
			$this->data['billing_state'] = $info->billing_state;
			$this->data['billing_city'] = $info->billing_city;
			$this->data['billing_street'] = $info->billing_street;
			$this->data['billing_zip'] = $info->billing_zip;
		}
       
		$this->data['active_tab'] = 'userfrofile';
		$this->data['active_menu'] = 'setting';
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard_new/_extra_scripts';
		if($this->expiredplans()){
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/setting';
		}
		$this->load->view( CUSTOMER_THEME . 'dashboard_new/_layout_after',$this->data);	
	}
	
	public function channelGroups(){

		if (!$this->ion_customer_auth->logged_in())
		{
			redirect('customer/login', 'refresh');
		}
		check_customer();  

		$user_id=$this->session->user_id;
		$this->data['user_id'] = $user_id;
		// insert into channel group tables
        if(is_array($this->input->post('channel_group')) && count($this->input->post('channel_group'))>0){
            $this->channel_to_group_m->delete_channel_groups_by_customer($user_id);
            foreach ($this->input->post('channel_group') as $group) {
               $data=array(
                    'channel_group_id'=>$group,
                    'customer_id'=>$user_id
                );
               $this->db->insert('customer_to_channel_groups',$data);
            }
            $this->userlogs->track_this($user_id,'<a href="'.site_url('customer/channelGroups').'" target="_blank">Channel Groups Updated</a>');   
            $this->session->set_flashdata('success',"Channel Groups Updated Successfully.");
			redirect(BASE_URL.'customer/channelGroups');
        }

		$this->data['page_title'] = "Channel Groups";
	        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
     	      	
		$product_info = $this->products_m->get_product_by_user($user_id);
		
        //channels_groups
   		$this->data['groups_channel']=$this->groups_channel_m->get();
    	$this->data['get_selected_groups']=$this->channel_to_group_m->get_channel_groups_by_customer($user_id);
    
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard/_extra_scripts';
	    $this->data['_view'] = CUSTOMER_THEME . 'dashboard/channel_groups';
	    $this->load->view( CUSTOMER_THEME . '_layout',$this->data);
	}
	
	public function devices(){
		if (!$this->ion_customer_auth->logged_in())
		{
			redirect('customer/login', 'refresh');
		}
		check_customer(); 
		$user_id=$this->session->user_id;
		$this->data['user_id'] = $user_id;

		$this->data['page_title'] = "Devices";
	        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
     	      	
		$product_info = $this->products_m->get_product_by_user($user_id);
		
		// get devices by product 
	    //$this->data['devices'] = $this->devices_m->get_devices_by_product($product_info->product_id);
		$this->data['devices'] = $this->devices_m->get_devices_by_customer($user_id);

		//$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard/_extra_scripts';
	    $this->data['_view'] = CUSTOMER_THEME . 'dashboard/devices';
	    $this->load->view( CUSTOMER_THEME . '_layout',$this->data);
	}


	public function updateProfile(){
	
		if (!$this->ion_customer_auth->logged_in())
		{
			redirect('customer/login', 'refresh');
		}
		
		check_customer(); 

		$user_id=$this->session->user_id;
		$this->data['user_id'] = $user_id;

		$this->load->model('dynamic_dependent_m');
		$rules = $this->customers_m->update_profile_rules;
		
        $this->form_validation->set_rules($rules);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
		
		
	
        if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post($post);
			//print_r($data);exit;
            $this->customers_m->save($user_id,$data);

            $this->userlogs->track_this($user_id, " Updated Profile on ". date('Y-m-d H:i:s', time()));

            $this->session->set_flashdata('success',"Profile Updated Successfully.");
			redirect(BASE_URL.'customer');
		}	
		/*echo '<pre>';
	print_r($this->session);exit;*/
		$this->data['page_title'] = "Customer";
	        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
     	      	
      	// get product details 
      	$product_info = $this->products_m->get_product_by_user($user_id);
        $this->data['product'] = $product_info;

        // get devices by product 
        $this->data['devices'] = $this->devices_m->get_devices_by_product($product_info->product_id);

        // get package by product 
        $this->data['packages'] = $this->packages_m->get_packages_by_product($product_info->product_id);

        // get user info
        $info = $this->customers_m->getCustomerInfo($user_id);
        $this->data['user_info'] =  $info;
        /* Countries */
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();
        /* States */
        $this->data['billing_states']=$this->dynamic_dependent_m->get_states($info->billing_country);
        /* Cities */
        $this->data['billing_cities']=$this->dynamic_dependent_m->get_cities($info->billing_state);
        $this->data['activeTab'] = 3; 
        $this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard/_extra_scripts';
        $this->data['_view'] = CUSTOMER_THEME . 'dashboard/index';
        $this->load->view( CUSTOMER_THEME . '_layout',$this->data);
	}
 
	/**
	Password and Old Password check
	By Bhaskar
	**/				 
	public function passwordmatch(){
		$password = base64_encode(trim($this->input->post('password')));
		$user_id=$this->session->user_id;
		$this->form_validation->set_message('passwordmatch', 'Old Password Does not Match.');
		$user_info=$this->customers_m->get_userdetsils_byid($user_id);
		if($user_info['password']!= $password){
			return FALSE;
		}else{
			return true;
		}
		//print_r($user_info);exit;
	}
	
	/**
	Password and Coform Password check
	By Bhaskar
	**/		
	
	public function pass_conpass(){
		$newpassword = $this->input->post('newpassword');
		$cnewpassword = $this->input->post('cnewpassword');
		
		if($newpassword == ''){
			$this->form_validation->set_message('pass_conpass', 'The New Password field is required.');
			return FALSE;
		}elseif($cnewpassword == ''){
			$this->form_validation->set_message('pass_conpass', '');
			return FALSE;
		}elseif($newpassword != $cnewpassword){
			$this->form_validation->set_message('pass_conpass', 'New Password and Confirm New Password must same');
			return FALSE;
		} else{
			return true;
		}
		
		
	}	
	
	/**
	Change Password
	By Bhaskar
	**/		 
	public function changepassword(){
		if (!$this->ion_customer_auth->logged_in())
		{
			redirect('customer/login', 'refresh');
		}
		$collection_key = IMS_CLIENT.'.'.CRM;

		$user_id=$this->session->user_id;
		$user_info=$this->customers_m->get_userdetsils_byid($user_id);
		//echo '<pre>';
		//print_r($user_info);exit;
		/*echo base64_encode('test123');*/
		
		$this->data['message'] = '';
		if(isset($_REQUEST['save_change'])){ 			
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');	
			$this->form_validation->set_rules('password', 'Old Password', 'trim|required|callback_passwordmatch');
			$this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|callback_pass_conpass');
			$this->form_validation->set_rules('cnewpassword', 'Confirm Password', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				 $this->data['message'] = 'error';
				 $this->data['newpassword'] = $this->input->post('newpassword');
				 $this->data['cnewpassword'] = $this->input->post('cnewpassword');
				 $this->data['password'] = $this->input->post('password');
			}else{
				//$password= base64_encode($this->input->post('newpassword'));
				//$alpha_password = $this->toAlphaNumeric(trim($password));

				$password= base64_encode($this->input->post('newpassword'));
				$alpha_password = base64_encode($this->toAlphaNumeric(trim($this->input->post('newpassword'))));


				$data = array('password'=>$password,'alpha_password'=>$alpha_password);
				$this->customers_m->update_customer($user_id,$data);

				// Get current profile data from MongoDB
            	$document_key = $user_info['alpha_email'].'.'.$user_info['alpha_password'].'.profile';
            	//$document_key = '11gmailcom.'.'11.'.'profile';

            	$current_profile = $this->get_profile_data($collection_key, $document_key);
            	//echo '<pre>';
            	//print_r($current_profile);

            	if ($current_profile) {
	                // Delete old profile
	                $this->delete_profile_data($collection_key, $document_key);
	                
	                // Create new profile with updated password
	                $new_document_key = $user_info['alpha_email'].'.'.$alpha_password.'.profile';
	                //$new_document_key = '11gmailcom.'.'12.'.'profile';
	                $this->set_profile_data($collection_key, $new_document_key, $current_profile);
            	}

            	$new_current_profile = $this->get_profile_data($collection_key, $new_document_key);
            	//echo '<pre>';
            	//print_r($new_current_profile);
            	//exit();
				
				
				//Add JSON Code..
				$this->userlogs->track_this($user_id, "Updated Password on ". date('Y-m-d H:i:s', time()));
	
				$this->session->set_flashdata('message_set',"Password Updated Successfully.");
				redirect(BASE_URL.'customer/changepassword');
			}
		}
		$this->data['page_title'] = "Change password";
	        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
     	      	
		$user_info=$this->customers_m->getCustomerInfo($user_id);
		$this->data['user_info'] = $user_info;
		/*$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard/_extra_scripts';
	    $this->data['_view'] = CUSTOMER_THEME . 'dashboard/change_password';
	    $this->load->view( CUSTOMER_THEME . '_layout',$this->data);*/
		
		
		$this->data['active_tab'] = 'userfrofile';
		$this->data['active_menu'] = 'cpassword';
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard_new/_extra_scripts';
		if($this->expiredplans()){
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/change_password';
		}
		$this->load->view( CUSTOMER_THEME . 'dashboard_new/_layout_after',$this->data);	
	}	

	public function email_unique_change() {
	    $new_email = $this->input->post('new_email');
	    $user_id = $this->session->user_id;
	    $alpha_email = $this->toAlphaNumeric(trim($new_email));
	    $this->form_validation->set_message('email_unique_change', 'This email is already used. Use another Email.');
	    return $this->customers_m->check_email_unique_for_change($new_email, $alpha_email, $user_id);
	}


	public function changeemail() {
	    if (!$this->ion_customer_auth->logged_in()) {
	        redirect('customer/login', 'refresh');
	    }
	    
	    $user_id = $this->session->user_id;
	    $user_info = $this->customers_m->getCustomerInfo($user_id);
	    
	    $this->data['message'] = '';
	    if(isset($_POST['save_change'])) {
	        $this->load->library('form_validation');
	        $this->form_validation->set_rules('current_email', 'Current Email', 'trim|required|valid_email');
	        $this->form_validation->set_rules('new_email', 'New Email', 'trim|required|valid_email|callback_email_unique_change');
	        $this->form_validation->set_rules('confirm_email', 'Confirm New Email', 'trim|required|matches[new_email]');
	        
	        if ($this->form_validation->run() == FALSE) {
	            $this->data['message'] = 'error';
	        } else {
	            $current_email = $this->input->post('current_email');
	            $new_email = $this->input->post('new_email');
	            
	            if ($current_email == $user_info->email) {

					$data = array(
					'email' => $new_email,
					'alpha_email' => $this->toAlphaNumeric(trim($new_email))
					);

	            	if ($this->customers_m->update_email($user_id,$data)) {

	            		// Get current profile data from MongoDB
		            	//$document_key = $user_info['alpha_email'].'.'.$user_info['alpha_password'].'.profile';
		            	$document_key = '11gmailcom.'.'12.'.'profile';

		            	$current_profile = $this->get_profile_data($collection_key, $document_key);
		            	//echo '<pre>';
		            	//print_r($current_profile);exit();

		            	if ($current_profile) {
			                // Delete old profile
			                $this->delete_profile_data($collection_key, $document_key);
			                
			                // Create new profile with updated password
			                //$new_document_key = $alpha_email.'.'.$user_info['alpha_password'].'.profile';
			                $new_document_key = '11gmailcom.'.'13.'.'profile';
			                $this->set_profile_data($collection_key, $new_document_key, $current_profile);
		            	}

		            	$new_current_profile = $this->get_profile_data($collection_key, $new_document_key);
		            	//echo '<pre>';
		            	//print_r($new_current_profile);
		            	//exit();
				
				
						//Add JSON Code..
						$this->userlogs->track_this($user_id, "Updated Email on ". date('Y-m-d H:i:s', time()));



	                    $this->session->set_flashdata('message_set', 'Email updated successfully.');
	                    redirect('customer/changeemail', 'refresh');
	                } else {
	                    $this->data['message'] = 'error';
	                    $this->data['message_content'] = 'Failed to update email.';
	                }
	            } else {
	                $this->data['message'] = 'error';
	                $this->data['message_content'] = 'Current email is incorrect.';
	            }
	        }
	    }

	    
	    $this->data['user_info'] = $user_info;
	    $this->data['active_tab'] = 'userfrofile';
	    $this->data['active_menu'] = 'cemail';
	    $this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard_new/_extra_scripts';
	    if ($this->expiredplans()) {
	        $this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/change_email';
	    }
	    $this->load->view(CUSTOMER_THEME . 'dashboard_new/_layout_after', $this->data);
	}

	private function get_profile_data($collection_key, $document_key) {
	    $url = "https://devices.tvms.axncdn.com/getprofile?collection_key={$collection_key}&document_key={$document_key}";
	   	//echo $url.'<br>';
	    $response = file_get_contents($url);
	    return json_decode($response, true);
	}

	private function set_profile_data($collection_key, $document_key, $profile_data) {
	    $url = 'https://devices.tvms.axncdn.com/setprofile/';
	    $data = array(
	        'collection_key' => $collection_key,
	        'document_key' => $document_key,
	        'document_data' => $profile_data
	    );
	    
	    $options = array(
	        'http' => array(
	            'header'  => "Content-type: application/json\r\nAccept: application/json\r\n",
	            'method'  => 'POST',
	            'content' => json_encode($data)
	        )
	    );
	    
	    $context  = stream_context_create($options);
	    $result = file_get_contents($url, false, $context);
	    return $result;
	}

	private function delete_profile_data($collection_key, $document_key) {
	    $url = 'https://devices.tvms.axncdn.com/setprofile/';
	    
	    // Get the current profile data
	    $current_profile = $this->get_profile_data($collection_key, $document_key);
	    
	    if ($current_profile && isset($current_profile)) {
	        // Empty all arrays within the profile data
	        $this->empty_arrays($current_profile);
	        
	        // Prepare the data for the API call
	        $data = array(
	            'collection_key' => $collection_key,
	            'document_key' => $document_key,
	            'document_data' => $current_profile
	        );
	        
	        // Set up the HTTP context
	        $options = array(
	            'http' => array(
	                'header'  => "Content-type: application/json\r\nAccept: application/json\r\n",
	                'method'  => 'POST',
	                'content' => json_encode($data)
	            )
	        );
	        
	        // Make the API call
	        $context = stream_context_create($options);
	        $result = file_get_contents($url, false, $context);
	        
	        // Check the result
	        if ($result === FALSE) {
	            // Handle error - log it or throw an exception
	            error_log("Failed to empty profile data for document_key: $document_key");
	            return false;
	        }
	        
	        return true;
	    }
	    
	    return false; // Profile not found
	}

	// Helper function to recursively empty all arrays
	private function empty_arrays(&$data) {
	    foreach ($data as $key => &$value) {
	        if (is_array($value)) {
	            if (!empty($value)) {
	                $this->empty_arrays($value);
	            }
	            $data[$key] = array();
	        }
	    }
	}
			 
	public function changePasswordXXX(){
		if (!$this->ion_customer_auth->logged_in())
		{
			redirect('customer/login', 'refresh');
		}
		check_customer(); 

		$user_id=$this->session->user_id;
		$this->data['user_id'] = $user_id;

		$rules = $this->customers_m->change_password_rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
        	$password= base64_encode($this->input->post('new_password'));
        	$data = array('password'=>$password);
			//$this->customers_m->save($user_id,$data);
			$this->customers_m->update_customer($user_id,$data);
			$this->userlogs->track_this($user_id, "Updated Password on ". date('Y-m-d H:i:s', time()));

			$this->session->set_flashdata('success',"Password Updated Successfully.");
			redirect(BASE_URL.'customer');
        }

		$this->data['page_title'] = "Change password";
	        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
     	      	
		$user_info=$this->customers_m->getCustomerInfo($user_id);
		$this->data['user_info'] = $user_info;
		/*$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard/_extra_scripts';
	    $this->data['_view'] = CUSTOMER_THEME . 'dashboard/change_password';
	    $this->load->view( CUSTOMER_THEME . '_layout',$this->data);*/
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard_new/_extra_scripts';
		$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/change_password';
		$this->load->view( CUSTOMER_THEME . 'dashboard_new/_layout_after',$this->data);	
	}
	
	
	/**
	Camcel Plan
	By Bhaskar
	**/
	public function cancelplan(){
		//$this->load->helper(array('form', 'url'));
		$user_id = $this->session->user_id;
		 // get user info
        $info = $this->customers_m->getCustomerInfo($user_id);		
		$product_activation_key_id = $info->product_activation_key_id;
		$subscription_expire_1 = $info->subscription_expire;
		
		$this->load->model('activation_keys_m');
		$getkeyDetails = $this->activation_keys_m->getKeyInfoID($product_activation_key_id);
		
		$month_expire = $getkeyDetails->length_months;
		$subscription_expire_2 = date('Y-m-d H:i:s', strtotime("+".$month_expire." months", strtotime(date("Y-m-d H:i:s"))));
		
		
		$now_time = date("Y-m-d H:i:s");
			
		
		if(((strtotime($subscription_expire_1) - strtotime($now_time))/(60)) > 0){
			$diff_time=((strtotime($subscription_expire_2) - strtotime($subscription_expire_1))/(30*24*60*60));
			
			$monthReturnGet = '1';
			for($i=1;$i<=24;$i++){
				if($diff_time > $i){
					$monthReturnGet = $i;
				}
			}
			
			$return_length_months = $getkeyDetails->length_months;
			$return_monthly_price = $getkeyDetails->monthly_price;			
			$return_moneyto_walet = $info->walletbalance + $return_monthly_price*($return_length_months - $monthReturnGet);
						 
			$data_customers = array('subscription_expire'=>'0000-00-00 00:00:00', 
									 	'product_activation_key_id' => '', 
											'product_id' => '',
										     	'devices_allowed' => '',
										     		'activation_code' => '',
											 			'walletbalance' => $return_moneyto_walet
										);
			$where_customers = array('id' => $user_id);
			$res =	$this->activation_keys_m->update_key($data_customers,$where_customers, 'customers');
			if($res){
				echo 'success';
			}					
		}					
	}
	
	/**
	Camcel Plans By Tab
	By Bhaskar
	**/
	public function changeplans(){ 
		$user_id = $this->session->user_id;
		$product_info = $this->products_m->get_product_by_user($user_id);	
		//echo '<pre>';
		//print_r($product_info);
		$group_byid = $this->customerpanel_m->getdataall('subscriptiongroup', array('product_id' => $product_info->product_id, 'active'=>'1','status'=>'1'));
		//print_r($group_byid);

		if($product_info->customer_can_change_plan == '0'){ 
			redirect(BASE_URL.'customer'); 
		}
		elseif(count($group_byid) == 0){ 
			redirect(BASE_URL.'customer'); 
		}
		$this->load->model('customerpanel_m');
		$plans = $this->customerpanel_m->getPlans();
		//($plans);
		
		
		//$this->data['gui_setting_id'] = $product_info->gui_setting_id;
		if(count($group_byid) > 0){
			//print_r( explode(',',$group_byid[0]['subscription_pans']));exit;
			$this->data['product_select_group'] = explode(',',$group_byid[0]['subscription_pans']);
			//$this->data['product_select_group'] = array();
		} else{ 
			//echo 'test';exit;
			$this->data['product_select_group'] = array();
		}
		//print_r($this->data['product_select_group']);exit();
		$this->data['free_change'] = $group_byid[0]['free_change'];
		
		//$this->data['group_array'] = 
		//this->data['group_product'] = $group_byid;
		$this->data['plans'] = $plans;
		$this->data['active_tab'] = 'usersubscription';
		$this->data['active_menu'] = 'changeplans';		
		
		// get user info
        $info = $this->customers_m->getCustomerInfo($user_id);
		$this->data['user_info'] = $info;		
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard_new/_extra_scripts';
		if($this->expiredplans()){
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/changeplans';
		}
		$this->load->view( CUSTOMER_THEME . 'dashboard_new/_layout_after',$this->data);	
	}

	public function upgradeplans(){ 
		$user_id = $this->session->user_id;

        $info = $this->customers_m->getCustomerInfo($user_id);
        $this->data['info'] = $info;
        
        $product_info = $this->customers_m->get_product($user_id);
        $this->data['product_info'] = $product_info;
        
        
		$select_plans = $this->customers_m->get_product_plans($info->product_id);
		

		// At the beginning of the view file
		$active_plan = null;
		$other_plans = [];

		foreach ($select_plans as $plan) {
		    if ($plan['id'] == $info->plan_id) {
		        $active_plan = $plan;
		    } else {
		        $other_plans[] = $plan;
		    }
		}

		$sorted_plans = $active_plan ? array_merge([$active_plan], $other_plans) : $other_plans;

		$this->data['plans'] = $sorted_plans;

		$this->data['active_tab'] = 'usersubscription';
		$this->data['active_menu'] = 'changeplans';		
		
		// get user info
		$this->data['user_info'] = $info;		
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard_new/_extra_scripts';
		$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/upgradeplans';
		$this->load->view( CUSTOMER_THEME . 'dashboard_new/_layout_after',$this->data);	
	}

	public function requestUpgrade() {
	    if (!$this->ion_customer_auth->logged_in()) {
	        redirect('customer/login', 'refresh');
	    }


	    $this->load->model('reseller_m');
		
		$user_id = $this->session->user_id;
	    $plan_id = $this->input->post('planId');

	    $user_info = $this->customers_m->getCustomerInfo($user_id);
	    $plan_info = $this->customers_m->getPlanInfo($plan_id);

	    if ($user_info->reseller_id == 0) {
	        $to_email = ADMIN_EMAIL; // Replace with actual admin email or get from settings
	    }
	    else {
	     	$reseller_info = $this->reseller_m->getReseller($user_info->reseller_id);	
			$to_email = $reseller_info->email;
	    }

	    $subject = "Plan Upgrade Request";
	    $message = "Customer {$user_info->first_name} {$user_info->last_name} (ID: {$user_id}) has requested an upgrade to the plan: {$plan_info->name}";

	    //Use your email sending function here
	    //$this->send_email($subject, $message, SYSTEM_EMAIL, SYSTEM_NAME, $to_email, 'Admin');

	    echo json_encode(['status' => 'success','message' => $message]);
	}

	
	/**
	Call a Plan Details
	By Bhaskar
	**/
	public function callaplan(){
		$planid = $_REQUEST['planid'];
		$free_change = $_REQUEST['free_change'];
		$this->load->model('activation_keys_m');
		$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$planid),'customers_panel_subscription');
		//print_r($getkeyDetails);
		$htmlString = '<div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
						<div style="text-align:center;"><h1>Are you sure to change Plans</h1></div>
						<div id="message_alert"  style="text-align:center;"></div>						
						<div class="card-body pt-0">											
											<div class="table-responsive">												
												<table id="kt_profile_overview_table" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
													<thead class="fs-7 text-gray-400 text-uppercase">
														<tr>
															<th>Plan Name</th>
															<th>Price</th>
															<th>Validity</th>
																												
														</tr>
													</thead>
													<tbody class="fs-6">';
														
															//foreach($getkeyDetails as $key=>$val){
												
														
																$htmlString .= '<tr>
																	<td>																
																		<div class="d-flex align-items-center">
																			<div class="d-flex flex-column justify-content-center">
																				<a href="" class="fs-6 text-gray-800 text-hover-primary">'.$getkeyDetails->name.'</a>
																				<span>'.$getkeyDetails->product_name.'</span>
																			</div>
																		</div>
																	</td>
																	
																	<td>$'.$getkeyDetails->monthly_price*$getkeyDetails->length_months.'</td>
																	<td>'. $getkeyDetails->length_months.' '.$getkeyDetails->month_day.'</td>
																															
																</tr>';
														
														
														//	}
														
										$htmlString .= '				
														
													</tbody>
												</table>
											</div>
										</div>
										<div class="text-center">											
											<button type="submit" onclick="change_plan('.$getkeyDetails->id.','.$free_change.');return false;" class="btn btn-primary">
												<span class="indicator-label">Yes</span>												
											</button>
										</div>					
					</div>';
					
					echo $htmlString;
	}
	
	/**
	Change Plan Ajax
	By Bhaskar
	**/
	public function changeplan(){
		//$this->load->helper(array('form', 'url'));
		$planid = $_REQUEST['planid'];
		$free_change = $_REQUEST['free_change'];
		$user_id = $this->session->user_id;
		 // get user info
        $info = $this->customers_m->getCustomerInfo($user_id);
		//echo '<pre>';
		$product_activation_key_id = $info->product_activation_key_id;
		$subscription_expire_1 = $info->subscription_expire;
		
		$this->load->model('activation_keys_m');
		//$getkeyDetails = $this->activation_keys_m->getKeyInfoID($product_activation_key_id);
		/*if($info->sebscription_trpe == 'aplan'){
			$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$product_activation_key_id),'activation_keys');
		}elseif($info->sebscription_trpe == 'subscript'){
			$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$product_activation_key_id),'subscription_renewal_keys');
		}elseif($info->sebscription_trpe == 'splan'){
			$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$product_activation_key_id),'customers_panel_subscription');
		}elseif($info->sebscription_trpe == 'rcode'){
			$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$product_activation_key_id),'subscription_renewal_keys');
		}*/
		
		if($info->sebscription_trpe == 'splan'){
			$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$product_activation_key_id),'customers_panel_subscription');
		}else{
			$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$product_activation_key_id),'subscription_renewal_keys');
		}
		
		$month_expire = $getkeyDetails->length_months.' '.$getkeyDetails->month_day;
		$subscription_expire_2 = date('Y-m-d H:i:s', strtotime("+".$month_expire, strtotime(date("Y-m-d H:i:s"))));
		
			
		$now_time = date("Y-m-d H:i:s");
			
		
		if(((strtotime($subscription_expire_1) - strtotime($now_time))/(60)) > 0){
			$this->load->model('customerpanel_m');
			$new_plan_details = $this->customerpanel_m->getKeysById($planid);
			
			
			$product_id = $new_plan_details['product_id'];
			$devices_allowed = $new_plan_details['devices_allowed'];			
			$product_activation_key_id = $new_plan_details['id'];
			
			$money_short = '0';
			
			if($free_change == '1'){
					$data_customers = array(
											'product_activation_key_id' => $product_activation_key_id, 
												'product_id' => $product_id,													
													'sebscription_trpe' => 'splan'
											);
			}else{
				if($info->sebscription_trpe == 'splan'){
					if($info->product_activation_key_id == $planid){
						$valid_time = "+".$new_plan_details['length_months'].' '.$new_plan_details['month_day'];
						$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($info->subscription_expire)));
						$walet_money =  $info->walletbalance - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
					} elseif($new_plan_details['monthly_price'] == $getkeyDetails->monthly_price){
						$subscription_expire = $info->subscription_expire;
						$walet_money = $info->walletbalance;
					}else{	
						$valid_time = "+".$new_plan_details['length_months'].' '.$new_plan_details['month_day'];
						$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));				
						if($getkeyDetails->month_day == 'days'){
							$diff_time=((strtotime($subscription_expire_2) - strtotime($subscription_expire_1))/(30*24*60*60));
							if($diff_time > 30){
								$time_get = ((strtotime($subscription_expire_1) - strtotime($now_time))/(30*24*60*60));
								$return_moneyto_walet = $info->walletbalance + ($time_get*$getkeyDetails->monthly_price);
								$walet_money = $return_moneyto_walet - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
							}else{
								$time_get = $getkeyDetails->length_months-30;;
								$return_moneyto_walet = $info->walletbalance + ($time_get*$getkeyDetails->monthly_price);
								$walet_money = $return_moneyto_walet - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
							}
						} elseif($getkeyDetails->month_day == 'months'){
							$diff_time=((strtotime($subscription_expire_2) - strtotime($subscription_expire_1))/(30*24*60*60));
							$monthReturnGet = '1';
							for($i=1;$i<=24;$i++){
								if($diff_time > $i){
									$monthReturnGet = $i;
								}
							}
							$return_length_months = $getkeyDetails->length_months;
							$return_monthly_price = $getkeyDetails->monthly_price;
							$return_moneyto_walet = $info->walletbalance + $return_monthly_price*($return_length_months - $monthReturnGet);
							$walet_money = $return_moneyto_walet - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
							
						}
						
						//echo $return_moneyto_walet.'-------------'.$walet_money;exit;
					}
				} elseif($info->sebscription_trpe == 'aproduct'){
						$valid_time = "+".$new_plan_details['length_months'].' '.$new_plan_details['month_day'];
						$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
						$walet_money = $info->walletbalance - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
				}elseif(($info->sebscription_trpe == 'subscript') || ($info->sebscription_trpe == 'rcode')){
						$newTotalPrice = ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
						$oldTotalPrice = $getkeyDetails->monthly_price*$getkeyDetails->length_months;
						
						if($oldTotalPrice >= $newTotalPrice){
							$subscription_expire = $info->subscription_expire;
							$walet_money = $info->walletbalance;						
						}else{
							$priceTotalAvl = $oldTotalPrice + $info->walletbalance;
							$valid_time = "+".$new_plan_details['length_months'].' '.$new_plan_details['month_day'];
							$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
							if($priceTotalAvl >= $newTotalPrice ){
								$subscription_expire = $info->subscription_expire;
								$walet_money = $priceTotalAvl - $newTotalPrice ;
								
							}else{							
								$money_short = '1';
							}
						}
											
				}else{ 
						$valid_time = "+".$new_plan_details['length_months'].' '.$new_plan_details['month_day'];
						$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
						
						if($getkeyDetails->month_day == 'days'){
							$diff_time=((strtotime($subscription_expire_2) - strtotime($subscription_expire_1))/(30*24*60*60));
							if($diff_time > 30){
								$time_get = ((strtotime($subscription_expire_1) - strtotime($now_time))/(30*24*60*60));
								$return_moneyto_walet = $info->walletbalance + ($time_get*$getkeyDetails->monthly_price);
								$walet_money = $return_moneyto_walet - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
							}else{
								$time_get = $getkeyDetails->length_months-30;;
								$return_moneyto_walet = $info->walletbalance + ($time_get*$getkeyDetails->monthly_price);
								$walet_money = $return_moneyto_walet - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
							}
						} elseif($getkeyDetails->month_day == 'months'){
							$diff_time=((strtotime($subscription_expire_2) - strtotime($subscription_expire_1))/(30*24*60*60));
							$monthReturnGet = '1';
							for($i=1;$i<=24;$i++){
								if($diff_time > $i){
									$monthReturnGet = $i;
								}
							}
							
							$return_length_months = $getkeyDetails->length_months;
							$return_monthly_price = $getkeyDetails->monthly_price;
							$return_moneyto_walet = $info->walletbalance + $return_monthly_price*($return_length_months - $monthReturnGet);
							$walet_money = $return_moneyto_walet - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
							
							
						}
				}
			
				$data_customers = array('subscription_expire'=>$subscription_expire, 
											'product_activation_key_id' => $product_activation_key_id, 
												'product_id' => $product_id,
													'devices_allowed' => $devices_allowed,
														'activation_code' => '',
															'walletbalance' => $walet_money,
															'sebscription_trpe' => 'splan'
											);
			}
				
			
			$where_customers = array('id' => $user_id);
			
			if(($walet_money >= 0) && ($money_short == '0')){
				$res =	$this->activation_keys_m->update_key($data_customers,$where_customers, 'customers');
				if($res){
					$data_customers_log = array('subscription_expire'=>$subscription_expire, 
											'product_activation_key_id' => $product_activation_key_id, 
												'product_id' => $product_id,
													'devices_allowed' => $devices_allowed,
														'activation_code' => '',
															'walletbalance' => $walet_money,
															'sebscription_trpe' => 'splan',
															'date_created'=>date("Y-m-d H:i:s")
											);
					 $log_text_array = $this->customerpanel_m->getdataall('plan_history',array('used_id' => $user_id));
					 if(count($log_text_array) > 0){
					 	 $log_text_array_log = json_decode($log_text_array[0]['log_json']);	
						 $log_array[] = $data_customers_log;
						 foreach($log_text_array_log as $val){
						 	$log_array[] = $val;
						 }							 			 	
					 	 $log_text = json_encode($log_array);
						 						 
						 $log_data = array('used_id'=>$user_id, 'log_json' => $log_text);
						 $this->customerpanel_m->update_key($log_data,array('used_id' => $user_id), 'plan_history');
						// echo $log_text;exit;
						
					 }else{		
					 	$log_array[] = $data_customers_log;			 					 
				     	$log_data = array('used_id'=>$user_id, 'log_json' => json_encode($log_array));					
					 	$this->customerpanel_m->insert('plan_history',$log_data);
					 }
					 
					 
					 
					  //Json Create
				//==========================================================================================================================
				//if($plan_keycode != ''){
					$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($info->email))));
					if(!is_dir($json_directory)){
						/* Directory does not exist, so lets create it. */
						mkdir($json_directory, 0777, true);
					}					
					/*$filename = $password . '.json';*/
					$filename = base64_decode($info->alpha_password) . '.json';
						
					$localFilePath = $json_directory.'/'.$filename;
					$final_json_output = $this->publishJsonGenerater(strtolower($info->email), base64_decode($info->password));
					
					$fpt_r = fopen($localFilePath, 'w');
					fwrite($fpt_r, $final_json_output);
					fclose($fpt_r);				
						
						
				//}	
				//===========================================================================================================================		
				
					 echo 'success';
				}	
			} else {
				echo 'shortmoney';
			}
				
		} else {
			$this->load->model('customerpanel_m');
			$new_plan_details = $this->customerpanel_m->getKeysById($planid);
			
			if($info->walletbalance >= $new_plan_details['monthly_price']){
				$valid_time = "+".$new_plan_details['length_months'].' '.$new_plan_details['month_day'];
				$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime(date("Y-m-d H:i:s"))));
						
				$product_id = $new_plan_details['product_id'];
				$devices_allowed = $new_plan_details['devices_allowed'];
				$walet_money = $info->walletbalance - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
				$product_activation_key_id = $new_plan_details['id'];
				//echo $subscription_expire;
				$data_customers = array('subscription_expire'=>$subscription_expire, 
												'product_activation_key_id' => $product_activation_key_id, 
													'product_id' => $product_id,
														'devices_allowed' => $devices_allowed,
															'activation_code' => '',
																'walletbalance' => $walet_money,
																'sebscription_trpe' => 'splan'
												);
					$where_customers = array('id' => $user_id);
					$res =	$this->activation_keys_m->update_key($data_customers,$where_customers, 'customers');
					
					if($res){
							 $data_customers_log = array('subscription_expire'=>$subscription_expire, 
												'product_activation_key_id' => $product_activation_key_id, 
													'product_id' => $product_id,
														'devices_allowed' => $devices_allowed,
															'activation_code' => '',
																'walletbalance' => $walet_money,
																'sebscription_trpe' => 'splan',
																'date_created'=>date("Y-m-d H:i:s")
												);
							 $log_text_array = $this->customerpanel_m->getdataall('plan_history',array('used_id' => $user_id));
							 if(count($log_text_array) > 0){
								 $log_text_array_log = json_decode($log_text_array[0]['log_json']);	
								 $log_array[] = $data_customers_log;								 
								 foreach($log_text_array_log as $val){
									$log_array[] = $val;
								 }	
								 			 	
								 $log_text = json_encode($log_array);								 														 
								 $log_data = array('used_id'=>$user_id, 'log_json' => $log_text);
								 $this->customerpanel_m->update_key($log_data,array('used_id' => $user_id), 'plan_history');
							 }else{		
								$log_array[] = $data_customers_log;			 					 
								$log_data = array('used_id'=>$user_id, 'log_json' => json_encode($log_array));					
								$this->customerpanel_m->insert('plan_history',$log_data);
							 }
							 
							//Json Create
							//=================================================================================================================			
							$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($info->email))));
							if(!is_dir($json_directory)){
								/* Directory does not exist, so lets create it. */
								mkdir($json_directory, 0777, true);
							}					
							/*$filename = $password . '.json';*/
							$filename = base64_decode($info->alpha_password) . '.json';
								
							$localFilePath = $json_directory.'/'.$filename;
							$final_json_output = $this->publishJsonGenerater(strtolower($info->email), base64_decode($info->password));
							
							$fpt_r = fopen($localFilePath, 'w');
							fwrite($fpt_r, $final_json_output);
							fclose($fpt_r);				
							//==================================================================================================================				
							echo 'success';
						}	
			}else {
				echo 'shortmoney';
			}	
		}	
			
	}
	
	public function changeplan_05_10_2023(){
		//$this->load->helper(array('form', 'url'));
		$planid = $_REQUEST['planid'];
		$user_id = $this->session->user_id;
		 // get user info
        $info = $this->customers_m->getCustomerInfo($user_id);
		//echo '<pre>';
		$product_activation_key_id = $info->product_activation_key_id;
		$subscription_expire_1 = $info->subscription_expire;
		
		$this->load->model('activation_keys_m');
		//$getkeyDetails = $this->activation_keys_m->getKeyInfoID($product_activation_key_id);
		if($info->sebscription_trpe == 'aplan'){
			$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$product_activation_key_id),'activation_keys');
		}elseif($info->sebscription_trpe == 'subscript'){
			$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$product_activation_key_id),'subscription_renewal_keys');
		}elseif($info->sebscription_trpe == 'splan'){
			$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$product_activation_key_id),'customers_panel_subscription');
		}elseif($info->sebscription_trpe == 'rcode'){
			$getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('id'=>$product_activation_key_id),'subscription_renewal_keys');
		}
		
		$month_expire = $getkeyDetails->length_months.' '.$getkeyDetails->month_day;
		$subscription_expire_2 = date('Y-m-d H:i:s', strtotime("+".$month_expire, strtotime(date("Y-m-d H:i:s"))));
		
			
		$now_time = date("Y-m-d H:i:s");
			
		
		if(((strtotime($subscription_expire_1) - strtotime($now_time))/(60)) > 0){
			$this->load->model('customerpanel_m');
			$new_plan_details = $this->customerpanel_m->getKeysById($planid);
			
			
			$product_id = $new_plan_details['product_id'];
			$devices_allowed = $new_plan_details['devices_allowed'];			
			$product_activation_key_id = $new_plan_details['id'];
			
			
			if($info->sebscription_trpe == 'splan'){
				if($info->product_activation_key_id == $planid){
					$valid_time = "+".$new_plan_details['length_months'].' '.$new_plan_details['month_day'];
					$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($info->subscription_expire)));
					$walet_money =  $info->walletbalance - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
				} elseif($new_plan_details['monthly_price'] == $getkeyDetails->monthly_price){
					$subscription_expire = $info->subscription_expire;
					$walet_money = $info->walletbalance;
				}else{	
					$valid_time = "+".$new_plan_details['length_months'].' '.$new_plan_details['month_day'];
					$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));				
					if($getkeyDetails->month_day == 'days'){
						$diff_time=((strtotime($subscription_expire_2) - strtotime($subscription_expire_1))/(30*24*60*60));
						if($diff_time > 30){
							$time_get = ((strtotime($subscription_expire_1) - strtotime($now_time))/(30*24*60*60));
							$return_moneyto_walet = $info->walletbalance + ($time_get*$getkeyDetails->monthly_price);
							$walet_money = $return_moneyto_walet - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
						}else{
							$time_get = $getkeyDetails->length_months-30;;
							$return_moneyto_walet = $info->walletbalance + ($time_get*$getkeyDetails->monthly_price);
							$walet_money = $return_moneyto_walet - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
						}
					} elseif($getkeyDetails->month_day == 'months'){
						$diff_time=((strtotime($subscription_expire_2) - strtotime($subscription_expire_1))/(30*24*60*60));
						$monthReturnGet = '1';
						for($i=1;$i<=24;$i++){
							if($diff_time > $i){
								$monthReturnGet = $i;
							}
						}
						$return_length_months = $getkeyDetails->length_months;
						$return_monthly_price = $getkeyDetails->monthly_price;
						$return_moneyto_walet = $info->walletbalance + $return_monthly_price*($return_length_months - $monthReturnGet);
						$walet_money = $return_moneyto_walet - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
						
					}
					
					//echo $return_moneyto_walet.'-------------'.$walet_money;exit;
				}
			} elseif($info->sebscription_trpe == 'aproduct'){
					$valid_time = "+".$new_plan_details['length_months'].' '.$new_plan_details['month_day'];
					$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
					$walet_money = $info->walletbalance - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
			}elseif(($info->sebscription_trpe == 'subscript') || ($info->sebscription_trpe == 'rcode')){
					$newTotalPrice = ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
					$oldTotalPrice = $getkeyDetails->monthly_price*$getkeyDetails->length_months;
					
					if($newTotalPrice <= $oldTotalPrice){
						$subscription_expire = $info->subscription_expire;
						$walet_money = $info->walletbalance;						
					}else{
						$subscription_expire = $info->subscription_expire;
						$walet_money = $info->walletbalance;	
						$product_id = $info->product_id;	
						$devices_allowed = $info->devices_allowed;		
						$product_activation_key_id = $info->product_activation_key_id;	
					}					
			}else{ 
					$valid_time = "+".$new_plan_details['length_months'].' '.$new_plan_details['month_day'];
					$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
					
				    if($getkeyDetails->month_day == 'days'){
						$diff_time=((strtotime($subscription_expire_2) - strtotime($subscription_expire_1))/(30*24*60*60));
						if($diff_time > 30){
							$time_get = ((strtotime($subscription_expire_1) - strtotime($now_time))/(30*24*60*60));
							$return_moneyto_walet = $info->walletbalance + ($time_get*$getkeyDetails->monthly_price);
							$walet_money = $return_moneyto_walet - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
						}else{
							$time_get = $getkeyDetails->length_months-30;;
							$return_moneyto_walet = $info->walletbalance + ($time_get*$getkeyDetails->monthly_price);
							$walet_money = $return_moneyto_walet - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
						}
					} elseif($getkeyDetails->month_day == 'months'){
						$diff_time=((strtotime($subscription_expire_2) - strtotime($subscription_expire_1))/(30*24*60*60));
						$monthReturnGet = '1';
						for($i=1;$i<=24;$i++){
							if($diff_time > $i){
								$monthReturnGet = $i;
							}
						}
						
						$return_length_months = $getkeyDetails->length_months;
						$return_monthly_price = $getkeyDetails->monthly_price;
						$return_moneyto_walet = $info->walletbalance + $return_monthly_price*($return_length_months - $monthReturnGet);
						$walet_money = $return_moneyto_walet - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
						
						
					}
			}
			
			
				
			$data_customers = array('subscription_expire'=>$subscription_expire, 
											'product_activation_key_id' => $product_activation_key_id, 
												'product_id' => $product_id,
													'devices_allowed' => $devices_allowed,
														'activation_code' => '',
															'walletbalance' => $walet_money,
															'sebscription_trpe' => 'splan'
											);
			$where_customers = array('id' => $user_id);
			
			if($walet_money >= 0){
				$res =	$this->activation_keys_m->update_key($data_customers,$where_customers, 'customers');
				if($res){
					$data_customers_log = array('subscription_expire'=>$subscription_expire, 
											'product_activation_key_id' => $product_activation_key_id, 
												'product_id' => $product_id,
													'devices_allowed' => $devices_allowed,
														'activation_code' => '',
															'walletbalance' => $walet_money,
															'sebscription_trpe' => 'splan',
															'date_created'=>date("Y-m-d H:i:s")
											);
					 $log_text_array = $this->customerpanel_m->getdataall('plan_history',array('used_id' => $user_id));
					 if(count($log_text_array) > 0){
					 	 $log_text_array_log = json_decode($log_text_array[0]['log_json']);	
						 $log_array[] = $data_customers_log;
						 foreach($log_text_array_log as $val){
						 	$log_array[] = $val;
						 }							 			 	
					 	 $log_text = json_encode($log_array);
						 						 
						 $log_data = array('used_id'=>$user_id, 'log_json' => $log_text);
						 $this->customerpanel_m->update_key($log_data,array('used_id' => $user_id), 'plan_history');
						// echo $log_text;exit;
						
					 }else{		
					 	$log_array[] = $data_customers_log;			 					 
				     	$log_data = array('used_id'=>$user_id, 'log_json' => json_encode($log_array));					
					 	$this->customerpanel_m->insert('plan_history',$log_data);
					 }
					 
					 
					 
					  //Json Create
				//==========================================================================================================================
				//if($plan_keycode != ''){
					$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($info->email))));
					if(!is_dir($json_directory)){
						/* Directory does not exist, so lets create it. */
						mkdir($json_directory, 0777, true);
					}					
					/*$filename = $password . '.json';*/
					$filename = base64_decode($info->alpha_password) . '.json';
						
					$localFilePath = $json_directory.'/'.$filename;
					$final_json_output = $this->publishJsonGenerater(strtolower($info->email), base64_decode($info->password));
					
					$fpt_r = fopen($localFilePath, 'w');
					fwrite($fpt_r, $final_json_output);
					fclose($fpt_r);				
						
						
				//}	
				//===========================================================================================================================		
				
					 echo 'success';
				}	
			} else {
				echo 'shortmoney';
			}
				
		} else {
			$this->load->model('customerpanel_m');
			$new_plan_details = $this->customerpanel_m->getKeysById($planid);
			
			if($info->walletbalance >= $new_plan_details['monthly_price']){
				$valid_time = "+".$new_plan_details['length_months'].' '.$new_plan_details['month_day'];
				$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime(date("Y-m-d H:i:s"))));
						
				$product_id = $new_plan_details['product_id'];
				$devices_allowed = $new_plan_details['devices_allowed'];
				$walet_money = $info->walletbalance - ($new_plan_details['monthly_price']*$new_plan_details['length_months']);
				$product_activation_key_id = $new_plan_details['id'];
				//echo $subscription_expire;
				$data_customers = array('subscription_expire'=>$subscription_expire, 
												'product_activation_key_id' => $product_activation_key_id, 
													'product_id' => $product_id,
														'devices_allowed' => $devices_allowed,
															'activation_code' => '',
																'walletbalance' => $walet_money,
																'sebscription_trpe' => 'splan'
												);
					$where_customers = array('id' => $user_id);
					$res =	$this->activation_keys_m->update_key($data_customers,$where_customers, 'customers');
					
					if($res){
							 $data_customers_log = array('subscription_expire'=>$subscription_expire, 
												'product_activation_key_id' => $product_activation_key_id, 
													'product_id' => $product_id,
														'devices_allowed' => $devices_allowed,
															'activation_code' => '',
																'walletbalance' => $walet_money,
																'sebscription_trpe' => 'splan',
																'date_created'=>date("Y-m-d H:i:s")
												);
							 $log_text_array = $this->customerpanel_m->getdataall('plan_history',array('used_id' => $user_id));
							 if(count($log_text_array) > 0){
								 $log_text_array_log = json_decode($log_text_array[0]['log_json']);	
								 $log_array[] = $data_customers_log;								 
								 foreach($log_text_array_log as $val){
									$log_array[] = $val;
								 }	
								 			 	
								 $log_text = json_encode($log_array);								 														 
								 $log_data = array('used_id'=>$user_id, 'log_json' => $log_text);
								 $this->customerpanel_m->update_key($log_data,array('used_id' => $user_id), 'plan_history');
								// echo $log_text;exit;
								
							 }else{		
								$log_array[] = $data_customers_log;			 					 
								$log_data = array('used_id'=>$user_id, 'log_json' => json_encode($log_array));					
								$this->customerpanel_m->insert('plan_history',$log_data);
							 }
							 
							 
							 
							 
							   //Json Create
				//==========================================================================================================================
				//if($plan_keycode != ''){
					$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($info->email))));
					if(!is_dir($json_directory)){
						/* Directory does not exist, so lets create it. */
						mkdir($json_directory, 0777, true);
					}					
					/*$filename = $password . '.json';*/
					$filename = base64_decode($info->alpha_password) . '.json';
						
					$localFilePath = $json_directory.'/'.$filename;
					$final_json_output = $this->publishJsonGenerater(strtolower($info->email), base64_decode($info->password));
					
					$fpt_r = fopen($localFilePath, 'w');
					fwrite($fpt_r, $final_json_output);
					fclose($fpt_r);				
						
						
				//}	
				//===========================================================================================================================		
				
				
							echo 'success';
						}	
			}else {
				echo 'shortmoney';
			}	
		}	
			
	}
	/**
	Add Wallet Money
	By Bhaskar
	**/
	public function rechargewallet(){
		if (!$this->ion_customer_auth->logged_in()){
			redirect('customer/login', 'refresh');
		}		
		$user_id = $this->session->user_id;						 
								 
		$this->data['message'] = '';
		if(isset($_REQUEST['activation_code'])){ 
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->form_validation->set_rules('key_code', 'Wallet Code', 'trim|required');
			if ($this->form_validation->run() == FALSE){				
			 	$this->data['message'] = 'error';			
			} else{
				 $key_code = trim($this->input->post('key_code'));
				 $this->load->model('customerpanel_m');				
				 $getkeyDetails = $this->customerpanel_m->getallWaletKeysByKeycode($key_code);
				 //print_r($getkeyDetails);exit;
				 if(count($getkeyDetails) > 0){
					  if($getkeyDetails[0]['used'] == '0'){
							$data = array('used' => '1', 'used_by'=>$user_id);
							$where = array('key_code' => $key_code , 'active' => '1', 'used' => '0');
							$res = $this->customerpanel_m->update_key($data,$where, 'wallet_moneycode');
							
							if($res){
								$info = $this->customers_m->getCustomerInfo($user_id);
								$walletbalance = $info->walletbalance+$getkeyDetails[0]['price'];
								$data_customers = array('walletbalance'=>$walletbalance);
					 			$where_customers = array('id' => $user_id);
					 			$this->customerpanel_m->update_key($data_customers,$where_customers, 'customers');
								
								
								// log of wallet 
								//=====================================================================================================
								$data_wallet_log = array('recharge_date'=>date('Y-m-d H:i:s'), 
															'wallet_key' => $key_code, 
																'price' => $getkeyDetails[0]['price']
															);
		
								$log_text_array = $this->customerpanel_m->getdataall('plan_history',array('used_id' => $user_id));
								
								 if(count($log_text_array) > 0){
								 	 if($log_text_array[0]['waller_log'] != ''){
										 $log_text_array_log = json_decode($log_text_array[0]['waller_log']);	
										 $log_array[] = $data_wallet_log;
										 foreach($log_text_array_log as $val){
											$log_array[] = $val;
										 }							 			 	
										 $log_text = json_encode($log_array);
																 
										 $log_data = array('used_id'=>$user_id, 'waller_log' => $log_text);
										 $this->customerpanel_m->update_key($log_data,array('used_id' => $user_id), 'plan_history');
										
										//print_r($log_data);
										// echo $log_text;exit;
										
									 }else{		
										$log_array[] = $data_wallet_log;			 					 
										$log_data = array('used_id'=>$user_id, 'waller_log' => json_encode($log_array));
										
										//print_r($log_data);					
										$this->customerpanel_m->update_key($log_data,array('used_id' => $user_id), 'plan_history');
									 }
								 }else{
								 		$log_array[] = $data_wallet_log;			 					 
										$log_data = array('used_id'=>$user_id, 'waller_log' => json_encode($log_array));					
										//$this->customerpanel_m->insert('plan_history',$log_data);
								 }
								 
								
								 //Json Create
				//==========================================================================================================================
				//if($plan_keycode != ''){
					$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($info->email))));
					if(!is_dir($json_directory)){
						/* Directory does not exist, so lets create it. */
						mkdir($json_directory, 0777, true);
					}					
					/*$filename = $password . '.json';*/
					$filename = base64_decode($info->alpha_password) . '.json';
						
					$localFilePath = $json_directory.'/'.$filename;
					$final_json_output = $this->publishJsonGenerater(strtolower($info->email), base64_decode($info->password));
					
					$fpt_r = fopen($localFilePath, 'w');
					fwrite($fpt_r, $final_json_output);
					fclose($fpt_r);				
						
						
				//}	
				//===========================================================================================================================		
				
				
								redirect(BASE_URL.'customer');
							}
						 
					  } else {
							$this->session->set_flashdata('message_set',"Key Already Used");
							redirect(BASE_URL.'customer/rechargewallet');
					  }
				  } else {
				  		$this->session->set_flashdata('message_set',"Invalid Key");
						redirect(BASE_URL.'customer/rechargewallet');
				  }
			}	
			$this->data['key_code'] = $this->input->post('key_code');
		}
		$this->data['active_tab'] = 'usersubscription';
		$this->data['active_menu'] = 'rechargewallettab';
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard_new/_extra_scripts';
		//if($this->expiredplans()){
		if($this->session->product_activation_key_id > 0){ 
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/rechargewallet';
		}else{
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/activatecode';
		}
		//}
		$this->load->view( CUSTOMER_THEME . 'dashboard_new/_layout_after',$this->data);	
	}
	/**
	Activation by Subscription Code 
	By Bhaskar
	**/
	public function activatecode(){
		if (!$this->ion_customer_auth->logged_in()){
			redirect('customer/login', 'refresh');
		}		
		$user_id = $this->session->user_id;
		 // get user info
        $info = $this->customers_m->getCustomerInfo($user_id);
		$this->data['message'] = '';
		if(isset($_REQUEST['activation_code'])){ 	
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->form_validation->set_rules('a_key', 'Activation Keys', 'trim|required');
			if ($this->form_validation->run() == FALSE){
			 $this->data['message'] = 'error';			
			} else{
				 $a_key = trim($this->input->post('a_key'));
				 $keycode_where = array('keycode'=> $a_key, 'active' => '1');
				 $keycode_details = $this->customers_m->selectdatarow($keycode_where,'subscription_renewal_keys');				
				 //$code_master = 'not_master'; 				 
				if (count($keycode_details) > 0) { 					 
				 	if($keycode_details[0]['user_id'] == '0'){						
						if(($keycode_details[0]['key_type'] == 'master') || ($keycode_details[0]['key_type'] == 'activation')){
						
						if($keycode_details[0]['reseller_id'] == '0'){
							$sebscription_trpe = 'subscript';	 
						}elseif($keycode_details[0]['reseller_id'] > '0'){
							$sebscription_trpe = 'rcode';	
						}
				 		$this->load->model('reseller_m');
				 		$plan_keycode = $a_key;
						$now_time = date("Y-m-d H:i:s");
						$valid_time = "+".$keycode_details[0]['length_months'].' '.$keycode_details[0]['month_day'];
						$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
						
						$data = array(	"activation_code"=>$plan_keycode,
										"sebscription_trpe"=>$sebscription_trpe,
										'subscription_expire'=>$subscription_expire, 
													'product_activation_key_id' => $keycode_details[0]['id'], 
														'product_id' => $keycode_details[0]['product_id'],
															/*'devices_allowed' => $keycode_details[0]['devices_allowed'],*/
															/*'walletbalance' => $keycode_details[0]['monthly_price']*$keycode_details[0]['length_months'], */
															'walletbalance' => '0',
															'reseller_id' => $keycode_details[0]['reseller_id']
									);
						$where = array('id'=>$user_id);
						$this->customers_m->update_keycode($data,$where,'customers');
						
						$subscription_keys_data = array('user_id'=>$user_id,'used'=>'1');
						$subscription_keys_where = array('keycode'=>$plan_keycode);
						$this->customers_m->update_keycode($subscription_keys_data,$subscription_keys_where,'subscription_renewal_keys');						
						
						$data_customers_log = array( 'subscription_expire'=>$subscription_expire, 
												'product_activation_key_id' => $keycode_details[0]['id'], 
												'product_id' => $keycode_details[0]['product_id'],
												/*'devices_allowed' => $keycode_details[0]['devices_allowed'],*/
												'activation_code' => $plan_keycode,												
												'sebscription_trpe' => $sebscription_trpe,
												'date_created'=>date("Y-m-d H:i:s"),
												'plan_name'=>$keycode_details[0]['group_name']
											);
						$data_customers_reseller_log = array( 'subscription_expire'=>$subscription_expire, 
													  	'product_activation_key_id' => $keycode_details[0]['id'], 
															'product_id' => $keycode_details[0]['product_id'],
																/*'devices_allowed' => $keycode_details[0]['devices_allowed'],*/
																	'activation_code' => $plan_keycode,
																		'customer_name' => $info->first_name.' '.$info->last_name,
																			'sebscription_trpe'=>$sebscription_trpe,
																			'date_created'=>date("Y-m-d H:i:s"),
																			'plan_name'=>$keycode_details[0]['group_name']
													);
													
													
				
						$log_array[] = $data_customers_log;			 					 
						$log_data = array('used_id'=>$user_id, 'log_json' => json_encode($log_array));					
						$this->customers_m->insertRow($log_data,'plan_history');
						
						$log_text_array_reseller = $this->customers_m->selectdatarow(array('reseller_id' => $keycode_details[0]['reseller_id']),'reseller_history');						
						$log_array_reseller = array();
						$log_array_reseller_kcode = array();
						if(count($log_text_array_reseller) > 0){
							 $log_text_array_log_reseller = json_decode($log_text_array_reseller[0]['log_json'],true);	
							 array_push($log_array_reseller,$data_customers_reseller_log);
							 foreach($log_text_array_log_reseller['user_activate'] as $key=>$val){ //print_r($val);
									 array_push($log_array_reseller,$val);
							 }
							 
							  foreach($log_text_array_log_reseller['key_code'] as $key1=>$val1){ 
									array_push($log_array_reseller_kcode,$val1);
							  }
										 
							 $log_text_reseller = json_encode(array('user_activate' =>$log_array_reseller, 'key_code' => $log_array_reseller_kcode));
							 $log_data_reseller = array('reseller_id' => $keycode_details[0]['reseller_id'], 'log_json' => $log_text_reseller);
							 $this->customers_m->update_keycode($log_data_reseller,array('reseller_id' => $this->session->resellerid), 'reseller_history');
						}else{		
							$log_array_reseller['user_activate'][0] = $data_customers_reseller_log;			 					 
							$log_data_reseller = array('reseller_id' => $keycode_details[0]['reseller_id'], 'log_json' => json_encode($log_array_reseller));					
							$this->customers_m->insertkeys($log_data_reseller,'reseller_history');
						}
				
						//Email Send
						//============================================================================================================================
						$this->load->model('email_templates_m');					
						$info_email=$this->email_templates_m->get(6,TRUE);						
						$mail_body = $info_email->body;
						$replacing_string = array("[FIRST_NAME]" => $info->first_name,
													"[LOGIN_LINK]" => '<a href="'.site_url('customer/login/').'">Login Link</a>',
														"[USERNAME]" => $info->email,
														"[PASSWORD]" => base64_decode($info->password));						
							
						
						$toname = $info->first_name;
						$subject = $info_email->subject;
						$from = $info_email->sender_email;
						$fromname = $info_email->sender_name;
						
									
						$bodyHTML =	strtr($info_email->body, $replacing_string);
						//echo $bodyHTML;exit;
						$this->send_email($subject, $bodyHTML, $from, $fromname, $info->email, $toname);
						
						//===============================================================================================================================
						
						//Json Create
				//==========================================================================================================================
				//if($plan_keycode != ''){
					$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($info->email))));
					if(!is_dir($json_directory)){
						/* Directory does not exist, so lets create it. */
						mkdir($json_directory, 0777, true);
					}					
					/*$filename = $password . '.json';*/
					$filename = base64_decode($info->alpha_password) . '.json';
						
					$localFilePath = $json_directory.'/'.$filename;
					$final_json_output = $this->publishJsonGenerater(strtolower($info->email), base64_decode($info->password));
					
					$fpt_r = fopen($localFilePath, 'w');
					fwrite($fpt_r, $final_json_output);
					fclose($fpt_r);	
				//}	
				//===========================================================================================================================		
						redirect(BASE_URL.'customer');
				   			 
				   
						}else{
							$this->data['message'] = 'error';	
							$this->data['message_content'] = 'Invalid Key.';	
						 }
					}else{
						$this->data['message'] = 'error';	
						$this->data['message_content'] = 'Key Already Used.';	
					 }
				 
				 }else{
				 	$this->data['message'] = 'error';	
					$this->data['message_content'] = 'Key Not exit.';	
				 }
				 //echo $res;exit;
			}
		}
		
		$this->data['active_tab'] = 'usersubscription';
		$this->data['active_menu'] = 'activatecode';
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard_new/_extra_scripts';
		
		//if($this->expiredplans()){
		if($this->session->product_activation_key_id > 0){ 
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/subscription';
		} else {
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/activatecode';
		}
		//}
		$this->load->view( CUSTOMER_THEME . 'dashboard_new/_layout_after',$this->data);	
		
	}
	
	public function activatecode_05_10_2023(){
		if (!$this->ion_customer_auth->logged_in()){
			redirect('customer/login', 'refresh');
		}		
		$user_id = $this->session->user_id;
		 // get user info
        $info = $this->customers_m->getCustomerInfo($user_id);
		$this->data['message'] = '';
		if(isset($_REQUEST['activation_code'])){ 	
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->form_validation->set_rules('a_key', 'Activation Keys', 'trim|required');
			if ($this->form_validation->run() == FALSE){
			 $this->data['message'] = 'error';			
			} else{
				 $a_key = trim($this->input->post('a_key'));
				 $keycode_where = array('keycode'=> $a_key, 'active' => '1');
				 $keycode_details = $this->customers_m->selectdatarow($keycode_where,'subscription_renewal_keys');				
				 //$code_master = 'not_master'; 				 
				if (count($keycode_details) > 0) { 					 
				 	if($keycode_details[0]['user_id'] == '0'){						
						if(($keycode_details[0]['key_type'] == 'master') || ($keycode_details[0]['key_type'] == 'activation')){
						
						if($keycode_details[0]['reseller_id'] == '0'){
							$sebscription_trpe = 'subscript';	 
						}elseif($keycode_details[0]['reseller_id'] > '0'){
							$sebscription_trpe = 'rcode';	
						}
				 		$this->load->model('reseller_m');
				 		$plan_keycode = $a_key;
						$now_time = date("Y-m-d H:i:s");
						$valid_time = "+".$keycode_details[0]['length_months'].' '.$keycode_details[0]['month_day'];
						$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
						
						$data = array(	"activation_code"=>$plan_keycode,
										"sebscription_trpe"=>$sebscription_trpe,
										'subscription_expire'=>$subscription_expire, 
													'product_activation_key_id' => $keycode_details[0]['id'], 
														'product_id' => $keycode_details[0]['product_id'],
															/*'devices_allowed' => $keycode_details[0]['devices_allowed'],*/
															/*'walletbalance' => $keycode_details[0]['monthly_price']*$keycode_details[0]['length_months'], */
															'walletbalance' => '0',
															'reseller_id' => $keycode_details[0]['reseller_id']
									);
						$where = array('id'=>$user_id);
						$this->customers_m->update_keycode($data,$where,'customers');
						
						$subscription_keys_data = array('user_id'=>$user_id,'used'=>'1');
						$subscription_keys_where = array('keycode'=>$plan_keycode);
						$this->customers_m->update_keycode($subscription_keys_data,$subscription_keys_where,'subscription_renewal_keys');						
						
						$data_customers_log = array( 'subscription_expire'=>$subscription_expire, 
												'product_activation_key_id' => $keycode_details[0]['id'], 
												'product_id' => $keycode_details[0]['product_id'],
												/*'devices_allowed' => $keycode_details[0]['devices_allowed'],*/
												'activation_code' => $plan_keycode,												
												'sebscription_trpe' => $sebscription_trpe,
												'date_created'=>date("Y-m-d H:i:s"),
												'plan_name'=>$keycode_details[0]['group_name']
											);
						$data_customers_reseller_log = array( 'subscription_expire'=>$subscription_expire, 
													  	'product_activation_key_id' => $keycode_details[0]['id'], 
															'product_id' => $keycode_details[0]['product_id'],
																/*'devices_allowed' => $keycode_details[0]['devices_allowed'],*/
																	'activation_code' => $plan_keycode,
																		'customer_name' => $info->first_name.' '.$info->last_name,
																			'sebscription_trpe'=>$sebscription_trpe,
																			'date_created'=>date("Y-m-d H:i:s"),
																			'plan_name'=>$keycode_details[0]['group_name']
													);
													
													
				
						$log_array[] = $data_customers_log;			 					 
						$log_data = array('used_id'=>$user_id, 'log_json' => json_encode($log_array));					
						$this->customers_m->insertRow($log_data,'plan_history');
						
						$log_text_array_reseller = $this->customers_m->selectdatarow(array('reseller_id' => $keycode_details[0]['reseller_id']),'reseller_history');						
						$log_array_reseller = array();
						$log_array_reseller_kcode = array();
						if(count($log_text_array_reseller) > 0){
							 $log_text_array_log_reseller = json_decode($log_text_array_reseller[0]['log_json'],true);	
							 array_push($log_array_reseller,$data_customers_reseller_log);
							 foreach($log_text_array_log_reseller['user_activate'] as $key=>$val){ //print_r($val);
									 array_push($log_array_reseller,$val);
							 }
							 
							  foreach($log_text_array_log_reseller['key_code'] as $key1=>$val1){ 
									array_push($log_array_reseller_kcode,$val1);
							  }
										 
							 $log_text_reseller = json_encode(array('user_activate' =>$log_array_reseller, 'key_code' => $log_array_reseller_kcode));
							 $log_data_reseller = array('reseller_id' => $keycode_details[0]['reseller_id'], 'log_json' => $log_text_reseller);
							 $this->customers_m->update_keycode($log_data_reseller,array('reseller_id' => $this->session->resellerid), 'reseller_history');
						}else{		
							$log_array_reseller['user_activate'][0] = $data_customers_reseller_log;			 					 
							$log_data_reseller = array('reseller_id' => $keycode_details[0]['reseller_id'], 'log_json' => json_encode($log_array_reseller));					
							$this->customers_m->insertkeys($log_data_reseller,'reseller_history');
						}
				
						//Email Send
						//============================================================================================================================
						$this->load->model('email_templates_m');					
						$info_email=$this->email_templates_m->get(6,TRUE);						
						$mail_body = $info_email->body;
						$replacing_string = array("[FIRST_NAME]" => $info->first_name,
													"[LOGIN_LINK]" => '<a href="'.site_url('customer/login/').'">Login Link</a>',
														"[USERNAME]" => $info->email,
														"[PASSWORD]" => base64_decode($info->password));						
							
						
						$toname = $info->first_name;
						$subject = $info_email->subject;
						$from = $info_email->sender_email;
						$fromname = $info_email->sender_name;
						
									
						$bodyHTML =	strtr($info_email->body, $replacing_string);
						//echo $bodyHTML;exit;
						$this->send_email($subject, $bodyHTML, $from, $fromname, $info->email, $toname);
						
						//===============================================================================================================================
						
						//Json Create
				//==========================================================================================================================
				//if($plan_keycode != ''){
					$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($info->email))));
					if(!is_dir($json_directory)){
						/* Directory does not exist, so lets create it. */
						mkdir($json_directory, 0777, true);
					}					
					/*$filename = $password . '.json';*/
					$filename = base64_decode($info->alpha_password) . '.json';
						
					$localFilePath = $json_directory.'/'.$filename;
					$final_json_output = $this->publishJsonGenerater(strtolower($info->email), base64_decode($info->password));
					
					$fpt_r = fopen($localFilePath, 'w');
					fwrite($fpt_r, $final_json_output);
					fclose($fpt_r);	
				//}	
				//===========================================================================================================================		
						redirect(BASE_URL.'customer');
				   			 
				   
						}else{
							$this->data['message'] = 'error';	
							$this->data['message_content'] = 'Invalid Key.';	
						 }
					}else{
						$this->data['message'] = 'error';	
						$this->data['message_content'] = 'Key Already Used.';	
					 }
				 
				 }else{
				 	$this->data['message'] = 'error';	
					$this->data['message_content'] = 'Key Not exit.';	
				 }
				 //echo $res;exit;
			}
		}
		
		$this->data['active_tab'] = 'usersubscription';
		$this->data['active_menu'] = 'activatecode';
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard_new/_extra_scripts';
		
		//if($this->expiredplans()){
		if($this->session->product_activation_key_id > 0){ 
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/subscription';
		} else {
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/activatecode';
		}
		//}
		$this->load->view( CUSTOMER_THEME . 'dashboard_new/_layout_after',$this->data);	
		
	}
	
	public function activatecodeXXX(){
		if (!$this->ion_customer_auth->logged_in()){
			redirect('customer/login', 'refresh');
		}		
		$user_id = $this->session->user_id;
		
		
		
		 // get user info
        $info = $this->customers_m->getCustomerInfo($user_id);
		/*echo '<pre>';
		print_r($info);exit;*/
		
		
		$this->data['message'] = '';
		if(isset($_REQUEST['activation_code'])){ 	
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->form_validation->set_rules('a_key', 'Activation Keys', 'trim|required');
			if ($this->form_validation->run() == FALSE){
			 $this->data['message'] = 'error';			
			} else{
				 $a_key = trim($this->input->post('a_key'));
				 $this->load->model('activation_keys_m');
				 //$getkeyDetails = $this->activation_keys_m->getActivationKeyInfo($a_key);
				 $getkeyDetails = $this->activation_keys_m->getActivationKeyInfo($a_key);
				 $code_master = 'not_master'; 
				 
				if ($getkeyDetails) {
				 	/*echo '<pre>';
				  	print_r($getkeyDetails);exit;*/
				 	if($getkeyDetails[0]['user_id'] == '0'){										
					 $data = array('user_id'=>$user_id, 'used' => '1');
					 $where = array('keycode' => $a_key, 'active' => '1', 'used' => '0');
					 $res = $this->activation_keys_m->update_key($data,$where, 'activation_keys');
					 if($res){
					 	$month_expire = $getkeyDetails[0]['length_months'];
					 	$subscription_expire = date('Y-m-d H:i:s', strtotime("+".$month_expire." months", strtotime(date("Y-m-d H:i:s"))));
					 	//$subscription_expire = date("Y-m-d H:i:s");
						//added money in user wallet when a user make activate by activation key
					 	$data_customers = array('subscription_expire'=>$subscription_expire, 
												'product_activation_key_id' => $getkeyDetails[0]['id'], 
												'product_id' => $getkeyDetails[0]['product_id'],
												'devices_allowed' => $getkeyDetails[0]['devices_allowed'],
												'sebscription_trpe' => 'aplan',
												'walletbalance' => $getkeyDetails[0]['monthly_price']*$getkeyDetails[0]['length_months'], 
												'activation_code' => $a_key);
												
						
					 	$where_customers = array('id' => $user_id);
					 	$this->activation_keys_m->update_key($data_customers,$where_customers, 'customers');
						
						$this->load->model('reseller_m');
						$activation_keys_data = array('user_id'=>$user_id,'used'=>'1');
						$activation_keys_where = array('keycode'=>$a_key);
						$this->reseller_m->update_keycode($activation_keys_data,$activation_keys_where,'activation_keys');
						
						
						//Email Send
						//============================================================================================================================
						$this->load->model('email_templates_m');					
						$info_email=$this->email_templates_m->get(6,TRUE);						
						$mail_body = $info_email->body;
						$replacing_string = array("[FIRST_NAME]" => $info->first_name,
													"[LOGIN_LINK]" => '<a href="'.site_url('customer/login/').'">Login Link</a>',
														"[USERNAME]" => $info->email,
														"[PASSWORD]" => base64_decode($info->password));						
							
						
						$toname = $info->first_name;
						$subject = $info_email->subject;
						$from = $info_email->sender_email;
						$fromname = $info_email->sender_name;
						
									
						$bodyHTML =	strtr($info_email->body, $replacing_string);
						//echo $bodyHTML;exit;
						$this->send_email($subject, $bodyHTML, $from, $fromname, $info->email, $toname);
						
						//===============================================================================================================================
						$this->session->set_flashdata('message_set',"Activation Success");
						redirect(BASE_URL.'customer');
					 }
				 
				 	
					}elseif($code_master == 'master') { 
						
				 	$this->load->model('reseller_m');
				 	$plan_keycode = $a_key;
				 	$where_keycode = array('keycode'=>$plan_keycode , 'used' =>0, 'active'=>1);		
					$keycode_details = $this->reseller_m->selectdatarow($where_keycode,'subscription_renewal_keys');
					if(count($keycode_details) > 0){
						$now_time = date("Y-m-d H:i:s");
						$valid_time = "+".$keycode_details[0]['length_months'].' '.$keycode_details[0]['month_day'];
						$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
						
						$data = array(	"activation_code"=>$plan_keycode,
										"sebscription_trpe"=>'rcode',
										'subscription_expire'=>$subscription_expire, 
													'product_activation_key_id' => $keycode_details[0]['id'], 
														'product_id' => $keycode_details[0]['product_id'],
															'devices_allowed' => $keycode_details[0]['devices_allowed'],
															'reseller_id' => $keycode_details[0]['reseller_id']
									);
						$where = array('id'=>$user_id);
						$this->reseller_m->update_keycode($data,$where,'customers');
						
						$subscription_keys_data = array('user_id'=>$user_id,'used'=>'1');
						$subscription_keys_where = array('keycode'=>$plan_keycode);
						$this->reseller_m->update_keycode($subscription_keys_data,$subscription_keys_where,'subscription_renewal_keys');
						
						
						
						$data_customers_log = array( 'subscription_expire'=>$subscription_expire, 
												'product_activation_key_id' => $keycode_details[0]['id'], 
												'product_id' => $keycode_details[0]['product_id'],
												'devices_allowed' => $keycode_details[0]['devices_allowed'],
												'activation_code' => $plan_keycode,												
												'sebscription_trpe' => 'rcode'
											);
						$data_customers_reseller_log = array( 'subscription_expire'=>$subscription_expire, 
													  	'product_activation_key_id' => $keycode_details[0]['id'], 
															'product_id' => $keycode_details[0]['product_id'],
																'devices_allowed' => $keycode_details[0]['devices_allowed'],
																	'activation_code' => $plan_keycode,
																		'customer_name' => $info->first_name.' '.$info->last_name,
																			'sebscription_trpe'=>'rcode',
																			'date_created'=>date("Y-m-d H:i:s"),
																			'plan_name'=>$keycode_details[0]['group_name']
													);
													
													
				
						$log_array[] = $data_customers_log;			 					 
						$log_data = array('used_id'=>$user_id, 'log_json' => json_encode($log_array));					
						$this->reseller_m->insertRow($log_data,'plan_history');
						
						$log_text_array_reseller = $this->reseller_m->selectdatarow(array('reseller_id' => $keycode_details[0]['reseller_id']),'reseller_history');						
						$log_array_reseller = array();
						$log_array_reseller_kcode = array();
						if(count($log_text_array_reseller) > 0){
							 $log_text_array_log_reseller = json_decode($log_text_array_reseller[0]['log_json'],true);	
							 array_push($log_array_reseller,$data_customers_reseller_log);
							 foreach($log_text_array_log_reseller['user_activate'] as $key=>$val){ //print_r($val);
									 array_push($log_array_reseller,$val);
							 }
							 
							  foreach($log_text_array_log_reseller['key_code'] as $key1=>$val1){ 
									array_push($log_array_reseller_kcode,$val1);
							  }
										 
							 $log_text_reseller = json_encode(array('user_activate' =>$log_array_reseller, 'key_code' => $log_array_reseller_kcode));
							 $log_data_reseller = array('reseller_id' => $keycode_details[0]['reseller_id'], 'log_json' => $log_text_reseller);
							 $this->reseller_m->update_keycode($log_data_reseller,array('reseller_id' => $this->session->resellerid), 'reseller_history');
						}else{		
							$log_array_reseller['user_activate'][0] = $data_customers_reseller_log;			 					 
							$log_data_reseller = array('reseller_id' => $keycode_details[0]['reseller_id'], 'log_json' => json_encode($log_array_reseller));					
							$this->reseller_m->insertkeys($log_data_reseller,'reseller_history');
						}
				
						//Email Send
						//============================================================================================================================
						$this->load->model('email_templates_m');					
						$info_email=$this->email_templates_m->get(6,TRUE);						
						$mail_body = $info_email->body;
						$replacing_string = array("[FIRST_NAME]" => $info->first_name,
													"[LOGIN_LINK]" => '<a href="'.site_url('customer/login/').'">Login Link</a>',
														"[USERNAME]" => $info->email,
														"[PASSWORD]" => base64_decode($info->password));						
							
						
						$toname = $info->first_name;
						$subject = $info_email->subject;
						$from = $info_email->sender_email;
						$fromname = $info_email->sender_name;
						
									
						$bodyHTML =	strtr($info_email->body, $replacing_string);
						//echo $bodyHTML;exit;
						$this->send_email($subject, $bodyHTML, $from, $fromname, $info->email, $toname);
						
						//===============================================================================================================================
						
						//Json Create
				//==========================================================================================================================
				//if($plan_keycode != ''){
					$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($info->email))));
					if(!is_dir($json_directory)){
						/* Directory does not exist, so lets create it. */
						mkdir($json_directory, 0777, true);
					}					
					/*$filename = $password . '.json';*/
					$filename = base64_decode($info->alpha_password) . '.json';
						
					$localFilePath = $json_directory.'/'.$filename;
					$final_json_output = $this->publishJsonGenerater(strtolower($info->email), base64_decode($info->password));
					
					$fpt_r = fopen($localFilePath, 'w');
					fwrite($fpt_r, $final_json_output);
					fclose($fpt_r);				
						
						
				//}	
				//===========================================================================================================================		
						redirect(BASE_URL.'customer');
				   } else{				
						$this->session->set_flashdata('message_set',"Key Already Used");
						redirect(BASE_URL.'customer/activatecode');
					}
				 
				    }else{
						$this->data['message'] = 'error';	
						$this->data['message_content'] = 'Key Already Used.';	
					 }
				 
				 }else{
				 	$this->data['message'] = 'error';	
					$this->data['message_content'] = 'Key Not exit.';	
				 }
				 //echo $res;exit;
			}
		}
		
		$this->data['active_tab'] = 'usersubscription';
		$this->data['active_menu'] = 'activatecode';
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard_new/_extra_scripts';
		
		//if($this->expiredplans()){
		if($this->session->product_activation_key_id > 0){ 
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/subscription';
		} else {
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/activatecode';
		}
		//}
		$this->load->view( CUSTOMER_THEME . 'dashboard_new/_layout_after',$this->data);	
		
	}

	/**
	Activation Subscription Code
	By Bhaskar
	**/
	public function activatsubscriptionecode(){
		if (!$this->ion_customer_auth->logged_in()){
			redirect('customer/login', 'refresh');
		}		
		$user_id = $this->session->user_id;		
		// get user info
        $info = $this->customers_m->getCustomerInfo($user_id);
		
		$this->data['message'] = '';
		if(isset($_REQUEST['activation_code'])){ 	
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->form_validation->set_rules('a_key', 'Activation Keys', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$this->data['message'] = 'error';			
			} else{
				 $a_key = trim($this->input->post('a_key'));
				 $this->load->model('activation_keys_m');				 
				 $getkeyDetails = $this->activation_keys_m->getKeyInfoDetails(array('keycode' => $a_key), 'subscription_renewal_keys');				
				 if($getkeyDetails->user_id == '0'){					 
					 $data = array('user_id'=>$user_id, 'used' => '1');
					 $where = array('keycode' => $a_key, 'active' => '1', 'used' => '0');
					 $res = $this->activation_keys_m->update_key($data,$where, 'subscription_renewal_keys');
					 //$res = true;
					 $product_activation_key_id = $info->product_activation_key_id;
					 if($info->sebscription_trpe == 'subscript'){
					 	$getkeyDetails_pre = $this->activation_keys_m->getKeyInfoDetails(array('id' => $product_activation_key_id), 'subscription_renewal_keys');
					 }elseif($info->sebscription_trpe == 'splan'){
					 	$getkeyDetails_pre = $this->activation_keys_m->getKeyInfoDetails(array('id' => $product_activation_key_id), 'customers_panel_subscription');
					 }elseif($info->sebscription_trpe == 'aplan'){
					 	$getkeyDetails_pre = $this->activation_keys_m->getKeyInfoDetails(array('id' => $product_activation_key_id), 'activation_keys');
					 }
					 
					 $subscription_expire_1 = $info->subscription_expire;
					 $month_expire_pre = $getkeyDetails_pre->length_months." ".$getkeyDetails_pre->month_day;
					 $subscription_expire_2 = date('Y-m-d H:i:s', strtotime("+".$month_expire_pre, strtotime(date("Y-m-d H:i:s"))));
		
					 $now_time = date("Y-m-d H:i:s");		
					 $return_moneyto_walet = '';
						if(((strtotime($subscription_expire_1) - strtotime($now_time))/(60)) > 0){
							$diff_time=((strtotime($subscription_expire_2) - strtotime($subscription_expire_1))/(30*24*60*60));
							
							$monthReturnGet = '1';
							for($i=1;$i<=24;$i++){
								if($diff_time > $i){
									$monthReturnGet = $i;
								}
							}
														
							if($getkeyDetails_pre->month_day == 'days'){
								$return_length_months = $getkeyDetails_pre->length_months-30;
								$return_monthly_price = $getkeyDetails_pre->monthly_price;
								if($return_length_months > 0){
									$return_moneyto_walet = $info->walletbalance + $return_monthly_price*$return_length_months;
								} else{
									$return_moneyto_walet = $info->walletbalance;
								}
							} else {
								$return_length_months = $getkeyDetails_pre->length_months;
								$return_monthly_price = $getkeyDetails_pre->monthly_price;
								$return_moneyto_walet = $info->walletbalance + $return_monthly_price*($return_length_months - $monthReturnGet);
							}
														
						}
					
					 if($res){ 
					 	
					 	if($info->sebscription_trpe == 'subscript'){
						 	if($getkeyDetails_pre->group_unic_code == $getkeyDetails->group_unic_code){
								$month_expire = $getkeyDetails->length_months." ".$getkeyDetails->month_day;
								$subscription_expire = date('Y-m-d H:i:s', strtotime("+".$month_expire, strtotime($subscription_expire_1)));
								
								$data_customers = array(
														'subscription_expire'=>$subscription_expire, 
														'product_activation_key_id' => $getkeyDetails->id, 
														'product_id' => $getkeyDetails->product_id,
														'devices_allowed' => $getkeyDetails->devices_allowed,
														'activation_code' => $a_key,														
														'sebscription_trpe' => 'subscript'
													   );
								$bodysms = "Thank you . Plan have extend!";
							}else{
								$month_expire = $getkeyDetails->length_months." ".$getkeyDetails->month_day;
								$subscription_expire = date('Y-m-d H:i:s', strtotime("+".$month_expire, strtotime(date("Y-m-d H:i:s"))));
								
								$data_customers = array(
														'subscription_expire'=>$subscription_expire, 
														'product_activation_key_id' => $getkeyDetails->id, 
														'product_id' => $getkeyDetails->product_id,
														'devices_allowed' => $getkeyDetails->devices_allowed,
														'activation_code' => $a_key,
														'walletbalance' => $return_moneyto_walet,
														'sebscription_trpe' => 'subscript'
													   );
								$bodysms = "Thank you . Subscription is activated!";
							}
						} elseif($info->sebscription_trpe == 'splan'){
						 	
							$month_expire = $getkeyDetails->length_months." ".$getkeyDetails->month_day;
							$subscription_expire = date('Y-m-d H:i:s', strtotime("+".$month_expire, strtotime(date("Y-m-d H:i:s"))));
							
							$data_customers = array(
													'subscription_expire'=>$subscription_expire, 
													'product_activation_key_id' => $getkeyDetails->id, 
													'product_id' => $getkeyDetails->product_id,
													'devices_allowed' => $getkeyDetails->devices_allowed,
													'activation_code' => $a_key,
													'walletbalance' => $return_moneyto_walet,
													'sebscription_trpe' => 'subscript'
												   );
							
							$bodysms = "Thank you . Subscription is activated!";
						}elseif($info->sebscription_trpe == 'aplan'){
						 	$month_expire = $getkeyDetails->length_months." ".$getkeyDetails->month_day;
							$subscription_expire = date('Y-m-d H:i:s', strtotime("+".$month_expire, strtotime(date("Y-m-d H:i:s"))));
							
							$data_customers = array(
													'subscription_expire'=>$subscription_expire, 
													'product_activation_key_id' => $getkeyDetails->id, 
													'product_id' => $getkeyDetails->product_id,
													'devices_allowed' => $getkeyDetails->devices_allowed,
													'activation_code' => $a_key,
													'walletbalance' => $return_moneyto_walet,
													'sebscription_trpe' => 'subscript'
												   );
							$bodysms = "Thank you . Subscription is activated!";
							
						}
						
						$where_customers = array('id' => $user_id);
						$this->activation_keys_m->update_key($data_customers,$where_customers, 'customers');
							
						$number = $info->c_code.$info->c_mobile;
						
						//activatsubscriptionecode()
						$this->send_sms($number,$bodysms);
							
										
						
						$this->session->set_flashdata('message_set',"Activation Success");
						
						$log_text_array = $this->customerpanel_m->getdataall('plan_history',array('used_id' => $user_id));
						 if(count($log_text_array) > 0){
							 $log_text_array_log = json_decode($log_text_array[0]['log_json']);	
							 $log_array[] = $data_customers;
							 foreach($log_text_array_log as $val){
								$log_array[] = $val;
							 }							 			 	
							 $log_text = json_encode($log_array);
													 
							 $log_data = array('used_id'=>$user_id, 'log_json' => $log_text);
							 $this->customerpanel_m->update_key($log_data,array('used_id' => $user_id), 'plan_history');
							// echo $log_text;exit;
							
						 }else{		
							$log_array[] = $data_customers;			 					 
							$log_data = array('used_id'=>$user_id, 'log_json' => json_encode($log_array));					
							$this->customerpanel_m->insert('plan_history',$log_data);
						 }
					 
					 
					 //json Created
					 //==========================================================================================================================
				//if($plan_keycode != ''){
					$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($info->email))));
					if(!is_dir($json_directory)){
						/* Directory does not exist, so lets create it. */
						mkdir($json_directory, 0777, true);
					}					
					/*$filename = $password . '.json';*/
					$filename = base64_decode($info->alpha_password) . '.json';
						
					$localFilePath = $json_directory.'/'.$filename;
					$final_json_output = $this->publishJsonGenerater(strtolower($info->email), base64_decode($info->password));
					
					$fpt_r = fopen($localFilePath, 'w');
					fwrite($fpt_r, $final_json_output);
					fclose($fpt_r);				
						
						
				//}	
				//===========================================================================================================================	
				
				
				
						redirect(BASE_URL.'customer/activatecode');
					 }
				 } else {
				 	$this->session->set_flashdata('message_set',"Key Already Used");
					redirect(BASE_URL.'customer/activatecode');
				 }
				
			}
		}
		
		$this->data['active_tab'] = 'usersubscription';
		$this->data['active_menu'] = 'activatecode';
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard_new/_extra_scripts';
		if($this->session->product_activation_key_id > 0){ 
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/subscription';
		} else {
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/activatecode';
		}
		
		$this->load->view( CUSTOMER_THEME . 'dashboard_new/_layout_after',$this->data);	
		
	}
	/**
	 * Log the user in
	 */
	public function login(){

		$this->data['title'] = $this->lang->line('login_heading');

		// validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() === TRUE)
		{
			
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool)$this->input->post('remember');

			if ($this->ion_customer_auth->login(trim($this->input->post('identity')), trim($this->input->post('password')), $remember))
			{
				
				//if the login is successful
				//redirect them back to the home page
				//get user details

				$user_info = $this->ion_customer_auth->user($this->session->user_id)->result();
				/*echo '<pre>';
				print_r($user_info);
				exit;*/
				foreach ($user_info as $user):
					$newdata = array(
				        'first_name'  => $user->first_name,
				        'last_name'   => $user->last_name				        
					);
				endforeach;
				
				$this->session->set_userdata($newdata);
				$this->session->set_userdata(array('role'=>'customers'));
				$this->session->set_userdata(array('product_activation_key_id'=>$user->product_activation_key_id));
				
				// update login logs 
				$this->userlogs->track_login($user_info[0]->id, "login");

				$this->session->set_flashdata('message', $this->ion_customer_auth->messages());
				redirect(BASE_URL.'customer/profile');
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				
				//print_r($this->ion_auth->errors());
				
				$this->session->set_flashdata('message_set', $this->ion_customer_auth->errors());
				//$this->session->set_flashdata('message_set',"Password Updated Successfully.");
				redirect('customer/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['identity'] = $this->input->post('identity');
			$this->data['password'] = $this->input->post('password');
			/*$this->data['identity'] = [
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
				'class'       => 'form-control',
                'placeholder' => lang('auth_your_email')
			];

			$this->data['password'] = [
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'class'       => 'form-control',
                'placeholder' => lang('auth_your_password')
			];*/

			//$this->_render_page('customer' . DIRECTORY_SEPARATOR . 'login', $this->data);
			
			
			$this->data['_view'] = CUSTOMER_THEME . 'registration/login';
			
			
			$this->load->view( CUSTOMER_THEME . 'registration/_layout_before',$this->data);
		}
	}

	/**
	 * Log the user out
	 */
	public function logout(){
		$this->data['title'] = "Logout";

		// update logout logs 
		$this->userlogs->track_login($this->session->user_id, "logout");

		// log the user out
		$this->ion_customer_auth->logout();
		
		$this->session->set_flashdata('message', $this->ion_customer_auth->messages());
		
		// redirect them to the login page
		redirect('customer/login', 'refresh');
	}

	/**
	 * Log the user out
	 */
	public function unauthorize()
	{
		$this->data['title'] = "Unauthorize";
		$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'unauthorize', $this->data);
	}

	/**
	 * Change password
	 */

	public function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_customer_auth->logged_in())
		{
			redirect('customer/login', 'refresh');
		}
		
		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() === FALSE)
		{
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = [
				'name' => 'old',
				'id' => 'old',
				'type' => 'password',
			];
			$this->data['new_password'] = [
				'name' => 'new',
				'id' => 'new',
				'type' => 'password',
				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
			];
			$this->data['new_password_confirm'] = [
				'name' => 'new_confirm',
				'id' => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
			];
			$this->data['user_id'] = [
				'name' => 'user_id',
				'id' => 'user_id',
				'type' => 'hidden',
				'value' => $user->id,
			];

			// render
			$this->_render_page('customer' . DIRECTORY_SEPARATOR . 'change_password', $this->data);
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				$this->userlogs->track_this($user->id, "Updated Password on ". date('Y-m-d H:i:s', time()));
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('customer/change_password', 'refresh');
			}
		}
	}

	/**
	 * Forgot password
	 */
	public function forgot_password()
	{
		$this->data['title'] = $this->lang->line('forgot_password_heading');
		
		// setting validation rules by checking whether identity is username or email
		if ($this->config->item('identity', 'ion_auth') != 'email')
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		}
		else
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}

		if ($this->form_validation->run() === FALSE)
		{
			$this->data['type'] = $this->config->item('identity', 'ion_auth');
			// setup the input
			$this->data['identity'] = [
				'name' => 'identity',
				'id' => 'identity',
				'class' => 'form-control'
			];

			if ($this->config->item('identity', 'ion_auth') != 'email')
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page('customer' . DIRECTORY_SEPARATOR . 'forgot_password', $this->data);
		}
		else
		{
			$identity_column = $this->config->item('identity', 'ion_auth');
			
			$identity = $this->ion_customer_auth->where($identity_column, $this->input->post('identity'))->customers()->row();
			
			if (empty($identity))
			{
				if ($this->config->item('identity', 'ion_auth') != 'email')
				{
					$this->ion_customer_auth->set_error('forgot_password_identity_not_found');
				}
				else
				{
					$this->ion_customer_auth->set_error('forgot_password_email_not_found');
				}
	
				$this->session->set_flashdata('message', $this->ion_customer_auth->errors());
				redirect("customer/forgot_password", 'refresh');
			}


			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_customer_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_customer_auth->messages());
				redirect("customer/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_customer_auth->errors());
				redirect("customer/forgot_password", 'refresh');
			}
		}
	}

	/**
	 * Reset password - final step for forgotten password
	 *
	 * @param string|null $code The reset code
	 */
	public function reset_password($code = NULL)
	{
		if (!$code)
		{ 
			show_404();
		}

		$this->data['title'] = $this->lang->line('reset_password_heading');
		
		$user = $this->ion_customer_auth->forgotten_password_check($code);

		if ($user)
		{

			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() === FALSE)
			{
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = [
					'name' => 'new',
					'id' => 'new',
					'type' => 'password',
					'class'=> 'form-control',
					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
				];
				$this->data['new_password_confirm'] = [
					'name' => 'new_confirm',
					'id' => 'new_confirm',
					'type' => 'password',
					'class'=> 'form-control',
					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
				];
				$this->data['user_id'] = [
					'name' => 'user_id',
					'id' => 'user_id',
					'type' => 'hidden',
					'value' => $user->id,
				];
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				// render
				$this->_render_page('customer' . DIRECTORY_SEPARATOR . 'reset_password', $this->data);
			}
			else
			{
				$identity = $user->{$this->config->item('identity', 'ion_auth')};

				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					// something fishy might be up
					$this->ion_customer_auth->clear_forgotten_password_code($identity);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$change = $this->ion_customer_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						$this->userlogs->track_this($user->id, "Updated Password on ". date('Y-m-d H:i:s', time()));
						// send password reset email 
						$this->load->model('email_templates_m','EM');
						$template=$this->EM->get_email_template("password_reset_confirmation");
						
						$login_link="<a href='".site_url('customer/login/')."'>".site_url('customer/login/')."</a>";
		            	$parse_data=array('FIRST_NAME'=>$user->first_name,
		            					  'USERNAME'=>$user->email,
		                              	  'NEW_PASSWORD'=>$this->input->post('new'),
		                              	  'LOGIN_LINK'=>$login_link,
		                                  'EMAIL' => $user->email                             
		                            	);
			            
			            // send email to customer
			            $this->load->model('Email_model');
			            $email_status=$this->Email_model->send_email($template,$parse_data);

						if($email_status){
							//$this->set_message('forgot_password_successful');
							// if the password was successfully changed
							$this->session->set_flashdata('message', 'Password Successfully Reset.');
							redirect("customer/login", 'refresh');
						}
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('customer/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("customer/forgot_password", 'refresh');
		}
	}

	/**
	 * Activate the user
	 *
	 * @param int         $id   The user ID
	 * @param string|bool $code The activation code
	 */
	public function activateBBBBBBB($id, $code = FALSE)
	{
		$activation = FALSE;

		if ($code !== FALSE)
		{
			$activation = $this->ion_customer_auth->activate($id, $code);
		}
		else if ($this->ion_customer_auth->is_admin())
		{
			$activation = $this->ion_customer_auth->activate($id);
		}

		if ($activation)
		{
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("customer", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("customer/forgot_password", 'refresh');
		}
	}

	/**
	 * Deactivate the user
	 *
	 * @param int|string|null $id The user ID
	 */
	public function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			show_error('You must be an administrator to view this page.');
		}

		$id = (int)$id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() === FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	/**
	 * Create a new user
	 */
	public function email_unique(){
		$remail = $this->input->post('email');
		$alpha_email = $this->toAlphaNumeric(trim($this->input->post('email')));
		$this->form_validation->set_message('email_unique', 'This email is already in use. Please use a different email.');
		return $this->customers_m->get_regemail_check_available($remail,$alpha_email);
	}
	
	public function send_sms($number,$body){	
			//echo $number.'---------------'.$body;exit;		
			//$remail = $this->input->post('email');
			$id = TWILLO_ID;
			$token = TWILLO_TOKEN;
			//$url = "https://api.twilio.com/2010-04-01/Accounts/$id/SMS/Messages";
			//$url = "https://api.twilio.com/2010-04-01/Accounts/$id/Messages.json";
			$url = TWILLO_URL.$id."/Messages.json";
			$from =TWILLO_PHONE_FROM;
			$to = "+".$number; // twilio trial verified number


			// Convert HTML paragraphs and line breaks to plain text equivalent
			$sms_plain_text = strip_tags($body); // Remove all HTML tags

			// Optionally, convert HTML <p> and <br> tags into newlines
			$sms_plain_text = preg_replace('/<p[^>]*?>/', '', $sms_plain_text);  // Remove opening <p> tag
			$sms_plain_text = preg_replace('/<\/p>/', "\n\n", $sms_plain_text);  // Replace closing </p> with two newlines
			$sms_plain_text = preg_replace('/<br[^>]*?>/', "\n", $sms_plain_text);  // Replace <br> with one newline
		

			$data = array (
				'From' => $from,
				'To' => $to,
				'Body' => $sms_plain_text,
			);
			$post = http_build_query($data);
			$x = curl_init($url );
			curl_setopt($x, CURLOPT_POST, true);
			curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($x, CURLOPT_USERPWD, "$id:$token");
			curl_setopt($x, CURLOPT_POSTFIELDS, $post);
			$y = curl_exec($x);
			curl_close($x);
	}

	public function verify_twilio_credentials() {
	    $id = TWILLO_ID;
	    $token = TWILLO_TOKEN;
	    //$url = "https://api.twilio.com/2010-04-01/Accounts/$id.json";
	    $url = TWILLO_URL.$id."/Messages.json";

	    //echo '<b>TWILLO_ID:</b> '.$id.'<br>';
	    //echo '<b>TWILLO_TOKEN:</b> '.$token.'<br>';
	    //echo '<b>TWILLO_URL:</b> '.$url.'<br><br>';	    
	    
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    curl_setopt($ch, CURLOPT_USERPWD, "$id:$token");
	    
	    $response = curl_exec($ch);
	    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    
	    curl_close($ch);
	    
	    if ($http_status == 200) {
	        echo "Twilio credentials are valid.";
	        return true;
	    } else {
	        echo "Failed to verify Twilio credentials. HTTP Status: " . $http_status;
	        return false;
	    }
	}

	public function send_email($subject, $body, $from, $fromname, $to, $toname){			
			//$url = "https://api.sendgrid.com/api/mail.send.json";
			/*
			$url = SENDGRID_URL;
			$sendgrid_apikey = SENDGRID_APIKEY;	
			
			
			$js = array(
			  'sub' => array(':name' => array('Elmer')),
			  'filters' => array('templates' => array('settings' => array('enable' => 1, 'template_id' => '')))
			);
			
			$params = array(
				'to'        => $to,
				'toname'    => $toname,
				'from'      => $from,
				'fromname'  => $fromname,
				'subject'   => $subject,
				//'text'      => $body
				'html'      => $body
				//'x-smtpapi' => json_encode($js),
			  );

			$session = curl_init($url);
			// Tell PHP not to use SSLv3 (instead opting for TLS)
			curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
			curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
			// Tell curl to use HTTP POST
			curl_setopt ($session, CURLOPT_POST, true);
			// Tell curl that this is the body of the POST
			curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
			// Tell curl not to return headers, but do return the response
			curl_setopt($session, CURLOPT_HEADER, false);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
			
			// obtain response
			$response = curl_exec($session);
			curl_close($session);
			
			*/
		$this->load->library('email');		
		/*$config = array();
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp.sendgrid.net';
		$config['smtp_user'] = 'apikey';
		$config['smtp_pass'] = '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';
		$config['smtp_port'] = 587;*/
		
		$config['protocol'] = $this->config->item('protocol');
		$config['smtp_host'] = $this->config->item('smtp_host');     //'smtp.com';
		$config['smtp_user'] = $this->config->item('smtp_user'); //'admin@tradexstock.com.au';
		$config['smtp_pass'] = $this->config->item('smtp_pass'); // '911trade';
		$config['smtp_port'] = $this->config->item('smtp_port');
		$this->email->initialize($config);
	
		
		$this->email->from($from, $fromname);
		$this->email->to($to);
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');						
		$this->email->subject($subject);
		$this->email->message($body);

		$this->email->send();
	}
	
	public function checkphoneXXXX($num){
        //your first charcter in voter_phone
        $first_ch = substr($num,0,1);       
		if ($first_ch==0){
           //set your error message here         
       		$mobile = substr($this->input->post('mobile'), 1);
			$this->form_validation->set_message('checkphone', 'This mobile number is already in use. Please use a different mobile number.');
			return $this->customers_m->get_mobile_check_available($mobile);
           // return TRUE;
		}else{
			$mobile = $this->input->post('mobile');
			$this->form_validation->set_message('checkphone', 'This mobile number is already in use. Please use a different mobile number.');
			return $this->customers_m->get_mobile_check_available($mobile);
		}
    }

    public function checkphone($num)
	{
	    // Check if the number is empty
	    if (empty($num)) {
	        $this->form_validation->set_message('checkphone', 'Mobile number is required.');
	        return FALSE;
	    }

	    // Remove any non-digit characters
	    $num = preg_replace('/[^0-9]/', '', $num);

	    // Check if the number starts with 0
	    $first_ch = substr($num, 0, 1);

	    if ($first_ch == '0') {
	        $mobile = substr($num, 1);
	    } else {
	        $mobile = $num;
	    }

	    // Check if the mobile number is already in use
	    if (!$this->customers_m->get_mobile_check_available($mobile)) {
	        $this->form_validation->set_message('checkphone', 'This mobile number is already in use. Please use a different mobile number.');
	        return FALSE;
	    }

	    return TRUE;
	}
	
	public function toAlphaNumeric($input) {
		if (is_null($input)) {
			return "";
		} else {
			$input = preg_replace('/\s/', '' , $input);
			
           $input = preg_replace("/[^a-zA-Z0-9]/", "", $input);
			return $input;
		}
	}
	
	public function register(){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_unique');
		$this->form_validation->set_rules('c_code', 'Country Code', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric|callback_checkphone');
		//$this->form_validation->set_rules('passwordv', 'Password', 'trim|required|min_length[8]|max_length[18]');
		$this->form_validation->set_rules('toc', 'I Accept the Terms', 'trim|required');
		
		//$this->send_email();
		
		$this->data['message'] = '';
		if(isset($_REQUEST['kt_sign_up_submit'])){
			$first_ch = substr(trim($this->input->post('mobile')),0,1);
			if ($first_ch==0){
				$mobile = substr(trim($this->input->post('mobile')), 1);
			}else{
				$mobile = trim($this->input->post('mobile'));
			}
			if ($this->form_validation->run() == FALSE){
				  $this->data['message'] = 'error';
				  $this->data['name'] = $this->input->post('name');
				  $this->data['email'] = $this->input->post('email');
				  $this->data['c_code'] = $this->input->post('c_code');
				  $this->data['mobile'] = $mobile;
				 // $this->data['passwordv'] = $this->input->post('passwordv');
				  $this->data['toc'] = $this->input->post('toc');
				  
				 $this->data['_view'] = CUSTOMER_THEME . 'registration/index';
				 $this->load->view( CUSTOMER_THEME . 'registration/_layout_before',$this->data);
			} else {
				$gcode = $this->getVcode();
				$c_code = $this->input->post('c_code');
				//$mobile = $mobile;
				$user_email = $this->input->post('email');
				$user_alpha_email = $this->toAlphaNumeric(trim($this->input->post('email')));
				$get_duplicate_user = $this->customers_m->get_userid_by_email($user_email, $user_alpha_email);	
				$this->customers_m->delete($get_duplicate_user[0]['id']);
				//print_r($get_duplicate_user);exit;
				$password= $this->generatePassword();
					$data =array(
						'first_name' => $this->input->post('name'),					
						'email' => $user_email,
						'alpha_email' => $user_alpha_email,
						'c_mobile' => $mobile,
						'mobile' => $mobile,
						'c_code' => $this->input->post('c_code'),
						'password' => base64_encode($password),
						"alpha_password"=>base64_encode($password),
						'v_code' => $gcode					
					);
					
					//print_r($data);exit;
					$this->db->insert('customers', $data);
					$insert_id=$this->db->insert_id();
					if($insert_id > 0){	
						$this->load->model('RegistrationOTP_m');
						$where_otp = array('id' => '1');
       					$registration_otp_info =  $this->RegistrationOTP_m->selectdatarow($where_otp, 'registration_otp');
	   					//print_r($registration_otp_info);exit;
							if($registration_otp_info[0]['status'] == '0'){
								$this->customers_m->update_status($insert_id);
								$username = $this->generateUsername($insert_id);
								$to = $this->input->post('email');
								//print_r($username);exit;
								$this->customers_m->update_username($username, $insert_id);	
								$number = $c_code.$mobile;


								//===================SMS Template Start=======================//
								//$body = "Username : ".$to." Password : ".$password;
								$this->load->model('sms_templates_m');
								$info_sms=$this->sms_templates_m->get(2,TRUE);
								$sms_body = $info_sms->body;
								$replacing_string = array("[FIRST_NAME]" => $this->input->post('name'),
															"[LOGIN_LINK]" => '<a href="'.site_url('customer/login/').'">Login Link</a>',
																"[USERNAME]" => $to,
																"[PASSWORD]" => $password);
								$bodyHTML =	strtr($info_email->body, $replacing_string);
								$this->send_sms($number,$bodyHTML);
								//===================SMS Template End=======================//
									
								
								//===================Email Template Start=======================//
								$this->load->model('email_templates_m');
								$info_email=$this->email_templates_m->get(6,TRUE);
								
								$mail_body = $info_email->body;
								$replacing_string = array("[FIRST_NAME]" => $this->input->post('name'),
															"[LOGIN_LINK]" => '<a href="'.site_url('customer/login/').'">Login Link</a>',
																"[USERNAME]" => $to,
																"[PASSWORD]" => $password);
								
								$toname = $this->input->post('name');
								$subject = $info_email->subject;
								$from = $info_email->sender_email;
								$fromname = $info_email->sender_name;
																	
								$bodyHTML =	strtr($info_email->body, $replacing_string);
								$this->send_email($subject, $bodyHTML, $from, $fromname, $to, $toname);
								//===================Email Template End=======================//
								
								//===================Json Start=======================//
								//if($plan_keycode != ''){
									$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($this->input->post('email')))));
									if(!is_dir($json_directory)){
										mkdir($json_directory, 0777, true);
									}					
									
									$filename = $password . '.json';
										
									$localFilePath = $json_directory.'/'.$filename;
									$final_json_output = $this->publishJsonGenerater(strtolower($this->input->post('email')), $password);
									
									$fpt_r = fopen($localFilePath, 'w');
									fwrite($fpt_r, $final_json_output);
									fclose($fpt_r);										 	
										
								//}	
								//===================Json End=======================//	
								 $this->data['_view'] = CUSTOMER_THEME . 'registration/registration_after';
							}
							else{
								$username = $this->generateUsername($insert_id);
								$to = $this->input->post('email');
								$this->customers_m->update_username($username, $insert_id);	
								$number = $c_code.$mobile;
								
								//===================SMS Template Start=======================//
								//$body = "Verification OTP : ".$gcode;
								$this->load->model('sms_templates_m');
								$info_sms=$this->sms_templates_m->get(3,TRUE);
								$sms_body = $info_sms->body;
								$replacing_string = array("[FIRST_NAME]" => $this->input->post('name'),
															"[VerificationOTP]" => $gcode);
								$bodyHTML =	strtr($info_sms->body, $replacing_string);
								$this->send_sms($number,$bodyHTML);	
								//===================SMS Template End=======================//
								
								//===================Email Template Start=======================//
								$this->load->model('email_templates_m');
								$info_email=$this->email_templates_m->get(8,TRUE);
								$mail_body = $info_email->body;
								$replacing_string = array("[FIRST_NAME]" => $this->input->post('name'),
															"[VerificationOTP]" => $gcode);
								$toname = $this->input->post('name');
								$subject = $info_email->subject;
								$from = $info_email->sender_email;
								$fromname = $info_email->sender_name;
																	
								$bodyHTML =	strtr($info_email->body, $replacing_string);
								$this->send_email($subject, $bodyHTML, $from, $fromname, $to, $toname);
								//===================Email Template End=======================//

								$this->data['user_id'] = $insert_id;					
								$this->data['count_down'] = 'authcountdown';
								$this->data['_extra_scripts'] = CUSTOMER_THEME . 'registration/_extra_scripts';
								$this->data['_view'] = CUSTOMER_THEME . 'registration/verification';
							}
						
					}
					
					$this->load->view( CUSTOMER_THEME . 'registration/_layout_before',$this->data);
			}
		} else{
			$this->data['name'] = '';
			$this->data['email'] = '';
			$this->data['c_code'] = '';
			$this->data['mobile'] = '';
			//$this->data['passwordv'] = '';
			$this->data['toc'] = '';
			//$this->data['_extra_scripts'] = CUSTOMER_THEME . 'registration/_extra_scripts';
			//$this->data['_view'] = CUSTOMER_THEME . 'registration/registration_after';
			$this->data['_view'] = CUSTOMER_THEME . 'registration/index';
			$this->load->view( CUSTOMER_THEME . 'registration/_layout_before',$this->data);			
			
		}
				
		
	}

	public function migrate(){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		// Capture the initial data from $_REQUEST, or use post data if available
		$encoded_data = $_REQUEST['data'];
		$this->data['encoded_data'] = $encoded_data;
		$decoded_data = base64_decode($encoded_data);
		parse_str($decoded_data, $data_array);

		$account_id = isset($data_array['accountID']) ? $data_array['accountID'] : '';
		$days_left = isset($data_array['uDaysLeft']) ? $data_array['uDaysLeft'] : 0;
		$package = isset($data_array['package']) ? $data_array['package'] : 0;

		// Check if the account already exists
		$existing_account = $this->customers_m->get_customer_by_account_id($account_id);

		if ($existing_account) {
			// Account already exists, redirect to login page with a message
			$this->session->set_flashdata('message_set', 'This box has already been migrated. Please scan a different one.');
		}

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('c_code', 'Country Code', 'trim|required');		
		//$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_unique');
		//$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric|callback_checkphone');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric');
		/*echo '<pre>';
		echo 'Data: '.$encoded_data.'<br>';
		echo 'AccountID: '.$account_id.'<br>';
		echo 'DaysLeft: '.$days_left.'<br>';
		echo 'Package: '.$package.'<br>';

		$product_id = 0;
		$plan_id = 0;
		$plan_info = $this->customers_m->getPlanInfo($package);
		print_r($plan_info);
		if ($plan_info) {
			$product_id = $plan_info->product_id;
			$plan_id = $plan_info->id;
		}
		echo $product_id .'<br>'.$plan_id;
		exit();
		*/
		
		$this->data['message'] = '';

		if(isset($_REQUEST['kt_sign_up_submit'])){
			$first_ch = substr(trim($this->input->post('mobile')),0,1);
			if ($first_ch==0){
				$mobile = substr(trim($this->input->post('mobile')), 1);
			}else{
				$mobile = trim($this->input->post('mobile'));
			}
			if ($this->form_validation->run() == FALSE){
				//echo 'wellcoem';exit();
				$this->data['message'] = 'error';
				$this->data['name'] = $this->input->post('name');
				$this->data['email'] = $this->input->post('email');
				$this->data['c_code'] = $this->input->post('c_code');
				$this->data['mobile'] = $mobile;
				//$this->data['encoded_data'] = $this->input->post('encoded_data');
				//$this->data['passwordv'] = $this->input->post('passwordv');
				//$this->data['toc'] = $this->input->post('toc');

				$this->data['_view'] = CUSTOMER_THEME . 'registration/migrate_index';
				$this->load->view( CUSTOMER_THEME . 'registration/_layout_before',$this->data);
			} 
			else {

				$now_time = date("Y-m-d H:i:s");
				$subscription_expire = date('Y-m-d H:i:s', strtotime("+{$days_left} days", strtotime($now_time)));


				// Check if the account already exists
				$existing_account = $this->customers_m->get_customer_by_account_id($account_id);

				if ($existing_account) {
					$this->session->set_flashdata('message_set', 'This box has already been migrated. Please scan a different one.');
					redirect('customer/migrate?data='.$encoded_data, 'refresh');
				}
				

				$product_id = 18;
				$plan_id = 36;
				$plan_info = $this->customers_m->getPlanInfo($package);
				if ($plan_info) {
					$product_id = $plan_info->product_id;
					$plan_id = $plan_info->id;
				}

				$gcode = $this->getVcode();
				$c_code = $this->input->post('c_code');
				$user_email = $this->input->post('email');
				$user_alpha_email = $this->toAlphaNumeric(trim($this->input->post('email')));
				$get_duplicate_user = $this->customers_m->get_userid_by_email($user_email, $user_alpha_email);	
				$this->customers_m->delete($get_duplicate_user[0]['id']);
				$password= $this->generatePassword();
				$data =array(
						'first_name' => $this->input->post('name'),
						'email' => $user_email,
						'alpha_email' => $user_alpha_email,
						'c_mobile' => $mobile,
						'mobile' => $mobile,
						'c_code' => $this->input->post('c_code'),
						'password' => base64_encode($password),
						"alpha_password"=>base64_encode($password),
						'v_code' => $gcode,
						'is_migrate' => 2,
						'account_id' => $account_id,
						'days_left' => $days_left,
						'package' => $package,
						'devices_allowed' => 1,				
						'product_id' => $product_id,
						'plan_id' => $plan_id,
						"product_activation_key_id"=>$product_id,
						"sebscription_trpe" => 'aproduct',
						'subscription_expire'=>$subscription_expire,
						'encoded_data'=>$encoded_data
					);
				$this->db->insert('customers', $data);
				$insert_id=$this->db->insert_id();
				
				if($insert_id > 0){	
					
            		//==============================Email Start====================================//
            		$verification_link = base_url("customer/verify_email/{$insert_id}/{$gcode}");    

					$this->load->model('email_templates_m');
					$info_email=$this->email_templates_m->get(2,TRUE);								
					$mail_body = $info_email->body;
					$replacing_string = array("[FIRST_NAME]" => $this->input->post('name'),
					"[CONFIRM]" => $verification_link);		

					$to = $this->input->post('email');
					$toname = $this->input->post('name');
					$subject = $info_email->subject;
					$from = $info_email->sender_email;
					$fromname = $info_email->sender_name;
													
					$bodyHTML =	strtr($info_email->body, $replacing_string);
					$this->send_email($subject, $bodyHTML, $from, $fromname, $to, $toname);
					//================================Email End===================================//
					$this->data['email'] = $this->input->post('email');
					$this->data['_view'] = CUSTOMER_THEME . 'registration/verify_email_sent';
				}
					
				$this->load->view( CUSTOMER_THEME . 'registration/_layout_before',$this->data);
			}
		} 
		else{
			$this->data['name'] = '';
			$this->data['email'] = '';
			$this->data['c_code'] = '';
			$this->data['mobile'] = '';
			$this->data['_extra_scripts'] = CUSTOMER_THEME . 'registration/_extra_scripts';
			$this->data['_view'] = CUSTOMER_THEME . 'registration/migrate_index';
			$this->load->view( CUSTOMER_THEME . 'registration/_layout_before',$this->data);				
		}
	}

	public function verify_email($user_id, $token) {

	    $this->load->model('customers_m');
	    $user = $this->customers_m->get($user_id);
	   

	    if ($user && $user->v_code === $token) {

	        
	        $this->load->model('RegistrationOTP_m');
			$where_otp = array('id' => '1');

			// Update user status
			$this->customers_m->update_status($user_id);
			
			$username = $this->generateUsername($user_id);
			$this->customers_m->update_username($username, $user_id);
	      
	        $data = array(
	        	'is_migrate' => 1,
	        	'v_code' => ''
				);				 
			$this->customers_m->update_customer($user_id,$data);

			//define('APP_DOWNLOAD_LINK', 'https://realtv.co/download');
			define('ServiceID','22');
			define('SUPPORT_INFO', 'info@realtv.co or +61283116939');
			define('COMPANY_NAME','Real Tv');
			define('COMPANY_URL','www.realtv.co');

			//=====================================SMS Start========================================//
			$this->load->model('sms_templates_m');
			$info_sms=$this->sms_templates_m->get(1,TRUE);
			$replacing_string = array("[ServiceID]" => '22',
			"[USERNAME]" => $user->email,
			"[PASSWORD]" => base64_decode($user->password),
			"[SUPPORT_INFO]"=> SUPPORT_INFO,
			"[COMPANY_NAME]"=> COMPANY_NAME,
			"[COMPANY_URL]"=> COMPANY_URL);
			$bodyHTML =	strtr($info_sms->body, $replacing_string);
			$number = $user->c_code.$user->mobile;
			$this->send_sms($number,$bodyHTML);	
			//=====================================SMS End========================================//

			//=====================================Email Start========================================//
			$this->load->model('email_templates_m');
			$info_email=$this->email_templates_m->get(10,TRUE);								
			$mail_body = $info_email->body;
			$replacing_string = array("[FIRST_NAME]" => $this->input->post('name'),
			"[LOGIN_LINK]" => '<a href="'.site_url('customer/login/').'">Login Link</a>',
			"[USERNAME]" => $user->email,
			"[PASSWORD]" => base64_decode($user->password),
			"[SUPPORT_INFO]"=> SUPPORT_INFO,
			"[COMPANY_NAME]"=> COMPANY_NAME);								

			$to = $user->email;
			$toname = $user->first_name.' '.$user->last_name;
			$subject = $info_email->subject;
			$from = $info_email->sender_email;
			$fromname = $info_email->sender_name;
				
			$bodyHTML =	strtr($info_email->body, $replacing_string);
			$this->send_email($subject, $bodyHTML, $from, $fromname, $to, $toname);
			//=====================================Email End========================================//

			//=====================================Json Create Start========================================//
			$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($user->email))));
			if(!is_dir($json_directory)){

			mkdir($json_directory, 0777, true);
			}					

			$filename = base64_decode($user->password) . '.json';

			$localFilePath = $json_directory.'/'.$filename;
			$final_json_output = $this->publishJsonGenerater(strtolower($user->email), base64_decode($user->password));

			$fpt_r = fopen($localFilePath, 'w');
			fwrite($fpt_r, $final_json_output);
			fclose($fpt_r);										 	
			//=====================================Json Create End========================================//


			// After successful registration and JSON creation, attempt to make an API call
			$api_data = array(
			'customer_id' => $user_id,
			'account_id' => $user->account_id,
			'email' => $user->email,
			'subscription_expire' => $user->subscription_expire
			);

			$api_result = $this->call_migration_api($api_data);

			// Log the API result, but don't let it affect the registration process
			//log_message('info', 'Migration API call result for customer ID ' . $user_id . ': ' . json_encode($api_result));
			$this->data['message'] = 'Your email has been verified. You can now log in.';			

			$this->data['_view'] = CUSTOMER_THEME . 'registration/registration_after';
			$this->load->view( CUSTOMER_THEME . 'registration/_layout_before',$this->data);
	    } 
	    else {
	    
			$this->data['message'] = 'Invalid verification link.';			
			$this->data['_view'] = CUSTOMER_THEME . 'registration/login';
			$this->load->view( CUSTOMER_THEME . 'registration/_layout_before',$this->data);
	    }
	}

	private function call_migration_api($data) {
	    $url = 'https://migrate.cdnnext.com';

	    // Check if the URL is valid
	    if (!filter_var($url, FILTER_VALIDATE_URL)) {
	        return array('success' => false, 'message' => 'Invalid API URL');
	    }

	    // Initialize cURL
	    $ch = curl_init($url);

	    // Set cURL options
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set a timeout of 10 seconds

	    // Execute the cURL request
	    $response = curl_exec($ch);

	    // Check for errors
	    if (curl_errno($ch)) {
	        $error_msg = curl_error($ch);
	        curl_close($ch);
	        return array('success' => false, 'message' => 'cURL error: ' . $error_msg);
	    }

	    // Get the HTTP status code
	    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    curl_close($ch);

	    // Process the API response
	    if ($http_code == 200) {
	        // Successful API call
	        return array('success' => true, 'message' => 'API call successful', 'data' => $response);
	    } else {
	        // API call failed
	        return array('success' => false, 'message' => 'API call failed with HTTP code: ' . $http_code);
	    }
	}
	
	public function terms(){
		$where = array('id' => '2');
        $page_info =  $this->customers_m->selectdatarow($where, 'pages');
		//print_r($page_info);
		$this->data['page_info'] = $page_info;		
		$this->data['_view'] = CUSTOMER_THEME . 'registration/terms';
		$this->load->view( CUSTOMER_THEME . 'registration/_layout_before',$this->data);	
	}
	
	public function dashboard(){
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'registration/_extra_scripts';
		//$this->data['sidebar'] = CUSTOMER_THEME . 'dashboard_new/includes/sidebar';
		if($this->expiredplans()){
			$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/index';
		}
		$this->load->view( CUSTOMER_THEME . 'dashboard_new/_layout_after',$this->data);	
	}
	
	public function verification(){
			$user_id = $_REQUEST['user_id'];
			$vcode = $_REQUEST['vcode'];
			$customers_details = $this->customers_m->get_userdetsils_byid($user_id);
			/*echo '<pre>';
			print_r($customers_details);exit;*/
			$opt_time = $customers_details['vcodelife'];
			$now_time = date("Y-m-d H:i:s");
			//echo $now_time.'------------'.$opt_time;
			
			$diff_time=((strtotime($now_time)-strtotime($opt_time))/60);
			//echo $diff_time;
			if(OTP_VAL_TIME > $diff_time){
				if($customers_details['v_code'] == $vcode){
					$this->customers_m->update_status($user_id);
						$number = $customers_details['c_code'].$customers_details['c_mobile'];
						
				//=============================SMS Start============================//
				//$body = "User Name : ".$customers_details['email']." Password : ".base64_decode($customers_details['password']);

				$this->load->model('sms_templates_m');					
				$info_sms=$this->sms_templates_m->get(2,TRUE);						
				$sms_body = $info_sms->body;
				$replacing_string = array("[FIRST_NAME]" => $customers_details['name'],
				"[LOGIN_LINK]" => '<a href="'.site_url('customer/login/').'">Login Link</a>',
				"[USERNAME]" => $customers_details['email'],
				"[PASSWORD]" => base64_decode($customers_details['password']));		
				$bodyHTML =	strtr($info_sms->body, $replacing_string);
				$this->send_sms($number,$bodyHTML);	
				//=============================SMS End============================//

				//=============================Email Start============================//
				$this->load->model('email_templates_m');					
				$info_email=$this->email_templates_m->get(6,TRUE);						
				$mail_body = $info_email->body;
				$replacing_string = array("[FIRST_NAME]" => $customers_details['name'],
				"[LOGIN_LINK]" => '<a href="'.site_url('customer/login/').'">Login Link</a>',
				"[USERNAME]" => $customers_details['email'],
				"[PASSWORD]" => base64_decode($customers_details['password']));						


				$toname = $customers_details['name'];
				$subject = $info_email->subject;
				$from = $info_email->sender_email;
				$fromname = $info_email->sender_name;


				$bodyHTML =	strtr($info_email->body, $replacing_string);
				$this->send_email($subject, $bodyHTML, $from, $fromname, $customers_details['email'], $toname);
				//=============================Email End============================//
						
				//====================================Json Create===========================//
				//if($plan_keycode != ''){
					$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($customers_details['email']))));
					if(!is_dir($json_directory)){
						/* Directory does not exist, so lets create it. */
						mkdir($json_directory, 0777, true);
					}					
					/*$filename = $password . '.json';*/
					$filename = base64_decode($customers_details['alpha_password']) . '.json';
						
					$localFilePath = $json_directory.'/'.$filename;
					$final_json_output = $this->publishJsonGenerater(strtolower($customers_details['email']), base64_decode($customers_details['password']));
					
					$fpt_r = fopen($localFilePath, 'w');
					fwrite($fpt_r, $final_json_output);
					fclose($fpt_r);	
				//}	
				//====================================Json End===========================//

				$this->session->set_flashdata('message_sussess',"yes");
				$this->session->set_flashdata('success',"Congratulations! Your account has been created. Please check your Email or Mobile for Login detail.");
				//===========================================================================================================================			
						
					echo 'success';
				} else{
					echo 'error';
				}
			}else{
				echo 'expire';
			}
	}
	
	public function resendcode(){
		$user_id = $_REQUEST['user_id'];
		$gcode = $this->getVcode();
		$customers_details = $this->customers_m->update_vcodelife($user_id, $gcode);
		if($customers_details){
			$customers_details = $this->customers_m->get_userdetsils_byid($user_id);
			//print_r($customers_details);
			$to = $customers_details['email'];
			//$password = $customers_details['password'];
			$number = $customers_details['c_code'].$customers_details['c_mobile'];
			
			//==============================SMS Start=================================//
			//$body = "Verification OTP : ".$gcode;

			$this->load->model('sms_templates_m');
			$info_sms=$this->sms_templates_m->get(3,TRUE);
			$sms_body = $info_sms->body;
			$replacing_string = array("[FIRST_NAME]" => $customers_details['first_name'],
			"[VerificationOTP]" => $gcode);
			$bodyHTML =	strtr($info_sms->body, $replacing_string);
			$this->send_sms($number,$bodyHTML);	
			//==============================SMS End=================================//
			
			//==============================Email Start=================================//
			$this->load->model('email_templates_m');
			$info_email=$this->email_templates_m->get(8,TRUE);
			$mail_body = $info_email->body;
			$replacing_string = array("[FIRST_NAME]" => $customers_details['first_name'],
			"[VerificationOTP]" => $gcode);

			$toname = $customers_details['first_name'].' '.$customers_details['last_name'];
			$subject = $info_email->subject;
			$from = $info_email->sender_email;
			$fromname = $info_email->sender_name;

			$bodyHTML =	strtr($info_email->body, $replacing_string);
			$this->send_email($subject, $bodyHTML, $from, $fromname, $to, $toname);
			//==============================Email End=================================//
						
						
			echo 'success';
		}else{
			echo 'error';
		}		
	}
	
	public function customerlogin(){ 
		if(isset($_REQUEST['kt_sign_in_submit'])){
				$email = $this->input->post('email');
				$password = base64_encode(trim($this->input->post('password')));
				$data = $this->customers_m->get_customer_details('email',$email);
				
				if($data['password'] == $password){
				
				} else{
					$this->data['email'] = $email;
					$this->data['password'] = $this->input->post('password');
					$this->data['_view'] = CUSTOMER_THEME . 'registration/login';
					$this->load->view( CUSTOMER_THEME . 'registration/_layout_before',$this->data);
				}
		} else {
			$this->data['email'] = '';
			$this->data['password'] = '';
			//$this->data['_view'] = CUSTOMER_THEME . 'registration/login';
			
			if($this->session->flashdata('message_sussess')){ 
				$this->data['_view'] = CUSTOMER_THEME . 'registration/registration_after';
			}else{
				$this->data['_view'] = CUSTOMER_THEME . 'registration/login';
			}
			$this->load->view( CUSTOMER_THEME . 'registration/_layout_before',$this->data);
		}
	}
	
	public function customerforgetpass(){
		$email = $this->input->get('email');
		$this->data['email'] = $email ? $email : '';
		$this->data['count_down'] = '';
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'registration/_extra_scripts';
		$this->data['_view'] = CUSTOMER_THEME . 'registration/forgetpassword';
		$this->load->view( CUSTOMER_THEME . 'registration/_layout_before',$this->data);
	}

	public function customerforgetpass_send()
	{
	    $reset_method = $this->input->post('reset_method');
	    $email = $this->input->post('email');
	    $mobile = $this->input->post('mobile');
	    $c_code = $this->input->post('c_code');

	    // Input validation
	    if ($reset_method === 'email') {
	        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
	            echo json_encode([
	                'success' => false,
	                'message' => 'Invalid email format. Please provide a valid email address.',
	            ]);
	            return;
	        }
	        $customer = $this->customers_m->get_customer_details('email', $email);
	    } else if ($reset_method === 'sms') {
	        if (empty($mobile) || empty($c_code)) {
	            echo json_encode([
	                'success' => false,
	                'message' => 'Please provide both country code and mobile number.',
	            ]);
	            return;
	        }
	        $full_mobile = $c_code . $mobile;
	        $customer = $this->customers_m->get_customer_details('mobile', $mobile);
	    } else {
	        echo json_encode([
	            'success' => false,
	            'message' => 'Invalid reset method.',
	        ]);
	        return;
	    }

	    if ($customer) {
	        $id = $customer['id'];
	        $to = $customer['email'];

	        $deviceType = ($reset_method === 'email') ? '_WebTV' : '_AndroidTV';
	        $deviceModel = ($reset_method === 'email') ? 'WebTV' : 'sdk_google_atv64_arm64';


	        $url = BASE_URL . 'api/device?' .
	            'sendtype=' . urlencode($reset_method) .
	            '&crmService=xtv_crm' .
	            '&cmsService=xtv_cms' .
	            '&deviceType=' . urlencode($deviceType) .
	            '&deviceModel=' . urlencode($deviceModel) .
	            '&macaddress=' .
	            '&userid=' . urlencode($customer['email']) .
	            '&email=' . urlencode($customer['email']);

	        // Use curl for the request
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

	        $response = curl_exec($ch);
	        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	        $curl_error = curl_error($ch);

	        curl_close($ch);

	        // Check for curl errors or HTTP errors
	        if ($response === false || $http_code !== 200) {
	            echo json_encode([
	                'success' => false,
	                'message' => 'Failed to send reset instructions. Please try again later.',
	                'error' => $curl_error ?: 'HTTP Code: ' . $http_code,
	            ]);
	        } else {
	            echo json_encode([
	                'success' => true,
	                'message' => 'Reset instructions sent successfully.',
	                'method' => $reset_method,
	            ]);
	        }
	    } else {
	        echo json_encode([
	            'success' => false,
	            'message' => $reset_method === 'email' ? 'Email not found in our records.' : 'Mobile number not found in our records.',
	        ]);
	    }
	}

	public function forgetpassword_success(){
	    $email = $this->input->get('email');
	    $method = $this->input->get('method');
	    $reset_method = $this->input->post('reset_method');
	    
	    $data = array(
	        'sent_to_email' => ($method == 'email'),
	        'sent_to_sms' => ($method == 'sms')
	    );

		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'registration/_extra_scripts';
		$this->data['_view'] = CUSTOMER_THEME . 'registration/forgetpassword_success';
		$this->load->view( CUSTOMER_THEME . 'registration/_layout_before',$this->data);


	}

	public function customerforgetpass_send_v1(){
	    $email = trim($this->input->post('email'));
	    $reset_method = $this->input->post('reset_method');

	    // Input validation
	    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
	        echo json_encode([
	            'success' => false,
	            'message' => 'Invalid email format. Please provide a valid email address.',
	        ]);
	        return;
	    }

	    // Retrieve customer details
	    $customers_details = $this->customers_m->get_customer_details('email', $email);

	    if ($customers_details) {
	        $id = $customers_details['id'];
	        $to = $customers_details['email'];
	 
	        $deviceType = ($reset_method === 'email') ? '_WebTV' : '_AndroidTV';
	        $deviceModel = ($reset_method === 'email') ? 'WebTV' : 'sdk_google_atv64_arm64';

	        $url = BASE_URL . 'api/device?' .
	            'sendtype=' . urlencode($reset_method) .
	            '&crmService=xtv_crm' .
	            '&cmsService=xtv_cms' .
	            '&deviceType=' . urlencode($deviceType) .
	            '&deviceModel=' . urlencode($deviceModel) .
	            '&macaddress=' .
	            '&userid=' . urlencode($to) .
	            '&email=' . urlencode($to);

	        // Use curl for the request
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

	        $response = curl_exec($ch);
	        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	        $curl_error = curl_error($ch);

	        curl_close($ch);

	        // Check for curl errors or HTTP errors
	        if ($response === false || $http_code !== 200) {
	            echo json_encode([
	                'success' => false,
	                'message' => 'Failed to send reset instructions. Please try again later.',
	                'error' => $curl_error ?: 'HTTP Code: ' . $http_code,
	                'url' => $url,
	            ]);
	        } else {
	            echo json_encode([
	                'success' => true,
	                'message' => 'Reset instructions sent successfully.',
	                'mailsendto' => $reset_method,
	                'response' => $response,
	                'url' => $url,
	            ]);
	        }
	    } else {
	        echo json_encode([
	            'success' => false,
	            'message' => 'Email not found in our records.',
	            'mailsendto' => $reset_method,
	        ]);
	    }
	}
	public function customerforgetpass_send_old(){
		$email = trim($_REQUEST['email']);
		$reset_method = $this->input->post('reset_method');
		//echo $send_by_sms.'--------------'.$send_by_email;
		$customers_details = $this->customers_m->get_customer_details('email',$email);
		/*echo '<pre>';
		print_r($customers_details);*/
		if(count($customers_details) > 0){
			$id = $customers_details['id'];
			$to = $customers_details['email'];
			$token = base64_encode($to).'snehasistu=-1=aKeMMyp08HyTv=2-'.base64_encode($id);
						
			//Email Send
			//============================================================================================================================
			$mailsendto = '';
			if($reset_method == 'email'){
				/*$this->load->model('email_templates_m');					
				$info_email=$this->email_templates_m->get(9,TRUE);						
				$mail_body = $info_email->body;
				$replacing_string = array("[FIRST_NAME]" => $customers_details['first_name'],
											"[PASSWORD]" => base64_decode($customers_details['password'])
										  );						
					
				
				$toname = $customers_details['first_name'];
				$subject = $info_email->subject;
				$from = $info_email->sender_email;
				$fromname = $info_email->sender_name;
				
							
				$bodyHTML =	strtr($info_email->body, $replacing_string);
				
				$this->send_email($subject, $bodyHTML, $from, $fromname, $customers_details['email'], $toname);*/
				
				$url_email = 	BASE_URL.'api/getUserLogin?'.
								'sendtype=email'.
								'&crmService=gomiddlewareTV3'.
								'&cmsService=gomiddleware2'.
								'&deviceType=_WebTV'.
								'&deviceModel=Chrome'.
								'&macaddress=0011223344'.
								'&userid='.$customers_details['username'].
								'&email='.$customers_details['email'].
								'&password='.base64_decode($customers_details['password']).
								'&messageType=forgetPassword';	
				//echo $url_sms;
				file_get_contents($url_email);
				
				$mailsendto .= 'email';
			}
			// SMS Send
			//================================================================================================================================
			if($reset_method == 'sms'){
				//$number = $customers_details['c_code'].$customers_details['mobile'];
				//$body = "Your Password : ".base64_decode($customers_details['password']);
				//$body = "Verification OTP : ".$gcode;
				//$this->send_sms($number,$body);
				$url_sms = 	BASE_URL.'api/getUserLogin?'.
								'sendtype=sms'.
								'&crmService=gomiddlewareTV3'.
								'&cmsService=gomiddleware2'.
								'&deviceType=_WebTV'.
								'&deviceModel=Chrome'.
								'&macaddress=0011223344'.
								'&userid='.$customers_details['username'].
								'&email='.$customers_details['email'].
								'&password='.base64_decode($customers_details['password']).
								'&messageType=forgetPassword';	
				//echo $url_sms;
				file_get_contents($url_sms);
				$mailsendto .= 'sms';
			}		
			//===============================================================================================================================
			echo $mailsendto.'<br>'.$url_email;
			//echo json_encode(['success' => true, 'message' => 'Reset instructions sent successfully.','mailsendto'=>$reset_method,'response'=>$response,'url'=>$url]);
						
			//echo 'success';
		} else {
			echo 'nodata';
			//echo json_encode(['success' => false, 'message' => 'Email not found in our records.','mailsendto'=>$reset_method,'response'=>$response,'url'=>$url]);
		}
		//print_r($data);
	}
	
	public function resetpassword(){ 
		$tval = $_REQUEST['tokenvalue'];
		if($tval == ''){
			redirect("customer/customerlogin", 'refresh');
		}else {
		$token_array = explode('snehasistu=-1=aKeMMyp08HyTv=2-' ,$tval);		
		$customers_details = $this->customers_m->get_customer_details('email',base64_decode($token_array[0]));
		/*echo '<pre>';
		print_r($customers_details);exit;*/
		//update_password
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|callback_pass_conpass');
		$this->form_validation->set_rules('cnewpassword', 'Confirm New Password', 'trim|required');
		$this->data['message'] = '';
		if(isset($_REQUEST['kt_conformpass_submit'])){
			if ($this->form_validation->run() == FALSE){
				  $this->data['message'] = 'error';
				  $this->data['newpassword'] = $this->input->post('newpassword');
				  $this->data['cnewpassword'] = $this->input->post('cnewpassword');
			}else{
				$newpassword = $this->input->post('newpassword');
				$this->data['newpassword'] = $newpassword;
				$this->data['cnewpassword'] = $this->input->post('cnewpassword');
				if($this->customers_m->update_password(base64_encode(trim($newpassword)),base64_decode($token_array[0]), base64_decode($token_array[1]))){
					//Email Send
						//============================================================================================================================
						$this->load->model('email_templates_m');					
						$info_email=$this->email_templates_m->get(6,TRUE);						
						$mail_body = $info_email->body;
						$replacing_string = array("[FIRST_NAME]" => $customers_details['first_name'],
													"[LOGIN_LINK]" => '<a href="'.site_url('customer/login/').'">Login Link</a>',
														"[USERNAME]" => $customers_details['email'],
														"[PASSWORD]" => $newpassword);						
							
						
						$toname = $customers_details['first_name'];
						$subject = $info_email->subject;
						$from = $info_email->sender_email;
						$fromname = $info_email->sender_name;
						
									
						$bodyHTML =	strtr($info_email->body, $replacing_string);
						//echo $bodyHTML;exit;
						$this->send_email($subject, $bodyHTML, $from, $fromname, $customers_details['email'], $toname);
						
						//===============================================================================================================================
						
					$this->session->set_flashdata('message_flash', 'Password reset. Please Login');
					redirect("customer/customerlogin", 'refresh');
				}
			}
		}else{
		
			$this->data['newpassword'] = '';
			$this->data['cnewpassword'] = '';
		}
		$this->data['token'] = $tval;
		$this->data['count_down'] = '';
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'registration/_extra_scripts';
		$this->data['_view'] = CUSTOMER_THEME . 'registration/conformpass';
		$this->load->view( CUSTOMER_THEME . 'registration/_layout_before',$this->data);
		}
	}
	
	public function register_old(){
	
		if ($this->ion_customer_auth->logged_in())
		{
			// redirect them to the dashboard
			redirect('customer', 'refresh');
		}

		$this->data['title'] = $this->lang->line('create_user_heading');

		// if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		// {
		// 	redirect('customer', 'refresh');
		// }

		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');
		$this->form_validation->set_rules('activation_key', 'Activation Key', 'trim|required|callback_check_activation_key');
		if ($identity_column !== 'email')
		{
			$this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['customers'] . '.' . $identity_column . ']');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
		}
		else
		{
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['customers'] . '.email]');
			$this->form_validation->set_rules('re_email', 'Confirm Email', 'trim|required|valid_email|matches[email]');
		}
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
		$this->form_validation->set_rules('address', $this->lang->line('create_user_validation_company_label'), 'trim');
		
		if ($this->form_validation->run() === TRUE)
		{
			$email = strtolower($this->input->post('email'));
			$identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
			if ($this->ion_customer_auth->identity_check($identity))
			{
				$this->ion_customer_auth->set_error('account_creation_duplicate_identity');
				$this->session->set_flashdata('message', $this->ion_customer_auth->errors());
				redirect("customer/register", 'refresh');
			}else{
				$this->load->model('activation_keys_m');
				$key_info=$this->activation_keys_m->getKeyInfo($this->input->post('activation_key'));
				$data =array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => $email,
					'phone' => $this->input->post('phone'),
					'billing_country' => $this->input->post('billing_country'),
					'billing_state' => $this->input->post('billing_state'),
					'billing_city' => $this->input->post('billing_city'),
					'billing_street' => $this->input->post('address'),
					//'billing_zip' => $this->input->post('zip'),
					'product_id' => $key_info->product_id,
					'product_activation_key_id' => $key_info->id,
					'devices_allowed' =>$key_info->devices_allowed
				);
				$this->db->insert('customers', $data);
				$insert_id=$this->db->insert_id();
				$name= base64_encode($this->input->post('first_name').' '.$this->input->post('last_name').'-'.$email);
				
				// send activation email 
				$this->load->model('email_templates_m','EM');
	            
	            //generate random activation code 
				$gcode = $this->generateCode();

	            $code= base64_encode($insert_id."-".$gcode);
	            
	            $data=array('activation_code'=>$gcode);
	            $this->db->where('id', $insert_id);
	            $this->db->update('customers', $data);

	            $confirm = "<a href=".site_url('customer/activate/'.$code).">".site_url('customer/activate/'.$code)."</a>";

	            $template=$this->EM->get_email_template("customer_activation_email");
	            $parse_data=array('FIRST_NAME'=>$this->input->post('first_name'),
	                              'CONFIRM'=>$confirm,
	                              'EMAIL' => $this->input->post('email')                             
	                            );
 
	            // send email to customer
	            $this->load->model('Email_model');
	            $this->Email_model->send_email($template,$parse_data);
 				
 				// update activation keys table with user id 
 				$data=array('user_id'=>$insert_id); 
 				$this->db->where('id',$key_info->id);
 				$this->db->update('activation_keys', $data);
 				
 				$this->userlogs->track_this($insert_id, "Registered in IMS on ". date('Y-m-d H:i:s',time())." Activation Required.");
 				
				$this->session->set_flashdata('message', $this->ion_customer_auth->messages());
				redirect("customer/activationRequired/".$name, 'refresh');
			}
		}
		else
		{	
			/* Countries */
	        $this->load->model('dynamic_dependent_m');
	        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();
			// display the create user form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['first_name'] = [
				'name' => 'first_name',
				'id' => 'first_name',
				'type' => 'text',
				'class' => 'form-control',
				'placeholder' => 'First Name',
				'required' => 'required',
				'value' => $this->form_validation->set_value('first_name'),
			];
			$this->data['last_name'] = [
				'name' => 'last_name',
				'id' => 'last_name',
				'type' => 'text',
				'class' => 'form-control',
				'placeholder' => 'Last Name',
				'required' => 'required',
				'value' => $this->form_validation->set_value('last_name'),
			];
			$this->data['identity'] = [
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('identity'),
			];
			$this->data['email'] = [
				'name' => 'email',
				'id' => 'email',
				'type' => 'email',
				'class' => 'form-control',
				'placeholder' => 'Email',
				'required' => 'required',
				'value' => $this->form_validation->set_value('email'),
			];
			$this->data['re_email'] = [
				'name' => 're_email',
				'id' => 're_email',
				'type' => 'email',
				'class' => 'form-control',
				'placeholder' => 'Confirm Email',
				'required' => 'required',
				'value' => $this->form_validation->set_value('re_email'),
			];
			$this->data['activation_key'] = [
				'name' => 'activation_key',
				'id' => 'activation_key',
				'type' => 'text',
				'class' => 'form-control',
				'placeholder' => 'Activation Key',
				'required' => 'required',
				'value' => $this->form_validation->set_value('activation_key'),
			];
			$this->data['phone'] = [
				'name' => 'phone',
				'id' => 'phone',
				'type' => 'text',
				'class' => 'form-control',
				'placeholder' => 'Phone',
				'required' => 'required',
				'value' => $this->form_validation->set_value('phone'),
			];
			$this->data['city'] = [
				'name' => 'billing_city',
				'id' => 'billing_city',
				'type' => 'text',
				'class' => 'form-control',
				'placeholder' => 'City',
				'value' => $this->form_validation->set_value('billing_city'),
			];

			$this->data['address'] = [
				'name' => 'address',
				'id' => 'address',
				'type' => 'text',
				'class' => 'form-control',
				'placeholder' => 'Address',
				'value' => $this->form_validation->set_value('address'),
			];
			
			//$this->_render_page('customer' . DIRECTORY_SEPARATOR . 'register', $this->data);
			$this->data['_extra_scripts'] = CUSTOMER_THEME . '_extra_scripts';
			$this->load->view( CUSTOMER_THEME . 'register',$this->data);
			
		}
	}

	public function activationRequired($data){
		$this->data['title'] = "Activation Required";
		$data = explode("-",base64_decode($data));
		$this->data['customer'] = $data[0];
		$this->data['email'] = $data[1];
		$this->_render_page('customer' . DIRECTORY_SEPARATOR . 'activation_required', $this->data);
	}
	
	public function activate($code){
		$extracted_code=base64_decode($code);
		$code_array= explode("-",$extracted_code);
		
		$user_id=$code_array[0];
		$code=$code_array[1];
		
		$customer_info=$this->customers_m->get_by(array('id'=>$user_id,'activation_code'=>$code), TRUE);
		if($customer_info){
			if($customer_info->status==0){  // if not activated earlier
				//generate username and password
	            $username= $this->generateUsername($user_id);
	            $password= $this->generatePassword();
	            $data=array('status'=>1,
	            			'pin'=>$username,
	                        'username'=>$username,
	                        'password'=>base64_encode($password)
	                        );

	            $this->customers_m->save($user_id,$data);
	            
				$this->load->model('activation_keys_m');
				$key_info=$this->activation_keys_m->get_by(array('id'=>$customer_info->product_activation_key_id), TRUE);
				
				// update the key , activation key 
 				if($key_info->length_months==12)
 					$expired_date=date('Y-m-d H:i:s',strtotime("+1 year"));
 				else
 					$expired_date=date('Y-m-d H:i:s',(time()+($key_info->length_months*30*24*60*60)));
 				
 				$data=array('used'=>1,
 							'date_used'=>date('Y-m-d H:i:s',time()),
 							'date_expired'=>$expired_date
 					); 
 				$this->db->where('id',$key_info->id);
 				$this->db->update('activation_keys', $data);

 				//update customers table
 				$data=array('subscription_expire'=>$expired_date); 
 				$this->customers_m->save($user_id,$data);
 				
 				$this->userlogs->track_this($user_id, "Account Activated on ". date('Y-m-d H:i:s',time()));

				// Send User ID And Password to new Customer.. 
				$this->load->model('email_templates_m','EM');
		        $login_link="<a href='".site_url('customer/login')."'>LOGIN.</a>";
		        $template=$this->EM->get_email_template("welcome_email");
		        $parse_data=array('FIRST_NAME'=>$customer_info->first_name,
		                          'LOGIN_LINK'=>$login_link,
		                          'EMAIL'=>$customer_info->email,
		                          'PASSWORD'=>$password	                                                    
		                        );

		        // send email to customer
		        $this->load->model('Email_model');
		        $this->Email_model->send_email($template,$parse_data);
		        $name= base64_encode($customer_info->first_name.' '.$customer_info->last_name);
				
				$this->session->set_flashdata('message', 'Your account is activated');
				redirect('customer/activationSuccess/'.$name, 'refresh');
			}else{
				$name= base64_encode($customer_info->first_name.' '.$customer_info->last_name);
				
				$this->session->set_flashdata('message', 'Your account is already activated');
				redirect('customer/activationSuccess/'.$name, 'refresh');
			}
		}
	}

	public function activationSuccess($data){
		$this->data['title'] = "Activation success";
		$this->data['customer'] = base64_decode($data);
		$this->_render_page('customer' . DIRECTORY_SEPARATOR . 'activation_success', $this->data);
	}

	// Renuew a Customar by subscription by Renewal Keys 
	public function renuebysubsscription(){
		$plan_keycode = $_REQUEST['plan_keycode'];
		$where_keycode = array('keycode'=>$plan_keycode);	
		//$this->load->model('customerpanel_m');	
	   	$keycode_details = $this->customers_m->selectdatarow($where_keycode,'subscription_renewal_keys');
		/*echo '<pre>';
		print_r($keycode_details);*/
		$user_id = $this->session->user_id;
		$info = $this->customers_m->getCustomerInfo($user_id);
		/*echo '<pre>';
		print_r($info);exit;*/
		if(count($keycode_details) > 0){
			if($keycode_details[0]['used'] == '0'){
				if(($keycode_details[0]['key_type'] == 'master') || ($keycode_details[0]['key_type'] == 'subscribe')){
							
						if($keycode_details[0]['reseller_id'] == '0'){
							$sebscription_trpe = 'subscript';	 
						}elseif($keycode_details[0]['reseller_id'] > '0'){
							$sebscription_trpe = 'rcode';	
						}
						
						if($keycode_details[0]['key_type'] == 'master'){
							$wallet_money = $info->walletbalance + $keycode_details[0]['activation_price'];
						}else{
							$wallet_money = $info->walletbalance;
						}
						/*echo $user_id;
						echo '<pre>';
						print_r($keycode_details);	*/
						$now_time = date("Y-m-d H:i:s");
						if(count($keycode_details)>0){
							$valid_time = "+".$keycode_details[0]['length_months'].' '.$keycode_details[0]['month_day'];
							$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
						}
						$data_customer = array(	"reseller_id"=>$keycode_details[0]['reseller_id'],
										"activation_code"=>$plan_keycode,
										"sebscription_trpe"=> $sebscription_trpe,
										'subscription_expire'=>$subscription_expire, 
										'product_activation_key_id' => $keycode_details[0]['id'], 
										'product_id' => $keycode_details[0]['product_id'],
										'devices_allowed' => $keycode_details[0]['devices_allowed'],
										'walletbalance' => $wallet_money
									);	
						//print_r($data);
						$where_customer = array('id'=>$user_id);
						$user_update = $this->customers_m->update_keycode($data_customer,$where_customer,'customers');
						if($user_update){
							$subscription_keys_data = array('user_id'=>$user_id,'used'=>'1');
							$subscription_keys_where = array('keycode'=>$plan_keycode);
							$this->customers_m->update_keycode($subscription_keys_data,$subscription_keys_where,'subscription_renewal_keys');
							echo 'success';
						}
						//update user 
					
				}else{
					echo 'invalidcode';
				}
			}else{
				echo 'usedcode';
			}
		}else{
				echo 'invalidcode';
		}
			
	}
	/**
	* Redirect a user checking if is admin
	*/
	public function redirectUser(){
		if ($this->ion_auth->is_admin()){
			redirect('auth', 'refresh');
		}
		redirect('/', 'refresh');
	}

	/**
	 * Edit a user
	 *
	 * @param int|string $id
	 */
	public function edit_user($id)
	{
		$this->data['title'] = $this->lang->line('edit_user_heading');

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();
			
		//USAGE NOTE - you can do more complicated queries like this
		//$groups = $this->ion_auth->where(['field' => 'value'])->groups()->result_array();
	

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = [
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'company' => $this->input->post('company'),
					'phone' => $this->input->post('phone'),
				];

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}

				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					// Update the groups user belongs to
					$this->ion_auth->remove_from_group('', $id);
					
					$groupData = $this->input->post('groups');
					if (isset($groupData) && !empty($groupData))
					{
						foreach ($groupData as $grp)
						{
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}

				// check to see if we are updating the user
				if ($this->ion_auth->update($user->id, $data))
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					$this->redirectUser();

				}
				else
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					$this->redirectUser();

				}

			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = [
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		];
		$this->data['last_name'] = [
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		];
		$this->data['company'] = [
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		];
		$this->data['phone'] = [
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		];
		$this->data['password'] = [
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password'
		];
		$this->data['password_confirm'] = [
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password'
		];

		$this->_render_page('auth/edit_user', $this->data);
	}

	/**
	 * Create a new group
	 */
	public function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required|alpha_dash');

		if ($this->form_validation->run() === TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if ($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		}
		else
		{
			// display the create group form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = [
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			];
			$this->data['description'] = [
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			];

			$this->_render_page('auth/create_group', $this->data);
		}
	}

	/**
	 * Edit a group
	 *
	 * @param int|string $id
	 */
	public function edit_group($id)
	{
		// bail if no group id given
		if (!$id || empty($id))
		{
			redirect('auth', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'trim|required|alpha_dash');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], array(
					'description' => $_POST['group_description']
				));

				if ($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth", 'refresh');
			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['group'] = $group;

		$this->data['group_name'] = [
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
		];
		if ($this->config->item('admin_group', 'ion_auth') === $group->name) {
			$this->data['group_name']['readonly'] = 'readonly';
		}
		
		$this->data['group_description'] = [
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		];

		$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'edit_group', $this->data);
	}

	/**
	 * @return array A CSRF key-value pair
	 */
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return [$key => $value];
	}

	/**
	 * @return bool Whether the posted CSRF token matches
	 */
	public function _valid_csrf_nonce(){
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
			return FALSE;
	}

	/**
	 * @param string     $view
	 * @param array|null $data
	 * @param bool       $returnhtml
	 *
	 * @return mixed
	 */
	public function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
	{

		$viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		if ($returnhtml)
		{
			return $view_html;
		}
	}

	public function generateCode(){
        $length=12;
        $randomcode = substr(str_shuffle("0123456789abcdefgh"), 0, $length);
        return $randomcode;
    }

	public function getVcode(){
        $length=6;
        $randomcode = substr(str_shuffle("0123456789"), 0, $length);
        return $randomcode;
    }
	
    public function generateUsername($inserted_id){
    	$this->load->model('settings_m');
        $prefix_code=$this->settings_m->getValue('userid-prefix');
        $userid=$prefix_code.$inserted_id;
        return $userid;
    }

    public function generatePassword(){
    	$this->load->model('settings_m');
        $length=$this->settings_m->getValue('password-length');
        $password = substr(str_shuffle("0123456789"), 0, $length);
        return $password;
    }

    public function password_check($password){
    	$user_id=$this->input->post('user_id');
    	
    	if(!$this->customers_m->check_user_password($password,$user_id)){
    		 
    		$this->form_validation->set_message('password_check', 'The Old {field} doesn\'t match. Please try again');
            return FALSE;
    	}else
    		return TRUE;
    }

    public function email_check_other_than($email){
        $result=$this->customers_m->check_other_emails($email,$this->input->post('user_id'));
        foreach ($result as $eml) {
            if($eml->email==$email){
                $this->form_validation->set_message('email_check_other_than', 'The {field} is already exist.');
                return FALSE;
            } 
        }
        return TRUE;
    }

    public function check_activation_key($key){
    	$this->load->model('activation_keys_m');
    	$this->load->model('products_m');
    	$this->load->model('dynamic_dependent_m');
        $key_info=$this->activation_keys_m->getKeyInfo($key);
            
        if(!$key_info){
            $this->form_validation->set_message('check_activation_key', 'The {field} doesn\'t exist.');
            return FALSE;
        }elseif($key_info->used==1){
        	$this->form_validation->set_message('check_activation_key', 'The {field} has already been used.');
            return FALSE;
        }elseif($key_info->active==0){
        	$this->form_validation->set_message('check_activation_key', 'The {field} hasnot been active.');
            return FALSE;
        }elseif($key_info->disabled==1){
        	$this->form_validation->set_message('check_activation_key', 'The {field} has been disabled.');
            return FALSE;
        }elseif($key_info->blocked==1){
        	$this->form_validation->set_message('check_activation_key', 'The {field} has been blocked.');
            return FALSE;
        }else{
        	// check if geo location is enabled
        	// if enabled 
        	// check which countries are in the list 
        	// check the ip of the customer 
        	// check the customer country if it is in the list 
        	// if yes return true 
        	// if not return false with message 
        	if($key_info->enable_geo_location==1){
        		// check which countries are in the list : get the countries list
        		$countries=$this->products_m->get_countries_by_product($key_info->product_id);
        	    $country_names=array();
        	    foreach ($countries as $id) {
        	    	$country_names[]=$this->dynamic_dependent_m->get_country_name_by_id($id);
        	    }
        	    // get the ip of the customer
        		$ip = $this->getVisIPAddr();
        		if($ip=="::1"){
        			$ip = '1.159.255.255'; 
        		}
        		  
				// Use JSON encoded string and converts 
				// it into a PHP variable 
				$ipdat = @json_decode(file_get_contents( 
				    "http://www.geoplugin.net/json.gp?ip=" . $ip));
				/*echo 'Country Name: ' . $ipdat->geoplugin_countryName . "\n"; 
        	    exit;*/
				if(in_array($ipdat->geoplugin_countryName, $country_names)){
					return TRUE;
				} 
				else{
					$this->form_validation->set_message('check_activation_key', 'Product not available for your region.');
            		return FALSE;
				}
				
        	}

            return TRUE;
        }

    }
    //OLD One
	/*public function publishJsonGenerater($uname, $pass){
		$this->load->model('customers_m');
		$username = $uname;
		$password = $pass;
		$accountStatus =  array('0' => 'Disabled', '1' => 'Active');
		$user = $this->customers_m->checkusercustomer($username, $password);
		$product = $this->customers_m->get_product($user->id);
		$location = $this->customers_m->get_product_location($product->id);
		$channel_packages = $this->customers_m->get_channel_packages($user->id);
		$movie_stores = $this->customers_m->get_movie_stores($user->id);
		$series_stores = $this->customers_m->get_series_stores($user->id);
		$music_categories = $this->customers_m->get_music_categories($user->id);
		$msg = $this->customers_m->get_message_customers($user->id);
		$return_array = array(
			'account' => array(
				'date_expired' => date('d M Y', strtotime($user->subscription_expire)),
				'datetime_expired' => date('m/d/Y H:i:s A', strtotime($user->subscription_expire)),
				'resellerid' => '0',
				'account_status' => $accountStatus[$user->status],
				'staging' => false
			),

			'customer' => array(
				'walletbalance' => $user->walletbalance,
				'currency' => $user->currency
			),
			'products' => array(
				"productid" => $product->id,
				"productname" => $product->name
			),
			'payperview' => array(
				"movies" => $movie_stores,
				"seasons" => [],
				"albums" => $movie_stores,
				"channels" => []
			),
			'storage' => array(
				"total" => 0,
				"used" => 0,
				"total_hours" => 0
			),

			'profiles' => [array(
				"id" => $user->id,
				"name" => $user->first_name . " " . $user->last_name,
				"recommendations" => "[]",
				"mode" => "regular",
				"avatar" => ""
			)],
			'messages' => $msg,
			'recordings' => []
		);
		$final_json_output = json_encode(json_encode($return_array, JSON_UNESCAPED_SLASHES));
		return $final_json_output;
	}*/

	//New One
	public function publishJsonGenerater($uname, $pass){

		//$uname = 'qmandal26@gmail.com';
		//$pass = 'ase345nhg';
		$this->load->model('customers_m');
		$username = $uname;
		$password = $pass;
		$accountStatus =  array('0' => 'Disabled', '1' => 'Active');
		$user = $this->customers_m->checkusercustomer($username, $password);
		// get product details
		$product = $this->customers_m->get_product($user->id);
		// get plan details
		$plan=$this->customers_m->get_plan($user->id);
		if($plan->devices_allowed != null)
        {
        	$devices_allowed = $plan->devices_allowed;
        }else{
        	$devices_allowed = $user->devices_allowed;
        }
		// get productlocation
		$location = $this->customers_m->get_product_location($product->id);
		// get total extra channel packages
		$channel_packages = $this->customers_m->get_channel_packages($user->id);
		// get total extra Movie Stores
		$movie_stores = $this->customers_m->get_movie_stores($user->id);
		// get total extra Series Stores
		$series_stores = $this->customers_m->get_series_stores($user->id);
		// get music categories
		$music_categories = $this->customers_m->get_music_categories($user->id);
		//$msg = $this->customers_m->get_message_customers($user->id);
		$return_array = array(
			'account' => array(
				'date_expired' => date('d M Y', strtotime($user->subscription_expire)),
				'datetime_expired' => date('m/d/Y H:i:s A', strtotime($user->subscription_expire)),
				/*'resellerid' => $user->reseller_id,*/
				'resellerid' => '0',
				'account_status' => $accountStatus[$user->status],
				'max_concurrent_devices' =>$devices_allowed,
				'allow_inapp_theme_change' => $user->allow_theme ? true : false,
				'staging' => $user->allow_theme ? true : false,
				'isBeta' =>$user->is_beta ? true : false
			),

			'customer' => array(
				'walletbalance' => $user->walletbalance,
				'currency' => $user->currency
			),
			'products' => array(
				"productid" => $product->id,
				"productname" => $product->name
			),
			'payperview' => array(
				"movies" => $movie_stores,
				"seasons" => [],
				"albums" => $movie_stores,
				"channels" => []
			),
			'storage' => array(
				"total" => 0,
				"used" => 0,
				"total_hours" => 0
			),

			'profiles' => [array(
				"id" => $user->id,
				"name" => $user->first_name . " " . $user->last_name,
				"recommendations" => "[]",
				"mode" => "regular",
				"avatar" => ""
			)],
			'messages' => [],
			'recordings' => []
		);
		$final_json_output = json_encode(json_encode($return_array, JSON_UNESCAPED_SLASHES));
		//echo $final_json_output;
		return $final_json_output;
	}
	
    function getVisIpAddr() { 
	    if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
	        return $_SERVER['HTTP_CLIENT_IP']; 
	    } 
	    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
	        return $_SERVER['HTTP_X_FORWARDED_FOR']; 
	    } 
	    else { 
	        return $_SERVER['REMOTE_ADDR']; 
	    } 
	} 


	public function currentActivePlan($id){
		$this->load->model('reseller_m');

       // check_allow('create',$this->data['is_allow']);
        $this->load->model('products_m');
        $this->load->model('dynamic_dependent_m');
		$this->load->model('customers_m');
       // $rules = $this->customers_m->add_rules;
       
	   	$where = array('id'=>$id);

	   	$customers_details = $this->reseller_m->selectCustomerInfo($id);
	   
	   	$whereInfo = array('customer_id'=>$id);	
	   	$customersInfo = $this->reseller_m->selectRechargePlan($id);


		$this->data['title'] = $customers_details[0]['title'];
		$this->data['first_name'] = $customers_details[0]['first_name'];
		$this->data['last_name'] = $customers_details[0]['last_name'];
		$this->data['c_code'] = $customers_details[0]['c_code'];
		$this->data['mobile'] = $customers_details[0]['mobile'];
		$this->data['email'] = $customers_details[0]['email'];
		$this->data['billing_country'] = $customers_details[0]['billing_country'];
		$this->data['currency'] = $customers_details[0]['currency'];
		$this->data['billing_state'] = $customers_details[0]['billing_state'];
		$this->data['billing_city'] = $customers_details[0]['billing_city'];
		$this->data['billing_street'] = $customers_details[0]['billing_street'];
		$this->data['billing_zip'] = $customers_details[0]['billing_zip'];
		$this->data['status'] = $customers_details[0]['status'];
		$this->data['password'] = base64_decode($customers_details[0]['password']);
		$this->data['keys'] = $customers_details[0]['activation_code'];
		$this->data['expire'] = $customers_details[0]['subscription_expire'];
		$this->data['productName'] = $customers_details[0]['productName'];
		$this->data['ActivePlanName'] = $customers_details[0]['planName'];
		$this->data['vcodelife'] = $customers_details[0]['vcodelife'];
		$this->data['is_upgrade'] = $customers_details[0]['is_upgrade'];
 
		

		//get last key



		$this->data['customid'] = $id;      
        /* Countries */
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();
        /* States */
        $this->data['billing_states']=$this->dynamic_dependent_m->get_states($customers_details[0]['billing_country']);
        /* Cities */
        $this->data['billing_cities']=$this->dynamic_dependent_m->get_cities($customers_details[0]['billing_state']);

        /* products */
        $this->data['products']=$this->products_m->get();


		
		

		


		$this->data['info'] = $customersInfo;

		$this->data['active_tab'] = 'usersubscription';
		$this->data['active_menu'] = 'currentActivePlan';
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'dashboard_new/_extra_scripts';
		$this->data['_view'] = CUSTOMER_THEME . 'dashboard_new/current_active_plan';
		$this->load->view( CUSTOMER_THEME . 'dashboard_new/_layout_after',$this->data);	
		 
		
    }
/* Login as a customer via a tokenized link - methods Code starts here 18 dec 2024*/
	public function auto_login()
	{
		$token = $this->input->get('token');

		// Validate token
		$query = $this->db->get_where('customer_login_tokens', ['token' => $token]);
		if ($query->num_rows() === 1) {
			$token_data = $query->row();
			// Check if token is expired
			if ($token_data->expires_at < time()) {
				echo 'This link has expired.';
				return;
			}

			// Check if a session already exists
			if ($this->session->userdata('user_id')) {
				echo '<script>
					if (confirm("A session is already active. Do you want to log out and log in as this customer?")) {
						window.location.href = "' . base_url("customer/force_auto_login?token=$token") . '";
					}
				</script>';
				return;
			}

			// Log in the customer
			$this->_login_customer($token_data->customer_id);
		} else {
			echo 'Invalid login link.';
		}
	}

	public function force_auto_login()
	{
		$token = $this->input->get('token');

		$query = $this->db->get_where('customer_login_tokens', ['token' => $token]);

		if ($query->num_rows() === 1) {
			$token_data = $query->row();
			$this->_login_customer($token_data->customer_id);
		} else {
			echo 'Invalid login link.';
		}
	}

	private function _login_customer($customer_id)
	{
		// Fetch customer data
		$this->load->model('customers_m');
		$customer = $this->customers_m->getCustomerInfo($customer_id);
		// print_r($customer);exit;
		if ($customer) {
			// Set customer session
			$customer_session = [
				'user_id'    => $customer->id,
				'first_name' => $customer->first_name,
				'last_name'  => $customer->last_name,
				'role'       => 'customers',
				'identity'      => $customer->email,
				'logged_in'  => true // Mark the user as logged in
			];
			// print_r($customer_session);exit;
			$this->session->set_userdata($customer_session);

			redirect('customer/profile');
		} else {
			$this->session->set_flashdata('error', 'Customer not found.');
			redirect('/customers');
		}
	}
	/* Login as a customer via a tokenized link - methods Code end here 18 dec 2024*/
    
}
