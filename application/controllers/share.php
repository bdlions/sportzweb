<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Share extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('notification');
        $this->load->library("statuses");
        $this->load->helper('url');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');

    }
    
    /*
     * Ajax call
     * This methoed will share a post
     */
    public function share_status()
    {
        $current_user_id = $this->session->userdata('user_id');
        $mapping_id = $_POST['mapping_id'];
        $reference_id = $_POST['reference_id'];
        $status_category_id = $_POST['status_category_id'];
        $description = $_POST['description'];
        $shared_type_id = $_POST['shared_type_id'];
        $referenced_user_id = $_POST['referenced_user_id'];
        $status_data = array();
        $status_info = array();
        $status_info_array = $this->statuses->get_status_info($reference_id)->result_array();
        if(!empty($status_info_array))
        {
            $status_info = $status_info_array[0];
            if($status_info['shared_type_id'] == STATUS_SHARE_HEALTHY_RECIPE)
            {
                $status_data['reference_id'] = $status_info['reference_id'];
                $status_data['shared_type_id'] = STATUS_SHARE_HEALTHY_RECIPE;
                $status_data['via_user_id'] = $status_info['user_id'];
            }
            else if($status_info['shared_type_id'] == STATUS_SHARE_SERVICE_DIRECTORY)
            {
                $status_data['reference_id'] = $status_info['reference_id'];
                $status_data['shared_type_id'] = STATUS_SHARE_SERVICE_DIRECTORY;
                $status_data['via_user_id'] = $status_info['user_id'];
            }
            else if($status_info['shared_type_id'] == STATUS_SHARE_NEWS)
            {
                $status_data['reference_id'] = $status_info['reference_id'];
                $status_data['shared_type_id'] = STATUS_SHARE_NEWS;
                $status_data['via_user_id'] = $status_info['user_id'];
            }
            else
            {
                $status_data['reference_id'] = $reference_id;
                $status_data['shared_type_id'] = $shared_type_id;
                //$status_data['via_user_id'] = $status_info['user_id'];
            }            
        }
        $current_time = now();
        $user_list_array = array();
        if(isset($_POST['user_id_list']))
        {
            $user_list_array = $_POST['user_id_list'];
        }
        $reference_list = array();
        foreach($user_list_array as $user_id)
        {
            if($user_id != '')
            {
                $user_info = new stdClass();
                $user_info->id = $user_id;
                //type_id 1 is user id
                $user_info->type_id = 1;
                $reference_list[] = $user_info;
            }            
        } 
        $status_data["reference_list"] = json_encode($reference_list);
        $status_data['user_id'] = $current_user_id;
        $status_data['mapping_id'] = $mapping_id;
        $status_data['status_category_id'] = $status_category_id;
        $status_data['description'] = $description;                
        $status_data['created_on'] = $current_time;
        $status_data['modified_on'] = $current_time;               
        
        if($this->statuses->post_status($status_data) !== FALSE)
        {
            $current_time = now();
            $reference_info_list = new stdClass();
            $reference_info_list->user_id = $current_user_id; //reference id 
            $reference_info_list->status_type = UNREAD_NOTIFICATION;
            $reference_info_list->created_on = $current_time;

            $notification_info_list = new stdClass();
            $notification_info_list->id = '';
            $notification_info_list->created_on = $current_time;
            $notification_info_list->modified_on = $current_time;
            $notification_info_list->type_id = NOTIFICATION_WHILE_SHARES_CREATED_POST;
            $notification_info_list->reference_id = (int) $reference_id; //status_id
            $notification_info_list->reference_id_list = array();
            $notification_info_list->reference_id_list[] = $reference_info_list;
            $response = $this->notification->add_notification($referenced_user_id, $notification_info_list);
           
        echo $response;
        }
        else
        {
            echo STATUS_POST_INSERTION_ERROR;
        }
    }
    
    public function share_application()
    {
        $status_category_id = $_POST['status_category_id'];
        $description = $_POST['description'];
        $reference_id = $_POST['reference_id'];
        $shared_type_id = $_POST['shared_type_id'];
        $current_user_id = $this->session->userdata('user_id');
        $status_data = array(
            'user_id' => $current_user_id,
            'status_category_id' => $status_category_id,
            'description' => $description,
            'reference_id' => $reference_id,
            'shared_type_id' => $shared_type_id,
            'created_on' => now()
        );
        if($this->statuses->post_status($status_data) !== FALSE)
        {
            echo STATUS_POST_SUCCESS;
        }
        else
        {
            echo STATUS_POST_INSERTION_ERROR;
        }
    }
    
    public function share_photo()
    {
        $status_category_id = $_POST['status_category_id'];
        $mapping_id = $_POST['mapping_id'];
        $description = $_POST['description'];
        $reference_id = $_POST['reference_id'];
        $shared_type_id = $_POST['shared_type_id'];
        $status_data = array(
            'user_id' => $this->session->userdata('user_id'),
            'mapping_id' => $mapping_id,
            'status_category_id' => $status_category_id,
            'description' => $description,
            'reference_id' => $reference_id,
            'shared_type_id' => $shared_type_id,
            'created_on' => now()
        );
        if($this->statuses->post_status($status_data) !== FALSE)
        {
            echo STATUS_SHARE_PHOTO_SUCCESS;
        }
        else
        {
            echo STATUS_SHARE_PHOTO_ERROR;
        }
    }
}
