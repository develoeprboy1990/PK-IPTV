<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers_m extends MY_Model {
	protected $_table_name = 'customers';
	public $add_rules = array(
		'title' => array(
			'field' => 'title',
			'label' => 'Title',
			'rules' => 'required|trim'
		),
		'first_name' => array(
			'field' => 'first_name',
			'label' => 'First Name',
			'rules' => 'required|trim'
		),
		'last_name' => array(
			'field' => 'last_name',
			'label' => 'Last Name',
			'rules' => 'required|trim'
		),
		'c_code' => array(
			'field' => 'c_code',
			'label' => ' ',
			'rules' => 'required|trim'
		),
		'phone' => array(
			'field' => 'phone',
			'label' => 'Phone',
			'rules' => ''
		),
		'c_mobile' => array(
			'field' => 'c_mobile',
			'label' => 'c_mobile',
			'rules' => ''
		),
		'mobile' => array(
			'field' => 'mobile',
			'label' => 'Mobile',
			'rules' => ''
		),
		'email' => array(
			'field' => 'email',
			'label' => 'Email', 
			'rules' => 'required|valid_email|callback_email_check'
		),
		'billing_street' => array(
			'field' => 'billing_street',
			'label' => 'Billing Street',
			'rules' => ''
		),
		'billing_zip' => array(
			'field' => 'billing_zip',
			'label' => 'Billing Zip',
			'rules' => ''
		),
		'billing_city' => array(
			'field' => 'billing_city',
			'label' => 'Billing City',
			'rules' => ''
		),
		'billing_state' => array(
			'field' => 'billing_state',
			'label' => 'Billing State',
			'rules' => ''
		),
		'billing_country' => array(
			'field' => 'billing_country',
			'label' => 'Billing Country',
			'rules' => ''
		),
		'product_id' => array(
			'field' => 'product_id',
			'label' => 'Product',
			'rules' => 'required|trim'
		),
		'plan_id' => array(
			'field' => 'plan_id',
			'label' => 'Product',
			'rules' => 'required|trim'
		),
		'allow_theme' => array(
			'field' => 'allow_theme',
			'label' => 'App Theme',
			'rules' => ''
		),
		'is_beta' => array(
			'field' => 'is_beta',
			'label' => 'isBeta',
			'rules' => ''
		),
		'is_migrate' => array(
			'field' => 'is_migrate',
			'label' => 'Migrate Customer',
			'rules' => ''
		),
		'account_id' => array(
			'field' => 'account_id',
			'label' => 'Account ID',
			'rules' => ''
		),
		'days_left' => array(
			'field' => 'days_left',
			'label' => 'Days Left',
			'rules' => ''
		),
		'package' => array(
			'field' => 'package',
			'label' => 'Package',
			'rules' => ''
		)
	);
	public $edit_rules = array(
		'title' => array(
			'field' => 'title',
			'label' => 'Title',
			'rules' => 'required|trim'
		),
		'first_name' => array(
			'field' => 'first_name',
			'label' => 'First Name',
			'rules' => 'required|trim'
		),
		'last_name' => array(
			'field' => 'last_name',
			'label' => 'Last Name',
			'rules' => 'required|trim'
		),
		'c_code' => array(
			'field' => 'c_code',
			'label' => ' ',
			'rules' => ''
		),
		'phone' => array(
			'field' => 'phone',
			'label' => 'Phone',
			'rules' => ''
		),
		'mobile' => array(
			'field' => 'mobile',
			'label' => 'Mobile',
			'rules' => ''
		),
		'c_mobile' => array(
			'field' => 'c_mobile',
			'label' => 'c_mobile',
			'rules' => ''
		),
		'email' => array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|valid_email|callback_email_check_other_than'
		),
		'billing_street' => array(
			'field' => 'billing_street',
			'label' => 'Billing Street',
			'rules' => ''
		),
		'billing_zip' => array(
			'field' => 'billing_zip',
			'label' => 'Billing Zip',
			'rules' => ''
		),
		'billing_city' => array(
			'field' => 'billing_city',
			'label' => 'Billing City',
			'rules' => ''
		),
		'billing_state' => array(
			'field' => 'billing_state',
			'label' => 'Billing State',
			'rules' => ''
		),
		'billing_country' => array(
			'field' => 'billing_country',
			'label' => 'Billing Country',
			'rules' => ''
		),
		'password' => array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'min_length[8]|max_length[12]|numeric'
		),
		'allow_theme' => array(
			'field' => 'allow_theme',
			'label' => 'App Theme',
			'rules' => ''
		),
		'is_beta' => array(
			'field' => 'is_beta',
			'label' => 'isBeta',
			'rules' => ''
		)
	);
	public $update_profile_rules = array(
		'first_name' => array(
			'field' => 'first_name',
			'label' => 'First Name',
			'rules' => 'required|trim'
		),
		'last_name' => array(
			'field' => 'last_name',
			'label' => 'Last Name',
			'rules' => 'required|trim'
		),
		'phone' => array(
			'field' => 'phone',
			'label' => 'Phone',
			'rules' => 'required|trim'
		),
		'c_code' => array(
			'field' => 'c_code',
			'label' => ' ',
			'rules' => ''
		),
		'mobile' => array(
			'field' => 'mobile',
			'label' => 'Mobile',
			'rules' => 'required|trim'
		),
		'email' => array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|valid_email|callback_email_check_other_than'
		),
		'billing_street' => array(
			'field' => 'billing_street',
			'label' => 'Billing Street',
			'rules' => ''
		),
		'billing_zip' => array(
			'field' => 'billing_zip',
			'label' => 'Billing Zip',
			'rules' => ''
		),
		'billing_city' => array(
			'field' => 'billing_city',
			'label' => 'Billing City',
			'rules' => ''
		),
		'billing_state' => array(
			'field' => 'billing_state',
			'label' => 'Billing State',
			'rules' => ''
		),
		'billing_country' => array(
			'field' => 'billing_country',
			'label' => 'Billing Country',
			'rules' => ''
		)
	);
	public $change_password_rules = array(
										'password' => array(
										'field' => 'password',
										'label' => 'Password',
										'rules' => 'min_length[8]|max_length[12]|numeric|callback_password_check'
										),
										'new_password' => array(
											'field' => 'new_password',
											'label' => 'New Password',
											'rules' => 'min_length[8]|max_length[12]|numeric'
										),
										'confirm_password' => array(
											'field' => 'confirm_password',
											'label' => 'Confirm New Password',
											'rules' => 'min_length[8]|max_length[12]|numeric|matches[new_password]'
										)
									);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getCustomers(){
		$this->db->select('a.*,co.name country');
		$this->db->from($this->_table_name.' as a');
		//$table_join = "a.billing_city = j.id"; 
		//$this->db->join('cities as j', $table_join,'left');
		$table_join = "a.billing_country = co.id"; 
		$this->db->join('countries as co', $table_join, 'left');
		$query = $this->db->get();
		return $query->result_array();
	}


	
	public function getCustomerInfo($id){
		$this->db->select('a.*,j.name city,co.name country,ak.date_expired');
		$this->db->from($this->_table_name.' as a');
		$table_join = "a.billing_city = j.id"; 
		$this->db->join('cities as j', $table_join,'left');
		$table_join = "a.billing_country = co.id"; 
		$this->db->join('countries as co', $table_join, 'left');
		$table_join = "a.id = ak.user_id"; 
		$this->db->join('activation_keys as ak', $table_join, 'left');
		$this->db->where('a.id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	// get latest login within 10 minutes
	public function get_logged_in_customers(){
		$sql="SELECT * FROM customers 
			  WHERE DATE_FORMAT(FROM_UNIXTIME(last_login),'%Y-%m-%d %H:%i:%s') > DATE_SUB(now(), INTERVAL 600 SECOND) 
		      AND status = '1'";
		$query = $this->db->query($sql);
		return $query->result();
	}

	// get expiring customers
	public function update_customer($id, $data){
		$this->db->where('id', $id);
		$this->db->update('customers', $data);
		/*$sql="SELECT * FROM customers 
			  WHERE status = '1' order by subscription_expire DESC LIMIT 25";
		$query = $this->db->query($sql);
		return $query->result();*/
	}
	
	// get expiring customers
	public function get_expiring_customers(){
		$sql="SELECT * FROM customers 
			  WHERE status = '1' order by subscription_expire DESC LIMIT 25";
		$query = $this->db->query($sql);
		return $query->result();
	}

	// get lastest subscriptions
	public function get_latest_subscription(){
		$sql="SELECT c.id, c.username, p.name, c.subscription_expire,a.date_used FROM customers c
			  JOIN activation_keys a on a.id=c.product_activation_key_id 
			  JOIN products p on p.id=a.product_id
			  WHERE c.status = '1' order by c.subscription_expire DESC LIMIT 25";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function get_channel_packages_by_customer($id){
		$this->db->select('channel_package_id');
		$this->db->where(array('customer_id'=>$id));
		$query = $this->db->get('customer_to_channel_packages');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['channel_package_id'];
		}
		return $ids;
	}

	public function delete_channel_packages_by_customer($id){
		$this->db->delete('customer_to_channel_packages', array('customer_id' =>$id));
	}

	public function get_movie_stores_by_customer($id){
		$this->db->select('movie_store_id');
		$this->db->where(array('customer_id'=>$id));
		$query = $this->db->get('customer_to_movie_stores');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['movie_store_id'];
		}
		return $ids;
	}

	public function delete_movie_stores_by_customer($id){
		$this->db->delete('customer_to_movie_stores', array('customer_id' =>$id));
	}

	public function get_series_stores_by_customer($id){
		$this->db->select('series_store_id');
		$this->db->where(array('customer_id'=>$id));
		$query = $this->db->get('customer_to_series_stores');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['series_store_id'];
		}
		return $ids;
	}

	public function delete_series_stores_by_customer($id){
		$this->db->delete('customer_to_series_stores', array('customer_id' =>$id));
	}

	public function get_music_categories_by_customer($id){
		$this->db->select('music_category_id');
		$this->db->where(array('customer_id'=>$id));
		$query = $this->db->get('customer_to_music_categories');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['music_category_id'];
		}
		return $ids;
	}

	public function delete_music_categories_by_customer($id){
		$this->db->delete('customer_to_music_categories', array('customer_id' =>$id));
	}

	public function check_other_emails($user_email,$user_id){
		$sql="select email from customers where id<>$user_id";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function check_user_password($password,$user_id){
		$sql="select password from customers where id=$user_id";
		$query = $this->db->query($sql);
		$db_password=$query->row()->password;

		if($password==base64_decode($db_password)){
			return true;
		}
		return false;
	}

	public function get_Edgecast_token_key(){
		//global $db;
		$sql="SELECT `key` FROM token
			  WHERE name='Edgecast'";
		
		$result  = $this->db->query($sql);
		$row=mysqli_fetch_object($result);
		return $data=substr($row->key,  2); //remove 2 character because we added extra2 character in ims
	}

	public function get_Akamai_token_key(){
		//global $db;
		$sql="SELECT `key` FROM token
			  WHERE name='Akamai'";
		
		$result  = $this->db->query($sql);
		$row=mysqli_fetch_object($result);
		return $data=substr($row->key,  2); //remove 2 character because we added extra2 character in ims
	}

	public function ECtokenGenerate($clientid, $ims, $clientip, $expire)
	{
			$token_key=get_Edgecast_token_key();
	   		$token = shell_exec('ectoken3\ectoken3 ' . $token_key . ' "ec_clientid=' . $clientid . $ims . '&ec_clientip=' . $clientip . '&ec_expire=' . $expire . '"');
		$token = trim(preg_replace('/\s\s+/', ' ', $token));
	    return $token;
	}

	public function akamai_generate_token_no_ip($clientid, $ims, $clientip, $expire) {
		$Akamai_token_key = get_Akamai_token_key();
		
	           	function h2b($str) {
	    		$bin = "";
	    		$i = 0;
	    		do { 
	    			//$bin .= chr(hexdec($str{$i}.$str{($i + 1)}));
	    			$bin .= chr(hexdec(substr($str, $i, 2)));
	        		$i += 2;
	    		} while ($i < strlen($str));
	    		return $bin;
			}
	 		
			$algo = "SHA256";
			$m_token .='st='.time()."~";
		    $m_token .='exp='.$expire."~";
		    $m_token .='acl=*~';
			$m_token .='data='.$ims.$clientid."~";
			$m_token_digest = (string)$m_token;

			$signature = hash_hmac($algo, rtrim($m_token_digest, "~"), h2b($Akamai_token_key));
		return 'hdnts='.$m_token.'hmac='.$signature;
		}

		
		
		public function akamai_generate_token($clientid, $ims, $clientip, $expire) {
	     $Akamai_token_key = get_Akamai_token_key();
			
	      	function h2b($str) {
	    		$bin = "";
	    		$i = 0;
	    		do { 
	    			//$bin .= chr(hexdec($str{$i}.$str{($i + 1)}));
	    			$bin .= chr(hexdec(substr($str, $i, 2)));
	        		$i += 2;
	    		} while ($i < strlen($str));
	    		return $bin;
			}
	 		
			$algo = "SHA256";
			$m_token .='st='.time()."~";
		    $m_token .='exp='.$expire."~";
			$m_token .='ip='.$clientip."~";
		    $m_token .='acl=*~';
			$m_token .='data='.$ims.$clientid."~";
			$m_token_digest = (string)$m_token;

			$signature = hash_hmac($algo, rtrim($m_token_digest, "~"), h2b($Akamai_token_key));
		return 'hdnts='.$m_token.'hmac='.$signature;
		}


	public function get_product($userid){
		//global $db;
		$sql="SELECT p.* FROM products p
			  JOIN customers c on p.id=c.product_id
		      WHERE c.id='$userid'";
		$result  = $this->db->query($sql);
	//echo $sql
		if($result->num_rows()>0){
			//return mysqli_fetch_object($result);
			return $result->result()[0];
		}else{
			return false;
		}
	}


	public function get_product_plans($product_id){
		$sql="SELECT p.id AS ProductID,p.name AS ProductName,plan.* 
				FROM products p
			  	INNER JOIN reseller_panel_subscription plan on plan.product_id=p.id
		      	WHERE p.id='$product_id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		
	}

	public function get_plan($userid){
		//global $db;
		$sql="SELECT plan.* FROM reseller_panel_subscription plan
			  JOIN customers c on plan.id=c.plan_id
		      WHERE c.id='$userid'";
		$result  = $this->db->query($sql);
		//echo $sql
		if($result->num_rows()>0){
			//return mysqli_fetch_object($result);
			return $result->result()[0];
		}else{
			return false;
		}
	}

	public function getPlanInfo($plain_id){
		//global $db;
		$sql="SELECT plan.* FROM reseller_panel_subscription plan
		      WHERE plan.id='$plain_id'";
		$result  = $this->db->query($sql);
		//echo $sql
		if($result->num_rows()>0){
			//return mysqli_fetch_object($result);
			return $result->result()[0];
		}else{
			return false;
		}
	}



	public function get_product_location($product_id){
		//global $db;
		$sql="SELECT p.*, sli.url FROM products p
			  JOIN server_location_items sli on p.server_id=sli.server_id
		      WHERE p.id='$product_id' AND sli.name='product_location'";
		$result  = $this->db->query($sql);

		if($result->num_rows()>0){
			//return mysqli_fetch_object($result);
			return $result->result()[0];
		}else{
			return false;
		}
	}

	public function get_customer_details($key,$data){
		//global $db;
		$sql="SELECT * FROM customers WHERE ".$key."='".$data."' and status='1'";
		//echo $sql;
		$result  = $this->db->query($sql);
		$user=array();
		if ($result->num_rows() > 0) {
			$row = $result->result_array();
			return $row[0];
			/*foreach($result->result_array() as $row){
				$user[] = $row[0];
			}*/
			
		} else {
			return array();
		}
		
	}

	public function get_email_check_available($user_email){
		//global $db;
		$sql="SELECT id FROM customers WHERE email='$user_email'";
		$result  = $this->db->query($sql);
		$user=array();
		//echo $sql;
		//print_r($result->num_rows());exit;
		if ($result->num_rows() > 0) {
			return false;  
		} else {
		 	return true; 
		}
	}


	public function get_userid_by_email($user_email, $alpha_email){
		//$sql="SELECT id FROM customers WHERE email='$user_email' OR alpha_email='$alpha_email'";
		$sql="SELECT id FROM customers WHERE email='$user_email'";
		$result  = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			$row = $result->result_array();
			return  $row; 
		} else {
		 	return array(); 
		}
	}



	public function get_regemail_check_available($user_email, $alpha_email){
		//global $db;
		//$sql="SELECT id FROM customers WHERE status='1' AND (email='$user_email' OR alpha_email='$alpha_email')";
		$sql="SELECT id FROM customers WHERE status='1' AND email='$user_email'";
		//echo $sql;exit;
		$result  = $this->db->query($sql);
		$user=array();
		//echo $sql;
		//print_r($result->num_rows());exit;
		if ($result->num_rows() > 0) {
			return false;  
		} else {
		 	return true; 
		}
	}

	public function get_mobile_check_available($c_mobile){
		//global $db;
		$sql="SELECT id FROM customers WHERE status='1' AND (mobile='$c_mobile' OR c_mobile='$c_mobile')";
		$result  = $this->db->query($sql);
		$user=array();
		//echo $sql;
		//print_r($result->num_rows());exit;
		if ($result->num_rows() > 0) {
			return false;  
		} else {
		 	return true; 
		}
	}

	public function get_userdetsils_byid($id ){
		//global $db;
		$sql="SELECT * FROM customers WHERE id='$id'";
		//echo $sql;
		$result  = $this->db->query($sql);
		
		//echo '<pre>';
		if ($result->num_rows() > 0) {
		//print_r($result->result());
			 $row = $result->result_array();
			 return  $row[0];
			/*foreach($result->result_array() as $row){
				print_r($row);
			}*/
		}
	}

	public function update_status($id){
		//global $db;
	    $sql = "UPDATE customers SET status='1' WHERE id ='".$id."'";
		$result = $this->db->query($sql);
		if($result){
	    	return true;
		} else {
	    	return false;
		}
	}

	public function update_password($password, $email, $id ){
		//global $db;
	    $sql = "UPDATE customers SET password='".$password."' WHERE id ='".$id."' AND email='".$email."'";
		$result = $this->db->query($sql);
		if($result){
	    	return true;
		} else {
	    	return false;
		}
	}

	public function update_vcodelife($id, $gcode){
		//global $db;
		$vcodelife = date("Y-m-d H:i:s");
	    //$sql = "UPDATE customers SET vcodelife='".$vcodelife."' WHERE id ='".$id."'";
		$sql = "UPDATE customers SET vcodelife='".$vcodelife."' , v_code='".$gcode."' WHERE id ='".$id."'";
		//echo $sql;
		$result = $this->db->query($sql);
		//print_r($result);
		if($result){
	    	return true;
		} else {
	    	return false;
		}
	}

	public function update_username($username,$id){
		//global $db;
	    $sql = "UPDATE customers SET username='".$username."' WHERE id ='".$id."'";
		$result = $this->db->query($sql);
		if($result){
	    	return true;
		} else {
	    	return false;
		}
	}

	public function get_channel_packages($user_id){
		//global $db;
		$sql="SELECT channel_package_id FROM customer_to_channel_packages
		      WHERE customer_id='$user_id'";
		$result  = $this->db->query($sql);
		$packages=array();
		//print_r($sql);exit;
		/*while ($row=mysqli_fetch_object($result)){
			array_push($packages,array('PackageID'=>$row->channel_package_id));
		}*/
		
		if ($result->num_rows() > 0) {
		//print_r($result->result());
			foreach($result->result_array() as $row){
				//$ids[]=$row['music_category_id'];
				array_push($packages,array('PackageID'=>$row['channel_package_id']));
			}
		  // output data of each row
		  /*while($row = $result->fetch_assoc()) {
		  	array_push($packages,array('PackageID'=>$row['channel_package_id']));
			//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
		  }*/
		} else {
		  
		}

	 //print_r($packages);exit;
		return $packages;
	}

	public function get_movie_stores($user_id){
		//global $db;
		$sql="SELECT movie_store_id FROM customer_to_movie_stores
		      WHERE customer_id='$user_id'";
		$result  = $this->db->query($sql);
		$packages=array();
		/*while ($row=mysqli_fetch_object($result)){
			array_push($packages,array('PackageID'=>$row->movie_store_id));
		}*/
		
		if ($result->num_rows() > 0) {
		//print_r($result->result());
			foreach($result->result_array() as $row){
				//$ids[]=$row['music_category_id'];
				array_push($packages,array('PackageID'=>$row['movie_store_id']));
			}
		  // output data of each row
		  /*while($row = $result->fetch_assoc()) {
		  	array_push($packages,array('PackageID'=>$row['channel_package_id']));
			//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
		  }*/
		} else {
		  
		}
		
		
		return $packages;
	}


	public function get_series_stores($user_id){
		//global $db;
		$sql="SELECT series_store_id FROM customer_to_series_stores
		      WHERE customer_id='$user_id'";
		$result  = $this->db->query($sql);
		$packages=array();
		/*while ($row=mysqli_fetch_object($result)){
			array_push($packages,array('PackageID'=>$row->series_store_id));
		}*/
		
		if ($result->num_rows() > 0) {
		//print_r($result->result());
			foreach($result->result_array() as $row){
				//$ids[]=$row['music_category_id'];
				array_push($packages,array('PackageID'=>$row['series_store_id']));
			}
		  // output data of each row
		  /*while($row = $result->fetch_assoc()) {
		  	array_push($packages,array('PackageID'=>$row['channel_package_id']));
			//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
		  }*/
		} else {
		  
		}
		return $packages;
	}

	public function get_music_categories($user_id){
		//global $db;
		$sql="SELECT music_category_id FROM customer_to_music_categories
		      WHERE customer_id='$user_id'";
		$result  = $this->db->query($sql);
		$packages=array();
		/*while ($row=mysqli_fetch_object($result)){
			array_push($packages,array('PackageID'=>$row->music_category_id));
		}*/
		
		if ($result->num_rows() > 0) {
		//print_r($result->result());
			foreach($result->result_array() as $row){
				//$ids[]=$row['music_category_id'];
				array_push($packages,array('PackageID'=>$row['music_category_id']));
			}
		  // output data of each row
		  /*while($row = $result->fetch_assoc()) {
		  	array_push($packages,array('PackageID'=>$row['channel_package_id']));
			//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
		  }*/
		} else {
		  
		}
		
	return $packages;
	}


	public function get_message_customers($user_id){
		$sql="SELECT * FROM logs
	            WHERE user_id=".$user_id." order by timestamp DESC Limit 5";
	    
		$result  = $this->db->query($sql);	
		$msg_array=[];
		if ($result->num_rows() > 0) {
		//print_r($result->result());
			foreach($result->result_array() as $row){
				array_push($msg_array,array("id"=>$row['id'],
	                                        "time"=>$row['timestamp'],
	                                        "message"=>$row['action']
	                                       )
	                        );
			}
		  
		} else {
		  
		}
		
	return $msg_array;
	}

	public function ipAddress() {
		if(isset($_SERVER["HTTP_CF_CONNECTING_IP"])){
	            //If it does, assume that PHP app is behind Cloudflare.
	            $ipAddress = $_SERVER["HTTP_CF_CONNECTING_IP"];
	        } else{
	            //Otherwise, use REMOTE_ADDR.
	            $ipAddress = $_SERVER['REMOTE_ADDR'];
	        }
		return $ipAddress;
	}

	public function countryCode($ip){
		if(isset($_SERVER["HTTP_CF_IPCOUNTRY"])){
			$userCountry = $_SERVER["HTTP_CF_IPCOUNTRY"];
		}
		else {
			$url_ipinfo= "http://pro.ip-api.com/json/".$ip."?key=orgpVdNotmSbX4q&fields=countryCode&_=".time();        
			$ipinfo_json_result = file_get_contents($url_ipinfo);
			$ipinfo = json_decode($ipinfo_json_result);
			$userCountry = $ipinfo->countryCode;
		}
		return $userCountry;
	}

	public function checkuser($username, $password){
		//global $db;
		$password = base64_encode($password);
	// $sql="SELECT c.*,co.name country FROM customers c
	// 		  JOIN countries co on c.billing_country=co.id
	// 	      WHERE c.username='$username' AND c.password='$password'";
		
	$sql="SELECT * FROM customers WHERE username='$username' AND password='$password'";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
		    
			return $query->result()[0];
		}else{
				return false;
		}
	}

	public function checkusercustomerpublic($username, $password){
		//global $db;
		$password = base64_encode($password);
	$sql="SELECT * FROM customers WHERE username='$username' AND password='$password'";
	//echo $sql;exit;	
		//$sql="SELECT c.*,ct.name city,co.name country FROM customers c
		//	  JOIN cities ct on c.billing_city=ct.id
		//	  JOIN countries co on c.billing_country=co.id
		 //     WHERE c.username='$username' AND c.password='$password'";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result()[0];
		}else{
				return false;
		}
	}

	public function checkusercustomer($username, $password){
		//global $db;
		$password = base64_encode($password);
	$sql="SELECT * FROM customers WHERE email='$username' AND password='$password'";
		
		//$sql="SELECT c.*,ct.name city,co.name country FROM customers c
		//	  JOIN cities ct on c.billing_city=ct.id
		//	  JOIN countries co on c.billing_country=co.id
		 //     WHERE c.username='$username' AND c.password='$password'";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result()[0];
		}else{
				return false;
		}
	}

	public function check_already_exist($customer_id,$uuid, $model){
		//global $db;
		$sql="SELECT * FROM customer_to_devices 
		      WHERE uuid='".$uuid."' AND model='".$model."' AND customer_id='$customer_id'";
		$result  = $this->db->query($sql);

		if($result->num_rows()>0)
			return true;
		else
			return false;
	}

	public function get_devices($userid){
		//global $db;
		$sql="SELECT cd.* FROM customer_to_devices cd
			  LEFT JOIN customers c on c.id=cd.customer_id
		      WHERE cd.customer_id='$userid'";
		return $result  = $this->db->query($sql);
	}


	public function check_if_any_expired_devices($userid){
		//global $db;
		
		$sql="SELECT * FROM customer_to_devices 
		      WHERE customer_id='$userid' AND valid <= '".time()."' LIMIT 1";
		
		$result  = $this->db->query($sql);
		return $result;
	}


	public function insert($table,$data){
		//global $db;
		$fields  = implode(',', array_keys($data));
	    $values  = implode("','", array_values($data));
	    $values = "'".$values."'";
	    $sql = "INSERT INTO ".$table."(".$fields.") Values "."(".$values.")";
		$result = $this->db->query($sql);
		if($result){
	    	return true;
		} else {
	    	return false;
		}
	}

	public function update($table,$data,$uuid){
		//global $db;
	    $set_statement="";
	    foreach ($data as $key => $value) {
	    	 $set_statement.=$key ."='". $value."',";
	    }

	    $sql = "UPDATE ".$table." SET ".rtrim($set_statement,',')." WHERE uuid='".$uuid."'";
		$result = $this->db->query($sql);
		if($result){
	    	return true;
		} else {
	    	return false;
		}
	}


	public function insertkeys($data, $table){
		$fields  = implode(',', array_keys($data));
		$values  = implode("','", array_values($data));
		$values = "'".$values."'";
		$sql = "INSERT INTO ".$table."(".$fields.") Values "."(".$values.")";
		$result = $this->db->query($sql);
		if($result){
			return true;
		} else {
			return false;
		}
	}
	
 	public function update_keycode($data,$where,$table){
	//global $db;
		$set_statement="";
		foreach ($data as $key => $value) {
			 $set_statement.=$key ."='". $value."',";
		}
		$where_statement="";
		foreach ($where as $key => $value) {
			 $where_statement.=$key ."='". $value."' AND ";
		}
	
		$sql = "UPDATE ".$table." SET ".rtrim($set_statement,',')." WHERE ".rtrim($where_statement,' AND ');
		//echo $sql;exit;
		$result = $this->db->query($sql);
		//echo $result;exit;
		if($result){
			return true;
		} else {
			return false;
		}
	}
	
	
	public function delete_device($table,$data_array){
		//global $db;
		$field  = implode(',', array_keys($data_array));
	    $value  = implode(",", array_values($data_array));
		$sql = "Delete from ". $table. " where ". $field ."='".$value."'";
		$result = $this->db->query($sql);
		if($result){
	    	return true;
		} else {
	    	return false;
		}
	}

	public function get_aes_encrypt_key(){
		//global $db;
		$sql="SELECT value FROM settings
			  WHERE slug='aes_encrypt_key'";
		$result  = $this->db->query($sql);
		$row=mysqli_fetch_object($result);
		return hex2bin($row->value); 
	}

	public function encrypt($data, $add_character){ 
		if ($add_character){
			$random_code = substr(md5(uniqid(mt_rand(), true)) , 0, $add_character);
		}
	    $key = get_aes_encrypt_key();
		
	$data = $random_code . base64_encode(openssl_encrypt($data, 'AES-128-ECB', $key, $options = OPENSSL_RAW_DATA, $iv = ''));
		 return str_replace(' ','+',$data);
	}

	public function decrypt($data, $remove_character){  
		if ($remove_character){
			$data=substr($data,  $remove_character);
		}
	   $key = get_aes_encrypt_key();
	   $data= str_replace(' ','+',$data);
		return openssl_decrypt(base64_decode($data), 'AES-128-ECB', $key, $options = OPENSSL_RAW_DATA, $iv = '');
	}

	public function getCountry($countryname){
		//global $db;
		
		$sql="SELECT id FROM countries
		      WHERE name='$countryname'";
		$result = $this->db->query($sql);
		if($result->num_rows>0)
			return mysqli_fetch_object($result);
			else
				return false;
	}

	public function selectdatarow($where, $table){
			$where_statement="";
			foreach ($where as $key => $value) {
				 $where_statement.=$key ."='". $value."' AND ";
			}
			$sql="SELECT * FROM ".$table." WHERE ".rtrim($where_statement,' AND ');
			//echo $sql;exit;
			$query = $this->db->query($sql);
			return $query->result_array();
	}

	public function insertRow($data, $table){
			$fields  = implode(',', array_keys($data));
			$values  = implode("','", array_values($data));
			$values = "'".$values."'";
			$sql = "INSERT INTO ".$table."(".$fields.") Values "."(".$values.")";
			$result = $this->db->query($sql);
			if($result){
				//return true;
				 return $this->db->insert_id();
			} else {
				return false;
			}
	}
			
	public function uploadToServer($filename,$localFilePath,$remoteFilePath){
		// FTP server details
		$ftp_host   = 'ftp.ams.9662C.etacdn.net';
		$ftp_username = 'vissionent+3iptv@gmail.com';
		$ftp_password = '12k-skkw-2WEE_MAS';

		// open an FTP connection
		$conn_id = ftp_connect($ftp_host) or die("Couldn't connect to $ftp_host");

		// login to FTP server
		$ftp_login = ftp_login($conn_id, $ftp_username, $ftp_password);

		// local & server file path
		$remoteFilePath = '/gomiddleware/'. $remoteFilePath.'/'.$filename;
		
		//move_uploaded_file ($filename , $localFilePath);
		// try to upload file
		if(ftp_put($conn_id, $remoteFilePath, $localFilePath, FTP_BINARY)){
		   // echo "File transfer successful - $localFilePath";
		}else{
		    //echo "There was an error while uploading $localFilePath";
		}
		// close the connection
		ftp_close($conn_id);
	}


	public function get_customer_by_account_id($account_id) {
	    $this->db->select('*');
	    $this->db->from($this->_table_name);
	    $this->db->where('account_id', $account_id);
	    $this->db->where('is_migrate', 1);
	    $query = $this->db->get();

	    if ($query->num_rows() > 0) {
	        return $query->row();
	    } else {
	        return false;
	    }
	}

	public function update_email($user_id,$data) {
	    $this->db->where('id', $user_id);
	    return $this->db->update('customers', $data);
	}

	public function check_email_unique_for_change($new_email, $alpha_email, $user_id) {
	    $this->db->where('status', '1');
	    $this->db->where('email', $new_email);
	    $this->db->where('id !=', $user_id);
	    $result = $this->db->get('customers');
	    
	    return $result->num_rows() === 0;
	}


	public function get_activated_count()
	{
		
	    $this->db->where('status', '1');
	    return $this->db->count_all_results($this->_table_name);
	}

	public function get_new_count($days = 30)
	{
	    $this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime("-$days days")));
	    $this->db->where('status', '1');
	    return $this->db->count_all_results($this->_table_name);
	}

	public function get_disabled_count()
	{
	    $this->db->where('status', '0');
	    return $this->db->count_all_results($this->_table_name);
	}

	public function get_expired_count()
	{
	    $this->db->where('subscription_expire <', date('Y-m-d H:i:s'));
	    $this->db->where('status', '1');
	    return $this->db->count_all_results($this->_table_name);
	}

	public function getCustomersWithResellers($status = '',$plan_type = '',$is_migrate = '')
	{

	    $this->db->select('a.*,co.name country,r.name reseller_name');
	    $this->db->from($this->_table_name.' as a');
	    $this->db->join('reseller as r', 'r.id = a.reseller_id', 'left');
	    $this->db->join('countries as co', 'a.billing_country = co.id', 'left');
	    
	    if($status == 1)
	    {
	        $this->db->where('a.status',1);
	    }
	    else{
	        $this->db->where('a.status',0);
	    }

	     if($is_migrate == 1)
	    {
	        $this->db->where('a.is_migrate',1);
	    }
	    else if($is_migrate == 2){
	        $this->db->where('a.is_migrate',2);
	    }
	    else{
	        $this->db->where('a.is_migrate',0);
	    }
	   

	    if($plan_type == 'master')
	    {
	        $this->db->where('a.plan_type','master');
	    }
	    else if($plan_type == 'trial'){
	        $this->db->where('a.plan_type','trial');
	    }

	   

	    $this->db->order_by('a.id', 'desc');

	    $query = $this->db->get();
	    return $query->result_array();
	}

	public function getAllCustomers()
	{
	    $this->db->select('a.*, co.name country, r.name reseller_name');
	    $this->db->from($this->_table_name.' as a');
	    $this->db->join('reseller as r', 'r.id = a.reseller_id', 'left');
	    $this->db->join('countries as co', 'a.billing_country = co.id', 'left');
	    $this->db->order_by('a.id', 'desc');
	    $query = $this->db->get();
	    return $query->result_array();
	}

	public function get_all_customer_growth_data() {
	    $sql = "SELECT 
	        DATE(created_at) as date,
	        COUNT(*) as count
	        FROM customers 
	        GROUP BY DATE(created_at)
	        ORDER BY date ASC";
	        
	    $query = $this->db->query($sql);
	    return $query->result_array();
	}
	
/**/
}
/* End of file Customers_m.php */
/* Location: ./application/models/Customers_m.php */