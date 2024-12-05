<?php defined('BASEPATH') OR exit('No direct script access allowed');
//For Resellers
class Resellers extends MY_Controller
//class Reseller extends User_Controller
{
	public $data = [];

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('reseller_m');
		
		$resellerid = $this->session->resellerid;
		$resellerInfo = $this->reseller_m->getReseller($resellerid);	
		/*echo '<pre>';
		print_r($resellerInfo);exit;	*/
		$this->data['resellerInfodash'] = $resellerInfo[0];
		
		$this->data['reseller_log'] = '';
		$log_text_array = $this->reseller_m->selectdatarow(array('reseller_id' => $this->session->resellerid),'reseller_history');
		if(count($log_text_array) > 0){
			$log_text_array_log = json_decode($log_text_array[0]['log_json'],true);
			//$log_text_array_log_keystatus = json_decode($log_text_array[0]['key_status_log'],true);
			$this->data['reseller_log'] = $log_text_array_log;
			//$this->data['key_status_log'] = $log_text_array_log_keystatus;
		}
	}
	
	public function index(){
		$this->userlog_in();
		$where = array('reseller_id'=>$this->session->resellerid);
		$resellerCustomer = $this->reseller_m->selectdatarow($where,'customers');
		$disabled_members = array();
		$active_members = array();
		$pending_members = array();
		$expired_members = array();
		foreach($resellerCustomer as $key=>$val){
			if($val['status'] == '0'){
				$disabled_members[] = $val;
			}elseif(($val['sebscription_trpe'] == '') && ($val['status'] == '1')){
				$pending_members[] = $val;
			}elseif(($val['subscription_expire'] != '0000-00-00 00:00:00') && ($val['status'] == '1')){
				$today = date("Y-m-d H:i:s");
				$diff_time=((strtotime($val['subscription_expire']) - strtotime($today)));
				if($diff_time>0){
					$active_members[] = $val;
				}else{
					$expired_members[] = $val;
				}
			}
		}
		/*echo '<pre>';
		print_r($resellerCustomer);exit;*/
		$this->data['disabled_members'] = $disabled_members;
		$this->data['pending_members'] = $pending_members;
		$this->data['active_members'] = $active_members;
		$this->data['expired_members'] = $expired_members;
		
		$this->data['active_tab'] = 'dashboard';
		$this->data['active_menu'] = 'default';
		//$this->data['resellerInfodash'] = $resellerInfo[0];
		$this->data['_view'] = CUSTOMER_THEME . 'resellers/index';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);
	}
	
	public function login(){
		// Clear any existing reseller session data before doing anything else
    	$this->session->unset_userdata(['resellerid', 'resellername', 'reselleremail', 'status', 'plan_type', 'islogin']);

		$this->userlog_in();
		//echo $this->router->method;exit;		
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('identity', 'User Name', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->data['message'] = '';
		if(isset($_REQUEST['sign_in_submit'])){
			$identity = $this->input->post('identity');
			$password = $this->input->post('password');
			if ($this->form_validation->run() == FALSE){
				$this->data['message'] = 'error';
				$this->data['identity'] = $identity;
				$this->data['password'] = $password;
			}else{
				$reseller_info = $this->reseller_m->getAll_email(trim($identity));
				//echo '<pre>';
				//print_r($reseller_info);exit();
				if($reseller_info[0]['password'] == base64_encode(trim($password))){
					$sesdata = array('resellerid' => $reseller_info[0]['id'],
										'resellername' => $reseller_info[0]['name'],
											'reselleremail' => $reseller_info[0]['email'] ,
												'status' => $reseller_info[0]['status'],
                                                 'plan_type' => $reseller_info[0]['plan_type'], 
												  'islogin' => '1');
					$this->session->set_userdata($sesdata);
					//$this->session->set_flashdata('message', $this->ion_customer_auth->messages());
					redirect(BASE_URL.'resellers/profile');
				}else{					
					$this->session->set_flashdata('message_set', 'Username/Password does not match!');
					redirect(BASE_URL.'resellers/login');							
				}
				//print_r($reseller_info);exit;
			}	
		}
		$this->data['_view'] = CUSTOMER_THEME . 'resellers/login';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_before',$this->data);
	}
	
	public function customerslist(){
		//$this->userlog_in();
		$this->data['active_tab'] = 'customers';
		$this->data['active_menu'] = 'customerslist';
		$where = array('reseller_id'=>$this->session->resellerid);		
		//$this->data['customers']= $this->reseller_m->selectdatarow($where,'customers');

		$this->data['customers']= $this->reseller_m->customerdata($this->session->resellerid); 
		
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'resellers/_extra_scripts';
		$this->data['_view'] = CUSTOMER_THEME . 'resellers/customerslist';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
	}
	
	public function editcustomermsg(){
		$resellerid = $this->session->resellerid;
		$resellerInfo = $this->reseller_m->getReseller($resellerid);	
		if($resellerInfo[0]['reseller_msgedit'] == '0'){
			redirect(BASE_URL.'resellers');
		}
		
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('messageto_customer', 'Message To Customer', 'trim|required');	
		$this->data['message'] = '';
		if(isset($_REQUEST['create_msg'])){
			$messageto_customer = $this->input->post('messageto_customer');
			if ($this->form_validation->run() == FALSE){
				$this->data['message'] = 'error';	
				$this->data['messageto_customer'] = $messageto_customer;				
			}else{
				$dataUpdate = array('messageto_customer_reseller'=>$messageto_customer);
				$whereUpdate = array('id'=>$this->session->resellerid);
				$this->reseller_m->update_keycode($dataUpdate,$whereUpdate,'reseller');
				redirect(BASE_URL.'resellers/editcustomermsg');
			}
		}else{
			$this->data['messageto_customer'] = $resellerInfo[0]['messageto_customer_reseller'];
		}
		
		$this->data['active_tab'] = 'customers';
		$this->data['active_menu'] = 'editcustomermsg';
		//messageto_customer_reseller
		$this->data['_view'] = CUSTOMER_THEME . 'resellers/editcustomermsg';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
	}

	public function viewcustomer($id){     
		
		$planinfo = $this->reseller_m->selectplankey($id);

		$this->data['planinfo']= $planinfo;
		$this->data['active_tab'] = 'customers';
		$this->data['active_menu'] = 'editcustomermsg';
		//messageto_customer_reseller
		$this->data['_view'] = CUSTOMER_THEME . 'resellers/viewplankey';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
	}

	public function profile(){
		
		$resellerid = $this->session->resellerid;
		//echo $resellerid;
		$resellerInfo = $this->reseller_m->getReseller($resellerid);	
		/*echo '<pre>';
		print_r($resellerInfo);exit;	*/
		$this->data['info'] = $resellerInfo[0];
		//messageto_customer_reseller
		$this->data['_view'] = CUSTOMER_THEME . 'resellers/profile';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
	}
	
	public function resellerplan(){
		$this->data['active_tab'] = 'subscription_code';
		$this->data['active_menu'] = 'resellerplan';
						
		$reseller_plans = $this->reseller_m->getAllActivePlans('reseller_panel_subscription');
		
		foreach($reseller_plans as $key=>$val){
			$reseller_plansArray['id_'.$val['id']] = $val;
		}
		$this->data['reseller_plansArray']= $reseller_plansArray;
		
		$getwhere = array('reseller_id' => $this->session->resellerid);
		$selected_plans_list = $this->reseller_m->selectdatarow($getwhere, 'reseller_details');
		
		$selected_plansarray = array();
		foreach($selected_plans_list as $key=>$val){
			$selected_plansarray[] = $val['product_plans'];
		}
		$this->data['selected_plans']= $selected_plansarray;
		$this->data['selected_plans_list']= $selected_plans_list;
		
		$this->load->model('products_m');
		$product_details = $this->products_m->get();
		foreach($product_details as $val){
			$products_list['products_'.$val['id']] = $val['name'];
		}
		$this->data['products_list']= $products_list;
		$this->data['products']= $product_details;
		
		$where = array('reseller_id'=>$this->session->resellerid);		
		$this->data['customers']= $this->reseller_m->selectdatarow($where,'customers');
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'resellers/_extra_scripts';
		$this->data['_view'] = CUSTOMER_THEME . 'resellers/customersplans';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
	}
	
	public function walletpayment(){
		$this->data['active_tab'] = 'account';
		$this->data['active_menu'] = 'walletpayment';
		//$this->data['payment_rows'] = $this->reseller_m->getAllRows('reseller_wallet','id');
		$where = array('reseller_id'=>$this->session->resellerid);
		$this->data['payment_rows'] = $this->reseller_m->getAllRowsWhere('reseller_wallet','id',$where);
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'resellers/_extra_scripts';
		$this->data['_view'] = CUSTOMER_THEME . 'resellers/walletpayment';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
	}
	
	public function rechargewallet(){
		if(isset($_REQUEST['activation_code'])){ 
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->form_validation->set_rules('key_code', 'Wallet Code', 'trim|required');
			if ($this->form_validation->run() == FALSE){				
			 	$this->data['message'] = 'error';			
			} else{
				 $key_code = trim($this->input->post('key_code'));
				 //$this->load->model('customerpanel_m');				
				 $getkeyDetails = $this->reseller_m->getAllCodeWhere('reseller_wallet_moneycode', array('key_code' => $key_code));
				 $info = $this->reseller_m->getAllRowsWhere('reseller','id',array('id' => $this->session->resellerid));
				 if(count($getkeyDetails) > 0){
				
					  if($getkeyDetails[0]['used'] == '0'){ 
					    	if($getkeyDetails[0]['currency_type'] == $info[0]['currency_type']){ 
								$data = array('used' => '1', 'used_by'=>$this->session->resellerid);
								$where = array('key_code' => $key_code , 'active' => '1', 'used' => '0');
								$res = $this->reseller_m->update_keycode($data,$where, 'reseller_wallet_moneycode');
								
								if($res){
									/*echo '<pre>';
									print_r($getkeyDetails);
									print_r($info);
									exit;*/
								
									$walletbalance = $info[0]['wallet_money']+$getkeyDetails[0]['price'];
									$data_reseller = array('wallet_money'=>$walletbalance);
									$where_reseller = array('id' => $this->session->resellerid);
									$this->reseller_m->update_keycode($data_reseller,$where_reseller, 'reseller');
									
									
									// log of wallet 
									//=====================================================================================================
									/*
									
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
									 
									 */
									$this->session->set_flashdata('message_set',"Recharge Success");
									$this->session->set_flashdata('message_success',"success");
									redirect(BASE_URL.'resellers/rechargewallet');
								}
							}else {
									$this->session->set_flashdata('message_set',"Invalid Key");
									redirect(BASE_URL.'resellers/rechargewallet');
							}
						 
					  } else {
							$this->session->set_flashdata('message_set',"Key Already Used");
							redirect(BASE_URL.'resellers/rechargewallet');
					  }
				  } else {
				  		$this->session->set_flashdata('message_set',"Invalid Key");
						redirect(BASE_URL.'resellers/rechargewallet');
				  }
			}	
			$this->data['key_code'] = $this->input->post('key_code');
		}
		$this->data['active_tab'] = 'account';
		$this->data['active_menu'] = 'rechargewallet';
		//$this->data['payment_rows'] = $this->reseller_m->getAllRows('reseller_wallet','id');
		//$where = array('reseller_id'=>$this->session->resellerid);
		//$this->data['payment_rows'] = $this->reseller_m->getAllRowsWhere('reseller_wallet','id',$where);
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'resellers/_extra_scripts';
		$this->data['_view'] = CUSTOMER_THEME . 'resellers/rechargewallet';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
	}
	
	public function deletecustomer(){
		$customer_id = $_REQUEST['customer_id'];
		/*echo $customer_id;*/
		$where = array('id' => $customer_id);
		if($this->reseller_m->deletedatarow($where,'customers')){
			echo 'success';
		} else{
			echo 'failure';
		}
		//redirect(BASE_URL.'resellers/customerslist');
	}
	
	public function deleteunusedkey($keyId){

		$where_keycode = array('id' => $keyId);
		$key_details = $this->reseller_m->selectdatarow($where_keycode,'subscription_renewal_keys');

		$dealerPrice=$key_details[0]['dealer_price'];   //get deleler amount 
		 
		if($this->reseller_m->updateWaletAmount($dealerPrice,$key_details[0]['reseller_id'])){ 
         
			$where = array('id' => $keyId);
			if($this->reseller_m->deletedatarow($where,'subscription_renewal_keys')){
				$this->session->set_flashdata('message_set',"yes");
				$this->session->set_flashdata('success',"Great, Code has been removed.");
				//redirect(BASE_URL.'resellers/masterkeys');
				$this->load->library('user_agent'); 
                redirect($this->agent->referrer());
			} else{
				echo 'failure';
			}
		} else{
			echo 'failure';
		}
		
	}
	public function deletekeycode(){
		$code_id = $_REQUEST['code_id'];
		/*echo $customer_id;*/
		$where = array('id' => $code_id);
		$data = array('disabled' => '1');
		if($this->reseller_m->update_keycode($data,$where,'subscription_renewal_keys')){
			echo 'success';
		} else{
			echo 'failure';
		}
		
	}
	
	public function disablekeycode(){
		$code_id = $_REQUEST['id'];
		$reseller_msg =$_REQUEST['msg'];
		$change_type = $_REQUEST['change_type'];
		
		$where_keycode = array('id' => $code_id, 'used'=>'0');
		$key_details = $this->reseller_m->selectdatarow($where_keycode,'subscription_renewal_keys');
		
		if($change_type == '0'){
			$key_status = 'Enable';
		}else{
			$key_status = 'Disable';
		}
		
				
		
		if(count($key_details) > 0){
			$where = array('id' => $code_id);
			$data = array('disabled' => $change_type);
			if($this->reseller_m->update_keycode($data,$where,'subscription_renewal_keys')){
				//$reseller_id = $key_details[0]['reseller_id'];
				//$return_price = $key_details[0]['monthly_price'];
				
				//$where_reseller = array('id' => $reseller_id);
				//$reseller_details = $this->reseller_m->selectdatarow($where_reseller,'reseller');
				
				//$wallet_money = $reseller_details[0]['wallet_money'] + $return_price;
				//$data_reseller = array('wallet_money' => $wallet_money);
				//$this->reseller_m->update_keycode($data_reseller,$where_reseller,'reseller');
				$log_text_array = $this->reseller_m->selectdatarow(array('reseller_id' => $this->session->resellerid),'reseller_history');	
				
				
				$log_array = array();
				$data_keystatuslog = array('keycode'=>$key_details[0]['keycode'],
												'key_status' => $key_status,									 
												  'group_name'=>$key_details[0]['group_name'],									 							 
												  'date_status'=>date('Y-m-d H:i:s'),
												  'reseller_msg' => $reseller_msg
											);
							
				if($log_text_array[0]['key_status_log'] != ''){
					$log_text_array_log = json_decode($log_text_array[0]['key_status_log'],true);
					//$log_text_array_log = json_decode($log_text_array[0]['log_json'],true);	
								//print_r($log_text_array_log);
								 //$log_array[] = $data;
								 array_push($log_array,$data_keystatuslog);
								// print_r($log_text_array_log);
								 foreach($log_text_array_log as $key=>$val){ //print_r($val);
									 //$log_array[] = $val;
									 array_push($log_array,$val);
								 }
								 
					//exit;	
				} else{
					array_push($log_array,$data_keystatuslog);
					
					//exit;
				}
				
				$log_text = json_encode($log_array);																	 
				$log_data = array('key_status_log' => $log_text);
				$this->reseller_m->update_keycode($log_data,array('reseller_id' => $this->session->resellerid), 'reseller_history');
				
				
				$msg_subs_array = array();
				array_push($msg_subs_array,array('msg' => $reseller_msg,
													'key_status' => $key_status, 							 
												  		'date_status'=>date('Y-m-d H:i:s')));
														
				$message_array = $this->reseller_m->selectdatarow(array('id' => $code_id),'subscription_renewal_keys');	
				
				if($message_array[0]['reseller_msg'] != ''){
					$message = json_decode($message_array[0]['reseller_msg'],true);
					foreach($message as $key=>$val){
						array_push($msg_subs_array,$val);
					}
				}
				$this->reseller_m->update_keycode(array('reseller_msg' => json_encode($msg_subs_array)),array('id' => $code_id),'subscription_renewal_keys');	
				//exit;
				echo 'success';
			} else{
				echo 'failure';
			}
		} else{
			echo 'failure';
		}
		
	}
	
	public function disablewaletkeycode(){
		$code_id = $_REQUEST['id'];
		$reseller_msg =$_REQUEST['msg'];
		$change_type = $_REQUEST['change_type'];
		
		$where_keycode = array('id' => $code_id, 'used'=>'0');
		$key_details = $this->reseller_m->selectdatarow($where_keycode,'wallet_moneycode');
		
		if($change_type == '0'){
			$key_status = 'Enable';
		}else{
			$key_status = 'Disable';
		}
		
				
		
		if(count($key_details) > 0){
			$where = array('id' => $code_id);
			$data = array('disabled' => $change_type);
			if($this->reseller_m->update_keycode($data,$where,'wallet_moneycode')){		
				
				$msg_subs_array = array();
				array_push($msg_subs_array,array('msg' => $reseller_msg,
													'key_status' => $key_status, 							 
												  		'date_status'=>date('Y-m-d H:i:s')));
														
				$message_array = $this->reseller_m->selectdatarow(array('id' => $code_id),'wallet_moneycode');	
				
				if($message_array[0]['reseller_msg'] != ''){
					$message = json_decode($message_array[0]['reseller_msg'],true);
					foreach($message as $key=>$val){
						array_push($msg_subs_array,$val);
					}
				}
				$this->reseller_m->update_keycode(array('reseller_msg' => json_encode($msg_subs_array)),array('id' => $code_id),'wallet_moneycode');
				
				
				//exit;
				echo 'success';
			} else{
				echo 'failure';
			}
		} else{
			echo 'failure';
		}
		
	}
	
	public function messagehistorywallet(){
		$id = $_REQUEST['id'];		
		$getwhere = array('id' => $id);
		$getdatarow = $this->reseller_m->selectdatarow($getwhere, 'wallet_moneycode');
		//print_r($getdatarow);
		$message = json_decode($getdatarow[0]['reseller_msg'],true);
		
		echo '<div style="border-bottom: 2px solid #ccc; height:20px;">'
					.'<div style="width:60%;float:left;">Message</div>'
					.'<div style="width:30%;float:left;">Created Date</div>'
					.'<div style="width:10%;float:left;">Status</div>'.
				 '</div>';
		foreach($message as $key=>$val){
			echo '<div style="border-bottom: 1px dotted #ccc;height:50px;">'
					.'<div style="width:60%;float:left;">'.$val['msg'].'</div>'
					.'<div style="width:30%;float:left;">'.date("M j, Y, g:i a", strtotime($val['date_status'])).'</div>'
					.'<div style="width:10%;float:left;">'.$val['key_status'].'</div>'.
				 '</div>';
		}
	}
	
	public function messagehistory(){
		$id = $_REQUEST['id'];		
		$getwhere = array('id' => $id);
		$getdatarow = $this->reseller_m->selectdatarow($getwhere, 'subscription_renewal_keys');
		//print_r($getdatarow);
		$message = json_decode($getdatarow[0]['reseller_msg'],true);
		
		echo '<div style="border-bottom: 2px solid #ccc; height:20px;">'
					.'<div style="width:60%;float:left;">Message</div>'
					.'<div style="width:30%;float:left;">Created Date</div>'
					.'<div style="width:10%;float:left;">Status</div>'.
				 '</div>';
		foreach($message as $key=>$val){
			echo '<div style="border-bottom: 1px dotted #ccc;height:50px;">'
					.'<div style="width:60%;float:left;">'.$val['msg'].'</div>'
					.'<div style="width:30%;float:left;">'.date("M j, Y, g:i a", strtotime($val['date_status'])).'</div>'
					.'<div style="width:10%;float:left;">'.$val['key_status'].'</div>'.
				 '</div>';
		}
	}
	
	public function masterkeys(){
		$getResellerInfo = $this->reseller_m->getReseller($this->session->resellerid);
		$getwhere = array('reseller_id' => $this->session->resellerid,'plan_type'=>'master');
		$selected_plans_list = $this->reseller_m->selectdatarow($getwhere, 'reseller_details');
		
		//echo '<pre>';
		//echo '<br>=======================================================================<br>';
		//echo '<br>=======================================================================<br>';

		//echo '<br>1- selected_plans_list (reseller_details)<br>';
		//print_r($selected_plans_list);
		//echo '<br>------------------------------------------------------------------------------<br>';
		$selected_plansarray = array();
		foreach($selected_plans_list as $key=>$val){
			$selected_plansarray[] = $val['product_plans'];
		}
		//echo '<br>2- selected_plansarray (Filter)<br>';
		//print_r($selected_plansarray);

		$this->data['selected_plans']= $selected_plansarray;
		$this->data['selected_plans_list']= $selected_plans_list;
		

		//echo '<br>=======================================================================<br>';
		//echo '<br>=======================================================================<br>';
		$this->load->model('products_m');
		$product_details = $this->products_m->get();

		//echo '<br>3- products (products)<br>';
		//print_r($product_details);
		//echo '<br>------------------------------------------------------------------------------<br>';
		foreach($product_details as $val){
			$products_list['products_'.$val['id']] = $val['name'];
		}
		
		//echo '<br>4- products_list (Filter)<br>';
		//print_r($products_list);

		$this->data['products_list']= $products_list;
		$this->data['products']= $product_details;


		//echo '<br>=======================================================================<br>';
		//echo '<br>=======================================================================<br>';		
		
		$reseller_plans = $this->reseller_m->getAllActivePlans('reseller_panel_subscription');
		
		//echo '<br>5- reseller_plans (reseller_panel_subscription)<br>';	
		//print_r($reseller_plans);	

		foreach($reseller_plans as $key=>$val){
			$reseller_plansArray['id_'.$val['id']] = $val;
		}
		//echo '<br>------------------------------------------------------------------------------<br>';
		//echo '<br><b>6- reseller_plansArray (Filter)</b><br>';	
		//print_r($reseller_plansArray);

		$this->data['reseller_plansArray']= $reseller_plansArray;


		
		$this->load->library('form_validation');
		$this->data['message'] = '';
		
		 if(isset($_REQUEST['create_code'])){ 		 	
		 	$this->form_validation->set_rules('plan_id', 'Plan', 'trim|required');
			$this->form_validation->set_rules('number_codes', 'Number Codes', 'trim|required|greater_than[0]');
			
			$plan_id = $this->input->post('plan_id');
			$number_codes = $this->input->post('number_codes');
			
			 if ($this->form_validation->run() == FALSE){
			 	$this->data['message'] = 'error';
				$this->data['plan_id'] = $plan_id;
				$this->data['number_codes'] = $number_codes;
			}else{
				// create subscription keys 
				$reseller_plan_codedetails = $this->reseller_m->reseller_plan_code($plan_id);
				$dealer_price_total = $reseller_plan_codedetails[0]['dealer_price']*$number_codes;
				$walet_deduct_money = 0;
				
				//echo '<pre>';			 
				if($getResellerInfo[0]['wallet_money'] >= $dealer_price_total){
					for($i=1;$i<=$number_codes;$i++){		
						$final_key = substr(str_shuffle("0123456789abcdefghijklmmnopqrstuvwxyz"), 0, 10);					
						$data = array('keycode'=>$final_key,
									  //'group_unic_code' => $group_unic,
									  'group_name'=>$reseller_plan_codedetails[0]['name'],
									  'product_id'=>$reseller_plan_codedetails[0]['product_id'],
									  'plan_id'=>$reseller_plan_codedetails[0]['plan_id'],
									  'devices_allowed'=>$reseller_plan_codedetails[0]['devices_allowed'],
									  'length_months'=>$reseller_plan_codedetails[0]['length_months'],
									  'month_day' => $reseller_plan_codedetails[0]['month_day'],
									 /* 'monthly_price' => $reseller_plan_codedetails[0]['dealer_price'],*/									 
									  'monthly_price' => $reseller_plan_codedetails[0]['monthly_price'],
									  'reseller_id' => $reseller_plan_codedetails[0]['reseller_id'],
									  'reseller_plan_id' => $reseller_plan_codedetails[0]['id'],
									   'activation_price' => $reseller_plan_codedetails[0]['activation_price'],
									   'dealer_price' => $reseller_plan_codedetails[0]['dealer_price'],
									  'key_type' => 'master',
									  'date_created'=>date('Y-m-d H:i:s')
							);
						//print_r($data);
						if($this->reseller_m->insertkeys($data,'subscription_renewal_keys')){
							$walet_deduct_money+=$reseller_plan_codedetails[0]['dealer_price'];
							// Get Reseller Log Json
							$log_text_array = $this->reseller_m->selectdatarow(array('reseller_id' => $this->session->resellerid),'reseller_history');
							//echo '<pre>';
							$log_array = array();
							$log_array_activate = array();
							if(count($log_text_array) > 0){
								 $log_text_array_log = json_decode($log_text_array[0]['log_json'],true);	
								//print_r($log_text_array_log);
								 //$log_array[] = $data;
								 array_push($log_array,$data);
								// print_r($log_text_array_log);
								 foreach($log_text_array_log['key_code'] as $key=>$val){ //print_r($val);
									 //$log_array[] = $val;
									 array_push($log_array,$val);
								 }
								 
								 foreach($log_text_array_log['user_activate'] as $key1=>$val1){ //print_r($val);
										 array_push($log_array_activate,$val1);
								 }
								//$log_text_reseller = json_encode(array('user_activate' =>$log_array_activate));
					 							 			 	
								$log_text = json_encode(array('key_code' =>$log_array, 'user_activate' =>$log_array_activate));
																		 
								$log_data = array('reseller_id' => $this->session->resellerid, 'log_json' => $log_text);
								$this->reseller_m->update_keycode($log_data,array('reseller_id' => $this->session->resellerid), 'reseller_history');
								// echo $log_text;exit;
								//print_r(array('key_code' =>$log_array));
									
							}else{		
								$log_array['key_code'][0] = $data;			 					 
								$log_data = array('reseller_id' => $this->session->resellerid, 'log_json' => json_encode($log_array));					
								$this->reseller_m->insertkeys($log_data,'reseller_history');
							}
				
				
						}
						//$this->subscription_renewal_keys_m->save(NULL,$data);
					}
					
					//exit;
					//echo $walet_deduct_money ;
					if($walet_deduct_money > 0){
						$walet_money = $getResellerInfo[0]['wallet_money'] - $walet_deduct_money;
						$dataUpdate = array('wallet_money'=>$walet_money);
						$whereUpdate = array('id'=>$this->session->resellerid);
						$this->reseller_m->update_keycode($dataUpdate,$whereUpdate,'reseller');
					
					}
					//exit;
					
					$this->session->set_flashdata('message_set',"yes");
					$this->session->set_flashdata('success',"Great, your following codes or code has been generated.");
				} else{
					$this->session->set_flashdata('message_set',"yes");
					$this->session->set_flashdata('error',"There is Not Enough Wallet Money");
				}
				redirect(BASE_URL.'resellers/masterkeys');
            }
            /*$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('keys').'" target="_blank">Keys Created</a>');   
            $this->session->set_flashdata('success',"Keys Created Successfully.");
           */
        }

		$whereSelect = array('reseller_id'=>$this->session->resellerid,  'key_type' => 'master');
		//$resellerKeycode = $this->reseller_m->selectdatarow($whereSelect, 'subscription_renewal_keys');
		$resellerKeycode = $this->reseller_m->selectSubscriptionCode($this->session->resellerid,'master');
		$this->data['resellerKeycode'] = $resellerKeycode;

		//echo '<br>=======================================================================<br>';
		//echo '<br>=======================================================================<br>';
		
		//echo '<br><b>7- resellerKeycode (subscription_renewal_keys)</b><br>';	
		//print_r($resellerKeycode);


		$this->data['resellerInfo'] = $getResellerInfo[0];
		$this->data['active_tab'] = 'subscription_code';
		$this->data['active_menu'] = 'masterkeys';
		
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'resellers/_extra_scripts';
		$this->data['_view'] = CUSTOMER_THEME . 'resellers/masterkeys';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
	}
	
	public function subscriptionkeys(){
		$getResellerInfo = $this->reseller_m->getReseller($this->session->resellerid);
		$getwhere = array('reseller_id' => $this->session->resellerid,'plan_type'=>'renewal');
		$selected_plans_list = $this->reseller_m->selectdatarow($getwhere, 'reseller_details');
		
		$selected_plansarray = array();
		foreach($selected_plans_list as $key=>$val){
			$selected_plansarray[] = $val['product_plans'];
		}
		$this->data['selected_plans']= $selected_plansarray;
		$this->data['selected_plans_list']= $selected_plans_list;
		
		$this->load->model('products_m');
		$product_details = $this->products_m->get();
		foreach($product_details as $val){
			$products_list['products_'.$val['id']] = $val['name'];
		}
		$this->data['products_list']= $products_list;
		$this->data['products']= $product_details;
		
		
		
		$reseller_plans = $this->reseller_m->getAllActivePlans('reseller_panel_subscription');		
		foreach($reseller_plans as $key=>$val){
			$reseller_plansArray['id_'.$val['id']] = $val;
		}
		$this->data['reseller_plansArray']= $reseller_plansArray;
		
		$this->load->library('form_validation');
		$this->data['message'] = '';
		 if(isset($_REQUEST['create_code'])){ 		 	
		 	$this->form_validation->set_rules('plan_id', 'Plan', 'trim|required');
			$this->form_validation->set_rules('number_codes', 'Number Codes', 'trim|required|greater_than[0]');
			
			$plan_id = $this->input->post('plan_id');
			$number_codes = $this->input->post('number_codes');
			
			 if ($this->form_validation->run() == FALSE){
			 	$this->data['message'] = 'error';
				$this->data['plan_id'] = $plan_id;
				$this->data['number_codes'] = $number_codes;
			}else{
				// create subscription keys 
				$reseller_plan_codedetails = $this->reseller_m->reseller_plan_code($plan_id);
				$dealer_price_total = $reseller_plan_codedetails[0]['dealer_price']*$number_codes;
				$walet_deduct_money = 0;
				
				
				//echo '<pre>';			 
				if($getResellerInfo[0]['wallet_money'] >= $dealer_price_total){
					for($i=1;$i<=$number_codes;$i++){		
						$final_key = substr(str_shuffle("0123456789abcdefghijklmmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);					
						$data = array('keycode'=>$final_key,
									  //'group_unic_code' => $group_unic,
									  'group_name'=>$reseller_plan_codedetails[0]['name'],
									  'product_id'=>$reseller_plan_codedetails[0]['product_id'],
									  'devices_allowed'=>$reseller_plan_codedetails[0]['devices_allowed'],
									  'length_months'=>$reseller_plan_codedetails[0]['length_months'],
									  'month_day' => $reseller_plan_codedetails[0]['month_day'],
									 /* 'monthly_price' => $reseller_plan_codedetails[0]['dealer_price'],*/
									  'monthly_price' => $reseller_plan_codedetails[0]['monthly_price'],
									  'reseller_id' => $reseller_plan_codedetails[0]['reseller_id'],
									  'key_type' => 'subscribe',
									  'date_created'=>date('Y-m-d H:i:s')
							);
						//print_r($data);
						if($this->reseller_m->insertkeys($data,'subscription_renewal_keys')){
							$walet_deduct_money+=$reseller_plan_codedetails[0]['dealer_price'];
							// Get Reseller Log Json
							$log_text_array = $this->reseller_m->selectdatarow(array('reseller_id' => $this->session->resellerid),'reseller_history');
							//echo '<pre>';
							$log_array = array();
							$log_array_activate = array();
							if(count($log_text_array) > 0){
								 $log_text_array_log = json_decode($log_text_array[0]['log_json'],true);	
								//print_r($log_text_array_log);
								 //$log_array[] = $data;
								 array_push($log_array,$data);
								// print_r($log_text_array_log);
								 foreach($log_text_array_log['key_code'] as $key=>$val){ //print_r($val);
									 //$log_array[] = $val;
									 array_push($log_array,$val);
								 }
								 
								 foreach($log_text_array_log['user_activate'] as $key1=>$val1){ //print_r($val);
										 array_push($log_array_activate,$val1);
								 }
								//$log_text_reseller = json_encode(array('user_activate' =>$log_array_activate));
					 							 			 	
								$log_text = json_encode(array('key_code' =>$log_array, 'user_activate' =>$log_array_activate));
																		 
								$log_data = array('reseller_id' => $this->session->resellerid, 'log_json' => $log_text);
								$this->reseller_m->update_keycode($log_data,array('reseller_id' => $this->session->resellerid), 'reseller_history');
								// echo $log_text;exit;
								//print_r(array('key_code' =>$log_array));
									
							}else{		
								$log_array['key_code'][0] = $data;			 					 
								$log_data = array('reseller_id' => $this->session->resellerid, 'log_json' => json_encode($log_array));					
								$this->reseller_m->insertkeys($log_data,'reseller_history');
							}
				
				
						}
						//$this->subscription_renewal_keys_m->save(NULL,$data);
					}
					
					//exit;
					//echo $walet_deduct_money ;
					if($walet_deduct_money > 0){
						$walet_money = $getResellerInfo[0]['wallet_money'] - $walet_deduct_money;
						$dataUpdate = array('wallet_money'=>$walet_money);
						$whereUpdate = array('id'=>$this->session->resellerid);
						$this->reseller_m->update_keycode($dataUpdate,$whereUpdate,'reseller');
					
					}
					//exit;
					
					$this->session->set_flashdata('message_set',"yes");
					$this->session->set_flashdata('success',"Create Key Successfully.");
				} else{
					$this->session->set_flashdata('message_set',"yes");
					$this->session->set_flashdata('error',"There is Not Enough Wallet Money");
				}
				redirect(BASE_URL.'resellers/subscriptionkeys');
            }
            /*$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('keys').'" target="_blank">Keys Created</a>');   
            $this->session->set_flashdata('success',"Keys Created Successfully.");
           */
        }
		$whereSelect = array('reseller_id'=>$this->session->resellerid, 'key_type' => 'subscribe');
		$resellerKeycode = $this->reseller_m->selectdatarow($whereSelect, 'subscription_renewal_keys');
		$this->data['resellerKeycode'] = $resellerKeycode;
		$this->data['resellerInfo'] = $getResellerInfo[0];
		$this->data['active_tab'] = 'subscription_code';
		$this->data['active_menu'] = 'subscriptionkeys';
		
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'resellers/_extra_scripts';
		$this->data['_view'] = CUSTOMER_THEME . 'resellers/subscriptionkeys';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
	}
	
	public function activationkeys(){
		$getResellerInfo = $this->reseller_m->getReseller($this->session->resellerid);
		$getwhere = array('reseller_id' => $this->session->resellerid,'plan_type'=>'activation');
		$selected_plans_list = $this->reseller_m->selectdatarow($getwhere, 'reseller_details');
		
		$selected_plansarray = array();
		foreach($selected_plans_list as $key=>$val){
			$selected_plansarray[] = $val['product_plans'];
		}
		$this->data['selected_plans']= $selected_plansarray;
		$this->data['selected_plans_list']= $selected_plans_list;
		
		$this->load->model('products_m');
		$product_details = $this->products_m->get();
		foreach($product_details as $val){
			$products_list['products_'.$val['id']] = $val['name'];
		}
		$this->data['products_list']= $products_list;
		$this->data['products']= $product_details;
		
		
		
		$reseller_plans = $this->reseller_m->getAllActivePlans('reseller_panel_subscription');		
		foreach($reseller_plans as $key=>$val){
			$reseller_plansArray['id_'.$val['id']] = $val;
		}
		$this->data['reseller_plansArray']= $reseller_plansArray;
		
		$this->load->library('form_validation');
		$this->data['message'] = '';
		 if(isset($_REQUEST['create_code'])){ 		 	
		 	$this->form_validation->set_rules('plan_id', 'Plan', 'trim|required');
			$this->form_validation->set_rules('number_codes', 'Number Codes', 'trim|required|greater_than[0]');
			
			$plan_id = $this->input->post('plan_id');
			$number_codes = $this->input->post('number_codes');
			
			 if ($this->form_validation->run() == FALSE){
			 	$this->data['message'] = 'error';
				$this->data['plan_id'] = $plan_id;
				$this->data['number_codes'] = $number_codes;
			}else{
				// create subscription keys 
				$reseller_plan_codedetails = $this->reseller_m->reseller_plan_code($plan_id);
				$dealer_price_total = $reseller_plan_codedetails[0]['dealer_price']*$number_codes;
				$walet_deduct_money = 0;
				
				/*echo '<pre>';	
				print_r($reseller_plan_codedetails);exit;*/		 
				if($getResellerInfo[0]['wallet_money'] >= $dealer_price_total){
					for($i=1;$i<=$number_codes;$i++){		
					 				
						$final_key = substr(str_shuffle("0123456789abcdefghijklmmnopqrstuvwxyz"), 0, 10);
						$data = array('keycode'=>$final_key,
									  //'group_unic_code' => $group_unic,
									  'group_name'=>$reseller_plan_codedetails[0]['name'],
									  'product_id'=>$reseller_plan_codedetails[0]['product_id'],
									  'devices_allowed'=>$reseller_plan_codedetails[0]['devices_allowed'],
									  'length_months'=>$reseller_plan_codedetails[0]['length_months'],
									  'month_day' => $reseller_plan_codedetails[0]['month_day'],
									 /*'monthly_price' => $reseller_plan_codedetails[0]['dealer_price'],*/
									  'monthly_price' => $reseller_plan_codedetails[0]['monthly_price'],
									  'reseller_id' => $reseller_plan_codedetails[0]['reseller_id'],
									  'activation_price' => $reseller_plan_codedetails[0]['activation_price'],
									  'dealer_price' => $reseller_plan_codedetails[0]['dealer_price'],
									  'key_type' => 'activation',
									  'date_created'=>date('Y-m-d H:i:s')
							);
						//print_r($data);exit;
						if($this->reseller_m->insertkeys($data,'subscription_renewal_keys')){
							$walet_deduct_money+=$reseller_plan_codedetails[0]['dealer_price'];
							// Get Reseller Log Json
							$log_text_array = $this->reseller_m->selectdatarow(array('reseller_id' => $this->session->resellerid),'reseller_history');
							//echo '<pre>';
							$log_array = array();
							$log_array_activate = array();
							if(count($log_text_array) > 0){
								 $log_text_array_log = json_decode($log_text_array[0]['log_json'],true);	
								//print_r($log_text_array_log);
								 //$log_array[] = $data;
								 array_push($log_array,$data);
								// print_r($log_text_array_log);
								 foreach($log_text_array_log['key_code'] as $key=>$val){ //print_r($val);
									 //$log_array[] = $val;
									 array_push($log_array,$val);
								 }
								 
								 foreach($log_text_array_log['user_activate'] as $key1=>$val1){ //print_r($val);
										 array_push($log_array_activate,$val1);
								 }
								//$log_text_reseller = json_encode(array('user_activate' =>$log_array_activate));
					 							 			 	
								$log_text = json_encode(array('key_code' =>$log_array, 'user_activate' =>$log_array_activate));
																		 
								$log_data = array('reseller_id' => $this->session->resellerid, 'log_json' => $log_text);
								$this->reseller_m->update_keycode($log_data,array('reseller_id' => $this->session->resellerid), 'reseller_history');
								// echo $log_text;exit;
								//print_r(array('key_code' =>$log_array));
									
							}else{		
								$log_array['key_code'][0] = $data;			 					 
								$log_data = array('reseller_id' => $this->session->resellerid, 'log_json' => json_encode($log_array));					
								$this->reseller_m->insertkeys($log_data,'reseller_history');
							}
				
				
						}
						//$this->subscription_renewal_keys_m->save(NULL,$data);
					}
					
					//exit;
					//echo $walet_deduct_money ;
					if($walet_deduct_money > 0){
						$walet_money = $getResellerInfo[0]['wallet_money'] - $walet_deduct_money;
						$dataUpdate = array('wallet_money'=>$walet_money);
						$whereUpdate = array('id'=>$this->session->resellerid);
						$this->reseller_m->update_keycode($dataUpdate,$whereUpdate,'reseller');
					
					}
					//exit;
					
					$this->session->set_flashdata('message_set',"yes");
					$this->session->set_flashdata('success',"Create Key Successfully.");
				} else{
					$this->session->set_flashdata('message_set',"yes");
					$this->session->set_flashdata('error',"There is Not Enough Wallet Money");
				}
				redirect(BASE_URL.'resellers/activationkeys');
            }
            /*$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('keys').'" target="_blank">Keys Created</a>');   
            $this->session->set_flashdata('success',"Keys Created Successfully.");
           */
        }
		$whereSelect = array('reseller_id'=>$this->session->resellerid,'key_type' => 'activation');
		//$resellerKeycode = $this->reseller_m->selectdatarow($whereSelect, 'subscription_renewal_keys');
		$resellerKeycode = $this->reseller_m->selectSubscriptionCode($this->session->resellerid,'activation');
		$this->data['resellerKeycode'] = $resellerKeycode;
		$this->data['resellerInfo'] = $getResellerInfo[0];
		$this->data['active_tab'] = 'subscription_code';
		$this->data['active_menu'] = 'activationkeys';
		
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'resellers/_extra_scripts';
		$this->data['_view'] = CUSTOMER_THEME . 'resellers/activationkeys';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
	}
	
	public function editcustomer($id){

       // check_allow('create',$this->data['is_allow']);
        $this->load->model('products_m');
        $this->load->model('dynamic_dependent_m');
		$this->load->model('customers_m');
       // $rules = $this->customers_m->add_rules;
       
	   	$where = array('id'=>$id);		
	   	$customers_details = $this->reseller_m->selectCustomerInfo($id);
	   
	   	$whereInfo = array('customer_id'=>$id);	
	   	$customersInfo = $this->reseller_m->selectRechargePlan($id);

	   	$resellerid = $this->session->resellerid;
		$this->data['resellerInfo'] = $this->reseller_m->getReseller($resellerid);

	

		/*echo '<pre>';
		print_r($customers_details);exit;*/
        
		//$this->form_validation->set_rules('currency_type', 'Currency', 'trim|required');
		


		if(isset($_REQUEST['create_customer'])){
			$first_ch = substr(trim($this->input->post('mobile')),0,1);
			if ($first_ch==0){
				$mobile = substr(trim($this->input->post('mobile')), 1);
			}else{
				$mobile = trim($this->input->post('mobile'));
			}
			$title = $this->input->post('title');
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$phone = $this->input->post('mobile');
			$c_code = $this->input->post('c_code');
			$email = $this->input->post('email');
			$billing_country = $this->input->post('billing_country');
			$currency = $this->input->post('currency');
			$billing_state = $this->input->post('billing_state');
			$billing_city = $this->input->post('billing_city');
			$billing_street = $this->input->post('billing_street');
			$billing_zip = $this->input->post('billing_zip');
			$password = $this->input->post('password');
			$status = $this->input->post('status');

		/*echo 'db password: '.$customers_details[0]['password'].'<br>';
		$decode_password = base64_decode($customers_details[0]['password']);
		echo 'After base64_decode: '.$decode_password.'<br>';
		$alpha_password = $this->toAlphaNumeric(strtolower($decode_password));
		echo 'After toAphNueric and strtolower of Decode Passwrod: '. $alpha_password;exit()


		$alpha_password = $this->toAlphaNumeric(strtolower($password));
		echo 'after base64_encode: '.base64_encode($password).'<br>';	
		echo 'after base64_encode($this->toAlphaNumeric( : '. base64_encode($this->toAlphaNumeric($password)).'<br>';
		echo  'forfile name: '.$this->toAlphaNumeric($password) . '.json';exit();*/
			
			$this->load->library('form_validation');
		
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('c_code', 'Country Code', 'trim|required');
			if($customers_details[0]['mobile'] != $mobile){
				$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric|callback_checkphone');
			}
			//$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_unique');
			$this->form_validation->set_rules('billing_country', 'Country Code', 'trim|required');
			$this->form_validation->set_rules('currency', 'currency Code', 'trim|required');
			$this->form_validation->set_rules('billing_state', 'State', 'trim|required');
			$this->form_validation->set_rules('billing_city', 'City', 'trim|required');
			$this->form_validation->set_rules('billing_street', 'Street', 'trim|required');
			$this->form_validation->set_rules('billing_zip', 'ZIP', 'trim|required');
		//	$this->form_validation->set_rules('password', 'Password', 'trim|required');
			//$this->form_validation->set_rules('plan_keycode', 'plan Keycode', 'trim|callback_plankeycodeactivation');
		
			if ($this->form_validation->run() == FALSE){
				$this->data['message'] = 'error';
				$this->data['title'] = $title;
				$this->data['first_name'] = $first_name;
				$this->data['last_name'] = $last_name;
				$this->data['c_code'] = $c_code;
				$this->data['mobile'] = $mobile;
				$this->data['email'] = $email;
				$this->data['billing_country'] = $billing_country;
				$this->data['currency'] = $currency;
				$this->data['billing_state'] = $billing_state;
				$this->data['billing_city'] = $billing_city;
				$this->data['billing_street'] = $billing_street;
				$this->data['billing_zip'] = $billing_zip;
			//	$this->data['password'] = $password;
				$this->data['status'] = $status;				
				
			} 
			else {

				$data = array(
								"title"=>$title,
								"first_name"=>$first_name,
								"last_name"=>$last_name,
								"phone"=>$phone,
								"mobile"=>$mobile,
								"c_code"=>$c_code,
								//"email"=>strtolower($email),
								//"alpha_email"=>$this->toAlphaNumeric(strtolower($email)),
								"password"=>base64_encode($password),
								"alpha_password"=>base64_encode($this->toAlphaNumeric($password)),
								"billing_street"=>$billing_street,
								"billing_zip"=>$billing_zip,
								"billing_city"=>$billing_city,
								"billing_state"=>$billing_state,
								"billing_country"=>$billing_country,
								"currency"=>$currency,
								"status"=>$status,
								"reseller_id"=>$this->session->resellerid
							);
				
				$this->reseller_m->update_keycode($data,$where,'customers');
				
				//Json Create
				//==========================================================================================================================
				//if($plan_keycode != ''){
					$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($customers_details[0]['email']))));
					if(!is_dir($json_directory)){
						/* Directory does not exist, so lets create it. */
						mkdir($json_directory, 0777, true);
					}					
					$filename = $this->toAlphaNumeric($password) . '.json';
						
					$localFilePath = $json_directory.'/'.$filename;
					$final_json_output = $this->publishJsonGenerater(strtolower($customers_details[0]['email']), $password);
					
					$fpt_r = fopen($localFilePath, 'w');
					fwrite($fpt_r, $final_json_output);
					fclose($fpt_r);				
						
						
				//}	
				//===========================================================================================================================	
				
				redirect(BASE_URL.'resellers/customerslist');
			}
			
		
		}
		else {
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
 
		}

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

		$this->data['active_tab'] = 'customers';
		$this->data['active_menu'] = 'customerslist';

		


		//Reseller Customer Logs
		//echo '<pre>';
		$this->data['reseller_customer_log'] = '';
		$customer_log_text_array = $this->reseller_m->selectdatarow(array('reseller_id' => $this->session->resellerid), 'reseller_history');

		if (count($customer_log_text_array) > 0) {

			
			$customer_log_text_array = json_decode($customer_log_text_array[0]['log_json'], true);
			//print_r($customer_log_text_array).'<br>';

			// Check if user_activate array exists
			if (isset($customer_log_text_array['user_activate']) && is_array($customer_log_text_array['user_activate'])) {

				$user_activate = $customer_log_text_array['user_activate'];
				//print_r($user_activate).'<br>';

				// Filter for specific customer log records
				$filtered_logs = array_filter($user_activate, function($log) use ($id) {
					// Add your filtering conditions here
					// For example, to filter by customer_id:
					return $log['customer_id'] == $id;

					// Or to filter by product_id:
					// return $log['product_id'] == '1';

					// You can add multiple conditions as needed
				});

				$this->data['reseller_customer_log'] = array_values($filtered_logs);
			}
		}
		
		
		//print_r($this->data['reseller_customer_log']);
		//exit();

		$this->data['devices'] = $this->fetchDevices($id);

		//print_r($this->data['devices']);exit();

		$this->data['info'] = $customersInfo;
		 
		
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'resellers/_extra_scripts';
        $this->data['_view'] = CUSTOMER_THEME . 'resellers/edit_customer';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
    }
	
	public function rechargeonecustomer($id){

		$where = array('reseller_id'=>$this->session->resellerid,'id'=>$id);		
		$this->data['customers']= $this->reseller_m->selectdatarow($where,'customers');
		$this->data['customers_id'] = $id;

		$this->data['customer_info'] = $this->reseller_m->selectCustomerInfo($id); 


		$this->load->library('form_validation');
		$this->form_validation->set_rules('customet_id', 'Customer', 'trim|required');
		$this->form_validation->set_rules('plan_keycode', 'plan Keycode', 'trim|required|callback_plankeycoderecharge');
			
		/*echo '<pre>';
		print_r($this->reseller_m->selectdatarow($where,'customers'));*/
				
		$this->data['message'] = '';
		if(isset($_REQUEST['recharge_customer'])){

			$customet_id = $this->input->post('customet_id');
			$plan_keycode = $this->input->post('plan_keycode');

			$customers_details = $this->reseller_m->selectCustomerInfo($customet_id);

			if ($this->form_validation->run() == FALSE){
				$this->data['message'] = 'error';
				$this->data['customet_id'] = $customet_id;
				$this->data['plan_keycode'] = $plan_keycode;
			}else{

				$where_keycode = array('keycode'=>$plan_keycode);		
	   			$keycode_details = $this->reseller_m->selectdatarow($where_keycode,'subscription_renewal_keys');

	   			if($keycode_details[0]['disabled']!=1){



					$where = array('id'=>$id);		
	         	    $customerInfo= $this->reseller_m->selectdatarow($where,'customers');
					$valid_time = "+".$keycode_details[0]['length_months'].' '.$keycode_details[0]['month_day'];
					$now_time = date("Y-m-d H:i:s");

					 
					$expire =  $customerInfo[0]['subscription_expire'];
					$diff = strtotime($expire) - strtotime($now_time);
					$days = floor($diff / (60 * 60 * 24));
					 if($days < 0 || $days==0){
						$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
					 }else{
						$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($expire)));
					 }

					 $subscription_expire_recharge = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));

					//$valid_time = "+".$keycode_details[0]['length_months'].' '.$keycode_details[0]['month_day'];
					//$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
					//get expiry date-------
					

					//code end
					$data = array(
								"sebscription_trpe"=>'rcode',
								'subscription_expire'=>$subscription_expire,  
								);
					$where = array('id'=>$customet_id);
					$this->reseller_m->update_keycode($data,$where,'customers');
					//customer recharge history--
					$insertData = array(
								"activation_code"=>$plan_keycode,
								"sebscription_trpe"=>'rcode',
								'subscription_expire'=>$subscription_expire_recharge, 
								'product_activation_key_id' => $keycode_details[0]['id'], 
								'product_id' => $keycode_details[0]['product_id'],
								'plan_id' => $keycode_details[0]['plan_id'],
								'devices_allowed' => $keycode_details[0]['devices_allowed'],
								'reseller_id' => $this->session->resellerid,
								'customer_id' => $customet_id,
								);
					$this->reseller_m->insertkeys($insertData,'customers_recharge'); 
                    //update status of recharge key: used
				    $subscription_keys_data = array('user_id'=>$customet_id,'used'=>'1');
				    $subscription_keys_where = array('keycode'=>$plan_keycode);
				    $this->reseller_m->update_keycode($subscription_keys_data,$subscription_keys_where,'subscription_renewal_keys');
				    //Json Create
					//==========================================================================================================================
					if($plan_keycode != ''){								
							$email = $customers_details[0]['email'];
							$password = base64_decode($customers_details[0]['password']);
							$alpha_password = $this->toAlphaNumeric(strtolower($password));

							$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($email))));
							if(!is_dir($json_directory)){
							/* Directory does not exist, so lets create it. */
							mkdir($json_directory, 0777, true);
							}			
							$filename = $alpha_password . '.json';

							$localFilePath = $json_directory.'/'.$filename;

							$final_json_output = $this->publishJsonGenerater(strtolower($email),$password);
							$fpt_r = fopen($localFilePath, 'w');
							fwrite($fpt_r, $final_json_output);
							fclose($fpt_r);
						}	
					//===========================================================================================================================	
					
					$this->session->set_flashdata('success', '<span style="color:green;"> Congratulations your recharge has been successful with '.$plan_keycode.'</span>');
					redirect(BASE_URL.'resellers/editcustomer/'.$customet_id);
				}else{
					 
					 
					$this->session->set_flashdata('success', '<span style="color:red;">Invalid Key.</span>');
				
					 
					redirect(BASE_URL.'resellers/customerslist');
					 
				}	
					
			}
			
		}
		$this->data['active_tab'] = 'customers';
		$this->data['active_menu'] = 'rechargecustomer';
		
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'resellers/_extra_scripts';
        $this->data['_view'] = CUSTOMER_THEME . 'resellers/rechargeonecustomer';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
		
	}

	public function upgradeonecustomer($id){

		if ($this->input->is_ajax_request() && $this->input->post('action') === 'upgrade_customer') {
			echo json_encode(['success' => true, 'message' => 'Upgrade successful']);
		}

		$where = array('reseller_id'=>$this->session->resellerid,'id'=>$id);		
		$this->data['customers']= $this->reseller_m->selectdatarow($where,'customers');
		$this->data['customers_id'] = $id;
		
		$customer_recharge = $this->reseller_m->selectRechargePlan($id);

		$customer_active_plan = $this->reseller_m->getCustomerWithActivePlan($id);
		$customer_active_plan[0]['TotalRecharge'] = count($customer_recharge);
		$customer_active_plan[0]['ActiveTotalPrice'] = $customer_active_plan[0]['ActiveDealerPrice']*count($customer_recharge);
		// Calculate RemainingBalance
		$total_price = $customer_active_plan[0]['ActiveTotalPrice'];
		$total_days = $customer_active_plan[0]['ActiveTotalDays'];
		$used_days = $customer_active_plan[0]['ActiveUsedDays'];
		$reamining_days = $customer_active_plan[0]['ActiveRemainingDays'];
		
		//$remaining_balance = ($total_price / $total_days) * $used_days - $total_price;
		$remaining_balance = ($total_price / $total_days) * $reamining_days;
		$remaining_balance = number_format($remaining_balance, 2); // Format to 2 decimal places
		$customer_active_plan[0]['RemainingBalance'] = $remaining_balance;

		//echo '<pre>';
		//print_r($customer_active_plan[0]).'<Br>';

		$now_time = date("Y-m-d H:i:s");
		//$valid_time = "+".$customer_active_plan[0]['PlanTime'];
		//$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
		//echo $subscription_expire;


		
		$reseller_plans = $this->reseller_m->getAllPlansByResellerID($this->session->resellerid);
		foreach($reseller_plans as $key=>$reseller_plan){
			if($customer_active_plan[0]['ActivePlanID']==$reseller_plan['PlanID'])
			{
				$reseller_plans[$key]['Status'] = '1';
			}else{
				$reseller_plans[$key]['Status'] = '0';
				// Calculate TotalDays for plans with Status 0
		        $plan_time = $reseller_plan['PlanTime'];
		        $current_date = new DateTime();
		        
		        // Add duration to current date based on PlanTime format
		        if (preg_match('/(\d+)\s*months?/', $plan_time, $matches)) {
		            $months = (int)$matches[1];
		            $end_date = clone $current_date;
		            $end_date->add(new DateInterval('P' . $months . 'M'));
		        } elseif (preg_match('/(\d+)\s*days?/', $plan_time, $matches)) {
		            $days = (int)$matches[1];
		            $end_date = clone $current_date;
		            $end_date->add(new DateInterval('P' . $days . 'D'));
		        } elseif (preg_match('/(\d+)\s*years?/', $plan_time, $matches)) {
		            $years = (int)$matches[1];
		            $end_date = clone $current_date;
		            $end_date->add(new DateInterval('P' . $years . 'Y'));
		        } else {
		            $end_date = $current_date; // Default to current date if PlanTime format is unexpected
		        }
		        
		        $interval = $current_date->diff($end_date);
		        $total_days = $interval->days;

		        $reseller_plans[$key]['ExpiryDate'] = $end_date->format('Y-m-d H:i:s');
		        
		        $reseller_plans[$key]['TotalDays'] = $total_days;

		         // Calculate FutureBalance
			    $active_remaining_days = $customer_active_plan[0]['ActiveRemainingDays'];
			    $plan_total_price = $reseller_plan['DealerPrice'];
			    $future_balance = ($plan_total_price / $total_days) * $active_remaining_days;
			    $future_balance = number_format($future_balance, 2); // Format to 2 decimal places
			    $reseller_plans[$key]['FutureBalance'] = $future_balance;
			    
			    // Calculate TotalBalance
			    $total_balance = $remaining_balance + $future_balance;
			    $total_balance = number_format($total_balance, 2); // Format to 2 decimal places
			    $reseller_plans[$key]['TotalBalance'] = $total_balance;
			}
		}

		// Sort the $reseller_plans array by the Status field
		usort($reseller_plans, function ($a, $b) {
		    return $b['Status'] <=> $a['Status'];
		});


		//print_r($reseller_plans);exit();


		$this->data['customer_active_plan'] = $customer_active_plan[0];
		$this->data['reseller_plans'] = $reseller_plans;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('customet_id', 'Customer', 'trim|required');
		$this->form_validation->set_rules('reseller_plan_id', 'Plan', 'trim|required');
			
		/*echo '<pre>';
		print_r($this->reseller_m->selectdatarow($where,'customers'));*/
				
		$this->data['message'] = '';
		if(isset($_REQUEST['upgrade_customer'])){
			 
			$customet_id = $this->input->post('customet_id');

			$reseller_plan_id = $this->input->post('reseller_plan_id');

			$customers_details = $this->reseller_m->selectCustomerInfo($customet_id);
			

			
			if ($this->form_validation->run() == FALSE){
				$this->data['message'] = 'error';
				$this->data['customet_id'] = $customet_id;
				$this->data['reseller_plan_id'] = $reseller_plan_id;
			}else{
				$where_reseller_plan_id = array('id'=>$reseller_plan_id);		
	   			$reseller_details = $this->reseller_m->selectdatarow($where_reseller_plan_id,'reseller_details');
				//print_r($reseller_details);
				//echo $reseller_details[0]['reseller_id'];exit();

				$where_keycode = array('reseller_id'=>$reseller_details[0]['reseller_id'], 'reseller_plan_id' => $reseller_details[0]['id'], 'used' => 0);		
	   			$keycode_details = $this->reseller_m->selectdatarow($where_keycode,'subscription_renewal_keys');

				if (!empty($keycode_details) && isset($keycode_details[0]['disabled']) && $keycode_details[0]['disabled'] != 1){
					echo 'Key Found:'.$keycode_details[0]['keycode'];
					exit();
					$where = array('id'=>$id);		
	         	    $customerInfo= $this->reseller_m->selectdatarow($where,'customers');

					$valid_time = "+".$keycode_details[0]['length_months'].' '.$keycode_details[0]['month_day'];

					$now_time = date("Y-m-d H:i:s");

					 
					$expire =  $customerInfo[0]['subscription_expire'];
					$diff = strtotime($expire) - strtotime($now_time);
					$days = floor($diff / (60 * 60 * 24));
					 if($days < 0 || $days==0){						
						$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
					 }else{
						$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($expire)));
					 }
					 $subscription_expire_recharge = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
					

					//Point-1 Will the vcodelife column in Customer Table will be update from today days.
					//Point-2 Will the Remaing Days "Payment" of Previous Plan be added back to Dealer Wallet.
					
					//When we create Customer from reseller following table is filled.
					//customers
					//customers_recharge
					//plan_history
					//reseller_history


					//code end
					$data = array(	 
									"sebscription_trpe"=>'rcode',
									'subscription_expire'=>$subscription_expire,  
								);
					$where = array('id'=>$customet_id);
					$this->reseller_m->update_keycode($data,$where,'customers');


					//customer recharge history--
					$insertData = array("activation_code"=>$plan_keycode,
									 "sebscription_trpe"=>'rcode',
									 'subscription_expire'=>$subscription_expire_recharge, 
									 'product_activation_key_id' => $keycode_details[0]['id'], 
									 'product_id' => $keycode_details[0]['product_id'],
									 'plan_id' => $keycode_details[0]['plan_id'],
									 'devices_allowed' => $keycode_details[0]['devices_allowed'],
									 'reseller_id' => $this->session->resellerid,
									 'customer_id' => $customet_id,
								);
					 $this->reseller_m->insertkeys($insertData,'customers_recharge'); 
                    //update status of recharge key: used
					
				    $subscription_keys_data = array('user_id'=>$customet_id,'used'=>'1');
				    $subscription_keys_where = array('keycode'=>$plan_keycode);
				    $this->reseller_m->update_keycode($subscription_keys_data,$subscription_keys_where,'subscription_renewal_keys');
				    //Json Create
				//==========================================================================================================================
				if($plan_keycode != ''){
					
				$email = $customers_details[0]['email'];
				$password = base64_decode($customers_details[0]['password']);
				$alpha_password = $this->toAlphaNumeric(strtolower($password));

				$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($email))));
				if(!is_dir($json_directory)){
				/* Directory does not exist, so lets create it. */
				mkdir($json_directory, 0777, true);
				}			
				$filename = $alpha_password . '.json';

				$localFilePath = $json_directory.'/'.$filename;

				$final_json_output = $this->publishJsonGenerater(strtolower($email),$password);
				$fpt_r = fopen($localFilePath, 'w');
				fwrite($fpt_r, $final_json_output);
				fclose($fpt_r);				
						
						
				}	
				//===========================================================================================================================	
					
					$this->session->set_flashdata('success', '<span style="color:green;"> Congratulations your recharge has been successful with '.$plan_keycode.'</span>');
					redirect(BASE_URL.'resellers/editcustomer/'.$customet_id);
				}else{
					 
					 
				$this->session->set_flashdata('success', '<span style="color:red;">Kindly Create Key For This Plan First.</span>');
				
					 
					redirect(BASE_URL.'resellers/customerslist');
					 
				}	
					
			}
			
		}
		$this->data['active_tab'] = 'customers';
		$this->data['active_menu'] = 'upgradeonecustomer';
		
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'resellers/_extra_scripts';
        $this->data['_view'] = CUSTOMER_THEME . 'resellers/upgradeonecustomer';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
		
	}

	public function upgrade_customer_ajax() {

	    if (!$this->input->is_ajax_request()) {
	        show_error('No direct script access allowed');
	        return;
	    }

	    $reseller_plan_id = $this->input->post('reseller_plan_id');
	    $customer_id = $this->input->post('customer_id');
	    $activation_key = $this->input->post('activation_key');
	    $message = '<ul>';

	    // Validate input
	    if (empty($reseller_plan_id) || empty($customer_id) || empty($activation_key)) {
	        echo json_encode(['success' => false, 'message' => 'Invalid input data']);
	        return;
	    }

	    // Get customer details
	    $customer_details = $this->reseller_m->selectCustomerInfo($customer_id);
	    if (empty($customer_details)) {
	        echo json_encode(['success' => false, 'message' => 'Customer not found']);
	        return;
	    }

	    // Get plan details
	    $reseller_plan_details = $this->reseller_m->reseller_plan_code($reseller_plan_id);
	    if (empty($reseller_plan_details)) {
	        echo json_encode(['success' => false, 'message' => 'Plan not found']);
	        return;
	    }

	    // Validate activation key
	    $keycode_details = $this->reseller_m->selectdatarow(['keycode' => $activation_key, 'used' => 0], 'subscription_renewal_keys');
	    if (empty($keycode_details) || $keycode_details[0]['disabled'] == 1) {
	        echo json_encode(['success' => false, 'message' => 'Invalid or used activation key']);
	        return;
	    }

	    // Calculate RemainingBalance
	    $customer_recharge = $this->reseller_m->selectRechargePlan($customer_id);
		$customer_active_plan = $this->reseller_m->getCustomerWithActivePlan($customer_id);
		$customer_active_plan[0]['TotalRecharge'] = count($customer_recharge);
		//$customer_active_plan[0]['ActiveTotalPrice'] = $customer_active_plan[0]['ActiveDealerPrice']*count($customer_recharge);

		$customer_active_plan[0]['ActiveTotalPrice'] = $customer_active_plan[0]['ActiveDealerPrice'];
		$total_price = $customer_active_plan[0]['ActiveTotalPrice'];
		$total_days = $customer_active_plan[0]['ActiveTotalDays'];
		$used_days = $customer_active_plan[0]['ActiveUsedDays'];
		$reamining_days = $customer_active_plan[0]['ActiveRemainingDays'];

		$remaining_balance = ($total_price / $total_days) * $reamining_days;
		$remaining_balance = number_format($remaining_balance, 2); // Format to 2 decimal places
		$dealerPrice=$keycode_details[0]['dealer_price'];   //get deleler amount 

		/*echo 'total_price'.$total_price.'<br>';
		echo 'total_days'.$total_days.'<br>';
		echo 'reamining_days'.$reamining_days.'<br>';
		echo 'remaining_balance'.$remaining_balance;
		exit();*/
		//Refund Reamining Balance to Dealer Wallet
		if($this->reseller_m->updateWaletAmount($remaining_balance,$reseller_plan_details[0]['reseller_id'])){
			$message .= '<li>Reseller Wallet Updated with Customer Previous Plan Reamining Amount: '.$remaining_balance.'</li>';
		}
		
		// Perform upgrade logic here
	    $now_time = date("Y-m-d H:i:s");
	    $valid_time = "+" . $reseller_plan_details[0]['length_months'] . ' ' . $reseller_plan_details[0]['month_day'];
	    $new_expiry = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));

		//Insert Activation Key As Recharge.
		$insertRechargeData = array(
			'activation_code'=>$activation_key,
			"sebscription_trpe"=>'Active',
			'subscription_expire'=>$new_expiry,
			'product_activation_key_id' => $keycode_details[0]['id'], 
			'product_id' => $keycode_details[0]['product_id'],
			'plan_id' => $keycode_details[0]['plan_id'],
			'devices_allowed' => $keycode_details[0]['devices_allowed'],
			'reseller_id' => $this->session->resellerid,
			'customer_id' => $customer_id,
		);

	    if($this->reseller_m->insertkeys($insertRechargeData,'customers_recharge')){
	    	//$message .= '<li>Add Key as Recharge Successfully.</li>';
	    } 

	    // Mark activation key as used
	    if($this->reseller_m->update_keycode(['used' => 1, 'user_id' => $customer_id], ['keycode' => $activation_key], 'subscription_renewal_keys')){
	    	//$message .= '<li>Key Mark as Used Successfully.</li>';
	    }

	    //Update Customer Table with New Plan.
	    $update_customer_data = [
	    	'is_upgrade' => '1',
	        "sebscription_trpe" => 'Upgrade',
	        'vcodelife' => $now_time,
	        'subscription_expire' => $new_expiry,
	        'product_id' => $reseller_plan_details[0]['product_id'],
	        'plan_id' => $reseller_plan_details[0]['plan_id'],
	        'product_activation_key_id' => $keycode_details[0]['id'], 
	        'activation_code' => $activation_key,
	        'devices_allowed' => $reseller_plan_details[0]['devices_allowed']
	    ];
	    if($this->reseller_m->update_keycode($update_customer_data, ['id' => $customer_id], 'customers')){
	    	$message .= '<li>Update Customer with New Plan Details Successfully.</li>';
	    }

	    //Create Log of Dealler Walet :: Reamining Balance Added.
		$data_customers_reseller_log = array('subscription_expire'=>$new_expiry, 
		'product_activation_key_id' => $keycode_details[0]['id'], 
		'product_id' => $keycode_details[0]['product_id'],
		'plan_id' => $keycode_details[0]['plan_id'],
		'plan_name'=>$keycode_details[0]['group_name'],
		'devices_allowed' => $keycode_details[0]['devices_allowed'],
		'activation_code' => $activation_key,
		'customer_name' => $customer_details[0]['first_name'].' '.$customer_details[0]['last_name'],
		'customer_id' => $customer_id,
		'customer_email' => strtolower($customer_details[0]['email']),
		'sebscription_trpe'=>'Upgrade',
		'remaining_balance' => $remaining_balance,
		'date_created'=>date("Y-m-d H:i:s")
		);
		$log_text_array_reseller = $this->reseller_m->selectdatarow(array('reseller_id' => $this->session->resellerid),'reseller_history');						
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
			$log_data_reseller = array('reseller_id' => $this->session->resellerid, 'log_json' => $log_text_reseller);
			if($this->reseller_m->update_keycode($log_data_reseller,array('reseller_id' => $this->session->resellerid), 'reseller_history')){
				//$message .= '<li>Update Log of Dealler Successfully.</li>';
			}
		}else{		
			$log_array_reseller['user_activate'][0] = $data_customers_reseller_log;			 					 
			$log_data_reseller = array('reseller_id' => $this->session->resellerid, 'log_json' => json_encode($log_array_reseller));					
			$this->reseller_m->insertkeys($log_data_reseller,'reseller_history');

			//$message .= '<li>Add Log of Dealler Successfully.</li>';
		}

		// Create Log of Customer Plan :: Plan Upgraded.
	    $data_customers_log = array( 'subscription_expire'=>$new_expiry, 
			'product_activation_key_id' => $keycode_details[0]['id'], 
			'product_id' => $keycode_details[0]['product_id'],
			'plan_id' => $keycode_details[0]['plan_id'],
			'devices_allowed' => $keycode_details[0]['devices_allowed'],
			'activation_code' => $activation_key,
			'walletbalance' => '',
			'sebscription_trpe' => 'Upgrade',
			'group_name'=>$keycode_details[0]['group_name'],
			'date_created'=>date('Y-m-d H:i:s'),
			'length_months'=>$keycode_details[0]['length_months'],
  			'month_day' => $keycode_details[0]['month_day'],
  			'monthly_price' => $keycode_details[0]['monthly_price'],
			'date_created'=>date("Y-m-d H:i:s")
		);		
		$log_array[] = $data_customers_log;			 					 
		$log_data = array('used_id'=>$customer_id, 'log_json' => json_encode($log_array));	
		if($this->reseller_m->insertRow($log_data,'plan_history')){
			//$message .= '<li>Add Log of Customer Successfully.</li>';
		}

	    

	    // Generate new JSON file
	    //==========================================================================================================================
		if($activation_key != ''){
			$email = $customer_details[0]['email'];
			$password = base64_decode($customer_details[0]['password']);
			$alpha_password = $this->toAlphaNumeric(strtolower($password));
			$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($email))));
			if(!is_dir($json_directory)){
				/* Directory does not exist, so lets create it. */
				mkdir($json_directory, 0777, true);
			}			
			$filename = $alpha_password . '.json';
			$localFilePath = $json_directory.'/'.$filename;
			$final_json_output = $this->publishJsonGenerater(strtolower($email),$password);
			$fpt_r = fopen($localFilePath, 'w');
			fwrite($fpt_r, $final_json_output);
			fclose($fpt_r);

				//$message .= '<li>Customer Json Successfully.</li>';
		}	
		//===========================================================================================================================	
	    $message .= "</ul>";
	    // Return success response
	    echo json_encode([
	        'success' => true, 
	        'message' => $message
	    ]);
	}
	
	
	public function rechargecustomer(){
		$where = array('reseller_id'=>$this->session->resellerid);		
		$this->data['customers']= $this->reseller_m->selectdatarow($where,'customers');
	/*	echo '<pre>';
		print_r($this->reseller_m->selectdatarow($where,'customers'));*/
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customet_id', 'Customer', 'trim|required');
		$this->form_validation->set_rules('plan_keycode', 'plan Keycode', 'trim|required|callback_plankeycode');
		
		$this->data['message'] = '';
		if(isset($_REQUEST['create_customer'])){
			$customet_id = $this->input->post('customet_id');
			$plan_keycode = $this->input->post('plan_keycode');
			
			if ($this->form_validation->run() == FALSE){
				$this->data['message'] = 'error';
				$this->data['customet_id'] = $customet_id;
				$this->data['plan_keycode'] = $plan_keycode;
			}else{
				$where_keycode = array('keycode'=>$plan_keycode);		
	   			$keycode_details = $this->reseller_m->selectdatarow($where_keycode,'subscription_renewal_keys');
				
				$now_time = date("Y-m-d H:i:s");
				$valid_time = "+".$keycode_details[0]['length_months'].' '.$keycode_details[0]['month_day'];
				$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
				
				$data = array(	"activation_code"=>$plan_keycode,
								"sebscription_trpe"=>'rcode',
								'subscription_expire'=>$subscription_expire, 
											'product_activation_key_id' => $keycode_details[0]['id'], 
												'product_id' => $keycode_details[0]['product_id'],
													'devices_allowed' => $keycode_details[0]['devices_allowed']
							);
				$where = array('id'=>$customet_id);
				$this->reseller_m->update_keycode($data,$where,'customers');
				redirect(BASE_URL.'resellers/customerslist');
							
			}
		}
		$this->data['active_tab'] = 'customers';
		$this->data['active_menu'] = 'rechargecustomer';
		
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'resellers/_extra_scripts';
        $this->data['_view'] = CUSTOMER_THEME . 'resellers/rechargecustomer';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
		
	}
	
	public function resendRegistration($customer_id){
		$this->load->model('customers_m');
	 	$customer_details = $this->customers_m->getCustomerInfo($customer_id);
		/*echo '<pre>';
		print_r($customer_details);*/
		
		 // Send Email Notification
            $this->load->model('email_templates_m','EM');
            $template=$this->EM->get_email_template("user_added_notification");
            
            $login_link="<a href='".site_url('customer/login/')."'>".site_url('customer/login/')."</a>";
            $parse_data=array('FIRST_NAME'=>$customer_details->first_name,
                              'USERNAME'=>$customer_details->email,
                              'PASSWORD'=>base64_decode($customer_details->password),
                              'LOGIN_LINK'=>$login_link,
                              'EMAIL' => $customer_details->email                             
                            );
            
            // send email to customer
            $this->load->model('Email_model');
            $email_status=$this->Email_model->send_email($template,$parse_data);
			$this->session->set_flashdata('success',"Resend Email Successfully.");
			redirect(BASE_URL.'resellers/customerslist/');
			
	}
	
	public function createcustomer(){
       // check_allow('create',$this->data['is_allow']);
        $this->load->model('products_m');
        $this->load->model('dynamic_dependent_m');
		$this->load->model('customers_m');
        $rules = $this->customers_m->add_rules;
       
        $this->load->library('form_validation');
		
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		//$this->form_validation->set_rules('phone', 'Contact Phone', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric|callback_checkphone');
		$this->form_validation->set_rules('c_code', 'Country Code', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_unique');
		$this->form_validation->set_rules('billing_country', 'Country Code', 'trim|required');
		$this->form_validation->set_rules('currency', 'currency Code', 'trim|required');
		
		$this->form_validation->set_rules('billing_state', 'State', 'trim|required');
		$this->form_validation->set_rules('billing_city', 'City', 'trim|required');
		$this->form_validation->set_rules('billing_street', 'Street', 'trim|required');
		$this->form_validation->set_rules('billing_zip', 'ZIP', 'trim|required');
		//$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('plan_keycode', 'plan Keycode', 'trim|callback_plankeycodeactivation');
		
		//'c_code' => $this->input->post('c_code'),
		if(isset($_REQUEST['create_customer'])){
			$first_ch = substr(trim($this->input->post('mobile')),0,1);
			if ($first_ch==0){
				$mobile = substr(trim($this->input->post('mobile')), 1);
			}else{
				$mobile = trim($this->input->post('mobile'));
			}
			
			$title = $this->input->post('title');
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$phone = $this->input->post('mobile');
			$c_code = $this->input->post('c_code');
			$currency = $this->input->post('currency'); 
			//$mobile = $this->input->post('mobile');
			$email = $this->input->post('email');
			$billing_country = $this->input->post('billing_country');
			$billing_state = $this->input->post('billing_state');
			$billing_city = $this->input->post('billing_city');
			$billing_street = $this->input->post('billing_street');
			$billing_zip = $this->input->post('billing_zip');
			//$password = $this->input->post('password');
			//$password= $this->generatePassword();
			$status = $this->input->post('status');
			$plan_keycode = $this->input->post('plan_keycode');
			
			if ($this->form_validation->run() == FALSE){
				$this->data['message'] = 'error';
				$this->data['title'] = $title;
				$this->data['first_name'] = $first_name;
				$this->data['last_name'] = $last_name;
				$this->data['c_code'] = $c_code;
				$this->data['mobile'] = $mobile;
				$this->data['email'] = $email;
				$this->data['currency'] = $currency;
				$this->data['billing_country'] = $billing_country;
				$this->data['billing_state'] = $billing_state;
				$this->data['billing_city'] = $billing_city;
				$this->data['billing_street'] = $billing_street;
				$this->data['billing_zip'] = $billing_zip;
				//$this->data['password'] = $password;
				$this->data['status'] = $status;
				$this->data['plan_keycode'] = $plan_keycode;	
				
				/* States */
				$this->data['billing_states']=$this->dynamic_dependent_m->get_states($billing_country);
				/* Cities */
				$this->data['billing_cities']=$this->dynamic_dependent_m->get_cities($billing_state);				
				
			} else {	
				
				$where_keycode = array('keycode'=>$plan_keycode);		
	   			$keycode_details = $this->reseller_m->selectdatarow($where_keycode,'subscription_renewal_keys');
				/*echo '<pre>';
				print_r($keycode_details);exit;*/
				if($keycode_details[0]['disabled']==1){

					$this->session->set_flashdata('success', '<span style="color:red;">Invalid Key.</span>');
					redirect(BASE_URL.'resellers/customerslist');

                   die;
				}
				$now_time = date("Y-m-d H:i:s");
				if(count($keycode_details)>0){
					$valid_time = "+".$keycode_details[0]['length_months'].' '.$keycode_details[0]['month_day'];
					$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
				}else{
					$valid_time = "-1 days";
					$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
				}
				
				//$where_customers = array('email'=>$email, 'alpha_email' => $this->toAlphaNumeric(strtolower($email)));	
				$where_customers = array('email'=>$email);		
	   			$customers_details = $this->reseller_m->selectdatarow($where_customers,'customers');
				
				if(count($customers_details) > 0){
					$this->reseller_m->deletedatarow(array('id' => $customers_details[0]['id']), 'customers');	
				}
				/*echo '<pre>';
				print_r($customers_details);exit;*/
					
				$data = array(
								"title"=>$title,
								"first_name"=>$first_name,
								"last_name"=>$last_name,
								"phone"=>$phone,
								"mobile"=>$mobile,
								"currency"=>$currency, 
								"c_code"=>$c_code,
								"email"=>strtolower($email),
								"alpha_email"=>$this->toAlphaNumeric(strtolower($email)),
								//"password"=>base64_encode($password),
								//"alpha_password"=>base64_encode($this->toAlphaNumeric(strtolower($password))),
								"billing_street"=>$billing_street,
								"billing_zip"=>$billing_zip,
								"billing_city"=>$billing_city,
								"billing_state"=>$billing_state,
								"billing_country"=>$billing_country,
								"status"=>$status,
								"reseller_id"=>$this->session->resellerid,
								"activation_code"=>$plan_keycode,
								"sebscription_trpe"=>'rcode',
								'subscription_expire'=>$subscription_expire, 
								'product_activation_key_id' => $keycode_details[0]['id'], 
								'product_id' => $keycode_details[0]['product_id'],
								'plan_id' => $keycode_details[0]['plan_id'],
								'devices_allowed' => $keycode_details[0]['devices_allowed']
							);
							
				$insert_id = $this->reseller_m->insertRow($data,'customers');
				
				$data_customers_log = array( 'subscription_expire'=>$subscription_expire, 
												'product_activation_key_id' => $keycode_details[0]['id'], 
												'product_id' => $keycode_details[0]['product_id'],
												'plan_id' => $keycode_details[0]['plan_id'],
												'devices_allowed' => $keycode_details[0]['devices_allowed'],
												'activation_code' => $plan_keycode,
												'walletbalance' => '',
												'sebscription_trpe' => 'rcode',
												'group_name'=>$keycode_details[0]['group_name'],
												'date_created'=>date('Y-m-d H:i:s'),
												'length_months'=>$keycode_details[0]['length_months'],
									  			'month_day' => $keycode_details[0]['month_day'],
									  			'monthly_price' => $keycode_details[0]['monthly_price'],
												'date_created'=>date("Y-m-d H:i:s")
											);


			
				$data_customers_reseller_log = array('subscription_expire'=>$subscription_expire, 
													'product_activation_key_id' => $keycode_details[0]['id'], 
													'product_id' => $keycode_details[0]['product_id'],
													'plan_id' => $keycode_details[0]['plan_id'],
													'devices_allowed' => $keycode_details[0]['devices_allowed'],
													'activation_code' => $plan_keycode,
													'customer_name' => $first_name.' '.$last_name,
													'customer_id' => $insert_id,
													'customer_email' => strtolower($email),
													'sebscription_trpe'=>'rcode',
													'date_created'=>date("Y-m-d H:i:s"),
													'plan_name'=>$keycode_details[0]['group_name']
													);

                         //firsttime recharge for activation
						$insertRechargeData = array("activation_code"=>$plan_keycode,
									 "sebscription_trpe"=>'Active',
									 'subscription_expire'=>$subscription_expire,
									 'product_activation_key_id' => $keycode_details[0]['id'], 
									 'product_id' => $keycode_details[0]['product_id'],
									 'plan_id' => $keycode_details[0]['plan_id'],
									 'devices_allowed' => $keycode_details[0]['devices_allowed'],
									 'reseller_id' => $this->session->resellerid,
									 'customer_id' => $insert_id,
								);
					     $this->reseller_m->insertkeys($insertRechargeData,'customers_recharge'); 						
				
				/*$insert_id = $this->reseller_m->insertRow($data,'customers');*/
				
				$log_array[] = $data_customers_log;			 					 
				$log_data = array('used_id'=>$insert_id, 'log_json' => json_encode($log_array));					
				$this->reseller_m->insertRow($log_data,'plan_history');
				
							
				
				$log_text_array_reseller = $this->reseller_m->selectdatarow(array('reseller_id' => $this->session->resellerid),'reseller_history');						
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
					 $log_data_reseller = array('reseller_id' => $this->session->resellerid, 'log_json' => $log_text_reseller);
					 $this->reseller_m->update_keycode($log_data_reseller,array('reseller_id' => $this->session->resellerid), 'reseller_history');
				}else{		
					$log_array_reseller['user_activate'][0] = $data_customers_reseller_log;			 					 
					$log_data_reseller = array('reseller_id' => $this->session->resellerid, 'log_json' => json_encode($log_array_reseller));					
					$this->reseller_m->insertkeys($log_data_reseller,'reseller_history');
				}
							
							
							
						
				//$username= $this->generateUsername($insert_id);
            	$password= $this->generatePassword();
				//$user_id = $data['email'];
				//$pincode = $password;	
				//$filename = $pincode.'.json';		
				//final json file will be like this 		
				//$userid1 = implode("/",str_split($this->toAlphaNumeric($user_id)));
				//$localFilePath = LOCAL_PATH_CUSTOMER.$userid1.'/'.$filename;			
				$data=array('pin'=>$this->generateUsername($insert_id),
							'username'=>$this->generateUsername($insert_id),
							"password"=>base64_encode($password),
							"alpha_password"=>base64_encode($this->toAlphaNumeric(strtolower($password))),
							'status' =>1
							);
				//$this->customers_m->save($insert_id,$data);
				$where = array('id' => $insert_id);
				$this->reseller_m->update_keycode($data,$where,'customers');
				
				$subscription_keys_data = array('user_id'=>$insert_id,'used'=>'1');
				$subscription_keys_where = array('keycode'=>$plan_keycode);
				$this->reseller_m->update_keycode($subscription_keys_data,$subscription_keys_where,'subscription_renewal_keys');
				
				// Mail send
				//=========================================================================================================================
				if($plan_keycode != ''){
						$this->load->model('email_templates_m');					
						$info_email=$this->email_templates_m->get(6,TRUE);						
						$mail_body = $info_email->body;
						$replacing_string = array("[FIRST_NAME]" => $first_name,
													"[LOGIN_LINK]" => '<a href="'.site_url('customer/login/').'">Login Link</a>',
														"[USERNAME]" => strtolower($email),
														"[PASSWORD]" => $password);						
							
						
						$toname = $first_name;
						$subject = $info_email->subject;
						$from = $info_email->sender_email;
						$fromname = $info_email->sender_name;
						/*$bodyHTML = "<div><strong>Username : </strong>".$to." </div>
									<div><strong>Password : </strong>".$this->input->post('passwordv')." </div>
									<div><strong>Verification OTP : </strong>".$gcode."</div>";*/
									
						$bodyHTML =	strtr($info_email->body, $replacing_string);
						//echo $bodyHTML;exit;
						$this->send_email($subject, $bodyHTML, $from, $fromname, $email, $toname);
						
				}
				//Json Create
				//==========================================================================================================================
				if($plan_keycode != ''){
					$alpha_password = $this->toAlphaNumeric(strtolower($password));
					$json_directory = LOCAL_PATH_CUSTOMER.implode("/",str_split($this->toAlphaNumeric(strtolower($email))));
					if(!is_dir($json_directory)){
						/* Directory does not exist, so lets create it. */
						mkdir($json_directory, 0777, true);
					}					
					$filename = $alpha_password . '.json';
						
					$localFilePath = $json_directory.'/'.$filename;
					$final_json_output = $this->publishJsonGenerater(strtolower($email), $password);
					
					$fpt_r = fopen($localFilePath, 'w');
					fwrite($fpt_r, $final_json_output);
					fclose($fpt_r);				
						
						
				}	
				//===========================================================================================================================		
				
				redirect(BASE_URL.'resellers/customerslist');
			}
			
		}
		
		      
        /* Countries */
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();
        

        /* products */
        $this->data['products']=$this->products_m->get();

		$this->data['active_tab'] = 'customers';
		$this->data['active_menu'] = 'customerslist';
		
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'resellers/_extra_scripts';
        $this->data['_view'] = CUSTOMER_THEME . 'resellers/create_customer';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
    }
	
	public function walletmoney(){
		//$this->data['is_allow']= check_permission(64);
		
		$resellerid = $this->session->resellerid;
		$resellerInfo = $this->reseller_m->getReseller($resellerid);
		if($resellerInfo[0]['can_create_walletcode'] == '0'){
			redirect(BASE_URL.'resellers');
		}	
		/*echo '<pre>';
		print_r($resellerInfo);exit;*/	
					
		$where = array('reseller_id' => $this->session->resellerid);
		$wallet_cupons = $this->reseller_m->selectdatarow($where, 'wallet_moneycode');
		/*
		echo '<pre>';
		print_r($wallet_cupons);exit;
		*/
		$this->data['wallet_cupons'] = $wallet_cupons;
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('length', 'Length', 'trim|required|greater_than_equal_to[12]');
		$this->form_validation->set_rules('prefix_code', 'Prefix Code', 'trim|required|max_length[6]');
		$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|greater_than[0]|max_length[20]');
		$this->form_validation->set_rules('price', 'Price', 'trim|required|greater_than[0]');
		if(isset($_REQUEST['walet_key'])){ 
			$length = $this->input->post('length');
			$prefix_code = $this->input->post('prefix_code');
			$quantity = $this->input->post('quantity');
			$price = $this->input->post('price');
			
			$reseller_discount = ($price*$resellerInfo[0]['wallet_code_discount'])/100 ;
			$price_final = $price - $reseller_discount;
			
			if ($this->form_validation->run() == FALSE){
				$this->data['message'] = 'error';
				$this->data['length'] = $length;
				$this->data['prefix_code'] = $prefix_code;
				$this->data['quantity'] = $quantity;
				$this->data['price'] = $price;
			} else{	
					//$required_price = $price*$quantity;
					$required_price = $price_final*$quantity;
					$total_comission = ($price - $price_final)*$quantity;
					if($resellerInfo[0]['wallet_money'] >= $required_price){
						for($i=1;$i<=$quantity;$i++){                
							$length_code =$length-strlen($prefix_code); 
							$key = substr(str_shuffle("0123456789"), 0, $length_code);		
							$final_key=$prefix_code.$key;
							$data = array(
										  'key_code '=>$final_key,
										  'price'=>$price,
										  'reseller_id'=>$this->session->resellerid,
										  'reseller_discount' => $reseller_discount
								);
							$this->reseller_m->insertkeys($data, 'wallet_moneycode');
						}	
						
						$wallet_money_remain = $resellerInfo[0]['wallet_money']	- $required_price;	
						$data_reseller = array('wallet_money'=>$wallet_money_remain);
					 	$where_reseller = array('id' => $this->session->resellerid);
					 	$this->reseller_m->update_key($data_reseller,$where_reseller, 'reseller');	
						
						$this->session->set_flashdata('message_set', 'setmag');
						$this->session->set_flashdata('success', 'Total Commission : $'.$total_comission.' ('.$resellerInfo[0]['wallet_code_discount'].'% of price.)');	
					}else{
						$this->session->set_flashdata('message_set', 'setmag');
						$this->session->set_flashdata('error', 'There is no enough money. Please recharge!');
					}
					redirect(BASE_URL.'resellers/walletmoney');
			
			}
		}
		
		$this->data['active_tab'] = 'subscription_code';
		$this->data['active_menu'] = 'walletmoney';
		
		$this->data['_extra_scripts'] = CUSTOMER_THEME . 'resellers/_extra_scripts';
        $this->data['_view'] = CUSTOMER_THEME . 'resellers/walletmoney';
		$this->load->view( CUSTOMER_THEME . 'resellers/_layout_after',$this->data);	
	}
	
	public function userlog_in(){
		if(!$this->session->islogin && $this->router->method != 'login'){
			redirect(BASE_URL.'resellers/login');
		}elseif($this->session->islogin && $this->router->method != 'index'){
			redirect(BASE_URL.'resellers');
		}
	}
	
	public function logout(){
		//$this->session->sess_destroy();

	    $reseller_session_keys = ['resellerid', 'resellername', 'reselleremail', 'status', 'plan_type', 'islogin'];
	    
	    foreach ($reseller_session_keys as $key) {
	        $this->session->unset_userdata($key);
	    }
		
		redirect(BASE_URL.'resellers/login');
	}
	
	public function checkphone($num){
        //your first charcter in voter_phone
       /* $first_ch = substr($num,0,1);
        if ($first_ch==0){
           //set your error message here
           $this->form_validation->set_message('checkphone','Mobile Number will not start with 0');
           return FALSE;
        } else{
            return TRUE;
		}
		*/
		
		
		 //your first charcter in mobile
        $first_ch = substr($num,0,1);
        if ($first_ch==0){
       		$mobile = substr($this->input->post('mobile'), 1);
			$this->form_validation->set_message('checkphone', 'This Mobile number already used. Use another mobile.');
			return $this->customers_m->get_mobile_check_available($mobile);
           // return TRUE;
		}else{
			$mobile = $this->input->post('mobile');
			$this->form_validation->set_message('checkphone', 'This Mobile number already used. Use another mobile.');
			return $this->customers_m->get_mobile_check_available($mobile);
		}
    }	
	
	public function email_unique(){
		$remail = $this->input->post('email');
		$alpha_email = $this->toAlphaNumeric(trim($this->input->post('email')));
		$this->form_validation->set_message('email_unique', 'This email already used. Use another Email.');
		//$where = array('email'=>$remail,'status'=>'1', 'alpha_email' => $alpha_email);
		$where = array('email'=>$remail,'status'=>'1');
		if(count($this->reseller_m->selectdatarow($where,'customers')) > 0 ){
			return false;
		}else{
			return true;
		}
		
	}
	
	public function plankeycode(){
		$plan_keycode = $this->input->post('plan_keycode');
		
		if($plan_keycode != ''){
			$where = array('keycode'=>$plan_keycode);
			if(count($this->reseller_m->selectdatarow($where,'subscription_renewal_keys')) > 0 ){
				$where = array('keycode'=>$plan_keycode, 'reseller_id'=>$this->session->resellerid, 'used'=>'1');
				if(count($this->reseller_m->selectdatarow($where,'subscription_renewal_keys')) > 0 ){
					$this->form_validation->set_message('plankeycode', 'Plan Keycode already used.');
					return false;
				}else{
					return true;
				}
			}else{
				$this->form_validation->set_message('plankeycode', 'Plan Keycode does not exit.');
				return false;
			}
		}
		
	}
	
	public function plankeycodeactivation(){
		$plan_keycode = $this->input->post('plan_keycode');
		
		if($plan_keycode != ''){			
			$keycode_where = array('keycode'=> $plan_keycode, 'active' => '1');
			$keycode_details = $this->customers_m->selectdatarow($keycode_where,'subscription_renewal_keys');
			if (count($keycode_details) > 0) {
				if($keycode_details[0]['user_id'] == '0'){
					if(($keycode_details[0]['key_type'] == 'master') || ($keycode_details[0]['key_type'] == 'activation')){						
						if($keycode_details[0]['reseller_id'] != $this->session->resellerid) {
							$this->form_validation->set_message('plankeycodeactivation', 'Sorry! Key does not belong to you. Please generate key from you account.');
							return false;
						}else{
							return true;
						}
					}else{
						$this->form_validation->set_message('plankeycodeactivation', 'Invalid Key.');
						return false;
					}				
				} else{
					$this->form_validation->set_message('plankeycodeactivation', 'Key Already Used.');
					return false;					
				}
			}else{
			 	$this->form_validation->set_message('plankeycodeactivation', 'Invalid Key.');
				return false;
				
		    }
				 
		}
		
	}
	
	public function plankeycoderecharge(){
		$plan_keycode = $this->input->post('plan_keycode');
		$customet_id = $this->input->post('customet_id');

		$customers_details = $this->reseller_m->selectCustomerInfo($customet_id);


		$this->load->model('customers_m');
		if($plan_keycode != ''){			
			$keycode_where = array('keycode'=> $plan_keycode, 'active' => '1');
			$keycode_details = $this->customers_m->selectdatarow($keycode_where,'subscription_renewal_keys');
			if (count($keycode_details) > 0) {

				if($keycode_details[0]['user_id'] == '0'){

					if(($keycode_details[0]['key_type'] == 'master') || ($keycode_details[0]['key_type'] == 'subscribe')){		

						if($keycode_details[0]['reseller_id'] == $this->session->resellerid) {
							
							if($keycode_details[0]['product_id'] ==  $customers_details[0]['product_id'])
							{
								if($keycode_details[0]['devices_allowed'] ==  $customers_details[0]['DevicesAllowed'])
								{
									return true;
								}else{
									$this->form_validation->set_message('plankeycoderecharge', 'Sorry! Key does not belong to this Device.'.$customers_details[0]['first_name']);
									return false;
								}

							}else{
								$this->form_validation->set_message('plankeycoderecharge', 'Sorry! Key does not belong to Active Product. Please generate key from Current Active Product.');
								return false;	
							}

							
						}
						else{
							$this->form_validation->set_message('plankeycoderecharge', 'Sorry! Key does not belong to you. Please generate key from you account.');
							return false;
						}
					}else{
						$this->form_validation->set_message('plankeycoderecharge', 'Invalid Key.');
						return false;
					}				
				} else{
					$this->form_validation->set_message('plankeycoderecharge', 'Key Already Used.');
					return false;					
				}
			}else{
			 	$this->form_validation->set_message('plankeycoderecharge', 'Invalid Key.');
				return false;
		    }
				 
		}
		
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

	//GET and SET Customer Devices
	public function fetchDevices($customer_id) {
		$customer = $this->reseller_m->selectCustomerInfo($customer_id)[0];
	    $email = $this->toAlphaNumeric($customer['email']);
	    $password = base64_decode($customer['password']);    
	    $url = "https://devices.tvms.axncdn.com/getdevice/?collection_key=" . IMS_CLIENT . "." . CRM . "&document_key=" . $email . "." . $password;
	    
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    $response = curl_exec($ch);
	    curl_close($ch);
	    
	    $devices = json_decode($response, true);
	    return $devices;
	}

	public function editDevice($customer_id, $device_uuid) {
	    $devices = $this->fetchDevices($customer_id);
	    $device = null;
	    foreach ($devices['devices'] as $d) {
	        if ($d['uuid'] == $device_uuid) {
	            $device = $d;
	            break;
	        }
	    }
	    
	    if ($device === null) {
	        show_404();
	    }
	    
	    $this->data['device'] = $device;
	    $this->data['customer_id'] = $customer_id;
	    $this->data['_view'] = CUSTOMER_THEME . 'resellers/edit_device';
	    $this->data['page_title'] = "Edit a Device";
	    $this->load->view(CUSTOMER_THEME . 'resellers/_layout_after', $this->data);
	}

	public function updateDevice($customer_id) {
	    $device = $this->input->post();    
	    $devices = $this->fetchDevices($customer_id);
	    foreach ($devices['devices'] as &$d) {
	        if ($d['uuid'] == $device['uuid']) {
	            $d = array_merge($d, $device);
	            break;
	        }
	    }
	    
	    $result = $this->setDevices($customer_id, $devices);
	    
	    if ($result) {
	        $this->session->set_flashdata('success', 'Device updated successfully');
	    } else {
	        $this->session->set_flashdata('error', 'Failed to update device');
	    }
	    
	    redirect('resellers/editcustomer/' . $customer_id);
	}

	public function deleteDevice($customer_id, $device_uuid) {
	    $devices = $this->fetchDevices($customer_id);
	    $devices['devices'] = array_filter($devices['devices'], function($d) use ($device_uuid) {
	        return $d['uuid'] != $device_uuid;
	    });
	    
	    $this->setDevices($customer_id, $devices);
	    redirect('resellers/editcustomer/' . $customer_id);
	}

	private function setDevices($customer_id, $devices) {
	    $customer = $this->reseller_m->selectCustomerInfo($customer_id)[0];
	    $email = $this->toAlphaNumeric($customer['email']);
	    $password = base64_decode($customer['password']);
	    
	    $url = "https://devices.tvms.axncdn.com/setdevice/";
	    $data = [
	        "collection_key" => IMS_CLIENT . "." . CRM,
	        "document_key" => $email . "." . $password,
	        "document_data" => $devices
	    ];
	    
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, [
	        'Content-Type: application/json',
	        'Accept: application/json'
	    ]);
	    
	    $response = curl_exec($ch);
	    curl_close($ch);

	    $result = json_decode($response, true);
	    return isset($result['success']) || (isset($result['modifiedCount']) && $result['modifiedCount'] > 0);
}
}