<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Footer_terms extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/admin/access_level/admin_access_level_library');
        $this->load->library('org/admin/footer/admin_about_us');
        $this->load->library('org/admin/footer/admin_terms_library');
        $this->load->library('org/admin/footer/admin_privacy_library');
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
            $this->data['allow_edit'] = TRUE;
        }
        else
        {
            $access_level_mapping = $this->admin_access_level_library->get_access_level_info($this->session->userdata('user_id'));
            $this->tmpl = USER_DASHBOARD_TEMPLATE;
            $this->data['access_level_mapping'] = $access_level_mapping;
            
            if(array_key_exists(ADMIN_ACCESS_LEVEL_FOOTER_TERMS_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->data['allow_view'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_FOOTER_TERMS_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT, $access_level_mapping))
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
        $this->terms();
    }
    
    /*
     * This method will show terms page
     * @Author Nazmul on 25th January 2015
     */
    public function terms()
    {
        $this->data['message'] = '';
        $terms_info = array();
        $terms_info_array = $this->admin_terms_library->get_terms_info()->result_array();
        if(!empty($terms_info_array))
        {
          $terms_info= $terms_info_array[0]; 
        }
        $this->data['terms_info'] = $terms_info;
        $this->template->load($this->tmpl, "admin/footer/terms/index", $this->data);
    }
    /*
     * This method will update terms
     * @Author Nazmul on 25th January 2015
     */
    public function update_terms()
    {
        $this->data['message'] = '';
       
        if ($this->input->post())
        {
            $result = array();
            $result['message'] = ''; 
              $data = array(
                    'description' => $this->input->post('description'),
                  );
               if ($this->admin_terms_library->update_terms_info($data)) {
                   redirect('admin/footer/terms','refresh');
                   return;
                } else {
                    redirect('admin/footer/update_terms','refresh');
                }
        }else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        
        $terms_info = array();
        $terms_info_array = $this->admin_terms_library->get_terms_info()->result_array();
        if(!empty($terms_info_array))
        {
          $terms_info = $terms_info_array[0]; 
        }
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'value' => $terms_info['description']
        );
        $this->data['submit_update_terms'] = array(
            'name' => 'submit_update_terms',
            'id' => 'submit_update_terms',
            'type' => 'submit',
            'value' => "Update"
        );

        $this->data['terms_info'] = $terms_info;
        
        $this->template->load($this->tmpl, "admin/footer/terms/update_terms", $this->data);
    }    
}

