<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(5);
        $this->load->model('settings_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Settings');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "settings";
        
        /* Breadcrumbs :: Common */
       // $this->breadcrumbs->unshift(1, 'Settings', 'settings');
    }


	public function index(){
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'settings/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'settings/edit';
        $this->data['page_title'] = "Settings";
		 /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Settings', 'settings');
	   
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['apis']= $this->settings_m->get_settings_by_type('1');
        $this->data['brands']= $this->settings_m->get_settings_by_type('8');
        $this->data['epgs']= $this->settings_m->get_settings_by_type('2');
        $this->data['aes_encrypt_key']= $this->settings_m->get_settings_by_type('6');
        $this->data['customers']= $this->settings_m->get_settings_by_type('3');

        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }
	public function epgCron(){
		$this->data['_view'] = DEFAULT_THEME . 'epgs/epgcron';
        $this->data['page_title'] = "EPG Cron";
		$this->data['sub_nav'] = "epgcron";		
        /* Breadcrumbs */
		//$this->breadcrumbs->unshift(1, 'EPG', 'settings/epgcron');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
       	$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	public function runCron(){
		$this->updateEPGData();
        $this->EPGpackage();
        $this->createJsonCatchupEPG('8');
        $this->createJsonEPG('8');
		
		$this->session->set_flashdata('success',"Edited Successfully.");			
		redirect(BASE_URL.'settings/epgCron');	
	}
	public function epg()
	{
		$this->load->model('epgs_m');
		if($this->input->post('submit')){
			
			$epg_url = $_POST['epg_url'];
			$epg_name = $_POST['epg_name'];
			$epg_offset = $_POST['epg_offset'];
			$epg_status = $_POST['epg_status'];
			$epg_offset_date = $_POST['epg_offset_date'];
			$url_type = $_POST['url_type'];
			
			$formdata = array('name'=>$epg_name, 
								'url'=>$epg_url,
									'epg_offset' => $epg_offset, 
										'epg_status' => $epg_status,
											'epg_offset_date' => $epg_offset_date,
											'url_type' => $url_type);
			$insert_id=$this->epgs_m->save(NULL,$formdata);	
			if($insert_id == 'Already Exist!'){
				$this->session->set_flashdata('failure',"EPG nameAlready Exist!");			
			}else{
				$this->session->set_flashdata('success',"Add Successfully.");
			}	
				redirect(BASE_URL.'settings/epg');		
		}
        //check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'epgs/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'epgs/index';
        $this->data['page_title'] = "Electronic Programme Guide (EPG)";
		$this->data['sub_nav'] = "epg";
		
        /* Breadcrumbs */
		$this->breadcrumbs->unshift(1, 'EPG', 'settings/epg');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
       	$this->data['epgs'] = $this->epgs_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }
	
	public function epgedit($id = NULL){
		$this->load->model('epgs_m');
		if($this->input->post('submit')){			
			$epg_url = $_POST['epg_url'];
			$epg_name = $_POST['epg_name'];
			$epg_offset = $_POST['epg_offset'];
			$epg_status = $_POST['epg_status'];
			$epg_offset_date = $_POST['epg_offset_date'];
			$url_type = $_POST['url_type'];
			
			$formdata = array('name'=>$epg_name, 
								'url'=>$epg_url, 
									'epg_offset' => $epg_offset, 
										'epg_status' => $epg_status,
											'epg_offset_date' => $epg_offset_date,
											'url_type' => $url_type);
			$insert_id=$this->epgs_m->save($id,$formdata);
			$this->session->set_flashdata('success',"Edited Successfully.");	
			redirect(BASE_URL.'settings/epg');		
		}
		//check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'settings/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'epgs/edit';
        $this->data['page_title'] = "Electronic Programme Guide (EPG)";
		$this->data['sub_nav'] = "epg";
		
        /* Breadcrumbs */
		$this->breadcrumbs->unshift(1, 'EPG', 'settings/epg');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
       	$this->data['info'] = $this->epgs_m->get($id,TRUE);
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	public function epgdelete($id = NULL){
		$this->load->model('epgs_m');
		$this->epgs_m->delete($id);
        // $this->movies_m->delete_channels_groups($id);       
        $this->session->set_flashdata('success',"EPG Deleted Successfully.");
        redirect(BASE_URL.'settings/epg');	
	}
	
	/*public function epgimport($id = NULL){
		$this->breadcrumbs->unshift(1, 'EPG', 'settings/epg');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
		$this->data['_view'] = DEFAULT_THEME . 'epgs/import';
		$this->data['page_title'] = "Electronic Programme Guide (EPG)";
		$this->data['sub_nav'] = "epg";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}*/
	

function simpleXmlToArray($xmlObject)
    {
        $array = [];
        foreach ($xmlObject->children() as $node) {
            // check if there are children
            if($node->count() > 0) {
                $array[$node->getName()] = simpleXmlToArray($node);
                continue;
            }

            $array[$node->getName()] = is_array($node) ? simplexml_to_array($node) : (string) $node;
        }

        return $array;
}
		
	public function epgimport($id = NULL){
			$this->load->model('epgs_m');
			$this->load->model('epgs_chanels_m');
			
			$info  = $this->epgs_m->get($id,TRUE);
			//echo '<pre>';
			
			$url = $info->url;
			$url_type = $info->url_type;
			//echo $url_type;exit;
			//$haystack = 'How are you?';
			$needle   = '.xml.gz';
			
			if (strpos($url, '.xml.gz') !== false) {
			
				$ch = curl_init();
				curl_setopt_array($ch, array(
				CURLOPT_URL => $url
				, CURLOPT_HEADER => 0
				, CURLOPT_RETURNTRANSFER => 1
				, CURLOPT_ENCODING => 'gzip'
				));  
				
				 $compressed = curl_exec($ch);
				curl_close($ch);
				//$chanel_array = array();
				$uncompressed = gzdecode($compressed);
				// now you can use string as xml
				$xml = simplexml_load_string($uncompressed);
				
				//$chanel_array = array();
				//echo $this->epgs_chanels_m->deletemultiplerow($id);exit;
				if($this->epgs_chanels_m->deletemultiplerow($id) > 0){
					//echo '<pre>';
					foreach ($xml->channel as $value){
					//print_r((array)$value);
					 $value_array = (array)$value;
					 $value_icon = (array)$value_array['icon'];
					 //print_r($value_icon);
					 $chanel_array = array('epgs_id' => $id,
												'chanel_name' => str_replace("'","",$value_array['display-name']),
													'clanel_id' => $value_array['@attributes']['id'],
														'icon' => str_replace("'","",$value_icon['@attributes']['src']),
														'url_type' => $url_type);
						
						$this->epgs_chanels_m->save(NULL,$chanel_array);
					}
					//exit;
					$this->session->set_flashdata('success',"EPG Import Successfully.");	
					redirect(BASE_URL.'settings/epg');	
				}
				
								
			} elseif (strpos($url, '.xml') !== false) {				
				$xmlfile = file_get_contents($url);
				$ob= (array)simplexml_load_string($xmlfile);
				$json  = json_encode($ob);
				$configData = json_decode($json, true);
				if($this->epgs_chanels_m->deletemultiplerow($id) > 0){	
				//echo '<pre>';	
					foreach ($configData['channel'] as $epg) {
							$chanel_array = array('epgs_id' => $id,
															'chanel_name' => $epg['display-name'],
																'clanel_id' => $epg['@attributes']['id'],
																	'icon' => $epg['url'],
																	'url_type' => $url_type);
									
							$this->epgs_chanels_m->save(NULL,$chanel_array);
						//print_r($chanel_array);
					}
					
					$this->session->set_flashdata('success',"EPG Import Successfully.");	
					redirect(BASE_URL.'settings/epg');
				}
					
			}

	}

	//8637586906
    public function update(){
        check_allow('edit',$this->data['is_allow']);
        $id=$this->input->post('id');
        $data=array('value'=>$this->input->post('value'));
        $this->settings_m->save($id,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('settings').'" target="_blank">System Settings Updated</a>');   
        echo "Updated Successfully";
    }


    public function updateToken(){ 
        check_allow('edit',$this->data['is_allow']);
        $id=$this->input->post('id');
        $data=array('key'=>$this->input->post('value'));
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('token');
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('settings').'" target="_blank">System Settings Token Updated</a>');   
        echo "Updated Successfully";
    }
}
