<?php
class Cron_test extends User_Controller
{
    
    
      public function __construct()
    {
        parent::__construct();
    }
    
 
 public function test(){

// create a new cURL resource
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "http://xims.cdnnext.com/cron_jobs/runAllCron");
curl_setopt($ch, CURLOPT_HEADER, 0);

// grab URL and pass it to the browser
curl_exec($ch);

// close cURL resource, and free up system resources
curl_close($ch);

	}
}