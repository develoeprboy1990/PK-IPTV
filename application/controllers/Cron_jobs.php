<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron_jobs extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function updateEPGData(){ 
		$this->load->model('channels_m');
		$channels = $this->channels_m->get();
		$this->load->model('epg_m');				     
		$this->load->model('epgs_m');
		$epgs_info = $this->epgs_m->get();
		
		 $sql = "TRUNCATE  epg";
		$query=$this->db->query($sql);
						
		foreach($epgs_info as $key=>$val){	
			if($val['epg_status'] == '1'){
				$url = $val['url'];
				$id = $val['id'];
				
				if (strpos($url, '.xml.gz') !== false) { 
					
						$this->epg_m->updateEPGgzipSmart($url,$channels);
						
				}elseif (strpos($url, '.xml') !== false) {	
						$days= $val['epg_offset_date'];
						// get 7 days earlier date . days set in the settings
						$timestamp= $days*24*60*60;
						$earlier_date = (time()-$timestamp);
						$earlier_date =date('Y-m-d',$earlier_date);
						
						
					
						$this->epg_m->updateEPGSmart($url,$channels);
						
				}
			}
		}
		$this->createJsonEPG(8);
    }
	
	function processDescription($text, $maxLength = 45)
	{
		$maxLength = 45;
		// Remove slashes
		$text = stripslashes($text);
		// Remove HTML and PHP tags
		$text = strip_tags($text);
		// Trim whitespace
		$text = trim($text);
		// Limit length
		if (mb_strlen($text, 'UTF-8') > $maxLength) {
			$text = mb_substr($text, 0, $maxLength, 'UTF-8') . '...';
		}
		return $text !== '' ? $text : "No info";
	}

			/*
    		1.	Multiple Files Creation:
    				The function will create multiple EPG files based on DAYS_TO_CREATE_EPG_FILES_FROM_TODAY.
    				Each file will cover 12 hours of the previous day, 24 hours of the current day, and 12 hours of the next day.
			2.	EPG Data Inclusion and Adjustment:
   			 		Programs that start before the time frame but end within it will be included, with adjusted start times.
   			 		Programs that start within the time frame but end after it will also be included, with adjusted end times.
			3.	Handling Empty EPG Data:
	    			If EPG data is empty, you can choose to set 'epgdata' => [] or fill it with No info” entries.
			*/


	public function createJsonEPG($id)
	{
		// === Option Settings ===
		// Set the desired option:
		// Option 1: Set 'epgdata' => [] when EPG data is empty.
		// Option 2: Fill with "No info" entries when EPG data is empty.
		$option = 1; // Change this to 1 for Option 1, or 2 for Option 2.

		// Set Interval Hours for Option 2:
		$intervalHours = 6; // Interval in hours for "No info" entries in Option 2.
		// === End of Option Settings ===

		$this->load->model('products_m');
		$products = $this->products_m->get();

		foreach ($products as $product) {
			$sql = "SELECT c.*, l.name as language_name FROM channel c
                JOIN package_to_channel ptc ON ptc.channel_id = c.id
                JOIN channel_package cp ON cp.id = ptc.package_id
                LEFT JOIN languages l ON l.id = c.language_id
                WHERE cp.id IN (
                    SELECT cp.id FROM channel_package cp
                    JOIN (
                        SELECT DISTINCT product_id, package_id FROM product_to_packages
                    ) pp ON pp.package_id = cp.id
                    WHERE pp.product_id = " . $product['id'] . "
                ) AND c.status = 1";
			$query = $this->db->query($sql);
			$checkChannel = array();

			foreach ($query->result() as $channel) {
				$sql_epg = "SELECT e.*, c.id as ch_id, l.name as language_name FROM channel c
                        LEFT JOIN languages l ON l.id = c.language_id
                        LEFT JOIN epg e ON c.id = e.channel_id
                        WHERE c.id = '$channel->id'";
				$query_epg = $this->db->query($sql_epg);
				$epg_data = $query_epg->result();

				// Loop over days
				for ($i = 0; $i < DAYS_TO_CREATE_EPG_FILES_FROM_TODAY; $i++) {
					$toDay = date('Y-m-d', strtotime("+" . $i . " days"));
					$dayStart = strtotime($toDay . ' 00:00:00') - 12 * 3600; // 12 hours before
					$dayEnd = strtotime($toDay . ' 23:59:59') + 12 * 3600;   // 12 hours after

					$epg_array = array();

					// If EPG data exists
					if (!empty($epg_data)) {
						foreach ($epg_data as $epg) {
							$epgStart = strtotime($epg->t_start);
							$epgEnd = strtotime($epg->t_end);
							$description = $this->processDescription($epg->description, 80);

							// Check if EPG event overlaps with the time frame
							if ($epgEnd > $dayStart && $epgStart < $dayEnd) {
								// Adjust start and end times
								$eventStart = max($epgStart, $dayStart);
								$eventEnd = min($epgEnd, $dayEnd);

								$epg_array[] = array(
									'id' => (int)$epg->id,
									's' => $eventStart,
									'e' => $eventEnd,
									'n' => $epg->name,
									'd' => $description,
									'i' => null
								);
							}
						}
					}

					// Initialize $filled_epg_array
					$filled_epg_array = array();

					// Handle empty EPG data
					if (empty($epg_array)) {
						if ($option == 1) {
							// Option 1: Set 'epgdata' => []
							$filled_epg_array = array();
						} elseif ($option == 2) {
							// Option 2: Fill with "No info" entries
							$intervalCount = ceil(($dayEnd - $dayStart) / (3600 * $intervalHours));
							for ($a = 0; $a < $intervalCount; $a++) {
								$noInfoStart = $dayStart + ($a * $intervalHours * 3600);
								$noInfoEnd = $noInfoStart + ($intervalHours * 3600);
								if ($noInfoEnd > $dayEnd) {
									$noInfoEnd = $dayEnd;
								}

								$epg_array[] = array(
									'id' => -1,
									's' => $noInfoStart,
									'e' => $noInfoEnd,
									'n' => "No info",
									'd' => "No info",
									'i' => null
								);
							}
							// Proceed to fill gaps with the "No info" entries
						}
					}

					// If there is EPG data or Option 2 is selected, proceed to fill gaps
					if (!empty($epg_array)) {
						// Sort and fill gaps
						usort($epg_array, function ($a, $b) {
							return $a['s'] - $b['s'];
						});

						$lastEndTime = $dayStart;

						foreach ($epg_array as $event) {
							if ($event['s'] > $lastEndTime) {
								// There is a gap; fill it with "No info"
								$filled_epg_array[] = array(
									'id' => -1,
									's' => $lastEndTime,
									'e' => $event['s'],
									'n' => "No info",
									'd' => "No info",
									'i' => null
								);
							}
							// Add the event
							$filled_epg_array[] = $event;
							$lastEndTime = $event['e'];
						}

						// Fill any remaining time after the last event
						if ($lastEndTime < $dayEnd) {
							$filled_epg_array[] = array(
								'id' => -1,
								's' => $lastEndTime,
								'e' => $dayEnd,
								'n' => "No info",
								'd' => "No info",
								'i' => null
							);
						}
					}

					if (!in_array($channel->channel_name, $checkChannel)) {
						array_push($checkChannel, $channel->channel_name);
					}

					// Prepare the channels array for this day
					$channels_array['channel_array_' . $i][] = array(
						'id' => (int)$channel->id,
						'number' => (int)$channel->channel_number,
						'language_id' => (int)$channel->language_id,
						'language' => $channel->language_name,
						'name' => $channel->channel_name,
						'icon' => $channel->channel_image,
						'is_dveo' => ($channel->is_dveo == 1),
						'is_flussonic' => ($channel->is_flussonic == 1),
						'epgdata' => $filled_epg_array
					);
				} // End of channels loop

				// Create JSON EPG files for each day
				for ($i = 0; $i < DAYS_TO_CREATE_EPG_FILES_FROM_TODAY; $i++) {
					$date = date('d_m_Y', strtotime("+" . $i . " days"));
					$this->creareJsonEPGtime(
						$date,
						$product['id'],
						$id,
						$channels_array['channel_array_' . $i],
						'_product_epg_v4'
					);
				}
			} // End of products loop

		}
	}


	public function EPGpackage()
	{
		// === Option Settings ===
		// Set the desired option:
		// Option 1: Set 'epgdata' => [] when EPG data is empty.
		// Option 2: Fill with "No info" entries when EPG data is empty.
		$option = 1; // Change this to 1 for Option 1, or 2 for Option 2.

		// Set Interval Hours for Option 2:
		$intervalHours = 6; // Interval in hours for "No info" entries in Option 2.
		// === End of Option Settings ===

		$sql = "SELECT * FROM channel_package";
		$query = $this->db->query($sql);
		foreach ($query->result() as $channel_package) {
			$sql_1 = "SELECT c.*, pc.package_id, pc.channel_id,l.name as language_name
			FROM package_to_channel as pc 
			join channel as c on pc.channel_id = c.id
			LEFT JOIN languages l on l.id=c.language_id
			where package_id='" . $channel_package->id . "'";

			$query = $this->db->query($sql_1);
			$checkChannel = array();

			foreach ($query->result() as $channel) {
				$sql_epg = "SELECT e.*, c.id as ch_id, l.name as language_name FROM channel c
                        LEFT JOIN languages l ON l.id = c.language_id
                        LEFT JOIN epg e ON c.id = e.channel_id
                        WHERE c.id = '$channel->id'";
				$query_epg = $this->db->query($sql_epg);
				$epg_data = $query_epg->result();

				// Loop over days
				for ($i = 0; $i < DAYS_TO_CREATE_EPG_FILES_FROM_TODAY; $i++) {
					$toDay = date('Y-m-d', strtotime("+" . $i . " days"));
					$dayStart = strtotime($toDay . ' 00:00:00') - 12 * 3600; // 12 hours before
					$dayEnd = strtotime($toDay . ' 23:59:59') + 12 * 3600;   // 12 hours after

					$epg_array = array();

					// If EPG data exists
					if (!empty($epg_data)) {
						foreach ($epg_data as $epg) {
							$epgStart = strtotime($epg->t_start);
							$epgEnd = strtotime($epg->t_end);
							$description = $this->processDescription($epg->description, 80);

							// Check if EPG event overlaps with the time frame
							if ($epgEnd > $dayStart && $epgStart < $dayEnd) {
								// Adjust start and end times
								$eventStart = max($epgStart, $dayStart);
								$eventEnd = min($epgEnd, $dayEnd);

								$epg_array[] = array(
									'id' => (int)$epg->id,
									's' => $eventStart,
									'e' => $eventEnd,
									'n' => $epg->name,
									'd' => $description,
									'i' => null
								);
							}
						}
					}

					// Initialize $filled_epg_array
					$filled_epg_array = array();

					// Handle empty EPG data
					if (empty($epg_array)) {
						if ($option == 1) {
							// Option 1: Set 'epgdata' => []
							$filled_epg_array = array();
						} elseif ($option == 2) {
							// Option 2: Fill with "No info" entries
							$intervalCount = ceil(($dayEnd - $dayStart) / (3600 * $intervalHours));
							for ($a = 0; $a < $intervalCount; $a++) {
								$noInfoStart = $dayStart + ($a * $intervalHours * 3600);
								$noInfoEnd = $noInfoStart + ($intervalHours * 3600);
								if ($noInfoEnd > $dayEnd) {
									$noInfoEnd = $dayEnd;
								}

								$epg_array[] = array(
									'id' => -1,
									's' => $noInfoStart,
									'e' => $noInfoEnd,
									'n' => "No info",
									'd' => "No info",
									'i' => null
								);
							}
							// Proceed to fill gaps with the "No info" entries
						}
					}

					// If there is EPG data or Option 2 is selected, proceed to fill gaps
					if (!empty($epg_array)) {
						// Sort and fill gaps
						usort($epg_array, function ($a, $b) {
							return $a['s'] - $b['s'];
						});

						$lastEndTime = $dayStart;

						foreach ($epg_array as $event) {
							if ($event['s'] > $lastEndTime) {
								// There is a gap; fill it with "No info"
								$filled_epg_array[] = array(
									'id' => -1,
									's' => $lastEndTime,
									'e' => $event['s'],
									'n' => "No info",
									'd' => "No info",
									'i' => null
								);
							}
							// Add the event
							$filled_epg_array[] = $event;
							$lastEndTime = $event['e'];
						}

						// Fill any remaining time after the last event
						if ($lastEndTime < $dayEnd) {
							$filled_epg_array[] = array(
								'id' => -1,
								's' => $lastEndTime,
								'e' => $dayEnd,
								'n' => "No info",
								'd' => "No info",
								'i' => null
							);
						}
					}

					if (!in_array($channel->channel_name, $checkChannel)) {
						array_push($checkChannel, $channel->channel_name);
					}

					// Prepare the channels array for this day
					$channels_array['channel_array_' . $i][] = array(
						'id' => (int)$channel->id,
						'number' => (int)$channel->channel_number,
						'language_id' => (int)$channel->language_id,
						'language' => $channel->language_name,
						'name' => $channel->channel_name,
						'icon' => $channel->channel_image,
						'is_dveo' => ($channel->is_dveo == 1),
						'is_flussonic' => ($channel->is_flussonic == 1),
						'epgdata' => $filled_epg_array
					);
				} // End of channels loop

				// Create JSON EPG files for each day
				for ($i = 0; $i < DAYS_TO_CREATE_EPG_FILES_FROM_TODAY; $i++) {
					$date = date('d_m_Y', strtotime("+" . $i . " days"));
					$this->creareJsonEpgPackagetime(
						$date,
						$channel_package->id,

						$channels_array['channel_array_' . $i],
						'_package_epg_v4'
					);
				}
			} // End of products loop

		}
	}

	public function createJsonCatchupEPG($id)
	{
		// === Option Settings ===
		// Set the desired option:
		// Option 1: Set 'epgdata' => [] when EPG data is empty.
		// Option 2: Fill with "No info" entries when EPG data is empty.
		$option = 2; // Change this to 1 for Option 1, or 2 for Option 2.

		// Set Interval Hours for Option 2:
		$intervalHours = 3; // Interval in hours for "No info" entries in Option 2.
		// === End of Option Settings ===

		$this->load->model('products_m');
		$products = $this->products_m->get();

		foreach ($products as $product) {
			$sql = "SELECT c.*, l.name as language_name FROM channel c
                JOIN package_to_channel ptc ON ptc.channel_id = c.id
                JOIN channel_package cp ON cp.id = ptc.package_id
                LEFT JOIN languages l ON l.id = c.language_id
                WHERE cp.id IN (
                    SELECT cp.id FROM channel_package cp
                    JOIN (
                        SELECT DISTINCT product_id, package_id FROM product_to_packages
                    ) pp ON pp.package_id = cp.id
                    WHERE pp.product_id = " . $product['id'] . "
                ) AND c.status = 1";
			$query = $this->db->query($sql);
			$checkChannel = array();

			// Initialize channels array
			$channels_array = array();

			foreach ($query->result() as $channel) {
				// Only proceed if the channel supports catch-up (is_flussonic == 1)
				if ($channel->is_flussonic == 1) {

					$sql_epg = "SELECT e.*, c.id as ch_id, l.name as language_name FROM channel c
                            LEFT JOIN languages l ON l.id = c.language_id
                            LEFT JOIN epg e ON c.id = e.channel_id
                            WHERE c.id = '$channel->id'";
					$query_epg = $this->db->query($sql_epg);
					$epg_data = $query_epg->result();

					// Loop over days
					for ($i = 0; $i < DAYS_TO_CREATE_EPG_FILES_FROM_TODAY; $i++) {
						$toDay = date('Y-m-d', strtotime("+" . $i . " days"));
						$dayStart = strtotime($toDay . ' 00:00:00') - 12 * 3600; // 12 hours before
						$dayEnd = strtotime($toDay . ' 23:59:59') + 12 * 3600;   // 12 hours after

						$epg_array = array();

						// If EPG data exists
						if (!empty($epg_data)) {
							foreach ($epg_data as $epg) {
								$epgStart = strtotime($epg->t_start);
								$epgEnd = strtotime($epg->t_end);
								$description = $this->processDescription($epg->description, 80);

								// Check if EPG event overlaps with the time frame
								if ($epgEnd > $dayStart && $epgStart < $dayEnd) {
									// Adjust start and end times
									$eventStart = max($epgStart, $dayStart);
									$eventEnd = min($epgEnd, $dayEnd);

									$epg_array[] = array(
										'id' => (int)$epg->id,
										's' => $eventStart,
										'e' => $eventEnd,
										'n' => $epg->name,
										'd' => $description,
										'i' => null,
										'cid' => (int)$channel->id
									);
								}
							}
						}

						// Initialize $filled_epg_array
						$filled_epg_array = array();

						// Handle empty EPG data
						if (empty($epg_array)) {
							if ($option == 1) {
								// Option 1: Set 'epgdata' => []
								$filled_epg_array = array();
							} elseif ($option == 2) {
								// Option 2: Fill with "No info" entries
								$intervalCount = ceil(($dayEnd - $dayStart) / (3600 * $intervalHours));
								for ($a = 0; $a < $intervalCount; $a++) {
									$noInfoStart = $dayStart + ($a * $intervalHours * 3600);
									$noInfoEnd = $noInfoStart + ($intervalHours * 3600);
									if ($noInfoEnd > $dayEnd) {
										$noInfoEnd = $dayEnd;
									}

									$epg_array[] = array(
										'id' => -1,
										's' => $noInfoStart,
										'e' => $noInfoEnd,
										'n' => "No info",
										'd' => "No info",
										'i' => null,
										'cid' => (int)$channel->id
									);
								}
								// Proceed to fill gaps with the "No info" entries
							}
						}

						// If there is EPG data or Option 2 is selected, proceed to fill gaps
						if (!empty($epg_array)) {
							// Sort and fill gaps
							usort($epg_array, function ($a, $b) {
								return $a['s'] - $b['s'];
							});

							$lastEndTime = $dayStart;

							foreach ($epg_array as $event) {
								if ($event['s'] > $lastEndTime) {
									// There is a gap; fill it with "No info"
									$filled_epg_array[] = array(
										'id' => -1,
										's' => $lastEndTime,
										'e' => $event['s'],
										'n' => "No info",
										'd' => "No info",
										'i' => null,
										'cid' => (int)$channel->id
									);
								}
								// Add the event
								$filled_epg_array[] = $event;
								$lastEndTime = $event['e'];
							}

							// Fill any remaining time after the last event
							if ($lastEndTime < $dayEnd) {
								$filled_epg_array[] = array(
									'id' => -1,
									's' => $lastEndTime,
									'e' => $dayEnd,
									'n' => "No info",
									'd' => "No info",
									'i' => null,
									'cid' => (int)$channel->id
								);
							}
						} else {
							// If Option 1 is selected and there is no EPG data, $filled_epg_array is already set to empty
							// If Option 2 is selected, $filled_epg_array will be populated with "No info" entries
						}

						// Prepare the channels array for this day
						$channels_array['channel_array_' . $i][] = array(
							'id' => (int)$channel->id,
							'number' => (int)$channel->channel_number,
							'language_id' => (int)$channel->language_id,
							'language' => $channel->language_name,
							'name' => $channel->channel_name,
							'icon' => $channel->channel_image,
							'is_dveo' => ($channel->is_dveo == 1),
							'is_flussonic' => ($channel->is_flussonic == 1),
							'epgdata' => $filled_epg_array
						);
					} // End of days loop

					if (!in_array($channel->channel_name, $checkChannel)) {
						array_push($checkChannel, $channel->channel_name);
					}
				} // End of is_flussonic check
			} // End of channels loop

			// Create JSON EPG files for each day
			for ($i = 0; $i < DAYS_TO_CREATE_EPG_FILES_FROM_TODAY; $i++) {
				$date = date('d_m_Y', strtotime("+" . $i . " days"));
				// Ensure that the channels array for the day exists
				if (isset($channels_array['channel_array_' . $i])) {
					$this->creareJsonEPGtime(
						$date,
						$product['id'],
						$id,
						$channels_array['channel_array_' . $i],
						'_product_catchup'
					);
				}
			}
		} // End of products loop
	}

	public function creareJsonEPGtime($todaydate, $product_id, $id, $channels_array, $json_text)
	{
		$server_time = date('Y-m-d H:i:s');
		$main_array = array(
			'ServerTime' => $server_time,
			'channels' => $channels_array
		);

		$today = $todaydate;
		$filename = $today . '_' . $product_id . $json_text . '.json';

		$localFilePath = LOCAL_PATH_CRM . $filename;

		///Encryption 
		$final_json_output = json_encode($main_array,  JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES);

		if (ENCRYPT_JSON == 1)
			$final['CID'] = encrypt($final_json_output, 2);
		else
			$final = $main_array;

		$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);

		$fp = fopen($localFilePath, 'w');
		fwrite($fp, $return_array);
		fclose($fp);


		$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'crm');

		$this->load->model('publish_m');
		// insert into tables
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save($id, $data);
	}

	public function createJsonUpdate($item)
	{
		$sql = "Select * FROM products";
		$query = $this->db->query($sql);

		foreach ($query->result() as $product) {
			$main_array = array(
				'app' => $item == 'app' ? true : false,
				'channel' => $item == 'channel' ? true : false,
				'movie' => $item == 'movie' ? true : false,
				'serie' => $item == 'serie' ? true : false,
				'album' => $item == 'album' ? true : false,
				'time' => time()
			);
			$filename = $product->id . '_update.json';
			$localFilePath = LOCAL_PATH_CRM . $filename;

			if (ENCRYPT_JSON == 1)
				$final['CID'] = encrypt($final_json_output, 2);
			else
				$final = $main_array;

			$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);

			$fp = fopen($localFilePath, 'w');
			fwrite($fp, $return_array);
			fclose($fp);
			$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'crm');
		}
	}

	public function createJsonProductCatchup($todaydate, $product_id, $channels_array, $json_text)
	{
		$server_time = date('Y-m-d H:i:s');
		$main_array = array(
			'ServerTime' => $server_time,
			'channels' => $channels_array
		);

		//$today = date('d_m_Y');
		$filename = $todaydate . '_' . $product_id . $json_text;
		$localFilePath = LOCAL_PATH_CRM . $filename;

		/* Encryption */
		$final_json_output = json_encode($main_array,  JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES);

		if (ENCRYPT_JSON == 1)
			$final['CID'] = encrypt($final_json_output, 2);
		else
			$final = $main_array;

		$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);

		$fp = fopen($localFilePath, 'w');
		fwrite($fp, $return_array);
		fclose($fp);

		$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'crm');
	}

	public function resyncCloudServer()
	{
		//shell_exec(ACTIVE_RSYNC_BASH_SCRIPT);
		$output = shell_exec('pgrep -x "rsync" > /dev/null');
		if (is_null($output)) {
			shell_exec(sprintf('%s > /dev/null 2>&1 &', ACTIVE_RSYNC_SETTINGS));
		}
	}

	public function uploadToCdnServer($filename, $localFilePath, $imagesOrJsonsOrCustomers, $CrmOrCms, $user_id = '', $pincode = '', $final_json_output = '')
	{

		if ($CrmOrCms == 'crm') {
			$CrmOrCms = '/' . CRM;
		} elseif ($CrmOrCms == 'cms') {
			$CrmOrCms = '/' . CMS;
		} else {
			$CrmOrCms == '';
		}
		if (ACTIVE_RSYNC) {
			$this->resyncCloudServer();
		} else {
			if ($imagesOrJsonsOrCustomers == 'images') {
				//Images
				$ftp_host   = CDN_FTP_HOST;  //Cloudtv use for Images
				$ftp_username = CDN_FTP_USERNAME;
				$ftp_password = CDN_FTP_PASSWORD;
			} else {
				$ftp_host   = CDN_PREFIX_FTP_HOST; //cloudtv03 use for JSONS or CUSTOMERS
				$ftp_username = CDN_PREFIX_FTP_USERNAME;
				$ftp_password = CDN_FTP_PASSWORD;
			}



			// open an FTP connection
			$conn_id = ftp_connect($ftp_host) or die("Couldn't connect to $ftp_host");

			// login to FTP server
			$ftp_login = ftp_login($conn_id, $ftp_username, $ftp_password);

			// turn passive mode on
			ftp_pasv($conn_id, true);
		}
		$dirpathbm = '';



		if ($imagesOrJsonsOrCustomers == 'customers') {
			$userid = implode("/", str_split($this->toAlphaNumeric($user_id)));
			$pin_code = $this->toAlphaNumeric($pincode);
			$remotepath = $userid . "/" . $pin_code . ".json";
			$remoteFilePath =  IMS_CLIENT . '/' . $imagesOrJsonsOrCustomers . '/' . $remotepath;
			$dirpathbm = $userid . '/';
			$aaa = explode('/', $userid);
			//echo $userid.'<br>';
			$bbb = '';
			foreach ($aaa as $key => $val) {
				$bbb .= '/' . $val;
				if (!ACTIVE_RSYNC) {
					@ftp_mkdir($conn_id, IMS_CLIENT . '/' . $imagesOrJsonsOrCustomers . $bbb);
				}
				$localdirectory = LOCAL_PATH_CUSTOMER . $bbb;
			}
			if (!is_dir($localdirectory)) {
				/* Directory does not exist, so lets create it. */
				mkdir($localdirectory, 0777, true);
			}
			$fpt_r = fopen($localFilePath, 'w');
			fwrite($fpt_r, $final_json_output);
			fclose($fpt_r);
		} else {
			$remoteFilePath =  IMS_CLIENT . '/' . $imagesOrJsonsOrCustomers . $CrmOrCms . '/' . $filename;
		}

		if (!ACTIVE_RSYNC) {


			$remoteFilePath =  IMS_CLIENT . '/' . $imagesOrJsonsOrCustomers . $CrmOrCms . '/' . $dirpathbm . $filename;


			if (@ftp_put($conn_id, $remoteFilePath, $localFilePath, FTP_BINARY)) {
				// echo "File transfer successful - $remoteFilePath";exit;

			} else {
				//echo "There was an error while uploading $remoteFilePath";exit;
			}
			ftp_close($conn_id);
		}
	}

	public function creareJsonEpgPackagetime($todaydate, $product_id, $channels_array, $json_text)
	{
		$server_time = date('Y-m-d H:i:s');
		$main_array = array(
			'ServerTime' => $server_time,
			'channels' => $channels_array
		);

		$today = $todaydate;
		$filename = $today . '_' . $product_id . $json_text . '.json';

		$localFilePath = LOCAL_PATH_CMS . $filename;

		///Encryption 
		$final_json_output = json_encode($main_array,  JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES);

		if (ENCRYPT_JSON == 1)
			$final['CID'] = encrypt($final_json_output, 2);
		else
			$final = $main_array;

		$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);

		$fp = fopen($localFilePath, 'w');
		fwrite($fp, $return_array);
		fclose($fp);


		$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'cms');

		$this->load->model('publish_m');
		// insert into tables
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save('8', $data);
	}

	// send customer expiring email prior expiration
	public function subscription_expiring_email($prior_days = 7)
	{
		$this->load->model('customers_m');

		$sql = "SELECT c.*, p.name as product_name FROM customers c
               JOIN products p on c.product_id=p.id
               WHERE DATE_FORMAT(c.subscription_expire,'%Y-%m-%d') = CURDATE() + INTERVAL " . $prior_days . " DAY";
		$query = $this->db->query($sql);
		$customers = $query->result();

		if ($query->num_rows() > 0) {
			foreach ($customers as $customer) {

				// send email reminder
				$this->load->model('email_templates_m', 'EM');
				$template = $this->EM->get_email_template("subscription_expiring_reminder");

				$parse_data = array(
					'FIRST_NAME' => $customer->first_name,
					'USERNAME' => $customer->email,
					'SUBSCRIPTION_PLAN' => $customer->product_name,
					'EXPIRING_DAY' => $prior_days,
					'SUBSCRIPTION_END_DATE' => date('D F j, Y', strtotime($customer->subscription_expire)),
					'EMAIL' => $customer->email
				);
				// send email to customer
				$this->load->model('Email_model');
				$email_status = $this->Email_model->send_email($template, $parse_data);
			}
		}
	}

	public function runAllCron()
	{
		$this->updateEPGData();
		$this->createJsonCatchupEPG('8');
		$this->createJsonEPG('8');
		$this->EPGpackage();
	}
}
