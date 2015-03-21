<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service_directory extends Role_Controller {

    function __construct() {
        parent::__construct();
        $this->lang->load('auth');
        
        $this->load->helper('language');
        $this->load->helper('url');
        $this->load->library('visitors');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('org/application/service_directory_library');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    /*
     * Writen by Omar faruk
     */

    function index() {
        $this->data['message'] = '';
        $this->template->load(null, "applications/service_directory/service_directory_home", $this->data);
    }
    function service_directory_map() {
        $this->data['message'] = '';
        $this->data['another_town'] = 'london_';
        $this->form_validation->set_rules('towncode', '', 'xss_clean');
        $this->form_validation->set_rules('check', '', 'xss_clean');
        $this->data['towncode'] = "";
        $this->data['selected_services'] = "";
        $this->data['services'] = "";
        if ($this->input->post('submit_service_directory')) {
            $towncode = $this->input->post('towncode');
            $selected_services_id = $this->input->post('service');
            $this->data['another_town'] = $towncode;
            $this->data['selected_services'] = $towncode;
            $this->data['selected_services_id'] = $selected_services_id;
            $this->data['towncode'] = $towncode;
            $services_array = $this->service_directory_library->get_all_services($selected_services_id)->result_array();
            $this->data['services'] = $services_array;
        }
        $service_category_list = $this->service_directory_library->get_all_service_categories()->result_array();
        
//        $this->data['selected_services'] = $seled_service;
        
        $this->data['service_category_list'] = $service_category_list;
        $this->data['service_info'] = $service_category_list;
        
        $visit_success = $this->visitors->store_application_visitor(APPLICATION_SERVICE_DIRECTORY_ID);
        $this->template->load(null, "applications/service_directory/service_directory_view", $this->data);
    }
    /*
     * This method will display details of a service
     * @param $service_id, service id
     * @Author Nazmul on 1st March 2015
     */
    public function show_service_detail($service_id = 0)
    {
        
        $service_info = $this->service_directory_library->get_service_info($service_id)->result_array();
        $service_comment = $this->service_directory_library->get_all_comments($service_id, NEWEST_FIRST,DEFAULT_VIEW_PER_PAGE);
        if(count($service_info)>0) {
            $service_info = $service_info[0];
        }
        $this->data['service_info'] = $service_info;
        $this->data['comments'] = $service_comment;
        $this->data['user_info'] = $this->ion_auth->get_user_info();
        $this->data['application_id'] = APPLICATION_SERVICE_DIRECTORY_ID;
        $this->data['item_id'] = $service_info['service_id'];
        
        $this->template->load(NULL, "applications/service_directory/service_detail_view", $this->data);
    }
    //Ajax call to save comment
    //Written by Omar Faruk
    function post_comment()
    {
        $response = array();
        $comment = trim($_POST['comment']);
        $comment_nature = $_POST['comment_nature'];
        if($comment_nature == 'Neutral') {
            $rate_id = 0;
        } else if($comment_nature == 'Negative') {
            $rate_id = 2;
        } else {
            $rate_id = 1;
        }
        
        $data = array(
            'comment' => $comment,
            'rate_id' => $rate_id,
            'user_id' => $this->session->userdata('user_id'),
            'service_id' => $_POST['service_id'],
            'created_on' => now()
        );
        
        //echo '<pre/>';print_r($data);exit('i m here');

        $id = $this->service_directory_library->create_comment($data);

        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Comments is added successfully.';
            $service_comment_info_array = $this->service_directory_library->get_comment_info($id)->result_array();
            if(!empty($service_comment_info_array))
            {
                $response['service_comment_info'] = $service_comment_info_array[0];
            }             
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_service_directory->errors_alert();
        }
        
       echo json_encode($response);
    }
    
    //Ajax call to save comment
    //Written by Omar Faruk
    function edit_comment()
    {
        $response = array();
        $comment_id = trim($_POST['comment_id']);
        $comment = trim($_POST['comment']);
        $comment_nature = $_POST['comment_nature'];
        if($comment_nature == 'Neutral') {
            $rate_id = 0;
        } else if($comment_nature == 'Negative') {
            $rate_id = 2;
        } else {
            $rate_id = 1;
        }
        
        $data = array(
            'comment' => $comment,
            'rate_id' => $rate_id,
            'user_id' => $this->session->userdata('user_id'),
            'service_id' => $_POST['service_id'],
            'modified_on' => now()
        );
        
        //echo '<pre/>';print_r($data);exit('i m here');

        $id = $this->service_directory_library->update_comment($comment_id, $data);

        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Comments is update successfully.';
            $service_comment_info_array = $this->service_directory_library->get_comment_info($comment_id)->result_array();
            if(!empty($service_comment_info_array))
            {
                $response['service_comment_info'] = $service_comment_info_array[0];
            }     
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_service_directory->errors_alert();
        }
        
       echo json_encode($response);
    }
    
    function remove_comment()
    {
        $response = array();
        $comment_id = $this->input->post('comment_id');

        $id = $this->service_directory_library->remove_comment($comment_id);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Comments is removed successfully.';   
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_service_directory->errors_alert();
        }
        
       echo json_encode($response);
    }

}

?>
