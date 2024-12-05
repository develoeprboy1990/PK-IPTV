<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//For Admin Panel
class Customers extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(13);
        $this->load->model('customers_m');
        $this->load->model('settings_m');        
		$this->load->model('reseller_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Customers');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "customers";
        $this->data['sub_nav'] = "customers";
        $this->data['activeTab'] = 1;
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Customers', 'customers');
    }

	public function index()
	{  
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'customers/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'customers/index';
        $this->data['page_title'] = "Customers";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements */
		$where_reseller = array('status'=>'1');
		$this->data['resellers']= $this->customers_m->selectdatarow($where_reseller, 'reseller');

		$this->data['customers']= $this->customers_m->getCustomersWithResellers(1,' ',0); 
		$this->data['migratedCustomers']= $this->customers_m->getCustomersWithResellers(1,'master',1); 
		$this->data['unverifiedCustomers']= $this->customers_m->getCustomersWithResellers(0,'master',2); 
		$this->data['trialCustomers']= $this->customers_m->getCustomersWithResellers(1,'trial',0);
		$this->data['all_customers'] = $this->customers_m->getAllCustomers();
		
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }
	
	//customMakeJsonFile($filename,$localFilePath,'customers','crm',$user_id,$pincode);
	
	public function customMakeJsonFile($final_json_output,$filename,$localFilePath,$filetype,$crm,$user_id,$pincode){ //echo $filename;exit;
		/*$fp = fopen($localFilePath, 'w');
		fwrite($fp, $final_json_output);
		fclose($fp);*/
		$this->uploadToCdnServer($filename,$localFilePath,$filetype,$crm,$user_id,$pincode,$final_json_output);
	}
	public function customJsonGenerater($uname, $pass){
			/*$username = $this->generateUsername($id);
			$password = $this->input->post('password');*/
			$username = $uname;
			$password = $pass;
			//echo $uname.'--------------'.$pass;exit;
			$accountStatus =  array('0'=>'Disabled', '1'=>'Active');
				$user=$this->customers_m->checkuser($username,$password);
				//print_r($user);exit;
                // get product details
                $product=$this->customers_m->get_product($user->id);
                // get plan details
                
                /*$plan=$this->customers_m->get_plan($user->id);
				if($plan->devices_allowed != null)
				{
				$devices_allowed = $plan->devices_allowed;
				}else{*/
				$devices_allowed = $user->devices_allowed;
				/*}*/

                // get productlocation
                $location=$this->customers_m->get_product_location($product->id);
                // get total extra channel packages
                $channel_packages=$this->customers_m->get_channel_packages($user->id);
                // get total extra Movie Stores
                $movie_stores=$this->customers_m->get_movie_stores($user->id);
                // get total extra Series Stores
                $series_stores=$this->customers_m->get_series_stores($user->id);
                // get music categories
                $music_categories=$this->customers_m->get_music_categories($user->id);
				
				//$msg = $this->customers_m->get_message_customers($user->id);
			   $return_array = array('account'=>array(
                                            'date_expired'=>date('d M Y',strtotime($user->subscription_expire)),
                                            //'datetime_expired'=>$user->subscription_expire,
											'datetime_expired'=>date('m/d/Y H:i:s A',strtotime($user->subscription_expire)),
                                            /*'resellerid'=>$user->reseller_id,*/
											'resellerid' => '0',
                                            'account_status'=> $accountStatus[$user->status],
                                            'max_concurrent_devices' =>$devices_allowed, 
                                            'allow_inapp_theme_change' => $user->allow_theme ? true : false,
                                            'staging'=>$user->allow_theme ? true : false,
			   								'isBeta' =>$user->is_beta ? true : false),
                                 	'customer'=>array(
                                            'walletbalance'=>$user->walletbalance,
                                            'currency'=>$user->currency),
									'products'=>array(
											"productid"=>$product->id,
											"productname"=>$product->name,
											'ChannelPackages'=>$channel_packages,
											'MovieStores'=>$movie_stores,
											'MusicPackages'=>$music_categories,
											'SeriesStores'=>$series_stores),
                                 	'payperview'=>array(
                                            "movies"=>$movie_stores,
                                            "seasons"=>[],
                                            "albums"=>$movie_stores,
                                            "channels"=>[]),
                                 	'storage'=>array(
                                            "total"=>0,
                                            "used"=>0,
                                            "total_hours"=>0),
									'profiles'=>[array(
                                                "id"=>$user->id,
                                                "name"=>$user->first_name. " ".$user->last_name,
                                                "recommendations"=>"[]",
                                                "mode"=>"regular",
                                                "avatar"=>""
                                                )],
                                 'messages' => [],
                                 'recordings'=>[]
								);
              // $final_json_output = json_encode(json_encode($return_array, JSON_UNESCAPED_SLASHES));
		 $final_json_output = json_encode(json_encode($return_array, JSON_UNESCAPED_SLASHES), JSON_UNESCAPED_SLASHES);
			   return $final_json_output;
	}

    public function details($id = NULL,$tab = 1){ 
        check_allow('edit',$this->data['is_allow']);
        $created_by = '';
        $this->load->model('devices_m'); 
        $this->load->model('logs_m');
        $this->load->model('messages_m'); 
        $this->load->model('products_m');
        $this->load->model('packages_m');
        $this->load->model('movie_stores_m');
        $this->load->model('series_stores_m');
        $this->load->model('music_categories_m');
        $this->load->model('dynamic_dependent_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'customers' ) : '';
        $rules = $this->customers_m->edit_rules;
        unset($rules['password']);
        $this->form_validation->set_rules($rules);
        $info=$this->customers_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        } 
        if($this->form_validation->run()==TRUE){
			$dataGet = $this->array_from_post($post);
			$first_ch = substr(trim($dataGet['mobile']),0,1);
			if ($first_ch==0){
				$mobile = substr(trim($dataGet['mobile']), 1);
			}else{
				$mobile = trim($dataGet['mobile']);
			}
			
			$dataSet = array(
				"title"=>$dataGet['title'],
				"first_name"=>$dataGet['first_name'],
				"last_name"=>$dataGet['last_name'],
				"phone"=>$dataGet['phone'],
				"c_code"=>$dataGet['c_code'],
				"mobile"=>$mobile,
				"email"=>strtolower($dataGet['email']),
				"alpha_email"=>$this->toAlphaNumeric(strtolower($dataGet['email'])),
				"billing_street"=>$dataGet['billing_street'],
				"billing_zip"=>$dataGet['billing_zip'],
				"billing_city"=>$dataGet['billing_city'],
				"billing_state"=>$dataGet['billing_state'],
				"billing_country"=>$dataGet['billing_country'],
				"allow_theme"=>$dataGet['allow_theme'],
				"is_beta"=>$dataGet['is_beta']
			);
            $data = $dataSet;
			//print_r($data);exit;
            $this->customers_m->save($id,$data);

            //change Password 
            /*if($this->input->post('change_password')==1 && $this->input->post('password')!=""){
            	
            	$data=array('password'=>base64_encode($this->input->post('password')),
							'alpha_password'=>base64_encode($this->toAlphaNumeric(trim($this->input->post('password')))));
                $this->customers_m->save($id,$data);
            }*/

			if($this->input->post('change_password')==1 && $this->input->post('password')!=""){
				$current_password = base64_decode($info->password);
				$new_password = $this->input->post('password');

				if($current_password !== $new_password){
					// Delete old file
					$old_alpha_password = $this->toAlphaNumeric(trim($current_password));
					$old_filename = $old_alpha_password . '.json';
					$old_userid = implode("/", str_split($this->toAlphaNumeric($info->email)));
					$old_filepath = LOCAL_PATH_CUSTOMER . $old_userid . '/' . $old_filename;

					if(file_exists($old_filepath)){
						unlink($old_filepath);
					}

					// Save new password
					$data = array(
						'password' => base64_encode($new_password),
						'alpha_password' => base64_encode($this->toAlphaNumeric(trim($new_password)))
					);
					$this->customers_m->save($id, $data);
				}
			}
			
						
			//print_r($id);exit;
            $this->userlogs->track_this($id, $info->first_name." ".$info->last_name." profile is updated on ". date('Y-m-d H:i:s',time()));
            //$this->userlogs->track_this($id, "Customer ID ".$info->username." Updated");
            $this->session->set_flashdata('success',"Customer Edited Successfully.");
			
			
			//==================================================================================================
			$user_id = $dataGet['email'];
			$pincode = $this->input->post('password');
			$alpha_password = $this->toAlphaNumeric(trim($this->input->post('password')));
			/*$user_id = implode("/",str_split($this->toAlphaNumeric($user_id)));
			$pincode = $this->toAlphaNumeric($pincode);*/
			
			//final json file will be like this 
			
			//$filename = $id.'_customers.json';
			/*$filename = $id.'_customers.json';*/
			$filename = $alpha_password.'.json';
			/*$remotepath = $user_id."/".$pincode.".json";
			$remotedir = $user_id;*/
			//echo $remotedir;exit;
			//$localFilePath = './jsons/customers/'.$filename;
			$userid1 = implode("/",str_split($this->toAlphaNumeric($user_id)));
			$localFilePath = LOCAL_PATH_CUSTOMER.$userid1.'/'.$filename;
			
			$username = $this->generateUsername($id);
			$password = $this->input->post('password');
			
			//echo $localFilePath;exit;
			$final_json_output = $this->customJsonGenerater($username, $password);
			//echo $final_json_output;exit;
			//$final['CID'] = encrypt($final_json_output, 2);
			//echo $final_json_output;exit;
			/*$fp = fopen($localFilePath, 'w');
			fwrite($fp, $final_json_output);
			fclose($fp);
			$this->uploadToCdnServer($filename,$localFilePath,'customers','crm',$user_id,$pincode);*/
			
			$this->customMakeJsonFile($final_json_output,$filename,$localFilePath,'customers','',$user_id,$pincode);
			//=========================================================================================================================
			
			
			
			
            redirect(BASE_URL.'customers');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Customer', 'customers/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
         /* Countries */
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();
        /* States */
        $this->data['billing_states']=$this->dynamic_dependent_m->get_states($info->billing_country);
        
        /* Cities */
       // $this->data['billing_cities']=$this->dynamic_dependent_m->get_cities($info->billing_state);
         
        /* products */
        $this->data['products']=$this->products_m->get();

        /* plans */
        $where = array('product_id'=>$info->product_id);
		$this->data['product_plans'] = $this->reseller_m->getAllCodeWhere('reseller_panel_subscription',$where);


        /* Devices */
        //$this->data['devices']=$this->devices_m->get_devices_by_customer($id);
        $this->data['devices'] = $this->fetchDevices($id);

        /* Subscriptions */
        $product_info = $this->products_m->get_product_by_user($id);
        $this->data['current_product'] = $product_info;

        // get plan details
        $this->data['current_plan']=$this->customers_m->get_plan($id);
        
        /* Channel Packages */
        $this->data['packages']= $this->packages_m->get();
        $this->data['selected_packages']= $this->customers_m->get_channel_packages_by_customer($id);

        /* Movie Stores */
        $this->data['movie_stores']= $this->movie_stores_m->get_parent_store();
        $this->data['selected_movie_stores']= $this->customers_m->get_movie_stores_by_customer($id);

        /* Series Stores */
        $this->data['series_stores']= $this->series_stores_m->get();
        $this->data['selected_series_stores']= $this->customers_m->get_series_stores_by_customer($id);

        /* Music Stores */
        $this->data['music_categories']= $this->music_categories_m->get();
        $this->data['selected_music_categories']= $this->customers_m->get_music_categories_by_customer($id);

        /* Messages */
        $this->data['messages']=$this->messages_m->getMessages($id);

        /* Logs */
        $this->data['logs']=$this->logs_m->getLogs($id);

        /* Debug Logs */
        $this->data['debug_logs']=$this->logs_m->getDebugLogs($id);


        /* reseller */        
        if($info->reseller_id != 0)
        {
        	$reseller_info = $this->reseller_m->getReseller($info->reseller_id);
        	
        	$this->data['customer_type']  = 'Reseller: '.$reseller_info[0]['name'] .'| Role: Reseller';
        }else{
        	$this->data['customer_type']  = 'Reseller: Admin | Role: Admin';
        }

		//print_r(DEFAULT_THEME . 'customers/details');exit;
        $this->data['details'] = $info;
        $this->data['activeTab'] = $tab;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'customers/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'customers/details';
        $this->data['page_title'] = "Edit a Customer";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }


	public function emailCheckAvailable(){
		$user_email = $_REQUEST['email'];
		//echo $user_email.'===========';
		if($this->customers_m->get_email_check_available($user_email)){
			echo 'available';
		}else{
			echo 'notavailable';
		}
	}	
		
    public function create(){
        check_allow('create',$this->data['is_allow']);
        $this->load->model('products_m');
        $this->load->model('dynamic_dependent_m');
        $rules = $this->customers_m->add_rules;
        $this->form_validation->set_rules($rules);
        $post=array();
        
        if($this->form_validation->run()==TRUE){
            foreach($rules as $key=>$value){
                $post[]=$key;
            }
 			$dataGet = $this->array_from_post($post);
            //$data = $this->array_from_post($post);
			//print_r($data);exit;
			$where_products = array('id'=>$dataGet['product_id']);
			$select_products = $this->customers_m->selectdatarow($where_products, 'products');

			$where_plan = array('id'=>$dataGet['plan_id']);
			$select_plan = $this->customers_m->selectdatarow($where_plan, 'reseller_panel_subscription');

			$devices_allowed = $select_plan[0]['devices_allowed'];

			$now_time = date("Y-m-d H:i:s");
			$valid_time = "+".$select_plan[0]['length_months'].' '.$select_plan[0]['month_day'];
			//$valid_time = "+".$select_products[0]['subscription_length'].' '.$select_products[0]['subscription_days_or_month'];
			$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));
			
			$first_ch = substr(trim($dataGet['mobile']),0,1);
			if ($first_ch==0){
				$mobile = substr(trim($dataGet['mobile']), 1);
			}else{
				$mobile = trim($dataGet['mobile']);
			}
			
			$dataSet = array(
							"title"=>$dataGet['title'],
							"first_name"=>$dataGet['first_name'],
							"last_name"=>$dataGet['last_name'],
							"c_code"=>$dataGet['c_code'],
							"phone"=>$dataGet['mobile'],
							"mobile"=>$mobile,
							"email"=>strtolower($dataGet['email']),
							"alpha_email"=>$this->toAlphaNumeric(strtolower($dataGet['email'])),
							"billing_street"=>$dataGet['billing_street'],
							"billing_zip"=>$dataGet['billing_zip'],
							"billing_city"=>$dataGet['billing_city'],
							"billing_state"=>$dataGet['billing_state'],
							"billing_country"=>$dataGet['billing_country'],
							"product_id"=>$dataGet['product_id'],
							"plan_id"=>$dataGet['plan_id'],
							"plan_type"=>$select_plan[0]['plan_type'],
							"allow_theme"=>$dataGet['allow_theme'],
							"is_beta"=>$dataGet['is_beta'],
							"product_activation_key_id"=>$dataGet['product_id'],
							"devices_allowed"=>$devices_allowed,
							"sebscription_trpe" => 'aproduct',
							'subscription_expire'=>$subscription_expire, 
							);
            $data = $dataSet;
			
            $insert_id=$this->customers_m->save(NULL,$data);
			//Subscription Log
			//============================================================================================================================
			$this->load->model('customerpanel_m');
			$data_customers = array('subscription_expire'=>$subscription_expire, 
									'product_activation_key_id' => $dataGet['product_id'], 
									'product_id' => $dataGet['product_id'],
									"plan_id"=>$dataGet['plan_id'],
									'devices_allowed' => $dataGet['devices_allowed'],
									'activation_code' => '',
									'walletbalance' => '',
									'sebscription_trpe' => 'aproduct',
									'date_created'=>date("Y-m-d H:i:s"));
			$log_text_array = $this->customerpanel_m->getdataall('plan_history',array('used_id' => $insert_id));
			
			 if(count($log_text_array) > 0){
			 	 $log_text_array_log = json_decode($log_text_array[0]['log_json']);	
				 $log_array[] = $data_customers;
				 foreach($log_text_array_log as $val){
				 	$log_array[] = $val;
				 }							 			 	
			 	 $log_text = json_encode($log_array);
				 						 
				 $log_data = array('used_id'=>$user_id, 'log_json' => $log_text);
				 $this->customerpanel_m->update_key($log_data,array('used_id' => $insert_id), 'plan_history');
				// echo $log_text;exit;
				
			 }else{		
			 	$log_array[] = $data_customers;			 					 
		     	$log_data = array('used_id'=>$insert_id, 'log_json' => json_encode($log_array));					
			 	$this->customerpanel_m->insert('plan_history',$log_data);
			 }
					 
			//==============================================================================================================================		 
            //generate username and password
			
			$username= $this->generateUsername($insert_id);
            $password= $this->generatePassword();
			
			//========================================================================================================		
			
			$user_id = $data['email'];
			$pincode = $password;
			$alpha_password = $this->toAlphaNumeric(trim($password));
			/*$user_id = implode("/",str_split($this->toAlphaNumeric($user_id)));
			$pincode = $this->toAlphaNumeric($pincode);*/
			
			//final json file will be like this 
			
			/*$filename = $pincode.'.json';*/
			$filename = $alpha_password.'.json';
			/*$remotepath = $user_id."/".$pincode.".json";
			$remotedir = $user_id;*/
			//echo $remotedir;exit;
			//$localFilePath = './jsons/customers/'.$filename;
			$userid1 = implode("/",str_split($this->toAlphaNumeric($user_id)));
			$localFilePath = LOCAL_PATH_CUSTOMER.$userid1.'/'.$filename;
			/* Encryption */
			/*$final_json_output = json_encode($data, JSON_UNESCAPED_SLASHES);
			//$final['CID'] = encrypt($final_json_output, 2);
			//echo $final_json_output;exit;
			$fp = fopen($localFilePath, 'w');
			fwrite($fp, $final_json_output);
			fclose($fp);
			$this->uploadToCdnServer($filename,$localFilePath,'customers','crm',$user_id,$pincode);*/
			
			//echo  $user_id."/".$pincode.".json";exit;
			
			
			
			//======================================================================================================================					
            
            $data=array('pin'=>$username,
                        'username'=>$username,
                        'password'=>base64_encode($password),
						"alpha_password"=>base64_encode($this->toAlphaNumeric($password)),
                        'status' =>1
                        );
            $this->customers_m->save($insert_id,$data);
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers/details/'.$insert_id).'" target="_blank">Customer Added</a>');   

            $product_info=$this->products_m->get_by(array('id'=>$this->input->post('product_id')), TRUE);
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers/details/'.$insert_id).'" target="_blank">Product '.$product_info->name.' added to Customer </a>');   
                              
            // Send Email Notification
            $this->load->model('email_templates_m','EM');
            $template=$this->EM->get_email_template("user_added_notification");
            
            $login_link="<a href='".site_url('customer/login/')."'>".site_url('customer/login/')."</a>";
            $parse_data=array('FIRST_NAME'=>$this->input->post('first_name'),
                              'USERNAME'=>$this->input->post('email'),
                              'PASSWORD'=>$password,
                              'LOGIN_LINK'=>$login_link,
                              'EMAIL' => $this->input->post('email')                             
                            );
            
            // send email to customer
            $this->load->model('Email_model');
            $email_status=$this->Email_model->send_email($template,$parse_data);


			//==========================================================================
				/*$accountStatus =  array('0'=>'Disabled', '1'=>'Active');
				$user=$this->customers_m->checkuser($username,$password);
				//print_r($user);exit;
                // get product details
                $product=$this->customers_m->get_product($user->id);
                // get productlocation
                $location=$this->customers_m->get_product_location($product->id);
                // get total extra channel packages
                $channel_packages=$this->customers_m->get_channel_packages($user->id);
                // get total extra Movie Stores
                $movie_stores=$this->customers_m->get_movie_stores($user->id);
                // get total extra Series Stores
                $series_stores=$this->customers_m->get_series_stores($user->id);
                // get music categories
                $music_categories=$this->customers_m->get_music_categories($user->id);
                // get total extra Music packages
                $return_array=array('account'=>array('date_expired'=>date('Y-m-d',strtotime($user->subscription_expire)),
					'account_status' => $accountStatus[$user->status],
                    'datetime_expired'=>$user->subscription_expire,
                    'reseller_id'=>$user->reseller_id),
                    'customer'=>array('walletbalance'=>$user->walletbalance,
                        'currency'=>$user->currency),
                    'products'=>array('productid'=>$product->id,
                        'productname'=>$product->name,
                        'productlocation'=>$location->url,
                        'ChannelPackages'=>$channel_packages,
                        'MovieStores'=>$movie_stores,
                        'MusicPackages'=>$music_categories,
                        'SeriesStores'=>$series_stores
                    ),
                    'payperview'=>array('movies'=>array(),
                        'seasons'=>array(),
                        'albums'=>array(),
                        'channels'=>array()
                    ),
                    'storage'=>array('total'=>0,
                        'used'=>0.0
                    ),
                    'recordings'=>array()
                );
               $final_json_output = json_encode($return_array, JSON_UNESCAPED_SLASHES);
			//$final['CID'] = encrypt($final_json_output, 2);
			//echo $final_json_output;exit;
			$fp = fopen($localFilePath, 'w');
			fwrite($fp, $final_json_output);
			fclose($fp);
			$this->uploadToCdnServer($filename,$localFilePath,'customers','crm',$user_id,$pincode);*/
            
			$final_json_output = $this->customJsonGenerater($username,$password);
		    $this->customMakeJsonFile($final_json_output, $filename,$localFilePath,'customers','',$user_id,$pincode);
		   
			//===========================================================================	
			
            if($email_status){
                $this->session->set_flashdata('success',"Customer Added Successfully.");
                redirect(BASE_URL.'customers');
            }
			
        }

        // If validation fails, we need to maintain the plan dropdown
        if($this->input->post('product_id')) {
            $where = array('product_id' => $this->input->post('product_id'));
            $this->data['plans'] = $this->reseller_m->getAllCodeWhere('reseller_panel_subscription', $where);
        }

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Customer', 'customers/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* Countries */
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();

        /* products */
        $this->data['products']=$this->products_m->get();

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'customers/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'customers/create';
        $this->data['page_title'] = "Add a new Customer";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){
       check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'customers' ) : '';
        
        $info=$this->customers_m->get_by(array('id'=>$id), TRUE);
        $this->customers_m->delete($id);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers').'" target="_blank">Customer Deleted</a>');   
        $this->session->set_flashdata('success',"Customer Deleted Successfully.");
        redirect( BASE_URL . 'customers' );
    }

    public function edit($id = NULL){   
        check_allow('edit',$this->data['is_allow']);
        $this->load->model('products_m');
        $this->load->model('dynamic_dependent_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'customers' ) : '';
        $rules = $this->customers_m->edit_rules;
        unset($rules['password']);
        $this->form_validation->set_rules($rules);
        $info=$this->customers_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->customers_m->save($id,$data);

            //change Password 
            if($this->input->post('change_password')==1 && $this->input->post('password')!=""){
                $data=array('password'=>base64_encode($this->input->post('password')));
                $this->customers_m->save($id,$data);
            }
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers/details/'.$id).'" target="_blank">Customer Updated</a>');   
            $this->session->set_flashdata('success',"Customer Edited Successfully.");
            redirect(BASE_URL.'customers');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Customer', 'customers/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
         /* Countries */
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();
        /* States */
        $this->data['billing_states']=$this->dynamic_dependent_m->get_states($info->billing_country);
        /* Cities */
        $this->data['billing_cities']=$this->dynamic_dependent_m->get_cities($info->billing_state);
         
        /* products */
        $this->data['products']=$this->products_m->get();
              
        $this->data['details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'customers/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'customers/edit';
        $this->data['page_title'] = "Edit a Customer";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function disable($id = NULL){
        check_allow('delete',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'customers' ) : '';
        $info=$this->customers_m->get($id,TRUE);
        $data=array('status'=>0);
        $this->customers_m->save($id,$data);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers/details/'.$id).'" target="_blank">Customer Disabled</a>');   
        $this->session->set_flashdata('success',"Customer Disabled Successfully.");
		
		//==========================================================================================================================	
		$dddd = $this->customers_m->getCustomerInfo($id);		
		$username = $this->generateUsername($dddd->id);
		$password = base64_decode($dddd->password);
		$alpha_password = base64_decode($dddd->alpha_password);
		
		$user_id = $dddd->email;
		$pincode = $password;
		//final json file will be like this 
		$filename = $alpha_password.'.json';
		//$localFilePath = './jsons/customers/'.$filename;
		$userid1 = implode("/",str_split($this->toAlphaNumeric($user_id)));
		$localFilePath = LOCAL_PATH_CUSTOMER.$userid1.'/'.$filename;
        //updated customers 
        /*$data=array('subscription_expire'=>$this->input->post('subscription_expire'));
        $this->customers_m->save($customer_id,$data);*/
		
      	$final_json_output = $this->customJsonGenerater($username,$password);		
		$this->customMakeJsonFile($final_json_output, $filename,$localFilePath,'customers','',$user_id,$pincode);
		//=========================================================================================================================
		
		
        redirect( BASE_URL . 'customers' );
    }

    public function activate($id = NULL){
        check_allow('delete',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'customers' ) : '';
        $info=$this->customers_m->get($id,TRUE);
        
        $data=array('status'=>1);
        $this->customers_m->save($id,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers/details/'.$id).'" target="_blank">Customer Activated</a>');   
        //==========================================================================================================================	
		$dddd = $this->customers_m->getCustomerInfo($id);		
		$username = $this->generateUsername($dddd->id);
		$password = base64_decode($dddd->password);
		$alpha_password = base64_decode($dddd->alpha_password);
		
		$user_id = $dddd->email;
		$pincode = $password;
		//final json file will be like this 
		//$filename = $pincode.'.json';
		$filename = $alpha_password.'.json';
		//$localFilePath = './jsons/customers/'.$filename;
		$userid1 = implode("/",str_split($this->toAlphaNumeric($user_id)));
		$localFilePath = LOCAL_PATH_CUSTOMER.$userid1.'/'.$filename;
        //updated customers 
       /* $data=array('subscription_expire'=>$this->input->post('subscription_expire'));
        $this->customers_m->save($customer_id,$data);*/
		
      	$final_json_output = $this->customJsonGenerater($username,$password);		
		$this->customMakeJsonFile($final_json_output, $filename,$localFilePath,'customers','',$user_id,$pincode);
		//=========================================================================================================================
        $this->session->set_flashdata('success',"Customer Activated Successfully.");
        redirect( BASE_URL . 'customers' );
    }

    public function addComments($customer_id){
		$dddd = $this->customers_m->getCustomerInfo($customer_id);
				
		$username = $this->generateUsername($dddd->id);
		$password = base64_decode($dddd->password);
		$alpha_password = base64_decode($dddd->alpha_password);
		//print_r($password);exit;
		$user_id = $dddd->email;
		$pincode = $password;
		//final json file will be like this 
		//$filename = $dddd->id.'_customers.json';
		//$filename = $pincode.'.json';
		$filename = $alpha_password.'.json';
		//$localFilePath = './jsons/customers/'.$filename;
		$userid1 = implode("/",str_split($this->toAlphaNumeric($user_id)));
		$localFilePath = LOCAL_PATH_CUSTOMER.$userid1.'/'.$filename;	
        //updated customers 
        if($this->input->post('comments') && $this->input->post('comments')!=""){
            $data=array('comments'=>$this->input->post('comments'));
            $this->customers_m->save($customer_id,$data);
            
           // $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers/details/'.$id).'" target="_blank">Comments Added</a>');   
		   $this->userlogs->track_this($customer_id,$this->input->post('comments'));
		   
		   $final_json_output = $this->customJsonGenerater($username,$password);
		   $this->customMakeJsonFile($final_json_output, $dddd->id.'.json',$localFilePath,'customers','',$user_id,$pincode);
		   
           $this->session->set_flashdata('success',"Comments Added Successfully.");
           redirect(BASE_URL.'customers/details/'.$customer_id);
        }
    }

    public function extendDate($customer_id){ 
		$customer_details = $this->customers_m->getCustomerInfo($customer_id);		
		if($this->input->post('subscription_expire') && $this->input->post('subscription_expire')!=""){
			//updated customers 
			$data=array('subscription_expire'=>$this->input->post('subscription_expire'));
			$this->customers_m->save($customer_id,$data);
			
		    // Customer Log
			 //=====================================================================================================================
			 $data_customers_log = array('subscription_expire'=>$this->input->post('subscription_expire'), 
											'product_activation_key_id' => $customer_details->product_activation_key_id, 
												'product_id' => $customer_details->product_id,
													'devices_allowed' => $customer_details->devices_allowed,
														'activation_code' => $customer_details->activation_code,
															'walletbalance' => $customer_details->walet_money,
															'sebscription_trpe' => $customer_details->sebscription_trpe,
															'date_created'=>date("Y-m-d H:i:s")
											);
					 $this->load->model('customerpanel_m');
					 $log_text_array = $this->customerpanel_m->getdataall('plan_history',array('used_id' => $customer_id));
					// echo '<pre>';
				 
					 if(count($log_text_array) > 0){
					 	 $log_text_array_log = json_decode($log_text_array[0]['log_json']);	
						 $log_array[] = $data_customers_log;
						 foreach($log_text_array_log as $val){
						 	$log_array[] = $val;
						 }							 			 	
					 	 $log_text = json_encode($log_array);
						// print_r($log_array);exit;						 
						 $log_data = array('used_id'=>$customer_id, 'log_json' => $log_text);
						 $this->customerpanel_m->update_key($log_data,array('used_id' => $customer_id), 'plan_history');
						// echo $log_text;exit;
						
					 }else{		
					 	$log_array[] = $data_customers_log;			 					 
				     	$log_data = array('used_id'=>$customer_id, 'log_json' => json_encode($log_array));					
					 	$this->customerpanel_m->insert('plan_history',$log_data);
					 }
					 
			//=====================================================================================================================	
			
			$this->userlogs->track_this($customer_id,'<a href="'.site_url('customers/details/'.$customer_id.'/2').'" target="_blank">Subscription Date Extended to '.$this->input->post('subscription_expire').'</a>');  
			
			$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers/details/'.$customer_id.'/2').'" target="_blank">Subscription Date Extended to '.$this->input->post('subscription_expire').'</a>'); 
			 
			$this->session->set_flashdata('success',"Subscription Extended Successfully.");
			
			//$dddd = $this->customers_m->getCustomerInfo($customer_id);		
			$username = $this->generateUsername($customer_details->id);
			$password = base64_decode($customer_details->password);
			$alpha_password = base64_decode($customer_details->alpha_password);
			
			$user_id = $customer_details->email;
			$pincode = $password;
			//final json file will be like this 
			//$filename = $pincode.'.json';
			$filename = $alpha_password.'.json';
			//$localFilePath = './jsons/customers/'.$filename;
			$userid1 = implode("/",str_split($this->toAlphaNumeric($user_id)));
			$localFilePath = LOCAL_PATH_CUSTOMER.$userid1.'/'.$filename;
			//updated customers 
			/*$data=array('subscription_expire'=>$this->input->post('subscription_expire'));
			$this->customers_m->save($customer_id,$data);*/
			$final_json_output = $this->customJsonGenerater($username,$password);
			$this->customMakeJsonFile($final_json_output, $filename,$localFilePath,'customers','',$user_id,$pincode);		
		}
		
        redirect(BASE_URL.'customers/details/'.$customer_id.'/2');
    }
    
    public function updateWallet($customer_id){
		$customer_details = $this->customers_m->getCustomerInfo($customer_id);
        $rules=array(
            'wallet_balance' => array(
            'field' => 'wallet_balance',
            'label' => 'Wallet Balance',
            'rules' => 'required|numeric|trim')
            );
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            //updated customers 
            $data=array('walletbalance'=>$this->input->post('wallet_balance'));
            $this->customers_m->save($customer_id,$data);
            			 // log of wallet 
						//=====================================================================================================
								$wallet_price_add = $this->input->post('wallet_balance') - $customer_details->walletbalance;
								$data_wallet_log = array('recharge_date'=>date('Y-m-d H:i:s'), 
															'wallet_key' => 'By Admin', 
																'price' => $wallet_price_add
															);
								 $this->load->model('customerpanel_m');
								$log_text_array = $this->customerpanel_m->getdataall('plan_history',array('used_id' => $customer_id));
								
								 if(count($log_text_array) > 0){
								 	 if($log_text_array[0]['waller_log'] != ''){
										 $log_text_array_log = json_decode($log_text_array[0]['waller_log']);	
										 $log_array[] = $data_wallet_log;
										 foreach($log_text_array_log as $val){
											$log_array[] = $val;
										 }							 			 	
										 $log_text = json_encode($log_array);
																 
										 $log_data = array('used_id'=>$customer_id, 'waller_log' => $log_text);
										 $this->customerpanel_m->update_key($log_data,array('used_id' => $customer_id), 'plan_history');
										
										//print_r($log_data);
										// echo $log_text;exit;
										
									 }else{		
										$log_array[] = $data_wallet_log;			 					 
										$log_data = array('used_id'=>$customer_id, 'waller_log' => json_encode($log_array));
										
										//print_r($log_data);					
										$this->customerpanel_m->update_key($log_data,array('used_id' => $customer_id), 'plan_history');
									 }
								 }else{
								 		$log_array[] = $data_wallet_log;			 					 
										$log_data = array('used_id'=>$customer_id, 'waller_log' => json_encode($log_array));					
										//$this->customerpanel_m->insert('plan_history',$log_data);
								 }		
					 
			//=====================================================================================================================	
			
			
				 
			  $this->userlogs->track_this($customer_id,'<a href="'.site_url('customers/details/'.$customer_id.'/2').'" target="_blank">Wallet Updated to $'.$this->input->post('wallet_balance').'</a>');             
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers/details/'.$customer_id.'/2').'" target="_blank">Wallet Updated to $'.$this->input->post('wallet_balance').'</a>');   
            $this->session->set_flashdata('success',"Wallet Balance Updated Successfully.");
			
		//=========================================================================================================================	
		//$dddd = $this->customers_m->getCustomerInfo($customer_id);		
		$username = $this->generateUsername($customer_details->id);
		$password = base64_decode($customer_details->password);
		$alpha_password = base64_decode($customer_details->alpha_password);
		
		$user_id = $customer_details->email;
		$pincode = $password;
		//final json file will be like this 
		//$filename = $dddd->id.'_customers.json';
		$filename = $alpha_password.'.json';
		//$localFilePath = './jsons/customers/'.$filename;
		$userid1 = implode("/",str_split($this->toAlphaNumeric($user_id)));
		$localFilePath = LOCAL_PATH_CUSTOMER.$userid1.'/'.$filename;
        //updated customers 
       /* $data=array('subscription_expire'=>$this->input->post('subscription_expire'));
        $this->customers_m->save($customer_id,$data);*/
		
      	$final_json_output = $this->customJsonGenerater($username,$password);		
		$this->customMakeJsonFile($final_json_output, $filename,$localFilePath,'customers','crm',$user_id,$pincode);
		//=========================================================================================================================
		
            redirect(BASE_URL.'customers/details/'.$customer_id.'/2');
        }

		
		
		
        $this->session->set_flashdata('error',"Error ! Please input the correct Wallet Balance Amount.");
        redirect(BASE_URL.'customers/details/'.$customer_id.'/2');
    }

	public function resendRegistration($customer_id){
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
			redirect(BASE_URL.'customers/details/'.$customer_id.'/2');
			
	}
	
    public function changeSubscription($customer_id){
        $this->load->model('products_m');

        $info=$this->customers_m->get($customer_id,TRUE);

        if($this->input->post('product_id') && $this->input->post('product_id')!="" && $info->reseller_id == 0){

        	$plan_id = $this->input->post('plan_id');

        	$where_plan = array('id'=>$plan_id);
			$select_plan = $this->customers_m->selectdatarow($where_plan, 'reseller_panel_subscription');


        	$now_time = date("Y-m-d H:i:s");
			$valid_time = "+".$select_plan[0]['length_months'].' '.$select_plan[0]['month_day'];
			$subscription_expire = date('Y-m-d H:i:s', strtotime($valid_time, strtotime($now_time)));


			$devices_allowed = $select_plan[0]['devices_allowed'];
			

            //updated customers 
            $data=array('product_id'=>$this->input->post('product_id'),
                        'plan_id'=>$this->input->post('plan_id'),
                        'subscription_expire'=>$subscription_expire,
                        "product_activation_key_id"=>$this->input->post('product_id'),
						"devices_allowed"=>$devices_allowed,
						"sebscription_trpe" => 'aproduct'
                        );

            $this->customers_m->save($customer_id,$data);

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers/details/'.$customer_id.'/2').'" target="_blank">Product Plan Updated</a>');              
            $this->session->set_flashdata('success',"Plan Updated Successfully.");
			
		//==========================================================================================================================	
		$dddd = $this->customers_m->getCustomerInfo($customer_id);		
		$username = $this->generateUsername($dddd->id);
		$password = base64_decode($dddd->password);
		$alpha_password = base64_decode($dddd->alpha_password);
		
		$user_id = $dddd->email;
		$pincode = $password;
		//final json file will be like this 
		//$filename = $pincode.'.json';
		$filename = $alpha_password.'.json';
		//$localFilePath = './jsons/customers/'.$filename;
		$userid1 = implode("/",str_split($this->toAlphaNumeric($user_id)));
		$localFilePath = LOCAL_PATH_CUSTOMER.$userid1.'/'.$filename;
        //updated customers 
        /*$data=array('subscription_expire'=>$this->input->post('subscription_expire'));
        $this->customers_m->save($customer_id,$data);*/
		
      	$final_json_output = $this->customJsonGenerater($username,$password);		
		$this->customMakeJsonFile($final_json_output, $filename,$localFilePath,'customers','',$user_id,$pincode);
		//=========================================================================================================================
		
            redirect(BASE_URL.'customers/details/'.$customer_id.'/2');
        }

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Customer', 'customers/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        
        /* Subscriptions */
        $product_info = $this->products_m->get_product_by_user($customer_id);
        $this->data['product'] = $product_info;

        // get plan details
        $this->data['product_plan']=$this->customers_m->get_plan($customer_id);


        /* products */
        $this->data['products']=$this->products_m->get();

        /* plans */
        $where = array('product_id'=>$info->product_id);
		$this->data['product_plans'] = $this->reseller_m->getAllCodeWhere('reseller_panel_subscription',$where);


		/* reseller */        
        if($info->reseller_id != 0)
        {
        	$reseller_info = $this->reseller_m->getReseller($info->reseller_id);
        	$this->data['customer_type'] = $reseller_info[0]['name'];
        }else{
        	$this->data['customer_type'] = 'Admin';
        }

        /* packages */
        $this->data['packages']= $this->packages_m->get(); 
        $this->data['selected_packages']= $this->customers_m->get_channel_packages_by_customer($customer_id);
        $this->data['details']=$this->customers_m->get($customer_id,TRUE);
        $this->data['customer_id']=$customer_id;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'customers/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'customers/change_subscription';
        $this->data['page_title'] = "Change Subscription";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function removeDevice($device_id,$customer_id){
        $this->db->delete('customer_to_devices', array('id' =>$device_id));
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers/details/'.$customer_id.'/3').'" target="_blank">Device Removed</a>');              
        $this->session->set_flashdata('success',"Device Removed Successfully.");
        redirect(BASE_URL.'customers/details/'.$customer_id.'/3');
    }

    public function deleteLog($log_id,$customer_id){
        $this->load->model('logs_m');
        $this->logs_m->delete($log_id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers/details/'.$customer_id.'/5').'" target="_blank">Customer Log Deleted</a>');              
        $this->session->set_flashdata('success',"Log Deleted Successfully.");
		
		//==========================================================================================================================	
		$dddd = $this->customers_m->getCustomerInfo($customer_id);		
		$username = $this->generateUsername($dddd->id);
		$password = base64_decode($dddd->password);
		
		$user_id = $dddd->email;
		$pincode = $password;
		//final json file will be like this 
		//$filename = $pincode.'.json';
		$filename = $customer_id.'.json';
		//$localFilePath = './jsons/customers/'.$filename;
		$userid1 = implode("/",str_split($this->toAlphaNumeric($user_id)));
		$localFilePath = LOCAL_PATH_CUSTOMER.$userid1.'/'.$filename;
        //updated customers 
       /* $data=array('subscription_expire'=>$this->input->post('subscription_expire'));
        $this->customers_m->save($customer_id,$data);*/
		
      	$final_json_output = $this->customJsonGenerater($username,$password);		
		$this->customMakeJsonFile($final_json_output, $filename,$localFilePath,'customers','',$user_id,$pincode);
		//=========================================================================================================================
		
        redirect(BASE_URL.'customers/details/'.$customer_id.'/5');
    }

    public function addPackage($customer_id){
        
        // insert into product_to_app_packages table
        if($this->input->post('total_channel_package')!=""){
            $this->customers_m->delete_channel_packages_by_customer($customer_id);
            if(is_array($this->input->post('packages')) && count($this->input->post('packages'))>0){
                foreach ($this->input->post('packages') as $pkg) {
                   $data=array(
                        'channel_package_id'=>$pkg,
                        'customer_id'=>$customer_id
                    );
                   $this->db->insert('customer_to_channel_packages',$data);
                }  
            } 
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers/details/'.$customer_id.'/4').'" target="_blank">Extra Channel Packages updated</a>');              
        }

        if($this->input->post('total_movie_stores')!=""){
            $this->customers_m->delete_movie_stores_by_customer($customer_id);
            if(is_array($this->input->post('movie_stores')) && count($this->input->post('movie_stores'))>0){
                foreach ($this->input->post('movie_stores') as $id) {
                   $data=array(
                        'movie_store_id'=>$id,
                        'customer_id'=>$customer_id
                    );
                   $this->db->insert('customer_to_movie_stores',$data);
                }
            }
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers/details/'.$customer_id.'/4').'" target="_blank">Extra Movie Package Updated</a>');              
        }

        if($this->input->post('total_series_stores')!=""){
            $this->customers_m->delete_series_stores_by_customer($customer_id);
            if(is_array($this->input->post('series_stores')) && count($this->input->post('series_stores'))>0){
                foreach ($this->input->post('series_stores') as $id) {
                   $data=array(
                        'series_store_id'=>$id,
                        'customer_id'=>$customer_id
                    );
                   $this->db->insert('customer_to_series_stores',$data);
                }
            }
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers/details/'.$customer_id.'/4').'" target="_blank">Extra Series Package Updated</a>');              
        }

        if($this->input->post('total_music_categories')!=""){
            $this->customers_m->delete_music_categories_by_customer($customer_id);
            if(is_array($this->input->post('music_categories')) && count($this->input->post('music_categories'))>0){
                foreach ($this->input->post('music_categories') as $id) {
                   $data=array(
                        'music_category_id'=>$id,
                        'customer_id'=>$customer_id
                    );
                   $this->db->insert('customer_to_music_categories',$data);
                }
            }
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customers/details/'.$customer_id.'/4').'" target="_blank">Extra Music Package Updated</a>');              
        }


		//==========================================================================================================================	
		$dddd = $this->customers_m->getCustomerInfo($customer_id);		
		$username = $this->generateUsername($dddd->id);
		$password = base64_decode($dddd->password);
		$alpha_password = base64_decode($dddd->alpha_password);
		
		$user_id = $dddd->email;
		$pincode = $password;
		//final json file will be like this 
		//$filename = $pincode.'.json';
		$filename = $alpha_password.'.json';
		//$localFilePath = './jsons/customers/'.$filename;
		$userid1 = implode("/",str_split($this->toAlphaNumeric($user_id)));
		$localFilePath = LOCAL_PATH_CUSTOMER.$userid1.'/'.$filename;
        //updated customers 
        /*$data=array('subscription_expire'=>$this->input->post('subscription_expire'));
        $this->customers_m->save($customer_id,$data);*/
		
      	$final_json_output = $this->customJsonGenerater($username,$password);		
		$this->customMakeJsonFile($final_json_output, $filename,$localFilePath,'customers','',$user_id,$pincode);
		//=========================================================================================================================
		
		
        $this->session->set_flashdata('success',"Extra Packages Updated Successfully.");
        redirect(BASE_URL.'customers/details/'.$customer_id."/4");

    }
    // Ajax Call
    public function updateDevicesAllowed(){
        $data=array('devices_allowed'=>$this->input->post('devices_allowed'));
        $id=$this->input->post('customer_id');
        $this->customers_m->save($id,$data);
        $this->userlogs->track_this($id, "Allowed devices updated to ". $this->input->post('devices_allowed'));
        echo "success";
    }

    
     /**
     * Fetch Messages 
     *
     * @return JSON object
     */
    public function fetchmessages(){
        $customer_id = $this->input->post('customer_id');
        $columns = array('created_date', 'subject', 'status');
        $index = 'id';

        // Number of total records
        $this->db->where(array('customer_id'=> $customer_id));
        $query=$this->db->get('messages');
        $total_records = $query->num_rows();

        // Get actual records
        $def_where= "customer_id= ".$customer_id;
        $query = [];
        $query = array_merge($this->_data_table($columns));
       
        if(isset($query['where'])){
             $def_where = $def_where . " AND (".$query['where'].")";
        } 
       
        // Get filter from ajax request in compiled query 
        $this->db->select('*');
        $this->db->where($def_where);
        if(isset($query['orderby'])){
            $this->db->order_by($query['orderby']['field'],$query['orderby']['order']);
        }
        if($this->input->post('length') != '-1') {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query_actual = $this->db->get('messages');
        $data['posts'] = $query_actual->result();     

        // get total filtered records
        $this->db->where($def_where);
        $query_filtered = $this->db->get('messages');
        $filtered_records = $query_filtered->num_rows();

        $itemData = array();
        $output = array(
            "draw"              =>  intval($this->input->post("draw")),
            "recordsTotal"      =>  $total_records,
            "recordsFiltered"   =>  $filtered_records,
            "data"              =>  array()
        );
        foreach($data['posts'] as $post)
        {
            $itemRows = array();  
            $itemRows[] = $post->created_date;      
            $itemRows[] = $post->subject;   
            $itemRows[] = ($post->status==0) ? 'Unsent <button type="button" name="update" id="'.$post->id.'" class="btn btn-primary btn-xs update btn-send-message">Send Now</button>' : "Sent";         
            $itemRows[] = '<button type="button" name="update" id="'.$post->id.'" class="btn btn-info btn-xs update btn-edit-message">Update</button> <button type="button" class="btn btn-warning btn-xs update btn-delete-message">Delete</button>';
            // $itemRows[] = '<button type="button" name="delete" id="'.$employee["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
            $itemRows['DT_RowId'] = $post->id;
            $output['data'][] = $itemRows;
        }       
        echo json_encode($output);
    }


    /**
    * Fetch Contact Data
    *
    * @return JSON object
    */
    public function fetch_message_data()
    {
        $this->load->model('messages_m');
        $this->check_post_ajax_request();
        $return_data = ['status' => 0];
        $id = $this->secure_data($this->input->post('id'));

        if($id) {
            $data=$this->messages_m->get_by(array('id'=>$id), TRUE);
              
            if($data) {
                $return_data['status'] = 1;
                $return_data['message_data'] = $data;
                $return_data['message'] = "Message Fetched Successfully";
            }
            else {
                $return_data['message'] = "Data doesn't exist";
            }
        }
        else {
            $return_data['message'] = "Message Data not available";
        }

        echo json_encode($return_data);
    }

     /**
     * Insert/Update Message
     *
     * @return JSON object
     */
    public function updatemessage()
    {   
        $this->load->model('messages_m');
        $this->check_post_ajax_request();
        $return_data = ['status' => 0];
        $return_data['message'] = "success";
       
        $rules = $this->messages_m->rules;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == TRUE) {
            $id = $this->secure_data($this->input->post('id'));      
            $fields = ['subject','body'];
            foreach($fields as $field) {
                $data[$field] = $this->secure_data($this->input->post($field));
            }
          
            if($id !== '') {
                // Update               
                $this->messages_m->save($id,$data);               
                $utype = 'update';
            }
            else {
                // Insert
                $data['created_date']=date('Y-m-d H:i:s', time());
                $data['customer_id']=$this->secure_data($this->input->post('customer_id'));
                $id=$this->messages_m->save(NULL,$data);
                $utype = 'add';
            }

            $return_data['query'] = $this->db->last_query();
            $return_data['status'] = 1;
            $return_data['utype'] = $utype;
            $return_data['message'] = ($utype === 'add') ? "Message successfully added" : "Message successfully updated";
        }
        else {
            $return_data['message'] = validation_errors();
        }

        echo json_encode($return_data);
    }

    /**
     * Delete Message
     *
     * @return JSON object
     */
    public function deletemessage()
    {   
        $this->load->model('messages_m');

        $this->check_post_ajax_request();

        $return_data = ['status' => 0];
        $id = $this->secure_data($this->input->post('id'));
           
        if($id && $id !== '') {
            $this->messages_m->delete($id);

            $return_data['status'] = 1;
            $return_data['message'] = 'Messages Deleted successfully';
        }
        else {
            $return_data['message'] = "Error occured";
        }

        echo json_encode($return_data);
    }

     /**
     * Send Message
     *
     * @return JSON object
     */
    public function sendmessage()
    {   
        $this->load->model('messages_m');

        $this->check_post_ajax_request();

        $return_data = ['status' => 0];
        $id = $this->secure_data($this->input->post('id'));
           
        if($id && $id !== '') {
          
            // get messages 
            $msg=$this->messages_m->get($id,TRUE);
         
            // get customer email
            $customer=$this->customers_m->get($msg->customer_id,TRUE);

            // send message here
            $this->load->model('email_model');

            // $parseElement=['EMAIL'=>$customer->email,
            //                 'USERNAME'=>$customer->username,
            //                 'SUBSCRIPTION_PLAN'=>'',
            //                 'EXPIRING_DAY'=>'',
            //                 'SUBSCRIPTION_END_DATE'=>'',
            //             ];


            //$this->email_model->send_email($template,$parseElement);

            $this->email_model->sendEmailSimple("IMS","info@ims.hificn.com",$customer->email,$msg->subject,$msg->body);

            //update the message status 
            $data['status']=1;
            $this->messages_m->save($id,$data);

            $return_data['status'] = 1;
            $return_data['message'] = 'Messages Sent successfully';
        }
        else {
            $return_data['message'] = "Error occured";
        }

        echo json_encode($return_data);
    }

    public function username_check($str)
    {
        if ($str == 'test')
        {
                $this->form_validation->set_message('username_check', 'The {field} field can not be the word "test"');
                return FALSE;
        }
        else
        {
            $user=$this->customers_m->get_by(array('username'=>$str), TRUE);
                
            if($user){
                $this->form_validation->set_message('username_check', 'The {field} is already exist.');
                return FALSE;
            }else
                return TRUE;
        }
    }

    public function email_check($email)
    {
        $user=$this->customers_m->get_by(array('email'=>$email), TRUE);
            
        if($user){
            $this->form_validation->set_message('email_check', 'The {field} is already exist.');
            return FALSE;
        }else
            return TRUE;
    }

    public function email_check_other_than($email){
        $result=$this->customers_m->check_other_emails($email,$this->input->post('id'));
        foreach ($result as $eml) {
            if($eml->email==$email){
                $this->form_validation->set_message('email_check_other_than', 'The {field} is already exist.');
                return FALSE;
            } 
        }
        return TRUE;
    }

    public function generateUsername($inserted_id){
        $prefix_code=$this->settings_m->getValue('userid-prefix');
        $userid=$prefix_code.$inserted_id;
        return $userid;
    }

    public function generatePassword(){
        $length=$this->settings_m->getValue('password-length');
        $password = substr(str_shuffle("0123456789"), 0, $length);
        return $password;
    }

    public function testEmail(){
        $this->load->model('email_model');
        $this->email_model->sendEmailSimple("IMS","info@ims.hificn.com","vissionent@gmail.com","test Message","Hello There! How are you doing");
    }

    function smtpTest(){
        $this->load->library('email');
        
        $config['protocol'] = 'smtp';
              
        // mailjet.com
         
       /* $config['smtp_host'] = "in-v3.mailjet.com";
        $config['smtp_user'] = "d45344321d1e080130303e2bdcc4e2c1";
        $config['smtp_pass'] = "7278ff0cc2d23fa47bcb341cae884611";
        $config['smtp_port'] = "25";*/
        

        //mailtrap.io
       /* $config['smtp_host'] = "smtp.mailtrap.io";
        $config['smtp_user'] = "850103bd2e1b6c";
        $config['smtp_pass'] = "2e6c457f0c5a5c";
        $config['smtp_port'] = "2525";*/
        
        //sendgrid.com Raj's working in another server  
         
       /* $config['smtp_host'] = "smtp.sendgrid.net";
        $config['smtp_user'] = "apikey"; 
        $config['smtp_pass'] = "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"; //my
        $config['smtp_port'] = "587";*/
        

        /*$config['smtp_user'] = "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";
        $config['smtp_pass'] = "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";*/
        
        $config['smtp_timeout'] = "60";
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['charset'] = 'ISO-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype']='html';
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        
        $this->email->from('info@ims.hificdn.com','IMS');
        $this->email->to('vissionent@gmail.com');
        $this->email->bcc('sdongol_2000@yahoo.com'); 
        $this->email->subject('Heee,This is a test email sent from 3rd party email server');
        $this->email->message('Hello Mate,<br><br> your are geeting this email from the 3rd party email server.<br><br>Thank You');
        if($this->email->send()){
            echo "sent";
        }
        else {
            echo "failed";
            print_r ( $this->email->print_debugger ( array ('headers','subject') ), TRUE );
        }

        echo $this->email->print_debugger();
    }

    public function simplemail(){
        $this->load->library('email');
        /*$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';*/
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);

        $this->email->from('in@ims.cdnhifi.com', 'IMS');
        $this->email->to('vissionent@gmail.com');
        $this->email->cc('sdongol_2000@yahoo.com');
       
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        if($this->email->send()){
            echo "sent";
        }
        else {
            echo "failed";
            print_r ( $this->email->print_debugger ( array ('headers','subject') ), TRUE );
        }
    }

    public function productselect(){
		$product_id = $_REQUEST['product_id'];
		$selected_plan = isset($_REQUEST['selected_plan']) ? $_REQUEST['selected_plan'] : '';

		$where = array('product_id'=>$product_id);
		$plans = $this->reseller_m->getAllCodeWhere('reseller_panel_subscription',$where);
		
		$output = '<option value="">Select Plan</option>';
		foreach($plans as $key=>$val){
        	$selected = ($selected_plan == $val['id']) ? 'selected' : '';
        	$output .= '<option value="'.$val['id'].'" '.$selected.'>'.$val['name'].' ('.$val['plan_type'].')'.'</option>';
        }
        echo $output;
	}

	public function fetchDevices($customer_id) {

		//$this->security->csrf_verify();
	    $customer = $this->customers_m->get($customer_id, TRUE);
	    $email = $this->toAlphaNumeric($customer->email);
	    $password = base64_decode($customer->password);	    
	    $url = "https://devices.tvms.axncdn.com/getdevice/?collection_key=" . IMS_CLIENT . "." . CRM . "&document_key=" . $email . "." . $password;
	    //echo $url;exit();
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    $response = curl_exec($ch);
	    curl_close($ch);
	    

	    $devices = json_decode($response, true);
	    //echo '<pre>';
	   // print_r($devices);exit();
	    
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
	    
	    // Merge the device and customer_id into $this->data
	    $this->data['device'] = $device;
	    $this->data['customer_id'] = $customer_id;
	    $this->data['_extra_scripts'] = DEFAULT_THEME . 'customers/_extra_scripts';
	    $this->data['_view'] = DEFAULT_THEME . 'customers/edit_device';
	    $this->data['page_title'] = "Edit a Device";
	    $this->load->view(DEFAULT_THEME . '_layout', $this->data);
	}

	public function updateDevice($customer_id) {
	    // Verify CSRF token

	    $device = $this->input->post();    
	    //echo 'wellcome';
	    $devices = $this->fetchDevices($customer_id);
	    foreach ($devices['devices'] as &$d) {
	        if ($d['uuid'] == $device['uuid']) {
	            $d = array_merge($d, $device);
	            break;
	        }
	    }
	    //print_r($devices);exit();
	    
	    $result = $this->setDevices($customer_id, $devices);
	    
	    if ($result) {
	        $this->session->set_flashdata('success', 'Device updated successfully');
	    } else {
	        $this->session->set_flashdata('error', 'Failed to update device');
	    }
	    
	    redirect('customers/details/' . $customer_id . '/3');
	}
	public function deleteDevice($customer_id, $device_uuid) {
	    $devices = $this->fetchDevices($customer_id);
	    $devices['devices'] = array_filter($devices['devices'], function($d) use ($device_uuid) {
	        return $d['uuid'] != $device_uuid;
	    });
	    
	    $this->setDevices($customer_id, $devices);
	    redirect('customers/details/' . $customer_id . '/3');
	}

	private function setDevices($customer_id, $devices) {
	    $customer = $this->customers_m->get($customer_id, TRUE);
	    $email = $this->toAlphaNumeric($customer->email);
	    $password = base64_decode($customer->password);
	    
	    
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

		// Split the response into two parts
		$json_strings = preg_split('/(?<=\})(?=\{)/', $response);
		$results = array_map('json_decode', $json_strings, array_fill(0, count($json_strings), true));

		// Check if either part of the response indicates success
		$success = false;
		foreach ($results as $result) {
		if (isset($result['success']) || (isset($result['modifiedCount']) && $result['modifiedCount'] > 0)) {
		    $success = true;
		    break;
		}
		}

		if ($success) {
			return true;
		} else {
			// Handle error
			log_message('error', 'Failed to set devices: ' . $response);
			return false;
		}
	}

	public function releaseAllDevices($customer_id) {
	    $devices = $this->fetchDevices($customer_id);
	    
	    if (isset($devices['devices']) && is_array($devices['devices']) && !empty($devices['devices'])) {
	        // Clear all devices by setting to an empty array
	        $devices['devices'] = array();
	        
	        $result = $this->setDevices($customer_id, $devices);
	        
	        if ($result) {
	            $this->session->set_flashdata('success', 'All devices have been released successfully');
	        } else {
	            $this->session->set_flashdata('error', 'Failed to release all devices');
	        }
	    } else {
	        $this->session->set_flashdata('info', 'No devices found to release');
	    }
	    
	    redirect('customers/details/' . $customer_id . '/3');
	}

	//Need to Remove
	public function setProfile($customer_id){
		$collection_key = IMS_CLIENT.'.'.CRM;


		$user_info=$this->customers_m->get_userdetsils_byid($customer_id);

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

		   
           $this->session->set_flashdata('success',"Comments Added Successfully.");
           redirect(BASE_URL.'customers/details/'.$customer_id);
       }
        
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

	public function getVcode(){
        $length=6;
        $randomcode = substr(str_shuffle("0123456789"), 0, $length);
        return $randomcode;
    }

	public function resend_verification() {
	    $customer_id = $this->input->post('customer_id');
	    $customer = $this->customers_m->get($customer_id);
	    
	    if ($customer) {
	        // Generate new verification token
	        $verification_token = $this->getVcode();
	        
	        // Update customer with new verification token
	        $this->customers_m->update('customers',['v_code' => $verification_token],$customer_id);
	        
	        $verification_link = BASE_URL."customer/verify_email/{$customer_id}/{$verification_token}";

	        // Send Email Notification
            $this->load->model('email_templates_m','EM');
            $template=$this->EM->get_email_template("customer_activation_email");
            
            $parse_data=array('FIRST_NAME'=>$customer->first_name,
                              'CONFIRM'=>$verification_link,
                              'EMAIL' => $customer->email                    
                            );
            
            // send email to customer
            $this->load->model('Email_model');
            $email_status=$this->Email_model->send_email($template,$parse_data);
	        
	        echo json_encode(['status' => 'success','email_status'=>$email_status]);
	    } else {
	        echo json_encode(['status' => 'error', 'message' => 'Customer not found']);
	    }
	}

	public function manual_verify() {
	    $customer_id = $this->input->post('customer_id');
	    $customer = $this->customers_m->get($customer_id);
	    
	    if ($customer && $customer->v_code) {
	        $verification_link = base_url("customer/verify_email/{$customer_id}/{$customer->v_code}");
	        
	        // Initialize cURL
	        $ch = curl_init();
	        
	        // Set cURL options
	        curl_setopt($ch, CURLOPT_URL, $verification_link);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	        
	        // Execute cURL request
	        $result = curl_exec($ch);
	        
	        // Check for errors
	        if(curl_errno($ch)) {
	            echo json_encode(['status' => 'error', 'message' => 'cURL Error: ' . curl_error($ch)]);
	        } else {
	            // Check HTTP status code
	            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	            if($http_code == 200) {
	                echo json_encode(['status' => 'success', 'message' => 'Customer verified successfully']);
	            } else {
	                echo json_encode(['status' => 'error', 'message' => 'Verification failed. HTTP Code: ' . $http_code]);
	            }
	        }
	        
	        // Close cURL resource
	        curl_close($ch);
	    } else {
	        echo json_encode(['status' => 'error', 'message' => 'Customer not found or verification code missing']);
	    }
	}
}