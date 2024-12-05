<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class App_publish extends User_Controller {
    public function __construct() {
        parent::__construct();
        $this->data['is_allow']= check_permission(81);
        $this->load->model('App_publish_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');

        /* Title Page :: Common */
        $this->page_title->push('App Publish');
        $this->data['page_title'] = $this->page_title->show();
        $this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "app_publish";
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'App Publish', 'App Publish');
    }

	public function index($tab=1){
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'app_publish/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'app_publish/index';
        $this->data['page_title'] = "App Publish";
        $this->data['activeTab'] = $tab;
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
      	

        //General
	    $this->data['generals']= $this->App_publish_m->get_AppPublish('','General');
        $this->data['genral_app_publish_add'] = $this->load->view( DEFAULT_THEME . 'app_publish/_add_genral_app_publish',$this->data, TRUE);
        $this->data['genral_app_publish_list']= $this->load->view( DEFAULT_THEME . 'app_publish/_list_genral_app_publish',$this->data, TRUE);

        //SetUp
        $this->data['setups']= $this->App_publish_m->get_AppPublish('','SetUp');
        $this->data['setup_app_publish_add'] = $this->load->view( DEFAULT_THEME . 'app_publish/_add_setup_app_publish',$this->data, TRUE);
        $this->data['setup_app_publish_list']= $this->load->view( DEFAULT_THEME . 'app_publish/_list_setup_app_publish',$this->data, TRUE);
        
        //Beta
        $this->data['betas']= $this->App_publish_m->get_AppPublish('','Beta');
        $this->data['beta_app_publish_add'] = $this->load->view( DEFAULT_THEME . 'app_publish/_add_beta_app_publish',$this->data, TRUE);
        $this->data['beta_app_publish_list']= $this->load->view( DEFAULT_THEME . 'app_publish/_list_beta_app_publish',$this->data, TRUE);

        //exit();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    //updateStatus
    public function updateStatus() {
        check_allow('edit', $this->data['is_allow']);
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $type = $this->input->post('type');

        // Check if trying to activate
        if ($status == 1) {
            // Check if there's already an active record
            $activeRecord = $this->App_publish_m->getActiveRecord($type);
            
            if ($activeRecord && $activeRecord->id != $id) {
                echo json_encode(array('status' => 'error', 'message' => 'Another record is already active. Please deactivate it first.'));
                return;
            }
        }

        $log_data = array('status' => $status);
        $result = $this->App_publish_m->update_app_publish($log_data, array('id' => $id), 'app_publish');
        
        if ($result) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to update status.'));
        }
    }

    //GetDetails
    public function getDetails() {
        check_allow('view', $this->data['is_allow']);
        
        $id = $this->input->post('id');
        
        $details = $this->App_publish_m->get($id);
        
        if($details) {
            echo json_encode($details);
        } else {
            echo json_encode(array('error' => 'Details not found'));
        }
    }

    //Create
    public function createAppPublish() {
        check_allow('create', $this->data['is_allow']);
        
        $rules = $this->App_publish_m->rules;
        $this->form_validation->set_rules($rules);
        
        if ($this->form_validation->run() == TRUE) {
            $type = $this->input->post('type');
            $data = array(
                'title' => $this->input->post('title'),
                'action' => $this->input->post('action'),
                'description' => $this->input->post('description'),
                'date' => $this->input->post('date'),
                'version_number' => $this->input->post('version_number'),
                'package_name' => $this->input->post('package_name'),
                'url' => $this->input->post('url'),
                'forceupdate' => $this->input->post('forceupdate'),
                'update_without_login' => $this->input->post('update_without_login'),
                'type' => $this->input->post('type'),
                'beta_type' => $this->input->post('beta_type'),
                'remarks' => $this->input->post('remarks'),
                'created_at' => date('Y-m-d H:i:s')
            );
            
            $result = $this->App_publish_m->save(NULL, $data);

            if ($result) {

                $this->userlogs->track_this($this->session->user_id, '<a href="'.site_url('app_publish').'" target="_blank">'.$type.' App Publish Created</a>');   
                $this->session->set_flashdata('success', $type." App Publish Created Successfully.");
                if($type =='General')
                redirect(BASE_URL . 'app_publish/index/1');
                if($type == 'SetUp')
                redirect(BASE_URL . 'app_publish/index/2');
                if($type == 'Beta')
                redirect(BASE_URL . 'app_publish/index/3');

            } else {
                $this->session->set_flashdata('error', "Failed to create ".$type." App Publish.");
                redirect(BASE_URL . 'app_publish/index/1');
            }
        } else {
            $this->index(1); // Reload the form with validation errors
        }
    }

    //EditForm
    public function editAppPublish($id) {
       // check_allow('edit', $this->data['is_allow']);

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'app_publish/_extra_scripts';
        $this->data['page_title'] = "Edit App Publish";
        $this->data['activeTab'] = $tab;
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        

        //App_Publish
        $getAppPublish = $this->App_publish_m->get($id);
        $this->data['app_publish'] = $getAppPublish;
        
        if (!$getAppPublish) {
            $this->session->set_flashdata('error', "Record not found.");
            redirect(BASE_URL . 'app_publish/index/1');
        }
        $this->data['_view'] = DEFAULT_THEME . 'app_publish/edit';
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    //Update
    public function updateAppPublish() {
        check_allow('edit', $this->data['is_allow']);
        
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        
        $rules = $this->App_publish_m->edit_rules;
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == TRUE) {
          
            $log_data = array(
                'title' => $this->input->post('title'),
                'action' => $this->input->post('action'),
                'description' => $this->input->post('description'),
                'date' => $this->input->post('date'),
                'version_number' => $this->input->post('version_number'),
                'package_name' => $this->input->post('package_name'),
                'url' => $this->input->post('url'),
                'forceupdate' => $this->input->post('forceupdate'),
                'update_without_login' => $this->input->post('update_without_login'),
                'beta_type' => $this->input->post('beta_type'),
                'remarks' => $this->input->post('remarks')
            );

            $result = $this->App_publish_m->update_app_publish($log_data,array('id' => $id), 'app_publish');
            if ($result) {

                $this->userlogs->track_this($this->session->user_id, '<a href="'.site_url('app_publish').'" target="_blank">'.$type.' App Publish Updated</a>');   
                $this->session->set_flashdata('success', $type." App Updated Successfully.");

                if($type =='General')
                redirect(BASE_URL . 'app_publish/index/1');
                if($type == 'SetUp')
                redirect(BASE_URL . 'app_publish/index/2');
                if($type == 'Beta')
                redirect(BASE_URL . 'app_publish/index/3');

            } else {
                $this->session->set_flashdata('error', "Failed to update General App Publish.");
                redirect(BASE_URL . 'app_publish/editAppPublish/' . $id);
            }
        } else {
            $this->editGeneralAppPublish($id);
        }
    }

    //Delete
    public function deleteAppPublish() {
        check_allow('delete', $this->data['is_allow']);
        
        $id = $this->input->post('id');
        
        if ($id) {
            // Get the record details before deleting
            $record = $this->App_publish_m->get($id);
            
            $result = $this->App_publish_m->delete($id);
            
            if ($result) {
                // Delete the associated JSON file
                $this->deleteJsonFile($id, $record->type);
                
                $this->userlogs->track_this($this->session->user_id, '<a href="'.site_url('app_publish').'" target="_blank">App Publish Deleted</a>');   
                echo json_encode(array('status' => 'success'));
            } else {
                echo json_encode(array('status' => 'error'));
            }
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }
    private function deleteJsonFile($id, $type) {
        if($type == 'General') {
            $filename = 'push_actions.json';
        } 
        if($type == 'SetUp') {
            $filename = 'stb_push_actions.json';
        }
        if($type == 'Beta') {
            $filename = 'beta_push_actions.json';
        }


        $localdirectory = LOCAL_PATH_CRM;
        $filePath = $localdirectory . $filename;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    //CreateJson
    public function publishApp() {
        check_allow('create', $this->data['is_allow']);
        
        $type = $this->input->post('type');
        
        if (!in_array($type, ['General', 'SetUp', 'Beta'])) {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid app type.'));
            return;
        }
        
        $activeRecord = $this->App_publish_m->getActiveRecord($type);
        
        if (!$activeRecord) {
            echo json_encode(array('status' => 'error', 'message' => 'No active ' . $type . ' App record found.'));
            return;
        }
        
        $data = array(
            'id' => $activeRecord->id,
            'title' => $activeRecord->title,
            'action' => $activeRecord->action,
            'description' => $activeRecord->description,
            'date' => date('d-m-Y', strtotime($activeRecord->date)), // Changed date format
            'version_number' => $activeRecord->version_number,
            'package_name' => $activeRecord->package_name,
            'url' => $activeRecord->url,
            'forceupdate' => $activeRecord->forceupdate == '1' ? True : False,
            'update_without_login' => $activeRecord->update_without_login == '1' ? True : False,
            'beta_type' => $activeRecord->beta_type,
            'remarks' => $activeRecord->remarks
        );

        if($type == 'General') {
            $filename = 'push_actions.json';
        } 
        if($type == 'SetUp') {
            $filename = 'stb_push_actions.json';
        }
        if($type == 'Beta') {
            $filename = 'beta_push_actions.json';
        }

        $localdirectory = LOCAL_PATH_CRM;
        $localFilePath =  $localdirectory . $filename;

        $json_data = json_encode([$data], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        
        if(!is_dir($localdirectory)){
            mkdir($localdirectory, 0777, true);
        }

        if (file_put_contents($localFilePath, $json_data)) {
            $this->userlogs->track_this($this->session->user_id, '<a href="'.site_url('app_publish').'" target="_blank">' . $type . ' App Published</a>');   
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to create JSON file.'));
        }
    }

    public function download($type) {
        // Get active record for the type
        $activeRecord = $this->App_publish_m->getActiveRecord($type);
        
        if (!$activeRecord) {
            $this->session->set_flashdata('error', 'No active ' . $type . ' app version found.');
            redirect(BASE_URL . 'app_publish/index/1');
            return;
        }

        // Create download page
        $data = array(
            'app_info' => $activeRecord,
            'type' => $type
        );
        
        $this->data['_view'] = DEFAULT_THEME . 'app_publish/download';
        $this->data['app_info'] = $activeRecord;
        $this->data['type'] = $type;
        $this->load->view(DEFAULT_THEME . 'app_publish/download', $this->data);
    }
    public function getDownloadLink($type) {
        $baseUrl = base_url();
        return $baseUrl . 'app_publish/download/' . $type;
    }

    public function copyLink($type) {
        $link = $this->getDownloadLink($type);
        echo json_encode(['status' => 'success', 'link' => $link]);
    }
}