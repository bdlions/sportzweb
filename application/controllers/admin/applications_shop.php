<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Applications_shop extends CI_Controller{
    public $tmpl = '';
    public $user_group_array = array();
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
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
        $this->data['product_color_list'] = array();
        $this->template->load($this->tmpl, "admin/applications/shop/product_color_list", $this->data);
    }
    
    /*
     * This method will create a new color
     * @Author Nazmul on 5th November 2014
     */
    public function create_color()
    {
        
    }
    /*
     * This method will update color
     * @param $color_id, color id
     * @Author Nazmul on 5th November 2014
     */
    public function update_color($color_id)
    {
        
    }
    
    /*
     * Ajax call to delete color
     * @Author Nazmul on 5th November 2014
     */
    public function delete_color()
    {
        
    }
}

