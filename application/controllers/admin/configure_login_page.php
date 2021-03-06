<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Configure_login_page extends Admin_Controller{
    function __construct() 
    {
        parent::__construct();
        $this->load->helper('url'); 
        $this->load->library('org/admin/configure/login_page_library');
        $this->load->library('org/utility/Utils');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->lang->load('auth');
        $this->load->helper('language');
        if(!$this->ion_auth->logged_in())
        {
            redirect("admin/auth","refresh");
        }
    }

    public function index() 
    {
        $this->data['current_configuration'] = array();
        $current_date = $this->utils->get_current_date_yyyymmdd();
        $current_configuration = $this->login_page_library->get_current_configuration($current_date)->result_array();
        if(!empty($current_configuration))
        {
            $this->data['current_configuration'] = $current_configuration[0];
        }
        $this->template->load(null, "admin/configure/login/index", $this->data);
    }
    
    public function edit_config()
    {
        if($this->input->post())
        {
            $result = array();
            if (isset($_FILES["userfile"])) {
                $file_info = $_FILES["userfile"];
                $result = $this->utils->upload_image($file_info, LOGIN_PAGE_IMAGE_PATH);
                if($result['status'] == 1)
                {
                    $path = LOGIN_PAGE_IMAGE_PATH.$result['upload_data']['file_name'];
                    $this->utils->resize_image($path, $path, LOGIN_PAGE_IMAGE_HEIGHT, LOGIN_PAGE_IMAGE_WIDTH);
                
                    $additional_data = array(
                        'img' => $result['upload_data']['file_name'],
                        'img_description' => $this->input->post('img_description'),
                        'selected_date' => $this->utils->convert_date_from_ddmmyyyy_to_yyyymmdd($this->input->post('selected_date'))
                    );
                    $id = $this->login_page_library->add_configuration($additional_data);
                    if($id !== FALSE)
                    {
                        $result['message'] = 'Configuration is stored successfully.';
                    }
                    else
                    {
                        $result['message'] = 'Error while storing configuration.';
                    }
                }
            }
            else
            {
                $result['status'] = 0;
                $result['message'] = 'Please select an image.';
            }
            echo json_encode($result);
            return;
        }
        $this->data['img_description'] = array('name' => 'img_description',
            'id' => 'img_description',
            'type' => 'text',
            'class'=>'form-control',
            'value' => ''
        ); 
        $this->data['selected_date'] = array('name' => 'selected_date',
            'id' => 'selected_date',
            'type' => 'text',
            'class'=>'form-control',
            'value' => ''
        );
        $this->template->load(null, "admin/configure/login/edit_config", $this->data);
    }
}