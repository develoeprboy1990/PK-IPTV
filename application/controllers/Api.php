<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Customer Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 * SMS  :https://xims.cdnnext.com/api/device/getUserLogin?sendtype=sms&crmService=xtv_crm&cmsService=xtv_cms&deviceType=_AndroidHandheld&deviceModel=SM-G950F&macaddress=&userid=write2sunny123@gmail.com&email=
 * EMAIL:https://xims.cdnnext.com/api/device/getUserLogin?sendtype=email&crmService=xtv_crm&cmsService=xtv_cms&deviceType=_AndroidHandheld&deviceModel=SM-G950F&macaddress=&userid=write2sunny123@gmail.com&email=
 */
 

class Api extends MY_Controller
{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('customers_m');
	}

	public function device($method = 'getUserLogin')
    { 
        if ($method == 'getUserLogin') {
        	$this->getUserLogin();
        } else {
            show_404();
        }
    }    

    public function getUserLogin(){
    	
        $userid = $_REQUEST['userid'];
        $emailInput = isset($_REQUEST['email']) ? trim($_REQUEST['email']) : '';
        $email = empty($emailInput) ? $userid : $emailInput;
        $send_type = trim($_REQUEST['sendtype']);
        
        $user = $this->customers_m->get_customer_details('email', $email); 
        if($user){     
            $toname = $user['first_name'];
            $number = $user['c_code'].$user['mobile'];
            $to = $user['email'];
                                
            if($send_type == "sms"){
                $this->load->model('sms_templates_m');    
                $info_sms = $this->sms_templates_m->get(4,TRUE);                        
                $sms_body = $info_sms->body;
                $replacing_string = array(
                    "[FIRST_NAME]" => $user['first_name'],
                    "[PASSWORD]" => base64_decode($user['password'])
                );
                $bodyHTML = strtr($info_sms->body, $replacing_string);    
                
                $this->send_sms($number, $bodyHTML);
                echo json_encode(array("success" => "SMS Sent Successfully"));
            }

            if($send_type == "email"){    
                $this->load->model('email_templates_m');    
                $info_email = $this->email_templates_m->get(9,TRUE);                        
                $mail_body = $info_email->body;
                $replacing_string = array(
                    "[FIRST_NAME]" => $user['first_name'],
                    "[PASSWORD]" => base64_decode($user['password'])
                );
                
                $subject = $info_email->subject;
                $from = $info_email->sender_email;
                $fromname = $info_email->sender_name;    
                $bodyHTML = strtr($info_email->body, $replacing_string);    
                $this->send_email($subject, $bodyHTML, $from, $fromname, $to, $toname);
                
                echo json_encode(array("success" => "Email Sent Successfully"));
            }
        } else {
            echo json_encode(array("error" => "User not found"));
        }
    }

	
	//URL Is this 
	public function getUserLogin_old(){
		$userid=$_REQUEST['userid'];
        $password=$_REQUEST['password'];
        $emailInput = isset($_REQUEST['email']) ? trim($_REQUEST['email']) : '';
        $email = empty($emailInput) ? $userid : $emailInput;
        $send_type=trim($_REQUEST['sendtype']);
		$message_type=$_REQUEST['messageType'];
		
		$user = $this->customers_m->get_customer_details('email',$email);
		 if($user){     
				$toname = $customers_details['first_name'];
				$number = $user['c_code'].$user['mobile'];
				$to = $user['email'];
								
				if($send_type=="sms"){

					$this->load->model('sms_templates_m');	
					//	if($message_type == 'forgetPassword'){
					$info_sms=$this->sms_templates_m->get(4,TRUE);						
					$sms_body = $info_sms->body;
					$replacing_string = array("[FIRST_NAME]" => $user['first_name'],
					"[PASSWORD]" => base64_decode($user['password'])
					);
					//	}

					$bodyHTML =	strtr($info_sms->body, $replacing_string);	


				//	if($message_type == 'forgetPassword'){
						//$body = "Your Password : ".base64_decode($user['password']);
				//	}	
					
					
				
					$this->send_sms($number,$bodyHTML);
					echo json_encode(array("success"=>"SMS Sent Successfully"));
					//echo 'sms';
				 }

				 if($send_type=="email"){	
				 	$this->load->model('email_templates_m');	
				 //	if($message_type == 'forgetPassword'){
						$info_email=$this->email_templates_m->get(9,TRUE);						
						$mail_body = $info_email->body;
						$replacing_string = array("[FIRST_NAME]" => $user['first_name'],
													"[PASSWORD]" => base64_decode($user['password'])
												  );
				//	}
					
					$subject = $info_email->subject;
					$from = $info_email->sender_email;
					$fromname = $info_email->sender_name;	
					$bodyHTML =	strtr($info_email->body, $replacing_string);	
					$this->send_email($subject, $bodyHTML, $from, $fromname, $to, $toname);
					
					echo json_encode(array("success"=>"Email Sent Successfully"));
				 }
				
			}
			 
			
		}
		
	
	public function send_sms($number,$body){
			$id = TWILLO_ID;
			$token = TWILLO_TOKEN;
			$url = TWILLO_URL.$id."/Messages.json";
			$from = TWILLO_PHONE_FROM;
			$to = "+".$number;

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
	
	public function send_email($subject, $body, $from, $fromname, $to, $toname){			
		$this->load->library('email');		
		$config['protocol'] = $this->config->item('protocol');
		$config['smtp_host'] = $this->config->item('smtp_host');
		$config['smtp_user'] = $this->config->item('smtp_user');
		$config['smtp_pass'] = $this->config->item('smtp_pass');
		$config['smtp_port'] = $this->config->item('smtp_port');
		$this->email->initialize($config);
		$this->email->from($from, $fromname);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($body);
		$this->email->send();
	}
}

