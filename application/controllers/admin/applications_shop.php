<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Applications_shop extends CI_Controller{
    public $tmpl = '';
    public $user_group_array = array();
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('org/admin/application/admin_shop_library.php');
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
            
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SHOP_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->data['allow_view'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SHOP_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS, $access_level_mapping))
            {
                $this->data['allow_access'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SHOP_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE, $access_level_mapping))
            {
                $this->data['allow_write'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SHOP_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE, $access_level_mapping))
            {
                $this->data['allow_approve'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SHOP_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT, $access_level_mapping))
            {
                $this->data['allow_edit'] = TRUE;
            }if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SHOP_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE, $access_level_mapping))
            {
                $this->data['allow_delete'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SHOP_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION, $access_level_mapping))
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
        $this->data['product_category_list'] = $this->admin_shop_library->get_all_product_categories()->result_array();
        $this->template->load($this->tmpl, "admin/applications/shop/index", $this->data);
    }
    
    /*
     * Ajax call to create a new product category
     * @Author Nazmul on 5th November 2014
     */
    public function create_product_category()
    {
        $result = array();
        $title = $this->input->post('title');
        $additional_data = array(
            'title' => $title
        );
        if($this->admin_shop_library->create_product_category($additional_data))
        {
            $result['message'] = $this->admin_shop_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_shop_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    /*
     * @Author Tanveer
     */
    public function get_product_category_info()
    {
        $result['product_category_info'] = array();
        $category_id = $this->input->post('category_id');
        $product_category_info_array = $this->admin_shop_library->get_product_category_info($category_id)->result_array();
        if(!empty($product_category_info_array))
        {
            $result['product_category_info'] = $product_category_info_array[0];
        }
        echo json_encode($result);
    }
    
    /*
     * Ajax call to update product category
     * @Author Nazmul on 5th November 2014
     */
    public function update_product_category()
    {
        $result = array();
        $category_id = $this->input->post('category_id');
        $title = $this->input->post('title');
        $additional_data = array(
            'title' => $title,
            'modified_on' => now()
        );
        if($this->admin_shop_library->update_product_category($category_id, $additional_data))
        {
            $result['message'] = $this->admin_shop_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_shop_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    /*
     * Ajax call to delete product category
     * @Author Nazmul on 5th November 2014
     */
    public function delete_product_category()
    {
        $result = array();
        $category_id = $this->input->post('category_id');
        if($this->admin_shop_library->delete_product_category($category_id))
        {
            $result['message'] = $this->admin_shop_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_shop_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    // ---------------------------------- Product Color Module ----------------------------------------
    public function manage_colors()
    {
        $this->data['message'] = '';
        $this->data['product_color_list'] = $this->admin_shop_library->get_all_product_colors()->result_array();
        $this->template->load($this->tmpl, "admin/applications/shop/product_color_list", $this->data);
    }
    
    /*
     * This method will create a new color
     * @Author Nazmul on 5th November 2014
     */
    public function create_color()
    {
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('input_color_title', 'Color Title', 'xss_clean|required');
        $this->form_validation->set_rules('input_color_desc', 'Color Description', 'xss_clean|required');

        if ($this->input->post('btnSubmit'))
        {
            if ($this->form_validation->run() == true)
            {
                if (isset($_FILES["userfile"]))
                {
                    $file_info = $_FILES["userfile"];
                    $uploaded_image_data = $this->image_upload($file_info, PRODUCT_COLOR_PICTURE_PATH);
                    if(isset($uploaded_image_data['error'])) {
                        $this->data['message'] = strip_tags($uploaded_image_data['error']);
                        echo json_encode($this->data);
                        return;
                    } else if(!empty($uploaded_image_data['upload_data']['file_name'])){
                        $path = FCPATH.PRODUCT_COLOR_PICTURE_PATH.$uploaded_image_data['upload_data']['file_name'];
                        unlink($path);
                    }
                }
                $result = array();
                $title = $this->input->post('input_color_title');
                $description = $this->input->post('input_color_desc');
//                $picture = $this->input->post('userfile');
                $additional_data = array(
                    'title' => $title,
                    'description' => $description
                );
                if ($this->admin_shop_library->create_product_color($additional_data)) {
                    $result['message'] = $this->admin_shop_library->messages_alert();
                    $this->data['message'] = json_encode($result['message']);
                    $this->template->load($this->tmpl, "admin/applications/shop/product_color_create", $this->data);
//                    redirect('admin/applications_shop/manage_colors'.$tournament_id,'refresh');
                } else {
                    $result['message'] = $this->admin_shop_library->errors_alert();
                    $this->data['message'] = json_encode($result['message']);
                    $this->template->load($this->tmpl, "admin/applications/shop/product_color_create", $this->data);
                }
//                echo json_encode($result);
            }
            else
            {
                $this->data['message'] = validation_errors();
            }
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message');
            $this->template->load($this->tmpl, "admin/applications/shop/product_color_create", $this->data);
        }
    }
    /*
     * This method will update color
     * @param $color_id, color id
     * @Author Nazmul on 5th November 2014
     */
    public function update_color($color_id)
    {
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('input_color_title', 'Color Title', 'xss_clean|required');
        $this->form_validation->set_rules('input_color_desc', 'Color Description', 'xss_clean|required');

        if ($this->input->post('btnSubmit'))
        {
            if ($this->form_validation->run() == true)
            {
                if (isset($_FILES["userfile"]))
                {
                    $file_info = $_FILES["userfile"];
                    $uploaded_image_data = $this->image_upload($file_info, PRODUCT_COLOR_PICTURE_PATH);
                    if(isset($uploaded_image_data['error'])) {
                        $this->data['message'] = strip_tags($uploaded_image_data['error']);
                        echo json_encode($this->data);
                        return;
                    } else if(!empty($uploaded_image_data['upload_data']['file_name'])){
                        $path = FCPATH.PRODUCT_COLOR_PICTURE_PATH.$uploaded_image_data['upload_data']['file_name'];
                        unlink($path);
                    }
                }
                $result = array();
                $title = $this->input->post('input_color_title');
                $description = $this->input->post('input_color_desc');
//                $picture = $this->input->post('userfile');
                $additional_data = array(
                    'title' => $title,
                    'description' => $description
                );
                if ($this->admin_shop_library->create_product_color($additional_data)) {
                    $result['message'] = $this->admin_shop_library->messages_alert();
                    $this->data['message'] = json_encode($result['message']);
                    $this->template->load($this->tmpl, "admin/applications/shop/product_color_create", $this->data);
//                    redirect('admin/applications_shop/manage_colors'.$tournament_id,'refresh');
                } else {
                    $result['message'] = $this->admin_shop_library->errors_alert();
                    $this->data['message'] = json_encode($result['message']);
                    $this->template->load($this->tmpl, "admin/applications/shop/product_color_create", $this->data);
                }
//                echo json_encode($result);
            }
            else
            {
                $this->data['message'] = validation_errors();
            }
        }
        else
        {
            $color_info = $this->admin_shop_library->get_product_color_info($color_id);
            var_dump($color_info); exit();
            $this->data['title'] = $color_info["title"];
            $this->data['description'] = $color_info["description"];
            $this->data['message'] = $this->session->flashdata('message');
            
            $this->template->load($this->tmpl, "admin/applications/shop/product_color_edit", $this->data);
        }
    }
    
    /*
     * Ajax call to delete color
     * @Author Nazmul on 5th November 2014
     */
    public function delete_color()
    {
        $result = array();
        $id = $this->input->post('id');
        if($this->admin_shop_library->delete_product_color($id))
        {
            $result['message'] = $this->admin_shop_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_shop_library->errors_alert();
        }
        echo json_encode($result);
    }
}

