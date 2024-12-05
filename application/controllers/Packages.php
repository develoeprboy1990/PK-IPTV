<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(47);
        $this->lang->load('groups');
        $this->lang->load('actions');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Packages');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "tar";
        $this->data['sub_nav'] = "packages";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Packages', 'packages');
    }


	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'packages/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'packages/index';
        $this->data['page_title'] = "Television and Radio >> Packages";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
        $rules = $this->packages_m->add_rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
           
            $data = $this->array_from_post(
                array(
                    'name', 
                    'price',
                    'vat', 
                    'device_type'
                    )
                );

            $insert_id=$this->packages_m->save(NULL,$data);
           
            // insert into channels tables
            if(count($this->input->post('channels'))>0){
                foreach ($this->input->post('channels') as $channel) {
                   $data=array(
                        'package_id'=>$insert_id,
                        'channel_id'=>$channel
                    );
                   $this->db->insert('package_to_channel',$data);
                }
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('packages/edit/'.$insert_id).'" target="_blank">TV & Radio Package Created</a>');   
 
            $this->session->set_flashdata('success',"Package Added Successfully.");
            redirect(BASE_URL.'packages');
        }

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create package', 'packages/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        //channels_groups
        $this->data['channels']=$this->channels_m->get();

        //get device Types 
        $this->data['devices']=$this->packages_m->get_devices();

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'packages/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'packages/create';
        $this->data['page_title'] = "Add New Package";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL)
    {
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'packages' ) : '';
                      
        $this->packages_m->delete($id);
        $this->packages_m->delete_package_channel($id);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('packages').'" target="_blank">TV & Radio Package Deleted</a>');   
        $this->session->set_flashdata('success',"Package Deleted Successfully.");
        redirect( BASE_URL . 'packages' );
    } 

    public function edit($id = NULL)
    {
        check_allow('edit',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'channels' ) : '';
        $rules = $this->packages_m->add_rules;
        $this->form_validation->set_rules($rules);
        
        $package_info=$this->packages_m->get($id,TRUE);
        
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post(
               array(
                    'name', 
                    'price',
                    'vat', 
                    'device_type',
                    'active'
                    )
                );
            $this->packages_m->save($id,$data);
         
            // insert into channel group tables
            if(is_array($this->input->post('channels')) && count($this->input->post('channels'))>0){
                // first delete all 
                $this->packages_m->delete_package_channel($id);

                // then insert 
                foreach ($this->input->post('channels') as $channel) {
                   $data=array(
                        'package_id'=>$id,
                        'channel_id'=>$channel
                    );
                   $this->db->insert('package_to_channel',$data);
                }
               
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('packages/edit/'.$id).'" target="_blank">TV & Radio Package Updated</a>');   
            $this->session->set_flashdata('success',"Channel Edited Successfully.");
            redirect(BASE_URL.'packages');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Channel', 'channels/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        //channels
        $this->data['channels']=$this->channels_m->get();
        $this->data['package_channels']=$this->packages_m->get_channels_by_package($id);
        
        //get device Types 
        $this->data['devices']=$this->packages_m->get_devices();

        $this->data['package_detail'] = $package_info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'packages/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'packages/edit';
        $this->data['page_title'] = "Edit Package";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function get_all_packages(){
        $totaldata = 10;
        $totalfiltered = 10;
        $packages = $this->packages_m->get_packages();
        $data = array();
        foreach ($packages as $package) {
            $data[] = array(
                    'name'=>$package['name'],
                    'device'=>ucwords($package['device_name']),
                    'status'=>($package['active']) ? 'Active' : 'Inactive',
                    'edit'=>btn_edit(BASE_URL.'packages/edit/'.$package['id']),
                    'delete'=>btn_delete(BASE_URL.'packages/delete/'.$package['id'])
                );
        }
        $json_data = array(
                        "draw"            => intval( $_REQUEST['draw'] ),
                        "recordsTotal"    => intval( $totaldata ),
                        "recordsFiltered" => intval( $totalfiltered ),
                        "data"            => $data
                    );
        echo json_encode($json_data);
    }

}
