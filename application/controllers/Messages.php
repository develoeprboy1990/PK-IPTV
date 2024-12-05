<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $is_allow = $this->ion_auth->checkPermission(33); 
        $this->data['is_allow']= $is_allow;
        
        if(!isset($is_allow))
        {
           redirect('unauthorize', 'refresh');
        }

        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        $this->load->model('messages_m');
        $this->load->model('news_m');
        $this->load->helper('text');
        /* Title Page :: Common */
        $this->page_title->push('News');
        $this->data['pagetitle'] = $this->page_title->show();

        $this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "messages";
        $this->data['activeTab'] = 1;
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Messages', 'messages');
    }

	public function index()
	{

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'messages/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'messages/index';
        $this->data['page_title'] = "Messages";
        $this->data['add_text'] = "Add a message";
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();   
       
        $this->load->model('customers_m');

        $this->data['customers']=$this->customers_m->get();

        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

     /**
     * Fetch Messages 
     *
     * @return JSON object
     */
    public function fetchmessages(){
        $customer_id = $this->input->post('customer_id');
        $columns = array('created_date', 'subject', 'status');
        $index = 'id';

        // Number of total records
       // $this->db->where(array('customer_id'=> $customer_id));
        $query=$this->db->get('messages');
        $total_records = $query->num_rows();

        // Get actual records
        $def_where= "customer_id= 0";
        $query = [];
        $query = array_merge($this->_data_table($columns));
       
        if(isset($query['where'])){
             $def_where = $def_where . " AND (".$query['where'].")";
        } 
       
        // Get filter from ajax request in compiled query 
        $this->db->select('*');
        $this->db->where($def_where);
        if(isset($query['orderby'])){
            $this->db->order_by($query['orderby']['field'],$query['orderby']['order']);
        }
        if($this->input->post('length') != '-1') {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query_actual = $this->db->get('messages');
        $data['posts'] = $query_actual->result();     

        // get total filtered records
        $this->db->where($def_where);
        $query_filtered = $this->db->get('messages');
        $filtered_records = $query_filtered->num_rows();

        $itemData = array();
        $output = array(
            "draw"              =>  intval($this->input->post("draw")),
            "recordsTotal"      =>  $total_records,
            "recordsFiltered"   =>  $filtered_records,
            "data"              =>  array()
        );
        foreach($data['posts'] as $post)
        {
            $itemRows = array();  
            $itemRows[] = $post->created_date;      
            $itemRows[] = $post->subject;   
            $itemRows[] = ($post->status==0) ? 'Unsent <button type="button" name="update" id="'.$post->id.'" class="btn btn-primary btn-xs update btn-send-message">Send Now</button>' : "Sent";         
            $itemRows[] = '<button type="button" name="update" id="'.$post->id.'" class="btn btn-info btn-xs update btn-edit-message">Update</button> <button type="button" class="btn btn-warning btn-xs update btn-delete-message">Delete</button>';
            // $itemRows[] = '<button type="button" name="delete" id="'.$employee["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
            $itemRows['DT_RowId'] = $post->id;
            $output['data'][] = $itemRows;
        }       
        echo json_encode($output);
    }


    /**
    * Fetch Contact Data
    *
    * @return JSON object
    */
    public function fetch_message_data()
    {
        $this->load->model('messages_m');
        $this->check_post_ajax_request();
        $return_data = ['status' => 0];
        $id = $this->secure_data($this->input->post('id'));

        if($id) {
            $data=$this->messages_m->get_by(array('id'=>$id), TRUE);
              
            if($data) {
                $return_data['status'] = 1;
                $return_data['message_data'] = $data;
                $return_data['message'] = "Message Fetched Successfully";
            }
            else {
                $return_data['message'] = "Data doesn't exist";
            }
        }
        else {
            $return_data['message'] = "Message Data not available";
        }

        echo json_encode($return_data);
    }

     /**
     * Insert/Update Message
     *
     * @return JSON object
     */
    public function updatemessage()
    {   
        $this->load->model('messages_m');
        $this->check_post_ajax_request();
        $return_data = ['status' => 0];
        $return_data['message'] = "success";
       
        $rules = $this->messages_m->rules;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == TRUE) {
            $id = $this->secure_data($this->input->post('id'));      
            $fields = ['subject','body'];
            foreach($fields as $field) {
                $data[$field] = $this->secure_data($this->input->post($field));
            }
          
            if($id !== '') {
                // Update               
                $this->messages_m->save($id,$data);               
                $utype = 'update';
            }
            else {
                // Insert
                $data['created_date']=date('Y-m-d H:i:s', time());
                $data['customer_id']=$this->secure_data($this->input->post('customer_id'));
                $id=$this->messages_m->save(NULL,$data);
                $utype = 'add';
            }

            $return_data['query'] = $this->db->last_query();
            $return_data['status'] = 1;
            $return_data['utype'] = $utype;
            $return_data['message'] = ($utype === 'add') ? "Message successfully added" : "Message successfully updated";
        }
        else {
            $return_data['message'] = validation_errors();
        }

        echo json_encode($return_data);
    }

    /**
     * Delete Message
     *
     * @return JSON object
     */
    public function deletemessage()
    {   
        $this->load->model('messages_m');

        $this->check_post_ajax_request();

        $return_data = ['status' => 0];
        $id = $this->secure_data($this->input->post('id'));
           
        if($id && $id !== '') {
            $this->messages_m->delete($id);

            $return_data['status'] = 1;
            $return_data['message'] = 'Messages Deleted successfully';
        }
        else {
            $return_data['message'] = "Error occured";
        }

        echo json_encode($return_data);
    }

     /**
     * Send Message
     *
     * @return JSON object
     */
    public function sendmessage()
    {   
        $this->load->model('customers_m');
        $this->load->model('messages_m');
        $this->check_post_ajax_request();
        $return_data = ['status' => 0];
        $id = $this->secure_data($this->input->post('id'));
        $emails= $this->input->post('emails');
       
        if($id && $id !== '') {
            // get messages 
            $msg=$this->messages_m->get($id,TRUE);
            // get customers selected email
            $this->load->model('email_model');
            $temp=[];
            foreach ($emails as $email) {               
                // prevent repeated email sending 
                if(!in_array($email, $temp)){
                   
                    $this->email_model->sendEmailSimple("IMS","info@ims.hificn.com",$email,$msg->subject,$msg->body);

                    //get customer by email id 
                    $customer=$this->customers_m->get_by(array('email'=>$email), TRUE);
                    if($customer){                  
                        $dt['subject']=$msg->subject;
                        $dt['body']=$msg->body;
                        $dt['customer_id']=$customer->id;
                        $dt['status']=1;
                        $dt['created_date']=date('Y-m-d H:i:S', time());
                        $this->messages_m->save(NULL,$dt);
                    }

                   $temp[]= $email;
                }
            }

            //update the message status 
            $data['status']=1;
            $this->messages_m->save($id,$data);

            $return_data['status'] = 1;
            $return_data['message'] = 'Messages Sent successfully';
        }
        else {
            $return_data['message'] = "Error occured";
        }

        echo json_encode($return_data);
    }

}
