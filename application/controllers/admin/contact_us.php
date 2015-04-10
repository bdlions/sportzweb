<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact_us extends Admin_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/admin/access_level/admin_access_level_library');
        $this->load->library('org/admin/footer/admin_contact_us_library');
        $this->load->library('org/utility/Utils');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
        
        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }
        
        $this->data['allow_view'] = FALSE;
        $this->data['allow_write'] = FALSE;
        $this->data['allow_edit'] = FALSE;
        $this->data['allow_delete'] = FALSE;
        
        $selected_user_group = $this->session->userdata('user_type');
        if(isset($selected_user_group ) && $selected_user_group != ""){
            $this->user_group_array = array($selected_user_group);
        }
        else
        {
            $this->user_group_array = $this->ion_auth->get_current_user_types();
        } 
        if (in_array(ADMIN, $this->user_group_array)) {
            $this->tmpl = ADMIN_DASHBOARD_TEMPLATE;
            $this->data['allow_view'] = TRUE;
            $this->data['allow_write'] = TRUE;      
            $this->data['allow_edit'] = TRUE;
            $this->data['allow_delete'] = TRUE;
        }
        else
        {
            $access_level_mapping = $this->admin_access_level_library->get_access_level_info($this->session->userdata('user_id'));
            $this->tmpl = USER_DASHBOARD_TEMPLATE;
            $this->data['access_level_mapping'] = $access_level_mapping;
            
            if(array_key_exists(ADMIN_ACCESS_LEVEL_FOOTER_CONTACT_US_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->data['allow_view'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_FOOTER_CONTACT_US_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE, $access_level_mapping))
            {
                $this->data['allow_write'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_FOOTER_CONTACT_US_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT, $access_level_mapping))
            {
                $this->data['allow_edit'] = TRUE;
            }if(array_key_exists(ADMIN_ACCESS_LEVEL_FOOTER_CONTACT_US_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE, $access_level_mapping))
            {
                $this->data['allow_delete'] = TRUE;
            }
            if(!$this->data['allow_view'])
            {
                redirect('admin/general/restriction_view', 'refresh');
            }
        }
    }
    
    /*
     * Thie method will load home page of contact us at admin panel
     * @Author Nazmul on 23rd January 2015
     */
    public function index()
    {        
//        $feedback_list = $this->admin_contact_us_library->get_all_feedbacks();
        $this->data['feedback_list'] = array();
        $this->template->load($this->tmpl, "admin/footer/contact_us/index", $this->data);
    }
    /*
     * Thie method will load member feedback list
     * @Author Nazmul on 23rd January 2015
     */
    public function member_feedback()
    {
        $feedback_list = array();
        $feedback_list_array = $this->admin_contact_us_library->get_member_feedbacks();
        if (!empty($feedback_list_array)) {
            $feedback_list = $feedback_list_array;
        }
        $this->data['feedback_list'] = $feedback_list;
        $this->template->load($this->tmpl, "admin/footer/contact_us/feedback_member", $this->data);
    }
    
    public function delete_feedback()
    {
        $result = array();
        $feedback_id = $this->input->post('id');
        if($this->admin_contact_us_library->delete_feedback($feedback_id))
        {
            $result['message'] = $this->admin_contact_us_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_contact_us_library->errors_alert();
        }
        echo json_encode($result);
    }
    

    /*
     * Thie method will load non member feedback list
     * @Author Nazmul on 23rd January 2015
     */
    public function non_member_feedback()
    {
        $feedback_list = array();
        $feedback_list_array = $this->admin_contact_us_library->get_non_member_feedbacks();
        if (!empty($feedback_list_array)) {
            $feedback_list = $feedback_list_array;
        }
        $this->data['feedback_list'] = $feedback_list;
        $this->template->load($this->tmpl, "admin/footer/contact_us/feedback_non_member", $this->data);
    }
    
    
    
//    TOPICS
    public function manage_topic()
    {
        $this->data['all_topics'] = array();
        $all_topics_array = $this->admin_contact_us_library->get_all_topics()->result_array();
        if(!empty($all_topics_array))
        {
            $this->data['all_topics'] = $all_topics_array;
        }
        $this->template->load($this->tmpl, "admin/footer/contact_us/topic_list", $this->data);
    }
    public function get_topic_info()
    {
        $result = array();
        $topic_id = $this->input->post('topic_id');
        $topic_info_array = $this->admin_contact_us_library->get_topic_info($topic_id)->result_array();
        if(!empty($topic_info_array))
        {
            $result['topic_info'] = $topic_info_array[0];
        }
        echo json_encode($result);
    }
    
    public function edit_topic()
    {
        $topic_id = $this->input->post('topic_id');
        $new_topic_name = $this->input->post('new_topic_name');
        $data = array(
            'title' => $new_topic_name,
            'modified_on' => now()
        );
        $this->admin_contact_us_library->update_topic($topic_id, $data);
        $result = array(
            'message' => 'Topic is updated successfully.'
        );
        echo json_encode($result);
    }
    public function create_topic()
    {
        $topic_name = $this->input->post('input_topic_name');
        $data = array(
            'title' => $topic_name,
            'created_on' => now()
        );
        $this->admin_contact_us_library->add_topic($data);
        $result = array(
            'message' => 'Topic is added successfully.'
        );
        echo json_encode($result);
    }
    public function delete_topic()
    {
        $del_item_id = $this->input->post('del_id');
        
        $data = array(
            'id' => $del_item_id
        );
        $this->admin_contact_us_library->delete_topic($del_item_id);
        $result = array(
            'message' => 'Item deleted successfully.'
        );
        echo json_encode($result);
    }
    
//    OS
    public function get_os_info()
    {
        $result = array();
        $os_id = $this->input->post('os_id');
        $os_info_array = $this->admin_contact_us_library->get_operating_system_info($os_id)->result_array();
        if(!empty($os_info_array))
        {
            $result['os_info'] = $os_info_array[0];
        }
        echo json_encode($result);
    }
    public function create_os()
    {
        $new_os_name = $this->input->post('new_os_name');
        $data = array(
            "title" => $new_os_name,
            "created_on" => now()
        );
        $this->admin_contact_us_library->add_operaging_system($data);
        
        $result = array(
            'message' => 'Operating system created successfully.'
        );
        echo json_encode($result);
    }
    public function edit_os()
    {
        $os_id = $this->input->post('os_id');
        $new_os_name = $this->input->post('new_os_name');
        
        $data = array(
            'title' => $new_os_name,
            'modified_on' => now()
        );
        $this->admin_contact_us_library->update_operating_system($os_id, $data);
        $result = array(
            'message' => 'Topic is updated successfully.'
        );
        echo json_encode($result);
    }
    public function delete_operaging_system()
    {
        $del_item_id = $this->input->post('del_id');
        
        $data = array(
            'id' => $del_item_id
        );
        $this->admin_contact_us_library->delete_operaging_system($del_item_id);
        $result = array(
            'message' => 'Item deleted successfully.'
        );
        echo json_encode($result);
    }
    public function manage_os()
    {
        $this->data['all_os'] = array();
        $all_os = $this->admin_contact_us_library->get_all_operating_systems()->result_array();
        if(!empty($all_os))
        {
            $this->data['all_os'] = $all_os;
        }
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/footer/contact_us/operating_system_list", $this->data);
    }
    
    
//    BROWSER
    public function get_browser_info()
    {
        $result = array();
        $browser_id = $this->input->post('browser_id');
        $browser_info_array = $this->admin_contact_us_library->get_browser_info($browser_id)->result_array();
        if(!empty($browser_info_array))
        {
            $result['browser_info'] = $browser_info_array[0];
        }
        echo json_encode($result);
    }
    
    public function create_browser()
    {
        $new_browser_name = $this->input->post('new_browser_name');
        $data = array(
            'title' => $new_browser_name,
            'created_on' => now()
        );
        $this->admin_contact_us_library->add_browser($data);
        $result = array(
            'message' => 'New browser is added successfully.'
        );
        echo json_encode($result);
        
    }
    public function edit_browser()
    {
        $new_browser_name = $this->input->post('new_browser_name');
        $browser_id = $this->input->post('browser_id');
        $data = array(
            'title' => $new_browser_name,
            'modified_on' => now()
        );
        $this->admin_contact_us_library->update_browser($browser_id, $data);
        $result = array(
            'message' => 'Browser info is updated successfully.'
        );
        echo json_encode($result);
    }
    public function delete_browser()
    {
        $del_item_id = $this->input->post('del_id');
        
        $data = array(
            'id' => $del_item_id
        );
        $this->admin_contact_us_library->delete_browser($del_item_id);
        $result = array(
            'message' => 'Item deleted successfully.'
        );
        echo json_encode($result);
    }
    public function manage_browser()
    {
        $this->data['all_browsers'] = array();
        $all_browsers_array = $this->admin_contact_us_library->get_all_browers()->result_array();
        if(!empty($all_browsers_array))
        {
            $this->data['all_browsers'] = $all_browsers_array;
        }
        $this->template->load($this->tmpl, "admin/footer/contact_us/browser_list", $this->data);
    }
}

