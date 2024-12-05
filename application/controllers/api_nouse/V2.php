<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');
class V2 extends REST_Controller
{
    public function __construct() {
      parent::__construct();
   
    }    
       
    // customers GET Request
    public function customers_get($id=0){
      if($id){
        $this->db->where('id',$id);
      }
      $query = $this->db->get('customers');
      $r = $query->result_array();
    
      if(!empty($r)){
        $this->response($r,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No user was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }     
    }

    // customers POST Request
    public function customers_post(){
      $required_fields = array(
                          'first_name', 
                          'last_name',
                          'email'
                        );
      $data = array(
        'title' => strip_tags($this->input->post('title')),
        'first_name' => strip_tags($this->input->post('first_name')),
        'last_name' => strip_tags($this->input->post('last_name')),
        'phone' => strip_tags($this->input->post('phone')),
        'mobile' => strip_tags($this->input->post('mobile')),
        'email' => strip_tags($this->input->post('email'))
      );

      if($this->check_required_field_blank($required_fields,$data)==true){
        if($this->db->insert('customers',$data))
        { 
          $inserted_id=$this->db->insert_id();
          $data= array('id'=>$inserted_id)+$data;
          $this->response([
              'status' => TRUE,
              'message' => 'Customer has been added successfully.',
              'data' => $data
          ], REST_Controller::HTTP_OK);
        }
        else
        {
          // Set the response and exit
          $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
        }
      }else{
          $this->response("Some Required fields are missing", REST_Controller::HTTP_FORBIDDEN);
      }
    }

    // customers PUT Request
    public function customers_put(){
      $id = $this->uri->segment(4);
      $required_fields = array(
                          'first_name', 
                          'last_name',
                          'email'
                        );
      $data = array(
        'title' => $this->input->get('title'),
        'first_name' => $this->input->get('first_name'),
        'last_name' => $this->input->get('last_name'),
        'phone' => $this->input->get('phone'),
        'mobile' => $this->input->get('mobile'),
        'email' => $this->input->get('email')
      );
          
      if($this->check_required_field_blank($required_fields,$data)==true){
        if($this->db->update('customers',$data,array('id' => $id)))
        {    
          $this->response([
              'status' => TRUE,
              'message' => 'Customer has been updated successfully.',
              'data' => $data
          ], REST_Controller::HTTP_OK);
        }
        else
        {
          // Set the response and exit
          $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
        }
        $this->response($r); 
      }else{
        $this->response("Some Required fields are missing", REST_Controller::HTTP_FORBIDDEN);
      }
    }

    // customers DELETE Request
    public function customers_delete(){
      $id = $this->uri->segment(4);
      if(ctype_digit(strval($id))){ // check if integer
        $result = $this->db->delete('customers', array('id' =>$id));
        if($result)
        {
          $this->response([
                'status' => TRUE,
                'message' => 'Customer is deleted successfully.'
            ], REST_Controller::HTTP_OK);
        }
        else
        {
          // Set the response and exit
          $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
        }
      }else{
        $this->response("Invalid data or request", REST_Controller::HTTP_FORBIDDEN);
      }
    }

    //devices 
    public function customer_devices_get($id=0){
      if($id){
        $this->db->where('id',$id);
      }
      $query = $this->db->get('customer_devices');
      $r = $query->result();

      $device_data=array();
      if($r){
        foreach ($r as $device) {
          // get model 
          $this->db->where('id',$device->model_id);
          $query = $this->db->get('customer_device_model');
          $model = $query->row();
          
          array_push($device_data, 
                     array('id'=>$device->id,
                          'serial'=>$device->serial,
                          'model'=>array('id'=>$model->id,
                                         'name'=>$model->name),
                          'location'=>$device->location,
                          'status' => $device->status,
                          'date_added'=>$device->date_added
                        ));
        }

        $this->response($device_data, REST_Controller::HTTP_OK);
      }else{
        $this->response([
                  'status' => FALSE,
                  'message' => 'No Customer Devices could be found.'
                ], REST_Controller::HTTP_BAD_REQUEST);
      }
    }

    // advertisement apis
    public function gethomescreenadvertisementduo_get(){
      $orientation=strip_tags($this->input->get('orientation'));
      $userId=strip_tags($this->input->get('userId'));
      $resellerId=strip_tags($this->input->get('resellerId'));
      $deviceModel=strip_tags($this->input->get('deviceModel'));
      $city=strip_tags($this->input->get('city'));
      $state=strip_tags($this->input->get('state'));
      $countryname=strip_tags($this->input->get('country'));
      
      $country=$this->getCountry($countryname);

      if($country){
            //get two random banners according to country 
            $sql="SELECT * FROM advertisement 
                  WHERE IF(exclude_country='yes', id NOT IN 
                    (SELECT advertisement_id FROM advertisements_exclude_include_countries
                    WHERE country_id='$country->id' AND exclude=1), 
                   id IN(SELECT advertisement_id FROM advertisements_exclude_include_countries
                    WHERE country_id='$country->id' AND include=1)
                  )
                  AND type='banner'
                  AND gui_position='$orientation'
                  AND ( NOW() BETWEEN date_start AND date_end) 
                  ORDER BY RAND()
                  LIMIT 2";  // 14 Australia 

            $result = $this->db->query($sql);
            $output=array();
            $i=1;
           
            if(@$result->num_rows>0){
                while($row = $result->fetch_array())
                {
                    $rows[] = $row;
                }
                foreach ($rows as $row) {
                    if($i==2){
                        $output1=array(
                                  "url$i"=>$row['image'],  // banner image url 
                                  "campaignemail$i"=>($row['make_clickable']==1) ? $row['campaign_email'] : "",
                                  "campaigntext$i"=>($row['make_clickable']==1) ? $row['campaign_email_text'] : "",
                                  "campaignstream$i"=>($row['make_clickable']==1) ? $row['stream_url'] : "",
                                  "campaignbackdrop$i"=>($row['make_clickable']==1) ? $row['backdrop']: "",  
                                  "campaignenabled$i"=> $row['make_clickable'], 
                                  "campaignid$i"=>$row['id']
                            ); 
                        $output=array_merge($output,$output1);
                    }else{
                        $output1=array(
                                  "url"=>$row['image'], // banner image url 
                                  "campaignemail"=> ($row['make_clickable']==1) ? $row['campaign_email'] : "",
                                  "campaigntext"=> ($row['make_clickable']==1) ? $row['campaign_email_text'] : "",
                                  "campaignstream"=> ($row['make_clickable']==1) ? $row['stream_url'] : "",
                                  "campaignbackdrop"=> ($row['make_clickable']==1) ? $row['backdrop']: "",  
                                  "campaignenabled"=> $row['make_clickable'],
                                  "campaignid"=> $row['id']
                            );
                        $output=array_merge($output,$output1);
                    }
                    $i++;
                }

                $this->response($output, REST_Controller::HTTP_OK);
            }
            else{
                // $error['status'] = 'error';
                // $error['code'] = -5;
                // $error['message'] ='No banners could be found';
                // $output= $error;

                $this->response([
                  'status' => FALSE,
                  'message' => 'No banners could be found.'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            /*$error['status'] = 'error';
            $error['code'] = -6;
            $error['message'] ='User Country could not be found';
            $output= $error;*/

            $this->response([
              'status' => FALSE,
              'message' => 'User Country could not be found.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    // stream advertisement 
    public function getstreamadvertisement_get(){
      $contentName=strip_tags($this->input->get('contentName'));
      $contentType=strip_tags($this->input->get('contentType'));
      $contentId=strip_tags($this->input->get('contentId'));
      $userId=strip_tags($this->input->get('userId'));
      $resellerId=strip_tags($this->input->get('resellerId'));
      $deviceModel=strip_tags($this->input->get('deviceModel'));
      $cmsService=strip_tags($this->input->get('cmsService'));
      $crmService=strip_tags($this->input->get('crmService'));
      $city=strip_tags($this->input->get('city'));
      $state=strip_tags($this->input->get('state'));
      $countryname=strip_tags($this->input->get('country'));

      //get country id from country name 
      $country=$this->getCountry($countryname);
      $preroll=array();
      $ticker=array();
      $overlay=array();
     
      $this->response($country, REST_Controller::HTTP_BAD_REQUEST);

      if($country){ 

            if($contentType=="channel"){
              $sql="SELECT a.* FROM advertisement a 
                    JOIN advertisement_video_to_channels avc 
                    on a.id=avc.advertisement_id 
                    WHERE IF(exclude_country='yes', a.id NOT IN 
                      (SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND exclude=1), 
                     a.id IN(SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND include=1)
                    )
                    AND a.type='preroll'
                    AND ( NOW() BETWEEN a.date_start AND a.date_end) 
                    AND avc.channel_id=$contentId
                    ORDER BY RAND()
                    LIMIT 1";  
            }elseif($contentType=="serie"){
              $sql="SELECT a.* FROM advertisement a 
                    JOIN advertisement_video_to_series avs 
                    on a.id=avs.advertisement_id 
                    WHERE IF(exclude_country='yes', a.id NOT IN 
                      (SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND exclude=1), 
                     a.id IN(SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND include=1)
                    )
                    AND a.type='preroll'
                    AND ( NOW() BETWEEN a.date_start AND a.date_end) 
                    AND avs.channel_id=$contentId
                    ORDER BY RAND()
                    LIMIT 1";  
            }elseif($contentType=="movie"){
               $sql="SELECT a.* FROM advertisement a 
                    JOIN advertisement_video_to_movies avm 
                    on a.id=avm.advertisement_id 
                    WHERE IF(exclude_country='yes', a.id NOT IN 
                      (SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND exclude=1), 
                     a.id IN(SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND include=1)
                    )
                    AND a.type='preroll'
                    AND ( NOW() BETWEEN a.date_start AND a.date_end) 
                    AND avm.channel_id=$contentId
                    ORDER BY RAND()
                    LIMIT 1"; 
            }           
            $result = $this->db->query($sql);
            if($result->num_rows>0){
                while($row = $result->fetch_array())
                {
                    $rows[] = $row;
                }
                foreach ($rows as $row) {
                  $preroll=array('url'=>$row['url'],
                                 'show_time'=>"text");
                            //   'show_time'=>$row['length']);
                }
            }

            //get one random ticker according to country 
            if($contentType=="channel"){
                $sql="SELECT a.* FROM advertisement a 
                    JOIN advertisement_video_to_channels avc 
                    on a.id=avc.advertisement_id 
                    WHERE IF(exclude_country='yes', a.id NOT IN 
                      (SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND exclude=1), 
                     a.id IN(SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND include=1)
                    )
                    AND a.type='ticker'
                    AND ( NOW() BETWEEN a.date_start AND a.date_end) 
                    AND avc.channel_id=$contentId
                    ORDER BY RAND()
                    LIMIT 1";  
            }elseif($contentType=="serie"){
              $sql="SELECT a.* FROM advertisement a 
                    JOIN advertisement_video_to_series avs 
                    on a.id=avs.advertisement_id 
                    WHERE IF(exclude_country='yes', a.id NOT IN 
                      (SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND exclude=1), 
                     a.id IN(SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND include=1)
                    )
                    AND a.type='ticker'
                    AND ( NOW() BETWEEN a.date_start AND a.date_end) 
                    AND avs.channel_id=$contentId
                    ORDER BY RAND()
                    LIMIT 1";  
            }elseif($contentType=="movie"){
               $sql="SELECT a.* FROM advertisement a 
                    JOIN advertisement_video_to_movies avm 
                    on a.id=avm.advertisement_id 
                    WHERE IF(exclude_country='yes', a.id NOT IN 
                      (SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND exclude=1), 
                     a.id IN(SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND include=1)
                    )
                    AND a.type='ticker'
                    AND ( NOW() BETWEEN a.date_start AND a.date_end) 
                    AND avm.channel_id=$contentId
                    ORDER BY RAND()
                    LIMIT 1"; 
            }     
            $result = $this->db->query($sql);
            if($result->num_rows>0){
                while($row = $result->fetch_array())
                {
                    $rows[] = $row;
                }
                foreach ($rows as $row) {
                  $ticker=array('text'=>$row['text'],
                                'show_time'=>$row['show_time']);
                }
            }

            //get one random ticker according to country 
            if($contentType=="channel"){
              $sql="SELECT a.* FROM advertisement a 
                    JOIN advertisement_video_to_channels avc 
                    on a.id=avc.advertisement_id 
                    WHERE IF(exclude_country='yes', a.id NOT IN 
                      (SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND exclude=1), 
                     a.id IN(SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND include=1)
                    )
                    AND a.type='overlay'
                    AND ( NOW() BETWEEN a.date_start AND a.date_end) 
                    AND avc.channel_id=$contentId
                    ORDER BY RAND()
                    LIMIT 1";  
            }elseif($contentType=="serie"){
              $sql="SELECT a.* FROM advertisement a 
                    JOIN advertisement_video_to_series avs 
                    on a.id=avs.advertisement_id 
                    WHERE IF(exclude_country='yes', a.id NOT IN 
                      (SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND exclude=1), 
                     a.id IN(SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND include=1)
                    )
                    AND a.type='overlay'
                    AND ( NOW() BETWEEN a.date_start AND a.date_end) 
                    AND avs.channel_id=$contentId
                    ORDER BY RAND()
                    LIMIT 1";  
            }elseif($contentType=="movie"){
               $sql="SELECT a.* FROM advertisement a 
                    JOIN advertisement_video_to_movies avm 
                    on a.id=avm.advertisement_id 
                    WHERE IF(exclude_country='yes', a.id NOT IN 
                      (SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND exclude=1), 
                     a.id IN(SELECT advertisement_id FROM advertisements_exclude_include_countries
                      WHERE country_id='$country->id' AND include=1)
                    )
                    AND a.type='overlay'
                    AND ( NOW() BETWEEN a.date_start AND a.date_end) 
                    AND avm.channel_id=$contentId
                    ORDER BY RAND()
                    LIMIT 1"; 
            }     
            $result = $this->db->query($sql);
            if($result->num_rows>0){
                while($row = $result->fetch_array())
                {
                    $rows[] = $row;
                }
                foreach ($rows as $row) {
                  $overlay=array('type'=>NULL,
                                 'url'=>$row['image'],
                                 'show_time'=>$row['show_time']);
                }
            }

            /*echo json_encode(array('servertime'=>date('Y-m-d H:i:s',time()),
                                  'preroll'=>$preroll,
                                  'ticker'=>$ticker,
                                  'overlay'=>$overlay)
            );*/
            $output = array('servertime'=>date('Y-m-d H:i:s',time()),
                            'preroll'=>$preroll,
                            'ticker'=>$ticker,
                            'overlay'=>$overlay);
            $this->response($output, REST_Controller::HTTP_OK);
        }else{
            /*$error['status'] = 'error';
            $error['code'] = -6;
            $error['message'] ='User Country could not be found';
            echo json_encode($error);*/

            $this->response([
              'status' => FALSE,
              'message' => 'User Country could not be found.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
 
    }

    // App Package Categories Request
    public function app_package_categories_get(){
      $query = $this->db->get('app_categories');
      $r = $query->result_array();
    
      if(!empty($r)){
        $this->response($r,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No app package category was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }     
    }

    // GET Apps By Category
    public function apps_get($category_id){
      $this->load->model('channels_m');
      $server_time= date('Y-m-d H:i:s');

      $this->db->where('id',$category_id);
      $query = $this->db->get('app_categories');
      $row= $query->row();

      // get all apps with the category_id
      $sql="SELECT * FROM app WHERE category_id=?";
      $query=$this->db->query($sql, $category_id);
      $apps_array=array();
      
      foreach($query->result() as $app){
        $url=rtrim($this->channels_m->get_server_url_by_id($app->server_url_id),"/");
        
        if($url!=NULL)
          $url=$url."#";
        $category =array('category_id'=>$row->id, 
                        'category_name'=>$row->name);
        array_push($apps_array, array(
                        'category' =>$category,
                        'id'=>(int)$app->id,
                        'description'=>$app->description,
                        'icon'=>$app->icon,
                        'url'=>$url.$app->url,
                        'toktype'=>$this->channels_m->get_token_code_by_id($app->token_id),
                        'appname'=>$app->name 
                        )                     
                );
      }      

      $r=array('ServerTime'=>$server_time,
               'app'=>$apps_array);
   
      if(!empty($r)){
        $this->response($r,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No app was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }     
    }

    //GET App Packages Get Request
    public function app_packages_get($package_id=0){
      if($package_id){
        $this->db->where('id',$package_id);
      }
      $this->load->model('app_packages_m');
      $app_packages = $this->app_packages_m->get();
      $data = array();
      if($app_packages){
        foreach ($app_packages as $package) {
          $this->db->select('ac.*');
          $this->db->from('app_categories as ac');
          $this->db->join('app_package_to_categories as apc','ac.id=apc.app_category_id AND apc.app_package_id='.$package['id']);
          $query=$this->db->get();
          $categories = array();

          foreach ($query->result() as $cat) {
            array_push($categories,array('id'=>$cat->id, 'name'=>$cat->name));
          }

          array_push($data,array(
                  'id' => $package['id'],
                  'name'=>$package['name'],
                  'price'=>ucwords($package['price']),
                  'categories' => $categories              
              ));
        }

        $this->response($data,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No app packages found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }  
    }

    //Menu -----------
    //get menus --
    public function menus_get($id=0){
      $this->load->model('menus_m');
      
      if($id)
        $this->db->where('id',$id);
      
      $menus=$this->db->get('iptv_menus');


      $menu_data=array();

      if($menus->result()){
        foreach ($menus->result() as $menu) {
            //iptv_menu_package_item
            $this->db->select('mp.*');
            $this->db->from('iptv_menu_packages as mp');
            $this->db->join('iptv_menu_package_item as mpi', 'mp.id=mpi.menu_package_id');
            $this->db->where('mpi.menu_id',$menu->id);
            $query= $this->db->get();
            $package_data=array();
            foreach ($query->result() as $pack) {
                array_push($package_data, 
                          array('id'=>$pack->id,
                                'name'=>$pack->name,
                                'url'=>$pack->url));
            }

            array_push($menu_data, 
                       array('id'=>$menu->id,
                             'name'=>$menu->name,
                             'type'=>$menu->type,
                             'is_default'=>$menu->is_default,
                             'is_module'=>$menu->is_module,
                             'module_name'=>$menu->module_name,
                             'is_app'=>$menu->is_app,
                             'postion'=>$menu->position,
                             'active'=>$menu->active,
                             'package'=>$package_data
                           ));
        }

        $this->response($menu_data,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Menu was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }

    }

    //get packages --
    public function menu_packages_get($id=0){
            
      if($id)
        $this->db->where('id',$id);
      
      $packages=$this->db->get('iptv_menu_packages');


      $package_data=array();

      if($packages->result()){
        foreach ($packages->result() as $pack) {
            //iptv_menu_package_item
            $this->db->select('m.*');
            $this->db->from('iptv_menus as m');
            $this->db->join('iptv_menu_package_item as mpi', 'm.id=mpi.menu_id');
            $this->db->where('mpi.menu_package_id',$pack->id);
            $query= $this->db->get();

            $menu_data=array();
            foreach ($query->result() as $menu) {
                array_push($menu_data, 
                          array('id'=>$menu->id,
                                'name'=>$menu->name,
                                'module_name'=>$menu->module_name));
            }

            array_push($package_data, 
                       array('id'=>$pack->id,
                             'name'=>$pack->name,
                             'url'=>$pack->url,
                             'menu'=>$menu_data
                           ));
        }

        $this->response($package_data,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Menu Package was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }

    }

    //channels -----------

    // get TV channels groups
    public function groups_get($id=0){
      $server_time= date('Y-m-d H:i:s'); 

      //get all TV Groups which has channels
     /* $sql="Select cg.* From channel_group cg
          JOIN channel_to_group ctg on
          cg.id= ctg.group_id group by cg.id";
      $query=$this->db->query($sql);*/

      $this->db->select('cg.*');
      $this->db->from('channel_group cg');
      if($id){
        $this->db->where('cg.id',$id);
      }
      $this->db->join('channel_to_group ctg', 'cg.id= ctg.group_id');
      $this->db->group_by('cg.id');
      $query = $this->db->get();

      $result = array('ServerTime'=>$server_time);
      
      $tv_group_array=array();
      if($query->result()){
        foreach ($query->result() as $tv_group) {
          //get all channels with this group
          $sql_channels="Select c.* From channel c
                   JOIN channel_to_group ctg on
                       c.id= ctg.channel_id 
                       WHERE ctg.group_id='$tv_group->id'";
          $query_channels=$this->db->query($sql_channels);
          $channels_array=array();
          foreach ($query_channels->result() as $channel) {

            //get all packages with this channel
            $sql_packages="Select cp.* From channel_package cp
                     JOIN package_to_channel ptc on
                         cp.id= ptc.package_id 
                         WHERE ptc.channel_id='$channel->id'";

            $query_packages=$this->db->query($sql_packages);
            $packages_array=array();
            foreach ($query_packages->result() as $package) {
              array_push($packages_array,
                         array('package_name'=>$package->name,
                               'price'=>$package->price
                              )
                          );
            }
            array_push($channels_array,array('channelprices'=>$packages_array,
                             'playlist'=>array(),
                             'events'=>array(),
                             'channel_id'=>$channel->id,
                             'channel_number'=>$channel->channel_number,
                             'name'=>$channel->channel_name,
                             'group_id'=>$tv_group->id,
                             'group_name'=>$tv_group->name,
                             'group_position'=>$tv_group->position,
                             'have_archive'=>'',
                             'url_high'=>$channel->url_high,
                             'url_low'=>$channel->url_low,
                             'url_interactivetv'=>$channel->url_interactivetv,
                             'is_flussonic'=>$channel->flussonoc,
                                 'is_dveo'=>'',
                                 'icon'=>'',
                                 'icon_small'=>'',
                                 'icon_big'=>'',
                                 'encoder_id'=>'',
                                 'preroll_enabled'=>$channel->preroll_enabled,
                                 'overlay_enabled'=>$channel->overlay_enabled,
                                 'ticker_enabled'=>$channel->ticker_enabled,
                                 'childlock'=>$channel->childlock,
                                 'fingerprint'=>$channel->fingerprint,
                                 'flusonnic'=>$channel->flussonoc,
                                 'use_playlist'=>'',
                                 'use_events'=>'',
                                 'secure_stream'=>$channel->secure_stream,
                                 'drm_stream'=>'',
                                 'drm_rewrite_rule'=>'',
                                 'is_payperview'=>'',
                                 'rule_payperview'=>'',
                                 'is_kids_friendly'=>'',
                                 'dvr_channel_name'=>$channel->dvr_channel_name
                            )
              );
          }

          array_push($tv_group_array, array('id'=>$tv_group->id,
                            'name'=>$tv_group->name,
                            'position'=>$tv_group->position,
                            'channels'=>$channels_array
                        )
                );
        }

        $main_array=array('ServerTime'=>$server_time,
                  'tv'=>$tv_group_array
                );

       $this->response($main_array,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Channel Group was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }

    //get channel packages
    public function channel_packages_get($package_id=0){
      $this->load->model('channels_m');

      // get channel_package
      if($package_id){
        $this->db->where('id',$package_id);
      }
      $query= $this->db->get('channel_package');
      $channel_packages = $query->result();

      $packages =array();
      if($channel_packages){
        foreach ($channel_packages as $package) {
            $channels=array();
            
            //get device type
            $this->db->where('id',$package->device_type);
            $query = $this->db->get('sys_channel_packet_devices');
            $device=$query->row();

            // get channel ids with this package
            $this->db->select('channel_id');
            $this->db->from('package_to_channel');
            $this->db->where(array('package_id'=>$package->id));
            $sub_query = $this->db->get_compiled_select();

            // get channels with this package
            $this->db->select('*');
            $this->db->from('channel');
            $this->db->where("id IN ($sub_query)");
            $query = $this->db->get();
            foreach($query->result() as $channel){

              $url_high=rtrim($this->channels_m->get_server_url_by_id($channel->server_url_high),"/");
              
              if($url_high!=NULL)
                $url_high=$url_high."#";

              $url_low=rtrim($this->channels_m->get_server_url_by_id($channel->server_url_low),"/");
              
              if($url_low!=NULL)
                $url_low=$url_low."#";

              $url_interactivetv=rtrim($this->channels_m->get_server_url_by_id($channel->server_url_interactivetv),"/");

              if($url_interactivetv!=NULL)
                $url_interactivetv=$url_interactivetv."#";

              array_push($channels,array(                       
                        'channel_id'=>(int)$channel->id,
                        'channel_number'=>(int)$channel->channel_number,
                        'name'=>$channel->channel_name,
                        'channelprices'=>array(),
                        'url_high'=>$url_high.$channel->url_high,
                        'toktype_high'=>$this->channels_m->get_token_code_by_id($channel->token_high),
                        'url_low'=>$url_low.$channel->url_low,
                        'toktype_low'=>$this->channels_m->get_token_code_by_id($channel->token_low),
                        'url_interactivetv'=>$url_interactivetv.$channel->url_interactivetv,
                        'toktype_interactive'=>$this->channels_m->get_token_code_by_id($channel->token_interactivetv),
                        'dvr_offset'=>(int)$channel->dvr_offset,
                        'icon'=>$channel->channel_image,
                        'preroll_enabled'=>(int)$channel->preroll_enabled,
                        'overlay_enabled'=>(int)$channel->overlay_enabled,
                        'ticker_enabled'=>(int)$channel->ticker_enabled,
                        'childlock'=>(int)$channel->childlock,
                        'flusonnic'=>(int)$channel->is_flussonic,
                        'is_kids_friendly'=>($channel->is_kids_friendly==0) ? false : true
                        )
                      );
            }

            array_push($packages, array(
                    'id'=>$package->id,
                    'name'=>$package->name,
                    'price'=>$package->price,
                    'vat'=>$package->vat,
                    'device_type'=>array(
                                  'id'=>$device->id,
                                  'name'=>$device->name
                                ),
                    'active' =>$package->active,
                    'channels' =>$channels)
                  );
        }

        $this->response($packages,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No package was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
      
    }

    // get channels 
    public function channels_get($id=0){
      $this->load->model('channels_m');

      // get channels
      if($id){
        $this->db->where('id',$id);
      }
      $query= $this->db->get('channel');
      $channels = $query->result();

      $channels_data =array();
      if($channels){
        foreach($channels as $channel){

          $url_high=rtrim($this->channels_m->get_server_url_by_id($channel->server_url_high),"/");
          
          if($url_high!=NULL)
            $url_high=$url_high."#";

          $url_low=rtrim($this->channels_m->get_server_url_by_id($channel->server_url_low),"/");
          
          if($url_low!=NULL)
            $url_low=$url_low."#";

          $url_interactivetv=rtrim($this->channels_m->get_server_url_by_id($channel->server_url_interactivetv),"/");

          if($url_interactivetv!=NULL)
            $url_interactivetv=$url_interactivetv."#";

          array_push($channels_data ,array(                       
                    'channel_id'=>(int)$channel->id,
                    'channel_number'=>(int)$channel->channel_number,
                    'name'=>$channel->channel_name,
                    'channelprices'=>array(),
                    'url_high'=>$url_high.$channel->url_high,
                    'toktype_high'=>$this->channels_m->get_token_code_by_id($channel->token_high),
                    'url_low'=>$url_low.$channel->url_low,
                    'toktype_low'=>$this->channels_m->get_token_code_by_id($channel->token_low),
                    'url_interactivetv'=>$url_interactivetv.$channel->url_interactivetv,
                    'toktype_interactive'=>$this->channels_m->get_token_code_by_id($channel->token_interactivetv),
                    'dvr_offset'=>(int)$channel->dvr_offset,
                    'icon'=>$channel->channel_image,
                    'preroll_enabled'=>(int)$channel->preroll_enabled,
                    'overlay_enabled'=>(int)$channel->overlay_enabled,
                    'ticker_enabled'=>(int)$channel->ticker_enabled,
                    'childlock'=>(int)$channel->childlock,
                    'flusonnic'=>(int)$channel->is_flussonic,
                    'is_kids_friendly'=>($channel->is_kids_friendly==0) ? false : true
                    )
                  );
        }
        $this->response($channels_data,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No channel was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
      
    }

    // music ---------

    //get music categories 
    public function music_categories_get($category_id=0){
      if($category_id){
        $this->db->where('id',$category_id);
      }
      $query= $this->db->get('music_categories');
      $categories = $query->result();
      $cat_array=array();

      if($categories){
        foreach ($categories as $cat) {
          array_push($cat_array, array('id'=>$cat->id, 'name'=>$cat->name));
        }
        $this->response($cat_array,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Music Category was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }
    //get albums by category
    public function albums_get($category_id){

      $this->load->model('channels_m');
      
      $this->db->where('id',$category_id);
      $query= $this->db->get('music_categories');
      $category_detail=$query->row();

      $this->db->where('category_id',$category_id);
      $query= $this->db->get('albums');
      $albums = $query->result();
      $albums_array=array();

      if($albums){
        foreach ($albums as $album) {
          
          $this->db->where('album_id',$album->id);
          $query_songs= $this->db->get('songs');

          $songs_array=array();
          
          foreach ($query_songs->result() as $song) {
            $url=rtrim($this->channels_m->get_server_url_by_id($song->server_url_id),"/");
            
            if($url!=NULL)
              $url=$url."#";

            array_push($songs_array, array('id'=>(int)$song->id,
                           'name'=>$song->name,
                           'url'=>$url.$song->url,
                           'toktype'=>$this->channels_m->get_token_code_by_id($song->token_id),
                           'secure_stream'=>($song->secure_stream==0) ? false: true,
                           'has_drm'=>($song->has_drm==0) ? false: true)
                );
          }
          array_push($albums_array, array(
                 'id'=>(int)$album->id,
                 'name'=>$album->name,
                 'description'=>$album->description,
                 'poster'=>$album->cover,
                 'artist'=>$album->artist,
                 'prices'=>array(),
                 'is_payperview'=>($album->is_payperview==0) ? false: true,
                 'rule_payperview'=>$album->rule_payperview,
                 'is_kids_friendly'=>($album->is_kids_friendly==0) ? false: true,
                 'category'=>array('category_id'=>$category_detail->id,
                              'category_name'=>$category_detail->name),
                 'songs'=>$songs_array
                ));
        }
        $this->response($albums_array,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Album was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }

    // get songs by album
    public function songs_get($album_id){
      $this->load->model('channels_m');

      $this->db->where('id',$album_id);
      $query= $this->db->get('albums');
      $album_detail=$query->row();

      $this->db->where('album_id',$album_id);
      $query= $this->db->get('songs');
      $songs = $query->result();
      $songs_array=array();

      if($songs){
        foreach ($songs as $song) {
         
            $url=rtrim($this->channels_m->get_server_url_by_id($song->server_url_id),"/");
            
            if($url!=NULL)
              $url=$url."#";

            array_push($songs_array, array(
                           'id'=>(int)$song->id,
                           'name'=>$song->name,
                           'url'=>$url.$song->url,
                           'toktype'=>$this->channels_m->get_token_code_by_id($song->token_id),
                           'secure_stream'=>($song->secure_stream==0) ? false: true,
                           'has_drm'=>($song->has_drm==0) ? false: true,
                           'album' =>array(
                              'id'=>(int)$album_id,
                              'name'=>$album_detail->name,
                              'description'=>$album_detail->description,
                              'poster'=>$album_detail->cover,
                              'artist'=>$album_detail->artist)
                            )
                      );
          }
         
        $this->response($songs_array,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'Songs Not was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }

    // get songs by album
    public function song_details_get($song_id){
      $this->load->model('channels_m');    

      if(!$song_id)
        $this->response([
                'status' => FALSE,
                'message' => 'Song id is required.'
            ], REST_Controller::HTTP_BAD_REQUEST);

      $this->db->where('id',$song_id);
      $query= $this->db->get('songs');
      $song = $query->row();
    
      if($song){

        // get album detail
        $this->db->where('id',$song->album_id);
        $query= $this->db->get('albums');
        $album_detail=$query->row();

        $url=rtrim($this->channels_m->get_server_url_by_id($song->server_url_id),"/");
        
        if($url!=NULL)
          $url=$url."#";

        $song_array= array(
                   'id'=>(int)$song->id,
                   'name'=>$song->name,
                   'url'=>$url.$song->url,
                   'toktype'=>$this->channels_m->get_token_code_by_id($song->token_id),
                   'secure_stream'=>($song->secure_stream==0) ? false: true,
                   'has_drm'=>($song->has_drm==0) ? false: true,
                   'album' =>array(
                      'id'=>$song->album_id,
                      'name'=>$album_detail->name,
                      'description'=>$album_detail->description,
                      'poster'=>$album_detail->cover,
                      'artist'=>$album_detail->artist)
                    );
               
        $this->response($song_array,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'Song not was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }

    // movies

    // get stores list
    public function movie_stores_get($parent_id=0){
      $this->db->where('parent_id',$parent_id);
      $query = $this->db->get('movie_store');
      $r = $query->result();
      $stores_array = array();
      $parent_stores= array();
      $sub_stores_array= array();

      if($r){
        foreach ($r as $store) {
          
          if($store->parent_id==0){
            $this->db->where('parent_id',$store->id);
            $query = $this->db->get('movie_store');
            $sub_stores = $query->result();
            $sub_stores_array= array();
            if($sub_stores){
              foreach ($sub_stores as $sub_store) {
                array_push($sub_stores_array, array(
                                'id'=>$sub_store->id,
                                'name'=>$sub_store->name)
                          );
              }
            }        
          }

          if($store->parent_id!=0){
            $this->db->where('id',$store->parent_id);
            $query = $this->db->get('movie_store');
            $parent_store = $query->row();
            $parent_stores= array();
            if($parent_store){
              $parent_stores=array(
                      'id'=>$parent_store->id,
                      'name'=>$parent_store->name);
            }
          }

          array_push($stores_array,array(
                'id'=>$store->id,
                'name'=>$store->name,
                'logo'=>$store->logo,
                'childlock'=>$store->childlock,
                'position'=>$store->position,
                'active'=>$store->active,
                'parent_store'=>$parent_stores,
                'sub_stores' => $sub_stores_array
              ));

        }
        
        $this->response($stores_array,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Store was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }     
    }

    // get specific store detail
    public function movie_store_details_get($id){
      $this->db->where('id',$id);
      $query = $this->db->get('movie_store');
      $r = $query->row();
      
      $parent_store=array();
      $sub_stores_array= array();

      if($r->parent_id!=0){
        $this->db->where('id',$r->parent_id);
        $query = $this->db->get('movie_store');
        $parent_store = $query->row();
        $parent_store=array(
                  'id'=>$parent_store->id,
                  'name'=>$parent_store->name);
      }

      if($r->parent_id==0){
        $this->db->where('parent_id',$r->id);
        $query = $this->db->get('movie_store');
        $sub_stores = $query->result();
        $sub_stores_array= array();
        if($sub_stores){
          foreach ($sub_stores as $sub_store) {
            array_push($sub_stores_array, array(
                            'id'=>$sub_store->id,
                            'name'=>$sub_store->name)
                      );
          }
        }        
      }

      $store=array(
                  'id'=>$r->id,
                  'name'=>$r->name,
                  'logo'=>$r->logo,
                  'childlock'=>$r->childlock,
                  'position'=>$r->position,
                  'active'=>$r->active,
                  'parent_store'=>$parent_store,
                  'sub_stores' => $sub_stores_array
            );

      if(!empty($store)){
        $this->response($store,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Store was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }     
    }

    // movie genre 
    public function movie_genres_get($id=0){
      $this->load->model('movie_stores_m');
      if($id){
        $this->db->where('id',$id);
      }
      $query = $this->db->get('movie_genre');
      $r = $query->result();
      
      $movie_store=array();
      $movie_sub_store= array();
      $genre_data=array();
      
      if($r){
        foreach ($r as $genre) {

          $store_id= $genre->store_id;

          // check parent store 
          $parent_id=$this->movie_stores_m->check_if_parent($store_id);

          if($parent_id==0){
            $parent_store_id= $store_id;
            $sub_store_id= 0;
          }else{
            $parent_store_id= $parent_id;
            $sub_store_id= $store_id;
          }

          $this->db->where('id',$parent_store_id);
          $query = $this->db->get('movie_store');
          $main_store = $query->row();


          if($sub_store_id!=0){
            $this->db->where('id',$sub_store_id);
            $query = $this->db->get('movie_store');
            $sub_store = $query->row();
          }

          array_push($genre_data, array(
                                    'id'=>$genre->id,
                                    'name'=>$genre->name,
                                    'movie_store'=>$main_store,
                                    'movie_sub_store'=>
                                    $sub_store)
                    );
        }

        $this->response($genre_data,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Genre was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }

    // movie language
    public function movie_languages_get($id=0){

      if($id){
        $this->db->where('id',$id);
      }
      $query = $this->db->get('languages');
      $r = $query->result_array();

      if($r){
        $this->response($r,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Language was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }   
    }

    // get movies 
    public function movies_get($id=0){
      $this->load->model('movie_stores_m');
      $this->load->model('channels_m');
      $server_time= date('Y-m-d H:i:s'); 
     
      $this->db->select('m.*,j.name language_name');
      $this->db->from('movie as m');
      if($id){
        $this->db->where('m.id',$id);
      }
      $this->db->join('languages as j', 'm.language = j.id');
      $query = $this->db->get();
      $m =$query->result();
      
      $movie_data= array();
      $movie_store=array();
      $movie_sub_store= array();
      $genre_data=array();
      
      if($m){
        foreach ($m as $movie) {

          $store_id= $movie->store_id;

          // check parent store 
          $parent_id=$this->movie_stores_m->check_if_parent($store_id);

          if($parent_id==0){
            $parent_store_id= $store_id;
            $sub_store_id= 0;
          }else{
            $parent_store_id= $parent_id;
            $sub_store_id= $store_id;
          }

          $this->db->where('id',$parent_store_id);
          $query = $this->db->get('movie_store');
          $main_store = $query->row();

          if($sub_store_id!=0){
            $this->db->where('id',$sub_store_id);
            $query = $this->db->get('movie_store');
            $sub_store = $query->row();
          }

          $url_trailer=rtrim($this->channels_m->get_server_url_by_id($movie->server_url_trailer),"/");
          
          if($url_trailer!=NULL)
            $url_trailer=$url_trailer."#";

          $tags=explode(",", $movie->tags);

          //get movie stream urls 
          $sql="Select msu.stream_name,l.name language_name,t.token_short_code,siu.url
                FROM movie_stream_urls msu
              JOIN movie m on m.id=msu.movie_id
              JOIN languages l on l.id=msu.language_id
              JOIN token t on t.id=msu.token_id
              LEFT JOIN server_items_urls siu on siu.id=msu.server_url_id
              WHERE msu.movie_id=".$movie->id;
          $query=$this->db->query($sql);    
          $stream_urls=array();          

          foreach ($query->result() as $stream) {
            if($stream->url!=NULL){
              $stream_url=rtrim($stream->url,"/");
              $url=$stream_url."#".$stream->stream_name;
            }else{
              $url=$stream->stream_name;
            }
      
            array_push($stream_urls,array('url'=>$url,
                            'language'=>$stream->language_name,
                            'toktype'=>$stream->token_short_code
                            )
                      );
          }

          //get genres ids with this movie
          $this->db->select('genre_id');
          $this->db->from('movie_to_genres');
          $this->db->where(array('movie_id'=>$movie->id));
          $sub_query = $this->db->get_compiled_select();

          // get channels with this package
          $this->db->select('mg.*,ms.id as ms_id, ms.name as ms_name');
          $this->db->from('movie_genre as mg');
          $this->db->join('movie_store as ms','ms.id=mg.store_id');
          $this->db->where("mg.id IN ($sub_query)");
          $gnre = $this->db->get();

          if($gnre->result()){
            $genre_data=array();
            foreach ($gnre->result() as $gen) {
              
              array_push($genre_data, array(
                                        'id'=>$gen->id, 
                                        'name'=>$gen->name,
                                        'store'=>array(
                                          'id'=>$gen->ms_id, 
                                          'name'=>$gen->ms_name)));
            }
          }


          $movie_array=array('ServerTime'=>$server_time,
                  'id'=>(int)$movie->id,
                  'name'=>$movie->name,
                  'description'=>$movie->description,
                  'poster'=>$movie->poster,
                  'backdrop'=>$movie->backdrop,
                  'length'=>(int)$movie->duration,
                  'year'=>$movie->year,
                  'trailer_url'=>$url_trailer.$movie->trailer,
                  'toktype_trailer'=>$this->channels_m->get_token_code_by_id($movie->token_trailer),
                  'actors'=>$movie->actor,
                  'rating'=>$movie->rating,
                  'language'=>$movie->language_name,
                  'childlock'=>(int)$movie->childlock,
                  'is_kids_friendly'=>($movie->is_kids_friendly==0) ? false : true,
                  'moviedescriptions'=>array(array('language'=>$movie->language_name,
                                 'description'=>$movie->description
                   )),
                  'moviestreams'=>$stream_urls,
                  'tags'=>$tags,
                  'has_preroll'=>(int)$movie->preroll_enabled,
                  'has_overlaybanner'=>(int)$movie->overlay_enabled,
                  'has_ticker'=>(int)$movie->ticker_enabled,
                  'genres'=>$genre_data
                  );

          array_push($movie_data, $movie_array);
        }

        $this->response($movie_data,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Movie was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }  

    // series

    // get series stores list
    public function series_stores_get($store_id=0){
      $this->load->model('channels_m');
      $server_time= date('Y-m-d H:i:s'); //
      
      //get all stores which has series
      $this->db->select('s.*');
      $this->db->from('series_store as s');
      if($store_id){
        $this->db->where('s.id',$store_id);
      }
      $this->db->join('series sr', 'sr.store_id= s.id');
      $this->db->group_by('s.id');
      $query = $this->db->get();

      $stores_array=array();
      if($query->result()){
      foreach ($query->result() as $store) {
        //get all series associated with store_id
        $sql_series="Select * From series 
           WHERE store_id='$store->id'";
        $query_series=$this->db->query($sql_series);
        
        $series_array=array();
        foreach ($query_series->result() as $series) {
          
            //get all seasons associated with series_id
            $sql_seasons="Select ss.*,l.name language_name 
                  From series_seasons ss
                  JOIN languages l on 
                  l.id=ss.language
                  WHERE ss.series_id='$series->id'";
            $query_seasons=$this->db->query($sql_seasons);
            
            $seasons_array=array();
            foreach ($query_seasons->result() as $season) {

              //get all episodes associated with season_id
              $sql_episodes="Select sp.*,l.name language_name 
                    From series_episode sp
                    JOIN languages l on 
                    l.id=sp.language_id
                    WHERE sp.season_id='$season->id'";
              $query_episodes=$this->db->query($sql_episodes);
              $episodes_array=array();
              
              foreach ($query_episodes->result() as $episode) {

                $url=rtrim($this->channels_m->get_server_url_by_id($episode->server_url_id),"/");
                if($url!=NULL)
                  $url=$url."#";

                array_push($episodes_array,
                           array(
                              'id'=>(int)$episode->id,
                              'name'=>$episode->title,
                              'streams'=>array(
                                array('url'=>$url.$episode->url,
                                      'language'=>$episode->language_name,
                                      'toktype'=>$this->channels_m->get_token_code_by_id($episode->token_id)
                                    )
                                  )
                                )
                          );
              }

              array_push($seasons_array,array(
                            'id'=>(int)$season->id,
                            'name'=>$season->name,
                              'poster'=>$season->poster,
                              'backdrop'=>$season->backdrop,
                                'childlock'=>(int)$season->childlock,
                                'length'=>(int)$season->duration,
                                'year'=>$season->year,
                                'actors'=>$season->actor,
                                'rating'=>$season->rating,
                                'language'=>$season->language_name,
                                'is_kids_friendly'=>($season->is_kids_friendly==0) ? false: true,
                                'has_preroll'=>(int)$season->preroll_enabled,
                                'has_overlaybanner'=>(int)$season->overlay_enabled,
                                'has_ticker'=>(int)$season->ticker_enabled,
                                'descriptions'=>array(
                                      array('language'=>$season->language_name,
                                           'description'=>$season->description)
                                    ),
                                'episodes'=>$episodes_array,
                                'tags'=>($season->tags!="") ? explode(",",$season->tags) : array()
                          )
                  );
            }

            array_push($series_array,array(
                        'name'=>$series->name,
                        'logo'=>$series->logo,
                        'childlock'=>(int)$series->childlock,
                        'position'=>(int)$series->position,
                        'id'=>(int)$series->id,
                        'season'=>$seasons_array
                        )
            );
        }

        array_push($stores_array,
                  array('vod_id'=>(int)$store->id,
                        'name'=>$store->name,
                        'logo'=>$store->logo,
                        'childlock'=>(int)$store->childlock,
                        'position'=>(int)$store->position,
                        'series'=>$series_array
                        )
                    );
      }

      $this->response($stores_array,REST_Controller::HTTP_OK); 
      
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Series was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }

    // get series 
    public function series_get($id=0){
      $this->load->model('channels_m');
      //get all series associated with store_id
      if($id){
        $this->db->where('id',$id);
      }
      $query_series= $this->db->get('series');

      $series_array=array();
      if($query_series->result()){
        foreach ($query_series->result() as $series) {
          //get all seasons associated with series_id
          $sql_seasons="Select ss.*,l.name language_name 
                From series_seasons ss
                JOIN languages l on 
                l.id=ss.language
                WHERE ss.series_id='$series->id'";
          $query_seasons=$this->db->query($sql_seasons);
          
          $seasons_array=array();
          foreach ($query_seasons->result() as $season) {
            //get all episodes associated with season_id
            $sql_episodes="Select sp.*,l.name language_name 
                  From series_episode sp
                  JOIN languages l on 
                  l.id=sp.language_id
                  WHERE sp.season_id='$season->id'";
            $query_episodes=$this->db->query($sql_episodes);
            $episodes_array=array();
            
            foreach ($query_episodes->result() as $episode) {
              $url=rtrim($this->channels_m->get_server_url_by_id($episode->server_url_id),"/");
              if($url!=NULL)
                $url=$url."#";

              array_push($episodes_array,
                        array('id'=>(int)$episode->id,
                              'name'=>$episode->title,
                              'streams'=>array(
                                'url'=>$url.$episode->url,
                                'language'=>$episode->language_name,
                                'toktype'=>$this->channels_m->get_token_code_by_id($episode->token_id)
                                )
                              )
                        );
            }

            array_push($seasons_array,array(
                          'id'=>(int)$season->id,
                          'name'=>$season->name,
                            'poster'=>$season->poster,
                            'backdrop'=>$season->backdrop,
                              'childlock'=>(int)$season->childlock,
                              'length'=>(int)$season->duration,
                              'year'=>$season->year,
                              'actors'=>$season->actor,
                              'rating'=>$season->rating,
                              'language'=>$season->language_name,
                              'is_kids_friendly'=>($season->is_kids_friendly==0) ? false: true,
                              'has_preroll'=>(int)$season->preroll_enabled,
                              'has_overlaybanner'=>(int)$season->overlay_enabled,
                              'has_ticker'=>(int)$season->ticker_enabled,
                              'descriptions'=>array(array('language'=>$season->language_name,
                                         'description'=>$season->description)),
                            'episodes'=>$episodes_array,
                            'tags'=>($season->tags!="") ? explode(",",$season->tags) : array()
                        )
                );
          }

          array_push($series_array, array(
                     'id'=>(int)$series->id,
                     'name'=>$series->name,
                     'logo'=>$series->logo,
                     'childlock'=>(int)$series->childlock,
                     'position'=>(int)$series->position,
                     'season'=>$seasons_array
                    ));
        }
        $this->response($series_array,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Series was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }

    // product and services
    // get services
    public function services_get($id=0){
      if($id){
        $this->db->where('id',$id);
      }
      $query = $this->db->get('services');
      $r = $query->result();
      $services_data=array();

      if($r){
        foreach ($r as $srv) {
          $this->db->select('im.*');
          $this->db->from('iptv_menus im');
          $this->db->join('services_menu_items smi','smi.menu_id=im.id');
          $this->db->where(array('smi.service_id' => $srv->id));
          $query = $this->db->get();
          $menu_data=array();
          foreach ($query->result() as $menu) {
            array_push($menu_data, array(
                      'id'=>$menu->id, 
                      'name'=>$menu->name)
                  );
          }

          array_push($services_data, 
                    array('id'=>$srv->id,
                          'name'=>$srv->name,
                          'price'=>$srv->price,
                          'vat'=>$srv->vat,
                          'menu'=>$menu_data));
        }

        $this->response($services_data,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Service was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }   
    }

    // get devices
    public function devices_get($id=0){
      if($id){
        $this->db->where('id',$id);
      }
      $query = $this->db->get('devices');
      $r = $query->result_array();

      if($r){
        $this->response($r,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Device was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }   
    }

    // get gui versions
    public function gui_versions_get($id=0){
      if($id){
        $this->db->where('id',$id);
      }
      $query = $this->db->get('gui_versions');
      $r = $query->result_array();

      if($r){
        $this->response($r,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No GUI Version was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }   
    }

     // get gui versions
    public function gui_settings_get($id=0){
      
      $this->db->select('gs.*,v.id as version_id, v.version as version_name');
      $this->db->from('gui_settings as gs');
      $this->db->join('gui_versions as v','v.id=gs.version_id');
      if($id){
        $this->db->where('gs.id',$id);
      }
      $query = $this->db->get();
      $r = $query->result_array();
     
      if($r){
        $this->response($r,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No GUI Setting was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }   
    }

    // get servers
    public function servers_get($id=0){
      if($id){
        $this->db->where('id',$id);
      }
      $query = $this->db->get('server_locations');
      $r = $query->result();
      $servers_array=array();
      if($r){
         foreach ($r as $srv) {
            // get locations server_location_items
            $this->db->where('server_id',$srv->id);
            $query = $this->db->get('server_location_items');
            $locations=$query->result();

            $location_array=array();
            $domains_array=array();
            foreach ($locations as $loc) {

              if($loc->type=="location"){
                array_push($location_array, 
                          array('id'=>$loc->id,
                                'name'=>$loc->name,
                                'url'=>$loc->url));
              }

              if($loc->type=="domain"){
                array_push($domains_array, 
                          array('id'=>$loc->id,
                                'name'=>$loc->name,
                                'url'=>$loc->url));
              }
            }     

            array_push($servers_array, 
                       array('id'=>$srv->id,
                             'name'=>$srv->name,
                             'locations'=>$location_array,
                             'domains'=>$domains_array
                           ));

          }

          $this->response($servers_array,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Server was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }

    // get products 
    public function products_get($id=0){
      $this->load->model('products_m');
    
      // get all products 
      if($id){
        $products = $this->products_m->get_by(array('id'=>$id));
      }else{
        $products = $this->products_m->get();
      }

      $products_array=array();
      if($products){
        foreach ($products as $product) {
          
          // get menu items from services assciated with this product
          $sql="SELECT m.* FROM iptv_menus m
                JOIN services_menu_items smi on m.id=smi.menu_id
                WHERE smi.service_id=?";
        
          $query=$this->db->query($sql,$product['service_id']);
          $menu_items_array=array();
          foreach ($query->result() as $menu) {
            array_push($menu_items_array, array('name'=>$menu->name,
                                'position'=>$menu->position,
                                'is_default'=>($menu->is_default=="yes") ? true : false,
                                'is_module'=>($menu->is_module=="yes") ? true : false,
                                'module_name'=>($menu->module_name!="") ? $menu->module_name : null,
                                'type'=>$menu->type,
                                'is_app'=>($menu->is_app=="yes") ? true : false,
                                'package_name'=>null,
                                'package_url'=>null
                                )
                );
          }

          // get channel packages
          $sql_packages="SELECT cp.* FROM channel_package cp
                JOIN product_to_packages pp on cp.id=pp.package_id
                WHERE pp.product_id=?";

          $query_packages=$this->db->query($sql_packages,$product['id']);
          $packages_array=array();
          foreach ($query_packages->result() as $package) {
            array_push($packages_array, array('PackageID'=>$package->id));
          }

          // get App packages
          $sql_app_packages="SELECT c.* FROM app_package_to_categories c 
                         JOIN app_packages ap on ap.id=c.app_package_id
                         JOIN products p on p.app_package_id=ap.id
                         WHERE p.id=?";

          $query_app_packages=$this->db->query($sql_app_packages,$product['id']);
          
          $app_packages_array=array();
          foreach ($query_app_packages->result() as $app_package) {
            array_push($app_packages_array, array('PackageID'=>$app_package->app_category_id));
          }

          // get Movie Stores
          $sql_movie_stores="SELECT ms.* FROM movie_store ms
                         JOIN product_to_vod_stores pvs on ms.id=pvs.vod_store_id
                             WHERE pvs.product_id=?";

          $query_movie_stores=$this->db->query($sql_movie_stores,$product['id']);
          $movie_stores_array=array();
          foreach ($query_movie_stores->result() as $movie_store) {
            array_push($movie_stores_array, array('PackageID'=>$movie_store->id));
          }
          // get Series Stores
          $sql_series_stores="SELECT ss.* FROM series_store ss
                         JOIN product_to_series_stores pss on ss.id=pss.series_store_id
                             WHERE pss.product_id=?";

          $query_series_stores=$this->db->query($sql_series_stores,$product['id']);
          $series_stores_array=array();
          foreach ($query_series_stores->result() as $series_store) {
            array_push($series_stores_array, array('PackageID'=>$series_store->id));
          }


          // get Devices Stores
          $sql_devices="SELECT d.* FROM devices d
                         JOIN product_to_devices pd on d.id=pd.device_id
                             WHERE pd.product_id=?";

          $query_devices=$this->db->query($sql_devices,$product['id']);
          $devices_array=array();
          foreach ($query_devices->result() as $device) {
            $devices_array[$device->model_name]=($device->available) ? $device->available : "false";
          }

          // get GUI Settings 
          $sql_settings="SELECT gs.*,ut.name as ui,gv.location FROM gui_settings gs
                       JOIN ui_themes ut on gs.ui=ut.id
                       JOIN gui_versions gv on gv.id=gs.version_id
                       WHERE gs.id=?";

          $query_settings=$this->db->query($sql_settings,$product['gui_setting_id']);
        
          $settings_array=array();
          $setting_info=$query_settings->row();
                  
          foreach ($setting_info as $key=>$value) {
            if($key!="id" && $key!="setting_name" && $key!="qrcode" && $key!="text" && $key!="logo" && $key!="background" && $key!="selection_color")
              $settings_array[$key]= ($value=="true" ? true:$value);
          }

          $settings_array['gui_start_url'] = rtrim($settings_array['gui_start_url'],'/')."/".ltrim($settings_array['location'],'/');
                
          // get server locations
          // get GUI SEttings 
          $sql_server_location="SELECT * FROM server_location_items
                            WHERE server_id=?";

          $query_server_location=$this->db->query($sql_server_location,$product['server_id']);
          $location_array=array();

          foreach ($query_server_location->result() as $location) {
            
            $location_array[$location->name]=$location->url;
          }
                unset($location_array['ui']); 

          $main_array=array(
                  'id'=>$product['id'],
                  'name'=>$product['name'],
                  'menu'=>array('menuitems'=>$menu_items_array),
                  'contact'=>array('qrcode'=>$setting_info->qrcode,
                           'text'=>$setting_info->text,
                           'logo'=>$setting_info->logo,
                           'background'=>$setting_info->background,
                           'selection_color'=>$setting_info->selection_color
                          ),
                  'facebook'=>array('appid'=>'', 'clienttoken'=>''),
                  'ChannelPackages'=>$packages_array,
                  'AppPackages'=>$app_packages_array,
                  'MovieStores'=>$movie_stores_array,
                  'SeriesStores'=>$series_stores_array,
                  'MusicPackages'=>array(),
                  'YoutubePackages'=>array(),
                  'devices'=>$devices_array,
                  'server_location'=>$location_array        
                );

          $main=array_merge($main_array,$settings_array);
          array_push($products_array, $main);
        }

        $this->response($products_array,REST_Controller::HTTP_OK); 
      }else{
        $this->response([
                'status' => FALSE,
                'message' => 'No Product was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }

    // Operator settings
    public function operator(){

    }
    
    public function settings_get($section='main'){

      $this->load->model('operator_m');
      $this->load->model('contacts_m');
      
      $operator_details=$this->operator_m->get_by(array('id'=>1),TRUE);   
      $welcome_details=$this->contacts_m->get_by(array('name'=>'welcome'),TRUE);
      $main_details=$this->contacts_m->get_by(array('name'=>'main'),TRUE);

      if($section=='main'){
        // build Main json
        $result =  array(
                'client' => $operator_details->operator_name,
                'brandname' => $operator_details->operator_brand,
                'supportinfo'=>$operator_details->operator_support_email,
                'contact'   =>  array(
                          'qrcode' => $main_details->qrcode,
                          'text' => $main_details->qrcode,
                          'logo' => $main_details->logo,
                          'background' => $main_details->background,
                          'selection_color' => $main_details->selection_color,
                        ),
                'cms' => $operator_details->operator_crm,
                'crm' => $operator_details->operator_name,
                'account'   =>  array(
                          'user_register' => ($operator_details->operator_use_register==1) ? "true" : "false",
                          'use_trial' => ($operator_details->operator_use_trial==1) ? "true" : "false",
                          'use_renew_by_key' => ($operator_details->operator_use_renew_by_key==1) ? "true" : "false",
                          'product_trial_id' => $operator_details->operator_product_trial_id,
                          'disclaimer' => $operator_details->operator_disclaimer,
                          'is_show_disclaimer' => ($operator_details->operator_is_show_disclaimer==1) ? "true" : "false"
                        ),
                'sleepmode' => $operator_details->operator_sleepmode,
                'default_language' => ucwords($operator_details->operator_default_language),
                'languages' =>  array(
                          'language' => 'English',
                          'language' => 'Hindi',
                        ),
                'style'     =>  array(
                          'image_location' =>$operator_details->operator_image_location,
                          'content_api_location' =>$operator_details->operator_content_api_location,
                          'product_api_location' => $operator_details->operator_product_api_location,
                          'web_api_location' => $operator_details->operator_web_api_location,
                          'news_image_location' => $operator_details->operator_news_image_location,
                          'font' =>$operator_details->operator_font,
                          'background'=>$main_details->background,
                          'logo' =>$main_details->logo,
                          'highlight' => array(
                            'primary' =>$operator_details->operator_primary_color,
                            'secondary'=>$operator_details->operator_secondary_color
                            )
                        )
        );
        $this->response($result,REST_Controller::HTTP_OK); 
      }elseif($section=='welcome'){
        // build welcome json
        $result =   array(
              'client' =>$operator_details->operator_name,
              'cms' => $operator_details->operator_brand,
              'crm' => $operator_details->operator_crm,
              'default_language' => ucwords($operator_details->operator_default_language),
              'web_api_location' => $operator_details->operator_web_api_location,
              'contact'   =>  array(
                        'qrcode' => $welcome_details->qrcode,
                        'text' => $welcome_details->qrcode,
                        'logo' => $welcome_details->logo,
                        'background' => $welcome_details->background,
                        'selection_color' => $welcome_details->selection_color,
                      ),
              'account'   =>  array(
                        'user_register' => ($operator_details->operator_use_register==1) ? "true" : "false",
                        'use_trial' => ($operator_details->operator_use_trial==1) ? "true" : "false",
                        'use_renew_by_key' => ($operator_details->operator_use_renew_by_key==1) ? "true" : "false",
                        'product_trial_id' => $operator_details->operator_product_trial_id,
                        'disclaimer' => $operator_details->operator_disclaimer,
                        'is_show_disclaimer' => ($operator_details->operator_is_show_disclaimer==1) ? "true" : "false"
                      ),
              'style'     =>  array(
                        'product_api_location' => $operator_details->operator_product_api_location
                      ),
              'storage'   =>  $operator_details->operator_storage,
              'languages' =>  array(
                        'language' => 'English',
                        'language' => 'Hindi',
                      )
        );
        $this->response($result,REST_Controller::HTTP_OK); 
      }else{
          $this->response([
                'status' => FALSE,
                'message' => 'No Settings was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
      
    }

    // home screen settings
    public function homescreen_get($product_id=0){
      $server_time= date('Y-m-d H:i:s'); 

      // get all products 
      $this->load->model('products_m');
      $this->load->model('channels_m');
      if($product_id){
        $products=$this->products_m->get_by(array('id'=>$product_id));
      }else{
        $products=$this->products_m->get();
      }
      $prd_homescreen_data=array();
      if($products){
        foreach ($products as $product) {
          //get all TV channels associated with this product id 
          $sql="Select c.* From channel c
              JOIN package_to_channel pc on c.id=pc.channel_id
                JOIN channel_package cp on cp.id=pc.package_id
                JOIN product_to_packages pp on pp.package_id =cp.id
                WHERE c.show_on_home=1 AND c.status=1 AND pp.product_id=".$product['id']." GROUP BY c.id";
          $query=$this->db->query($sql);
          $tv_items_array=array();
          foreach ($query->result() as $tv_channel) {

            array_push($tv_items_array,array('channel_id'=>(int)$tv_channel->id,
                               'channel_image'=>$tv_channel->channel_image,
                          )
                   );
          }

          //get all movies associated with product_id
          $sql_movie ="Select m.* From movie m 
                       JOIN (select id from movie_store where parent_id in (
                        select vod_store_id from product_to_vod_stores where product_id=".$product['id'].") 
                  UNION (select vod_store_id from product_to_vod_stores where product_id=".$product['id'].") 
                  ) x on m.store_id=x.id WHERE m.show_on_home=1 AND m.status=1";       
          $query_movie=$this->db->query($sql_movie);
        
          $movies=array();
          foreach ($query_movie->result() as $movie) {
            array_push($movies, array('id'=>(int)$movie->id,
                          'name'=>$movie->name,
                            'description'=>$movie->description,
                          'poster'=>$movie->poster,
                          'backdrop'=>$movie->backdrop  //@rob
                            )
                  );
          }
          
          //get all series associated with product_id
          $sql_series="Select s.* From series s
                 JOIN (select id from series_store where parent_id in (
                        select series_store_id from product_to_series_stores where product_id=".$product['id'].") 
                  UNION (select series_store_id from product_to_series_stores where product_id=".$product['id'].") 
                  ) x on s.store_id=x.id WHERE s.show_on_home=1 AND s.active=1";             
          $query_series=$this->db->query($sql_series);
          
          $series=array();
          foreach ($query_series->result() as $serie) {
            //get all seasons associated with series_id
            $sql_seasons="Select ss.*,l.name language_name 
                  From series_seasons ss
                  JOIN languages l on 
                  l.id=ss.language
                  WHERE ss.series_id='$serie->id'";
            $query_seasons=$this->db->query($sql_seasons);
          
            $seasons_array=array();
            foreach ($query_seasons->result() as $season) {
              //get all episodes associated with season_id
              $sql_episodes="Select sp.*,l.name language_name 
                    From series_episode sp
                    JOIN languages l on 
                    l.id=sp.language_id
                    WHERE sp.season_id='$season->id'";
              $query_episodes=$this->db->query($sql_episodes);
              $episodes_array=array();
              foreach ($query_episodes->result() as $episode) {
                $url=rtrim($this->channels_m->get_server_url_by_id($episode->server_url_id),"/");
                if($url!=NULL)
                  $url=$url."#";

                array_push($episodes_array,array('id'=>(int)$episode->id,
                                     'name'=>$episode->title,
                                       'streams'=>array('url'=>$url.$episode->url,
                                                  'language'=>$episode->language_name,
                                                  'toktype'=>$this->channels_m->get_token_code_by_id($episode->token_id)
                                                  )
                                    )
                    );
              }

              array_push($seasons_array,array(
                            'id'=>(int)$season->id,
                            'name'=>$season->name,
                              'poster'=>$season->poster,
                              'backdrop'=>$season->backdrop,
                                'childlock'=>(int)$season->childlock,
                                'length'=>(int)$season->duration,
                                'year'=>$season->year,
                                'actors'=>$season->actor,
                                'rating'=>$season->rating,
                                'language'=>$season->language_name,
                                'is_kids_friendly'=>($season->is_kids_friendly==0) ? false: true,
                                'has_preroll'=>(int)$season->preroll_enabled,
                                'has_overlaybanner'=>(int)$season->overlay_enabled,
                                'has_ticker'=>(int)$season->ticker_enabled,
                                'descriptions'=>array(array('language'=>$season->language_name,
                                           'description'=>$season->description)),
                              'episodes'=>$episodes_array,
                              'tags'=>($season->tags!="") ? explode(",",$season->tags) : array()
                          )
                  );
            }
          
            array_push($series, array(
               'id'=>(int)$serie->id,
               'name'=>$serie->name,
               'logo'=>$serie->logo,
               'childlock'=>(int)$serie->childlock,
               'position'=>(int)$serie->position,
               'season'=>$seasons_array
               )
              );        
          } //new added @rob

          //get all news items associated with product's news_group_id
          $sql_news="Select n.* From news n
                 WHERE n.news_group_id=".$product['news_group_id'];
                 
          $query_news=$this->db->query($sql_news);
          $news_array=array();
          foreach ($query_news->result() as $news) {
            array_push($news_array, array('id'=>$news->id,
                            'title'=>$news->title,
                            'image'=>$news->image,
                              'description'=>$news->description,
                                    'date'=>date('Y-m-d',$news->date_created)
                                  )
                   );
          }
          
          $main_array=array(
                'servertime'=>$server_time,
                'product_id'=>array('id'=>$product['id'],'name'=>$product['name']),
                'metrortvitems'=>$tv_items_array,
                'metromovieitems'=>$movies,
                'metroserieitems'=>$series,
                'metronewsitems'=>$news_array
          );
          array_push($prd_homescreen_data, $main_array);
        }
        $this->response($prd_homescreen_data,REST_Controller::HTTP_OK); 
      }else{
          $this->response([
                'status' => FALSE,
                'message' => 'No Homescreen Setting was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }

    // get EPG 
    public function epg_get($channel_id=0){
      // get all channels 
      $server_time= date('Y-m-d H:i:s'); //2019-07-21T15:12:01.213422+00:00
      $where="";
      if($channel_id){
        $where=" WHERE c.id=".$channel_id;
      }

      //get all TV channels
      $sql="Select c.* FROM channel c 
          JOIN epg e on 
          c.id=e.channel_id ".$where." GROUP BY c.id";
      $query=$this->db->query($sql);

      $channels_array=array();
      if($query->result()){
        foreach ($query->result() as $channel) {
          $sql_epg="Select * FROM epg WHERE channel_id='$channel->id'";
          $query_epg=$this->db->query($sql_epg);
          $epg_array=array();
          foreach ($query_epg->result() as $epg) {
            array_push($epg_array, array('epg_id'=>$epg->id,
                           't_start'=>strtotime($epg->t_start),
                           't_end'=>strtotime($epg->t_end),
                           'ut_start'=>$epg->ut_start,
                           'ut_end'=>$epg->ut_end,
                           'progname'=>$epg->name,
                          // 'progdesc'=>'No Information Available',
                           'progimg'=>$epg->progimg,
                           'is_serie'=>$epg->is_series,
                           )
                  );
          }

          array_push($channels_array,array('channel_id'=>$channel->id,
                          'channel_name'=>$channel->channel_name,
                          'channel_icon'=>'',
                          'channel_epg_offset'=>$channel->epg_offset,
                          'epgdata'=>$epg_array 
                          )
                );
        }  

        $main_array=array(
          'serverTime'=>$server_time,
          'channels'=>$channels_array
        );
        $this->response($main_array,REST_Controller::HTTP_OK); 
      }else{
          $this->response([
                'status' => FALSE,
                'message' => 'No EPG was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }

    //advertisement 

    //banners 
    public function banners_get($banner_id=0){
      
      if($banner_id){
        $this->db->where('id',$banner_id);
      }
      $this->db->where('type','banner');
      $query= $this->db->get('advertisement');
      $banners_data=array();

      if($query->result()){
        foreach ($query->result() as $ban) {
          array_push($banners_data, 
                    array('id'=>$ban->id,
                          'name'=>$ban->name,
                          'image'=>$ban->image,
                          'gui_position'=>$ban->gui_position,
                          'date_start'=>$ban->date_start,
                          'date_end'=>$ban->date_end,
                          'max_views'=>$ban->max_views,
                          'url'=>$ban->url,
                          'text'=>$ban->text,
                          'external_url'=>$ban->external_url,
                          'campaign_email'=>$ban->campaign_email,
                          'stream_url'=>$ban->stream_url,
                          'backdrop'=>$ban->backdrop,
                          'description'=>$ban->description
                    ));
        }
        $this->response($banners_data,REST_Controller::HTTP_OK); 
      }else{
          $this->response([
                'status' => FALSE,
                'message' => 'No Banner was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }
    
    //prerolls
    public function prerolls_get($preroll_id=0){
      if($preroll_id){
        $this->db->where('id',$preroll_id);
      }
      $this->db->where('type','preroll');
      $query= $this->db->get('advertisement');
      $prerolls_data=array();
      if($query->result()){
        foreach ($query->result() as $roll) {

          $this->db->select('c.*');
          $this->db->from('channel c');
          $this->db->join('advertisement_video_to_channels vc',
                          'vc.channel_id=c.id');
          $this->db->where('vc.advertisement_id',$roll->id);
          $channels= $this->db->get();
               
          $channels_data=$channels->result_array();
          

          $this->db->select('s.*');
          $this->db->from('series s');
          $this->db->join('advertisement_video_to_series vs',
                          'vs.series_id=s.id');
          $this->db->where('vs.advertisement_id',$roll->id);
          $series= $this->db->get();
               
          $series_data=$series->result_array();

          $this->db->select('m.*');
          $this->db->from('movie m');
          $this->db->join('advertisement_video_to_movies vm',
                          'vm.movie_id=m.id');
          $this->db->where('vm.advertisement_id',$roll->id);
          $movies= $this->db->get();
               
          $movies_data=$movies->result_array();

          array_push($prerolls_data, 
                      array('id'=>$roll->id,
                          'name'=>$roll->name,
                          'image'=>$roll->image,
                          'gui_position'=>$roll->gui_position,
                          'date_start'=>$roll->date_start,
                          'date_end'=>$roll->date_end,
                          'max_views'=>$roll->max_views,
                          'url'=>$roll->url,
                          'text'=>$roll->text,
                          'external_url'=>$roll->external_url,
                          'campaign_email'=>$roll->campaign_email,
                          'stream_url'=>$roll->stream_url,
                          'backdrop'=>$roll->backdrop,
                          'description'=>$roll->description,
                          'channels'=>$channels_data,
                          'series'=>$series_data,
                          'movies'=>$movies_data
                    ));
        }
        $this->response($prerolls_data,REST_Controller::HTTP_OK); 
      }else{
          $this->response([
                'status' => FALSE,
                'message' => 'No Preroll was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }

    //prerolls
    public function overlays_get($overlay_id=0){
      if($overlay_id){
        $this->db->where('id',$overlay_id);
      }
      $this->db->where('type','overlay');
      $query= $this->db->get('advertisement');
      $overlay_data=array();
      if($query->result()){
        foreach ($query->result() as $roll) {

          $this->db->select('c.*');
          $this->db->from('channel c');
          $this->db->join('advertisement_video_to_channels vc',
                          'vc.channel_id=c.id');
          $this->db->where('vc.advertisement_id',$roll->id);
          $channels= $this->db->get();
               
          $channels_data=$channels->result_array();
          

          $this->db->select('s.*');
          $this->db->from('series s');
          $this->db->join('advertisement_video_to_series vs',
                          'vs.series_id=s.id');
          $this->db->where('vs.advertisement_id',$roll->id);
          $series= $this->db->get();
               
          $series_data=$series->result_array();

          $this->db->select('m.*');
          $this->db->from('movie m');
          $this->db->join('advertisement_video_to_movies vm',
                          'vm.movie_id=m.id');
          $this->db->where('vm.advertisement_id',$roll->id);
          $movies= $this->db->get();
               
          $movies_data=$movies->result_array();

          array_push($overlay_data, 
                      array('id'=>$roll->id,
                          'name'=>$roll->name,
                          'image'=>$roll->image,
                          'gui_position'=>$roll->gui_position,
                          'date_start'=>$roll->date_start,
                          'date_end'=>$roll->date_end,
                          'max_views'=>$roll->max_views,
                          'url'=>$roll->url,
                          'text'=>$roll->text,
                          'external_url'=>$roll->external_url,
                          'campaign_email'=>$roll->campaign_email,
                          'stream_url'=>$roll->stream_url,
                          'backdrop'=>$roll->backdrop,
                          'description'=>$roll->description,
                          'channels'=>$channels_data,
                          'series'=>$series_data,
                          'movies'=>$movies_data
                    ));
        }
        $this->response($overlay_data,REST_Controller::HTTP_OK); 
      }else{
          $this->response([
                'status' => FALSE,
                'message' => 'No Overlay Video was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }

    //prerolls
    public function tickers_get($ticker_id=0){
      if($ticker_id){
        $this->db->where('id',$ticker_id);
      }
      $this->db->where('type','ticker');
      $query= $this->db->get('advertisement');
      $ticker_data=array();
      if($query->result()){
        foreach ($query->result() as $roll) {

          $this->db->select('c.*');
          $this->db->from('channel c');
          $this->db->join('advertisement_video_to_channels vc',
                          'vc.channel_id=c.id');
          $this->db->where('vc.advertisement_id',$roll->id);
          $channels= $this->db->get();
               
          $channels_data=$channels->result_array();
          

          $this->db->select('s.*');
          $this->db->from('series s');
          $this->db->join('advertisement_video_to_series vs',
                          'vs.series_id=s.id');
          $this->db->where('vs.advertisement_id',$roll->id);
          $series= $this->db->get();
               
          $series_data=$series->result_array();

          $this->db->select('m.*');
          $this->db->from('movie m');
          $this->db->join('advertisement_video_to_movies vm',
                          'vm.movie_id=m.id');
          $this->db->where('vm.advertisement_id',$roll->id);
          $movies= $this->db->get();
               
          $movies_data=$movies->result_array();

          array_push($ticker_data, 
                      array('id'=>$roll->id,
                          'name'=>$roll->name,
                          'image'=>$roll->image,
                          'gui_position'=>$roll->gui_position,
                          'date_start'=>$roll->date_start,
                          'date_end'=>$roll->date_end,
                          'max_views'=>$roll->max_views,
                          'url'=>$roll->url,
                          'text'=>$roll->text,
                          'external_url'=>$roll->external_url,
                          'campaign_email'=>$roll->campaign_email,
                          'stream_url'=>$roll->stream_url,
                          'backdrop'=>$roll->backdrop,
                          'description'=>$roll->description,
                          'channels'=>$channels_data,
                          'series'=>$series_data,
                          'movies'=>$movies_data
                    ));
        }
        $this->response($ticker_data,REST_Controller::HTTP_OK); 
      }else{
          $this->response([
                'status' => FALSE,
                'message' => 'No Ticker Video was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }

    //News 
    // get news groups
    public function news_groups_get($group_id=0){
      if($group_id){
        $this->db->where('id',$group_id);
      }      
   
      $query= $this->db->get('news_groups');
      $group_data=array();
      if($query->result()){
        foreach ($query->result() as $grp) {
            $this->db->where('news_group_id',$grp->id);
            $groups= $this->db->get('news');
            $news_data=$groups->result_array();
            array_push($group_data, 
                      array(
                        'id'=>$grp->id,
                        'name'=>$grp->name,
                        'news'=>$news_data));
        }
       $this->response($group_data,REST_Controller::HTTP_OK); 
      }else{
          $this->response([
                'status' => FALSE,
                'message' => 'No News Group was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }  

    }

    //get news 

    public function news_get($news_id=0){
      if($news_id){
        $this->db->where('id',$news_id);
      }      
   
      $query= $this->db->get('news');
      $news_data=array();

      if($query->result()){
        foreach ($query->result() as $news) {
            $this->db->where('id',$news->news_group_id);
            $groups= $this->db->get('news_groups');
            $news_group_data=$groups->row_array();
            array_push($news_data, 
                      array(
                        'id'=>$news->id,
                        'title'=>$news->title,
                        'news_group'=>$news_group_data,
                        'news_description'=>$news->description,
                        'image'=>$news->image,
                        'date_created'=>$news->date_created));
        }
       $this->response($news_data,REST_Controller::HTTP_OK); 
      }else{
          $this->response([
                'status' => FALSE,
                'message' => 'No News was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }  

    }

    //reports 

    public function analytics_get($analytic_id=0){
      if($analytic_id){
        $this->db->where('id',$analytic_id);
      }      
   
      $query= $this->db->get('analytics_report');
      $analytics=$query->result_array();

      if($analytics){
       
        $this->response($analytics,REST_Controller::HTTP_OK); 
      }else{
          $this->response([
                'status' => FALSE,
                'message' => 'No Analytics Report was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
      }  
    }

    function check_required_field_blank($required_fields,$data){
      $flag=1;
      foreach ($data as $key => $value) {
        if(in_array($key, $required_fields) && empty($value))
           $flag=0;
      }
      if($flag==1)
        return true;
      else
        return false;
    }

    function getCountry($countryname){
      $this->db->where('name',$countryname);
      $query = $this->db->get('countries');
      
      if($query->num_rows()>0)
          return $query->row();
      else
          return false;
    }
}