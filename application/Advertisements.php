<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advertisements extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(27);
        $this->load->model('advertisements_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Advertisements');
        $this->data['page_title'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Advertisements', 'advertisements');
    }


	public function index()
	{
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'advertisements/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'advertisements/index';
        $this->data['page_title'] = "Advertisement";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements */
        $this->data['advertisements']= $this->advertisements_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function banners()
    {
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'advertisements/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'advertisements/banners';
        $this->data['page_title'] = "Advertisement >> Banners";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements banners */
        $this->data['banners']= $this->advertisements_m->get_by(array('type'=>'banner'));
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function prerolls()
    {
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'advertisements/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'advertisements/prerolls';
        $this->data['page_title'] = "Advertisement >> Preroll";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements prerolls */
        $this->data['prerolls']= $this->advertisements_m->get_by(array('type'=>'preroll'));
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function overlays()
    {
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'advertisements/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'advertisements/overlays';
        $this->data['page_title'] = "Advertisement >> Overlay";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements overlays */
         $this->data['overlays']= $this->advertisements_m->get_by(array('type'=>'overlay'));
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function tickers()
    {
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'advertisements/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'advertisements/tickers';
        $this->data['page_title'] = "Advertisement >> Ticker";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements tickers */
        $this->data['tickers']= $this->advertisements_m->get_by(array('type'=>'ticker'));
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        $this->load->model('app_categories_m');
        $rules = $this->advertisements_m->rules;
        $this->form_validation->set_rules($rules);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }

        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);

            $insert_id=$this->advertisements_m->save(NULL,$data);
           
            //upload files if there is an image 
           /* if($_FILES['icon']['name']!='')
            {
                $upload_path='./uploads/advertisements/';
                $filename ='channel_image';
               
                $img_data=$this->do_upload($upload_path,$filename);

                $data=array('channel_image'=> $img_data);
                $this->advertisements_m->save($insert_id,$data);
            }*/
         
            $this->session->set_flashdata('success',"App Added Successfully.");
            redirect(BASE_URL.'advertisements');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create App', 'advertisements/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        /* Category */
        $this->data['categories']=$this->app_categories_m->get();

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'advertisements/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'advertisements/create';
        $this->data['page_title'] = "Add new App";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){

       ( $id == NULL ) ? redirect( BASE_URL . 'advertisements' ) : '';
        
        $app_info=$this->advertisements_m->get($id);
        
       /* if($app_info->channel_image_icon)
        {
            if(file_exists("./uploads/advertisements/icons/".$app_info->channel_image_icon))
                @unlink("./uploads/advertisements/icons/".$app_info->channel_image_icon);
        }*/

        $this->advertisements_m->delete($id);
        $this->session->set_flashdata('success',"App Deleted Successfully.");
        redirect( BASE_URL . 'advertisements' );
    }

    public function edit($id = NULL)
    {   
        $this->load->model('app_categories_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'advertisements' ) : '';
        $rules = $this->advertisements_m->rules;
        $this->form_validation->set_rules($rules);
        $app_info=$this->advertisements_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->advertisements_m->save($id,$data);

            /*if($_FILES['icon']['name']!='')
            {
                if(file_exists("./uploads/advertisements/icons/".$channel_info->channel_image_icon))
                    @unlink("./uploads/advertisements/icons/".$channel_info->channel_image_icon);

                $upload_path='./uploads/advertisements/icons/';
                $icon_filename ='channel_image_icon';
               
                $img_icon_data=$this->do_upload($upload_path,$icon_filename);

                $icon_data=array('channel_image_icon'=> $img_icon_data);
                $this->advertisements_m->save($id,$icon_data);
            }*/

            $this->session->set_flashdata('success',"App Edited Successfully.");
            redirect(BASE_URL.'advertisements');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit App', 'advertisements/create');

        /* Category */
        $this->data['categories']=$this->app_categories_m->get();

        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['details'] = $app_info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'advertisements/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'advertisements/edit';
        $this->data['page_title'] = "Edit App";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

     public function get_all_apps(){
        $totaldata = 10;
        $totalfiltered = 10;
        $advertisements = $this->advertisements_m->get();
        $data = array();
        foreach ($advertisements as $app) {
            $data[] = array(
                    'id'=>$app['id'],
                    'name'=>$app['name'],
                    'url'=>$app['url'],
                    'edit'=>btn_edit(BASE_URL.'advertisements/edit/'.$app['id']),
                    'delete'=>btn_delete(BASE_URL.'advertisements/delete/'.$app['id']),
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
