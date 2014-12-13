<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Applications_servicedirectory extends CI_Controller{
    public $tmpl = '';
    public $user_group_array = array();
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('org/admin/application/admin_service_directory');
        $this->load->library('org/admin/access_level/admin_access_level_library'); 
        $this->load->library('org/utility/utils');
        $this->load->library('excel');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->helper('language');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
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
            
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->data['allow_view'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS, $access_level_mapping))
            {
                $this->data['allow_access'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE, $access_level_mapping))
            {
                $this->data['allow_write'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE, $access_level_mapping))
            {
                $this->data['allow_approve'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT, $access_level_mapping))
            {
                $this->data['allow_edit'] = TRUE;
            }if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE, $access_level_mapping))
            {
                $this->data['allow_delete'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION, $access_level_mapping))
            {
                $this->data['allow_configuration'] = TRUE;  
            }
            if(!$this->data['allow_view'])
            {
                redirect('admin/general/restriction_view', 'refresh');
            }
        }

    }    
    function index()
    {
        $this->data['message'] = '';
        
        $service_category_list = array();
        $service_category_list_array = $this->admin_service_directory->get_all_service_category()->result_array();
        if(!empty($service_category_list_array))
        {
            $service_category_list = $service_category_list_array;
        }
        $this->data['service_category_list'] = $service_category_list;
        $this->template->load($this->tmpl, "admin/applications/service_directory/service_category", $this->data);
    }
    
    //Ajax call for create service category
    //Written by Omar Faruk
    /*function create_service_category()
    {
        $response = array();
        $service_category_name = $_POST['service_category_name'];
        
        $additional_data = array(
            'application_id' => APPLICATION_SERVICE_DIRECTORY_ID
        );

        $id = $this->admin_service_directory->create_service_category($service_category_name, $additional_data);
        
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Service Category is added successfully.';
            $service_service_info_array = $this->admin_service_directory->get_service_category_info($id)->result_array();
            if(!empty($service_service_info_array))
            {
                $response['service_category_info'] = $service_service_info_array[0];
            }             
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_service_directory->errors_alert();
        }
        echo json_encode($response);
    }*/
    
    function create_service_category()
    {
        $this->data['message'] = '';
        
        $this->form_validation->set_rules('title', 'Title', 'xss_clean|required');
        
        if ($this->input->post()) 
        {         
            if($this->form_validation->run() == true)
            {
                if (isset($_FILES["userfile"]))
                {
                    $file_info = $_FILES["userfile"];
                    $uploaded_image_data = $this->image_upload($file_info,SERVICE_DIRECTORY_CATEGORY_IMAGE_PATH);
                    if(isset($uploaded_image_data['error'])) {
                        $this->data['message'] = strip_tags($uploaded_image_data['error']);
                        echo json_encode($this->data);
                        return;
                    } else if(!empty($uploaded_image_data['upload_data']['file_name'])){
                        $path = FCPATH.'/resources/images/applications/service_directory/'.$uploaded_image_data['upload_data']['file_name'];
                        unlink($path);
                    }
                }
                
                $service_category_name = $this->input->post('title');
                $additional_data = array(
                    'picture' => empty($uploaded_image_data['upload_data']['file_name'])? '' : $uploaded_image_data['upload_data']['file_name'],
                    'created_on' => now(),
                );
                
                $id = $this->admin_service_directory->create_service_category($service_category_name, $additional_data);
                if($id !== FALSE) {
                    $this->data['message'] = "Service category create is successfully";
                    echo json_encode($this->data);
                    return;
                }else{
                    $this->data['message'] = strip_tags($this->admin_service_directory->errors());
                    echo json_encode($this->data);
                    return;
                }
            }
            else 
            {
                $this->data['message'] = strip_tags(validation_errors());
                echo json_encode($this->data);
                return;
            } 
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message');
            $this->data['message'] = validation_errors();
        }
        
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => $this->form_validation->set_value('title'),
        );
        
        $this->template->load($this->tmpl, "admin/applications/service_directory/create_service_category", $this->data);
        
    }
    
    //Ajax call for edit service category
    //Written by Omar Faruk
    /*function edit_service_category()
    {
        $response = array();
        $service_category_id = $_POST['service_category_id'];
        $service_category_name = $_POST['service_category_name'];
        //echo $service_category_id . ' ' . $service_category_name; exit;
        $additional_data = array(
            'description' => $service_category_name,
            'application_id' => APPLICATION_SERVICE_DIRECTORY_ID
        );
        $id = $this->admin_service_directory->update_service_category($service_category_id, $additional_data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Service Category is Update successfully.';
            $service_category_info_array = $this->admin_service_directory->get_service_category_info($service_category_id)->result_array();
            if(!empty($service_category_info_array))
            {
                $response['service_category_info'] = $service_category_info_array[0];
            }             
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_service_directory->errors_alert();
        }
        echo json_encode($response);
    }*/
    
    function edit_service_category($service_category_id = 0)
    {
        $this->data['message'] = '';
        $this->form_validation->set_rules('title', 'Title', 'xss_clean|required');
        
        $service_category_info_array = $this->admin_service_directory->get_service_category_info($service_category_id)->result_array();
        if(!empty($service_category_info_array))
        {
            $service_category_info_array = $service_category_info_array[0];
        }else{
            $this->session->set_flashdata('error_message', 'This service category is not exits.');
            redirect("admin/servicedirectory/edit_service_category/".$service_category_id, 'refresh');
        }
        $this->data['service_category_info'] = $service_category_info_array;
        
        if ($this->input->post()) 
        {        
            if($this->form_validation->run() == true)
            {
                if (isset($_FILES["userfile"]))
                {
                    $file_info = $_FILES["userfile"];
                    //$uploaded_image_data = $this->image_upload($file_info);
                    $uploaded_image_data = $this->image_upload($file_info,SERVICE_DIRECTORY_CATEGORY_IMAGE_PATH);
                    if(isset($uploaded_image_data['error'])) {
                        $this->data['message'] = strip_tags($uploaded_image_data['error']);
                        echo json_encode($this->data);
                        return;
                    } else if(!empty($uploaded_image_data['upload_data']['file_name'])){
                        $path = FCPATH.SERVICE_IMAGE_UPLOAD_PATH.$uploaded_image_data['upload_data']['file_name'];
                        unlink($path);
                    }
                }
                
                
                $service_category_name = $this->input->post('title');
                $additional_data = array(
                    'description' => $service_category_name,
                    'modified_on' => now(),
                );
                
                 if(!empty($uploaded_image_data) && ($uploaded_image_data['upload_data']['file_name'] != null)) {
                    $path = FCPATH.SERVICE_DIRECTORY_CATEGORY_IMAGE_PATH.$service_category_info_array['picture'];
                    unlink($path);
                    $additional_data['picture'] = $uploaded_image_data['upload_data']['file_name'];
                }
                               
                $id = $this->admin_service_directory->update_service_category($service_category_id, $additional_data);
                if($id !== FALSE)
                {
                    $this->data['status'] = 1;
                    $this->data['message'] = 'Service Category is Update successfully.';
                    echo json_encode($this->data);
                    return;
                }
                else
                {
                    $this->data['status'] = 0;
                    $this->data['message'] = strip_tags($this->admin_service_directory->errors_alert());
                    echo json_encode($this->data);
                    return;
                }
            } else {
                $this->data['message'] = validation_errors();
                echo json_encode($this->data);
                return;
            }
        }
        
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => $service_category_info_array['description'],
        );
        
        $this->data['service_category_id'] = $service_category_id;
        
        $this->template->load($this->tmpl, "admin/applications/service_directory/edit_service_category", $this->data);
        
    }
    
    public function get_service_data()
    {
        $response = array();
        $service_category_id = $_POST['service_category_id'];
        
        $service_category_array = $this->admin_service_directory->get_service_category_info($service_category_id)->result_array();
        if(!empty($service_category_array))
        {
            $response = $service_category_array[0];
        }
        echo json_encode($response);
    }
    
    function service_category($service_category_id = 0)
    {
        $this->data['message'] = '';
        $this->data['service_category_id'] = $service_category_id;
        $services_list = array();
        $service_list_array = $this->admin_service_directory->get_all_services($service_category_id)->result_array();
        $this->data['services_list'] = $service_list_array;
        $this->template->load($this->tmpl, "admin/applications/service_directory/services", $this->data);
    }
    
    function create_service($service_category_id = 0)
    {
        $this->data['message'] = '';
        
        $this->form_validation->set_rules('name', 'Name', 'xss_clean|required');
        $this->form_validation->set_rules('title', ' Title', 'xss_clean|required');
        $this->form_validation->set_rules('latitude', 'Latitude', 'xss_clean|required');
        $this->form_validation->set_rules('longitude', 'Longitude', 'xss_clean|required');
        $this->form_validation->set_rules('address', 'Address', 'xss_clean|required');
        $this->form_validation->set_rules('city', 'City', 'xss_clean|required');
        $this->form_validation->set_rules('post_code', 'Post Code', 'xss_clean|required');
        
        if ($this->input->post()) 
        {           
            if($this->form_validation->run() == true)
            {
               $service_category_id = $this->input->post('service_category_id');
                
                if (isset($_FILES["userfile"]))
                {
                    $file_info = $_FILES["userfile"];
                    $uploaded_image_data = $this->image_upload($file_info,SERVICE_IMAGE_PATH);
                    if(isset($uploaded_image_data['error'])) {
                        $this->data['error_message'] = strip_tags($uploaded_image_data['error']);
                        echo json_encode($this->data);
                        return;
                    }else if(!empty($uploaded_image_data['upload_data']['file_name'])){
                        $path = FCPATH.SERVICE_IMAGE_UPLOAD_PATH.$uploaded_image_data['upload_data']['file_name'];
                        //unlink($path);
                    }
                }
                
                $service_name = $this->input->post('title');
                $data = array(
                    'name' => $this->input->post('name'),
                    'latitude' => $this->input->post('latitude'),
                    'longitude' => $this->input->post('longitude'),
                    'address' => $this->input->post('address'),
                    'city' => $this->input->post('city'),
                    'country_id' => $this->input->post('country_name'),
                    'opening_hours' => $this->input->post('opening_hours'),
                    'post_code' => $this->input->post('post_code'),
                    'telephone' => $this->input->post('telephone'),
                    'service_category_id'  => $service_category_id,
                    'business_profile_id'   => $this->input->post('business_profile_id'),
                    'website' => $this->input->post('website'),
                    'picture' => empty($uploaded_image_data['upload_data']['file_name'])? '' : $uploaded_image_data['upload_data']['file_name'],
                    'created_on' => now(),
                );
                
                $id = $this->admin_service_directory->create_service($service_name, $data);
                if($id !== FALSE) {
                    $this->data['message'] = "Service create is successful";
                    echo json_encode($this->data);
                    return;
                }else{
                    $this->data['message'] = strip_tags($this->admin_service_directory->errors());
                    echo json_encode($this->data);
                    return;
                }
            }
            else 
            { 
                $this->data['message'] = strip_tags(validation_errors());
                echo json_encode($this->data);
                return;
            }
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message');
            $this->data['message'] = validation_errors();
        }
        
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => $this->form_validation->set_value('title'),
        );
        
        $this->data['name'] = array(
            'name'  => 'name',
            'id'    => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name'),
        );
        $this->data['latitude'] = array(
            'name'  => 'latitude',
            'id'    => 'latitude',
            'type' => 'text',
            'value' => $this->form_validation->set_value('latitude')
        );   
        $this->data['longitude'] = array(
            'name'  => 'longitude',
            'id'    => 'longitude',
            'type' => 'text',
            'value' => $this->form_validation->set_value('longitude')
        );
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'text',
            'value' => $this->form_validation->set_value('address'),
            'rows'  => '4',
            'cols'  => '10'
        );
        $this->data['city'] = array(
            'name' => 'city',
            'id' => 'city',
            'type' => 'text',
            'value' => $this->form_validation->set_value('city')
        );
        
        $this->data['post_code'] = array(
            'name' => 'post_code',
            'id' => 'post_code',
            'type' => 'text',
            'value' => '',
        );
         
        $this->data['opening_hours'] = array(
            'name' => 'opening_hours',
            'id' => 'opening_hours',
            'type' => 'text',
            'value' => '',
        );
        
        $this->data['telephone'] = array(
            'name' => 'telephone',
            'id' => 'telephone',
            'type' => 'text',
            'value' => '',
            'onkeydown'=>'validateNumberAllowDecimal(event, true)'
        );
        
        $this->data['website'] = array(
            'name' => 'website',
            'id' => 'website',
            'type' => 'text',
            'value' => '',
        );
        
        $this->data['submit_create_service'] = array(
            'name' => 'submit_create_service',
            'id' => 'submit_create_service',
            'type' => 'submit',
            'value' => 'Add',
        );
        
        $country_list_array = $this->admin_service_directory->get_all_country()->result_array();
        foreach ($country_list_array as $key => $country) {
            $this->data['country_list'][$country['id']] = $country['country_name'];
        }
        
        $business_profiles_array = $this->admin_service_directory->get_all_business_profile()->result_array();
        foreach ($business_profiles_array as $profile) {
            $this->data['business_profile_list'][$profile['id']] = $profile['business_description'];
        }
        
        $this->data['service_category_id'] = $service_category_id;
        $this->template->load($this->tmpl, "admin/applications/service_directory/create_service", $this->data);
    }
    
    /**
     * omar faruk
     * @param type $file_info
     * @return type array()
     */
    public function image_upload($file_info, $upload_path)
    {
        $data = array();
        if (isset($file_info))
        {
            $config['image_library'] = 'gd2';
            //$config['upload_path'] = './resources/images/applications/service_directory';
            $config['upload_path'] = SERVICE_IMAGE_UPLOAD_PATH;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '10240';
            $config['maintain_ratio'] = FALSE;
            //$config['width'] = 120;
            //$config['height'] = 120;
            $config['create_thumb'] = TRUE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());
                return $data = $error;
            } else {
                $upload_data = $this->upload->data();
                if($upload_path == 'resources/images/applications/service_directory/services/') {
                    $width = 250;
                    $height = 250;
                } else if($upload_path == 'resources/images/applications/service_directory/service_category/') {
                    $width = 13;
                    $height = 13;
                }

                $this->resize_uploaded_image($upload_data,$width,$height,$upload_path);
                $data = array('upload_data' => $upload_data);
                return $data;
            }
        }
        return $data;
    }
    
    /**
     * writen by omar faruk
     * to resize an uploaded image in a new directory
     * @param type $image_data
     * @param type $width
     * @param type $height
     * @param type $new_path
     */
    public function resize_uploaded_image($image_data,$width=13,$height=13,$new_path ) {
        $config2 = array(
            'source_image' => $image_data['full_path'],
            'new_image' => $new_path,
            'maintain_ration' => TRUE,
            'width' => $width,
            'height' => $height
        );
       
        $this->load->library('image_lib');
        $this->image_lib->initialize($config2);

        if (!$this->image_lib->resize()) {
           $data = array('error' => $this->image_lib->display_errors());
           //echo $this->image_lib->display_errors();
        }
        $this->image_lib->resize();
        $this->image_lib->clear();
    }

    function delete_service_catagory()
    {
       $service_id = $_POST['service_id'];
        if($this->admin_service_directory->remove_service_category($service_id))
        {
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }
    function delete_service()
    {
        $service_id = $_POST['service_id'];
        if($this->admin_service_directory->remove_service($service_id))
        {
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }
    function service_edit($service_id = 0)
    {
        $this->data['message'] = '';
        $this->form_validation->set_rules('name', 'Name', 'xss_clean|required');
        $this->form_validation->set_rules('title', ' Title', 'xss_clean|required');
        $this->form_validation->set_rules('latitude', 'Latitude', 'xss_clean|required');
        $this->form_validation->set_rules('longitude', 'Longitude', 'xss_clean|required');
        $this->form_validation->set_rules('address', 'Address', 'xss_clean|required');
        $this->form_validation->set_rules('city', 'City', 'xss_clean|required');
        $this->form_validation->set_rules('post_code', 'Post Code', 'xss_clean|required');
        
        $service_info = array();
        $service_info_array = $this->admin_service_directory->get_service_info($service_id)->result_array();
       
        if(empty($service_info_array))
        {
            $this->session->set_flashdata('error_message', 'For this service no data fount');
            redirect("admin/applications_servicedirectory","refresh");
        }
        else
        {
            $service_info = $service_info_array[0];
        }
        
        if ($this->input->post()) 
        {            
            if($this->form_validation->run() == true)
            {  
                $uploaded_image_data = array();
                if (isset($_FILES["userfile"]))
                {
                    $file_info = $_FILES["userfile"];
                    $uploaded_image_data = $this->image_upload($file_info, SERVICE_IMAGE_PATH);
                    if(isset($uploaded_image_data['error'])) {
                        $this->data['message'] = strip_tags($uploaded_image_data['error']);
                        echo json_encode($this->data);
                        return;
                    }else if(!empty($uploaded_image_data['upload_data']['file_name'])){
                        $path = FCPATH.SERVICE_IMAGE_UPLOAD_PATH.$uploaded_image_data['upload_data']['file_name'];
                        //unlink($path);
                    }
                }
                
                $service_name = $this->input->post('title');
                $data = array(
                    'name' => $this->input->post('name'),
                    'title' => $service_name,
                    'latitude' => $this->input->post('latitude'),
                    'longitude' => $this->input->post('longitude'),
                    'address' => $this->input->post('address'),
                    'city' => $this->input->post('city'),
                    'country_id' => $this->input->post('country_name'),
                    'opening_hours' => $this->input->post('opening_hours'),
                    'post_code' => $this->input->post('post_code'),
                    'telephone' => $this->input->post('telephone'),
                    'service_category_id'  => $this->input->post('service_category_id'),
                    'business_profile_id'   => $this->input->post('business_profile_id'),
                    'website' => $this->input->post('website'),
                    'modified_on' => now(),
                );
                
                if(!empty($uploaded_image_data) && ($uploaded_image_data['upload_data']['file_name'] != null)) {
                    $path = FCPATH.SERVICE_IMAGE_PATH.$service_info['picture'];
                    unlink($path);
                    $data['picture'] = $uploaded_image_data['upload_data']['file_name'];
                }
                
                $id = $this->admin_service_directory->update_service($service_info['id'], $data);
                if($id !== FALSE) {
                    $this->data['message'] = "Service is updated successfully";
                    echo json_encode($this->data);
                    return;
                    //$this->session->set_flashdata('success_message', 'You have update service sucessfully');
                    //redirect("admin/servicedirectory/service_category/".$service_info['service_category_id'], 'refresh');
                }else{
                    $this->data['message'] = strip_tags($this->admin_healthy_recipes->errors());
                    echo json_encode($this->data);
                    return;
                }
            }
            else 
            { 
                $this->data['message'] = strip_tags(validation_errors());
                echo json_encode($this->data);
                return;
            }           
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => $service_info['title'],
        );
        
        $this->data['name'] = array(
            'name'  => 'name',
            'id'    => 'name',
            'type' => 'text',
            'value' => $service_info['name']
        );
        $this->data['latitude'] = array(
            'name'  => 'latitude',
            'id'    => 'latitude',
            'type' => 'text',
            'value' => $service_info['latitude']
        );   
        $this->data['longitude'] = array(
            'name'  => 'longitude',
            'id'    => 'longitude',
            'type' => 'text',
            'value' => $service_info['longitude']
        );
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'text',
            'value' => $service_info['address'],
            'rows'  => '4',
            'cols'  => '10'
        );
        $this->data['city'] = array(
            'name' => 'city',
            'id' => 'city',
            'type' => 'text',
            'value' => $service_info['city']
        );
        
        $this->data['country_id'] = array(
            'name' => 'country_id',
            'id' => 'country_id',
            'type' => 'text',
            'value' => $service_info['country_id'],
        );
        
        $this->data['post_code'] = array(
            'name' => 'post_code',
            'id' => 'post_code',
            'type' => 'text',
            'value' => $service_info['post_code']
        );
         
        $this->data['opening_hours'] = array(
            'name' => 'opening_hours',
            'id' => 'opening_hours',
            'type' => 'text',
            'value' => $service_info['opening_hours'],
        );
        
        $this->data['telephone'] = array(
            'name' => 'telephone',
            'id' => 'telephone',
            'type' => 'text',
            'value' => $service_info['telephone'],
            'onkeydown'=>'validateNumberAllowDecimal(event, true)'
        );
        
        $this->data['website'] = array(
            'name' => 'website',
            'id' => 'website',
            'type' => 'text',
            'value' => $service_info['website'],
        );
        
        $this->data['submit_edit_service'] = array(
            'name' => 'submit_edit_service',
            'id' => 'submit_edit_service',
            'type' => 'submit',
            'value' => 'Update',
        );
        
        if($service_info['business_profile_id'] != NULL) {
            $this->data['selected_business_profile_id'] = $service_info['business_profile_id'];
        } else {
            $this->data['selected_business_profile_id'] = NULL;
        }
        
        if($service_info['country_id'] != NULL) {
            $this->data['selected_country_id'] = $service_info['country_id'];
        } else {
            $this->data['selected_country_id'] = NULL;
        }
        
        $country_list_array = $this->admin_service_directory->get_all_country()->result_array();
        foreach ($country_list_array as $key => $country) {
            $this->data['country_list'][$country['id']] = $country['country_name'];
        }
        
        $business_profiles_array = $this->admin_service_directory->get_all_business_profile()->result_array();
        foreach ($business_profiles_array as $profile) {
            $this->data['business_profile_list'][$profile['id']] = $profile['business_description'];
        }
        
        $this->data['service_id'] = $service_id;
        $this->data['service_info'] = $service_info;
        
        $this->template->load($this->tmpl, "admin/applications/service_directory/edit_service", $this->data);
    }
    
    function service_show($service_id = 0)
    {
        $this->data['message'] = '';
        $service_info = $this->admin_service_directory->get_service_info($service_id)->result_array();
        
        $this->data['service_info'] = $service_info[0];
        $this->template->load($this->tmpl, "admin/applications/service_directory/service_show", $this->data);
    }
    function service_comments($service_id = 0)
    {
        $this->data['message'] = '';
        $service_comments = $this->admin_service_directory->get_all_comments($service_id)->result_array();
           
        $length = count($service_comments);
        
        for($i=0; $i<$length;$i++)
        {
            $service_comments[$i]['liked_user_list'] = json_decode($service_comments[$i]['liked_user_list']);
            $service_comments[$i]['created_on'] = unix_to_human($service_comments[$i]['created_on']);
            $service_comments[$i]['rate_id'] = $this->utils->rating_name($service_comments[$i]['rate_id']);
            $service_comments[$i]['liked_user_list'] = count($service_comments[$i]['liked_user_list']);
        }

        $this->data['service_comments'] = $service_comments;
        $this->data['service_id'] = $service_id;
        $this->template->load($this->tmpl, "admin/applications/service_directory/service_comments", $this->data);
    }
    
    function remove_comment()
    {
        $comment_id = $this->input->post('comment_id');
        
        $id = $this->admin_service_directory->remove_comment($comment_id);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Comment is removed successfully.';          
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_service_directory->errors_alert();
        }
        echo json_encode($response);
    }
    
    function service_pictures($service_id = 0)
    {
        $this->data['message'] = '';
        
        $service_info = $this->admin_service_directory->get_service_info($service_id)->result_array();
        if(count($service_info) >0 )
        {
           $service_info = $service_info[0];
        }
        $this->data['service_info'] = $service_info;
        
        $this->template->load($this->tmpl, "admin/applications/service_directory/service_pictures", $this->data);
    }
    
    public function check_country_code_validity($country_code)
    {
        if($country_code>0 && $country_code<TOTAL_COUNTRY_NUMBER)
        {
            return 1;
        }
        
        return 0;
    }
    
    public function page_import_service()
    {
        $success_counter=0;
        $result_array = array();
        $this->data['message'] = '';
        if($this->input->post('button_submit'))
        {
            $config['upload_path'] = './././resources/import/applications/service_directory/';
            $config['allowed_types'] = 'xlsx';
            $config['file_name'] = 'services.xlsx';
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload())
            {
                $this->data['message'] = $this->upload->display_errors();
            }
            else
            {
                $file = 'resources/import/applications/service_directory/services.xlsx';

                //read file from path
                $objPHPExcel = PHPExcel_IOFactory::load($file);

                //get only the Cell Collection
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

                //extract to a PHP readable array format
                $header = array();
                $arr_data = array();
                //task_tanvir validate each row before extracting information
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();

                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();

                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = $data_value;
                    } else {
                        $arr_data[$row][$column] = $data_value;
                    }
                }
                
                //send the data in an array format
                $data['header'] = $header;
                $data['values'] = $arr_data;
                $i = 0;
                $result_array = array();
                $header_len = sizeof($header[1]);
                foreach ($arr_data as $result_data)
                {
                    $i++;
                    $flag = FALSE;
                    foreach($header[1] as $key=>$row)
                    {
                        if(!array_key_exists($key, $result_data))
                        {
                            $result_array[$i] = 'row no ' . $i . ' contains empty field';
                        
                            $flag = TRUE;
                            break;
                        }
                    }
                    
                    if($flag) continue;
                    if(sizeof($result_data)!= $header_len || (array_key_exists('D', $result_data) && !$this->check_country_code_validity($result_data['D'])))
                    {
                        $result_array[$i] = 'row no ' . $i . ' contains invalid data';
                        continue;
                    }

                    $additional_data = array(
                        'service_category_name' => strip_tags($result_data['J']),
                        'name' => strip_tags($result_data['A']),
                        'address' => strip_tags($result_data['B']),
                        'city' => strip_tags($result_data['C']),
                        'country_id' => $result_data['D'],
                        'post_code' => strip_tags($result_data['E']),
                        'opening_hours' => strip_tags($result_data['F']),
                        'telephone' => strip_tags($result_data['G']),
                        'website' => strip_tags($result_data['H']),
                        'business_profile_id' => $result_data['I'],
                        'latitude' => $result_data['K'],
                        'longitude' => $result_data['L'],
                        'created_on' => now()
                    );

                    $flag = $this->admin_service_directory->add_imported_service_info($additional_data);
                    if($flag!=FALSE)
                    {
                        $success_counter++;
                    }
                    else{
                        $result_array[$i] = 'Row no '.$i.' is not inserted';
                    }
                }
            }
            
            $message = $success_counter.' rows are inserted '.'<br>';
            if(!empty($result_array)) $message = $message.'';
            foreach($result_array as $result)
            {
                $message = $message.' '.$result.'<br>';
            }
            $this->data['message'] = $message;

        }
        $this->template->load($this->tmpl, "admin/applications/service_directory/import_services_view", $this->data);
    }
    public function import_services()
    {
        $lines = file('resources/import/applications/service_directory/services.txt');
        $result_array = array();
        $i = 0;
        
        foreach ($lines as $line) 
        {
            $i++;
            $splited_content = explode("~", $line);
            //echo '<pre/>';print_r($splited_content);exit('here');
            $title = $splited_content[1];
            $service_category_name = $splited_content[11];
            $service_category_image = $splited_content[12];
            $service_category_info_array = $this->admin_service_directory->get_service_category_info_by_name($service_category_name)->result_array();
            
            if(!empty($service_category_info_array))
            {
                $service_category_info_array = $service_category_info_array[0];
            } 
            else
            {
                $id = $this->admin_service_directory->create_service_category($service_category_name, $additional_data = array('picture' => $service_category_image));
                if($id !== FALSE)
                {
                    $service_category_info_array = $this->admin_service_directory->get_service_category_info($id)->result_array();
                    if(!empty($service_category_info_array))
                    {
                        $service_category_info_array = $service_category_info_array[0];
                    }             
                }
            }
            
            $additional_data = array(
                'name' => $splited_content[0],
                'address' => $splited_content[2],
                'city' => $splited_content[3],
                'country_id' => $splited_content[4],
                'post_code' => $splited_content[5],
                'opening_hours' => $splited_content[6],
                'telephone' => $splited_content[7],
                'website' => $splited_content[8],
                'business_profile_id' => $splited_content[9],
                'picture' => $splited_content[10],
                'service_category_id' => $service_category_info_array['id'],
                'created_on' => now()
            );
            
            $flag = $this->admin_service_directory->create_service($title, $additional_data);
            if($flag !== FALSE) {
                $result_array[$i] = 'row no '.$i.' inserted sucessfully';
            } else {
                $result_array[$i] = 'row no '.$i.' contain duplicated service title';
            }
        }
        
        echo '<pre/>';print_r($result_array); die();
    }
}
?>
