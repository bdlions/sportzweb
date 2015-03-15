<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Applications_photography extends Admin_Controller{
    public $tmpl = '';
    public $user_group_array = array();
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/admin/application/admin_photography');
        $this->load->library('org/admin/access_level/admin_access_level_library'); 
        $this->load->library('org/utility/Utils');
        $this->load->library('org/application/photography_library');
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
            
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->data['allow_view'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE, $access_level_mapping))
            {
                $this->data['allow_write'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT, $access_level_mapping))
            {
                $this->data['allow_edit'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE, $access_level_mapping))
            {
                $this->data['allow_delete'] = TRUE;
            }
            if(!$this->data['allow_view'])
            {
                redirect('admin/general/restriction_view', 'refresh');
            }
        }        
    }
    
    public function index()
    {
        $image_array = $this->photography_library->get_all_images()->result_array();
        $this->data['image_list'] = $image_array;
        $this->template->load($this->tmpl, "admin/applications/photography/index", $this->data);
    }
    
    public function add_image()
    {
        $this->data['message'] = '';
        if($this->input->post())
        {
            $result = array();
            if (isset($_FILES["userfile"])) {
                $file_info = $_FILES["userfile"];
                $result = $this->utils->upload_image($file_info, PHOTOGRAPHY_IMAGE_PATH);
                if($result['status'] == 1)
                {
                    $path = PHOTOGRAPHY_IMAGE_PATH.$result['upload_data']['file_name'];
                    $this->utils->resize_image($path, $path, PHOTOGRAPHY_IMAGE_HEIGHT, PHOTOGRAPHY_IMAGE_WIDTH);
                
                    $additional_data = array(
                        'img' => $result['upload_data']['file_name'],
                        'text1' => $this->input->post('text1'),
                        'text2' => $this->input->post('text2'),
                        'text3' => $this->input->post('text3'),
                        'text4' => $this->input->post('text4'),
                        'text5' => $this->input->post('text5'),
                        'text6' => $this->input->post('text6')
                    );
                    $id = $this->admin_photography->add_image($additional_data);
                    if($id !== FALSE)
                    {
                        $result['message'] = 'Image is stored successfully.';
                    }
                    else
                    {
                        $result['message'] = 'Error while storing Image.';
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
        $this->data['text1'] = array('name' => 'text1',
            'id' => 'text1',
            'type' => 'text',
            'class'=>'form-control',
            'value' => ''
        ); 
        $this->data['text2'] = array('name' => 'text2',
            'id' => 'text2',
            'type' => 'text',
            'class'=>'form-control',
            'value' => ''
        ); 
        $this->data['text3'] = array('name' => 'text3',
            'id' => 'text3',
            'type' => 'text',
            'class'=>'form-control',
            'value' => ''
        ); 
        $this->data['text4'] = array('name' => 'text4',
            'id' => 'text4',
            'type' => 'text',
            'class'=>'form-control',
            'value' => ''
        ); 
        $this->data['text5'] = array('name' => 'text5',
            'id' => 'text5',
            'type' => 'text',
            'class'=>'form-control',
            'value' => ''
        ); 
        $this->data['text6'] = array('name' => 'text6',
            'id' => 'text6',
            'type' => 'text',
            'class'=>'form-control',
            'value' => ''
        ); 
        
        $this->data['login_page_image'] = array('name' => 'login_page_image',
            'id' => 'login_page_image',
            'type' => 'checkbox',
            'class'=>'form-control',
            'value' => ''
        ); 
        $this->data['login_page_image_date'] = array('name' => 'login_page_image_date',
            'id' => 'login_page_image_date',
            'type' => 'text',
            'class'=>'form-control',
            'value' => ''
        );
        
        $this->data['logout_page_image'] = array('name' => 'logout_page_image',
            'id' => 'logout_page_image',
            'type' => 'checkbox',
            'class'=>'form-control',
            'value' => ''
        ); 
        $this->data['logout_page_image_date'] = array('name' => 'logout_page_image_date',
            'id' => 'logout_page_image_date',
            'type' => 'text',
            'class'=>'form-control',
            'value' => ''
        );
        $this->template->load($this->tmpl, "admin/applications/photography/add_image", $this->data);
        
    }
    
    public function edit_image($image_id)
    {
        $this->data['message'] = '';
        $image_info = array();
        $image_info_array = $this->admin_photography->get_image_info($image_id)->result_array();
        if(!$image_id || empty($image_info_array)) {
            redirect("admin/applications_photography", "refresh");
        }
        $image_info = $image_info_array[0];
        if($this->input->post())
        {
            $result = array();
            if (isset($_FILES["userfile"])) {
                $file_info = $_FILES["userfile"];
                $result = $this->utils->upload_image($file_info, PHOTOGRAPHY_IMAGE_PATH);
                if ($result['status'] == 1) {
                    $path = PHOTOGRAPHY_IMAGE_PATH . $result['upload_data']['file_name'];
                    $this->utils->resize_image($path, $path, PHOTOGRAPHY_IMAGE_HEIGHT, PHOTOGRAPHY_IMAGE_WIDTH);

                    $additional_data = array(
                        'img' => $result['upload_data']['file_name'],
                        'text1' => $this->input->post('text1'),
                        'text2' => $this->input->post('text2'),
                        'text3' => $this->input->post('text3'),
                        'text4' => $this->input->post('text4'),
                        'text5' => $this->input->post('text5'),
                        'text6' => $this->input->post('text6')
                    );
                    $id = $this->admin_photography->update_image($image_id, $additional_data);
                    if ($id !== FALSE) {
                        $result['message'] = 'Image is Updated successfully.';
                    } else {
                        $result['message'] = 'Error while storing Image.';
                    }
                }
            } else{
                $result['status'] = 0;
                $result['message'] = 'Please select an image.';
            }
            echo json_encode($result);
            return;
        }
        
        $this->data['text1'] = array('name' => 'text1',
            'id' => 'text1',
            'type' => 'text',
            'class'=>'form-control',
            'value' => $image_info['text1']
        ); 
        $this->data['text2'] = array('name' => 'text2',
            'id' => 'text2',
            'type' => 'text',
            'class'=>'form-control',
            'value' => $image_info['text2']
        ); 
        $this->data['text3'] = array('name' => 'text3',
            'id' => 'text3',
            'type' => 'text',
            'class'=>'form-control',
            'value' => $image_info['text3']
        ); 
        $this->data['text4'] = array('name' => 'text4',
            'id' => 'text4',
            'type' => 'text',
            'class'=>'form-control',
            'value' => $image_info['text4']
        ); 
        $this->data['text5'] = array('name' => 'text5',
            'id' => 'text5',
            'type' => 'text',
            'class'=>'form-control',
            'value' => $image_info['text5']
        ); 
        $this->data['text6'] = array('name' => 'text6',
            'id' => 'text6',
            'type' => 'text',
            'class'=>'form-control',
            'value' => $image_info['text6']
        );
        $this->data['submit_edit_image'] = array(
            'name' => 'submit_edit_image',
            'id' => 'submit_edit_image',
            'type' => 'submit',
            'value' => 'Update'
        );
        $this->data['image_id'] = $image_id;
        $this->data['image_file_name'] = $image_info['img'];
        $this->template->load($this->tmpl, "admin/applications/photography/edit_image", $this->data);
    }
    
    public function delete_image()
    {
        $result = array();
        $image_id = $this->input->post('image_id');
        if($this->admin_photography->delete_image($image_id))
        {
            $result['message'] = $this->admin_photography->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_photography->errors_alert();
        }
        echo json_encode($result);
    }
}

