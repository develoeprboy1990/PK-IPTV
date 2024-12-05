<?php
class  First_time_setup extends    User_Controller
{

    public function __construct()
    {
        parent::__construct();
    }


    public function createDirectory($directoryName, $cdnOrLocal,$remoteFilePath, $localFilePath)
    {
        if ($cdnOrLocal == "local") {

            if (!mkdir($directoryName, 0777, true)) {
                // die('Failed to create directories...');
            }


            // $fp = fopen($localFilePath, 'w');
            // fwrite($fp, $return_array);
            // fclose($fp);
        } else {


            $ftp_host   = CDN_FTP_HOST;
            $ftp_username = CDN_FTP_USERNAME;
            $ftp_password = CDN_FTP_PASSWORD;


            // open an FTP connection
            $conn_id = ftp_connect($ftp_host) or die("Couldn't connect to $ftp_host");
            // login to FTP server
            $ftp_login = ftp_login($conn_id, $ftp_username, $ftp_password);
            // turn passive mode on
            ftp_pasv($conn_id, true);
if ($directoryName!=null){

    ftp_mkdir($conn_id, $directoryName);

}
else{

    ftp_put($conn_id, $remoteFilePath, $localFilePath, FTP_BINARY);

}

          





            ftp_close($conn_id);
        }
        // if(ftp_put($conn_id, $remoteFilePath, $localFilePath, FTP_BINARY)){
        // } else {
        //    echo "There was an error while uploading $remoteFilePath";exit;
        // }
    }


    //create folders 
    public function step1()
    {
        $directoryname[0] = IMS;
        $directoryname[1] = IMS . '/jsons';
        $directoryname[2] = IMS . '/jsons/'. CRM;
        $directoryname[3] = IMS . '/jsons/'. CMS;
        $directoryname[4] = IMS . '/customers';
        $directoryname[5] = IMS . '/apps';
        $directoryname[6] = IMS . '/images';
        $directoryname[7] = IMS . '/images/' . CMS;
        $directoryname[8] = IMS . '/userinterfaces';
        $directoryname[9] = IMS . '/userinterfaces/important_Base_Start_Url';
        $directoryname[10] = IMS . '/userinterfaces/important_Base_Start_Url/artwork';
        $directoryname[11] = IMS . '/userinterfaces/important_Base_Start_Url/settings';




        foreach ($directoryname as $value) {
            //  echo $value ."</br>";

            $this->createDirectory("./" . $value, "local",0,0);
        }
    }

    //Create folders on CDN
    public function step2()
    {



        $directoryname[0] = IMS;
        $directoryname[1] = IMS . '/jsons';
        $directoryname[2] = IMS . '/jsons/'. CRM;
        $directoryname[3] = IMS . '/jsons/'. CMS;
        $directoryname[4] = IMS . '/customers';
        $directoryname[5] = IMS . '/apps';
        $directoryname[6] = IMS . '/images';
        $directoryname[7] = IMS . '/images/' . CMS;
        $directoryname[8] = IMS . '/userinterfaces';
        $directoryname[9] = IMS . '/userinterfaces/important_Base_Start_Url';
        $directoryname[10] = IMS . '/userinterfaces/important_Base_Start_Url/artwork';
        $directoryname[11] = IMS . '/userinterfaces/important_Base_Start_Url/settings';


   


        foreach ($directoryname as $value) {
            //  echo $value ."</br>";
            $this->createDirectory($value, "cdn",0,0);
        }
    }

    public function step3(){
        $cdnOrLocal="cdn";
        $remoteFilePath= "/apps/grey-circle-plus.png";
        $localFilePath= "./apps/grey-circle-plus.png";
        $this-> createDirectory("", $cdnOrLocal, $remoteFilePath, $localFilePath);
    }

   
}
