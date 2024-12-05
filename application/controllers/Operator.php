<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operator extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Operator');
        $this->data['page_title'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Operator', 'operator');
	}

	public function index()
    {   
        $this->load->model('dynamic_dependent_m');
        $id= $this->input->post('operator_id');
        $rules = $this->operator_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->operator_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->operator_m->save($id,$data);

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('operator').'" target="_blank">Operator Contact Updated</a>');   
            $this->session->set_flashdata('success',"Operator Edited Successfully.");
            redirect(BASE_URL.'operator');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Operator', 'operator/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
          /* Countries */
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();
        /* States */
        $this->data['states']=$this->dynamic_dependent_m->get_states($info->operator_country);
        /* Cities */
        $this->data['cities']=$this->dynamic_dependent_m->get_cities($info->operator_state);

        $this->data['operator_details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'operator/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'operator/index';
        $this->data['page_title'] = "Edit an Operator";
        
        $this->data['main_nav'] = "os";
        $this->data['sub_nav'] = "operator";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function contact($type){ 
        $this->load->model('contacts_m');
        $rules = $this->contacts_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->contacts_m->get_by(array('name'=>$type),TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->contacts_m->save($info->id,$data);

            //upload files if there is an image 
            if($_FILES['logo']['name']!='')
            {
                $filename= $this->upload_image('logo', $info->logo, LOCAL_PATH_IMAGES_CMS, 'contacts_m',$info->id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');;
            }

            if($_FILES['background']['name']!='')
            {
                $filename= $this->upload_image('background',$info->background, LOCAL_PATH_IMAGES_CMS, 'contacts_m',$info->id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');;
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('operator/contact/'.$type).'" target="_blank">Operator '.ucfirst($type).' Updated</a>');   
            $this->session->set_flashdata('success',"Contact Edited Successfully.");
            redirect(BASE_URL.'operator/contact/'.$type);
        } 

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Contact', 'operator/edit');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['details'] = $info;
        $this->data['type'] = $type;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'operator/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'operator/contact';
        $this->data['page_title'] = "Edit a Contact";
        
        $this->data['main_nav'] = "os";
        $this->data['sub_nav'] = $type;
        
        $this->load->view( DEFAULT_THEME . '_layout',$this->data); 
    }
}

/* End of file Operator.php */
/* Location: ./application/controllers/Operator.php */