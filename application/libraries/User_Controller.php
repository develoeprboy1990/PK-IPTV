<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_controller extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->config->load('breadcrumb');
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('login', 'refresh');
		}
		//Do your magic here
	}

	/*
	 * Check AJAX call with type POST
	 */
	public function check_post_ajax_request()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
			exit;
		}
		if ($this->input->server('REQUEST_METHOD') !== 'POST') {
			$return_data = array('status' => 0, 'message' => 'An error occurred.');
			echo json_encode($return_data);
			exit;
		}
	}

	/*
	 * XSS clean data
	 */
	public function secure_data($field_data = '')
	{
		return $this->security->xss_clean(trim($field_data));
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

	//For Remove duplicate array value of object 
	public function my_array_unique($array, $keep_key_assoc = false)
	{
		$duplicate_keys = array();
		$tmp = array();

		foreach ($array as $key => $val) {
			// convert objects to arrays, in_array() does not support objects
			if (is_object($val))
				$val = (array)$val;
			if (!in_array($val, $tmp))
				$tmp[] = $val;
			else
				$duplicate_keys[] = $key;
		}
		foreach ($duplicate_keys as $key)
			unset($array[$key]);
		return $keep_key_assoc ? $array : array_values($array);
	}


	public function get_all_users()
	{
		$totaldata = 10;
		$totalfiltered = 10;
		$all_users = $this->user_m->get_join();
		$data = array();
		foreach ($all_users as $user) {
			$data[] = array(
				'id' => $user->id,
				'user_name' => ucwords($user->user_name),
				'user_employee' => ucwords($user->user_employee_id_emp_name),
				'user_group' => ucwords($user->user_group_id_group_name),
				'user_status' => ($user->user_status) ? 'Active' : 'Inactive',
				'user_edit' => btn_edit(BASE_URL . 'user/edit/' . $user->id),
				'user_delete' => btn_delete(BASE_URL . 'user/delete/' . $user->id),
				'user_create_date' => $user->user_create_date
			);
		}
		// print_r($data);
		// die;
		$json_data = array(
			"draw"            => intval($_REQUEST['draw']),
			"recordsTotal"    => intval($totaldata),
			"recordsFiltered" => intval($totalfiltered),
			"data"            => $data
		);
		echo json_encode($json_data);
	}

	public function get_all_emp()
	{
		$totaldata = 10;
		$totalfiltered = 10;
		$all_employee = $this->employee_m->get();
		$data = array();
		foreach ($all_employee as $emp) {
			$data[] = array(
				'id' => $emp['id'],
				'employee_name' => ucwords($emp['emp_name']),
				'employee_status' => ($emp['emp_status']) ? 'Active' : 'Inactive',
				'employee_edit' => btn_edit(BASE_URL . 'employee/edit/' . $emp['id']),
				'employee_delete' => btn_delete(BASE_URL . 'employee/delete/' . $emp['id']),
				'employee_create_date' => $emp['emp_create_date']
			);
		}
		$json_data = array(
			"draw"            => intval($_REQUEST['draw']),
			"recordsTotal"    => intval($totaldata),
			"recordsFiltered" => intval($totalfiltered),
			"data"            => $data
		);
		echo json_encode($json_data);
	}

	public function get_all_group()
	{
		$totaldata = 10;
		$totalfiltered = 10;
		$all_group = $this->group_m->get();
		$data = array();
		foreach ($all_group as $grp) {
			$data[] = array(
				'id' => $grp['id'],
				'group_name' => ucwords($grp['group_name']),
				'group_status' => ($grp['group_status']) ? 'Active' : 'Inactive',
				'group_permission' => btn_permission(BASE_URL . 'group/permission/' . $grp['id']),
				'group_edit' => btn_edit(BASE_URL . 'group/edit/' . $grp['id']),
				'group_delete' => btn_delete(BASE_URL . 'group/delete/' . $grp['id']),
				'group_create_date' => $grp['group_create_date']
			);
		}
		$json_data = array(
			"draw"            => intval($_REQUEST['draw']),
			"recordsTotal"    => intval($totaldata),
			"recordsFiltered" => intval($totalfiltered),
			"data"            => $data
		);
		echo json_encode($json_data);
	}

	public function get_all_role()
	{
		$totaldata = 10;
		$totalfiltered = 10;
		$all_role = $this->role_m->get();
		$data = array();
		foreach ($all_role as $role) {
			$data[] = array(
				'id' => $role['id'],
				'role_name' => ucwords($role['role_name']),
				'role_status' => ($role['role_status']) ? 'Active' : 'Inactive',
				'role_edit' => btn_edit(BASE_URL . 'role/edit/' . $role['id']),
				'role_delete' => btn_delete(BASE_URL . 'role/delete/' . $role['id']),
				'role_create_date' => $role['role_create_date']
			);
		}
		$json_data = array(
			"draw"            => intval($_REQUEST['draw']),
			"recordsTotal"    => intval($totaldata),
			"recordsFiltered" => intval($totalfiltered),
			"data"            => $data
		);
		echo json_encode($json_data);
	}


	public function get_all_groups_channel()
	{
		$totaldata = 10;
		$totalfiltered = 10;
		$all_group = $this->groups_channel_m->get();
		$data = array();
		foreach ($all_group as $grp) {
			$data[] = array(
				'id' => $grp['id'],
				'name' => ucwords($grp['name']),
				'position' => $grp['position'],
				'group_edit' => btn_edit(BASE_URL . 'groups_channel/edit/' . $grp['id']),
				'group_delete' => btn_delete(BASE_URL . 'groups_channel/delete/' . $grp['id'])
			);
		}
		$json_data = array(
			"draw"            => intval($_REQUEST['draw']),
			"recordsTotal"    => intval($totaldata),
			"recordsFiltered" => intval($totalfiltered),
			"data"            => $data
		);
		echo json_encode($json_data);
	}


	/*
     * Data table query
     */
	public function _data_table($columns)
	{
		if ($this->input->post('length') != '-1')
			$query['limit'] = array('limit' => $this->input->post('length'), 'from' => $this->input->post('start'));

		//Ordering
		if (!empty($_POST["order"])) {
			$index = $_POST['order']['0']['column'];
			$field = $columns[$index];
			$query['orderby'] = array('field' => $field, 'order' => $_POST['order']['0']['dir']);
		}

		// Filtering
		if ($_POST["search"]["value"] != '') {
			$where = "";
			for ($i = 0; $i < count($columns); $i++) {
				$where .= $columns[$i] . " LIKE '%" . $_POST["search"]["value"] . "%' OR ";
			}

			$where = substr_replace($where, "", -3);
			$query['where'] = $where;
		}

		return $query;
	}


	public function upload_image_remote($tabrow, $path, $image_name, $model, $id)
	{

		$url = 'http://image.tmdb.org/t/p/w500/' . $image_name;
		/* Extract the filename */
		$filename = substr($url, strrpos($url, '/') + 1);
		/* Save file wherever you want */
		file_put_contents($path . $filename, file_get_contents($url));

		$data = array($tabrow => $image_name);
		$this->$model->save($id, $data);
		return $image_name;
	}

	public function upload_image($filename, $oldfilename, $path, $model, $id)
	{
		// remove old file 
		if (file_exists($path . $oldfilename)) {
			@unlink($path . $oldfilename);
		}
		//echo $path;
		//echo $filename;
		$img_data = $this->do_upload($path, $filename);
		$data = array($filename => $img_data);
		$this->$model->save($id, $data);
		return $img_data;
	}

	public function resize_image($tmp_filename, $localFilePath, $width, $height)
	{
		$this->load->library('image_lib');

		$image_info = getimagesize($tmp_filename);
		$image_width = $image_info[0];
		$image_height = $image_info[1];

		if ($image_width > $width || $image_height > $height) {
			$config['image_library'] = 'gd2';
			$config['source_image'] = $localFilePath;
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = FALSE;
			$config['width']     = $width;
			$config['height']   = $height;

			$this->image_lib->initialize($config);
			//$this->image_lib->crop();
			$this->image_lib->resize();
			$this->image_lib->clear();
			//if (!$this->image_lib->crop())
			/*if (!$this->image_lib->resize())
			{
			    return $this->image_lib->display_errors();
			}*/
			return true;
		}
	}

	function download_and_save_image($url, $path)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);

		$data = curl_exec($ch);
		curl_close($ch);

		$file_name = $this->get_file_name_from_url($url);
		$fp = $path . $file_name;

		if (file_put_contents($fp, $data))
			return true;
		else
			return false;
	}

	function get_file_name_from_url($url)
	{
		$path_parts = pathinfo($url);
		return $file_name = $path_parts['filename'] . "." . $path_parts['extension'];
	}

	public function uploadToServer($filename, $localFilePath, $remoteFilePath)
	{
		$this->load->model('settings_m');
		// FTP server details
		die("change this it using wrong function uploadToServer, should be use uploadToCdnServer");

		//$ftp_host   = $this->settings_m->getValue('cdn_ftp_host');
		//	$ftp_username = $this->settings_m->getValue('cdn_ftp_username');
		//	$ftp_password = $this->settings_m->getValue('cdn_ftp_passwqord');
		//	$cdn_folder   = $this->settings_m->getValue('cdn_folder');

		$ftp_host   = CDN_PREFIX_FTP_HOST;
		$ftp_username = CDN_PREFIX_FTP_USERNAME;
		$ftp_password = CDN_PREFIX_FTP_PASSWORD;
		$cdn_folder   = CDN_PREFIX_FOLDER;
		/*$ftp_host   = 'ftp.ams.9662C.etacdn.net';
		$ftp_username = 'vissionent+3iptv@gmail.com';
		$ftp_password = '12k-skkw-2WEE_MAS';*/

		// open an FTP connection
		$conn_id = ftp_connect($ftp_host) or die("Couldn't connect to $ftp_host");

		// login to FTP server
		$ftp_login = ftp_login($conn_id, $ftp_username, $ftp_password);

		// turn passive mode on
		ftp_pasv($conn_id, true);

		// local & server file path
		$remoteFilePath = '/' . $cdn_folder . '/' . $remoteFilePath . '/' . $filename;

		//move_uploaded_file ($filename , $localFilePath);
		// try to upload file
		if (ftp_put($conn_id, $remoteFilePath, $localFilePath, FTP_BINARY)) {
			// echo "File transfer successful - $localFilePath";
		} else {
			//echo "There was an error while uploading $localFilePath";
		}
		// close the connection
		ftp_close($conn_id);
	}
	public function toAlphaNumeric($input)
	{
		if (is_null($input)) {
			return "";
		} else {
			$input = preg_replace('/\s/', '', $input);

			$input = preg_replace("/[^a-zA-Z0-9]/", "", $input);
			return $input;
		}
	}

	public function resyncCloudServer()
	{
		//shell_exec(ACTIVE_RSYNC_BASH_SCRIPT);
		$output = shell_exec('pgrep -x "rsync" > /dev/null');
		if (is_null($output)) {
			shell_exec(sprintf('%s > /dev/null 2>&1 &', ACTIVE_RSYNC_SETTINGS));
		}


		//  sprintf('%s > /dev/null 2>&1 & ', /root/xims.cdnnext.com_RSYNC.sh )
		//shell_exec(sprintf('%s > /dev/null 2>&1 &', ACTIVE_RSYNC_SETTINGS));
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
			//$userid = implode("/", str_split($this->toAlphaNumeric($user_id)));
			
			$userid = implode("/", array_map('strtolower', str_split($this->toAlphaNumeric($user_id))));
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
		} 
		else {
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


	public function updateEPGData()
	{
		$this->load->model('channels_m');
		$channels = $this->channels_m->get();
		$this->load->model('epg_m');
		$this->load->model('epgs_m');
		$epgs_info = $this->epgs_m->get();

		$sql = "TRUNCATE  epg";
		$query = $this->db->query($sql);

		foreach ($epgs_info as $key => $val) {
			if ($val['epg_status'] == '1') {
				$url = $val['url'];
				$id = $val['id'];

				if (strpos($url, '.xml.gz') !== false) {
						$this->epg_m->updateEPGgzipSmart($url, $channels);
				} elseif (strpos($url, '.xml') !== false) {
					$days = $val['epg_offset_date'];
					$timestamp = $days * 24 * 60 * 60;
					$earlier_date = (time() - $timestamp);
					$earlier_date = date('Y-m-d', $earlier_date);
					$this->epg_m->updateEPGSmart($url, $channels);
				}
			}
		}
		$this->createJsonEPG(8);
	}

	
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

	






	public function createJsonProductCatchup($todaydate, $product_id, $channels_array, $json_text)
	{
		$server_time = date('Y-m-d H:i:s');
		$main_array = array(
			'ServerTime' => $server_time,
			'channels' => $channels_array
		);

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
}