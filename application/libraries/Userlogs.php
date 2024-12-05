<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User logs for CodeIgniter
 *
 * A library for tracking user activity in CodeIgniter applications.
 * Requires PHP v.5.1 or higher.
 *
 * @package		Userlogs for CodeIgniter
 * @author		Casey McLaughlin
 * @copyright	Open Source BSD License
 * @link		  http://samyakmedia.com
 * @since		  Version 1.2
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * User Log library
 *
 * @package		  User Log for CodeIgniter
 * @subpackage	Libraries
 * @author		  vission
 * @link		    http://samyakmedia.com
 */
class Userlogs
{
  private $CI;
  private $configuration;

  private $needed_fields = array(array('name' => 'id', 'type' => 'int', 'primary_key' => 1, 'forge_type' => 'int', 'forge_auto_increment' => TRUE),
														array('name' => 'user_id', 'type' => 'int', 'forge_type' => 'int', 'forge_constraint' => '11'),
                            array('name' => 'session_id', 'type' => 'string', 'forge_type' => 'varchar', 'forge_constraint' => '100'),
														array('name' => 'user_identifier', 'type' => 'string', 'forge_type' => 'varchar', 'forge_constraint' => '255'),
														array('name' => 'request_uri', 'type' => 'string', 'forge_type' => 'text'),
														array('name' => 'timestamp', 'type' => 'string', 'forge_type' => 'varchar', 'forge_constraint' => '20'),
														array('name' => 'client_ip', 'type' => 'string', 'forge_type' => 'varchar', 'forge_constraint' => '50'),
														array('name' => 'action', 'type' => 'string', 'forge_type' => 'varchar', 'forge_constraint' => '255'),
                            array('name' => 'client_user_agent', 'type' => 'string', 'forge_type' => 'text'),
														array('name' => 'referer_page', 'type' => 'string', 'forge_type' => 'text'));

  /**
   * Constructor
   *
   * Does nothing but run the initialization
   * method.
   *
   * @access public
   * @return void|boolean Will return FALSE if the intialization did not succeed.
   */
  public function __construct(){
    $result = $this->initialize();

    if ($result === FALSE)
      return FALSE;
  }


	// --------------------------------------------------------------------

  /**
   * Initialization script
   *
   * Checks the environment to ensure that the library
   * will run.
   *
   * @access public
   * @return boolean The result of the intialization process
   */
  public function initialize()
  {
    //connect to CodeIgnitor
    if ( ! $this->CI =& get_instance())
    {
      echo "The Userlogs library is built for CodeIgnitor 3.X and cannot be used outside of CI.";
      exit();
    }

    //if php is not new enough, show error and die.
    if (phpversion() < 5.1)
    {
      show_error('The Userlogs plugin is supported only on PHP v5.1 and above!');
      return FALSE;
    }

    //check for the configuration file
    if ( ! $this->CI->config->load('userlogs_config') OR $this->CI->config->item('userlogs') === FALSE)
    {
      show_error("Missing the configuration for userlogs.  Ensure you have installed userlogs correctly.");
      return FALSE;
    }

    //Load the configuration
    $this->configuration = $this->CI->config->item('userlogs');

    //check the database for the table
    if ( ! $this->check_database())
    {
      show_error("The database is not setup correctly for UserLogs.  Check to ensure proper database setup, or check the config settings for userlogs.");
      return FALSE;
    }

    //if made it here
    return TRUE;
  }


  // --------------------------------------------------------------------

  /**
   * Automatically Track User Events
   *
   * Auto-track is meant to be run only from a CodeIgniter hook.  It
   * checks to ensure that autotracking is enabled, checks any filters
   * that may have been configured in the configuration file, and then
   * runs the {@link trackThis()} method.
   *
   * @return boolean The result of the tracking action (whether a db record was added or not)
   */
  public function auto_track()
  {
    //check the conditions
    if ($this->configuration['auto_track'] == TRUE)
    {
      $proceed = $this->check_filters();

      if ($proceed === TRUE)
        return $this->track_this();
    }
  }


  // --------------------------------------------------------------------

  /**
   * Track the current pageview
   *
   * Retrieves information from the session, user agent, and server
   * fields, and then adds a record to the tracking database.
   *
   * @access public
   * @return boolean The result of the tracking action (whether a db record was added or not)
   */
  public function track_this($user_id="", $action="")
  {
    //load necessary libraries
    $this->CI->load->database();
    $this->CI->load->library('user_agent');
    $this->CI->load->library('session');

    //get the data
    $input_data = array();
    //$input_data['session_id'] = $this->CI->session->userdata('session_id');
    $input_data['session_id'] = $this->CI->session->session_id;
    $input_data['request_uri'] = $this->CI->input->server('REQUEST_URI');
    $input_data['timestamp'] = time();
    $input_data['client_ip'] = $this->CI->input->server('REMOTE_ADDR');
    $input_data['user_id'] = $user_id;
    $input_data['action'] = $action;
    $input_data['client_user_agent'] = $this->CI->agent->agent_string();
    $input_data['referer_page'] = $this->CI->agent->referrer();

    //Get the user identifier, if set
    if ($this->configuration['user_identifier'] !== null && is_array($this->configuration['user_identifier']))
    {
      if (count($this->configuration['user_identifier']) == 3)
      {
        list($class_type, $class_name, $function_name) = $this->configuration['user_identifier'];
        $the_args = array();
      }
      elseif (count($this->configuration['user_identifier']) == 4)
        list($class_type, $class_name, $function_name, $the_args) = $this->configuration['user_identifier'];

      if ( ! $this->CI->load->$class_type($class_name))
      {
        if ((($class_type !== 'helper') && !method_exists($this->CI->$class_name, $function_name)) OR ($class_type == 'helper' && !function_exists($function_name)))
          display_error("Could not load the $function_name in $class_name.  Check the userIdentifier configuration in userTracking config. User Identifier will not be tracked.");
        else //Do it!
        {
          if ($class_type == 'helper')
            $input_data['user_identifier'] = call_user_func_array($function_name, $the_args);
          else
            $input_data['user_identifier'] = call_user_func_array(array($this->CI->$class_name, $function_name), $the_args);
        }
      }
      else
        display_error("Could not load the $class_type: $class_name.  Check the userIdentifier configuration in userTracking config. User Identifier will not be tracked.");
    }

    //Add it to the database
    $this->CI->load->database();
    $result = $this->CI->db->insert('logs', $input_data);

    if ($result === FALSE)
      show_error("Could not write to the logs table in the database while trying to add a tracking record.  Double-check configureation and datbase setup for userlogs library!");

    //Return the database write result
    return $result;
  }


   // --------------------------------------------------------------------

  /**
   * Track the Login / logout
   *
   * Retrieves information from the session, user agent, and server
   * fields, and then adds a record to the tracking database.
   *
   * @access public
   * @return boolean The result of the tracking action (whether a db record was added or not)
   */
  public function track_login($user_id="", $action="")
  {
    //load necessary libraries
    $this->CI->load->database();
    $this->CI->load->library('user_agent');
    $this->CI->load->library('session');

    //get the data
    $input_data = array();

    if($action=='login')
      $input_data['last_login'] = time();
    else
      $input_data['last_logout'] = time();

    //$input_data['session_id'] = $this->CI->session->userdata('session_id');
    $input_data['session_id'] = $this->CI->session->session_id;
    $input_data['request_uri'] = $this->CI->input->server('REQUEST_URI');
    $input_data['timestamp'] = time();
    $input_data['client_ip'] = $this->CI->input->server('REMOTE_ADDR');
    $input_data['user_id'] = $user_id;
    $input_data['action'] = ucfirst($action). " on ". date('Y-m-d H:i:s',time());
    $input_data['client_user_agent'] = $this->CI->agent->agent_string();
    $input_data['referer_page'] = $this->CI->agent->referrer();

    //Add it to the database
    $this->CI->load->database();
    $result = $this->CI->db->insert('logs', $input_data);

    if ($result === FALSE)
      show_error("Could not write to the logs table in the database while trying to add a tracking record.  Double-check configureation and datbase setup for userlogs library!");

    //Return the database write result
    return $result;
  }


  // --------------------------------------------------------------------

  /**
   * Check/Process filters
   *
   * This is run as part of the autoTrack() function.  It processes any
   * filters defined in the configuration file and returns either TRUE or FALSE.
   *
   * @access  private
   * @return boolean Whether or not the filter tests suceeded.
   */
  private function check_filters()
  {
    //Get the tracking filters from the config
    $tracking_filters = $this->configuration['tracking_filter'];

    //If there are filters, process them
    if (is_array($tracking_filters) && count($tracking_filters) > 0 && $tracking_filters[0] !== null)
    {
      $filter_results = array();

      //go through each tracking filter and make sure that they pass
      foreach($tracking_filters as $curr_filter)
      {
        //Check the filter for the right type
        if ( ! is_array($curr_filter) OR (count($curr_filter) != 4 && count($curr_filter) != 5))
        {
          show_error("The userlogs filter is malformed.  Check the userlogs configuration.  Filter: $curr_filter");
          continue;
        }

        if (count($curr_filter) == 4)
        {
          list($class_type, $class_name, $function_name, $expected_result) = $curr_filter;
          $the_args = array();  //This is empty
        }
        elseif (count($curr_filter) == 5)
          list($class_type, $class_name, $function_name, $expected_result, $the_args) = $curr_filter;
        else
        {
          show_error("The userlogs filter is malformed.  Check the userlogs configuration.  Filter: $curr_filter");
          continue;
        }

        //Run the filter
        if ( ! $this->CI->load->$class_type($class_name))
        {
          if ((($class_type !== 'helper') && !method_exists($this->CI->$class_name, $function_name)) OR ($class_type == 'helper' && !function_exists($function_name)))
            show_error("Could not load the $function_name in $class_name.  The filter will not be applied.");
          else //Do it!
          {
            if ($class_type == 'helper')
              $curr_filter_result = call_user_func_array($function_name, $the_args);
            else
              $curr_filter_result = call_user_func_array(array($this->CI->$class_name, $function_name), $the_args);
          }
        }
        else
          show_error("Could not load the $class_type: $class_name.  Check the userIdentifier configuration in userTracking config. User filter will not be applied.");

        //Analyze the results
        //If there is no result for the current filter, autofail!
        if ( ! isset($curr_filter_result))
        {
          $filter_results[] = 'fail';
        }
        else //if there is a result, test it
        {
        	//Do a strong type comparison if we are expecting true or false
        	if ($expected_result === TRUE OR $expected_result === FALSE)
        	{
	          if ($curr_filter_result === $expected_result)
	            $filter_results[] = 'pass';
	          else
	            $filter_results[] = 'fail';
        	}
        	else //Do a weak type comparison for everything else
        	{
	          if ($curr_filter_result == $expected_result)
	            $filter_results[] = 'pass';
	          else
	            $filter_results[] = 'fail';
        	}
        }
      }

      //check the results
      if (strtoupper($this->configuration['tracking_filter_logic']) == "AND") //AND Logic
      {
        if ( ! in_array("fail", $filter_results))
          return TRUE;
        else
          return FALSE;
      }
      else //OR Logic
      {
        if (in_array("pass", $filter_results))
          return TRUE;
        else
          return FALSE;
      }
    }
    else //no filters to check -- pass automatically.
      return TRUE;
  }


  // --------------------------------------------------------------------


  /**
   * Check Database
   *
   * This checks and, if defined in the configuration file, builds the
   * necessary database tables for tracking using the CI database forge class.
   *
   * If it finds a malformed table, it will backup that table and create a new one.
   *
   * @access private
   * @return boolean Whether the database table exists or was setup succesfully.
   */
  private function check_database()
  {
    //load the ci database and db forge classes, or show error & return FALSE
    $this->CI->load->database();
    $this->CI->load->dbforge();

    //check to see if the table exists
    if ($this->CI->db->table_exists('logs'))
    {
      //if the table exists, check to see if the columns are setup correctly
      $fields = $this->CI->db->field_data('logs');

      //if the columns are setup correctly, return TRUE
      $num_matched = 0;
      foreach($this->needed_fields as $needed_field)
      {
        $nf_name = $needed_field['name'];
        $nf_type = $needed_field['type'];

        foreach($fields as $the_field)
        {
          if ($the_field->name == $nf_name && $the_field->type = $nf_type)
          {
            $num_matched++;
            break;
          }
        }
      }

      if ($num_matched < count($this->needed_fields) && $this->configuration['auto_fix_db'] === TRUE)
      {
        //if the columns are setup incorrectly and autofix_db is on, fix the db and return TRUE

        //rename the table
        global $CI;
        $db_prefix = $CI->db->dbprefix;
        $this->CI->dbforge->rename_table($db_prefix . 'logs', 'logs_backup_' . time());
        $this->CI->db->query("UNLOCK TABLES;");

        //rebuild the table
        $result = $this->build_database_table();

        //return TRUE
        return $result;
      }
      elseif ($num_matched < count($this->needed_fields) && $this->configuration['auto_fix_db'] !== TRUE)
      {
        //if the columns are setup incorrectly and autofix_db is off, show error return FALSE
        show_error('The database table exists, but is malformed and not setup correctly.');
        return FALSE;
      }
      else //everything is setup right
        return TRUE;
    }
    elseif ($this->configuration['auto_build_db'] === TRUE)
    {
      //if the table doesn't exist, and autoBuild_db is on, build the table and return TRUE
      $result = $this->build_database_table();
      return $result;
    }
    else
    {
      //if the table doesn't exist, and autoBuild_db is off, show error and return FALSE
      show_error("The logs database table does not exist.  Check your database installation.");
      return FALSE;
    }
  }

  // --------------------------------------------------------------------


  /**
   * Build Database Table
   *
   * Builds the database table.  If one already exists, it will overwrite.  This method
   * should only be called from the {@link checkDatabase} method to avoid potential
   * data loss.
   *
   * @access private
   * @return boolean Whether the table was built succesfully
   */
  private function build_database_table()
  {
    //load the ci database and db forge classes, or show error & return FALSE (if not already done)
    $this->CI->load->database();
    $this->CI->load->dbforge();

    //create a new table with the appropriate fields
    $new_fields = array();

    foreach($this->needed_fields as $curr_nf)
    {
      $name = $curr_nf['name'];
      $new_fields[$name] = array('type' => $curr_nf['forge_type']);
      if (isset($curr_nf['forge_constraint']))
        $new_fields[$name]['constraint'] = $curr_nf['forge_constraint'];
      if (isset($curr_nf['forge_auto_increment']))
        $new_fields[$name]['auto_increment'] = $curr_nf['forge_auto_increment'];

      if (isset($curr_nf['primary_key']) && $curr_nf['primary_key'] == 1)
        $this->CI->dbforge->add_key($name, TRUE);
    }

    $this->CI->dbforge->add_field($new_fields);
    $this->CI->dbforge->create_table('logs');
    return TRUE;
  }

}