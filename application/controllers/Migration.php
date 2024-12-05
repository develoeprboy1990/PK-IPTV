<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration extends User_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('migration');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        $this->load->database();
        $this->load->model('logs_m');
        
        // Add CSRF protection
        $this->load->helper('form');
    }
    public function index()
    {
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'migrations/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'migrations/index';
        $this->data['page_title'] = "Migrations";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        // Handle empty migrations table
        $migration_row = $this->db->get('migrations')->row();
        $this->data['current_version'] = $migration_row ? $migration_row->version : 0;
        // Get migration history if you have a table for it
        $this->data['migration_history'] = $this->db->get('migration_history')->result();
        $this->load->view(DEFAULT_THEME . '_layout', $this->data);
    }
    public function latestXXX()
    {
        // Get current version before migration
        $migration_row = $this->db->get('migrations')->row();
        $current_version = $migration_row ? $migration_row->version : 0;
        $latest_version = $this->migration->find_migrations(); // Get all migration versions
        foreach ($latest_version as $version => $file) {
            // Skip already applied migrations
            if ($version <= $current_version) {
                continue;
            }
            // Attempt each migration in sequence
            if ($this->migration->version($version) === FALSE) {
                $this->session->set_flashdata('error', $this->migration->error_string());
                break; // Stop if a migration fails
            } else {
                // Log each successful migration
                $this->_log_migration($version);
            }
        }
        // Check the new current version after migration
        $new_version_row = $this->db->get('migrations')->row();
        $new_version = $new_version_row ? $new_version_row->version : 0;
        if ($new_version > $current_version) {
            $this->session->set_flashdata('success', "Migrations ran successfully! Updated from version {$current_version} to {$new_version}");
        } else {
            $this->session->set_flashdata('info', "System is already at the latest version ({$current_version})");
        }
        redirect('migration');
    }
    
    public function revertXXX($steps = 1)
    {
        try {
            // Get current version from the migrations table
            $migration_row = $this->db->get('migrations')->row();
            $current_version = $migration_row ? $migration_row->version : 0;
            if ($current_version <= 0) {
                $this->session->set_flashdata('error', "No migrations to revert");
                redirect('migration');
                return;
            }
            // Calculate target version
            $target_version = $current_version - $steps;
            if ($target_version < 0) {
                $target_version = 0;
            }
            // Revert directly to target version
            if ($this->migration->version($target_version) === FALSE) {
                $this->session->set_flashdata('error', $this->migration->error_string());
            } else {
                // Log the reversion
                $this->_log_migration($target_version, 'revert');
                $this->session->set_flashdata('success', "Successfully reverted to version {$target_version} from version {$current_version}");
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('error', "Reversion failed: " . $e->getMessage());
        }
        redirect('migration');
    }
     public function latest()
    {
        // Check if request is POST using proper method
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            show_error('Direct access is not allowed', 403);
            return;
        }
        // Get current version before migration
        $migration_row = $this->db->get('migrations')->row();
        $current_version = $migration_row ? $migration_row->version : 0;
        $latest_version = $this->migration->find_migrations();
        $success = true;
        $error_message = '';
        // Start transaction
        $this->db->trans_start();
        try {
            foreach ($latest_version as $version => $file) {
                if ($version <= $current_version) {
                    continue;
                }
                if ($this->migration->version($version) === FALSE) {
                    $success = false;
                    $error_message = $this->migration->error_string();
                    break;
                } else {
                    $this->_log_migration($version);
                }
            }

            // Log the migration attempt
            /*$this->userlogs->track_this($this->session->user_id,$success ? 
                    "Migration to latest version successful. Updated from version {$current_version}" : 
                    "Migration failed: {$error_message}");*/

            if (!$success) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', $error_message);
            } else {
                $this->db->trans_commit();
                $new_version = $this->db->get('migrations')->row()->version;
                $this->session->set_flashdata('success', 
                    "Migrations ran successfully! Updated from version {$current_version} to {$new_version}");
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', "Migration failed: " . $e->getMessage());
        }
        redirect('migration');
    }
    public function revert()
    {
        // Check if request is POST using proper method
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            show_error('Direct access is not allowed', 403);
            return;
        }
        // Start transaction
        $this->db->trans_start();
        try {
            $migration_row = $this->db->get('migrations')->row();
            $current_version = $migration_row ? $migration_row->version : 0;
            if ($current_version <= 0) {
                $this->session->set_flashdata('error', "No migrations to revert");
                redirect('migration');
                return;
            }
            $target_version = $current_version - 1;
            $success = true;
            $error_message = '';
            if ($this->migration->version($target_version) === FALSE) {
                $success = false;
                $error_message = $this->migration->error_string();
            } else {
                $this->_log_migration($target_version, 'revert');
            }

            // Log the revert attempt
            /*$this->userlogs->track_this($this->session->user_id,$success ? 
                    "Successfully reverted from version {$current_version} to {$target_version}" : 
                    "Reversion failed: {$error_message}");*/

            if (!$success) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', $error_message);
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('success', 
                    "Successfully reverted to version {$target_version} from version {$current_version}");
            }

        } catch (Exception $e) {
            $this->db->trans_rollback();
            //$this->userlogs->track_this($this->session->user_id,"Reversion failed with exception: " . $e->getMessage());
            $this->session->set_flashdata('error', "Reversion failed: " . $e->getMessage());
        }

        redirect('migration');
    }
    private function _log_migration($version, $action = 'migrate')
    {
        try {
            // Get current version before logging
            $migration_row = $this->db->get('migrations')->row();
            $current_version = $migration_row ? $migration_row->version : 0;
            // For reverts, we want to log the file that's being reverted (the current version)
            $version_to_log = ($action === 'revert') ? ($current_version + 1) : $version;
            
            // Pad the version to match the typical 3-digit format (e.g., '024')
            $padded_version = str_pad($version_to_log, 3, '0', STR_PAD_LEFT);
            // Get all migrations
            $migrations = $this->migration->find_migrations();
            // Initialize filename as unknown
            $filename = "{$padded_version}_unknown_migration.php";
            // Check for a matching migration file
            foreach ($migrations as $migration_version => $migration_path) {
                if ((int) $migration_version === (int) $version_to_log) {
                    $filename = basename($migration_path);
                    break;
                }
            }
            // Prepare the data for logging
            $data = [
                'version' => $version,  // Keep the target version
                'filename' => $filename, // But use the filename of the version being reverted
                'applied_at' => date('Y-m-d H:i:s'),
                'action' => $action
            ];
            // Insert log entry into the migration_history table
            $this->db->insert('migration_history', $data);
        } catch (Exception $e) {
            // Log the error without stopping the migration process
            log_message('error', 'Failed to log migration: ' . $e->getMessage());
        }
    }
    /*public function dbseed()
    {
        $this->load->library('DatabaseSeeder'); // Include 'seeder' if stored in a folder
        $this->databaseseeder->run();  // Call run() on the loaded instance
        echo "Database seeding completed.\n";
    }*/
    /*public function manual_query()
    {
        try {
            $query = $this->input->post('query');
            
            if (empty($query)) {
                $this->session->set_flashdata('error', 'Query cannot be empty');
                redirect('migration');
                return;
            }
            // Execute the query
            $result = $this->db->query($query);
            
            if ($result) {
                // Get the number of affected rows
                $affected_rows = $this->db->affected_rows();
                $this->session->set_flashdata('success', "Query executed successfully! Affected rows: {$affected_rows}");
            } else {
                $this->session->set_flashdata('error', "Query execution failed: " . $this->db->error()['message']);
            }
            
        } catch (Exception $e) {
            $this->session->set_flashdata('error', "Query execution failed: " . $e->getMessage());
        }
        redirect('migration/index/tab_3');
    }*/
}
?>