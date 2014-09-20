<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Applications_directory extends CI_Controller{
    public $tmpl = '';
    public $user_group_array = array();
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('org/admin/application/admin_application_directory_library');
        $this->load->library('org/admin/access_level/admin_access_level_library');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
        
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }
        
        $this->data['allow_view'] = FALSE;
        $this->data['allow_access'] = FALSE;
        $this->data['allow_write'] = FALSE;
        $this->data['allow_approve'] = FALSE;
        $this->data['allow_edit'] = FALSE;
        $this->data['allow_delete'] = FALSE;
        $this->data['allow_configuration'] = FALSE;
        
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
            $this->data['allow_access'] = TRUE;
            $this->data['allow_write'] = TRUE;
            $this->data['allow_approve'] = TRUE;
            $this->data['allow_edit'] = TRUE;
            $this->data['allow_delete'] = TRUE;
            $this->data['allow_configuration'] = TRUE; 
        }
        else
        {
            $access_level_mapping = $this->admin_access_level_library->get_access_level_info($this->session->userdata('user_id'));
            $this->tmpl = USER_DASHBOARD_TEMPLATE;
            $this->data['access_level_mapping'] = $access_level_mapping;
            
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->data['allow_view'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS, $access_level_mapping))
            {
                $this->data['allow_access'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE, $access_level_mapping))
            {
                $this->data['allow_write'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE, $access_level_mapping))
            {
                $this->data['allow_approve'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT, $access_level_mapping))
            {
                $this->data['allow_edit'] = TRUE;
            }if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE, $access_level_mapping))
            {
                $this->data['allow_delete'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION, $access_level_mapping))
            {
                $this->data['allow_configuration'] = TRUE;  
            }
            if(!$this->data['allow_view'])
            {
                redirect('admin/general/restriction_view', 'refresh');
            }
        }
    }
    
    public function index()
    {
        $this->data['message'] = '';
        $all_applications_array = $this->admin_application_directory_library->get_all_applications()->result_array();
        //echo '<pre>';print_r($all_applications_array);exit('here');
        $this->data['all_applications'] = $all_applications_array;
        $this->template->load(null, "admin/applications/directory/index", $this->data);
    }
    
    /*
     * This method will create a new application
     * @Author Nazmul on 20th September 2014
     */
    public function create_application()
    {
        $this->data['message'] = '';
        $this->form_validation->set_rules('title', 'Title', 'xss_clean|required');
        $this->form_validation->set_rules('description', 'Description', 'xss_clean|required');
        $this->form_validation->set_rules('summary_editortext', 'Summary', 'xss_clean|required');
        
        if($this->input->post())
        {
            if (isset($_FILES["userfile"]))
                {
                    $file_info = $_FILES["userfile"];
                    $uploaded_image_data = $this->image_upload($file_info);
                    if(isset($uploaded_image_data['error'])) {
                        $this->data['message'] = strip_tags($uploaded_image_data['error']);
                        echo json_encode($this->data);
                        return;
                    }else if(!empty($uploaded_image_data['upload_data']['file_name'])){
                        //$path = FCPATH.NEWS_IMAGE_PATH.$uploaded_image_data['upload_data']['file_name'];
                        //unlink($path);
                    }
                }
                
                $app_title = trim(htmlentities($this->input->post('title')));
                $description = trim(htmlentities($this->input->post('description')));
                $summary = trim(htmlentities($this->input->post('summary_editortext')));
                
                $data = array(
                    'title' => $app_title,
                    'description' => $description,
                    'summary' => $summary,
                    'img1' => empty($uploaded_image_data['upload_data']['file_name'])? '' : $uploaded_image_data['upload_data']['file_name'],
                    'created_on' => now()
                );

                $app_id = $this->admin_application_directory_library->create_application($data);
                if($app_id !== FALSE){
                        $this->data['message'] = "Application create is successful";
                        echo json_encode($this->data);
                        return;
                }else{
                    $this->data['message'] = $this->admin_application_directory_library->errors();
                    echo json_encode($this->data);
                    return;
                }
        }
        
        
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => $this->form_validation->set_value('title'),
        );
        
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('description'),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['summary'] = array(
            'name' => 'summary',
            'id' => 'summary',
            'type' => 'text',
            'value' => $this->form_validation->set_value('summary_editortext'),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->template->load(null, "admin/applications/directory/create_application", $this->data);
        
    }
    
    /**
     * function for image uplaod
     * @param type $file_info
     * @return type
     */
    public function image_upload($file_info)
    {
        $data = null;
        if (isset($file_info))
        {
            $config['image_library'] = 'gd2';
            $config['upload_path'] = APPLICATION_DIRECTORY_IMAGE_PATH;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '10240';
            $config['maintain_ratio'] = FALSE;
            $config['width'] = 120;
            $config['height'] = 120;
            $config['create_thumb'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());
                return $data = $error;
            } else {
                $upload_data = $this->upload->data();
                $data = array('upload_data' => $upload_data);
                return $data;
            }
        }
        return $data;

    }
    
    /*
     * This method will update an application
     * @Author Nazmul on 20th September 2014
     */
    public function update_application($application_id = 0)
    {
        if(empty($application_id) or $application_id==0){
            redirect('admin/applications_directory', 'refresh');
        }
        $this->data['message'] = '';
        $this->form_validation->set_rules('title', 'Title', 'xss_clean|required');
        $this->form_validation->set_rules('description', 'Description', 'xss_clean|required');
        $this->form_validation->set_rules('summary_editortext', 'Summary', 'xss_clean|required');
        
        $application_info = array();
        $application_info = $this->admin_application_directory_library->get_application_info($application_id)->result_array();
        if(!empty($application_info))
        {
            $application_info = $application_info[0];
        }
        $this->data['application_info'] = $application_info;
        if($this->input->post())
        {
            
            if (isset($_FILES["userfile"]))
                {
                    $file_info = $_FILES["userfile"];
                    $uploaded_image_data = $this->image_upload($file_info);
                    if(isset($uploaded_image_data['error'])) {
                        $this->data['message'] = strip_tags($uploaded_image_data['error']);
                        echo json_encode($this->data);
                        return;
                    }else if(!empty($uploaded_image_data['upload_data']['file_name'])){
                        //$path = FCPATH.NEWS_IMAGE_PATH.$uploaded_image_data['upload_data']['file_name'];
                        //unlink($path);
                    }
                }
                
                $app_title = $this->input->post('title');
                $description = trim(htmlentities($this->input->post('description')));
                $summary = trim(htmlentities($this->input->post('summary_editortext')));
                
                $data = array(
                    'title' => $app_title,
                    'description' => $description,
                    'summary' => $summary,
                    'img1' => empty($uploaded_image_data['upload_data']['file_name'])?  $application_info['img1'] : $uploaded_image_data['upload_data']['file_name'],
                    'modified_on' => now()
                );
                
                $app_id = $this->admin_application_directory_library->update_application($application_id,$data);
                if($app_id !== FALSE){
                        $this->data['message'] = "Application update is successful";
                        echo json_encode($this->data);
                        return;
                }else{
                    $this->data['message'] = $this->admin_application_directory_library->errors();
                    echo json_encode($this->data);
                    return;
                }
        }
        
        
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => $application_info['title'],
        );
        
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'value' => $application_info['description'],
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['summary'] = array(
            'name' => 'summary',
            'id' => 'summary',
            'type' => 'text',
            'value' => html_entity_decode(html_entity_decode($application_info['summary'])),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        //echo '<pre/>';print_r($this->data);exit();
        
        $this->template->load(null, "admin/applications/directory/update_application", $this->data);
    }
    
}

