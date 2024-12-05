<?php
defined('BASEPATH') or exit('No direct script access allowed');

class publish_vod_classic_ims extends User_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow'] = check_permission(28);
        $this->load->model('publish_vod_classic_ims_m');
        $this->data['main_nav'] = "publish_vod_classic_ims";
    }

    public function index()
    {
        check_allow('view', $this->data['is_allow']);

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'publish_vod_classic_ims/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'publish_vod_classic_ims/index';
        $this->data['page_title'] = "Publish Classic IMS VOD";
        $this->data['modules'] = $this->publish_vod_classic_ims_m->get();
        $this->load->view(DEFAULT_THEME . '_layout', $this->data);
    }

    public function updateAll()
    {
        check_allow('edit', $this->data['is_allow']);
        $this->createJsonMovieDetails(2, true);
        $this->createJsonSeriesDetails(2, true);
        $this->createJsonSeriesInStoreCategoryWebSeries(1);
        $this->createJsonSeriesInStoreCategoryTvShow(1);
        $this->createJsonmoviesInStoreCategory(2);
        $this->createJsonSeriesGenresWebSeries(3);
        $this->createJsonSeriesGenresTvShow(3);
    

        $this->session->set_flashdata('success', "All Json Files Published Successfully.");
        redirect(BASE_URL . 'publish_vod_classic_ims');
    }

    public function create($id)
    {
        //	check_allow('create', $this->data['is_allow']);
        switch ($id) {


            case 1:
                $this->createJsonMovieDetails($id);
                $this->createJsonSeriesDetails($id);
                $this->createJsonSeriesInStoreCategoryWebSeries($id);
                $this->createJsonSeriesInStoreCategoryTvShow($id);
                $this->createJsonmoviesInStoreCategory($id);

                $this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish_vod_classic_ims') . '" target="_blank">Only New VOD UPdate(Use Only for New VOD)</a>');
                $this->session->set_flashdata('success', "1. Only New VOD UPdate(Use Only for New VOD) Created Successfully.");
                redirect(BASE_URL . 'publish_vod_classic_ims');
                break;
            case 2:
                $this->createJsonMovieDetails($id,true);
                $this->createJsonSeriesDetails($id,true);
                $this->createJsonSeriesInStoreCategoryWebSeries($id);
                $this->createJsonSeriesInStoreCategoryTvShow($id);
                $this->createJsonmoviesInStoreCategory($id);
                
                $this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish_vod_classic_ims') . '" target="_blank">2. All VOD Update (Use for Update and New VOD)</a>');
                $this->session->set_flashdata('success', "2. All VOD Update (Use for Update and New VOD) Created Successfully.");
                redirect(BASE_URL . 'publish_vod_classic_ims');
                break;
            case 3:
                //MOVIES WORKING
                 $this->createJsonMovieGenres($id); 
                 $this->createJsonMoviesInStoreCategory($id);
                
                //Web-Series FAIL
                 $this->createJsonSeriesGenresWebSeries($id);
                 $this->createJsonSeriesInStoreCategoryWebSeries($id);
                 
                 //TV SHOW
                 $this->createJsonSeriesGenresTvShow($id);
                 $this->createJsonSeriesInStoreCategoryTvShow($id);
               
               
               
               
               
             
                $this->userlogs->track_this($this->session->user_id, '<a href="' . site_url('publish_vod_classic_ims') . '" target="_blank">Stores and Categories(Use when new Store or Categories)</a>');
                $this->session->set_flashdata('success', "3. Stores and Categories (Use when new Store or Categories) Created Successfully.");
                redirect(BASE_URL . 'publish_vod_classic_ims');
                break;
        }
    }




    /**
     * Helper function to write JSON to a file.
     */

    private function writeJsonFile($filename, $data)
    {
        $directory = CLASSIC_IMS_VOD_LOCATION;
       
        // Check if the directory exists
        if (!is_dir($directory)) {
            // Attempt to create the directory
            if (!mkdir($directory, 0755, true)) {
                throw new Exception("Failed to create directory: $directory");
            }
        }
    
        // Ensure the directory path ends with a directory separator
        $directory = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    
        $localFilePath = $directory . $filename;
    
        $final_json_output = json_encode(json_encode($data, JSON_UNESCAPED_SLASHES));
    
        // Write the JSON data to the file
        if (file_put_contents($localFilePath, $final_json_output) === false) {
            throw new Exception("Failed to write to file: $localFilePath");
        }
    }

    // //NO needed...it will create in classic IMS ID_stores.json
    public function createJsonMovieStores($id)
    {
        check_allow('create', $this->data['is_allow']);
        $server_time = date('Y-m-d\TH:i:s.u\Z'); // Use ISO 8601 format

        // Get the total stores in the system
        $sql = "SELECT * FROM movie_store WHERE active = 1";
        $query = $this->db->query($sql);

        foreach ($query->result() as $store) {
            $stores_array = array();

            // Determine subid value based on parent_id
            $subid = ($store->parent_id == 0) ? "1" : "0";

            array_push(
                $stores_array,
                array(
                    'id' => (int)$store->id,
                    'name' => $store->name,
                    'logo' => $store->logo,
                    'childlock' => (int)$store->childlock,
                    'subid' => $subid,
                    'position' => (int)$store->position,
                    'spotlight' => 0
                )
            );

            $main_array = array(
                'ServerTime' => $server_time,
                'vodstores' => $stores_array
            );

            $filename = $store->id . '_stores.json';
            $this->writeJsonFile($filename, $main_array);
        }

        // Insert into tables
        $data = array('last_update' => date('Y-m-d H:i:s'));
        $this->publish_vod_classic_ims_m->save($id, $data);
    }


    //It is Not needed. it will create in Classic IMS
    //manually created store web sereis 1001_stores.json , and TV SHOW 1002_stores.json and all store from series store .
    public function createJsonSeriesStores($id)
    {
        check_allow('create', $this->data['is_allow']);
        $server_time = date('Y-m-d\TH:i:s.u\Z'); // Use ISO 8601 format

        // Create first constant file
        $stores_array_1001 = array(
            array(
                'id' => 1001,
                'name' => 'WEB SERIES',
                'logo' => 'web_series1001.png',
                'childlock' => 1,
                'subid' => '0', // 1 if parent_id data is 0 if not then 1 
                'position' => 2,
                'spotlight' => 0
            )
        );

        $main_array_1001 = array(
            'ServerTime' => $server_time,
            'vodstores' => $stores_array_1001
        );

        $filename_1001 = '1001_stores.json';
        $this->writeJsonFile($filename_1001, $main_array_1001);

        // Create second constant file
        $stores_array_1002 = array(
            array(
                'id' => 1002,
                'name' => 'TV SHOW',
                'logo' => 'tv_Show1002.png',
                'childlock' => 1,
                'subid' => '1',
                'position' => 2,
                'spotlight' => 0
            )
        );

        $main_array_1002 = array(
            'ServerTime' => $server_time,
            'vodstores' => $stores_array_1002
        );

        $filename_1002 = '1002_stores.json';
        $this->writeJsonFile($filename_1002, $main_array_1002);

        // Get the total series stores in the system from the database
        $sql = "SELECT * FROM series_store WHERE active = 1";
        $query = $this->db->query($sql);

        foreach ($query->result() as $store) {
            $stores_array = array();

            // Determine subid value based on parent_id
            // $subid = ($store->parent_id == 0) ? "1" : "0";

            array_push(
                $stores_array,
                array(
                    'id' => (int)$store->id + 9000000,
                    'name' => $store->name,
                    'logo' => $store->logo,
                    'childlock' => (int)$store->childlock,
                    'subid' => 0,
                    'position' => (int)$store->position,
                    'spotlight' => 0
                )
            );

            $main_array = array(
                'ServerTime' => $server_time,
                'vodstores' => $stores_array
            );

            $filename = $store->id + 9000000 . '_stores.json';
            $this->writeJsonFile($filename, $main_array);
        }

        // Insert into tables
        $data = array('last_update' => date('Y-m-d H:i:s'));
        $this->publish_vod_classic_ims_m->save($id, $data);
    }


    //ID_sub_stores.json
    public function createJsonMovieSubStores($id)
    {
        check_allow('create', $this->data['is_allow']);
        $server_time = date('Y-m-d\TH:i:s.u\Z'); // Use ISO 8601 format

        // Get the total stores in the system where parent_id = 0
        $sql = "SELECT * FROM movie_store WHERE parent_id = 0 AND active = 1";
        $query = $this->db->query($sql);

        foreach ($query->result() as $store) {
            // Get substores
            $sql_substores = "SELECT * FROM movie_store WHERE parent_id='$store->id' AND active=1";
            $query_substores = $this->db->query($sql_substores);

            $substores = array();
            if ($query_substores->num_rows() > 0) {
                foreach ($query_substores->result() as $substore) {
                    array_push(
                        $substores,
                        array(
                            'id' => (int)$substore->id,
                            'name' => $substore->name,
                            'logo' => $substore->logo,
                            'childlock' => (int)$substore->childlock,
                            'subid' => "0",
                            'position' => (int)$substore->position,
                            'spotlight' => 0
                        )
                    );
                }
            } else {
                // If no substores found, add the store itself as a substore
                array_push(
                    $substores,
                    array(
                        'id' => (int)$store->id,
                        'name' => $store->name,
                        'logo' => $store->logo,
                        'childlock' => (int)$store->childlock,
                        'subid' => "0",
                        'position' => (int)$store->position,
                        'spotlight' => 0
                    )
                );
            }

            $main_array = array(
                'ServerTime' => $server_time,
                'vodstores' => $substores
            );

            $filename = $store->id . '_sub_stores.json';
            $this->writeJsonFile($filename, $main_array);
        }

        // Insert into tables
        $data = array('last_update' => date('Y-m-d H:i:s'));
        $this->publish_vod_classic_ims_m->save($id, $data);
    }


    //ID_store_categories.json
    //@rob update old system 
public function createJsonMovieGenres($id)
{
    // Ensure necessary permissions and settings
    check_allow('create', $this->data['is_allow']);
    // Get the current server time
    $server_time = date('Y-m-d H:i:s');
    // Query to get all movie stores
    $sql_store = "SELECT * FROM movie_store";
    $store_query = $this->db->query($sql_store);
    // Iterate over each store
    foreach ($store_query->result() as $store) {
        // Initialize the vodgenres array with the two additional entries
        $vodgenres = array(
            array('id' => '1', 'name' => 'Recently Added'),
            array('id' => '2', 'name' => 'New Release')
        );

        // Query to get all movie genres
        $sql_genre = "SELECT * FROM movie_genre ORDER BY order_no";
        $genre_query = $this->db->query($sql_genre);

        // Iterate over each genre and add to the vodgenres array if movie count > 0
        foreach ($genre_query->result() as $genre) {
            // Check if there are movies associated with this genre and store's language
            $sql_movie_count = "SELECT COUNT(*) as count FROM movie WHERE FIND_IN_SET(?, select_genres) > 0 AND language = ?";
            $movie_count_query = $this->db->query($sql_movie_count, array($genre->id, $store->language_id));
            $movie_count = $movie_count_query->row()->count;

            if ($movie_count > 2) {
                array_push($vodgenres, array(
                    'id' => $genre->id + 2, // Adjust ID by adding 2
                    'name' => $genre->name,
                    'count' => $movie_count,
                ));
            }
            // If movie count is 0, skip adding this genre
        }

        /*** Add movie_ott_platforms to vodgenres ***/
        // Query to get all movie OTT platforms
        $sql_platform = "SELECT * FROM movie_ott_platforms ORDER BY order_no";
        $platform_query = $this->db->query($sql_platform);

        // Iterate over each platform and add to the vodgenres array if movie count > 0
        foreach ($platform_query->result() as $platform) {
            // Check if there are movies associated with this platform and store's language
            $sql_movie_count = "SELECT COUNT(*) as count FROM movie WHERE FIND_IN_SET(?, ott_platforms) > 0 AND language = ?";
            $movie_count_query = $this->db->query($sql_movie_count, array($platform->id, $store->language_id));
            $movie_count = $movie_count_query->row()->count;

            if ($movie_count > 2) {
                array_push($vodgenres, array(
                    'id' => $platform->id + 500, // Adjust ID by adding 500
                    'name' => $platform->name,
                    'count' => $movie_count,
                ));
            }
            // If movie count is 0, skip adding this platform
        }

        // Prepare the main array to be encoded as JSON
        $main_array = array(
            'ServerTime' => $server_time,
            'StoreName' => $store->name,
            'vodgenres' => $vodgenres
        );
        // Define the filename and local file path
        $filename = $store->id . '_store_categories.json';
        $this->writeJsonFile($filename, $main_array);
    }
    // Update the last update time in the database
    $data = array('last_update' => date('Y-m-d H:i:s'));
    $this->publish_vod_classic_ims_m->save($id, $data);
}



    // category ID _ Movie Store ID_ movies_store_category.json

public function createJsonMoviesInStoreCategory($id)
{
    $excludeGenre18FromCategory1 = true; // Set to false if you want to include genre ID 18 in Category ID 1

    check_allow('create', $this->data['is_allow']);
    $server_time = date('Y-m-d\TH:i:s.u\Z'); // Use ISO 8601 format

    // Get all active movie stores
    $sql_stores = "SELECT * FROM movie_store WHERE active = 1";
    $query_stores = $this->db->query($sql_stores);

    foreach ($query_stores->result() as $store) {

        /*** Category ID 1: Recently Added ***/
        // Get the 100 most recent movies ordered by id descending
        $this->db->select('*');
        $this->db->from('movie');
        $this->db->where('language', $store->language_id);
        $this->db->where('store_id', $store->id);
        if ($excludeGenre18FromCategory1) {
         $this->db->where("NOT FIND_IN_SET('18', REPLACE(select_genres, ' ', ''))");
        }
        $this->db->order_by('id', 'DESC');

        $this->db->limit(600);


        $query_movies = $this->db->get();

        $movies = array();
        foreach ($query_movies->result() as $movie) {
            array_push($movies, $this->formatMovie($movie));
        }

        $main_array = $this->prepareMainArray($server_time, $movies);

        $filename = '1_' . $store->id . '_movies_store_category.json';
        $this->writeJsonFile($filename, $main_array);

        /*** Category ID 2: New Releases ***/
        // Get movies ordered by year descending and id descending
        $this->db->select('*');
        $this->db->from('movie');
        $this->db->where('language', $store->language_id);
        $this->db->where('store_id', $store->id);
        $this->db->where("NOT FIND_IN_SET('18', REPLACE(select_genres, ' ', ''))");
        $this->db->order_by('year', 'DESC');
        $this->db->order_by('id', 'DESC');

        $this->db->limit(600);

        $query_movies = $this->db->get();

        $movies = array();
        foreach ($query_movies->result() as $movie) {
            array_push($movies, $this->formatMovie($movie));
        }

        $main_array = $this->prepareMainArray($server_time, $movies);

        $filename = '2_' . $store->id . '_movies_store_category.json';
        $this->writeJsonFile($filename, $main_array);

        /*** Adjusted Categories for Genres ***/
        // Get genres for the current movie store
        $sql_genres = "SELECT * FROM movie_genre ORDER BY order_no";
        $query_genres = $this->db->query($sql_genres);

        foreach ($query_genres->result() as $category) {
            $adjusted_category_id = $category->id + 2;

            // Get movies for the current genre and store's language
            $this->db->select('*');
            $this->db->from('movie');
            $this->db->where('language', $store->language_id);
            $this->db->where('store_id', $store->id);
            $this->db->where("select_genres IS NOT NULL AND select_genres <> ''");
            $this->db->where("FIND_IN_SET('{$category->id}', REPLACE(select_genres, ' ', '')) > 0");
            
            if ($category->id != 18) {
            $this->db->where("NOT FIND_IN_SET('18', REPLACE(select_genres, ' ', ''))");
            }
            
            $this->db->order_by('id', 'DESC');
            $query_movies = $this->db->get();

            // Check if movies exist for this genre
            if ($query_movies->num_rows() > 0) {
                $movies = array();
                foreach ($query_movies->result() as $movie) {
                    array_push($movies, $this->formatMovie($movie));
                }

                $main_array = $this->prepareMainArray($server_time, $movies);

                $filename = $adjusted_category_id . '_' . $store->id . '_movies_store_category.json';
                $this->writeJsonFile($filename, $main_array);
            }
        }

        /*** Adjusted Categories for movie_ott_platforms ***/
        // Get all entries from movie_ott_platforms
        $sql_platforms = "SELECT * FROM movie_ott_platforms ORDER BY order_no";
        $query_platforms = $this->db->query($sql_platforms);

        foreach ($query_platforms->result() as $platform) {
            $adjusted_category_id = $platform->id + 500; // Adjust ID by adding 500

            // Get movies associated with this platform and store's language
            $this->db->select('*');
            $this->db->from('movie');
            $this->db->where('language', $store->language_id);
            $this->db->where("ott_platforms IS NOT NULL AND ott_platforms <> ''");
            $this->db->where("FIND_IN_SET('{$platform->id}', REPLACE(ott_platforms, ' ', '')) > 0");
            $this->db->where("NOT FIND_IN_SET('18', REPLACE(select_genres, ' ', ''))");
            $this->db->order_by('id', 'DESC');
            $query_movies = $this->db->get();

            // Check if movies exist for this platform
            if ($query_movies->num_rows() > 0) {
                $movies = array();
                foreach ($query_movies->result() as $movie) {
                    array_push($movies, $this->formatMovie($movie));
                }

                $main_array = $this->prepareMainArray($server_time, $movies);

                $filename = $adjusted_category_id . '_' . $store->id . '_movies_store_category.json';
                $this->writeJsonFile($filename, $main_array);
            }
        }
    }

    // Update the last update time in the database
    $data = array('last_update' => date('Y-m-d H:i:s'));
    $this->publish_vod_classic_ims_m->save($id, $data);
}


    /**
     * Helper function to format a movie array.
     */
    private function formatMovie($movie)
    {
        return array(
            'id' => (int)$movie->id,
            'name' => $movie->name,
            // 'description' => $movie->description,
            // 'price' => "0", // static
            'poster' => $movie->poster,
            //  'year' => (!empty($movie->year) && strtotime($movie->year) !== false) ? (new DateTime($movie->year))->format('Y') : '0000',
            //  'rating' => isset($movie->rating) && is_numeric($movie->rating) ? round($movie->rating / 2) : 0, // default to 0 if not set or not numeric
            //  'isrented' => false, // static
            //  'isserie' => 0, // static
            // 'rentalid' => 0, // static
            //  'rentaldate' => "0001-01-01T00:00:00", // static
            //  'rentalenddate' => "0001-01-01T00:00:00" // static
        );
    }

    /**
     * Helper function to prepare the main array.
     */
    private function prepareMainArray($server_time, $movies)
    {
        return array(
            'ServerTime' => $server_time,
            'type' => "", // static
            'total' => count($movies),
            'count' => count($movies),
            'page' => 0, // static
            'movies' => $movies
        );
    }



    

    // Generate All Movies detail
    //create all movies $this->createJsonMovieDetails($id, true);    
    //create only new movies $this->createJsonMovieDetails($id); or $this->createJsonMovieDetails($id, false);
    public function createJsonMovieDetails($id, $processAll = false)
    {
        $server_time = date('Y-m-d H:i:s');
        check_allow('create', $this->data['is_allow']);
        $this->load->model('movies_m');

        $lastProcessedIdFile = CLASSIC_IMS_VOD_LOCATION . 'last_processed_movie_id.txt';

        if ($processAll) {
            // If processing all movies, set last processed ID to 0
            $lastProcessedId = 0;
        } else {
            // Read last processed ID from file
            if (file_exists($lastProcessedIdFile)) {
                $lastProcessedId = (int)file_get_contents($lastProcessedIdFile);
            } else {
                $lastProcessedId = 0; // If the file doesn't exist, start from ID 0
            }
        }

        // Build the query to fetch movies with language names
        $this->db->select('movie.*, languages.name as language_name');
        $this->db->from('movie');
        $this->db->join('languages', 'languages.id = movie.language', 'left');

        // Apply the condition based on whether we're processing all movies or not
        if (!$processAll) {
            $this->db->where('movie.id >', $lastProcessedId);
        }

        $query = $this->db->get();
        $movies = $query->result();

        // Initialize the max processed ID
        $maxProcessedId = $lastProcessedId;

        foreach ($movies as $movie) {
            // Update the max processed ID
            if ($movie->id > $maxProcessedId) {
                $maxProcessedId = $movie->id;
            }

            // Fetch the stream_name directly
            $stream_query = $this->db->select('stream_name')
                ->from('movie_stream_urls')
                ->where('movie_id', $movie->id)
                ->limit(1)
                ->get();

            $stream_name = ($stream_query->num_rows() > 0) ? $stream_query->row()->stream_name : '';

            $movie_array = array(
                'ServerTime'    => $server_time,
                'id'            => (int)$movie->id,
                'ximsid'        => "M".$movie->id,
                'name'          => stripslashes($movie->name),
                'description'   => stripslashes($movie->description),
                'poster'        => $movie->poster,
                'actors'        => $movie->actor,
                'length'        => (int)$movie->duration,
                'year'          => (!empty($movie->year) && strtotime($movie->year) !== false) ? (new DateTime($movie->year))->format('Y') : '0000',
                'rate_imdb'     => isset($movie->rating) && is_numeric($movie->rating) ? round($movie->rating / 2) : 0,
                'rating'        => isset($movie->rating) && is_numeric($movie->rating) ? round($movie->rating / 2) : 0,
                'language'      => $movie->language_name, // Now this will have the language name
                'is_serie'      => 0,
                'url'           => $stream_name,
                'trailerurl'    => $movie->server_url_trailer,
                'vod_tokenize'  => $movie->tokenize,
                'token_type'    => 'Akamai'
            );

            $filename = $movie->id . '_movie_details.json';
            $this->writeJsonFile($filename, $movie_array);
        }

        // Update the last processed ID only if not processing all movies
        
            file_put_contents($lastProcessedIdFile, $maxProcessedId);
      

        // Update the last_update timestamp
        $data = array('last_update' => date('Y-m-d H:i:s'));
        $this->publish_vod_classic_ims_m->save($id, $data);
    }


    //series movie details
    public function createJsonSeriesDetails($id, $processAll = false)
    {
        check_allow('create', $this->data['is_allow']);
        $server_time = date('Y-m-d H:i:s');
        $lastProcessedSeasonIdFile = CLASSIC_IMS_VOD_LOCATION . 'last_processed_series_season_id.txt';

        if ($processAll) {
            // If processing all series, set last processed season ID to 0
            $lastProcessedSeasonId = 0;
        } else {
            // Read last processed season ID from file
            if (file_exists($lastProcessedSeasonIdFile)) {
                $lastProcessedSeasonId = (int)file_get_contents($lastProcessedSeasonIdFile);
            } else {
                $lastProcessedSeasonId = 0; // If the file doesn't exist, start from ID 0
            }
        }

        // Initialize the max processed season ID
        $maxProcessedSeasonId = $lastProcessedSeasonId;


        // Get all series seasons with IDs greater than the last processed ID
        $sql_seasons = "SELECT ss.*, s.name as series_name
            FROM series_seasons ss
            JOIN series s ON ss.series_id = s.id
            WHERE ss.id > " . $this->db->escape($lastProcessedSeasonId);
        $query_seasons = $this->db->query($sql_seasons);

        foreach ($query_seasons->result() as $season) {

            // Update the max processed season ID
            if ($season->id > $maxProcessedSeasonId) {
                $maxProcessedSeasonId = $season->id;
            }

            // Get episodes for the current season, ordered by sequence_id
            $sql_episodes = "SELECT * FROM series_episode 
                         WHERE season_id = " . $this->db->escape($season->id) . " 
                         ORDER BY 
                         CASE 
                             WHEN sequence_id < 20 THEN sequence_id
                             ELSE -sequence_id 
                         END ASC";

            $query_episodes = $this->db->query($sql_episodes);
            $episodes = array();

            foreach ($query_episodes->result() as $episode) {
                array_push(
                    $episodes,
                    array(
                        'id' => (int)$episode->id,
                        'name' => stripslashes("Ep:" . $episode->sequence_id . " - " . $episode->title),
                        'url' => $episode->url,
                        // 'description' => $episode->description,
                        'sequenceid' => (int)$episode->sequence_id
                    )
                );
            }

            // Prepare series details
            $series_details = array(
                'ServerTime' => $server_time,
                'id' => (int)$season->id + 9000000,
                'ximsid' => "S".$season->id,
                'name' => stripslashes($season->series_name . ' - ' . $season->name),
                'description' => stripslashes($season->description),
                'poster' => $season->poster,
                'year' => (!empty($season->year) && strtotime($season->year) !== false) ? (new DateTime($season->year))->format('Y') : '0000',
                'rate_imdb'  => isset($season->rating) && is_numeric($season->rating) ? round($season->rating / 2) : 0, // default to 0 if not set or not numeric
                'rating' => isset($season->rating) && is_numeric($season->rating) ? round($season->rating / 2) : 0, // default to 0 if not set or not numeric
                'is_serie' => 1,
                'moviedescriptions' => array(),
                'movieseries' => $episodes,
                'vod_tokenize' => 0,
                'token_type' => 'Akamai'
            );

            $filename = 9000000 + $season->id . '_movie_details.json';
            $this->writeJsonFile($filename, $series_details);
        }
        // After processing, update the last processed season ID
        file_put_contents($lastProcessedSeasonIdFile, $maxProcessedSeasonId);

        // Update the last_update timestamp in the database
        $data = array('last_update' => date('Y-m-d H:i:s'));
        $this->publish_vod_classic_ims_m->save($id, $data);
    }



public function createJsonSeriesGenresWebSeries($id)
{
    check_allow('create', $this->data['is_allow']);
    $server_time = date('Y-m-d\TH:i:s.u\Z'); // Use ISO 8601 format

    // Get series stores where active = 1 and name does not contain 'TV SHOW'
    $sql = "SELECT * FROM series_store WHERE active = 1 AND name NOT LIKE '%TV SHOW%'";
    $query = $this->db->query($sql);
    $series_stores = $query->result();

    // Get all entries from series_ott_platforms
    $sql_ott = "SELECT * FROM series_ott_platforms";
    $ott_query = $this->db->query($sql_ott);
    $ott_platforms = $ott_query->result();

    foreach ($series_stores as $store) {
        $categories = array();

        // Manually add categories
        /*** Category ID 1: Recently Added ***/
        $categories[] = array(
            'id' => 1,
            'name' => 'Recently Added'
        );

        /*** Category ID 2: New Releases ***/
        $categories[] = array(
            'id' => 2,
            'name' => 'New Releases'
        );

        /*** Category ID 3: ALL ***/
        $categories[] = array(
            'id' => 3,
            'name' => 'ALL'
        );

        foreach ($ott_platforms as $ott_platform) {
            // Check if there are series associated with this ott_platform and store's language_id
            $sql_series = "SELECT COUNT(*) as count FROM series WHERE FIND_IN_SET(?, ott_platforms) > 0 AND language_id = ?";
            $series_query = $this->db->query($sql_series, array($ott_platform->id, $store->language_id));
            $series_count = $series_query->row()->count;

            if ($series_count > 0) {
                $category_data = array(
                    'id' => (int)$ott_platform->id + 9000000 + 3, // Adjust ID by adding 3
                    'name' => $ott_platform->name
                );
                array_push($categories, $category_data);
            }
            // If no series found, skip this ott_platform
        }

        // Always create the JSON file
        // Create JSON data
        $main_array = array(
            'ServerTime' => $server_time,
            'Name'=>$store->name,
            'vodgenres' => $categories
        );

        // Filename is (series_store id + 1000) + '_store_categories.json'
        $filename = (1000 + $store->id) . '_store_categories.json';
        $this->writeJsonFile($filename, $main_array);
    }

    // Insert into tables
    $data = array('last_update' => date('Y-m-d H:i:s'));
    $this->publish_vod_classic_ims_m->save($id, $data);
}

public function createJsonSeriesGenresTvShow($id)
{
    check_allow('create', $this->data['is_allow']);
    $server_time = date('Y-m-d\TH:i:s.u\Z'); // Use ISO 8601 format

    // Get series stores where active = 1 and name contains 'TV SHOW'
    $sql = "SELECT * FROM series_store WHERE active = 1 AND name LIKE '%TV SHOW%'";
    $store_query = $this->db->query($sql);
    $series_stores = $store_query->result();

    foreach ($series_stores as $store) {
        // Calculate the new filename based on store ID
        $filename = (2000 + $store->id) . '_store_categories.json';

        // Get tv_show_platforms where language_id matches the series_store's language_id
        $sql_tv = "SELECT * FROM tv_show_platforms WHERE language_id = ?";
        $tv_query = $this->db->query($sql_tv, array($store->language_id));
        $tv_show_platforms = $tv_query->result();

        $categories = array();

        foreach ($tv_show_platforms as $tv_show) {
            // Check if there are series associated with this tv_show_platform
            $sql_series = "SELECT COUNT(*) as count FROM series WHERE FIND_IN_SET(?, tv_show_platforms) > 0";
            $series_query = $this->db->query($sql_series, array($tv_show->id));
            $series_count = $series_query->row()->count;

            if ($series_count > 0) {
                $category_data = array(
                    'id' => (int)$tv_show->id + 900000,
                    'name' => $tv_show->name
                );
                array_push($categories, $category_data);
            }
            // If no series found, skip this tv_show_platform
        }

        // Only create the JSON file if categories are not empty
        if (!empty($categories)) {
            // Create JSON data
            $main_array = array(
                'ServerTime' => $server_time,
                'name' => $store->name,
                'vodgenres' => $categories
            );

            // Write the JSON file
            $this->writeJsonFile($filename, $main_array);
        }
    }

    // Insert into tables
    $data = array('last_update' => date('Y-m-d H:i:s'));
    $this->publish_vod_classic_ims_m->save($id, $data);
}
    
public function createJsonSeriesInStoreCategoryWebSeries($id)
{
    check_allow('create', $this->data['is_allow']);
    $server_time = date('Y-m-d\TH:i:s.u\Z'); // Use ISO 8601 format

    // Get all series stores where active = 1 and name does not contain 'TV SHOW'
    $sql_stores = "SELECT * FROM series_store WHERE active = 1 AND name NOT LIKE '%TV SHOW%'";
    $query_stores = $this->db->query($sql_stores);

    foreach ($query_stores->result() as $store) {

        /*** Category ID 1: Recently Added ***/
        // Get the 100 most recent series ordered by id descending
        $this->db->select('*');
        $this->db->from('series');
        $this->db->where('language_id', $store->language_id);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(100);
        $query_series = $this->db->get();

        $movies = array();
        foreach ($query_series->result() as $series) {
            // Get seasons for the current series
            $this->db->select('*');
            $this->db->from('series_seasons');
            $this->db->where('series_id', $series->id);
            $query_seasons = $this->db->get();

            foreach ($query_seasons->result() as $season) {
                $movies[] = array(
                    'id' => (int)$season->id + 9000000, // series_seasons id
                    'name' => $series->name . " (" . $season->name . ")", // series name + series_seasons name
                    'poster' => $season->poster, // from series_seasons
                    'rating' => isset($series->rating) && is_numeric($series->rating) ? round($series->rating / 2) : 0, // default to 0 if not set or not numeric
                    'isserie' => 1, // for series
                );
            }
        }

        $main_array = array(
            'ServerTime' => $server_time,
            'name' => $store->name,
            'type' => "", // static
            'total' => count($movies),
            'count' => count($movies),
            'page' => 0, // static
            'movies' => $movies
        );

        $filename = '1_' . ((int)$store->id + 1000) . '_movies_store_category.json';
        $this->writeJsonFile($filename, $main_array);

        /*** Category ID 2: New Releases ***/
        // Get series ordered by year descending and id descending
        $this->db->select('*');
        $this->db->from('series');
        $this->db->where('language_id', $store->language_id);
        $this->db->order_by('year', 'DESC');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(100);
        $query_series = $this->db->get();

        $movies = array();
        foreach ($query_series->result() as $series) {
            // Get seasons for the current series
            $this->db->select('*');
            $this->db->from('series_seasons');
            $this->db->where('series_id', $series->id);
            $query_seasons = $this->db->get();

            foreach ($query_seasons->result() as $season) {
                $movies[] = array(
                    'id' => (int)$season->id + 9000000, // series_seasons id
                    'name' => $series->name . " (" . $season->name . ")", // series name + series_seasons name
                    'poster' => $season->poster, // from series_seasons
                    'rating' => isset($series->rating) && is_numeric($series->rating) ? round($series->rating / 2) : 0,
                    'isserie' => 1, // for series
                );
            }
        }

        $main_array = array(
            'ServerTime' => $server_time,
            'name' => $store->name,
            'type' => "", // static
            'total' => count($movies),
            'count' => count($movies),
            'page' => 0, // static
            'movies' => $movies
        );

        $filename = '2_' . ((int)$store->id + 1000) . '_movies_store_category.json';
        $this->writeJsonFile($filename, $main_array);

        /*** Category ID 3: ALL ***/
        // Get all series for the current store
        $this->db->select('*');
        $this->db->from('series');
        $this->db->where('language_id', $store->language_id);
        $this->db->order_by('id', 'DESC');
        $query_series = $this->db->get();

        $movies = array();
        foreach ($query_series->result() as $series) {
            // Get seasons for the current series
            $this->db->select('*');
            $this->db->from('series_seasons');
            $this->db->where('series_id', $series->id);
            $query_seasons = $this->db->get();

            foreach ($query_seasons->result() as $season) {
                $movies[] = array(
                    'id' => (int)$season->id + 9000000, // series_seasons id
                    'name' => $series->name . " (" . $season->name . ")", // series name + series_seasons name
                    'poster' => $season->poster, // from series_seasons
                    'rating' => isset($series->rating) && is_numeric($series->rating) ? round($series->rating / 2) : 0,
                    'isserie' => 1, // for series
                );
            }
        }

        $main_array = array(
            'ServerTime' => $server_time,
            'name' => $store->name,
            'type' => "", // static
            'total' => count($movies),
            'count' => count($movies),
            'page' => 0, // static
            'movies' => $movies
        );

        $filename = '3_' . ((int)$store->id + 1000) . '_movies_store_category.json';
        $this->writeJsonFile($filename, $main_array);

        /*** Categories for OTT Platforms ***/
        // Get all entries from series_ott_platforms
        $sql_ott = "SELECT * FROM series_ott_platforms";
        $ott_query = $this->db->query($sql_ott);
        $ott_platforms = $ott_query->result();

        foreach ($ott_platforms as $ott_platform) {
            // Adjust category ID
            $adjusted_category_id = (int)$ott_platform->id + 9000000 + 3;

            // Check if there are series associated with this ott_platform and store's language_id
            $this->db->select('*');
            $this->db->from('series');
            $this->db->where('language_id', $store->language_id);
            $this->db->where("ott_platforms IS NOT NULL AND ott_platforms <> ''");
            $this->db->where("FIND_IN_SET('{$ott_platform->id}', REPLACE(ott_platforms, ' ', '')) > 0");
            $this->db->order_by('id', 'DESC');
            $query_series = $this->db->get();

            if ($query_series->num_rows() > 0) {
                $movies = array();
                foreach ($query_series->result() as $series) {
                    // Get seasons for the current series
                    $this->db->select('*');
                    $this->db->from('series_seasons');
                    $this->db->where('series_id', $series->id);
                    $query_seasons = $this->db->get();

                    foreach ($query_seasons->result() as $season) {
                        $movies[] = array(
                            'id' => (int)$season->id + 9000000, // series_seasons id
                            'name' => $series->name . " (" . $season->name . ")", // series name + series_seasons name
                            'poster' => $season->poster, // from series_seasons
                            'rating' => isset($series->rating) && is_numeric($series->rating) ? round($series->rating / 2) : 0,
                            'isserie' => 1, // for series
                        );
                    }
                }

                $main_array = array(
                    'ServerTime' => $server_time,
                    'name' => $store->name,
                    'type' => "", // static
                    'total' => count($movies),
                    'count' => count($movies),
                    'page' => 0, // static
                    'movies' => $movies
                );

                $filename = $adjusted_category_id . '_' . ((int)$store->id + 1000) . '_movies_store_category.json';
                $this->writeJsonFile($filename, $main_array);
            }
        }
    }

    // Update the last update time in the database
    $data = array('last_update' => date('Y-m-d H:i:s'));
    $this->publish_vod_classic_ims_m->save($id, $data);
}

public function createJsonSeriesInStoreCategoryTvShow($id)
{
    check_allow('create', $this->data['is_allow']);
    $server_time = date('Y-m-d\TH:i:s.u\Z'); // Use ISO 8601 format

    // Get series stores where active = 1 and name contains 'TV SHOW'
    $sql_stores = "SELECT * FROM series_store WHERE active = 1 AND name LIKE '%TV SHOW%'";
    $query_stores = $this->db->query($sql_stores);
    $series_stores = $query_stores->result();

    foreach ($series_stores as $store) {
        // Get tv_show_platforms where language_id matches the series_store's language_id
        $sql_tv = "SELECT * FROM tv_show_platforms WHERE language_id = ?";
        $tv_query = $this->db->query($sql_tv, array($store->language_id));
        $tv_show_platforms = $tv_query->result();

        foreach ($tv_show_platforms as $tv_show) {
            // Adjust category ID
            $adjusted_category_id = (int)$tv_show->id + 900000;

            // Check if there are series associated with this tv_show_platform
            $this->db->select('*');
            $this->db->from('series');
            $this->db->where('language_id', $store->language_id);
            $this->db->where("tv_show_platforms IS NOT NULL AND tv_show_platforms <> ''");
            $this->db->where("FIND_IN_SET('{$tv_show->id}', REPLACE(tv_show_platforms, ' ', '')) > 0");
            $this->db->order_by('id', 'DESC');
            $query_series = $this->db->get();

            if ($query_series->num_rows() > 0) {
                $movies = array();
                foreach ($query_series->result() as $series) {
                    // Get seasons for the current series
                    $this->db->select('*');
                    $this->db->from('series_seasons');
                    $this->db->where('series_id', $series->id);
                    $query_seasons = $this->db->get();

                    foreach ($query_seasons->result() as $season) {
                        $movies[] = array(
                            'id' => (int)$season->id + 9000000, // Adjusted season ID
                            'name' => $series->name . " (" . $season->name . ")", // Combined name
                            'poster' => $season->poster, // Season poster
                            'rating' => isset($series->rating) && is_numeric($series->rating) ? round($series->rating / 2) : 0,
                            'isserie' => 1,
                        );
                    }
                }

                $main_array = array(
                    'ServerTime' => $server_time,
                    'name' => $store -> name,
                    'type' => "", // static
                    'total' => count($movies),
                    'count' => count($movies),
                    'page' => 0, // static
                    'movies' => $movies
                );

                // Filename is adjusted category ID + store ID
                $filename = $adjusted_category_id . '_' . ((int)$store->id + 2000) . '_movies_store_category.json';

                $this->writeJsonFile($filename, $main_array);
            }
            // If no series found, skip this tv_show_platform
        }
    }

    // Update the last update time in the database
    $data = array('last_update' => date('Y-m-d H:i:s'));
    $this->publish_vod_classic_ims_m->save($id, $data);
}
}
