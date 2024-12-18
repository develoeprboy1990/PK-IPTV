<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Publish extends User_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->data['is_allow'] = check_permission(28);
		$this->load->model('publish_m');
		$this->load->model('channels_m');
		$this->load->model('customers_m');
		$this->load->model('settings_m');
		$this->load->model('reseller_m');
		
		$this->data['main_nav'] = "publish";
	}

	public function index()
	{
		check_allow('view', $this->data['is_allow']);

		$this->data['_extra_scripts'] = DEFAULT_THEME . 'publish/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'publish/index';
		$this->data['page_title'] = "Publish";
		$this->data['modules'] = $this->publish_m->get();
		$this->load->view(DEFAULT_THEME . '_layout', $this->data);
	}

	public function updateAll()
	{
		check_allow('edit', $this->data['is_allow']);
		$this->createJsonOperator(1);
		$this->createJsonChannelPackages(2);
		$this->createJsonMovieStores(3);
		$this->createJsonMovieDetails(4);
		$this->createJsonSeriesStores(5);
		//$this->createJsonTV(6);
		$this->createJsonHomeScreen(7);
		$this->createJsonEPG(8);
		//$this->createJsonDevices(9);
		$this->createJsonProducts(10);
		$this->createJsonSeries(11);
		$this->createJsonMusicPackage(12);
		$this->createJsonProductApps(13);
		$this->createJsonTags(14);
		$this->createJsonLanguages(16);
		$this->session->set_flashdata('success', "All Json Files Published Successfully.");
		redirect(BASE_URL . 'publish');
	}

	public function create($id)
	{
		check_allow('create', $this->data['is_allow']);
		switch ($id) {
			case 1:
				$this->createJsonOperator($id);
				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">Operator Json Files Created</a>');
				$this->session->set_flashdata('success', "Operator Json Files Created Successfully.");
				redirect(BASE_URL . 'publish');
				break;
			case 2:
				$this->createJsonChannelPackages($id);
				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">Channel Packages Json Files Created</a>');
				$this->session->set_flashdata('success', "Channel Packages Json Files Created Successfully.");
				redirect(BASE_URL . 'publish');
				break;
			case 3:
				$this->createJsonMovieStores($id);
				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">Movies Stores Json Files Created</a>');
				$this->session->set_flashdata('success', "Movies Stores Json Files Created Successfully.");
				redirect(BASE_URL . 'publish');
				break;
			case 4:
				$this->createJsonMovieDetails($id);
				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">Movie Details Json Files Created</a>');
				$this->session->set_flashdata('success', "Movie Details Json Files Created Successfully.");
				redirect(BASE_URL . 'publish');
				break;
			case 5:
				$this->createJsonSeriesStores($id);
				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">Series Stores Json Files Created</a>');
				$this->session->set_flashdata('success', "Series Stores Json Files Created Successfully.");
				redirect(BASE_URL . 'publish');
				break;
			case 6:
				$this->createJsonTV($id);
				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">TV Package Json Files Created</a>');
				$this->session->set_flashdata('success', "TV Package Json Files Created Successfully.");
				redirect(BASE_URL . 'publish');
				break;
			case 7:
				$this->createJsonHomeScreen($id);
				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">Home Screen Json File Created</a>');
				$this->session->set_flashdata('success', "Home Screen Json File Created Successfully.");
				redirect(BASE_URL . 'publish');
				break;

			case 8:
				$this->EPGpackage();
				$this->createJsonCatchupEPG($id);
				$this->createJsonEPG($id);

				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">EPG Json Files Created</a>');
				$this->session->set_flashdata('success', "EPG Json Files Created Successfully.");
				redirect(BASE_URL . 'publish');
				break;

			case 9:
				$this->createJsonDevices($id);
				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">Devices Json Files Created</a>');
				$this->session->set_flashdata('success', "Devices Json Files Created Successfully.");
				redirect(BASE_URL . 'publish');
				break;

			case 10:
				$this->createJsonProducts($id);
				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">Products Json Files Created</a>');
				$this->session->set_flashdata('success', "Products Json Files Created Successfully.");
				redirect(BASE_URL . 'publish');
				break;

			case 11:
				$this->createJsonSeries($id);
				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">Series Json Files Created</a>');
				$this->session->set_flashdata('success', "Series Json Files Created Successfully.");
				redirect(BASE_URL . 'publish');
				break;
			case 12:
				$this->createJsonMusicPackage($id);
				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">Music Package Json Files Created</a>');
				$this->session->set_flashdata('success', "Music Package Json Files Created Successfully.");
				redirect(BASE_URL . 'publish');
				break;
			case 13:
				$this->createJsonProductApps($id);
				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">App Package Json Files Created</a>');
				$this->session->set_flashdata('success', "App Package Json Files Created Successfully.");
				redirect(BASE_URL . 'publish');
				break;
			case 14:
				$this->createJsonTags($id);
				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">Tags Json Files Created</a>');
				$this->session->set_flashdata('success', "Tags Json Files Created Successfully.");
				redirect(BASE_URL . 'publish');
				break;
			case 15:
				$userDataArray = $this->customers_m->getCustomers();
				/*echo '<pre>';
				print_r($userDataArray);exit;*/
				foreach ($userDataArray as $key => $val) {
					$username = $this->generateUsername($val['id']);
					$password = base64_decode($val['password']);
					$user_id = $val['email'];
					$pincode = $password;

					//--------raj-----------
					// 					mkdir("./testXXX", 0777, true);
					// 						$fpts = fopen("./testXXX/test.json", 'w');
					// 						fwrite($fpts, "this is the text");
					// 		fclose($fpts);

					$userid1 = implode("/", str_split($this->toAlphaNumeric($user_id)));
					/*$pin_code2 = $this->toAlphaNumeric($pincode);	
					$localdirectory= LOCAL_PATH_CUSTOMER.$userid1;
					mkdir($localdirectory, 0777, true);
					
					$localtestfile =$localdirectory."/".$pin_code2.".json";
					
					$final_json_output2 = $this->publishJsonGenerater($username, $password);
					
						$fpt = fopen($localtestfile, 'w');
					fwrite($fpt, $final_json_output2);
					fclose($fpt);*/
					//--------raj-end----------


					//final json file will be like this 
					//$filename = $dddd->id . '_customers.json';
					$filename = $password . '.json';
					//$localFilePath = './jsons/customers/' . $filename;

					$localFilePath = LOCAL_PATH_CUSTOMER . $userid1 . '/' . $filename;
					$final_json_output = $this->publishJsonGenerater($username, $password);

					$this->publishMakeJsonFile($final_json_output, $filename, $localFilePath, 'customers', '', $user_id, $pincode);
				}
				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">Customers Json Files Created</a>');
				$this->session->set_flashdata('success', "Customers Json Files Created Successfully.");
				redirect(BASE_URL . 'publish');
			case 16:
				$this->createJsonLanguages($id);
				$this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish') . '" target="_blank">Languages Json Files Created</a>');
				$this->session->set_flashdata('success', "Languages Json Files Created Successfully.");
				redirect(BASE_URL . 'publish');
				break;
			default:
				# code...
				break;
		}
	}
	
	public function generateUsername($inserted_id)
	{
		$prefix_code = $this->settings_m->getValue('userid-prefix');
		$userid = $prefix_code . $inserted_id;
		return $userid;
	}
	
	public function publishMakeJsonFile($final_json_output, $filename, $localFilePath, $filetype, $crm, $user_id, $pincode)
	{
		/*$fp = fopen($localFilePath, 'w');
		fwrite($fp, $final_json_output);
		fclose($fp);*/
		$this->uploadToCdnServer($filename, $localFilePath, $filetype, $crm, $user_id, $pincode, $final_json_output);
	}

	public function publishJsonGenerater($uname, $pass)
	{
		$username = $uname;
		$password = $pass;
		$accountStatus =  array('0' => 'Disabled', '1' => 'Active');
		//$user = $this->customers_m->checkuser($username, $password);
		$user = $this->customers_m->checkusercustomerpublic($username, $password);
		// get product details
		$product = $this->customers_m->get_product($user->id);
		// get plan details

		/*$plan=$this->customers_m->get_plan($user->id);
		if($plan->devices_allowed != null)
		{
		$devices_allowed = $plan->devices_allowed;
		}else{*/
		$devices_allowed = $user->devices_allowed;
		/*}*/

	
		// get productlocation
		$location = $this->customers_m->get_product_location($product->id);
		// get total extra channel packages
		$channel_packages = $this->customers_m->get_channel_packages($user->id);
		// get total extra Movie Stores
		$movie_stores = $this->customers_m->get_movie_stores($user->id);
		// get total extra Series Stores
		$series_stores = $this->customers_m->get_series_stores($user->id);
		// get music categories
		$music_categories = $this->customers_m->get_music_categories($user->id);
		//$msg = $this->customers_m->get_message_customers($user->id);
		$return_array = array(
			'account' => array(
				'date_expired' => date('d M Y', strtotime($user->subscription_expire)),
				'datetime_expired' => date('m/d/Y H:i:s A', strtotime($user->subscription_expire)),
				//'resellerid' => $user->reseller_id,
				'resellerid' => "0",
				'account_status' => $accountStatus[$user->status],
				'max_concurrent_devices' =>$devices_allowed,
				'allow_inapp_theme_change' => $user->allow_theme ? true : false,
				'staging' => $user->allow_theme ? true : false,
				'isBeta' =>$user->is_beta ? true : false
			),

			'customer' => array(
				'walletbalance' => $user->walletbalance,
				'currency' => $user->currency
			),
			'products' => array(
				"productid" => $product->id,
				"productname" => $product->name
			),
			'payperview' => array(
				"movies" => $movie_stores,
				"seasons" => [],
				"albums" => $movie_stores,
				"channels" => []
			),
			'storage' => array(
				"total" => 0,
				"used" => 0,
				"total_hours" => 0
			),

			'profiles' => [array(
				"id" => $user->id,
				"name" => $user->first_name . " " . $user->last_name,
				"recommendations" => "[]",
				"mode" => "regular",
				"avatar" => ""
			)],
			'messages' => [],
			'recordings' => []
		);
		$final_json_output = json_encode(json_encode($return_array, JSON_UNESCAPED_SLASHES));
		return $final_json_output;
	}

	public function createJsonOperator($id)
	{
		check_allow('create', $this->data['is_allow']);
		$this->load->model('operator_m');
		$this->load->model('contacts_m');

		$operator_details = $this->operator_m->get_by(array('id' => 1), TRUE);
		$welcome_details = $this->contacts_m->get_by(array('name' => 'welcome'), TRUE);
		$main_details = $this->contacts_m->get_by(array('name' => 'main'), TRUE);

		// build Main json
		$result_main = 	array(
			'client' => $operator_details->operator_name,
			'brandname' => $operator_details->operator_brand,
			'supportinfo' => $operator_details->operator_support_email,
			'contact'   => 	array(
				'qrcode' => $main_details->qrcode,
				'text' => $main_details->qrcode,
				'logo' => $main_details->logo,
				'background' => $main_details->background,
				'selection_color' => $main_details->selection_color,
			),
			'cms' => $operator_details->operator_crm,
			'crm' => $operator_details->operator_name,
			'account' 	=> 	array(
				'user_register' => ($operator_details->operator_use_register == 1) ? "true" : "false",
				'use_trial' => ($operator_details->operator_use_trial == 1) ? "true" : "false",
				'use_renew_by_key' => ($operator_details->operator_use_renew_by_key == 1) ? "true" : "false",
				'product_trial_id' => $operator_details->operator_product_trial_id,
				'disclaimer' => $operator_details->operator_disclaimer,
				'is_show_disclaimer' => ($operator_details->operator_is_show_disclaimer == 1) ? "true" : "false"
			),
			'sleepmode' => $operator_details->operator_sleepmode,
			'default_language' => ucwords($operator_details->operator_default_language),
			'languages' =>  array(
				'language' => 'English',
				'language' => 'Hindi',
			),
			'style'     => 	array(
				'image_location' => $operator_details->operator_image_location,
				'content_api_location' => $operator_details->operator_content_api_location,
				'product_api_location' => $operator_details->operator_product_api_location,
				'web_api_location' => $operator_details->operator_web_api_location,
				'news_image_location' => $operator_details->operator_news_image_location,
				'font' => $operator_details->operator_font,
				'background' => $main_details->background,
				'logo' => $main_details->logo,
				'highlight' => array(
					'primary' => $operator_details->operator_primary_color,
					'secondary' => $operator_details->operator_secondary_color
				)
			)
		);

		// build welcome json
		$result_welcome = 	array(
			'client' => $operator_details->operator_name,
			'cms' => $operator_details->operator_brand,
			'crm' => $operator_details->operator_crm,
			'default_language' => ucwords($operator_details->operator_default_language),
			'web_api_location' => $operator_details->operator_web_api_location,
			'contact'   => 	array(
				'qrcode' => $welcome_details->qrcode,
				'text' => $welcome_details->qrcode,
				'logo' => $welcome_details->logo,
				'background' => $welcome_details->background,
				'selection_color' => $welcome_details->selection_color,
			),
			'account' 	=> 	array(
				'user_register' => ($operator_details->operator_use_register == 1) ? "true" : "false",
				'use_trial' => ($operator_details->operator_use_trial == 1) ? "true" : "false",
				'use_renew_by_key' => ($operator_details->operator_use_renew_by_key == 1) ? "true" : "false",
				'product_trial_id' => $operator_details->operator_product_trial_id,
				'disclaimer' => $operator_details->operator_disclaimer,
				'is_show_disclaimer' => ($operator_details->operator_is_show_disclaimer == 1) ? "true" : "false"
			),
			'style'     => 	array(
				'product_api_location' => $operator_details->operator_product_api_location
			),
			'storage'   =>  $operator_details->operator_storage,
			'languages' =>  array(
				'language' => 'English',
				'language' => 'Hindi',
			)
		);

		$filename = 'settings_main.json';
		$localFilePath = './jsons/' . $filename;

		/* Encryption */
		$final_json_output = json_encode($result_main, JSON_UNESCAPED_SLASHES);
		//$final['CID'] = encrypt($final_json_output, 2);

		if (ENCRYPT_JSON == 1)
			$final['CID'] = encrypt($final_json_output, 2);
		else
			$final = $main_array;

		$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);

		$fp = fopen($localFilePath, 'w');
		fwrite($fp, $return_array);
		fclose($fp);

		$this->uploadToServer($filename, $localFilePath, 'jsons/setting');

		$filename = 'settings_welcome.json';
		$localFilePath = './jsons/' . $filename;

		/* Encryption */
		$final_json_output = json_encode($result_welcome, JSON_UNESCAPED_SLASHES);
		//$final['CID'] = encrypt($final_json_output, 2);
		if (ENCRYPT_JSON == 1)
			$final['CID'] = encrypt($final_json_output, 2);
		else
			$final = $main_array;

		$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);

		$fp = fopen($localFilePath, 'w');
		fwrite($fp, $return_array);
		fclose($fp);

		$this->uploadToServer($filename, $localFilePath, 'jsons/setting');

		// insert into tables
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save($id, $data);
	}

	public function createJsonMovieStores($id)
	{

		$this->createJsonUpdate("movie");
		check_allow('create', $this->data['is_allow']);
		$server_time = date('Y-m-d H:i:s'); //2019-07-21T15:12:01.213422+00:00

		// get the total products in the system
		$sql = "Select * FROM products";
		$query = $this->db->query($sql);

		foreach ($query->result() as $product) {

			//get all parent stores
			$sql = "Select ms.*,l.name as language_name 
				  From movie_store ms
				  JOIN product_to_vod_stores pvs on pvs.vod_store_id=ms.id
				  LEFT JOIN languages l ON l.id = ms.language_id
				  WHERE ms.parent_id=0 AND pvs.product_id='$product->id' AND  ms.active =1";

			$query = $this->db->query($sql);

			$stores_array = array();

			foreach ($query->result() as $store) {
				

				$sql_genre = "Select DISTINCT(mg.id) as mgid, mg.* 
								From movie_genre mg 
									join movie_to_genres mtg on mg.id=mtg.genre_id 
									where mtg.store_id='$store->id' order by mg.id";


				$query_genre = $this->db->query($sql_genre);
				$genres = array();

			
				//RECENT_MOVIE_GENRE_NAME
				$sql_movie_recent = "SELECT movie.id, movie.language, movie.poster, movie.backdrop, movie.name, movie.year, l.name as language_name 
                     FROM movie 
                     LEFT JOIN languages l ON l.id = movie.language
                     WHERE movie.store_id='$store->id' 
                     ORDER BY movie.id DESC 
                     LIMIT " . RECENT_MOVIE_LIMIT;

				$query_movie_recent = $this->db->query($sql_movie_recent);
				$movies_recent = array();
				$position_recent = 1;
				foreach ($query_movie_recent->result() as $movie_recent) {
					array_push(
						$movies_recent,
						array(
							'id' => (int)$movie_recent->id,
							'language_id' => $movie_recent->language,
							'language' => $movie_recent->language_name,
							'poster' => $movie_recent->poster,
							'backdrop' => $movie_recent->backdrop,
							'name' => stripslashes($movie_recent->name),
							'position' => $position_recent++,
							'year' => date('Ymd', strtotime($movie_recent->year))
						)
					);
				}
				array_push(
					$genres,
					array(
						'id' => 1,
						'name' => RECENT_MOVIE_GENRE_NAME,
						'vod_id' => (int)$store->id,
						'language_id' => (int)$store->language_id,
						'language' => $store->language_name,
						'movies' => $movies_recent
					)
				);
				//--

				//	@14sep24 start
				// New Release Movie added order by year
				$sql_latest_release_movies_order_by_year = "
				SELECT * FROM (
    		    SELECT movie.id, movie.language, movie.poster, movie.backdrop, movie.name, movie.year, l.name as language_name 
   			    FROM movie 
   			    LEFT JOIN languages l ON l.id = movie.language
       			WHERE movie.store_id = '$store->id' 
        		ORDER BY movie.id DESC 
        		LIMIT " . LATEST_RELEASE_MOVIE_LIMIT . "
    			) AS subquery
    			ORDER BY year DESC";
				$query_latest_release_movies = $this->db->query($sql_latest_release_movies_order_by_year);
				$movies_new_release = array();
				$position_new_release = 2;

				foreach ($query_latest_release_movies->result() as $movie_new_release) {
					array_push(
						$movies_new_release,
						array(
							'id' => (int)$movie_new_release->id,
							'language_id' => $movie_new_release->language,
							'language' => $movie_new_release->language_name,
							'poster' => $movie_new_release->poster,
							'backdrop' => $movie_new_release->backdrop,
							'name' => $movie_new_release->name,
							'position' => $position_new_release++,
							'year' => date('Ymd', strtotime($movie_new_release->year))
						)
					);
				}

				// Add the new genre array to the genres array
				array_push(
					$genres,
					array(
						'id' => 2, // Adjust ID as needed
						'name' => LATEST_RELEASE_MOVIE_GENRE_NAME,
						'vod_id' => (int)$store->id,
						'language_id' => (int)$store->language_id,
						'language' => $store->language_name,
						'movies' => $movies_new_release
					)
				);

				//@14sep24 end
				foreach ($query_genre->result() as $genre) {
					//get all movies associated with genre_id
					$sql_movie = "Select m.*,l.name language_name 
									From movie m
									JOIN languages l on 
									l.id=m.language
									JOIN movie_to_genres mg on
									m.id=mg.movie_id
						 			WHERE mg.genre_id='$genre->id' AND mg.store_id='$store->id' ORDER BY m.id DESC";

					$query_movie = $this->db->query($sql_movie);

					$movies = array();
					$position = 1;
					foreach ($query_movie->result() as $movie) {
						//$tags = explode(",", $movie->tags);
						array_push(
							$movies,
							array(
								'id' => (int)$movie->id,
								'poster' => $movie->poster,
								'language_id' => $movie->language,
								'language' => $movie->language_name,
								'backdrop' => $movie->backdrop,
								'name' => stripslashes($movie->name),
								'position' => $position++,
								//'tags' => $tags,
								'year' => date('Ymd', strtotime($movie->year))
							)
						);
					}

					array_push(
						$genres,
						array(
							'id' => (int)$genre->id + 2,
							'order_no' => $genre->order_no,
							'name' => $genre->name,
							'vod_id' => (int)$store->id,
							'language_id' => (int)$store->language_id,
							'language' => $store->language_name,
							'movies' => $movies

						)
					);
				}

				//get substores
				$sql_substores = "Select ms.*,l.name as language_name  
				From movie_store ms
				LEFT JOIN languages l ON l.id = ms.language_id
				WHERE ms.parent_id='$store->id' AND ms.active=1";
				$query_substores = $this->db->query($sql_substores);
				$substores = array();
				foreach ($query_substores->result() as $substore) {

					//get all genres associated with store_id
					/*$sql_substore_genre = "Select * From movie_genre 
						 WHERE store_id='$substore->id'";*/

					//$sql_substore_genre = "Select * From movie_genre";
					$sql_substore_genre = "Select DISTINCT(mg.id) as mgid, mg.id , mg.name, mtg.store_id, mtg.substore_id 
												From movie_genre mg 
													join movie_to_genres mtg on mg.id=mtg.genre_id 
														where mtg.store_id='$store->id' AND mtg.substore_id='$substore->id'";

					$query_substore_genre = $this->db->query($sql_substore_genre);
					$substore_genres = array();
					foreach ($query_substore_genre->result() as $substore_genre) {
						//get all movies associated with genre_id
						$sql_substore_movie = "Select m.*,l.name language_name 
									From movie m
									JOIN languages l on 
									l.id=m.language
									JOIN movie_to_genres mg on
									m.id=mg.movie_id
						 			WHERE mg.genre_id='$substore_genre->id' AND mg.store_id='$store->id' ORDER BY m.id DESC";
						$query_substore_movie = $this->db->query($sql_substore_movie);
						$substore_movies = array();
						$positions = 1;
						foreach ($query_substore_movie->result() as $substore_movie) {

							//$tags=explode(",",$substore_movie->tags);

							//get tags for this movie


							array_push(
								$substore_movies,
								array(
									'id' => (int)$substore_movie->id,
									'language_id' => (int)$substore_movie->language,
									'language' => $substore_movie->language_name,
									'poster' => $substore_movie->poster,
									'backdrop' => $substore_movie->backdrop,
									'name' => $substore_movie->name,
									'is_kids_friendly' => (int)$substore_movie->is_kids_friendly,
									'childlock' => (int)$substore_movie->childlock,
									'position' => $positions++
								)
							);
						}
						if (!empty($substore_movies)) {
							array_push(
								$substore_genres,
								array(
									'id' => (int)$substore_genre->id,
									'name' => $substore_genre->name,
									'movies' => $substore_movies
								)
							);
						}
					}
					array_push(
						$substores,
						array(
							'vod_id' => (int)$substore->id,
							'name' => $substore->name,
							'logo' => $substore->logo,
							'childlock' => (int)$substore->childlock,
							'position' => $substore->position,
							'language_id' => (int)$substore->language_id,
							'language' => $substore->language_name,
							'genres' => $substore_genres,
							'substores' => array()
						)
					);
				}

				array_push(
					$stores_array,
					array(
						'vod_id' => (int)$store->id,
						'name' => $store->name,
						'logo' => $store->logo,
						'childlock' => (int)$store->childlock,
						'position' => -(int)$store->position,
						'language_id' => (int)$store->language_id,
						'language' => $store->language_name,
						//'genres' => $genres,
						'genres' => empty($substores) ? $genres : null,
						'substores' => $substores
					)
				);
			}

			$main_array = array(
				'ServerTime' => $server_time,
				'vodstore' => $stores_array
			);

			$filename = $product->id . '_product_movies_v2.json';
			$localFilePath = LOCAL_PATH_CRM . $filename;
			/* Encryption */
			$final_json_output = json_encode($main_array, JSON_UNESCAPED_SLASHES);
			//$final['CID'] = encrypt($final_json_output, 2);

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
		// insert into tables
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save($id, $data);
		$this->createJsonTags(14);
	}

	

	public function createJsonMovieDetails($id)
	{
		$this->createJsonUpdate("movie");
		check_allow('create', $this->data['is_allow']);
		$this->load->model('movies_m');
		$server_time = date('Y-m-d H:i:s');

		// get all movies
		$movies = $this->movies_m->get_movies();

		foreach ($movies as $movie) {

			$url_trailer = rtrim($this->channels_m->get_server_url_by_id($movie->server_url_trailer), "/");
			if ($url_trailer != NULL)
				$url_trailer = $url_trailer . "/";

			//get movie stream urls 
			$sql = "Select msu.stream_name,l.name language_name,t.token_short_code,siu.url,m.vast_url
			      FROM movie_stream_urls msu
				  JOIN movie m on m.id=msu.movie_id
				  JOIN languages l on l.id=msu.language_id
				  JOIN token t on t.id=msu.token_id
				  LEFT JOIN server_items_urls siu on siu.id=msu.server_url_id
				  WHERE msu.movie_id=" . $movie->id;
			$query = $this->db->query($sql);
			$stream_urls = array();
			foreach ($query->result() as $stream) {
				
				if ($stream->url != NULL) {
					$stream_url = rtrim($stream->url, "/");
					$url = $stream_url . "/" . ltrim($stream->stream_name, "/");
				} else {
					$url = $stream->stream_name;
				}

				array_push(
					$stream_urls,
					array(
						'url' => $url,
						'language' => $stream->language_name,
						//'toktype'=>$stream->token_short_code,
						'vtt_url' => $stream->vast_url,
						'secure_stream' => false,
						'akamai_token' => true,
						'flussonic_token' => false
					)
				);
			}

			$url_movie = rtrim($this->channels_m->get_server_url_by_id($movie->server_url_movie), "/");
			if ($url_movie != NULL)
				$url_movie = $url_movie . "#";

			//get tags for this movie
			$sql_tags = "SELECT name FROM movie_tags WHERE id IN (
				SELECT tag_id from movie_to_tags WHERE movie_id='$movie->id')";
			$query_tags = $this->db->query($sql_tags);

			$tags = [];

			foreach ($query_tags->result() as $tag) {
				$tags[] = $tag->name;
			}

			$movie_array = array(
				'ServerTime' => $server_time,
				'id' => (int)$movie->id,
				'name' => stripslashes($movie->name),
				'description' => stripslashes($movie->description),
				'poster' => $movie->poster,
				'backdrop' => $movie->backdrop,
				'length' => (int)$movie->duration,
				'year' => $movie->year,
				'trailer_url' => $url_trailer . $movie->trailer,
				// 'toktype_trailer'=>$this->channels_m->get_token_code_by_id($movie->token_trailer),
				'actors' => stripslashes($movie->actor),
				'imdb_rating' => (int)$movie->rating,
				'rating' => ((int)$movie->rating) / 2,
				'language_id' => $movie->language,
				'language' => $movie->language_name,
				'childLock' => (int)$movie->childlock,
				'is_kids_friendly' => ($movie->is_kids_friendly == 0) ? false : true,
				'age_rating' => null,
				'is_payperview' => false,
				'rule_payperview' => array(
					'id' => 0,
					'name' => null,
					'type' => null,
					'quantity' => 0
				),
				'movieprices' => array(),
				'moviedescriptions' => array(array(
					'language' => $movie->language_name,
					'description' => stripslashes($movie->description)
				)),
				'moviestreams' => $stream_urls,
				'tags' => $tags,
				'has_preroll' => (int)$movie->preroll_enabled,
				'has_overlaybanner' => (int)$movie->overlay_enabled,
				'has_ticker' => (int)$movie->ticker_enabled,
				'vast' => null
			);

			$filename = $movie->id . '_movie_details_v2.json';
			$localFilePath = LOCAL_PATH_CMS . $filename;
			$main_array = $movie_array;
			/* Encryption */
			$final_json_output = json_encode($movie_array, JSON_UNESCAPED_SLASHES);
			//$final['CID'] = encrypt($final_json_output, 2);

			if (ENCRYPT_JSON == 1)
				$final['CID'] = encrypt($final_json_output, 2);
			else
				$final = $main_array;

			$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);

			$fp = fopen($localFilePath, 'w');
			fwrite($fp, $return_array);
			fclose($fp);

			$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'cms');
		}

		// insert into tables
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save($id, $data);
	}
	//new added on 28sep23
	//create series using package 

	public function createJsonSeriesStores($id)
	{
		$this->createJsonUpdate("serie");
		check_allow('create', $this->data['is_allow']);
		$server_time = date('Y-m-d H:i:s'); //2019-07-21T15:12:01.213422+00:00

		// get the  series store in system
		$sql = "Select series_store.*,l.name as language_name FROM series_store
		LEFT JOIN languages l on l.id=series_store.language_id 
		where series_store.active = 1";
		$query = $this->db->query($sql);

		foreach ($query->result() as $store) {
			$stores_array = array();
			//get all series associated with store_id
			$sql_series = "Select series.*,l.name as language_name From series 
						LEFT JOIN languages l on 
										l.id=series.language_id
						 WHERE series.store_id='$store->id' ORDER BY series.id DESC";
			$query_series = $this->db->query($sql_series);
			$series_array = array();
			foreach ($query_series->result() as $series) {
				//get all seasons associated with series_id
				$sql_seasons = "SELECT ss.* 
								FROM series_seasons ss
                				WHERE ss.series_id = '$series->id'";


				$query_seasons = $this->db->query($sql_seasons);
				$seasons_array = array();
				foreach ($query_seasons->result() as $season) {
					$sql_episodes  = "Select * From series_episode WHERE season_id='$season->id' ORDER BY sequence_id";
					$query_episodes = $this->db->query($sql_episodes);
					$episodes_array = array();
					foreach ($query_episodes->result() as $episode) {
						$url = rtrim($this->channels_m->get_server_url_by_id($episode->server_url_id), "/");
						if ($url != NULL)
							$url = $url . "/";
						array_push(
							$episodes_array,
							array(
								'id' => (int)$episode->id,
								'name' => stripslashes($episode->title),
								'image' => $episode->image, //todo in cms
								'season_number' => (int)$season->season_number,
								'episode_number' => (int)$episode->sequence_id,
								'description' => stripslashes($episode->description),
								//'crew' => array($episode->actor),
								'crew' =>  null,
								'streams' => array(
									array(
										'url' => $url .  ltrim($episode->url, "/"),
										'language' => $series->language_name,
										'language_id' => (int)$series->language_id, 
										// 'toktype'=>$this->channels_m->get_token_code_by_id($episode->token_id)
										'vtt_url' => null,
										'secure_stream' => false,
										'akamai_token' => true,
										'flussonic_token' => false
									)
								),
							)
						);
					}

					array_push(
						$seasons_array,
						array(
							'id' => (int)$season->id,
							'name' => $season->name,
							'poster' => $season->poster,
							'backdrop' => $season->backdrop,
							'childLock' => (int)$season->childlock,
							'season_number' => (int)$season->season_number,
							'length' => (int)$season->duration,
							'year' => $season->year,
							'actors' => stripslashes($season->actor),
							'rating' => ((int)$season->rating) / 2,
							'imdb_rating' => $season->rating,
							'language' => $series->language_name,
							'language_id' => (int)$series->language_id, 
							'is_kids_friendly' => ($season->is_kids_friendly == 0) ? false : true,
							'has_preroll' => (int)$season->preroll_enabled,
							'has_overlaybanner' => (int)$season->overlay_enabled,
							'has_ticker' => (int)$season->ticker_enabled,
							'descriptions' => array(array(
								'language' => $series->language_name, // Use series language
								'description' => stripslashes($season->description)
							)),
							'episodes' => $episodes_array,
							'tags' => ($season->tags != "") ? explode(",", $season->tags) : array()
						)
					);
				}

				array_push(
					$series_array,
					array(
						'name' => stripslashes($series->name),
						'logo' => $series->logo,
						'childlock' => (int)$series->childlock,
						'position' => (int)$series->position,
						'language_id' => (int)$series->language_id,
						'language' => $series->language_name,
						'id' => (int)$series->id,
						'season' => $seasons_array
					)
				);
			}

			array_push(
				$stores_array,
				array(
					'vod_id' => (int)$store->id,
					'name' => $store->name,
					'logo' => $store->logo,
					'childlock' => (int)$store->childlock,
					'position' => (int)$store->position,
					'language_id' => (int)$store->language_id,
					'language' => $store->language_name,
					'series' => $series_array
				)
			);

			$main_array = array(
				'ServerTime' => $server_time,
				'seriestore' => $stores_array
			);
			$filename = $store->id . '_series_stores_v2.json';
			$localFilePath = LOCAL_PATH_CMS . $filename;

			/* Encryption */
			$final_json_output = json_encode($main_array, JSON_UNESCAPED_SLASHES);
			//$final['CID'] = encrypt($final_json_output, 2);
			if (ENCRYPT_JSON == 1)
				$final['CID'] = encrypt($final_json_output, 2);
			else
				$final = $main_array;
			$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);
			$fp = fopen($localFilePath, 'w');
			fwrite($fp, $return_array);
			fclose($fp);
			$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'cms');
		}
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save($id, $data);
	}



	//nouse
	public function createJsonSeries($id)
	{
		$this->createJsonUpdate("serie");
		check_allow('create', $this->data['is_allow']);
		$server_time = date('Y-m-d H:i:s'); //2019-07-21T15:12:01.213422+00:00


		// get the total products in the system
		$sql = "Select * FROM products";
		$query = $this->db->query($sql);

		foreach ($query->result() as $product) {

			//get all series associated with store_id
			$sql_series = "SELECT * FROM `series` ORDER BY `id` DESC";
			$query_series = $this->db->query($sql_series);

			$series_array = array();

			foreach ($query_series->result() as $series) {
				//get all seasons associated with series_id
				$sql_seasons = "Select ss.*,l.name language_name 
							From series_seasons ss
							JOIN languages l on 
							l.id=ss.language
				 			WHERE ss.series_id='$series->id'";
				$query_seasons = $this->db->query($sql_seasons);

				$seasons_array = array();
				foreach ($query_seasons->result() as $season) {
					//get all episodes associated with season_id
					$sql_episodes  = "Select * From series_episode WHERE season_id='$season->id'";
					$query_episodes = $this->db->query($sql_episodes);
					$episodes_array = array();
					foreach ($query_episodes->result() as $episode) {
						$url = rtrim($this->channels_m->get_server_url_by_id($episode->server_url_id), "/");
						if ($url != NULL)
							$url = $url . "#";

						array_push(
							$episodes_array,
							array(
								'id' => (int)$episode->id,
								'name' => stripslashes($episode->title),
								'streams' => array(
									'url' => $url . $episode->url,
									//	'language' => $season->language,
									'toktype' => $this->channels_m->get_token_code_by_id($episode->token_id)
								)
							)
						);
					}

					//get tags for this movie
					$sql_tags = "SELECT name FROM movie_tags WHERE id IN (
						SELECT tag_id from series_to_tags WHERE series_id='$season->id')";
					$query_tags = $this->db->query($sql_tags);

					$tags = [];

					foreach ($query_tags->result() as $tag) {
						$tags[] = $tag->name;
					}

					array_push(
						$seasons_array,
						array(
							'id' => (int)$season->id,
							'name' => stripslashes($season->name),
							'poster' => $season->poster,
							'backdrop' => $season->backdrop,
							'childlock' => (int)$season->childlock,
							'length' => (int)$season->duration,
							'year' => $season->year,
							'actors' => stripslashes($season->actor),
							'rating' => $season->rating,
							'language' => $season->language_name,
							'is_kids_friendly' => ($season->is_kids_friendly == 0) ? false : true,
							'has_preroll' => (int)$season->preroll_enabled,
							'has_overlaybanner' => (int)$season->overlay_enabled,
							'has_ticker' => (int)$season->ticker_enabled,
							'descriptions' => array(array(
								'language' => $season->language_name,
								'description' => stripslashes($season->description)
							)),
							'episodes' => $episodes_array,
							'tags' => $tags
						)
					);
				}

				array_push(
					$series_array,
					array(
						'id' => (int)$series->id,
						'name' => $series->name,
						'logo' => $series->logo,
						'childlock' => (int)$series->childlock,
						'position' => (int)$series->position,
						'season' => $seasons_array
					)
				);
			}

			$main_array = array(
				'ServerTime' => $server_time,
				'series' => $series_array
			);

			$filename = $product->id . '_series.json';
			$localFilePath = LOCAL_PATH_CRM . $filename;

			/* Encryption */
			$final_json_output = json_encode($main_array, JSON_UNESCAPED_SLASHES);
			//$final['CID'] = encrypt($final_json_output, 2);

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
		// insert into tables
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save($id, $data);
	}

	public function createJsonHomeScreen($id)
	{
		$url_trailer = '';
		$this->createJsonUpdate("movie");
		check_allow('create', $this->data['is_allow']);
		$server_time = date('Y-m-d H:i:s'); //2019-07-21T15:12:01.213422+00:00

		// get all products 
		$this->load->model('products_m');
		$products = $this->products_m->get();

		foreach ($products as $product) {
			//get all TV channels associated with this product id 
			$sql = "Select c.*,l.name as language_name From channel c
				  JOIN package_to_channel pc on c.id=pc.channel_id
			  	  JOIN channel_package cp on cp.id=pc.package_id
			  	  JOIN product_to_packages pp on pp.package_id =cp.id
			  	  LEFT JOIN languages l ON l.id = c.language_id
			  	  WHERE c.show_on_home=1 AND c.status=1 AND pp.product_id=" . $product['id'] . " GROUP BY c.id";
			$query = $this->db->query($sql);
			$tv_items_array = array();
			foreach ($query->result() as $tv_channel) {


				$url_high = rtrim($this->channels_m->get_server_url_by_id($tv_channel->server_url_high), "/");
				if ($url_high != NULL) {
					$url_high = $url_high . "/" . $tv_channel->url_high . "/" . CHANNEL_EXT;
				} else {
					$url_high = $url_high . $tv_channel->url_high;
				}

				$url_low = rtrim($this->channels_m->get_server_url_by_id($tv_channel->server_url_low), "/");
				if ($url_low != NULL) {
					$url_low = $url_low . "/" . $tv_channel->url_low . "/" . CHANNEL_EXT;
				} else {
					$url_low . $tv_channel->url_low;
				}

				$url_interactivetv = rtrim($this->channels_m->get_server_url_by_id($tv_channel->server_url_interactivetv), "/");

				if ($url_interactivetv != NULL) {
					$url_interactivetv = $url_interactivetv . "/" . $tv_channel->url_interactivetv . "/" . INTERACTIVE_CHANNEL_EXT;
				} else {
					$url_interactivetv = $url_interactivetv . $tv_channel->url_interactivetv;
				}

				//------------

				// $url_high = rtrim($this->channels_m->get_server_url_by_id($tv_channel->server_url_high), "/");

				// if ($url_high != NULL)
				// 	$url_high = $url_high . "#";

				// $url_low = rtrim($this->channels_m->get_server_url_by_id($tv_channel->server_url_low), "/");
				// if ($url_low != NULL)
				// 	$url_low = $url_low . "#";

				// $url_interactivetv = rtrim($this->channels_m->get_server_url_by_id($tv_channel->server_url_interactivetv), "/");

				// if ($url_interactivetv != NULL)
				// 	$url_interactivetv = $url_interactivetv . "#";


				// //----------



				array_push(
					$tv_items_array,
					array(
						'channel_id' => (int)$tv_channel->id,
						'language_id' => (int)$tv_channel->language_id,
						'language' => $tv_channel->language_name,
						'channel_image' => $tv_channel->channel_image,
						'channel_number' => (int)$tv_channel->channel_number,
						//---
						//'url_high' => $url_high . $tv_channel->url_high,
						//'url_high' => $url_high,
						'url_high' => ($tv_channel->is_flussonic == 1) ? $url_interactivetv : $url_high,
						'url_low' => $url_high,
						'tizen_webos' => $url_interactivetv,
						'ios_tvos' => $url_interactivetv,

						'standard_url' => $url_interactivetv,

						//'url_low' => $url_low . $tv_channel->url_low,

						//'url_interactivetv' => $url_interactivetv . $tv_channel->url_interactivetv,
						'url_interactivetv' => $url_interactivetv,
						//----

						'is_dveo' => ($tv_channel->is_dveo == 1) ? true : false,
						'is_flussonic' => ($tv_channel->is_flussonic == 1) ? true : false,
						//TODO dynamic DRM from database
						'drm' => array(
							'drm_type' => null,
							'drm_rewrite_rule' => null
						)
					)
				);
			}

			//get all movies associated with product_id
			$sql_movie = "Select m.*,l.name as language_name From movie m 
			             JOIN (select id from movie_store where id in (
			             	select vod_store_id from product_to_vod_stores where product_id=" . $product['id'] . ") 
							UNION (select vod_store_id from product_to_vod_stores where product_id=" . $product['id'] . ") 
							) x on m.store_id=x.id
							LEFT JOIN languages l ON l.id = m.language 
							WHERE m.show_on_home=1 AND m.status=1";
			$query_movie = $this->db->query($sql_movie);

			$movies = array();
			foreach ($query_movie->result() as $movie) {

				//---MOVIE URL 

				//get movie stream urls 
				$sql = "Select msu.stream_name,l.name language_name,t.token_short_code,siu.url,m.vast_url
			FROM movie_stream_urls msu
			JOIN movie m on m.id=msu.movie_id
			JOIN languages l on l.id=msu.language_id
			JOIN token t on t.id=msu.token_id
			LEFT JOIN server_items_urls siu on siu.id=msu.server_url_id
			WHERE msu.movie_id=" . $movie->id;
				$query = $this->db->query($sql);
				$stream_urls = array();
				foreach ($query->result() as $stream) {
					if ($stream->url != NULL) {
						$stream_url = rtrim($stream->url, "/");
						$url = $stream_url . "/" . ltrim($stream->stream_name, "/");
					} else {
						$url = $stream->stream_name;
					}

					array_push(
						$stream_urls,
						array(
							'url' => $url,
							'language' => $stream->language_name,
							//'toktype'=>$stream->token_short_code,
							'vtt_url' => $stream->vast_url,
							'secure_stream' => false,
							'akamai_token' => true,
							'flussonic_token' => false
						)
					);
				}



				//-------
				$sql_tags = "SELECT name FROM movie_tags WHERE id IN (
				SELECT tag_id from movie_to_tags WHERE movie_id='$movie->id')";
				$query_tags = $this->db->query($sql_tags);

				$tags = [];

				foreach ($query_tags->result() as $tag) {
					$tags[] = $tag->name;
				}
				//-------------	
				array_push(
					$movies,
					array(
						'id' => (int)$movie->id,
						'language_id' => (int)$movie->language,
						'language' => $movie->language_name,
						'name' => stripslashes($movie->name),
						'description' => $movie->description,
						'poster' => $movie->poster,
						'backdrop' => $movie->backdrop,
						'length' => (int)$movie->duration,
						'year' => $movie->year,
						'trailer_url' => '',
						// 'toktype_trailer'=>$this->channels_m->get_token_code_by_id($movie->token_trailer),
						'actors' => stripslashes($movie->actor),
						'imdb_rating' => $movie->rating,
						'rating' => $movie->rating,
						'childLock' => (int)$movie->childlock,
						'is_kids_friendly' => ($movie->is_kids_friendly == 0) ? false : true,
						'age_rating' => null,
						'is_payperview' => false,
						'rule_payperview' => array(
							'id' => 0,
							'name' => null,
							'type' => null,
							'quantity' => 0
						),
						'movieprices' => array(),
						'moviedescriptions' => array(array(
							//'language' => $movie->language_name,
							'language' => '',
							'description' => stripslashes($movie->description)
						)),
						'moviestreams' => $stream_urls,
						//'moviestreams' => '',
						'tags' => $tags,
						'has_preroll' => (int)$movie->preroll_enabled,
						'has_overlaybanner' => (int)$movie->overlay_enabled,
						'has_ticker' => (int)$movie->ticker_enabled,
						'vast' => null
					)
				);
			}

			//get all series associated with product_id
			$sql_series =  "SELECT s.*, l.name AS language_name
               				FROM series s
               				LEFT JOIN languages l ON l.id = s.language_id
						 	JOIN (select id from series_store where parent_id in (
                     		select series_store_id from product_to_series_stores where product_id=" . $product['id'] . ") 
							UNION (select series_store_id from product_to_series_stores where product_id=" . $product['id'] . ") 
							) x on s.store_id=x.id WHERE s.active=1";
			//		) x on s.store_id=x.id WHERE s.show_on_home=1 AND s.active=1";		 
			$query_series = $this->db->query($sql_series);

			$series = array();
			$seasons_array = array();
			foreach ($query_series->result() as $serie) {
				//get all seasons associated with series_id
				$sql_seasons = "Select ss.* 
								From series_seasons ss
								WHERE ss.series_id='$serie->id' AND ss.show_on_home=1";
				$query_seasons = $this->db->query($sql_seasons);
			
				
				foreach ($query_seasons->result() as $season) {
					//get all episodes associated with season_id
					$sql_episodes  = "Select * From series_episode WHERE season_id='$season->id'";
					$query_episodes = $this->db->query($sql_episodes);
					$episodes_array = array();
					foreach ($query_episodes->result() as $episode) {
						$url = rtrim($this->channels_m->get_server_url_by_id($episode->server_url_id), "/");
						if ($url != NULL)
							$url = $url . "#";
			
						array_push(
							$episodes_array,
							array(
								'id' => (int)$episode->id,
								'name' => $episode->title,
								'streams' => array(
									'url' => $url . $episode->url,
									'vtt_url' => null,
									'secure_stream' => false,
									'akamai_token' => true,
									'flussonic_token' => false
								)
							)
						);
					}
			
					//get tags for this movie
					$sql_tags = "SELECT name FROM movie_tags WHERE id IN (
								 SELECT tag_id from series_to_tags WHERE series_id='$season->id')";
					$query_tags = $this->db->query($sql_tags);
			
					$tags = [];
			
					foreach ($query_tags->result() as $tag) {
						$tags[] = $tag->name;
					}
			
					array_push(
						$seasons_array,
						array(
							'id' => (int)$season->id,
							'name' => stripslashes( $serie->name.": ".$season->name),
							'poster' => $season->poster,
							'backdrop' => $season->backdrop,
							'childlock' => (int)$season->childlock,
							'length' => (int)$season->duration,
							'year' => $season->year,
							'actors' => stripslashes($season->actor),
							'rating' => $season->rating,
							'language' => $serie->language_name, // From series
							'language_id' => (int)$serie->language_id, // From series
							'is_kids_friendly' => ($season->is_kids_friendly == 0) ? false : true,
							'has_preroll' => (int)$season->preroll_enabled,
							'has_overlaybanner' => (int)$season->overlay_enabled,
							'has_ticker' => (int)$season->ticker_enabled,
							'descriptions' => array(array(
								'language' => $serie->language_name, // From series
								'description' => stripslashes($season->description)
							)),
							'episodes' => $episodes_array,
							'tags' => $tags
						)
					);
				}
			
				array_push(
					$series,
					array(
						'id' => (int)$serie->id,
						'name' => stripslashes($serie->name),
						'logo' => $serie->logo,
						'childlock' => (int)$serie->childlock,
						'position' => (int)$serie->position,
						'language' => $serie->language_name, // Series-level language
						'language_id' => (int)$serie->language_id, // Series-level language_id
						'season' => $seasons_array
					)
				);
			}

			//get all news items associated with product's news_group_id
			$sql_news = "Select n.* From news n
					   WHERE n.news_group_id=" . $product['news_group_id'];

			$query_news = $this->db->query($sql_news);
			$news_array = array();
			foreach ($query_news->result() as $news) {
				array_push(
					$news_array,
					array(
						'id' => $news->id,
						'title' => $news->title,
						'image' => $news->image,
						'description' => $news->description,
						'date' => date('Y-m-d', $news->date_created)
					)
				);
			}

			$main_array = array(
				'servertime' => $server_time,
				'metrortvitems' => $tv_items_array,
				'metromovieitems' => $movies,
				'metroserieitems' =>	$seasons_array,   //@rob
				//'metroserieitems'=>$series,
				'metronewsitems' => $news_array
			);

			$filename = $product['id'] . '_metro_v2.json';
			$localFilePath = LOCAL_PATH_CRM . $filename;

			/* Encryption */
			$final_json_output = json_encode($main_array, JSON_UNESCAPED_SLASHES);
			//$final['CID'] = encrypt($final_json_output, 2);

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

		// insert into tables
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save($id, $data);
	}



	public function createJsonDevices($id)
	{
		check_allow('create', $this->data['is_allow']);
		$this->load->model('devices_m');

		// get all Devices 
		$server_time = date('Y-m-d H:i:s'); //2019-07-21T15:12:01.213422+00:00

		$devices = $this->devices_m->get();

		$devices_array = array();
		foreach ($devices as $device) {
			$devices_array[$device['model_name']] = ($device['available']) ? $device['available'] : "false";
		}

		$main_array = array(
			'serverTime' => $server_time,
			'devices' => $devices_array
		);

		$filename = 'devices.json';
		$localFilePath = './jsons/' . $filename;

		/* Encryption */
		$final_json_output = json_encode($main_array, JSON_UNESCAPED_SLASHES);
		//$final['CID'] = encrypt($final_json_output, 2);
		if (ENCRYPT_JSON == 1)
			$final['CID'] = encrypt($final_json_output, 2);
		else
			$final = $main_array;
		$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);

		$fp = fopen($localFilePath, 'w');
		fwrite($fp, $return_array);
		fclose($fp);

		$this->uploadToServer($filename, $localFilePath, 'jsons/device');

		// insert into tables
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save($id, $data);
	}

	public function uploadjsonimages($filesource, $filedestination, $filename)
	{
		$file = $filesource . $filename;
		// Open the file to get existing content
		$data = file_get_contents($file);
		// New file
		$new = $filedestination . $filename;
		// Write the contents back to a new file
		file_put_contents($new, $data);
	}

	public function createJsonProducts($id)
	{
		$this->createJsonUpdate("product");
		check_allow('create', $this->data['is_allow']);
		$this->load->model('products_m');

		// get all products 
		$products = $this->products_m->get();
		/*echo '<pre>';
		print_r($products);exit;*/
		$products_array = array();

		foreach ($products as $product) {
			// $this->userinterfaceJson($product['gui_setting_id']);
			// get menu items from services assciated with this product
			$sql = "SELECT m.* FROM iptv_menus m
			      JOIN services_menu_items smi on m.id=smi.menu_id
			      WHERE smi.service_id=?";

			$query = $this->db->query($sql, $product['service_id']);
			$menu_items_array = array();
			foreach ($query->result() as $menu) {
				array_push(
					$menu_items_array,
					array(
						'name' => $menu->name,
						'position' => (int)$menu->position,
						'is_default' => ($menu->is_default == "yes") ? true : false,
						'is_module' => ($menu->is_module == "yes") ? true : false,
						'module_name' => ($menu->module_name != "") ? $menu->module_name : null,
						'type' => $menu->type,
						'is_app' => ($menu->is_app == "yes") ? true : false,
						'package_name' => null,
						'package_url' => null
					)
				);
			}

			// get channel packages
			$sql_packages = "SELECT cp.* FROM channel_package cp
			      JOIN product_to_packages pp on cp.id=pp.package_id
			      WHERE pp.product_id=?";

			$query_packages = $this->db->query($sql_packages, $product['id']);
			$packages_array = array();
			foreach ($query_packages->result() as $package) {
				array_push($packages_array, array('PackageID' => (int) $package->id));
			}

			// get App packages
			$sql_app_packages = "SELECT c.* FROM app_package_to_categories c 
			      			   JOIN app_packages ap on ap.id=c.app_package_id
			      			   JOIN products p on p.app_package_id=ap.id
			      			   WHERE p.id=?";

			$query_app_packages = $this->db->query($sql_app_packages, $product['id']);

			$app_packages_array = array();
			foreach ($query_app_packages->result() as $app_package) {
				array_push($app_packages_array, array('PackageID' => (int) $app_package->app_category_id));
			}

			// get Movie Stores
			$sql_movie_stores = "SELECT ms.* FROM movie_store ms
			      			   JOIN product_to_vod_stores pvs on ms.id=pvs.vod_store_id
			                   WHERE pvs.product_id=?";

			$query_movie_stores = $this->db->query($sql_movie_stores, $product['id']);
			$movie_stores_array = array();
			foreach ($query_movie_stores->result() as $movie_store) {
				array_push($movie_stores_array, array('PackageID' => (int) $movie_store->id));
			}
			// get Series Stores
			$sql_series_stores = "SELECT ss.* FROM series_store ss
			      			   JOIN product_to_series_stores pss on ss.id=pss.series_store_id
			                   WHERE pss.product_id=?";

			$query_series_stores = $this->db->query($sql_series_stores, $product['id']);
			$series_stores_array = array();
			foreach ($query_series_stores->result() as $series_store) {
				array_push($series_stores_array, array('PackageID' => (int) $series_store->id));
			}


			// get Devices Stores
			$sql_devices = "SELECT d.* FROM devices d
			      			   JOIN product_to_devices pd on d.id=pd.device_id
			                   WHERE pd.product_id=?";

			$query_devices = $this->db->query($sql_devices, $product['id']);
			$devices_array = array();
			foreach ($query_devices->result() as $device) {
				$devices_array[$device->model_name] = ($device->available) ? true : false;
			}

			// get GUI Settings 
			$sql_settings = "SELECT gs.*, ut.name as ui FROM gui_settings gs
			      		   JOIN ui_themes ut on gs.ui=ut.id
			      		   WHERE gs.id=?";

			$query_settings = $this->db->query($sql_settings, $product['gui_setting_id']);
			//echo $this->db->last_query();
			//$settings_array = array();
			$setting_info = $query_settings->row();
			//	print_r($setting_info);

			$settings_array = array(
				"youtube_api_key" => $setting_info->youtube_api_key,
				"flusonic_base_url" => $setting_info->flusonic_base_url,
				"product_has_epg" => $setting_info->product_has_epg == "true" ? true : false,
				"gui_start_url" => $setting_info->gui_start_url,
				"base_start_url" => $setting_info->base_start_url . "_" . md5($setting_info->id),
				"ui" => $setting_info->ui,
				"brandname" => $setting_info->brandname,
				"contactinformation" => $setting_info->contactinformation,
				"dir" => $setting_info->dir,
				"show_catchuptv" => $setting_info->show_catchuptv == "true" ? true : false,
				"show_clock" => $setting_info->show_clock == "true" ? true : false,
				"show_fontsize" => $setting_info->show_fontsize == "true" ? true : false,
				"show_hint" => $setting_info->show_hint == "true" ? true : false,
				"show_languages" => $setting_info->show_languages == "true" ? true : false,
				"show_quickmenu" => $setting_info->show_quickmenu == "true" ? true : false,
				"show_screensaver" => $setting_info->show_screensaver == "true" ? true : false,
				"show_search" => $setting_info->show_search == "true" ? true : false,
				"show_speedtest" => $setting_info->show_speedtest == "true" ? true : false,
				"enable_hint" => $setting_info->enable_hint == "true" ? true : false,
				"enable_kids_mode" => $setting_info->enable_kids_mode == "true" ? true : false,
				"enable_advertisments" => $setting_info->enable_advertisments == "true" ? true : false,
				"direct_tv_mode" => $setting_info->direct_tv_mode == "true" ? true : false,
				"max_concurrent_devices" => (int)$setting_info->max_concurrent_devices,
				"channel_preview" => $setting_info->channel_preview == "true" ? true : false,
				"epg_preview" => $setting_info->epg_preview == "true" ? true : false,
				"show_weather" => $setting_info->show_weather == "true" ? true : false,
				"max_days_interactivetv" => (int)$setting_info->max_days_interactivetv,
				"sleep_mode" => (int)$setting_info->sleep_mode,
				"payment_type" => $setting_info->payment_type,
				"storage_package" => (int)$setting_info->storage_package,
				"catchup_days" => 7

			);


			/*	foreach ($setting_info as $key => $value) {
				if ($key != "id" && $key != "setting_name" && $key != "qrcode" && $key != "text_ui" && $key != "logo" && $key != "background" && $key != "selection_color")
					//$settings_array[$key]= ($value=="true" ? true:$value);
					//$settings_array[$key]= ($value=="true" ? true:$value);
					//$settings_array[$key]=$value;

					if ($key == "base_strat_url"){
						$settings_array[$key] = $value."_".md5($product['gui_setting_id']);
					} elseif ($value == "true") {
						$settings_array[$key] = true;
					} elseif ($value == "") {
						$settings_array[$key] = false;
					} else {
						$settings_array[$key] = $value;
					}
			}*/

			//  $settings_array['gui_start_url'] = rtrim($settings_array['gui_start_url'],'/')."/".ltrim($settings_array['location'],'/');

			// get server locations
			// get GUI SEttings 
			//	$sql_server_location="SELECT * FROM server_location_items
			//    		  		  WHERE server_id=?";

			//$query_server_location=$this->db->query($sql_server_location,$product['server_id']);
			//	$location_array=array();
			//	foreach ($query_server_location->result() as $location) {

			//		$location_array[$location->name]=$location->url;
			//	}
			//   unset($location_array['ui']); 
			//TOKEN ARRAY

			//$token_array=array();

			//AKAMAI TOKEN MIX with 10 extra character if AKAMAI_TOKEN_MIX_KEY not set or less then 10 character
			//$token_array[akamai_token]=  substr(AKAMAI_TOKEN_MIX_KEY."Ja839js023",10).AKAMAI_TOKEN; 

			//FLUSSONIC TOKEN
			//$token_array[flussonic_token]=  substr(FLUSSONIC_TOKEN_MIX_KEY."Ak93sKddwi",10).FLUSSONIC_TOKEN; 


			$main_array = array(
				'menu' => array('menuitems' => $menu_items_array),
				'contact' => array(
					'qrcode' => $setting_info->qrcode,
					'text' => htmlentities($setting_info->text_ui),
					'logo' => $setting_info->logo,
					'background' => $setting_info->background,
					'selection_color' => $setting_info->primary_color
				),
				'facebook' => array('appid' => '', 'clienttoken' => ''),
				'ChannelPackages' => $packages_array,
				'AppPackages' => $app_packages_array,
				'MovieStores' => $movie_stores_array,
				'SeriesStores' => $series_stores_array,
				'MusicPackages' => array(),
				'YoutubePackages' => array(),
				//	'server_location'=>$location_array,			
				'devices' => $devices_array,
				'akamai_key' =>  substr("Ja839js023" . AKAMAI_TOKEN_MIX_KEY, 10) . AKAMAI_KEY,
				'flussonic_key' =>  substr("Ak93sKddwi" . FLUSSONIC_TOKEN_MIX_KEY, 10) . FLUSSONIC_KEY

			);
			$main = array_merge($main_array, $settings_array);
			//print_r($main);
			//die();

			$filename = $product['id'] . '_product_v2.json';
			$localFilePath = LOCAL_PATH_CRM . $filename;

			/* Encryption */
			$final_json_output = json_encode($main, JSON_UNESCAPED_SLASHES);

			//$final['CID'] = encrypt($final_json_output, 2);

			if (ENCRYPT_JSON == 1)
				$final['CID'] = encrypt($final_json_output, 2);
			else
				$final = $main;

			$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);

			$fp = fopen($localFilePath, 'w');
			fwrite($fp, $return_array);
			fclose($fp);

			//$this->uploadToServer($filename,$localFilePath,'jsons/product');

			$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'crm');
		}

		// insert into tables
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save($id, $data);
	}

	//OLD_with all channels and v2
	public function createJsonPackages_old_no_USE()
	{


		$server_time = date('Y-m-d H:i:s');

		//get all channel packages
		$sql = "Select id FROM channel_package WHERE active = 1";

		$query = $this->db->query($sql);

		foreach ($query->result() as $packaget) {
			$all_channels_group_array = array();
			$all_channels_array = array();


			$channel_in_package = "Select c.id channel_id From channel c
						 JOIN package_to_channel cg on cg.channel_id=c.id  
						 WHERE cg.package_id='$packaget->id' AND status = 1";

			$querry_channel_in_package = $this->db->query($channel_in_package);

			foreach ($querry_channel_in_package->result() as $channel_package) {

				//add to array if channel is not exist 
				if (!in_array($channel_package->channel_id, $all_channels_array)) {
					$all_channels_array[] = $channel_package->channel_id;
				}
			}



			// find all group 
			$sql_group = "SELECT * FROM `channel_group` ORDER BY position";

			$query_group = $this->db->query($sql_group);
			$groups_array = array();
			foreach ($query_group->result() as $group) {
				// Find all channels in each group 
				$sql_channel_group = "Select ch.*,l.name as language_name  From channel ch 
				JOIN channel_to_group cg on ch.id=cg.channel_id 
				LEFT JOIN languages l on l.id=ch.language_id 
				WHERE cg.group_id = '$group->id' AND ch.status=1";

				$query_sql_channel_group = $this->db->query($sql_channel_group);
				$channels_array = array();

				if (count($query_sql_channel_group->result()) > 0) {
					foreach ($query_sql_channel_group->result() as $channel) {



						if (in_array($channel->id, $all_channels_array)) {
							$url_high = rtrim($this->channels_m->get_server_url_by_id($channel->server_url_high), "/");

							if ($url_high != NULL) {
								$url_high = $url_high . "/" . $channel->url_high . "/" . CHANNEL_EXT;
							} else {
								$url_high = $url_high . $channel->url_high;
							}

							$url_low = rtrim($this->channels_m->get_server_url_by_id($channel->server_url_low), "/");
							if ($url_low != NULL) {
								$url_low = $url_low . "/" . $channel->url_low . "/" . CHANNEL_EXT;
							} else {
								$url_low . $channel->url_low;
							}

							$url_interactivetv = rtrim($this->channels_m->get_server_url_by_id($channel->server_url_interactivetv), "/");

							if ($url_interactivetv != NULL) {
								$url_interactivetv = $url_interactivetv . "/" . $channel->url_interactivetv . "/" . INTERACTIVE_CHANNEL_EXT;
							} else {
								$url_interactivetv = $url_interactivetv . $channel->url_interactivetv;
							}

							$url_standard = rtrim($this->channels_m->get_server_url_by_id($channel->server_standard), "/");

							if ($url_standard != NULL)
								$url_standard = $url_standard . "/";

							$url_ios_tvos = rtrim($this->channels_m->get_server_url_by_id($channel->server_ios_tvos), "/");

							if ($url_ios_tvos != NULL)
								$url_ios_tvos = $url_ios_tvos . "/";

							$url_tizen_webos = rtrim($this->channels_m->get_server_url_by_id($channel->server_tizen_webos), "/");

							if ($url_tizen_webos != NULL)
								$url_tizen_webos = $url_tizen_webos . "/";


							array_push(
								$channels_array,
								array(
									'channel_id' => (int)$channel->id,
									'language_id' => (int)$channel->language_id,
									'language' => $channel->language_name,
									'channel_number' => (int)$channel->channel_number,
									'name' => $channel->channel_name,
									'url_high' => $url_high,
									//'toktype_high' => $this->channels_m->get_token_code_by_id($channel->token_high),
									//NO NEEDED URL LOW NO MORE USING
									//'url_low' => $url_low,
									//'toktype_low' => $this->channels_m->get_token_code_by_id($channel->token_low),
									'url_interactivetv' => $url_interactivetv,
									//'toktype_interactive' => $this->channels_m->get_token_code_by_id($channel->token_interactivetv),
									'standard_url' => $url_high, //TODO
									'ios_tvos' => $url_high,
									'tizen_webos' => $url_high,
									// 'standard_url'=>$url_standard.$channel->url_standard,
									//'ios_tvos'=>$url_ios_tvos.$channel->url_ios_tvos,
									//'tizen_webos'=>$url_tizen_webos.$channel->url_tizen_webos,
									'is_flussonic' => (int)$channel->is_flussonic,
									'is_dveo' => 0,
									'icon' => $channel->channel_image != null ? $channel->channel_image : 'default.jpeg',
									'icon_small' => $channel->channel_image != null ? $channel->channel_image : 'default.jpeg',
									'icon_big' => $channel->channel_image != null ? $channel->channel_image : 'default.jpeg',
									'preroll_enabled' => (int)$channel->preroll_enabled,
									'overlay_enabled' => (int)$channel->overlay_enabled,
									'ticker_enabled' => (int)$channel->ticker_enabled,
									'childlock' => (int)$channel->childlock,
									'flusonnic' => (int)$channel->is_flussonic,
									'secure_stream' => $this->channels_m->get_token_code_by_id($channel->token_high) == 'secure_stream' ? true : false,
									'akamai_token' => $this->channels_m->get_token_code_by_id($channel->token_high) == 'akamai_token' ? true : false,
									'flussonic_token' => $this->channels_m->get_token_code_by_id($channel->token_high) == 'flussonic_token' ? true : false,
									'drm_stream' => false,
									'drm_rewrite_rule' => null,
									'dvr_offset' => (int)$channel->dvr_offset,
									'rule_payperview' => array(
										'id' => 0,
										'name' => null,
										'type' => null,
										'quantity' => 0
									),
									'is_kids_friendly' => ($channel->is_kids_friendly == 0) ? false : true,
									'vast' => null,
									'drm' => array(
										'drm_type' => null,
										'drm_rewrite_rule' => null
									)
								)
							);
						}
						//$all_channels_group_array = array_merge($all_channels_group_array, $channels_array);

					}
					if (!empty($channels_array)) {
						array_push($groups_array, array(
							'id' => (int)$group->id + 1,
							'name' => $group->name,
							'position' =>  -(int)($group->position + 1),
							'channels' => $channels_array
						));
					}
					$all_channels_group_array = array_merge($all_channels_group_array, $channels_array);
				}
			}

			$all_channels_group_array = array_unique($all_channels_group_array, SORT_REGULAR);
			$key_values = array_column($all_channels_group_array, 'channel_number');
			array_multisort($key_values, SORT_ASC, $all_channels_group_array);

			array_unshift($groups_array, array(
				'id' => 1,
				'name' => "All Channels",
				'position' => -1,
				'channels' => $all_channels_group_array
				//'channels' => $all_channels_array
			));


			//$final_array_with_all =  array_merge($groups_array, $all_channels_group_array);

			$main_array = array(
				'ServerTime' => $server_time,
				'tv' => $groups_array
			);
			$filename = $packaget->id . '_package_tv_v2.json';
			//$filename = $packaget->id . '_product_channels_v2.json';
			$localFilePath = LOCAL_PATH_CMS . $filename;

			//  Encryption 
			$final_json_output = json_encode($main_array, JSON_UNESCAPED_SLASHES);
			//$final['CID'] = encrypt($final_json_output, 2);
			if (ENCRYPT_JSON == 1)
				$final['CID'] = encrypt($final_json_output, 2);
			else
				$final = $main_array;

			$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);

			$fp = fopen($localFilePath, 'w');
			fwrite($fp, $return_array);
			fclose($fp);


			$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'cms');

			//	echo '<pre>';
			//	print_r($main_array);
			//	exit;
		}
	
	}
	public function createJsonPackages()
	{


		$server_time = date('Y-m-d H:i:s');

		//get all channel packages
		$sql = "Select id FROM channel_package WHERE active = 1";

		$query = $this->db->query($sql);

		foreach ($query->result() as $packaget) {
			$all_channels_group_array = array();
			$all_channels_array = array();


			$channel_in_package = "Select c.id channel_id From channel c
						 JOIN package_to_channel cg on cg.channel_id=c.id  
						 WHERE cg.package_id='$packaget->id' AND status = 1";

			$querry_channel_in_package = $this->db->query($channel_in_package);

			foreach ($querry_channel_in_package->result() as $channel_package) {

				//add to array if channel is not exist 
				if (!in_array($channel_package->channel_id, $all_channels_array)) {
					$all_channels_array[] = $channel_package->channel_id;
				}
			}



			// find all group 
			$sql_group = "SELECT * FROM `channel_group` ORDER BY position";

			$query_group = $this->db->query($sql_group);
			$groups_array = array();
			foreach ($query_group->result() as $group) {
				// Find all channels in each group 
				$sql_channel_group = "Select ch.*,l.name as language_name  From channel ch 
				JOIN channel_to_group cg on ch.id=cg.channel_id 
				LEFT JOIN languages l on l.id=ch.language_id 
				WHERE cg.group_id = '$group->id' AND ch.status=1";

				$query_sql_channel_group = $this->db->query($sql_channel_group);
				$channels_array = array();

				if (count($query_sql_channel_group->result()) > 0) {
					foreach ($query_sql_channel_group->result() as $channel) {



						if (in_array($channel->id, $all_channels_array)) {
							$url_high = rtrim($this->channels_m->get_server_url_by_id($channel->server_url_high), "/");

							if ($url_high != NULL) {
								$url_high = $url_high . "/" . $channel->url_high . "/" . CHANNEL_EXT;
							} else {
								$url_high = $url_high . $channel->url_high;
							}

							$url_low = rtrim($this->channels_m->get_server_url_by_id($channel->server_url_low), "/");
							if ($url_low != NULL) {
								$url_low = $url_low . "/" . $channel->url_low . "/" . CHANNEL_EXT;
							} else {
								$url_low . $channel->url_low;
							}

							$url_interactivetv = rtrim($this->channels_m->get_server_url_by_id($channel->server_url_interactivetv), "/");

							if ($url_interactivetv != NULL) {
								$url_interactivetv = $url_interactivetv . "/" . $channel->url_interactivetv . "/" . INTERACTIVE_CHANNEL_EXT;
							} else {
								$url_interactivetv = $url_interactivetv . $channel->url_interactivetv;
							}

							$url_standard = rtrim($this->channels_m->get_server_url_by_id($channel->server_standard), "/");

							if ($url_standard != NULL)
								$url_standard = $url_standard . "/";

							$url_ios_tvos = rtrim($this->channels_m->get_server_url_by_id($channel->server_ios_tvos), "/");

							if ($url_ios_tvos != NULL)
								$url_ios_tvos = $url_ios_tvos . "/";

							$url_tizen_webos = rtrim($this->channels_m->get_server_url_by_id($channel->server_tizen_webos), "/");

							if ($url_tizen_webos != NULL)
								$url_tizen_webos = $url_tizen_webos . "/";


							array_push(
								$channels_array,
								array(
									'channel_id' => (int)$channel->id,
									'language_id' => (int)$channel->language_id,
									'language' => $channel->language_name,
									'channel_number' => (int)$channel->channel_number,
									'name' => $channel->channel_name,
									'url_high' => $url_high,
									//'toktype_high' => $this->channels_m->get_token_code_by_id($channel->token_high),
									//NO NEEDED URL LOW NO MORE USING
									//'url_low' => $url_low,
									//'toktype_low' => $this->channels_m->get_token_code_by_id($channel->token_low),
									'url_interactivetv' => $url_interactivetv,
									//'toktype_interactive' => $this->channels_m->get_token_code_by_id($channel->token_interactivetv),
									'standard_url' => $url_high, //TODO
									'ios_tvos' => $url_high,
									'tizen_webos' => $url_high,
									// 'standard_url'=>$url_standard.$channel->url_standard,
									//'ios_tvos'=>$url_ios_tvos.$channel->url_ios_tvos,
									//'tizen_webos'=>$url_tizen_webos.$channel->url_tizen_webos,
									'is_flussonic' => (int)$channel->is_flussonic,
									'is_dveo' => 0,
									'icon' => $channel->channel_image != null ? $channel->channel_image : 'default.jpeg',
									'icon_small' => $channel->channel_image != null ? $channel->channel_image : 'default.jpeg',
									'icon_big' => $channel->channel_image != null ? $channel->channel_image : 'default.jpeg',
									'preroll_enabled' => (int)$channel->preroll_enabled,
									'overlay_enabled' => (int)$channel->overlay_enabled,
									'ticker_enabled' => (int)$channel->ticker_enabled,
									'childlock' => (int)$channel->childlock,
									'flusonnic' => (int)$channel->is_flussonic,
									'secure_stream' => $this->channels_m->get_token_code_by_id($channel->token_high) == 'secure_stream' ? true : false,
									'akamai_token' => $this->channels_m->get_token_code_by_id($channel->token_high) == 'akamai_token' ? true : false,
									'flussonic_token' => $this->channels_m->get_token_code_by_id($channel->token_high) == 'flussonic_token' ? true : false,
									'drm_stream' => false,
									'drm_rewrite_rule' => null,
									'dvr_offset' => (int)$channel->dvr_offset,
									'rule_payperview' => array(
										'id' => 0,
										'name' => null,
										'type' => null,
										'quantity' => 0
									),
									'is_kids_friendly' => ($channel->is_kids_friendly == 0) ? false : true,
									'vast' => null,
									'drm' => array(
										'drm_type' => null,
										'drm_rewrite_rule' => null
									)
								)
							);
						}
						//$all_channels_group_array = array_merge($all_channels_group_array, $channels_array);

					}
					if (!empty($channels_array)) {
						array_push($groups_array, array(
							'id' => (int)$group->id + 1,
							'name' => $group->name,
							'position' =>  -(int)($group->position + 1),
							'channels' => $channels_array
						));
					}
					//$all_channels_group_array = array_merge($all_channels_group_array, $channels_array);
				}
			}

			//$all_channels_group_array = array_unique($all_channels_group_array, SORT_REGULAR);
			//$key_values = array_column($all_channels_group_array, 'channel_number');
			//array_multisort($key_values, SORT_ASC, $all_channels_group_array);

			// array_unshift($groups_array, array(
			// 	'id' => 1,
			// 	'name' => "All Channels",
			// 	'position' => -1,
			// 	'channels' => $all_channels_group_array
			// 	//'channels' => $all_channels_array
			// ));


			//$final_array_with_all =  array_merge($groups_array, $all_channels_group_array);

			$main_array = array(
				'ServerTime' => $server_time,
				'tv' => $groups_array
			);
			$filename = $packaget->id . '_package_tv_v2.json';
			//$filename = $packaget->id . '_product_channels_v2.json';
			$localFilePath = LOCAL_PATH_CMS . $filename;

			//  Encryption 
			$final_json_output = json_encode($main_array, JSON_UNESCAPED_SLASHES);
			//$final['CID'] = encrypt($final_json_output, 2);
			if (ENCRYPT_JSON == 1)
				$final['CID'] = encrypt($final_json_output, 2);
			else
				$final = $main_array;

			$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);

			$fp = fopen($localFilePath, 'w');
			fwrite($fp, $return_array);
			fclose($fp);


			$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'cms');

			//	echo '<pre>';
			//	print_r($main_array);
			//	exit;
		}
	
	}

//version 2 with all channels 
	public function createJsonChannelPackages_oldNOUSE($id)
	{
		$this->createJsonUpdate("channel");
		$this->createJsonPackages();
		check_allow('create', $this->data['is_allow']);
		$server_time = date('Y-m-d H:i:s');

		// get the total products in the system
		$sql = "Select * FROM products";
		$query = $this->db->query($sql);

		foreach ($query->result() as $product) {
			$all_channels_group_array = array();
			//get all channel packages
			$sql_pkg = "Select cp.id From channel_package cp 
			JOIN product_to_packages pp on pp.package_id=cp.id
			WHERE pp.product_id=" .  $product->id;

			$query_pkg = $this->db->query($sql_pkg);
			$all_channels_array = array();
			//Get all channel package loop 
			foreach ($query_pkg->result() as $tv) {

				//get all channel in package 
				$channel_in_package = "Select c.id channel_id,l.name as language_name From channel c
						LEFT JOIN languages l on l.id=c.language_id
						 JOIN package_to_channel cg on cg.channel_id=c.id  
						 WHERE cg.package_id='$tv->id' AND status = 1";

				$querry_channel_in_package = $this->db->query($channel_in_package);

				foreach ($querry_channel_in_package->result() as $channel_package) {

					//add to array if channel is not exist 
					if (!in_array($channel_package->channel_id, $all_channels_array)) {
						$all_channels_array[] = $channel_package->channel_id;
					}
				}
			}


			// find all group 
			$sql_group = "SELECT * FROM `channel_group` ORDER BY position";

			$query_group = $this->db->query($sql_group);
			$groups_array = array();
			foreach ($query_group->result() as $group) {
				// Find all channels in each group 
				$sql_channel_group = "Select ch.*,l.name as language_name  From channel ch 
				JOIN channel_to_group cg on ch.id=cg.channel_id 
				LEFT JOIN languages l on l.id=ch.language_id 
				WHERE cg.group_id = '$group->id' AND ch.status=1";

				$query_sql_channel_group = $this->db->query($sql_channel_group);
				$channels_array = array();

				if (count($query_sql_channel_group->result()) > 0) {
					foreach ($query_sql_channel_group->result() as $channel) {



						if (in_array($channel->id, $all_channels_array)) {
							$url_high = rtrim($this->channels_m->get_server_url_by_id($channel->server_url_high), "/");

							if ($url_high != NULL) {
								$url_high = $url_high . "/" . $channel->url_high . "/" . CHANNEL_EXT;
							} else {
								$url_high = $url_high . $channel->url_high;
							}

							$url_low = rtrim($this->channels_m->get_server_url_by_id($channel->server_url_low), "/");
							if ($url_low != NULL) {
								$url_low = $url_low . "/" . $channel->url_low . "/" . CHANNEL_EXT;
							} else {
								$url_low . $channel->url_low;
							}

							$url_interactivetv = rtrim($this->channels_m->get_server_url_by_id($channel->server_url_interactivetv), "/");

							if ($url_interactivetv != NULL) {
								$url_interactivetv = $url_interactivetv . "/" . $channel->url_interactivetv . "/" . INTERACTIVE_CHANNEL_EXT;
							} else {
								$url_interactivetv = $url_interactivetv . $channel->url_interactivetv;
							}

							$url_standard = rtrim($this->channels_m->get_server_url_by_id($channel->server_standard), "/");

							if ($url_standard != NULL)
								$url_standard = $url_standard . "/";

							$url_ios_tvos = rtrim($this->channels_m->get_server_url_by_id($channel->server_ios_tvos), "/");

							if ($url_ios_tvos != NULL)
								$url_ios_tvos = $url_ios_tvos . "/";

							$url_tizen_webos = rtrim($this->channels_m->get_server_url_by_id($channel->server_tizen_webos), "/");

							if ($url_tizen_webos != NULL)
								$url_tizen_webos = $url_tizen_webos . "/";


							array_push(
								$channels_array,
								array(
									'channel_id' => (int)$channel->id,
									'language_id' => (int)$channel->language_id,
									'language' => $channel->language_name,
									'channel_number' => (int)$channel->channel_number,
									'name' => $channel->channel_name,
									'url_high' => $url_high,
									//'toktype_high' => $this->channels_m->get_token_code_by_id($channel->token_high),
									//NO NEEDED URL LOW NO MORE USING
									//'url_low' => $url_low,
									//'toktype_low' => $this->channels_m->get_token_code_by_id($channel->token_low),
									'url_interactivetv' => $url_interactivetv,
									//'toktype_interactive' => $this->channels_m->get_token_code_by_id($channel->token_interactivetv),
									'standard_url' => $url_high, //TODO
									'ios_tvos' => $url_high,
									'tizen_webos' => $url_high,
									// 'standard_url'=>$url_standard.$channel->url_standard,
									//'ios_tvos'=>$url_ios_tvos.$channel->url_ios_tvos,
									//'tizen_webos'=>$url_tizen_webos.$channel->url_tizen_webos,
									'is_flussonic' => (int)$channel->is_flussonic,
									'is_dveo' => 0,
									'icon' => $channel->channel_image != null ? $channel->channel_image : 'default.jpeg',
									'icon_small' => $channel->channel_image != null ? $channel->channel_image : 'default.jpeg',
									'icon_big' => $channel->channel_image != null ? $channel->channel_image : 'default.jpeg',
									'preroll_enabled' => (int)$channel->preroll_enabled,
									'overlay_enabled' => (int)$channel->overlay_enabled,
									'ticker_enabled' => (int)$channel->ticker_enabled,
									'childlock' => (int)$channel->childlock,
									'flusonnic' => (int)$channel->is_flussonic,
									'secure_stream' => $this->channels_m->get_token_code_by_id($channel->token_high) == 'secure_stream' ? true : false,
									'akamai_token' => $this->channels_m->get_token_code_by_id($channel->token_high) == 'akamai_token' ? true : false,
									'flussonic_token' => $this->channels_m->get_token_code_by_id($channel->token_high) == 'flussonic_token' ? true : false,
									'drm_stream' => false,
									'drm_rewrite_rule' => null,
									'dvr_offset' => (int)$channel->dvr_offset,
									'rule_payperview' => array(
										'id' => 0,
										'name' => null,
										'type' => null,
										'quantity' => 0
									),
									'is_kids_friendly' => ($channel->is_kids_friendly == 0) ? false : true,
									'vast' => null,
									'drm' => array(
										'drm_type' => null,
										'drm_rewrite_rule' => null
									)
								)
							);
						}
						//$all_channels_group_array = array_merge($all_channels_group_array, $channels_array);

					}
					if (!empty($channels_array)) {
						array_push($groups_array, array(
							'id' => (int)$group->id + 1,
							'name' => $group->name,
							'position' =>  -(int)($group->position + 1),
							'channels' => $channels_array
						));
					}
					$all_channels_group_array = array_merge($all_channels_group_array, $channels_array);
				}
			}

			$all_channels_group_array = array_unique($all_channels_group_array, SORT_REGULAR);
			$key_values = array_column($all_channels_group_array, 'channel_number');
			array_multisort($key_values, SORT_ASC, $all_channels_group_array);

			array_unshift($groups_array, array(
				'id' => 1,
				'name' => "All Channels",
				'position' => -1,
				'channels' => $all_channels_group_array
				//'channels' => $all_channels_array
			));


			//$final_array_with_all =  array_merge($groups_array, $all_channels_group_array);

			$main_array = array(
				'ServerTime' => $server_time,
				'tv' => $groups_array
			);

			$filename = $product->id . '_product_channels_v2.json';
			$localFilePath = LOCAL_PATH_CRM . $filename;

			//  Encryption 
			$final_json_output = json_encode($main_array, JSON_UNESCAPED_SLASHES);
			//$final['CID'] = encrypt($final_json_output, 2);
			if (ENCRYPT_JSON == 1)
				$final['CID'] = encrypt($final_json_output, 2);
			else
				$final = $main_array;

			$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);

			$fp = fopen($localFilePath, 'w');
			fwrite($fp, $return_array);
			fclose($fp);


			$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'crm');

			//	echo '<pre>';
			//	print_r($main_array);
			//	exit;
		}
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save($id, $data);
	}

	//version 3 and 2 with no more all channels 
	public function createJsonChannelPackages($id)
	{
		$this->createJsonUpdate("channel");
		$this->createJsonPackages();
		check_allow('create', $this->data['is_allow']);
		$server_time = date('Y-m-d H:i:s');

		// get the total products in the system
		$sql = "Select * FROM products";
		$query = $this->db->query($sql);

		foreach ($query->result() as $product) {
			$all_channels_group_array = array();
			//get all channel packages
			$sql_pkg = "Select cp.id From channel_package cp 
			JOIN product_to_packages pp on pp.package_id=cp.id
			WHERE pp.product_id=" .  $product->id;

			$query_pkg = $this->db->query($sql_pkg);
			$all_channels_array = array();
			//Get all channel package loop 
			foreach ($query_pkg->result() as $tv) {

				//get all channel in package 
				$channel_in_package = "Select c.id channel_id,l.name as language_name From channel c
						LEFT JOIN languages l on l.id=c.language_id
						 JOIN package_to_channel cg on cg.channel_id=c.id  
						 WHERE cg.package_id='$tv->id' AND status = 1";

				$querry_channel_in_package = $this->db->query($channel_in_package);

				foreach ($querry_channel_in_package->result() as $channel_package) {

					//add to array if channel is not exist 
					if (!in_array($channel_package->channel_id, $all_channels_array)) {
						$all_channels_array[] = $channel_package->channel_id;
					}
				}
			}


			// find all group 
			$sql_group = "SELECT * FROM `channel_group` ORDER BY position";

			$query_group = $this->db->query($sql_group);
			$groups_array = array();
			foreach ($query_group->result() as $group) {
				// Find all channels in each group 
				$sql_channel_group = "Select ch.*,l.name as language_name  From channel ch 
				JOIN channel_to_group cg on ch.id=cg.channel_id 
				LEFT JOIN languages l on l.id=ch.language_id 
				WHERE cg.group_id = '$group->id' AND ch.status=1";

				$query_sql_channel_group = $this->db->query($sql_channel_group);
				$channels_array = array();

				if (count($query_sql_channel_group->result()) > 0) {
					foreach ($query_sql_channel_group->result() as $channel) {



						if (in_array($channel->id, $all_channels_array)) {
							$url_high = rtrim($this->channels_m->get_server_url_by_id($channel->server_url_high), "/");

							if ($url_high != NULL) {
								$url_high = $url_high . "/" . $channel->url_high . "/" . CHANNEL_EXT;
							} else {
								$url_high = $url_high . $channel->url_high;
							}

							$url_low = rtrim($this->channels_m->get_server_url_by_id($channel->server_url_low), "/");
							if ($url_low != NULL) {
								$url_low = $url_low . "/" . $channel->url_low . "/" . CHANNEL_EXT;
							} else {
								$url_low . $channel->url_low;
							}

							$url_interactivetv = rtrim($this->channels_m->get_server_url_by_id($channel->server_url_interactivetv), "/");

							if ($url_interactivetv != NULL) {
								$url_interactivetv = $url_interactivetv . "/" . $channel->url_interactivetv . "/" . INTERACTIVE_CHANNEL_EXT;
							} else {
								$url_interactivetv = $url_interactivetv . $channel->url_interactivetv;
							}

							$url_standard = rtrim($this->channels_m->get_server_url_by_id($channel->server_standard), "/");

							if ($url_standard != NULL)
								$url_standard = $url_standard . "/";

							$url_ios_tvos = rtrim($this->channels_m->get_server_url_by_id($channel->server_ios_tvos), "/");

							if ($url_ios_tvos != NULL)
								$url_ios_tvos = $url_ios_tvos . "/";

							$url_tizen_webos = rtrim($this->channels_m->get_server_url_by_id($channel->server_tizen_webos), "/");

							if ($url_tizen_webos != NULL)
								$url_tizen_webos = $url_tizen_webos . "/";


							array_push(
								$channels_array,
								array(
									'channel_id' => (int)$channel->id,
									'language_id' => (int)$channel->language_id,
									'language' => $channel->language_name,
									'channel_number' => (int)$channel->channel_number,
									'name' => $channel->channel_name,
									'url_high' => $url_high,
									//'toktype_high' => $this->channels_m->get_token_code_by_id($channel->token_high),
									//NO NEEDED URL LOW NO MORE USING
									//'url_low' => $url_low,
									//'toktype_low' => $this->channels_m->get_token_code_by_id($channel->token_low),
									'url_interactivetv' => $url_interactivetv,
									//'toktype_interactive' => $this->channels_m->get_token_code_by_id($channel->token_interactivetv),
									'standard_url' => $url_high, //TODO
									'ios_tvos' => $url_high,
									'tizen_webos' => $url_high,
									// 'standard_url'=>$url_standard.$channel->url_standard,
									//'ios_tvos'=>$url_ios_tvos.$channel->url_ios_tvos,
									//'tizen_webos'=>$url_tizen_webos.$channel->url_tizen_webos,
									'is_flussonic' => (int)$channel->is_flussonic,
									'is_dveo' => 0,
									'icon' => $channel->channel_image != null ? $channel->channel_image : 'default.jpeg',
									'icon_small' => $channel->channel_image != null ? $channel->channel_image : 'default.jpeg',
									'icon_big' => $channel->channel_image != null ? $channel->channel_image : 'default.jpeg',
									'preroll_enabled' => (int)$channel->preroll_enabled,
									'overlay_enabled' => (int)$channel->overlay_enabled,
									'ticker_enabled' => (int)$channel->ticker_enabled,
									'childlock' => (int)$channel->childlock,
									'flusonnic' => (int)$channel->is_flussonic,
									'secure_stream' => $this->channels_m->get_token_code_by_id($channel->token_high) == 'secure_stream' ? true : false,
									'akamai_token' => $this->channels_m->get_token_code_by_id($channel->token_high) == 'akamai_token' ? true : false,
									'flussonic_token' => $this->channels_m->get_token_code_by_id($channel->token_high) == 'flussonic_token' ? true : false,
									'drm_stream' => false,
									'drm_rewrite_rule' => null,
									'dvr_offset' => (int)$channel->dvr_offset,
									'rule_payperview' => array(
										'id' => 0,
										'name' => null,
										'type' => null,
										'quantity' => 0
									),
									'is_kids_friendly' => ($channel->is_kids_friendly == 0) ? false : true,
									'vast' => null,
									'drm' => array(
										'drm_type' => null,
										'drm_rewrite_rule' => null
									)
								)
							);
						}
						//$all_channels_group_array = array_merge($all_channels_group_array, $channels_array);

					}
					
					
					// Sort channels_array by channel_number before adding to groups_array
					$channel_numbers = array_column($channels_array, 'channel_number');
					array_multisort($channel_numbers, SORT_ASC, $channels_array);
					
					if (!empty($channels_array)) {
						array_push($groups_array, array(
							'id' => (int)$group->id + 1,
							'name' => $group->name,
							'position' =>  -(int)($group->position + 1),
							'channels' => $channels_array
						));
					}
					//$all_channels_group_array = array_merge($all_channels_group_array, $channels_array);
				}
			}

// 			 $groups_array = array_unique($groups_array, SORT_REGULAR);
// 			 $key_values = array_column($groups_array, 'channel_number');
// 			array_multisort($key_values, SORT_ASC, $groups_array);

			// array_unshift($groups_array, array(
			// 	'id' => 1,
			// 	'name' => "All Channels",
			// 	'position' => -1,
			// 	'channels' => $all_channels_group_array
			// 	//'channels' => $all_channels_array
			// ));


			//$final_array_with_all =  array_merge($groups_array, $all_channels_group_array);

			$main_array = array(
				'ServerTime' => $server_time,
				'tv' => $groups_array
			);
		//version 2
			$filename = $product->id . '_product_channels_v2.json';
			$localFilePath = LOCAL_PATH_CRM . $filename;
			$return_array = json_encode($main_array, JSON_UNESCAPED_SLASHES);
			$fp = fopen($localFilePath, 'w');
			fwrite($fp, $return_array);
			fclose($fp);
			$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'crm');

		//Version 3
			$filename = $product->id . '_product_channels_v3.json';
			$localFilePath = LOCAL_PATH_CRM . $filename;
			$final = $main_array;
			$return_array = json_encode($main_array, JSON_UNESCAPED_SLASHES);
			$fp = fopen($localFilePath, 'w');
			fwrite($fp, $return_array);
			fclose($fp);
			$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'crm');

			
		}
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save($id, $data);
	}

	public function createJsonMusicPackage($id)
	{
		$this->createJsonUpdate("album");
		check_allow('create', $this->data['is_allow']);
		$this->load->model('music_categories_m');

		// get the total products in the system
		$sql = "Select * FROM products";
		$query = $this->db->query($sql);

		foreach ($query->result() as $product) {

			// get all Music Categories  
			$server_time = date('Y-m-d H:i:s');

			$categories = $this->music_categories_m->get();
			$categories_array = array();
			foreach ($categories as $category) {
				// get all albums with the category_id
				$sql = "SELECT * FROM albums WHERE category_id=?";
				$query = $this->db->query($sql, $category['id']);
				$album_array = array();

				foreach ($query->result() as $album) {
					//get all songs with the album_id
					$sql_songs = "SELECT * FROM songs WHERE album_id=?";
					$query_songs = $this->db->query($sql_songs, $album->id);
					$songs_array = array();
					foreach ($query_songs->result() as $song) {

						$url = rtrim($this->channels_m->get_server_url_by_id($song->server_url_id), "/");
						if ($url != NULL)
							$url = $url . "#";

						array_push(
							$songs_array,
							array(
								'id' => (int)$song->id,
								'name' => $song->name,
								'url' => $url . $song->url,
								// 'toktype'=>$this->channels_m->get_token_code_by_id($song->token_id),
								'secure_stream' => ($song->secure_stream == 0) ? false : true,
								'has_drm' => ($song->has_drm == 0) ? false : true
							)
						);
					}

					array_push(
						$album_array,
						array(
							'id' => (int)$album->id,
							'name' => $album->name,
							'description' => $album->description,
							'poster' => $album->cover,
							'artist' => $album->artist,
							'songs' => $songs_array,
							'prices' => array(),
							'is_payperview' => ($album->is_payperview == 0) ? false : true,
							'rule_payperview' => $album->rule_payperview,
							'is_kids_friendly' => ($album->is_kids_friendly == 0) ? false : true
						)
					);
				}
				array_push(
					$categories_array,
					array(
						'id' => (int)$category['id'],
						'name' => $category['name'],
						'albums' => $album_array
					)
				);

				$main_array = array(
					'ServerTime' => $server_time,
					'categories' => $categories_array
				);

				$filename = $product->id . '_product_albums_v2.json';
				$localFilePath = LOCAL_PATH_CRM . $filename;

				/* Encryption */
				$final_json_output = json_encode($main_array, JSON_UNESCAPED_SLASHES);
				//$final['CID'] = encrypt($final_json_output, 2);

				if (ENCRYPT_JSON == 1)
					$final['CID'] = encrypt($final_json_output, 2);
				else
					$final = $main_array;

				$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);

				$fp = fopen($localFilePath, 'w');
				fwrite($fp, $return_array);
				fclose($fp);

				//$this->uploadToServer($filename,$localFilePath,'jsons/music');


				$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'crm');
			}
		}

		// insert into tables
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save($id, $data);
	}

	public function createJsonProductApps($id)
	{
		$this->createJsonUpdate("app");
		check_allow('create', $this->data['is_allow']);
		$this->load->model('app_categories_m');
		$server_time = date('Y-m-d H:i:s');

		// get the total products in the system
		$sql = "Select * FROM products";
		$query = $this->db->query($sql);

		foreach ($query->result() as $product) {
			// get all App Categories  
			$appcategories = $this->app_categories_m->get();
			$categories_array = array();
			foreach ($appcategories as $category) {
				// get all apps with the category_id
				$sql = "SELECT * FROM app WHERE category_id=?";
				$query = $this->db->query($sql, $category['id']);
				$apps_array = array();

				foreach ($query->result() as $app) {
					$url = rtrim($this->channels_m->get_server_url_by_id($app->server_url_id), "/");

					if ($url != NULL)
						$url = $url . "#";

					array_push(
						$apps_array,
						array(
							'id' => (int)$app->id,
							'description' => $app->description,
							'icon' => $app->icon,
							'url' => $url . $app->url,
							'toktype' => $this->channels_m->get_token_code_by_id($app->token_id),
							'appname' => $app->name
						)
					);
				}
				array_push(
					$categories_array,
					array(
						'id' => (int)$category['id'],
						'name' => $category['name'],
						'apps' => $apps_array
					)
				);

				$main_array = array(
					'ServerTime' => $server_time,
					'appcategories' => $categories_array
				);

				$filename = $product->id . '_product_apps_v2.json';
				$localFilePath = LOCAL_PATH_CRM . $filename;

				/* Encryption */
				$final_json_output = json_encode($main_array, JSON_UNESCAPED_SLASHES);

				/*$final['CID'] = encrypt($final_json_output, 2);*/
				if (ENCRYPT_JSON == 1)
					$final['CID'] = encrypt($final_json_output, 2);
				else
					$final = $main_array;

				$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);

				$fp = fopen($localFilePath, 'w');
				fwrite($fp, $return_array);
				fclose($fp);

				//$this->uploadToServer($filename,$localFilePath,'jsons/app');


				$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'crm');
			}
		}
		// insert into tables
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save($id, $data);
	}
	//removing substore

	public function createJsonTags($id)
	{
		$this->createJsonUpdate("movie");
		check_allow('create', $this->data['is_allow']);

		// get the total products in the system
		$sql = "Select * FROM products";
		$query = $this->db->query($sql);
		$series_array = array();


		foreach ($query->result() as $product) {

			//get all Tags
			$sql_tag = "Select * FROM movie_tags";
			$query_tag = $this->db->query($sql_tag);

			$tags_array = array();

			foreach ($query_tag->result() as $tag) {


				// get Movies 
				$sql_movies = "SELECT * FROM (SELECT * FROM movie
										WHERE store_id IN ( 
										SELECT id from movie_store 
										WHERE id IN (
										SELECT vod_store_id 
										FROM products p 
										JOIN product_to_vod_stores pvs on p.id=pvs.product_id 
										WHERE p.id=" . $product->id . "))) x
							JOIN (select movie_id from movie_to_tags mt 
								JOIN movie_tags mts on mts.id=mt.tag_id
								WHERE mt.tag_id=" . $tag->id . ") y on x.id=y.movie_id ORDER BY RAND() LIMIT 75";


				$query_movies = $this->db->query($sql_movies);
				$movies_array = array();


				foreach ($query_movies->result() as $movie) {
					array_push(
						$movies_array,
						array(
							'id' => $movie->id,
							'name' => $movie->name,
							'image' => CDN_LOCATION_FOR_IMAGE . $movie->poster,
							'language_id' => $movie->language
							
						)
					);
				}

				array_push(
					$tags_array,
					array(
						'tag' => $tag->name,
						'movies' => $movies_array,
						'series' => $series_array

					)
				);
			}

			$main_array = $tags_array;

			$filename = $product->id . '_tags.json';
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

			//$this->uploadToServer($filename,$localFilePath,$cdn_path);
		}

		// insert into tables
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save($id, $data);
	}



	public function createJsonLanguages($id)
	{
		check_allow('create', $this->data['is_allow']);
		$this->load->model('language_m');


		// get all Devices 
		$server_time = date('Y-m-d H:i:s'); //2019-07-21T15:12:01.213422+00:00

		$languages = $this->language_m->get();

		$language_array = array();

		foreach ($languages as $language) {
	        $language_array[] = array(
	            'id' => $language['id'],
	            'name' => $language['name']
	        );
   		}


		$filename = 'language.json';
		$localFilePath = LOCAL_PATH_CMS . $filename;
		$main_array = $language_array;
		/* Encryption */
		$final_json_output = json_encode($language_array, JSON_UNESCAPED_SLASHES);
		//$final['CID'] = encrypt($final_json_output, 2);

		if (ENCRYPT_JSON == 1)
			$final['CID'] = encrypt($final_json_output, 2);
		else
			$final = $main_array;

		$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);

		$fp = fopen($localFilePath, 'w');
		fwrite($fp, $return_array);
		fclose($fp);

		$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'cms');
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
			//$localFilePath= $localFilePath.time();
			$fp = fopen($localFilePath, 'w');
			fwrite($fp, $return_array);
			fclose($fp);
			$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'crm');
		}
	}
}
/* End of file Publish.php */
/* Location: ./application/controllers/Publish.php */
