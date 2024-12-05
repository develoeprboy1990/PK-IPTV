<?php
class Email_model extends CI_model {

	public function __construct()
	{
		parent::__construct();
		
		// config mail setting 
		$this->config_email();
	}
	
	function config_email(){
		$this->load->model('settings_m');
		$this->load->library('email');

		$config['protocol'] = 'smtp';
		$config['smtp_host'] = $this->settings_m->getValue('smtp_host');     //'smtp.com';
		$config['smtp_user'] = $this->settings_m->getValue('smtp_user'); //'admin@tradexstock.com.au';
		$config['smtp_pass'] = $this->settings_m->getValue('smtp_password'); // '911trade';
		$config['smtp_port'] = $this->settings_m->getValue('smtp_port');
  		
  		$config['smtp_timeout'] = "60";
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['charset'] = 'ISO-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype']='html';
		$this->email->initialize($config); 	// can be configures from email config .php
		$this->email->set_newline("\r\n");
	}
		
	//to parse the the email which is available in the
	function parse_email($parseElement,$mail_body)
	{
			foreach($parseElement as $name=>$value)
			{
					$parserName=$name;
					$parseValue=$value;
					$mail_body=str_replace("[$parserName]",$parseValue,$mail_body);
			}
			return $mail_body;
	}
	
	function send_email($template,$parseElement){
		
		$subject = $template->subject;
		$emailbody = $template->body;
		//$emailbody = str_replace('/useruploads/images/',base_url().'useruploads/images/',$emailbody);
						
		$subject=$this->parse_email($parseElement,$subject);
		$message=$this->parse_email($parseElement,$emailbody);
		
		$this->email->from($template->sender_email,$template->sender_name);
		$this->email->to($parseElement['EMAIL']);
		$this->email->bcc($template->bcc); 
		$this->email->subject($subject);
		$this->email->message($message);
		
		if ($this->email->send()){
			$this->email->clear();
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function sendEmailSimple($from_name,$from_email,$to,$subject,$message){
		$this->email->from($from_email,$from_name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		//$this->email->send();
		//$this->email->clear();
	    if($this->email->send()){
	    	return TRUE;
	    	//echo "email sent";
	    }else{
	    	return FALSE;
		 //echo "email didn't send";
	    }
	}
	
}

/* End of file Email_model.php */
/* Location: ./system/application/models/Email_model.php */