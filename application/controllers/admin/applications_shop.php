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
        $this->form_validation->set_rules('title', 'Color Title', 'xss_clean|required');
        $this->form_validation->set_rules('description', 'Color Description', 'xss_clean|required');
        if ($this->input->post('submit_create_color'))
        {            
            if($this->form_validation->run() == true)
            {
                $additional_data = array(
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description')
                );
                $color_id = $this->admin_shop_library->create_product_color($additional_data);
                if($color_id !== FALSE)
                {
                    $this->session->set_flashdata('message', $this->admin_shop_library->messages());
                    redirect('admin/applications_shop/create_color','refresh');
                }
                else
                {
                    $this->data['message'] = 'Error while creating a color.';
                }
            }
            else
            {
                $this->data['message'] = validation_errors();
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
            'value' => $this->form_validation->set_value('title'),
        );
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('description'),
        );
        $this->data['submit_create_color'] = array(
            'name' => 'submit_create_color',
            'id' => 'submit_create_color',
            'type' => 'submit',
            'value' => 'Create',
        );
        $this->template->load($this->tmpl, "admin/applications/shop/product_color_create", $this->data);
    }
    /*
     * This method will update color
     * @param $color_id, color id
     * @Author Nazmul on 5th November 2014
     */
    public function update_color($color_id = 0)
    {
        if(empty($color_id))
        {
            redirect("admin/applications_scoreprediction","refresh");
        }
        $this->data['message'] = '';
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('title', 'Color Title', 'xss_clean|required');
        $this->form_validation->set_rules('description', 'Color Description', 'xss_clean|required');
        if ($this->input->post('submit_update_color'))
        {            
            if($this->form_validation->run() == true)
            {
                $additional_data = array(
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'modified_on' => now()
                );
                if($this->admin_shop_library->update_product_color($color_id, $additional_data))
                {
                    $this->session->set_flashdata('message', $this->admin_shop_library->messages());
                    redirect('admin/applications_shop/update_color/'.$color_id,'refresh');
                }
                else
                {
                    $this->data['message'] = $this->admin_shop_library->errors();
                }
            }
            else
            {
                $this->data['message'] = validation_errors();
            }            
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        $color_info = array();
        $color_info_array = $this->admin_shop_library->get_product_color_info($color_id)->result_array();
        if(!empty($color_info_array))
        {
            $color_info = $color_info_array[0];
        }
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => $color_info['title'],
        );
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'value' => $color_info['description'],
        );
        $this->data['submit_update_color'] = array(
            'name' => 'submit_update_color',
            'id' => 'submit_update_color',
            'type' => 'submit',
            'value' => 'Update',
        );
        $this->data['color_id'] = $color_id;
        $this->template->load($this->tmpl, "admin/applications/shop/product_color_edit", $this->data);        
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
    
    
        
    // ---------------------------------- Product Size Module ----------------------------------------

    // MEN ----------------------------------
    public function manage_size_men()
    {
        $this->data['message'] = '';
        $this->data['size_list'] = $this->admin_shop_library->get_all_sizes_men()->result_array();
        $this->template->load($this->tmpl, "admin/applications/shop/product_sizing_men", $this->data);
    }

    public function create_size_men()
    {
//        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
//        $this->form_validation->set_rules('title', 'Size Title', 'xss_clean|required');
//        $this->form_validation->set_rules('us_ca', 'US - CA', 'xss_clean|required');
//        $this->form_validation->set_rules('uk', 'UK', 'xss_clean|required');
//        $this->form_validation->set_rules('eu', 'EU', 'xss_clean|required');
        
        $result = array();
        $title = $this->input->post('title');
        $us_ca = $this->input->post('us_ca');
        $uk = $this->input->post('uk');
        $eu = $this->input->post('eu');
        $additional_data = array(
            'title' => $this->input->post('title'),
            'us_ca' => $this->input->post('us_ca'),
            'uk' => $this->input->post('uk'),
            'eu' => $this->input->post('eu')
        );
        if($this->admin_shop_library->create_size_men($additional_data))
        {
            $result['message'] = $this->admin_shop_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_shop_library->errors_alert();
        }
        echo json_encode($result);
        
        
//        if ($this->input->post('submit_create_size'))/////////////////
//        {
//            if($this->form_validation->run() == true)
//            {
//                $additional_data = array(
//                    'title' => $this->input->post('title'),
//                    'us_ca' => $this->input->post('us_ca'),
//                    'uk'    => $this->input->post('uk'),
//                    'eu'    => $this->input->post('eu')
//                );
//                $id = $this->admin_shop_library->create_size_men($additional_data);
//                if($id !== FALSE)
//                {
//                    $this->session->set_flashdata('message', $this->admin_shop_library->messages());
//                    redirect('admin/applications_shop/manage_size_men','refresh');
//                }
//                else
//                {
//                    $this->data['message'] = 'Error while creating a new Size.';
//                }
//            }
//            else
//            {
//                $this->data['message'] = validation_errors();
//            }
//        }
//        else
//        {
//            $this->data['message'] = $this->session->flashdata('message'); 
//        }
        
//        echo json_encode($result);
        
        
        
//        $this->data['title'] = array(
//            'name' => 'title',
//            'id' => 'title',
//            'type' => 'text',
//            'value' => $this->form_validation->set_value('title'),
//        );
//        $this->data['us_ca'] = array(
//            'name' => 'us_ca',
//            'id' => 'us_ca',
//            'type' => 'text',
//            'value' => $this->form_validation->set_value('us_ca'),
//        );
//        $this->data['submit_create_size'] = array(
//            'name' => 'submit_create_size',
//            'id' => 'submit_create_size',
//            'type' => 'submit',
//            'value' => 'Create',
//        );
//        $this->template->load($this->tmpl, "admin/applications/shop/product_size_men_create", $this->data);
    }
    
    public function get_size_info_men()
    {
        $result['size_info'] = array();
        $id = $this->input->post('id');
        $size_info_array = $this->admin_shop_library->get_size_info_men($id)->result_array();
        if(!empty($size_info_array))
        {
            $result['size_info'] = $size_info_array[0];
        }
        echo json_encode($result);
    }


    public function delete_size_men()
    {
        $result = array();
        $id = $this->input->post('id');
        if($this->admin_shop_library->delete_size_men($id))
        {
            $result['message'] = $this->admin_shop_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_shop_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    public function update_size_men()
    {
        $result = array();
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $us_ca = $this->input->post('us_ca');
        $uk = $this->input->post('uk');
        $eu = $this->input->post('eu');
        $additional_data = array(
            'title' => $title,
            'us_ca' => $us_ca,
            'uk' => $uk,
            'eu' => $eu,
            'modified_on' => now()
        );
        if($this->admin_shop_library->update_size_men($id, $additional_data))
        {
            $result['message'] = $this->admin_shop_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_shop_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    // WOMEN ----------------------------------
    public function manage_size_women()
    {
        $this->data['message'] = '';
        $this->data['size_list'] = $this->admin_shop_library->get_all_sizes_women()->result_array();
        $this->template->load($this->tmpl, "admin/applications/shop/product_sizing_women", $this->data);
    }
    
    public function create_size_women()
    {
        $result = array();
        $title = $this->input->post('title');
        $us_ca = $this->input->post('us_ca');
        $uk = $this->input->post('uk');
        $eu = $this->input->post('eu');
        $additional_data = array(
            'title' => $this->input->post('title'),
            'us_ca' => $this->input->post('us_ca'),
            'uk' => $this->input->post('uk'),
            'eu' => $this->input->post('eu')
        );
        if($this->admin_shop_library->create_size_women($additional_data))
        {
            $result['message'] = $this->admin_shop_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_shop_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    public function get_size_info_women()
    {
        $result['size_info'] = array();
        $id = $this->input->post('id');
        $size_info_array = $this->admin_shop_library->get_size_info_women($id)->result_array();
        if(!empty($size_info_array))
        {
            $result['size_info'] = $size_info_array[0];
        }
        echo json_encode($result);
    }


    public function delete_size_women()
    {
        $result = array();
        $id = $this->input->post('id');
        if($this->admin_shop_library->delete_size_women($id))
        {
            $result['message'] = $this->admin_shop_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_shop_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    public function update_size_women()
    {
        $result = array();
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $us_ca = $this->input->post('us_ca');
        $uk = $this->input->post('uk');
        $eu = $this->input->post('eu');
        $additional_data = array(
            'title' => $title,
            'us_ca' => $us_ca,
            'uk' => $uk,
            'eu' => $eu,
            'modified_on' => now()
        );
        if($this->admin_shop_library->update_size_women($id, $additional_data))
        {
            $result['message'] = $this->admin_shop_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_shop_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    // TINY TOMS ----------------------------------
    public function manage_size_tinytoms()
    {
        $this->data['message'] = '';
        $this->data['size_list'] = $this->admin_shop_library->get_all_sizes_tinytoms()->result_array();
        $this->template->load($this->tmpl, "admin/applications/shop/product_sizing_tinytoms", $this->data);
    }
    
    public function create_size_tinytoms()
    {
        $result = array();
        $title = $this->input->post('title');
        $us_ca = $this->input->post('us_ca');
        $uk = $this->input->post('uk');
        $eu = $this->input->post('eu');
        $additional_data = array(
            'title' => $this->input->post('title'),
            'us_ca' => $this->input->post('us_ca'),
            'uk' => $this->input->post('uk'),
            'eu' => $this->input->post('eu')
        );
        if($this->admin_shop_library->create_size_tinytoms($additional_data))
        {
            $result['message'] = $this->admin_shop_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_shop_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    public function get_size_info_tinytoms()
    {
        $result['size_info'] = array();
        $id = $this->input->post('id');
        $size_info_array = $this->admin_shop_library->get_size_info_tinytoms($id)->result_array();
        if(!empty($size_info_array))
        {
            $result['size_info'] = $size_info_array[0];
        }
        echo json_encode($result);
    }


    public function delete_size_tinytoms()
    {
        $result = array();
        $id = $this->input->post('id');
        if($this->admin_shop_library->delete_size_tinytoms($id))
        {
            $result['message'] = $this->admin_shop_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_shop_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    public function update_size_tinytoms()
    {
        $result = array();
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $us_ca = $this->input->post('us_ca');
        $uk = $this->input->post('uk');
        $eu = $this->input->post('eu');
        $additional_data = array(
            'title' => $title,
            'us_ca' => $us_ca,
            'uk' => $uk,
            'eu' => $eu,
            'modified_on' => now()
        );
        if($this->admin_shop_library->update_size_tinytoms($id, $additional_data))
        {
            $result['message'] = $this->admin_shop_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_shop_library->errors_alert();
        }
        echo json_encode($result);
    }
    // YOUTH ----------------------------------
    public function manage_size_youth()
    {
        $this->data['message'] = '';
        $this->data['size_list'] = $this->admin_shop_library->get_all_sizes_youth()->result_array();
        $this->template->load($this->tmpl, "admin/applications/shop/product_sizing_youth", $this->data);
    }
    
    public function create_size_youth()
    {
        $result = array();
        $title = $this->input->post('title');
        $us_ca = $this->input->post('us_ca');
        $uk = $this->input->post('uk');
        $eu = $this->input->post('eu');
        $additional_data = array(
            'title' => $this->input->post('title'),
            'us_ca' => $this->input->post('us_ca'),
            'uk' => $this->input->post('uk'),
            'eu' => $this->input->post('eu')
        );
        if($this->admin_shop_library->create_size_youth($additional_data))
        {
            $result['message'] = $this->admin_shop_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_shop_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    public function get_size_info_youth()
    {
        $result['size_info'] = array();
        $id = $this->input->post('id');
        $size_info_array = $this->admin_shop_library->get_size_info_youth($id)->result_array();
        if(!empty($size_info_array))
        {
            $result['size_info'] = $size_info_array[0];
        }
        echo json_encode($result);
    }


    public function delete_size_youth()
    {
        $result = array();
        $id = $this->input->post('id');
        if($this->admin_shop_library->delete_size_youth($id))
        {
            $result['message'] = $this->admin_shop_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_shop_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    public function update_size_youth()
    {
        $result = array();
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $us_ca = $this->input->post('us_ca');
        $uk = $this->input->post('uk');
        $eu = $this->input->post('eu');
        $additional_data = array(
            'title' => $title,
            'us_ca' => $us_ca,
            'uk' => $uk,
            'eu' => $eu,
            'modified_on' => now()
        );
        if($this->admin_shop_library->update_size_youth($id, $additional_data))
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

