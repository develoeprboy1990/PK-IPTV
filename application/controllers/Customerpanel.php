<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customerpanel extends MY_Controller
{
	public $data = [];

	public function __construct(){
		parent::__construct();
		//$this->load->database();
		$this->data['is_allow']= check_permission(62);
        $this->load->model('customers_m');
		$this->load->model('products_m');
		$this->load->model('customerpanel_m');
		$this->load->model('gui_settings_m');
		$this->load->library('breadcrumbs');
	}
	
	public function index(){
		$this->data['is_allow']= check_permission(63);
		$this->data['page_title'] = "Customer Panel";
		/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
		$this->data['main_nav'] = 'customerPanel';
		$this->data['sub_nav'] = 'subscription_plans';
		$this->data['products']= $this->products_m->get();
		$this->data['customerpanel_m']= $this->customerpanel_m->getKeys();
        
		/*echo '<pre>';
		print_r($this->customerpanel_m->getKeys());exit;*/
		$this->load->helper(array('form', 'url'));
		
		 $this->data['message'] = '';
		if(isset($_REQUEST['subscription_plans'])){ 			
			$name = $this->input->post('sname');
			$product_id = $this->input->post('product_id');
			$devices_allowed = $this->input->post('devices_allowed');
			$price = $this->input->post('price');
			$length_months = $this->input->post('length_months');
			$month_day = $this->input->post('month_day');
			$tag_title = $this->input->post('tag_title');
			$facility_content = $this->input->post('facility_content');
			//$gui_setting_id = $this->input->post('gui_setting_id');
			//$product_group = $this->input->post('product_group');
			$rproducts = $this->input->post('rproducts');
			
			//print_r($rproducts);exit;
			$this->data['sname'] = $name;
			$this->data['product_id'] = $product_id;
			$this->data['devices_allowed'] = $devices_allowed;
			$this->data['price'] = $price;
			$this->data['length_months'] = $length_months;
			$this->data['tag_title'] = $tag_title;
			$this->data['facility_content'] = $facility_content;
			//$this->data['gui_setting_id'] = $gui_setting_id;
			//$this->data['product_group'] = $product_group;
			
			$data = array('name' => $name,
							'monthly_price' => $price,
								'product_id' => $product_id,
									'devices_allowed'	=> $devices_allowed,
										'length_months' => $length_months,
										'month_day' => $month_day,
										'tag_title' => $tag_title,
										'facility_content' => $facility_content,
										/*'product_group' => $product_group,*/
										'rproducts' => implode(',', $rproducts)
										/*'gui_setting_id' => $gui_setting_id*/
						);
			
			$this->customerpanel_m->insert('customers_panel_subscription', $data);
			redirect(BASE_URL.'customerpanel');
			
		} 
		else {
			$this->data['sname'] = '';
			$this->data['devices_allow'] = '';
			$this->data['product_id'] = '';
			$this->data['price'] = '';
			$this->data['length_months'] = '';
			$this->data['tag_title'] = '';
			$this->data['facility_content'] = '';
			$this->data['gui_setting_id'] = '';
			/*$this->data['product_group'] = '';*/
		}
		 /* GUI Settings*/
		// echo '<pre>';
		
		$gui_setting = $this->gui_settings_m->get();
		foreach($gui_setting as $key=>$val){
			$gui_setting_array['id_'.$val['id']] =  $val['setting_name'];
		}
		
		//print_r();exit;
        $this->data['settings']= $this->gui_settings_m->get();
		$this->data['gui_setting_array']= $gui_setting_array;
		
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'customerpanel/_extra_scripts';
		$this->data['subscription_renewal_keys_view'] = $this->load->view( DEFAULT_THEME . 'customerpanel/_add_subscription_keys',$this->data, TRUE);
        $this->data['subscription_renewal_keys_list_view']= $this->load->view( DEFAULT_THEME . 'customerpanel/_list_subscription_keys',$this->data, TRUE);
		
        $this->data['_view'] = DEFAULT_THEME . 'customerpanel/index';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function relatedProducts(){
		$p_id = $_REQUEST['p_id'];
		$product_info = $this->products_m->get_products_byid($p_id);
		$gui_setting_id = $product_info[0]['gui_setting_id'];
		$product_gui_info = $this->products_m->get_products_bygui($gui_setting_id);
		/*echo '<pre>';
		print_r($product_gui_info);*/
		foreach($product_gui_info as $key=>$val){
			if($val['id'] != $p_id){
				echo '<input type="checkbox" id="vehicle1" name="rproducts[]" value="'.$val['id'].'">
						<label for="vehicle1">'.$val['name'].'</label><br>';
			}
		}
		
	}
	
	public function deleteplan($id){
		$where = array('id' => $id);
		$data = array('active' => '0');
		$this->customerpanel_m->update_key($data,$where, 'customers_panel_subscription');
		redirect(BASE_URL.'customerpanel');
	}
	
	public function editplan($id){
		$this->data['is_allow']= check_permission(63);
		$this->data['page_title'] = "Customer Panel";
		/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
		$plan_details = $this->customerpanel_m->getPlanById($id);
		
		 $this->data['message'] = '';
		if(isset($_REQUEST['walet_plans'])){ 			
			$name = $this->input->post('sname');
			$product_id = $this->input->post('product_id');
			$devices_allowed = $this->input->post('devices_allowed');
			$price = $this->input->post('price');
			$length_months = $this->input->post('length_months');
			$month_day = $this->input->post('month_day');
			$tag_title = $this->input->post('tag_title');
			$facility_content = $this->input->post('facility_content');
			//$gui_setting_id = $this->input->post('gui_setting_id');
			//$product_group = $this->input->post('product_group');
			//$rproducts = $this->input->post('rproducts');
			
			$this->data['id'] = $plan_details['id'];
			
			$this->data['sname'] = $name;
			$this->data['product_id'] = $product_id;
			$this->data['devices_allowed'] = $devices_allowed;
			$this->data['price'] = $price;
			$this->data['length_months'] = $length_months;
			$this->data['tag_title'] = $tag_title;
			$this->data['facility_content'] = $facility_content;
			$this->data['month_day'] = $month_day;
			//$this->data['gui_setting_id'] = $gui_setting_id;
			//$this->data['product_group'] = $product_group;
			//$this->data['rproducts'] = $rproducts;
			
			$data = array('name' => $name,
							'monthly_price' => $price,
								'product_id' => $product_id,
									'devices_allowed'	=> $devices_allowed,
										'length_months' => $length_months,
										'month_day' => $month_day,
										'tag_title' => $tag_title,
										'facility_content' => $facility_content,
										/*'product_group' => $product_group,
										'rproducts' => implode(',', $rproducts)*/
										/*'gui_setting_id' => $gui_setting_id*/
						);
			$where = array('id' => $id);
			$this->customerpanel_m->update_key($data,$where, 'customers_panel_subscription');
			//$this->customerpanel_m->insert('customers_panel_subscription', $data);
			redirect(BASE_URL.'customerpanel');
			
		} else {
			$this->data['sname'] = $plan_details['name'];
			$this->data['devices_allowed'] = $plan_details['devices_allowed'];
			$this->data['product_id'] = $plan_details['product_id'];
			$this->data['price'] = $plan_details['monthly_price'];
			$this->data['length_months'] = $plan_details['length_months'];
			$this->data['tag_title'] = $plan_details['tag_title'];
			$this->data['facility_content'] = $plan_details['facility_content'];
			$this->data['month_day'] = $plan_details['month_day'];
			$this->data['id'] = $plan_details['id'];
			//$this->data['gui_setting_id'] =  $plan_details['gui_setting_id'];
			//$this->data['product_group'] =  $plan_details['product_group'];
			//$this->data['rproducts'] =  explode(',',$plan_details['rproducts']);
			
		}
		
		/* GUI Settings*/		
        $this->data['settings']= $this->gui_settings_m->get();
		
		//$this->data['plan_details'] = $plan_details;
		$this->data['products']= $this->products_m->get();		
		$this->data['main_nav'] = 'customerPanel';
		$this->data['sub_nav'] = 'subscription_plans';
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'customerpanel/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'customerpanel/editplan';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function subscriptiongroup(){
		$this->data['is_allow']= check_permission(76);
		
		$this->data['page_title'] = "Customer Panel";
		/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

		$this->data['main_nav'] = 'customerPanel';
		$this->data['sub_nav'] = 'subscriptiongroup';
		
		if(isset($_REQUEST['subscription_group'])){ 
			$group_name = $this->input->post('group_name');
			$product_id = $this->input->post('product_id');
			$subscription_pans = $this->input->post('subscription_pans');
			$free_change = $this->input->post('free_change');
			//echo $free_change;exit;
					$data = array(	'group_name' => $group_name, 
								  	'product_id' => $product_id,
								  	'subscription_pans'=>implode(',',$subscription_pans),
								  	'free_change' => $free_change
							     );
			$this->customerpanel_m->insert('subscriptiongroup',$data);
			redirect(BASE_URL.'customerpanel/subscriptiongroup');
		}
		
		$this->data['customerpanel_m']= $this->customerpanel_m->getKeys();
		//$this->data['products']= $this->products_m->get();
		$get_allproducts = $this->products_m->get();
		$this->data['products']= $get_allproducts;
		/*echo '<pre>';
		print_r($get_allproducts);exit;*/
		foreach($get_allproducts as $key=>$val){
			$get_allproducts_array['id_'.$val['id']] = array('name' => $val['name'],
																'gui_setting_id' => $val['gui_setting_id']);
		}
		$this->data['products_array']= $get_allproducts_array;
		$this->load->model('gui_settings_m');
		  /* GUI Settings*/
        $gui_settings = $this->gui_settings_m->get();
		foreach($gui_settings as $key=>$val){
			$gui_settings_array['id_'.$val['id']] = $val['setting_name'];
		}
		$this->data['gui_settings_array']= $gui_settings_array;
		//echo '<pre>';
		//print_r($get_allproducts_array);
		//print_r($this->customerpanel_m->getKeys());exit;
		$group_dataall = $this->customerpanel_m->getdataall('subscriptiongroup', array('active' => '1'));
		$group_dataall_product_id = array();
		foreach($group_dataall as $key=>$val){
			array_push($group_dataall_product_id,$val['product_id']);
		}
		
		$this->data['group_dataall_product_id'] = $group_dataall_product_id;		
		$this->data['group_dataall'] = $group_dataall;
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'customerpanel/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'customerpanel/subscriptiongroup';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	
	public function subscriptiongroupedit($id){
		$this->data['is_allow']= check_permission(76);
		$this->data['page_title'] = "Customer Panel";
		/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
		$this->data['main_nav'] = 'customerPanel';
		$this->data['sub_nav'] = 'subscriptiongroup';
		$group_byid = $this->customerpanel_m->getdataall('subscriptiongroup', array('id' => $id));
		/*echo '<pre>';
		print_r($group_byid);exit;*/
		if(isset($_REQUEST['subscription_group'])){ 
			$group_name = $this->input->post('group_name');
			$product_id = $this->input->post('product_id');
			$subscription_pans = $this->input->post('subscription_pans');
			$free_change = $this->input->post('free_change');
			
			if(count($subscription_pans) > 0){
				$data = array('group_name' => $group_name, 
								'free_change' => $free_change,
								'subscription_pans'=>implode(',',$subscription_pans)
							);
			} else{
				$data = array('group_name' => $group_name, 
							'free_change' => $free_change
						);
			}
			//print_r($data);exit;
			$where = array('id'=>$id);
			$this->customerpanel_m->update_key($data,$where, 'subscriptiongroup');
			redirect(BASE_URL.'customerpanel/subscriptiongroup');
		}else{
			$this->data['group_name'] = $group_byid[0]['group_name'];
			$this->data['free_change'] = $group_byid[0]['free_change'];			
			$this->data['product_id'] = $group_byid[0]['product_id'];
			$this->data['subscription_pans'] = explode(',',$group_byid[0]['subscription_pans']);
		}
		
		$this->data['customerpanel_m']= $this->customerpanel_m->getKeys();
		//$this->data['products']= $this->products_m->get();
		$get_allproducts = $this->products_m->get();
		$this->data['products']= $get_allproducts;
		
		foreach($get_allproducts as $key=>$val){
			$get_allproducts_array['id_'.$val['id']] = array('name' => $val['name'],
																'gui_setting_id' => $val['gui_setting_id']);
		}
		$this->data['products_array']= $get_allproducts_array;
		$this->load->model('gui_settings_m');
		  /* GUI Settings*/
        $gui_settings = $this->gui_settings_m->get();
		foreach($gui_settings as $key=>$val){
			$gui_settings_array['id_'.$val['id']] = $val['setting_name'];
		}
		$this->data['gui_settings_array']= $gui_settings_array;
		$this->data['pid']= $id;
		
		$group_dataall = $this->customerpanel_m->getdataall('subscriptiongroup', array('active' => '1'));
		$group_dataall_product_id = array();
		foreach($group_dataall as $key=>$val){
			array_push($group_dataall_product_id,$val['product_id']);
		}
		//echo '<pre>';
		//print_r($get_allproducts_array);
		//print_r($this->customerpanel_m->getKeys());exit;
		$this->data['group_dataall_product_id'] = $group_dataall_product_id;	
		$this->data['group_dataall'] = $this->customerpanel_m->getdataall('subscriptiongroup', array('active' => '1'));
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'customerpanel/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'customerpanel/subscriptiongroupedit';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}

	public function subscriptiongroupdelete($id){
		$where = array('id'=>$id);
		$data = array('active'=>'0');
		$this->customerpanel_m->update_key($data,$where, 'subscriptiongroup');
		redirect(BASE_URL.'customerpanel/subscriptiongroup');
	}
	
	public function subscriptiongroupddisable($id){
		$where = array('id'=>$id);
		$data = array('status'=>'0');
		$this->customerpanel_m->update_key($data,$where, 'subscriptiongroup');
		redirect(BASE_URL.'customerpanel/subscriptiongroup');
	}
	
	public function subscriptiongroupdenable($id){
		$where = array('id'=>$id);
		$data = array('status'=>'1');
		$this->customerpanel_m->update_key($data,$where, 'subscriptiongroup');
		redirect(BASE_URL.'customerpanel/subscriptiongroup');
	}
	
	public function walletmoney(){
		$this->data['is_allow']= check_permission(64);
		$this->data['page_title'] = "Customer Panel";
		/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
		$wallet_cupons = $this->customerpanel_m->getallWaletKeys();
		$this->data['wallet_cupons'] = $wallet_cupons;
		if(isset($_REQUEST['walet_plans'])){ 
		 	for($i=1;$i<=$this->input->post('quantity');$i++){
                
                $length =$this->input->post('length')-strlen($this->input->post('prefix_code')); 
                $key = substr(str_shuffle("0123456789"), 0, $length);

                $final_key=$this->input->post('prefix_code').$key;
                $data = array(
							  'key_code '=>$final_key,
                              'price'=>$this->input->post('price')
                    );
                $this->customerpanel_m->insert('wallet_moneycode', $data);
				//
            }
			redirect(BASE_URL.'customerpanel/walletmoney');
		}
		$this->data['main_nav'] = 'customerPanel';
		$this->data['sub_nav'] = 'walletmoney';
		
		$this->data['_view'] = DEFAULT_THEME . 'customerpanel/walletmoney';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function deletewalletcode($id){
		$where = array('id' => $id);
		$data = array('active' => '0');
		$this->customerpanel_m->update_key($data,$where, 'wallet_moneycode');
		redirect(BASE_URL.'customerpanel/walletmoney');
	}
	
}