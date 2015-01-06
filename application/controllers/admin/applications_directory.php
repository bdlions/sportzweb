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
        $this->load->library('org/utility/Utils');
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
        $this->data['allow_write'] = FALSE;
        $this->data['allow_edit'] = FALSE;
        
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
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE, $access_level_mapping))
            {
                $this->data['allow_write'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT, $access_level_mapping))
            {
                $this->data['allow_edit'] = TRUE;
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
        $this->data['all_applications'] = $all_applications_array;
        $this->template->load($this->tmpl, "admin/applications/directory/index", $this->data);
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
            $app_title = trim(htmlentities($this->input->post('title')));
            $description = trim(htmlentities($this->input->post('description')));
            $summary = trim(htmlentities($this->input->post('summary_editortext')));
            $data = array(
                'title' => $app_title,
                'description' => $description,
                'summary' => $summary,
                'created_on' => now()
            );
            $app_id = $this->admin_application_directory_library->create_application($data);
            if($app_id !== FALSE){
                    $this->data['message'] = "Application is created successfully";
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
        $this->template->load($this->tmpl, "admin/applications/directory/create_application", $this->data);        
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
        $application_info_array = $this->admin_application_directory_library->get_application_info($application_id)->result_array();
        if(!empty($application_info_array))
        {
            $application_info = $application_info_array[0];
        }
        $this->data['application_info'] = $application_info;
        if($this->input->post())
        {     
            $app_title = $this->input->post('title');
            $description = trim(htmlentities($this->input->post('description')));
            $summary = trim(htmlentities($this->input->post('summary_editortext')));

            $data = array(
                'title' => $app_title,
                'description' => $description,
                'summary' => $summary,
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
        $this->data['image_type_list'] = array(
            APPLICATION_DIRECTORY_IMAGE1_TYPE_ID => 'Icon',
            APPLICATION_DIRECTORY_IMAGE2_TYPE_ID => 'Slider',
            //APPLICATION_DIRECTORY_IMAGE_GALLERY_TYPE_ID => 'Gallery',
            APPLICATION_DIRECTORY_GALLERY_IMAGE1_ID => 'Gallery Image1',
            APPLICATION_DIRECTORY_GALLERY_IMAGE2_ID => 'Gallery Image2',
            APPLICATION_DIRECTORY_GALLERY_IMAGE3_ID => 'Gallery Image3',
            APPLICATION_DIRECTORY_GALLERY_IMAGE4_ID => 'Gallery Image4'
        );
        $this->template->load($this->tmpl, "admin/applications/directory/update_application", $this->data);
    }
    
    /*
     * This method will add image under an application
     * @Author Nazmul on 12th October 2014
     */
    public function update_application_directory_image($application_id = 0)
    {
        if (isset($_FILES["userfile"]))
        {
            $user_id = $this->session->userdata('user_id');
            $img = $user_id.'_'.now().'.jpg';
            $file_info = $_FILES["userfile"];
            $result = $this->utils->upload_image($file_info, APPLICATION_DIRECTORY_IMAGE_PATH);
            if( $result['status'] == 1 ) {
                $image_name = $result['upload_data']['file_name'];
                $image_type_list_id = $this->input->post('image_type_list');
                if($image_type_list_id == APPLICATION_DIRECTORY_IMAGE1_TYPE_ID)
                {
                    $this->utils->resize_image(APPLICATION_DIRECTORY_IMAGE_PATH.$image_name, APPLICATION_DIRECTORY_IMAGE_PATH.$img, APPLICATION_DIRECTORY_IMAGE1_HEIGHT, APPLICATION_DIRECTORY_IMAGE1_WIDTH);
                    $data = array(
                        'img1' => $img,
                        'modified_on' => now()
                    );
                    $this->admin_application_directory_library->update_application($application_id,$data);
                }
                else if($image_type_list_id == APPLICATION_DIRECTORY_IMAGE2_TYPE_ID)
                {
                    $this->utils->resize_image(APPLICATION_DIRECTORY_IMAGE_PATH.$image_name, APPLICATION_DIRECTORY_IMAGE_PATH.$img, APPLICATION_DIRECTORY_IMAGE2_HEIGHT, APPLICATION_DIRECTORY_IMAGE2_WIDTH);
                    $data = array(
                        'img2' => $img,
                        'modified_on' => now()
                    );
                    $this->admin_application_directory_library->update_application($application_id,$data);
                }
                else
                {
                    $this->utils->resize_image(APPLICATION_DIRECTORY_IMAGE_PATH.$image_name, APPLICATION_DIRECTORY_GALLERY_SMALL_IMAGE_PATH.$img, APPLICATION_DIRECTORY_GALLERY_IMAGE_SMALL_HEIGHT, APPLICATION_DIRECTORY_GALLERY_IMAGE_SMALL_WIDTH);
                    $this->utils->resize_image(APPLICATION_DIRECTORY_IMAGE_PATH.$image_name, APPLICATION_DIRECTORY_GALLERY_LARGE_IMAGE_PATH.$img, APPLICATION_DIRECTORY_GALLERY_IMAGE_LARGE_HEIGHT, APPLICATION_DIRECTORY_GALLERY_IMAGE_LARGE_WIDTH);
                    
                    $data = array(
                        'id' => $image_type_list_id,
                        'img' => $img
                    );
                    $this->admin_application_directory_library->add_gallery_image($application_id, $data);                    
                }    
                $this->utils->delete_image(APPLICATION_DIRECTORY_IMAGE_PATH.$image_name);
            }
            echo json_encode($result);
            return;
        }
    }
    
}

