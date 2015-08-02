<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bg_landing_img extends Admin_Controller {

    public $tmpl = '';
    public $user_group_array = array();

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->model('org/admin/landing_image_model');
        $this->load->library('org/utility/Utils');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }

//        $this->data['allow_view'] = FALSE;
//        $this->data['allow_write'] = FALSE;
//        $this->data['allow_edit'] = FALSE;
//        $this->data['allow_delete'] = FALSE; 
        // $selected_user_group = $this->session->userdata('user_type');
//        if(isset($selected_user_group ) && $selected_user_group != ""){
//            $this->user_group_array = array($selected_user_group);
//        }
//        else
//        {
//            $this->user_group_array = $this->ion_auth->get_current_user_types();
//        } 
//        if (in_array(ADMIN, $this->user_group_array)) {
//            $this->tmpl = ADMIN_DASHBOARD_TEMPLATE;
//            $this->data['allow_view'] = TRUE;
//            $this->data['allow_write'] = TRUE;
//            $this->data['allow_edit'] = TRUE;
//            $this->data['allow_delete'] = TRUE; 
//        }
//        else
//        {
//            $access_level_mapping = $this->admin_access_level_library->get_access_level_info($this->session->userdata('user_id'));
//            $this->tmpl = USER_DASHBOARD_TEMPLATE;
//            $this->data['access_level_mapping'] = $access_level_mapping;
//            
//            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
//            {
//                $this->data['allow_view'] = TRUE;
//            }
//            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE, $access_level_mapping))
//            {
//                $this->data['allow_write'] = TRUE;
//            }
//            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT, $access_level_mapping))
//            {
//                $this->data['allow_edit'] = TRUE;
//            }
//            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE, $access_level_mapping))
//            {
//                $this->data['allow_delete'] = TRUE;
//            }
//            if(!$this->data['allow_view'])
//            {
//                redirect('admin/general/restriction_view', 'refresh');
//            }
//        }        
    }

    public function index() {
        $image_array = $this->landing_image_model->get_all_images()->result_array();
        $this->data['image_list'] = $image_array;
        $this->template->load(NULL, "admin/landing_img/index", $this->data);
    }

    public function edit_image($image_id) {

        $this->data['message'] = '';
        $image_info = array();
        $image_info_array = $this->landing_image_model->get_image_info($image_id)->result_array();
        if (!$image_id || empty($image_info_array)) {
            redirect("admin/bg_landing_img", "refresh");
        }
        $image_info = $image_info_array[0];
        $result = array();
        if (isset($_FILES["userfile"])) {
            $file_info = $_FILES["userfile"];
            $result = $this->utils->upload_image($file_info, SLIDING_IMAGE_PATH);
            if ($result['status'] == 1) {
//                    $path = PHOTOGRAPHY_IMAGE_PATH . $result['upload_data']['file_name'];
//                    $this->utils->resize_image($path, $path, PHOTOGRAPHY_IMAGE_HEIGHT, PHOTOGRAPHY_IMAGE_WIDTH);

                $additional_data = array(
                    'img' => $result['upload_data']['file_name'],
                );
                $id = $this->landing_image_model->update_image($image_id, $additional_data);
                if ($id !== FALSE) {
                    $result['message'] = 'Image is Updated successfully.';
                } else {
                    $result['message'] = 'Error while storing Image.';
                }
            }
            echo json_encode($result);
            return;
        } else {
            $this->data['submit_edit_image'] = array(
                'name' => 'submit_edit_image',
                'value'=> 'Update',
                'type' => 'submit',
            );
            $this->data['image_id'] = $image_id;
            $this->data['image_file_name'] = $image_info['img'];
            $this->template->load($this->tmpl, "admin/landing_img/edit_image", $this->data);
        }
    }

    public function delete_image() {
        $result = array();
        $image_id = $this->input->post('image_id');
        if ($this->landing_image_model->delete_image($image_id)) {
            $result['message'] = $this->landing_image_model->messages_alert();
        } else {
            $result['message'] = $this->landing_image_model->errors_alert();
        }
        echo json_encode($result);
    }

    public function add_image() {

        $this->data['message'] = '';
        $result = array();
        if (isset($_FILES["userfile"])) {
            $file_info = $_FILES["userfile"];
            $result = $this->utils->upload_image($file_info, SLIDING_IMAGE_PATH);
            if ($result['status'] == 1) {
//                $path = SLIDING_IMAGE_PATH . $result['upload_data']['file_name'];
//                $this->utils->resize_image($path, $path, SLIDING_IMAGE_HEIGHT, SLIDING_IMAGE_WIDTH);
                $additional_data = array(
                    'img' => $result['upload_data']['file_name']
                );
                $id = $this->landing_image_model->add_image($additional_data);
                if ($id !== null) {
                    $result['message'] = 'Image is stored successfully.';
                } else {
                    $result['message'] = 'Error while storing Image.';
                }
            }
            echo json_encode($result);
            return;
        } else {
            $this->template->load($this->tmpl, "admin/landing_img/add_image");
        }
    }

}
