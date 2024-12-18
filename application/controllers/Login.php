<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{

		$dashbaord = 'admin/dashboard/';
		$this->user_m->loggedin() ==  FALSE || redirect($dashbaord);
		$rules = $this->user_m->login_rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			if($this->user_m->login() == TRUE){
				redirect($dashbaord);
			}else{
				$this->session->set_flashdata('login_error', 'The Email Password Combination does not exist!');
				redirect( BASE_URL .'index');
			}
		}
		$this->data['page_title'] = 'Login';
		$this->load->view( DEFAULT_THEME . 'index',$this->data);
	}

	public function logout(){
		$this->user_m->logout();
		redirect( BASE_URL );
	}

	/* Login as a customer via a tokenized link - the link generation methods Code starts here 18 dec 2024*/
	public function generate_customer_login_link($customer_id)
	{
		$this->load->model('customers_m');
		// Fetch customer data
		$customer = $this->customers_m->getCustomerInfo($customer_id);
		if ($customer) {
			// Generate a unique token
			$token = bin2hex(random_bytes(32)); // Secure random token
			$expiry_time = time() + (60 * 10); // 10 minutes validity

			// Save token and expiry in the database or a temp table
			$this->db->insert('customer_login_tokens', [
				'customer_id' => $customer_id,
				'token' => $token,
				'expires_at' => $expiry_time
			]);

			// Generate the login link
			$link = base_url("customer/auto_login?token=$token");

			echo json_encode(['link' => $link]);
		} else {
			echo json_encode(['error' => 'Customer not found']);
		}
	}
	/* Login as a customer via a tokenized link - the link generation methods Code end here 18 dec 2024*/

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */