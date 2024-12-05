<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Epg_m extends MY_Model {

	protected $_table_name = 'epg';
	public $rules = array(
		't_start' => array(
			'field' => 't_start',
			'label' => 'Time Start',
			'rules' => ''
		),
		't_end' => array(
			'field' => 't_end',
			'label' => 'Time End',
			'rules' => ''
		),
		'ut_start' => array(
			'field' => 'ut_start',
			'label' => 'Universal Time Start',
			'rules' => ''
		),
		'ut_end' => array(
			'field' => 'ut_end',
			'label' => 'Universal Time End',
			'rules' => ''
		),
		'progname' => array(
			'field' => 'progname',
			'label' => 'Programme Title',
			'rules' => ''
		),
		'progdesc' => array(
			'field' => 'active',
			'label' => 'Programme Description',
			'rules' => ''
		),
		'progimg' => array(
			'field' => 'progimg',
			'label' => 'Programme Image',
			'rules' => ''
		),
		'description' => array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => ''
		),
		'is_serie' => array(
			'field' => 'is_serie',
			'label' => 'Is Serie',
			'rules' => ''
		)		
	);
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function updateEPG($url,$channel_id,$epg_name){
		$xmlfile = file_get_contents($url);
		$ob= (array)simplexml_load_string($xmlfile);
		$json  = json_encode($ob);
		$configData = json_decode($json, true);
		/*echo "<pre>";
		print_r($configData);
		echo "</pre>";*/
		foreach ($configData['programme'] as $epg) {
			$channel_name= $epg['@attributes']['channel'];
			if($epg_name==$channel_name){
				$channel_name = $epg['@attributes']['channel'];
				$program_name = $epg['title'];
				$start = $epg['@attributes']['start'];
				$stop = $epg['@attributes']['stop'];
				if(isset($epg['desc'])){
					$desc = $epg['desc'];
				} else{
					$desc = $epg['title'];
				}
				
				$ut_start =strtotime($start);
				$t_start= date('Y-m-d H:i:s', $ut_start);

				$ut_end =strtotime($stop);
				$t_end= date('Y-m-d H:i:s', $ut_end);

				$data = array(	
								'channel_id' => $channel_id,
								/*'name' => $program_name,*/
								'name' => $channel_name,
								'description' => $desc,
								't_start' => $t_start,
								't_end' => $t_end,
								'ut_start' => $ut_start,
								'ut_end' => $ut_end
					        );
				$this->save(NULL, $data);
			}
		}
	}
	public function updateEPGSmart($url,$channels){
		$xmlfile = file_get_contents($url);
		$ob= (array)simplexml_load_string($xmlfile);
		$json  = json_encode($ob);
		$configData = json_decode($json, true);
		/*echo "<pre>";
		print_r($configData);
		echo "</pre>";*/
		foreach($channels as $channel){
			$channel_id = $channel['id'];
			$epg_name = ($channel['channel_name']!="") ? $channel['channel_name'] : $channel['channel_epg_name'];
			$epg_offset = ($channel['epg_offset'] != '') ? $channel['epg_offset'].' minutes' : '+0 minutes';
			foreach ($configData['programme'] as $epg) {
				$channel_name= $epg['@attributes']['channel'];
				if($epg_name==$channel_name){
					$channel_name = $epg['@attributes']['channel'];
					$program_name = $epg['title'];
					$start = $epg['@attributes']['start'];
					$stop = $epg['@attributes']['stop'];
					if(isset($epg['desc'])){
						$desc = $epg['desc'];
					} else{
						$desc = $epg['title'];
					}
					
					$ut_start =strtotime($start);
					$t_start= date('Y-m-d H:i:s', $ut_start);
					$new_t_start = date("Y-m-d H:i:s",strtotime($t_start." ".$epg_offset));
					
					$ut_end =strtotime($stop);
					$t_end= date('Y-m-d H:i:s', $ut_end);
					$new_t_end = date("Y-m-d H:i:s",strtotime($t_end." ".$epg_offset));
	
					$data = array(	
									'channel_id' => $channel_id,
									/*'name' => $program_name,*/
									'name' => $channel_name,
									'description' => $desc,
									//'t_start' => $t_start,
									't_start' => $new_t_start,
									//'t_end' => $t_end,
									't_end' => $new_t_end,
									'ut_start' => $ut_start,
									'ut_end' => $ut_end
								);
					$this->save(NULL, $data);
				}
			}
		}
	}
	
	
	public function updateEPGgzip($url,$channel_id,$epg_name){
			//echo $epg_name.'<br>';
			//$url ='https://imserver.threeiptv.com/IN.xml.gz';
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
				/*echo '<pre>';
				print_r($xml->programme[0]);
				exit;*/
				foreach ($xml->programme as $value){ 
					$value_array = (array)$value;
					$channel_name= $value_array['@attributes']['channel'];
					//echo $epg_name.'--------'.$channel_name.'<br>';
					if($epg_name==$channel_name){
						//	$channel_name = $epg['@attributes']['channel'];
							$program_name = $value_array['title'];
							$start = $value_array['@attributes']['start'];
							$stop = $value_array['@attributes']['stop'];
			
							if(isset($value_array['desc'])){
								$desc = $value_array['desc'];
							} else{
								$desc = $value_array['title'];
							}
				
							$ut_start =strtotime($start);
							$t_start= date('Y-m-d H:i:s', $ut_start);
			
							$ut_end =strtotime($stop);
							$t_end= date('Y-m-d H:i:s', $ut_end);
			
							$data = array(	
											'channel_id' => $channel_id,
											'name' => $program_name,
											'description' => $desc,
											't_start' => $t_start,
											't_end' => $t_end,
											'ut_start' => $ut_start,
											'ut_end' => $ut_end
										);
							$this->save(NULL, $data);
						}
				}
				
	}
	public function updateEPGgzipSmart($url,$channels){
			
			//echo $epg_name.'<br>';
			//$url ='https://imserver.threeiptv.com/IN.xml.gz';
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
				/*echo '<pre>';
				print_r($channels);
				print_r($xml->programme[0]);
				exit;*/
				foreach($channels as $channel){ 
					$channel_id = $channel['id'];
					$epg_name = $channel['channel_epg_id'];
					//$epg_offset = $channel['epg_offset'].' minutes';
					$epg_offset = ($channel['epg_offset'] != '') ? $channel['epg_offset'].' minutes' : '+0 minutes';
							if($epg_name != ''){
								foreach ($xml->programme as $value){ 
										$value_array = (array)$value;
										$channel_name= $value_array['@attributes']['channel'];
										//echo $epg_name.'--------'.$channel_name.'<br>';
										if($epg_name==$channel_name){
											//	$channel_name = $epg['@attributes']['channel'];
												$program_name = $value_array['title'];
												$start = $value_array['@attributes']['start'];
												$stop = $value_array['@attributes']['stop'];
								
												if(isset($value_array['desc'])){
													$desc = $value_array['desc'];
												} else{
													$desc = $value_array['title'];
												}
									
												$ut_start =strtotime($start);
												$t_start= date('Y-m-d H:i:s', $ut_start);
												$new_t_start = date("Y-m-d H:i:s",strtotime($t_start." ".$epg_offset));
								
												$ut_end =strtotime($stop);
												$t_end= date('Y-m-d H:i:s', $ut_end);
												$new_t_end = date("Y-m-d H:i:s",strtotime($t_end." ".$epg_offset));
								
												$data = array(	
																'channel_id' => $channel_id,
																'name' => $program_name,
																'description' => $desc,
																//'t_start' => $t_start,
																't_start' => $new_t_start,
																//'t_end' => $t_end,
																't_end' => $new_t_end,
																'ut_start' => $ut_start,
																'ut_end' => $ut_end
															);
												$this->save(NULL, $data);
											}
									}
							}
				}
				
				
	}
	
}

/* End of file Epg_m.php */
/* Location: ./application/models/Epg_m.php */