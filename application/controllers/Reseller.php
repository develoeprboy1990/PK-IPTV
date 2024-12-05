<?php defined('BASEPATH') OR exit('No direct script access allowed');
//For Admin Panel

class Reseller extends MY_Controller{
	public $data = [];
	public function __construct(){
		parent::__construct();
		$this->data['is_allow']= check_permission(65);
			
		$this->load->model('dynamic_dependent_m');
		$this->load->model('reseller_m');
		//$this->load->model('customers_m');
		
		$this->load->helper(array('form', 'url'));
		
		$this->load->library('breadcrumbs');
		$this->load->library('page_title');
		
		$this->breadcrumbs->unshift(1, 'Reseller', 'reseller');
	}
	
	public function index(){
		$this->data['is_allow']= check_permission(66);
		check_allow('view',$this->data['is_allow']);
		
		$this->data['page_title'] = "Reseller";
		/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

		$this->data['main_nav'] = 'resellerweb';
		$this->data['sub_nav'] = 'reseller';
		$this->data['recellers'] = $this->reseller_m->getData();
		//print_r($allReceller);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'reseller/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'reseller/index';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function resellermoneycode(){
		$this->data['is_allow']= check_permission(77);
		$this->data['page_title'] = "Reseller Wallet Money";
		/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
		$wallet_cupons = $this->reseller_m->selectdatarow(array('active' => '1'), 'reseller_wallet_moneycode');
		$this->data['wallet_cupons'] = $wallet_cupons;
		if(isset($_REQUEST['walet_plans'])){ 
		 	for($i=1;$i<=$this->input->post('quantity');$i++){
                
                $length =$this->input->post('length')-strlen($this->input->post('prefix_code')); 
                $key = substr(str_shuffle("0123456789"), 0, $length);

                $final_key=$this->input->post('prefix_code').$key;
                $data = array(
							  'key_code '=>$final_key,
                              'price'=>$this->input->post('price'),
							   'currency_type'=>$this->input->post('currency_type')
                    );
                $this->reseller_m->insertRow($data, 'reseller_wallet_moneycode');
				//
            }
			redirect(BASE_URL.'reseller/resellermoneycode');
		}
		$this->data['main_nav'] = 'resellerweb';
		$this->data['sub_nav'] = 'walletmoneycode';
		
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'resellermoneycode/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'resellermoneycode/walletmoney';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function deleteresellermoneycode($id){
		$where = array('id' => $id);
		$data = array('active' => '0');
		$this->reseller_m->update_keycode($data,$where, 'reseller_wallet_moneycode');
		redirect(BASE_URL.'reseller/resellermoneycode');
	}
	
	public function create(){
		$this->data['main_nav'] = 'resellerweb';
		$this->data['sub_nav'] = 'reseller';
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric|callback_checkphone');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_unique');
		$this->form_validation->set_rules('billing_country', 'Country Code', 'trim|required');
		$this->form_validation->set_rules('billing_state', 'State', 'trim|required');
		$this->form_validation->set_rules('billing_city', 'City', 'trim|required');
		$this->form_validation->set_rules('billing_street', 'Street', 'trim|required');
		$this->form_validation->set_rules('billing_zip', 'ZIP', 'trim|required');
		$this->form_validation->set_rules('currency_type', 'Currency', 'trim|required');		
		
		$this->data['message'] = '';

		// Get selected country and state for persistence
    	$selected_country = $this->input->post('billing_country');
    	$selected_state = $this->input->post('billing_state');

		if(isset($_REQUEST['add_reseller'])){
			$name = $this->input->post('name');
			$mobile = $this->input->post('mobile');
			$email = $this->input->post('email');
			$billing_country = $this->input->post('billing_country');
			$billing_state = $this->input->post('billing_state');
			$billing_city = $this->input->post('billing_city');
			$billing_street = $this->input->post('billing_street');
			$billing_zip = $this->input->post('billing_zip');
			$status = $this->input->post('status');
			$currency_type = $this->input->post('currency_type');
			$customer_msgcontent = $this->input->post('customer_msgcontent');
			$reseller_msgedit = $this->input->post('reseller_msgedit');
			//$reseller_masterkey = $this->input->post('reseller_masterkey');
			$see_customer_password = $this->input->post('see_customer_password');
			
			$can_create_walletcode = $this->input->post('can_create_walletcode');
			$wallet_code_discount = $this->input->post('wallet_code_discount');
			$can_view_devices = $this->input->post('can_view_devices');
			$plan_type = $this->input->post('plan_type');
			
			if ($this->form_validation->run() == FALSE){
				$this->data['message'] = 'error';
				$this->data['name'] = $name;
				$this->data['mobile'] = $mobile;
				$this->data['email'] = $email;
				$this->data['billing_country'] = $billing_country;
				$this->data['billing_state'] = $billing_state;
				$this->data['billing_city'] = $billing_city;
				$this->data['billing_street'] = $billing_street;
				$this->data['billing_zip'] = $billing_zip;
				$this->data['status'] = $status;
				$this->data['currency_type'] = $currency_type;
				$this->data['customer_msgcontent'] = $customer_msgcontent;
				$this->data['reseller_msgedit'] = $reseller_msgedit;
				//$this->data['reseller_masterkey'] = $reseller_masterkey;
				$this->data['see_customer_password'] = $see_customer_password;
				
				$this->data['can_create_walletcode'] = $can_create_walletcode;
				$this->data['wallet_code_discount'] = $wallet_code_discount;
				$this->data['can_view_devices'] = $can_view_devices;

				
				$this->data['plan_type'] = $plan_type;

				// Get states for selected country
	            if ($selected_country) {
	                $states = $this->reseller_m->fetch_state($selected_country);
	                $this->data['states'] = $states;
	            }

	            // Set form data for repopulation
           		$this->data['selected_country'] = $selected_country;
            	$this->data['selected_state'] = $selected_state;

				
			} else {
				$random_number = base64_encode($this->random_number('10'));
				$data = array(
							'name' => $name,					
							'email' => $email,
							'country' => $billing_country,
							'state' => $billing_state,
							'city' => $billing_city,
							'postcode' => $billing_zip,
							'street' => $billing_street,
							'mobile' => $mobile,
							'password' => $random_number,
							'status' => $status,
							'wallet_money' => '0',
							'currency_type' => $currency_type,
							'customer_msgcontent' => $customer_msgcontent,
							'reseller_msgedit' => $reseller_msgedit,
							/*'reseller_masterkey' => $reseller_masterkey,*/
							'see_customer_password' => $see_customer_password,
							'can_create_walletcode' => $can_create_walletcode,
							'wallet_code_discount' => $wallet_code_discount,
							'can_view_devices' => $can_view_devices,
							'plan_type' => $plan_type
						);
				$insertid = $this->reseller_m->insert($data);
				//print_r($aaa);exit;
				/*$data_plan = array('reseller_id' => $insertid);	
				$this->reseller_m->insertkeys($data_plan,'reseller_details');*/
				redirect(BASE_URL.'reseller');
			}
			
		}

		// If no form submission, initialize with empty states
	    if (!isset($this->data['states'])) {
	        $this->data['states'] = array();
	    }

		/* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Reseller', 'reseller/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* Countries */
		
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();
		
		//$this->customers_m->save($insert_id,$data);
		$this->data['page_title'] = 'Create Reseller';
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'reseller/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'reseller/create';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function resellerplans(){

		$this->data['page_title'] = "Plans";
		/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

		$this->data['active_tab'] = 'renewal';
		
		$this->load->model('products_m');
		$product_details = $this->products_m->get();
		/*echo '<pre>';
		print_r($product_details);*/
		foreach($product_details as $val){
			$products_list['products_'.$val['id']] = $val['name'];
		}
		$this->data['products_list']= $products_list;
		$this->data['products']= $product_details;
		
		$this->data['reseller_renewal']= $this->reseller_m->getAllSubscription('reseller_panel_subscription', array('plan_type'=>'renewal' ));
		$this->data['renewal_keys'] = $this->load->view( DEFAULT_THEME . 'reseller/renewal_keys',$this->data, TRUE);
		
		$this->data['reseller_activation']= $this->reseller_m->getAllSubscription('reseller_panel_subscription', array('plan_type'=>'activation'));
		$this->data['activation_keys'] = $this->load->view( DEFAULT_THEME . 'reseller/activation_keys',$this->data, TRUE);
		
		$this->data['reseller_master']= $this->reseller_m->getAllSubscription('reseller_panel_subscription', array('plan_type'=>'master'));
		$this->data['master_keys'] = $this->load->view( DEFAULT_THEME . 'reseller/master_keys',$this->data, TRUE);

		$this->data['reseller_trial']= $this->reseller_m->getAllSubscription('reseller_panel_subscription', array('plan_type'=>'trial'));
    	$this->data['trial_keys'] = $this->load->view( DEFAULT_THEME . 'reseller/trial_keys',$this->data, TRUE);
    
		
		$this->data['main_nav'] = 'products';
		$this->data['sub_nav'] = 'resellerplans';
		 
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'reseller/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'reseller/resellers_plan';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function resellerRenewalPlans(){		
		$this->load->model('products_m');
		$product_details = $this->products_m->get();
		foreach($product_details as $val){
			$products_list['products_'.$val['id']] = $val['name'];
		}
		
		$this->data['reseller_m']= $this->reseller_m->getAllCode('reseller_panel_subscription');
		$this->load->helper(array('form', 'url'));
		
		 $this->data['message'] = '';
		if(isset($_REQUEST['resellers_plans'])){ 			
			$name = $this->input->post('sname');
			$product_id = $this->input->post('product_id');
			$devices_allowed = $this->input->post('devices_allowed');
			$price = $this->input->post('price');
			$length_months = $this->input->post('length_months');
			$month_day = $this->input->post('month_day');			
			$facility_content = $this->input->post('facility_content');			
			$currency_type = $this->input->post('currency_type');
			$status = $this->input->post('status');
			
			//echo $keysnumber;exit;
			$this->data['sname'] = $name;
			$this->data['product_id'] = $product_id;
			$this->data['devices_allowed'] = $devices_allowed;
			$this->data['price'] = $price;
			$this->data['length_months'] = $length_months;			
			$this->data['facility_content'] = $facility_content;			
			$this->data['currency_type'] = $currency_type;
			$this->data['status'] = $status;
				$data = array('name' => $name,
								'monthly_price' => $price,
								'product_id' => $product_id,
								'length_months' => $length_months,
								'plan_type' => 'renewal',
								'devices_allowed'	=> $devices_allowed,
								'active' => $status,
								'month_day' => $month_day,								
								'facility_content' => $facility_content,								
								'currency_type' => $currency_type
						);
						
				//print_r($data);
				$this->reseller_m->insertkeys($data,'reseller_panel_subscription');
			
			redirect(BASE_URL.'reseller/resellerplans');
			
		} else {
			$this->data['sname'] = '';
			$this->data['devices_allow'] = '';
			$this->data['product_id'] = '';
			$this->data['price'] = '';
			$this->data['length_months'] = '';				
			$this->data['facility_content'] = '';			
			$this->data['currency_type'] = '';
			$this->data['status'] = '';
		}
		
		$this->data['main_nav'] = 'resellerweb';
		$this->data['sub_nav'] = 'resellerplans';
		$this->data['products_list']= $products_list;
		$this->data['products']= $product_details;
		$this->data['_view'] = DEFAULT_THEME . 'reseller/resellers_plan';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}	
	public function resellerActivationPlans(){		
		$this->load->model('products_m');
		$product_details = $this->products_m->get();
		foreach($product_details as $val){
			$products_list['products_'.$val['id']] = $val['name'];
		}
		
		$this->data['reseller_m']= $this->reseller_m->getAllCode('reseller_panel_subscription');
		$this->load->helper(array('form', 'url'));
		
		 $this->data['message'] = '';
		if(isset($_REQUEST['resellers_plans'])){ 			
			$name = $this->input->post('sname');
			$product_id = $this->input->post('product_id');
			$devices_allowed = $this->input->post('devices_allowed');
			$price = $this->input->post('price');
			$length_months = $this->input->post('length_months');
			$month_day = $this->input->post('month_day');			
			$facility_content = $this->input->post('facility_content');			
			$currency_type = $this->input->post('currency_type');
			$status = $this->input->post('status');
			$activation_price = $this->input->post('activation_price');
			
			//echo $keysnumber;exit;
			$this->data['sname'] = $name;
			$this->data['product_id'] = $product_id;
			$this->data['devices_allowed'] = $devices_allowed;
			$this->data['price'] = $price;
			$this->data['length_months'] = $length_months;			
			$this->data['facility_content'] = $facility_content;			
			$this->data['currency_type'] = $currency_type;
			$this->data['status'] = $status;
			$this->data['activation_price'] = $activation_price;
			
				$data = array('name' => $name,
								'monthly_price' => $price,
								'product_id' => $product_id,
								'length_months' => $length_months,
								'plan_type' => 'activation',
								'devices_allowed'	=> $devices_allowed,
								'active' => $status,
								'month_day' => $month_day,								
								'facility_content' => $facility_content,								
								'currency_type' => $currency_type,
								'activation_price' => $activation_price
						);
						
				//print_r($data);
				$this->reseller_m->insertkeys($data,'reseller_panel_subscription');
			
			redirect(BASE_URL.'reseller/resellerplans/index/2');
			
		} else {
			/*$this->data['sname'] = '';
			$this->data['devices_allow'] = '';
			$this->data['product_id'] = '';
			$this->data['price'] = '';
			$this->data['length_months'] = '';				
			$this->data['facility_content'] = '';			
			$this->data['currency_type'] = '';
			$this->data['status'] = '';*/
		}
		
		/*$this->data['main_nav'] = 'resellerweb';
		$this->data['sub_nav'] = 'resellerplans';
		$this->data['products_list']= $products_list;
		$this->data['products']= $product_details;
		$this->data['_view'] = DEFAULT_THEME . 'reseller/resellers_plan';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);*/
	}	
	public function resellerMasterPlans(){		
		$this->load->model('products_m');
		$product_details = $this->products_m->get();
		foreach($product_details as $val){
			$products_list['products_'.$val['id']] = $val['name'];
		}
		
		$this->data['reseller_m']= $this->reseller_m->getAllCode('reseller_panel_subscription');
		$this->load->helper(array('form', 'url'));
		
		 $this->data['message'] = '';
		if(isset($_REQUEST['resellers_plans'])){ 			
			$name = $this->input->post('sname');
			$product_id = $this->input->post('product_id');
			$devices_allowed = $this->input->post('devices_allowed');
			$price = $this->input->post('price');
			$length_months = $this->input->post('length_months');
			$month_day = $this->input->post('month_day');			
			$facility_content = $this->input->post('facility_content');			
			$currency_type = $this->input->post('currency_type');
			$status = $this->input->post('status');
			$activation_price = $this->input->post('activation_price');
			
			//echo $keysnumber;exit;
			$this->data['sname'] = $name;
			$this->data['product_id'] = $product_id;
			$this->data['devices_allowed'] = $devices_allowed;
			$this->data['price'] = $price;
			$this->data['length_months'] = $length_months;			
			$this->data['facility_content'] = $facility_content;			
			$this->data['currency_type'] = $currency_type;
			$this->data['status'] = $status;
			$this->data['activation_price'] = $activation_price;
			
				$data = array('name' => $name,
								'monthly_price' => $price,
								'product_id' => $product_id,
								'length_months' => $length_months,
								'plan_type' => 'master',
								'devices_allowed'	=> $devices_allowed,
								'active' => $status,
								'month_day' => $month_day,								
								'facility_content' => $facility_content,								
								'currency_type' => $currency_type,
								'activation_price' => $activation_price
						);
						
				//print_r($data);
				$this->reseller_m->insertkeys($data,'reseller_panel_subscription');
			
			redirect(BASE_URL.'reseller/resellerplans/index/3');
			
		} else {
			/*$this->data['sname'] = '';
			$this->data['devices_allow'] = '';
			$this->data['product_id'] = '';
			$this->data['price'] = '';
			$this->data['length_months'] = '';				
			$this->data['facility_content'] = '';			
			$this->data['currency_type'] = '';
			$this->data['status'] = '';*/
		}
		
		/*$this->data['main_nav'] = 'resellerweb';
		$this->data['sub_nav'] = 'resellerplans';
		$this->data['products_list']= $products_list;
		$this->data['products']= $product_details;
		$this->data['_view'] = DEFAULT_THEME . 'reseller/resellers_plan';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);*/
	}
	public function resellerTrialPlans(){		
	    $this->load->model('products_m');
	    $product_details = $this->products_m->get();
	    foreach($product_details as $val){
	        $products_list['products_'.$val['id']] = $val['name'];
	    }

	    
	    $this->data['reseller_m']= $this->reseller_m->getAllCode('reseller_panel_subscription');
	    $this->load->helper(array('form', 'url'));
	    
	    $this->data['message'] = '';
	    
	    if(isset($_REQUEST['resellers_plans'])){ 			
	        $name = $this->input->post('sname');
	        $product_id = $this->input->post('product_id');
	        $devices_allowed = $this->input->post('devices_allowed');
	        $price = $this->input->post('price');
	        $length_months = $this->input->post('length_months');
	        $month_day = $this->input->post('month_day');			
	        $facility_content = $this->input->post('facility_content');			
	        $currency_type = $this->input->post('currency_type');
	        $status = $this->input->post('status');
	        $activation_price = $this->input->post('activation_price');
	        
	        $this->data['sname'] = $name;
	        $this->data['product_id'] = $product_id;
	        $this->data['devices_allowed'] = $devices_allowed;
	        $this->data['price'] = $price;
	        $this->data['length_months'] = $length_months;			
	        $this->data['facility_content'] = $facility_content;			
	        $this->data['currency_type'] = $currency_type;
	        $this->data['status'] = $status;
	        $this->data['activation_price'] = $activation_price;
	        
	        $data = array('name' => $name,
	                        'monthly_price' => $price,
	                        'product_id' => $product_id,
	                        'length_months' => $length_months,
	                        'plan_type' => 'trial',
	                        'devices_allowed'	=> $devices_allowed,
	                        'active' => $status,
	                        'month_day' => $month_day,								
	                        'facility_content' => $facility_content,								
	                        'currency_type' => $currency_type,
	                        'activation_price' => $activation_price
	                );
	        $this->reseller_m->insertkeys($data,'reseller_panel_subscription');
	    
	        redirect(BASE_URL.'reseller/resellerplans/index/4');
	        
	    }
	    else {
	        // Default values for trial plans
	        $this->data['sname'] = '';
	        $this->data['devices_allowed'] = '';
	        $this->data['product_id'] = '';
	        $this->data['price'] = '0';
	        $this->data['length_months'] = '30';				
	        $this->data['facility_content'] = '';			
	        $this->data['currency_type'] = '';
	        $this->data['status'] = '';
	        $this->data['activation_price'] = '0';
	    }
	    
	    $this->data['main_nav'] = 'products';
	    $this->data['sub_nav'] = 'resellerplans';
	    $this->data['products_list']= $products_list;
	    $this->data['products']= $product_details;
	    
	    $this->data['_extra_scripts'] = DEFAULT_THEME . 'reseller/_extra_scripts';
	    $this->data['_view'] = DEFAULT_THEME . 'reseller/resellers_plan';
	    $this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function resellerplansXXX(){		
		$this->load->model('products_m');
		$product_details = $this->products_m->get();
		foreach($product_details as $val){
			$products_list['products_'.$val['id']] = $val['name'];
		}
		
		$this->data['reseller_m']= $this->reseller_m->getAllCode('reseller_panel_subscription');
		$this->load->helper(array('form', 'url'));
		
		 $this->data['message'] = '';
		if(isset($_REQUEST['resellers_plans'])){ 			
			$name = $this->input->post('sname');
			$product_id = $this->input->post('product_id');
			/*$devices_allowed = $this->input->post('devices_allowed');*/
			$price = $this->input->post('price');
			$length_months = $this->input->post('length_months');
			$month_day = $this->input->post('month_day');			
			$facility_content = $this->input->post('facility_content');			
			$currency_type = $this->input->post('currency_type');
			$status = $this->input->post('status');
			
			//echo $keysnumber;exit;
			$this->data['sname'] = $name;
			$this->data['product_id'] = $product_id;
			/*$this->data['devices_allowed'] = $devices_allowed;*/
			$this->data['price'] = $price;
			$this->data['length_months'] = $length_months;			
			$this->data['facility_content'] = $facility_content;			
			$this->data['currency_type'] = $currency_type;
			$this->data['status'] = $status;
				$data = array('name' => $name,
								'monthly_price' => $price,
								'product_id' => $product_id,
								'length_months' => $length_months,
								/*'devices_allowed'	=> $devices_allowed,*/
								'active' => $status,
								'month_day' => $month_day,								
								'facility_content' => $facility_content,								
								'currency_type' => $currency_type
						);
						
				//print_r($data);
				$this->reseller_m->insertkeys($data,'reseller_panel_subscription');
			
			redirect(BASE_URL.'reseller/resellerplans');
			
		} else {
			$this->data['sname'] = '';
			/*$this->data['devices_allow'] = '';*/
			$this->data['product_id'] = '';
			$this->data['price'] = '';
			$this->data['length_months'] = '';				
			$this->data['facility_content'] = '';			
			$this->data['currency_type'] = '';
			$this->data['status'] = '';
		}
		
		$this->data['main_nav'] = 'resellerweb';
		$this->data['sub_nav'] = 'resellerplans';
		$this->data['products_list']= $products_list;
		$this->data['products']= $product_details;
		$this->data['_view'] = DEFAULT_THEME . 'reseller/resellers_plan';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function editplan($id){
		$this->load->model('products_m');
		$product_details = $this->products_m->get();
		foreach($product_details as $val){
			$products_list['products_'.$val['id']] = $val['name'];
		}		
		
		if(isset($_REQUEST['resellers_plans'])){ 			
			$name = $this->input->post('sname');
			$product_id = $this->input->post('product_id');
			/*$devices_allowed = $this->input->post('devices_allowed');*/
			$price = $this->input->post('price');
			$length_months = $this->input->post('length_months');
			$month_day = $this->input->post('month_day');			
			$facility_content = $this->input->post('facility_content');			
			$currency_type = $this->input->post('currency_type');
			$status = $this->input->post('status');
			
			//echo $keysnumber;exit;
			$this->data['sname'] = $name;
			$this->data['product_id'] = $product_id;
			/*$this->data['devices_allowed'] = $devices_allowed;*/
			$this->data['price'] = $price;
			$this->data['length_months'] = $length_months;			
			$this->data['facility_content'] = $facility_content;			
			$this->data['currency_type'] = $currency_type;
			$this->data['status'] = $status;
			$this->data['month_day'] = $month_day;
				$data = array('name' => $name,
								'monthly_price' => $price,
								'product_id' => $product_id,
								'length_months' => $length_months,
								/*'devices_allowed'	=> $devices_allowed,*/
								'active' => $status,
								'month_day' => $month_day,								
								'facility_content' => $facility_content,								
								'currency_type' => $currency_type
						);
				$where = array('id' => $id);
				$this->reseller_m->update_keycode($data,$where,'reseller_panel_subscription');	
				//print_r($data);
				//$this->reseller_m->insertkeys($data,'reseller_panel_subscription');
			
			redirect(BASE_URL.'reseller/resellerplans');
			
		} else {
			$reseller_plandetails = $this->reseller_m->getResellerPlans($id,'reseller_panel_subscription');
			/*echo '<pre>';
			print_r($reseller_plandetails);*/
			$this->data['sname'] = $reseller_plandetails[0]['name'];
			/*$this->data['devices_allowed'] = $reseller_plandetails[0]['devices_allowed'];*/
			$this->data['product_id'] = $reseller_plandetails[0]['product_id'];
			$this->data['price'] = $reseller_plandetails[0]['monthly_price'];
			$this->data['length_months'] = $reseller_plandetails[0]['length_months'];				
			$this->data['facility_content'] = $reseller_plandetails[0]['facility_content'];			
			$this->data['currency_type'] = $reseller_plandetails[0]['currency_type'];
			$this->data['status'] = $reseller_plandetails[0]['active'];
			$this->data['month_day'] = $reseller_plandetails[0]['month_day'];
		}
		$this->data['id'] = $id;
		$this->data['main_nav'] = 'resellerweb';
		$this->data['sub_nav'] = 'resellerplans';
		$this->data['products_list']= $products_list;
		$this->data['products']= $product_details;
		
		$this->data['_view'] = DEFAULT_THEME . 'reseller/editplan';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function editplanRenewal($id){
		$this->load->model('products_m');
		$product_details = $this->products_m->get();
		foreach($product_details as $val){
			$products_list['products_'.$val['id']] = $val['name'];
		}		
		
		if(isset($_REQUEST['resellers_plans'])){ 			
			$name = $this->input->post('sname');
			$product_id = $this->input->post('product_id');
			$devices_allowed = $this->input->post('devices_allowed');
			$price = $this->input->post('price');
			$length_months = $this->input->post('length_months');
			$month_day = $this->input->post('month_day');			
			$facility_content = $this->input->post('facility_content');			
			$currency_type = $this->input->post('currency_type');
			$status = $this->input->post('status');
			
			//echo $keysnumber;exit;
			$this->data['sname'] = $name;
			$this->data['product_id'] = $product_id;
			$this->data['devices_allowed'] = $devices_allowed;
			$this->data['price'] = $price;
			$this->data['length_months'] = $length_months;			
			$this->data['facility_content'] = $facility_content;			
			$this->data['currency_type'] = $currency_type;
			$this->data['status'] = $status;
			$this->data['month_day'] = $month_day;
				$data = array('name' => $name,
								'monthly_price' => $price,
								'product_id' => $product_id,
								'length_months' => $length_months,
								'devices_allowed'	=> $devices_allowed,
								'active' => $status,
								'month_day' => $month_day,								
								'facility_content' => $facility_content,								
								'currency_type' => $currency_type
						);
				$where = array('id' => $id);
				$this->reseller_m->update_keycode($data,$where,'reseller_panel_subscription');	
				//print_r($data);
				//$this->reseller_m->insertkeys($data,'reseller_panel_subscription');
			
			redirect(BASE_URL.'reseller/resellerplans');
			
		} else {
			$reseller_plandetails = $this->reseller_m->getResellerPlans($id,'reseller_panel_subscription');
			/*echo '<pre>';
			print_r($reseller_plandetails);*/
			$this->data['sname'] = $reseller_plandetails[0]['name'];
			$this->data['devices_allowed'] = $reseller_plandetails[0]['devices_allowed'];
			$this->data['product_id'] = $reseller_plandetails[0]['product_id'];
			$this->data['price'] = $reseller_plandetails[0]['monthly_price'];
			$this->data['length_months'] = $reseller_plandetails[0]['length_months'];				
			$this->data['facility_content'] = $reseller_plandetails[0]['facility_content'];			
			$this->data['currency_type'] = $reseller_plandetails[0]['currency_type'];
			$this->data['status'] = $reseller_plandetails[0]['active'];
			$this->data['month_day'] = $reseller_plandetails[0]['month_day'];
		}
		$this->data['id'] = $id;
		$this->data['main_nav'] = 'products';
		$this->data['sub_nav'] = 'resellerplans';
		$this->data['products_list']= $products_list;
		$this->data['products']= $product_details;
		
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'reseller/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'reseller/editplan_renewal';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}	
	public function editplanActivation($id){
		$this->load->model('products_m');
		$product_details = $this->products_m->get();
		foreach($product_details as $val){
			$products_list['products_'.$val['id']] = $val['name'];
		}		
		
		if(isset($_REQUEST['resellers_plans'])){ 			
			$name = $this->input->post('sname');
			$product_id = $this->input->post('product_id');
			$devices_allowed = $this->input->post('devices_allowed');
			$price = $this->input->post('price');
			$length_months = $this->input->post('length_months');
			$month_day = $this->input->post('month_day');			
			$facility_content = $this->input->post('facility_content');			
			$currency_type = $this->input->post('currency_type');
			$status = $this->input->post('status');
			$activation_price = $this->input->post('activation_price');
			
			//echo $keysnumber;exit;
			$this->data['sname'] = $name;
			$this->data['product_id'] = $product_id;
			$this->data['devices_allowed'] = $devices_allowed;
			$this->data['price'] = $price;
			$this->data['length_months'] = $length_months;			
			$this->data['facility_content'] = $facility_content;			
			$this->data['currency_type'] = $currency_type;
			$this->data['status'] = $status;
			$this->data['month_day'] = $month_day;
			$this->data['activation_price'] = $activation_price;
			
				$data = array('name' => $name,
								'monthly_price' => $price,
								'product_id' => $product_id,
								'length_months' => $length_months,
								'devices_allowed'	=> $devices_allowed,
								'active' => $status,
								'month_day' => $month_day,								
								'facility_content' => $facility_content,								
								'currency_type' => $currency_type,
								'activation_price' =>$activation_price
						);
				$where = array('id' => $id);
				$this->reseller_m->update_keycode($data,$where,'reseller_panel_subscription');	
				//print_r($data);
				//$this->reseller_m->insertkeys($data,'reseller_panel_subscription');
			
			redirect(BASE_URL.'reseller/resellerplans');
			
		} else {
			$reseller_plandetails = $this->reseller_m->getResellerPlans($id,'reseller_panel_subscription');
			/*echo '<pre>';
			print_r($reseller_plandetails);*/
			$this->data['sname'] = $reseller_plandetails[0]['name'];
			$this->data['devices_allowed'] = $reseller_plandetails[0]['devices_allowed'];
			$this->data['product_id'] = $reseller_plandetails[0]['product_id'];
			$this->data['price'] = $reseller_plandetails[0]['monthly_price'];
			$this->data['length_months'] = $reseller_plandetails[0]['length_months'];				
			$this->data['facility_content'] = $reseller_plandetails[0]['facility_content'];			
			$this->data['currency_type'] = $reseller_plandetails[0]['currency_type'];
			$this->data['status'] = $reseller_plandetails[0]['active'];
			$this->data['month_day'] = $reseller_plandetails[0]['month_day'];
			$this->data['activation_price'] = $reseller_plandetails[0]['activation_price'];
		}
		$this->data['id'] = $id;
		$this->data['main_nav'] = 'products';
		$this->data['sub_nav'] = 'resellerplans';
		$this->data['products_list']= $products_list;
		$this->data['products']= $product_details;
		
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'reseller/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'reseller/editplan_activation';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}	
	public function editplanMaster($id){

		$this->data['page_title'] = "Edit Master Plan";
		/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();


		$this->load->model('products_m');
		$product_details = $this->products_m->get();
		foreach($product_details as $val){
			$products_list['products_'.$val['id']] = $val['name'];
		}		
		
		if(isset($_REQUEST['resellers_plans'])){ 			
			$name = $this->input->post('sname');
			$product_id = $this->input->post('product_id');
			$devices_allowed = $this->input->post('devices_allowed');
			$price = $this->input->post('price');
			$length_months = $this->input->post('length_months');
			$month_day = $this->input->post('month_day');			
			$facility_content = $this->input->post('facility_content');			
			$currency_type = $this->input->post('currency_type');
			$status = $this->input->post('status');
			$activation_price = $this->input->post('activation_price');
			
			//echo $keysnumber;exit;
			$this->data['sname'] = $name;
			$this->data['product_id'] = $product_id;
			$this->data['devices_allowed'] = $devices_allowed;
			$this->data['price'] = $price;
			$this->data['length_months'] = $length_months;			
			$this->data['facility_content'] = $facility_content;			
			$this->data['currency_type'] = $currency_type;
			$this->data['status'] = $status;
			$this->data['month_day'] = $month_day;
			$this->data['activation_price'] = $activation_price;
				$data = array('name' => $name,
								'monthly_price' => $price,
								'product_id' => $product_id,
								'length_months' => $length_months,
								'devices_allowed'	=> $devices_allowed,
								'active' => $status,
								'month_day' => $month_day,								
								'facility_content' => $facility_content,								
								'currency_type' => $currency_type,
								'activation_price' =>$activation_price
						);
				$where = array('id' => $id);
				$this->reseller_m->update_keycode($data,$where,'reseller_panel_subscription');	
				//print_r($data);
				//$this->reseller_m->insertkeys($data,'reseller_panel_subscription');
			
			redirect(BASE_URL.'reseller/resellerplans');
			
		} else {
			$reseller_plandetails = $this->reseller_m->getResellerPlans($id,'reseller_panel_subscription');
			/*echo '<pre>';
			print_r($reseller_plandetails);*/
			$this->data['sname'] = $reseller_plandetails[0]['name'];
			$this->data['devices_allowed'] = $reseller_plandetails[0]['devices_allowed'];
			$this->data['product_id'] = $reseller_plandetails[0]['product_id'];
			$this->data['price'] = $reseller_plandetails[0]['monthly_price'];
			$this->data['length_months'] = $reseller_plandetails[0]['length_months'];				
			$this->data['facility_content'] = $reseller_plandetails[0]['facility_content'];			
			$this->data['currency_type'] = $reseller_plandetails[0]['currency_type'];
			$this->data['status'] = $reseller_plandetails[0]['active'];
			$this->data['month_day'] = $reseller_plandetails[0]['month_day'];
			$this->data['activation_price'] = $reseller_plandetails[0]['activation_price'];
		}
		$this->data['id'] = $id;
		$this->data['main_nav'] = 'products';
		$this->data['sub_nav'] = 'resellerplans';

		$this->data['products_list']= $products_list;
		$this->data['products']= $product_details;
		
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'reseller/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'reseller/editplan_master';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
		public function editplanTrial($id){
	    $this->data['page_title'] = "Edit Trial Plan";
	    /* Breadcrumbs */
	    $this->data['breadcrumb'] = $this->breadcrumbs->show();

	    $this->load->model('products_m');
	    $product_details = $this->products_m->get();
	    foreach($product_details as $val){
	        $products_list['products_'.$val['id']] = $val['name'];
	    }		
	    
	    if(isset($_REQUEST['resellers_plans'])){ 			
	        $name = $this->input->post('sname');
	        $product_id = $this->input->post('product_id');
	        $devices_allowed = $this->input->post('devices_allowed');
	        $price = $this->input->post('price');
	        $length_months = $this->input->post('length_months');
	        $month_day = $this->input->post('month_day');			
	        $facility_content = $this->input->post('facility_content');			
	        $currency_type = $this->input->post('currency_type');
	        $status = $this->input->post('status');
	        
	        $this->data['sname'] = $name;
	        $this->data['product_id'] = $product_id;
	        $this->data['devices_allowed'] = $devices_allowed;
	        $this->data['price'] = $price;
	        $this->data['length_months'] = $length_months;			
	        $this->data['facility_content'] = $facility_content;			
	        $this->data['currency_type'] = $currency_type;
	        $this->data['status'] = $status;
	        $this->data['month_day'] = $month_day;
	        
	        $data = array('name' => $name,
	                    'monthly_price' => $price,
	                    'product_id' => $product_id,
	                    'length_months' => $length_months,
	                    'devices_allowed'	=> $devices_allowed,
	                    'active' => $status,
	                    'month_day' => $month_day,								
	                    'facility_content' => $facility_content,								
	                    'currency_type' => $currency_type
	            );
	        $where = array('id' => $id);
	        $this->reseller_m->update_keycode($data,$where,'reseller_panel_subscription');	
	        
	        redirect(BASE_URL.'reseller/resellerplans');
	        
	    } else {
	        $reseller_plandetails = $this->reseller_m->getResellerPlans($id,'reseller_panel_subscription');
	        $this->data['sname'] = $reseller_plandetails[0]['name'];
	        $this->data['devices_allowed'] = $reseller_plandetails[0]['devices_allowed'];
	        $this->data['product_id'] = $reseller_plandetails[0]['product_id'];
	        $this->data['price'] = $reseller_plandetails[0]['monthly_price'];
	        $this->data['length_months'] = $reseller_plandetails[0]['length_months'];				
	        $this->data['facility_content'] = $reseller_plandetails[0]['facility_content'];			
	        $this->data['currency_type'] = $reseller_plandetails[0]['currency_type'];
	        $this->data['status'] = $reseller_plandetails[0]['active'];
	        $this->data['month_day'] = $reseller_plandetails[0]['month_day'];
	    }
	    $this->data['id'] = $id;
	    $this->data['main_nav'] = 'products';
	    $this->data['sub_nav'] = 'resellerplans';
	    $this->data['products_list']= $products_list;
	    $this->data['products']= $product_details;
	    
	    $this->data['_extra_scripts'] = DEFAULT_THEME . 'reseller/_extra_scripts';
	    $this->data['_view'] = DEFAULT_THEME . 'reseller/editplan_trial';
	    $this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}

	
	public function resellersdetails($id){
		
		$this->data['page_title'] = "Resellers Details";
		/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

		$this->load->model('products_m');
		$product_details = $this->products_m->get();
		foreach($product_details as $val){
			$products_list['products_'.$val['id']] = $val['name'];
		}
		
		$this->data['active_tab'] = 'plans';
		
		$getwhere = array('reseller_id' => $id);
		if(isset($_REQUEST['customer_plans'])){			
			$this->data['active_tab'] = 'customer';
		}
		
		if(isset($_REQUEST['add_plans'])){	
			$selected_plans = $this->input->post('selected_plans');	
			
			$getdatarow = $this->reseller_m->selectdatarow($getwhere, 'reseller_details');
			
			$selected_plans_array = array();
			foreach($getdatarow as $key=>$val){
				$selected_plans_array[] = $val['product_plans'];
			}
			/*echo '<pre>';
			print_r($getdatarow);*/
			$array_diff = array_diff($selected_plans_array,$selected_plans);
			foreach($array_diff as $valplan){
				$this->reseller_m->deletedatarow(array('product_plans' => $valplan,'reseller_id' => $id),'reseller_details');
			}
			//echo '<pre>';
			foreach($selected_plans as $val_plan){
				if(!in_array($val_plan,$selected_plans_array)){
					$reseller_plandetails = $this->reseller_m->getResellerPlans($val_plan,'reseller_panel_subscription');
					/*print_r($reseller_plandetails);
					echo $reseller_plandetails[0]['currency_type'].'---------------';*/
					$data = array('reseller_id' => $id, 
								  'product_plans' => $val_plan,
								  'currency_type' => $reseller_plandetails[0]['currency_type'],
								  'activation_price' => $reseller_plandetails[0]['activation_price'],
								  'discount_value' => '0',
								  'dealer_price' => (($reseller_plandetails[0]['monthly_price']*$reseller_plandetails[0]['length_months'])+$reseller_plandetails[0]['activation_price']),
								  'plan_type' => $reseller_plandetails[0]['plan_type']
								 );	
					$this->reseller_m->insertkeys($data, 'reseller_details');
				}				
								
				//print_r($selected_plans);
				
			}	
			
			//exit;			
			//insertkeys($data, $table);
			//$this->reseller_m->update_keycode($data,$getwhere,'reseller_details');			
			$this->data['active_tab'] = 'plans';
		}		
		$reseller_plans = $this->reseller_m->getAllActivePlans('reseller_panel_subscription');
		
		foreach($reseller_plans as $key=>$val){
			$reseller_plansArray['id_'.$val['id']] = $val;
		}
		$this->data['reseller_plansArray']= $reseller_plansArray;
		
		$this->data['reseller_m']= $reseller_plans;
		$this->data['products_list']= $products_list;
		$this->data['products']= $product_details;
		
		$selected_plans_list = $this->reseller_m->selectdatarow($getwhere, 'reseller_details');
		/*echo '<pre>';
		print_r($this->reseller_m->getAllActivePlans('reseller_panel_subscription'));exit;*/
		$selected_plansarray = array();
		foreach($selected_plans_list as $key=>$val){
			$selected_plansarray[] = $val['product_plans'];
		}
		$this->data['selected_plans']= $selected_plansarray;
		$this->data['selected_plans_list']= $selected_plans_list;
		
		$reseller_info = $this->reseller_m->getReseller($id);		
		$this->data['reseller_currency_type'] = $reseller_info[0]['currency_type'];
		
		$this->data['reseller_id'] = $id;
		$this->data['main_nav'] = 'resellerweb';
		$this->data['sub_nav'] = 'reseller';		
		
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'reseller/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'reseller/resellerdetails';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function resellerplansupdate(){
		$id = $_REQUEST['id'];
		$currency = $_REQUEST['currency'];
		$fixed_per = $_REQUEST['fixed_per'];
		$fixed_per_val = $_REQUEST['fixed_per_val'];
		$product_plans_price = $_REQUEST['product_plans_price'];
		$activation_price = $_REQUEST['activation_price'];
		$dealer_price = ($fixed_per == '1') ? ($product_plans_price-$fixed_per_val): ($product_plans_price - (($product_plans_price*$fixed_per_val)/100));
		//echo $dealer_price;
		
		if($dealer_price > 0){
			$data = array('currency_type' => $currency,
								'discount_type' => $fixed_per,
								'discount_value' => $fixed_per_val,
								'activation_price' =>$activation_price,
								'dealer_price' => $dealer_price);
			$where = array('id'=>$id);
			$this->reseller_m->update_keycode($data,$where,'reseller_details');
			
			echo json_encode(array('msg'=>'success', 'dealer_price'=>$dealer_price));
		}else{
			echo json_encode(array('msg'=>'fail', 'dealer_price'=>$dealer_price));
		}
		//echo $id.'----'.$currency.'---'.$fixed_per.'---'.$fixed_per_val;
	
	}
	
	public function resellerdelete($id){
		$this->reseller_m->deletedatarow(array('id' => $id), 'reseller');
		$this->reseller_m->deletedatarow(array('reseller_id' => $id), 'reseller_details');
		redirect(BASE_URL.'reseller');
	}
	
	public function deletecode($id){		
		$this->reseller_m->deletesubscription($id, 'reseller_panel_subscription');
		redirect(BASE_URL.'reseller/resellerplans');
	}	
	
	public function details($id){
		$this->data['main_nav'] = 'resellerweb';
		$this->data['sub_nav'] = 'reseller';
		$resellers_info = $this->reseller_m->getReseller($id);
		
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric|callback_checkphone');
		//$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_unique');
		$this->form_validation->set_rules('billing_country', 'Country Code', 'trim|required');
		$this->form_validation->set_rules('billing_state', 'State', 'trim|required');
		$this->form_validation->set_rules('billing_city', 'City', 'trim|required');
		$this->form_validation->set_rules('billing_street', 'Street', 'trim|required');
		$this->form_validation->set_rules('billing_zip', 'ZIP', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('currency_type', 'Currency', 'trim|required');
		/*$this->form_validation->set_rules('passwordv', 'Password', 'trim|required');
		$this->form_validation->set_rules('toc', 'I Accept the Terms', 'trim|required');*/
		
		$this->data['message'] = '';
		if(isset($_REQUEST['add_reseller'])){
			$name = $this->input->post('name');
			$mobile = $this->input->post('mobile');
			$email = $this->input->post('email');
			$billing_country = $this->input->post('billing_country');
			$billing_state = $this->input->post('billing_state');
			$billing_city = $this->input->post('billing_city');
			$billing_street = $this->input->post('billing_street');
			$billing_zip = $this->input->post('billing_zip');
			$status = $this->input->post('status');
			$password = $this->input->post('password');
			$currency_type = $this->input->post('currency_type');
			$currency_type = $this->input->post('currency_type');
			$customer_msgcontent = $this->input->post('customer_msgcontent');
			$reseller_msgedit = $this->input->post('reseller_msgedit');
			//$reseller_masterkey = $this->input->post('reseller_masterkey');
			$see_customer_password = $this->input->post('see_customer_password');			
			$can_create_walletcode = $this->input->post('can_create_walletcode');
			$wallet_code_discount = $this->input->post('wallet_code_discount');
			$can_view_devices = $this->input->post('can_view_devices');
			$plan_type = $this->input->post('plan_type');
			
			if ($this->form_validation->run() == FALSE){
				$this->data['message'] = 'error';
				$this->data['id'] = $id;
				$this->data['name'] = $name;
				$this->data['mobile'] = $mobile;
				$this->data['email'] = $email;
				$this->data['billing_country'] = $billing_country;
				$this->data['billing_state'] = $billing_state;
				$this->data['billing_city'] = $billing_city;
				$this->data['billing_street'] = $billing_street;
				$this->data['billing_zip'] = $billing_zip;
				$this->data['status'] = $status;
				$this->data['password'] = $password;
				$this->data['currency_type'] = $currency_type;				
				$this->data['customer_msgcontent'] = $customer_msgcontent;
				$this->data['reseller_msgedit'] = $reseller_msgedit;
				//$this->data['reseller_masterkey'] = $reseller_masterkey;
				$this->data['see_customer_password'] = $see_customer_password;				
				$this->data['can_create_walletcode'] = $can_create_walletcode;
				$this->data['wallet_code_discount'] = $wallet_code_discount;
				$this->data['can_view_devices'] = $can_view_devices;
				$this->data['plan_type'] = $plan_type;
			} else {
				$data = array(
							'name' => $name,					
							'email' => $email,
							'country' => $billing_country,
							'state' => $billing_state,
							'city' => $billing_city,
							'postcode' => $billing_zip,
							'street' => $billing_street,
							'mobile' => $mobile,
							'status' => $status,
							'password' => base64_encode($password),							
							'currency_type' => $currency_type,							
							'customer_msgcontent' => $customer_msgcontent,
							'reseller_msgedit' => $reseller_msgedit,
							/*'reseller_masterkey' => $reseller_masterkey,*/
							'see_customer_password' => $see_customer_password,
							'can_create_walletcode' => $can_create_walletcode,
							'wallet_code_discount' => $wallet_code_discount,
							'can_view_devices' => $can_view_devices,
							'plan_type' => $plan_type
						);
				$where = array('id' => $id);
				$this->reseller_m->update_key($data, $where);
				redirect(BASE_URL.'reseller');
			}			
		} else{
			$this->data['id'] = $id;
			$this->data['name'] = $resellers_info[0]['name'];
			$this->data['mobile'] = $resellers_info[0]['mobile'];
			$this->data['email'] = $resellers_info[0]['email'];
			$this->data['billing_country'] = $resellers_info[0]['country'];
			$this->data['billing_state'] = $resellers_info[0]['state'];
			$this->data['billing_city'] = $resellers_info[0]['city'];
			$this->data['billing_street'] = $resellers_info[0]['street'];
			$this->data['billing_zip'] = $resellers_info[0]['postcode'];
			$this->data['status'] = $resellers_info[0]['status'];
			$this->data['password'] = base64_decode($resellers_info[0]['password']);
			$this->data['customer_msgcontent'] = $resellers_info[0]['customer_msgcontent'];
			$this->data['reseller_msgedit'] = $resellers_info[0]['reseller_msgedit'];
			$this->data['currency_type'] = $resellers_info[0]['currency_type'];
			$this->data['messageto_customer_reseller'] = $resellers_info[0]['messageto_customer_reseller'];
			//$this->data['reseller_masterkey'] = $resellers_info[0]['reseller_masterkey'];
			$this->data['see_customer_password'] = $resellers_info[0]['see_customer_password'];
			
			$this->data['can_create_walletcode'] = $resellers_info[0]['can_create_walletcode'];
			$this->data['wallet_code_discount'] = $resellers_info[0]['wallet_code_discount'];
			$this->data['can_view_devices'] = $resellers_info[0]['can_view_devices'];
			$this->data['plan_type'] = $resellers_info[0]['plan_type'];
		}
		/*echo '<pre>';
		print_r($resellers_info[0]);exit;*/
		/* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Edit Reseller', 'reseller/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* Countries */
		
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();
		$states = $this->reseller_m->fetch_state($resellers_info[0]['country']);
		//print_r($states);exit;
		$this->data['states'] = $states;
		
		//$this->customers_m->save($insert_id,$data);
		$this->data['page_title'] = 'Edit Reseller';
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'reseller/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'reseller/edit';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function addplans(){
		$this->data['main_nav'] = 'resellerweb';
		$this->data['sub_nav'] = 'addcode';
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('reseller_id', 'Reseller Name', 'trim|required');
		$this->form_validation->set_rules('key_code', 'Key Codeddd', 'trim|required|callback_code_unique');
		$this->data['message'] = '';
		if(isset($_REQUEST['add_code'])){
			$reseller_id = $this->input->post('reseller_id');
			$key_code = $this->input->post('key_code');
			
			
			if ($this->form_validation->run() == FALSE){
				$this->data['reseller_id'] = $reseller_id;
				$this->data['key_code'] = $key_code;
				
			}else{
				$resellers_info = $this->reseller_m->getReseller($reseller_id);				
				$where = array('key_code' => $key_code);
				$data = array('used_by' => $reseller_id);
				$this->reseller_m->update_keycode($data, $where,'reseller_panel_subscription');
				redirect(BASE_URL.'reseller/resellerplans');
			}
		}
		
		$this->data['recellers'] = $this->reseller_m->getAll();
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'reseller/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'reseller/addplans';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function addwallet(){
		//print_r($resellers_info);exit;
		
		$this->data['page_title'] = "Add Wallet";
		/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

		$getReseller = $this->reseller_m->getAll();
		foreach($getReseller as $key=>$val){
			$reseller_name['name_'.$val['id']] = $val['name'];
		}
		
		$this->data['recellers'] = $getReseller;
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('reseller_id', 'Reseller Name', 'trim|required');
		$this->form_validation->set_rules('wallet_money', 'Wallet Money', 'trim|required|greater_than[0]');
		$this->form_validation->set_rules('currency_type', 'Currency Type', 'trim|required');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');
		
		$this->data['message'] = '';
		if(isset($_REQUEST['add_wallet'])){
			$reseller_id = $this->input->post('reseller_id');
			$wallet_money = $this->input->post('wallet_money');
			$currency_type = $this->input->post('currency_type');		
			$payment_status = $this->input->post('payment_status');
			$message = $this->input->post('message');
			
			if ($this->form_validation->run() == FALSE){
				$this->data['reseller_id'] = $reseller_id;
				$this->data['wallet_money'] = $wallet_money;
				$this->data['currency_type'] = $currency_type;
				$this->data['payment_status'] = $payment_status;
				$this->data['message'] = $message;
			}else{
				$resellers_info = $this->reseller_m->getReseller($reseller_id);
				$wallet_money_total = $resellers_info[0]['wallet_money'] + $wallet_money;
				$data = array('wallet_money' => $wallet_money_total);
				$where = array('id' => $reseller_id);
				
				$log_arr[] = array('msg' =>$message);
				$reseller_wallet_data = array('reseller_id' => $reseller_id,
												'reseller_name' => $reseller_name['name_'.$reseller_id], 
												'price' =>$wallet_money, 
													'currency'=>$currency_type, 
														'payment_status'=>$payment_status,
														'message' => json_encode($log_arr));
														
				if($this->reseller_m->insertkeys($reseller_wallet_data, 'reseller_wallet')){
					$this->reseller_m->update_key($data, $where);
				}
				
				redirect(BASE_URL.'reseller/walletpayment');
			}
		}
		
		$this->data['main_nav'] = 'resellerweb';
		$this->data['sub_nav'] = 'walletpayment';
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'reseller/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'reseller/addwallet';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
		
	}
	
	public function walletpayment(){ 
		$this->data['page_title'] = "Wallet Money";
		/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

		$this->data['main_nav'] = 'resellerweb';
		$this->data['sub_nav'] = 'walletpayment';
		$where = array('status'=>'1');
		$this->data['payment_rows'] = $this->reseller_m->getAllRowsWhere('reseller_wallet','id',$where);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'reseller/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'reseller/wallet_money';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function walletdelete($id){
		$data = array('status'=>'0');
		$where = array('id' =>$id);
		$this->reseller_m->update_keycode($data,$where,'reseller_wallet');
		redirect(BASE_URL.'reseller/walletpayment');
		
	}
	
	public function waletstatuschange(){
		$payment_status = ($_REQUEST['payment_status'] == 'paid') ? 'paid': 'notpaid';
		$id = $_REQUEST['id'];
		$msg = $_REQUEST['msg'];
		
		$getwhere = array('id' => $id);
		$getdatarow = $this->reseller_m->selectdatarow($getwhere, 'reseller_wallet');
		$message = json_decode($getdatarow[0]['message'],true);
		
		$json_array = array();		
		array_push($json_array,array('msg' => $msg));
		foreach($message as $key=>$val){
			array_push($json_array,$val);
		}
		// echo json_encode($json_array);
		 
		
						
		$data = array('payment_status'=>$payment_status,'message'=>json_encode($json_array));
		$where = array('id' =>$id);
		if($this->reseller_m->update_keycode($data,$where,'reseller_wallet')){
			echo 'success';
		}else{
			echo 'falure'; 
		}
	}
	
	public function messagehistory(){
		$id = @$_REQUEST['id'];
		$msg = @$_REQUEST['msg'];
		$getwhere = array('id' => $id);
		$getdatarow = $this->reseller_m->selectdatarow($getwhere, 'reseller_wallet');
		$message = json_decode($getdatarow[0]['message'],true);
		
		/*echo '<pre>';
		print_r($message);*/
		if(count($message) > 0){
			echo '<div style="max-height: 300px;overflow-y: scroll;">';
			echo '<div style="border-bottom: 1px dotted #ccc; height:50px;">
						<div style="width:70%;float:left;">Message</div>
						<div style="width:30%;float:left;">Created Time</div>
					  </div>';
			foreach($message as $key=>$val){

				echo '<div style="border-bottom: 1px dotted #ccc;height:50px;">
						<div style="width:70%;float:left;">'.@$val['msg'].'</div>
						<div style="width:30%;float:left;">'.date("M j, Y, g:i a", strtotime(@$val['creation_time'])).'</div>
					  </div>';
			}
			echo '</div>';
		} else{
			echo '<div>';
			echo '<div style="border-bottom: 1px dotted #ccc; height:50px;">
						<div style="width:70%;float:left;">Message</div>
						<div style="width:30%;float:left;">Created Time</div>
					  </div>';
			echo '<div style="border-bottom: 1px dotted #ccc; height:50px;text-align:center;">
						No Message
					  </div>';		  
			echo '</div>';
			
		}
	}
	
	public function waletupdatemessage(){
		//$payment_status = 'paid';
		$id = @$_REQUEST['id'];
		$msg = @$_REQUEST['msg'];
		$getwhere = array('id' => $id);
		$getdatarow = $this->reseller_m->selectdatarow($getwhere, 'reseller_wallet');
		$message = json_decode($getdatarow[0]['message'],true);
		
		$json_array = array();		
		array_push($json_array,array('msg' => $msg, 'creation_time'=>date('Y-m-d H:i:s', time())));
		foreach($message as $key=>$val){
			array_push($json_array,$val);
		}
		// echo json_encode($json_array);
		 
		$data = array('message'=>json_encode($json_array));
		$where = array('id' =>$id);
		if($this->reseller_m->update_keycode($data,$where,'reseller_wallet')){
			echo 'success';
		}else{
			echo 'falure';
		}
	}
	
	public function resellercurrency(){
		$reseller_id = $_REQUEST['reseller_id'];
		$resellers_info = $this->reseller_m->getReseller($reseller_id);
		//print_r($resellers_info);
			foreach(COUNTRY_CURRENCY as $key=>$val){
				if($resellers_info[0]['currency_type'] == $val){
                  echo '<option value="'.$val.'">'.$key.'</option>';
				}
            }  
	}
	
	public function subscription(){

		$this->data['page_title'] = "Subscription Code";
		/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

		$this->data['recellers'] = $this->reseller_m->getAll();
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('product_id', 'Product Name', 'trim|required');
		$this->form_validation->set_rules('keycode_length', 'Keycode Length', 'trim|required|greater_than[0]|less_than_equal_to[10]');	
		$this->form_validation->set_rules('devices_allowed', 'Total Devices Number', 'trim|required|greater_than[0]');
		$this->form_validation->set_rules('price', ' ', 'trim|required|greater_than[0]');	
		$this->form_validation->set_rules('currency_type', ' ', 'trim|required');
		$this->form_validation->set_rules('length_months', ' ', 'trim|required|greater_than[0]');
		$this->form_validation->set_rules('month_day', ' ', 'trim|required');
		$this->form_validation->set_rules('status', ' ', 'trim|required');	
		$this->form_validation->set_rules('commission', ' ', 'trim|required|greater_than_equal_to[0]');	
		
		if(isset($_REQUEST['add_subscription'])){
			$product_id = $this->input->post('product_id');
			$keycode_length = $this->input->post('keycode_length');
			$devices_allowed = $this->input->post('devices_allowed');
			$price = $this->input->post('price');
			$currency_type = $this->input->post('currency_type');
			$length_months = $this->input->post('length_months');
			$month_day = $this->input->post('month_day');
			$status = $this->input->post('status');
			$commission = $this->input->post('commission');
			if ($this->form_validation->run() == FALSE){
				$this->data['product_id'] = $product_id;
				$this->data['keycode_length'] = $keycode_length;
				$this->data['devices_allowed'] = $devices_allowed;
				$this->data['price'] = $price;
				$this->data['currency_type'] = $currency_type;
				$this->data['length_months'] = $length_months;
				$this->data['month_day'] = $month_day;
				$this->data['status'] = $status;
				$this->data['commission'] = $commission;
			}else{
				for($i=1;$i<=$keycode_length;$i++){
					$code = substr(str_shuffle("0123456789abcdefghijklmmnopqrstuvwxyz"), 0, $keycode_length);
					$data = array(									
								'code' => $code,
								'product_id' => $product_id,
								'price' => $price,
								'life_length' => $length_months,
								'day_month' => $month_day,
								'status' => $status,
								'devices_allowed' => $devices_allowed,
								'currency_type' => $currency_type,
								'commission' =>($price*$commission)/100
							);					
					$this->reseller_m->insertkeys($data, 'subscription_plans_reseller');
				}
				redirect(BASE_URL.'reseller/subscription');
			}
		}
				
		/* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Subscription Code', 'reseller/subscription');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
		$this->data['all_reseller_code'] = $this->reseller_m->getAllCode('subscription_plans_reseller');
		$this->data['main_nav'] = 'resellerweb';
		$this->data['sub_nav'] = 'subscription';
		$this->load->model('products_m');
		$product_details = $this->products_m->get();
		foreach($product_details as $val){
			$products_list['products_'.$val['id']] = $val['name'];
		}
		//print_r($products_list);exit;
		$this->data['products_list']= $products_list;
		$this->data['products']= $product_details;
		
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'reseller/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'reseller/subscription';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function deletesubscription($id){		
		$this->reseller_m->deletesubscription($id,'subscription_plans_reseller');
		$this->session->set_flashdata('success',"Key Deleted Successfully.");
		redirect(BASE_URL.'reseller/subscription');
	}
	
	public function checkphone($num){
        //your first charcter in voter_phone
        $first_ch = substr($num,0,1);
        if ($first_ch==0)
        {
            //set your error message here
           $this->form_validation->set_message('checkphone','Mobile Number will not start with 0');
            return FALSE;
        }
        else
            return TRUE;
    }
	
	public function email_unique(){
		$remail = $this->input->post('email');
		$this->form_validation->set_message('email_unique', 'This email already used. Use another Email.');
		return $this->reseller_m->get_email_check_available($remail);
	}
	
	public function code_unique(){
		$key_code = $this->input->post('key_code');		
		
		if($key_code == ''){
			$this->form_validation->set_message('code_unique', 'The key code Required.');
			return false;
		}else{ 
			if($this->reseller_m->get_resellercode_verification($key_code, 'reseller_panel_subscription')){
				if($this->reseller_m->get_resellercode_check_available($key_code, 'reseller_panel_subscription')){
					$this->form_validation->set_message('code_unique', 'This key code already used. Use another.');
					return false;
				}				
			}else{ 
				$this->form_validation->set_message('code_unique', 'This key code is not real.');
				return false;
			}
		}
		
		return true;
		//return $this->reseller_m->get_resellercode_check_available($key_code, 'reseller_panel_subscription');
		//return false;
	}
	
	public function fetch_state(){
          if($this->input->post('country_id'))
          {
           echo $this->reseller_m->fetch_state($this->input->post('country_id'));
          }
     }

	public function login(){
		$this->data['_view'] = CUSTOMER_THEME . 'resellers/login';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_before',$this->data);
	}
	
	public function random_number($maxlength = 17) {
		$chary = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
						"0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
						"A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
		$return_str = "";
		for ( $x=0; $x<=$maxlength; $x++ ) {
			$return_str .= $chary[rand(0, count($chary)-1)];
		}
		return $return_str;
	}

	
}