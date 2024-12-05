<?php
function btn_edit($uri){
	return anchor($uri, '<i class="fa fa-edit"></i>');
}

function btn_permission($uri){
	return anchor($uri, '<i class="fa fa-cog"></i>');
}

function btn_delete($uri){
	return anchor($uri, '<i class="fa fa-trash"></i>', array(
		'onclick' => "return confirm('You are about to delete a record. This cannot be undone. Are you sure?');"));
}

function btn_deactivate($uri){
	return anchor($uri, '<i class="fa fa-trash"></i>', array(
		'onclick' => 'return swal("Heres a message!")'));
}

function btn_view($uri){
	return anchor($uri, '<i class="fa fa-eye">View</i>');
}

function check_permission($module){
	$ci = &get_instance();
   
    $ci->load->library('ion_auth');
    $ci->load->library('session');

    if($ci->session->role=='customers'){
		redirect('unauthorize', 'refresh');
	}

	$is_allow = $ci->ion_auth->checkPermission($module); 
    if(!isset($is_allow))
    {
       redirect('unauthorize', 'refresh');
    }else{
    	return $is_allow;
    } 
}

	/**
	 * Check Allow function to check if function available
	 *
	 * @params string $action
	 * @params array $allowed_params
	 * @return array or redirect 
	 */
	function check_allow($action,$allowed_params){
		$params="allow_".$action;

		if($allowed_params->$params==NULL)
			redirect('unauthorize', 'refresh');

		return true;
	}

function check_customer(){
	$ci = &get_instance();

    //load the session library
    $ci->load->library('session');

	if($ci->session->role!=='customers'){
		redirect('unauthorize', 'refresh');
	}
}

function get_aes_encrypt_key(){
	$ci = &get_instance();
	$ci->load->database();
	$sql="SELECT value FROM settings
		  WHERE slug='aes_encrypt_key'";
	$query = $ci->db->query($sql);
	$row=$query->row();
	return hex2bin($row->value); 
}

function encrypt($data){ 
	$random_code = substr(md5(uniqid(mt_rand(), true)) , 0, 2);
    $key = get_aes_encrypt_key();
	
  	$data = $random_code . base64_encode(openssl_encrypt($data, 'AES-128-ECB', $key, $options = OPENSSL_RAW_DATA, $iv = ''));
	return str_replace(' ','+',$data);
}
//Disable for development
/*
function encrypt($data){ 
		return $data;
}*/