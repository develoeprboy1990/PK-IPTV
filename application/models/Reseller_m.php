<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reseller_m extends MY_Model {
	protected $_table_name = 'reseller';
	
	public function insert($data){
		$fields  = implode(',', array_keys($data));
		$values  = implode("','", array_values($data));
		$values = "'".$values."'";
		$sql = "INSERT INTO ".$this->_table_name."(".$fields.") Values "."(".$values.")";
		$result = $this->db->query($sql);
		$insert_id = $this->db->insert_id();

		if($result){
			return $insert_id;
			//return true;
		} else {
			return false;
		}
	}	
	public function get_email_check_available($user_email){
		$sql="SELECT id FROM ".$this->_table_name." WHERE email='$user_email'";
		$result  = $this->db->query($sql);
		$user=array();
		if ($result->num_rows() > 0) {
			return false;  
		} else {
			return true; 
		}
	}
	
	public function get_mobile_check_available($c_mobile){
		//global $db;
		$sql="SELECT id FROM customers WHERE mobile='$c_mobile'";
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

	public function get_resellercode_check_available($key_code,$table){
		$sql="SELECT id FROM ".$table." WHERE used_by='' and key_code='".$key_code."'";
		//echo $sql;exit;
		$result  = $this->db->query($sql);
		$user=array();
		if ($result->num_rows() > 0) {
			return false;  
		} else {
			return true; 
		}
	}
	
	public function get_resellercode_verification($key_code,$table){
		$sql="SELECT id FROM ".$table." WHERE key_code='".$key_code."'";
		
		$result  = $this->db->query($sql);		
		if ($result->num_rows() > 0) {
			return true;  
		} else {
			return false; 
		}
	}
	public function getData(){
		$sql="Select * FROM ".$this->_table_name." where status!=3 order by id desc";
		$query = $this->db->query($sql);
		$reseller = array();
		foreach($query->result_array() as $row){
			$reseller[] = $row;
		}		
		return $reseller;
	}	
		
	public function getAll(){
		$sql="Select * FROM ".$this->_table_name;
		$query = $this->db->query($sql);
		$reseller = array();
		foreach($query->result_array() as $row){
			$reseller[] = $row;
		}		
		return $reseller;
	}	
	public function getReseller($id){
		$sql="Select * FROM ".$this->_table_name." where id='".$id."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getResellerPlans($id,$table_name){
		$sql="Select * FROM ".$table_name." where id='".$id."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}		
	public function fetch_state($country_id) {
		  $this->db->where('country_id', $country_id);
		  $this->db->order_by('name', 'ASC');
		  $query = $this->db->get('states');		  		
		  $state = array();
		  foreach($query->result() as $row){
		  	$state[] = $row;		   
		  }
		  return $state;
		 
	 }

	 public function updateWaletAmount($dealerPrice ,$dealerId) {
		      
		
		$sql = "UPDATE reseller SET wallet_money = wallet_money + '".$dealerPrice."' WHERE  id='".$dealerId."'";
		//echo $sql;exit;
		$result = $this->db->query($sql);
		//echo $result;exit;
		if($result){
			return true;
		} else {
			return false;
		} 
	   
   }

	 
	 
	 public function update_key($data,$where){
	//global $db;
		$set_statement="";
		foreach ($data as $key => $value) {
			 $set_statement.=$key ."='". $value."',";
		}
		$where_statement="";
		foreach ($where as $key => $value) {
			 $where_statement.=$key ."='". $value."' AND ";
		}
	
		$sql = "UPDATE ".$this->_table_name." SET ".rtrim($set_statement,',')." WHERE ".rtrim($where_statement,' AND ');
		//echo $sql;exit;
		$result = $this->db->query($sql);
		//echo $result;exit;
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
	
	public function getAll_email($user_email){
		$sql="SELECT * FROM ".$this->_table_name." WHERE email='".$user_email."' AND status='1'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function reseller_plan_code($id){
		$sql = "SELECT 
			sd.*,
			rps.id as plan_id,
			rps.name as name,	
			rps.monthly_price as monthly_price,	
			rps.product_id 	as product_id,
			rps.length_months as length_months,	
			rps.devices_allowed as devices_allowed,	
			rps.active as active,
			rps.month_day as month_day,	
			rps.facility_content as facility_content,	
			rps.currency_type as plan_currency_type,	
			rps.plan_type as plan_plan_type,	
			rps.activation_price as plan_activation_price
			FROM `reseller_details` as sd
			join reseller_panel_subscription as rps on rps.id=sd.product_plans where sd.id='".$id."'";
		$query = $this->db->query($sql);
		return $query->result_array();
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
	
	public function getAllCode($table){
		$sql="Select * FROM ".$table;
		$query = $this->db->query($sql);
		$reseller_code = array();
		foreach($query->result_array() as $row){
			$reseller_code[] = $row;
		}		
		return $reseller_code;
	}
	
	public function getAllCodeWhere($table,$where){
		$where_statement="";
		foreach ($where as $key => $value) {
			 $where_statement.=$key ."='". $value."' AND ";
		}
		$sql="SELECT * FROM ".$table." WHERE ".rtrim($where_statement,' AND ');
		
		//$sql="Select * FROM ".$table;
		$query = $this->db->query($sql);
		$reseller_code = array();
		foreach($query->result_array() as $row){
			$reseller_code[] = $row;
		}		
		return $reseller_code;
	}


	public function getAllSubscription($table,$where){
		$where_statement="";
		foreach ($where as $key => $value) {
			 $where_statement.=$key ."='". $value."' AND ";
		}
		 $where_statement.= 'active' != 3;
		$sql="SELECT * FROM ".$table." WHERE active != 3 and ".rtrim($where_statement,' AND  ');
		
		//$sql="Select * FROM ".$table;
		$query = $this->db->query($sql);
		$reseller_code = array();
		foreach($query->result_array() as $row){
			$reseller_code[] = $row;
		}		
		return $reseller_code;
	}
	
	public function getAllActivePlans($table){
		$sql="Select * FROM ".$table." where active='1' order by plan_type DESC";
		$query = $this->db->query($sql);
		$reseller_code = array();
		foreach($query->result_array() as $row){
			$reseller_code[] = $row;
		}		
		return $reseller_code;
	}
	//working-----------
	public function deletesubscriptionNow($id, $table){

		$sql = "UPDATE ".$table." SET ".rtrim($set_statement,',')." WHERE ".rtrim($where_statement,' AND ');
		//echo $sql;exit;
		$result = $this->db->query($sql);

		
		$sql= "DELETE FROM ".$table." WHERE id='".$id."'";
		$query = $this->db->query($sql);
		return $query;
	}

	public function deletesubscription($id, $table){
		$sql= "DELETE FROM ".$table." WHERE id='".$id."'";
		$query = $this->db->query($sql);
		return $query;
	}
	
	public function selectdatarow($where, $table){
		$where_statement="";
		foreach ($where as $key => $value) {
			 $where_statement.=$key ."='". $value."' AND ";
		}
		$sql="SELECT * FROM ".$table." WHERE ".rtrim($where_statement,' AND ') .' ORDER BY id DESC';
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function selectRechargePlan($id){
		 
		 
		/*$sql="SELECT t1.* ,t2.name as productName,t2.subscription_length, t2.subscription_days_or_month FROM customers_recharge as t1 inner join products as t2 on t2.id = t1.product_id  WHERE  t1.customer_id=rtrim($id) order by t1.id desc";*/

		$sql="SELECT 
		t1.*,
		t2.name as productName,
		t3.group_name,
		CONCAT(t3.length_months, ' ', t3.month_day) as subscription_days_or_month 
		FROM customers_recharge as t1 
		inner join products as t2 on t2.id = t1.product_id  
		inner join subscription_renewal_keys as t3 on t1.activation_code = t3.keycode
		WHERE  t1.customer_id=rtrim($id) 
		order by t1.id desc";
		 

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function selectCustomerInfo($id){
		 
		//Customer (customers)
		//Product (products)
		//Plan (reseller_panel_subscription)
		
		$sql="SELECT 
		t1.* ,
		t2.name as productName,
		t2.subscription_length,
		t2.subscription_days_or_month,
		t3.name as planName,
		t3.devices_allowed as DevicesAllowed
		FROM customers as t1 
		LEFT  join products as t2 on t2.id = t1.product_id  
		LEFT  join reseller_panel_subscription as t3 on t3.id = t1.plan_id  
		WHERE  t1.id=rtrim($id) order by t1.id desc";
		 

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function selectSubscriptionCode($id, $type){
		 
		$sql="SELECT t1.* ,t2.first_name,t2.last_name,t2.title  FROM  subscription_renewal_keys as t1 
		left join  customers as t2 on t2.id=t1.user_id
		WHERE t1.reseller_id=$id and t1.key_type='".$type."' ORDER BY t1.id DESC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function selectplankey($id){
		 
		$sql="SELECT t1.* ,t2.* FROM  subscription_renewal_keys as t1 
		left join  customers as t2 on t2.id=t1.user_id
		WHERE t1.id=$id   ";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function customerdata($id){
		 
		$sql="SELECT t1.* ,t2.name as proname,t2.subscription_length, t2.price FROM customers as t1 inner join products as t2 on t2.id = t1.product_id  WHERE  t1.reseller_id=rtrim($id) order by t1.id desc";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function deletedatarow($where, $table){
		$where_statement="";
		foreach ($where as $key => $value) {
			 $where_statement.=$key ."='". $value."' AND ";
		}
		
		$sql= "DELETE FROM ".$table." WHERE ".rtrim($where_statement,' AND ');
		
		$query = $this->db->query($sql);
		return $query; 
	}
	
	public function getAllRows($table,$order_by){
		$sql="Select * FROM ".$table.' ORDER BY '.$order_by.' DESC';;
		$query = $this->db->query($sql);
		$row_array = array();
		foreach($query->result_array() as $row){
			$row_array[] = $row;
		}		
		return $row_array;
	}
	
	public function getAllRowsWhere($table,$order_by,$where){
		$where_statement=" WHERE ";
		foreach ($where as $key => $value) {
			 $where_statement.=$key ."='". $value."' AND ";
		}
		$sql="Select * FROM ".$table.rtrim($where_statement,' AND ') .' ORDER BY '.$order_by.' DESC';;
		$query = $this->db->query($sql);
		$row_array = array();
		foreach($query->result_array() as $row){
			$row_array[] = $row;
		}		
		return $row_array;
	}

	public function getCustomerWithActivePlan($id){
		 
		//customers
		//subscription_renewal_keys
		//reseller_details
		//reseller_panel_subscription
		//products
		$sql="SELECT 
		c.id AS CustomerID,
		CONCAT(c.title,'',c.first_name, ' ', c.last_name) as CustomerName,
		c.email AS CustomerEmail,
		prod.id as ActiveProductID,
		prod.name as ActiveProductName,
		plans.id AS ActivePlanID,
		plans.name AS ActivePlanName,
		plans.monthly_price As ActivePlanPrice,
		CONCAT(plans.length_months, ' ', plans.month_day) as ActivePlanTime,
		plans.devices_allowed AS DevicesAllowed,
		mkeys.id AS ActivationKeyID,
		mkeys.keycode AS ActivationCode,
		c.vcodelife AS PlanActivate,
		c.subscription_expire AS PlanExpire,
		rd.dealer_price AS ActiveDealerPrice,
		DATEDIFF(c.subscription_expire, c.vcodelife) AS ActiveTotalDays,
		DATEDIFF(NOW(), c.vcodelife) AS ActiveUsedDays,
		DATEDIFF(c.subscription_expire, NOW()) AS ActiveRemainingDays
		FROM customers as c 
		inner join subscription_renewal_keys as mkeys on c.product_activation_key_id = mkeys.id
		inner join reseller_details as rd on rd.id=mkeys.reseller_plan_id 
		inner join reseller_panel_subscription as plans on  plans.id = rd.product_plans
		inner join products as prod on prod.id = mkeys.product_id  
		WHERE  c.id=rtrim($id) 
		order by c.id desc limit 1";
		 

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getAllPlansByResellerID($reseller_id){
			$sql = "SELECT 
			rd.ID AS ResellerPlanID,
			p.name AS ProductName,
			rps.id As PlanID,
			rps.name AS PlanName,
			rps.monthly_price As PlanPrice,
			CONCAT(rps.length_months, ' ', rps.month_day) as PlanTime,
			rd.dealer_price AS DealerPrice,
			rps.devices_allowed AS DeviceAllowed
			FROM `reseller` as r
			join reseller_details as rd on rd.reseller_id=r.id 
			join reseller_panel_subscription as rps on rps.id=rd.product_plans 
			join products as p on p.id=rps.product_id 
			where 1 AND rps.active='1'";
			if($reseller_id !='')
			{
				$sql .= "AND r.id='".$reseller_id."'";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
	}

	public function getPlanName($plan_id) {
	    $plan = $this->db->get_where('reseller_panel_subscription', array('id' => $plan_id))->row();
	    return $plan ? $plan->name . ' (' . $plan->plan_type . ')' : '';
	}
	
}