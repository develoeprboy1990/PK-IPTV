<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customers_m');
    }

    public function user(){
        // http://ims.hificdn.com/api/user/JPfu+dNlzIpM7MLKFn7CWVlGNAlycGSBz/P7c+A8+iBF0=&_=1568255298970
        //this  is data CI=JPfu+dNlzIpM7MLKFn7CWVlGNAlycGSBz/P7c+A8+iBF0=&_=1568255298970
        //after decrypt and remove first 2 character this is format /customer/1212/1211212
        //sugget better way to send data may be we will do like  id=1212&password=1211212 or any other way

        $first2Character='JP';
        $key = hex2bin("5ad87aa3275ec183426d439f66398b94"); //from database

        $CI = ($_GET['CI']);
        $CI= str_replace(' ','+',$CI);

        // remove first 2 character
        if ( substr($CI, 0, 2) == $first2Character){
            $CI=substr($CI,  2);
            $CI = $this->decrypt($CI, $key);
            
            $data= explode('/',$CI);

            //extract customer id and password and check if they are valid and custommer is allowed
            $username= $data[1];
            $password= $data[2];
            //todo  api to get with ip timezone and other info sample is below
            
            // check user exist 
            // if exist return user's detail else error 
           
            $user=$this->customers_m->get_by(array('username'=>$username,'password'=>sha1($password)),TRUE);
            if($user){
                $user_info=$this->customers_m->getCustomerInfo($user->id);
                $json_return['timezone']='GMT+10';
                $json_return['city']=$user_info->city;
                $json_return['country']=$user_info->country;
                $json_return['ua']= $_SERVER['HTTP_USER_AGENT'];
                $json_return['time']=time();

                if(isset($_SERVER["HTTP_CF_CONNECTING_IP"])){
                    //If it does, assume that PHP app is behind Cloudflare.
                    $ipAddress = $_SERVER["HTTP_CF_CONNECTING_IP"];
                } else{
                    //Otherwise, use REMOTE_ADDR.
                    $ipAddress = $_SERVER['REMOTE_ADDR'];
                }

                $json_return['ip']=$ipAddress;
             
                $final_json_output = json_encode($json_return, JSON_UNESCAPED_SLASHES);
                $final['CID']= 'JP'.$this->encrypt($final_json_output, $key);
                echo json_encode($final, JSON_UNESCAPED_SLASHES);
            }else{
                $error['status'] = 'error';
                $error['code'] = -2;
                echo json_encode($error);
            }

       }else{
           $error['status'] = 'error';
           $error['code'] = -1;
           echo json_encode($error);
       }
    }

    // this is from function file
    function encrypt($data, $key)
    {
      return base64_encode(openssl_encrypt($data, 'AES-128-ECB', $key, $options = OPENSSL_RAW_DATA, $iv = ''));
    }

    function decrypt($data, $key)
    {
      return openssl_decrypt(base64_decode($data), 'AES-128-ECB', $key, $options = OPENSSL_RAW_DATA, $iv = '');
    }

}
