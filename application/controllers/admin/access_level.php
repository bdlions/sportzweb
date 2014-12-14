<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Access_level extends CI_Controller{
    public $user_group_array = array();
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation'); 
        $this->load->library('org/admin/access_level/admin_access_level_library');  
        $this->load->helper('url'); 

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }
        $selected_user_group = $this->session->userdata('user_type');
        if(isset($selected_user_group ) && $selected_user_group != ""){
            $this->user_group_array = array($selected_user_group);
        }
        else
        {
            $this->user_group_array = $this->ion_auth->get_current_user_types();
        } 
        if (!in_array(ADMIN, $this->user_group_array)) {
            redirect('admin/auth/login', 'refresh');
        }
    }

    function index()
    {
        if($this->input->post('submit_create_user'))
        {
            $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $group_id[] = $this->input->post('user_type_list');
            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name')
            );
            $user_id = $this->ion_auth->register($username, $password, $email, $additional_data, $group_id);
            if ($user_id !== FALSE) {
                $form_post_array = $this->input->post();
                $access_level_mapping = $this->access_level_input_process($form_post_array);
                
                $this->admin_access_level_library->store_access_level_info($user_id, $access_level_mapping);
                $update_data = array(
                    'account_status_id' => 1
                );
                //activating the created user
                $this->ion_auth->update($user_id, $update_data);
                redirect('admin/access_level/show_users','refresh');
            } 
            else {
                $this->session->set_flashdata('message', "Unsuccessful to register a user.");
            }
            redirect('admin/access_level','refresh');
        }
        $this->data['user_type_list'] = array();
        $groups_array = $this->admin_access_level_library->get_access_level_groups()->result_array();
        foreach($groups_array as $group)
        {
            $this->data['user_type_list'][$group['group_id']] = $group['name'];
        }       
        
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name'),
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name'),
        );
        $this->data['email'] = array(
            'name' => 'email',
            'id' => 'email',
            'type' => 'text',
            'value' => $this->form_validation->set_value('email'),
        );
        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password',
            'value' => ''
        );
        
        $this->data = array_merge($this->data, $this->get_access_level_items());
        
        $this->data['submit_create_user'] = array(
            'name' => 'submit_create_user',
            'id' => 'submit_create_user',
            'type' => 'submit',
            'value' => 'Create User',
        );
        $user_info = array();
        $user_info_array = $this->admin_access_level_library->get_user_info()->result_array();
        if(!empty($user_info_array))
        {
            $user_info = $user_info_array[0];
        }
        $this->data['user_info'] = $user_info;
        $this->data['message'] = $this->session->flashdata('message');
        $this->template->load(ADMIN_DASHBOARD_TEMPLATE, "admin/access_level/index", $this->data);
    }
    
    public function show_users()
    {
        $this->data['message'] = $this->session->flashdata('message');
        
        $this->data['user_list'] = $this->admin_access_level_library->get_all_users_groups()->result_array();
        
        $user_info = array();
        $user_info_array = $this->admin_access_level_library->get_user_info()->result_array();
        if(!empty($user_info_array))
        {
            $user_info = $user_info_array[0];
        }
        $this->data['user_info'] = $user_info;
        $this->data['title'] = ADMIN_TITLE;
        $this->data['message'] = $this->session->flashdata('message');
        $this->template->load(ADMIN_DASHBOARD_TEMPLATE, "admin/access_level/users", $this->data);
    }
    
    public function edit_user($user_id)
    {
        $user_info = array();
        $user_info_array = $this->admin_access_level_library->get_user_info($user_id)->result_array();
        if(!empty($user_info_array))
        {
            $user_info = $user_info_array[0];
        }
        
        if($this->input->post('submit_update_user'))
        {
            $user_info_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'user_id' =>  $user_id
            );
            if($this->input->post('user_password') != ACCESS_LEVEL_DEFAULT_PASSWORD)
            {
                $user_info_data['password'] = $this->input->post('user_password');
            }
            
            //update user info
            $form_post_array = $this->input->post();
            $access_level_mapping = $this->access_level_input_process($form_post_array);
            
            $this->admin_access_level_library->store_access_level_info($user_id, $access_level_mapping, $user_info_data);
            
            $group_id = $this->input->post('user_type_list');
            if($group_id != $user_info['group_id'])
            {
                $this->admin_access_level_library->remove_from_group($user_info['group_id'], $user_info['user_id']);
                $this->admin_access_level_library->add_to_group($group_id, $user_info['user_id']);
            }
          
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect('admin/access_level/show_users','refresh');
        }
        $access_level_mapping = $this->admin_access_level_library->get_access_level_info($user_id);
        
            
        
        
        $this->data['user_type_list'] = array();
        $groups_array = $this->admin_access_level_library->get_access_level_groups()->result_array();
        foreach($groups_array as $group)
        {
            $this->data['user_type_list'][$group['group_id']] = $group['name'];
        }
        $this->data['selected_access_type'] = $user_info['group_id'];
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $user_info['first_name']
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $user_info['last_name']
        );
        
        $this->data = array_merge($this->data, $this->get_access_level_items($access_level_mapping));
        $this->data['user_password'] = array(
            'name' => 'user_password',
            'id' => 'user_password',
            'type' => 'password',
            'value' => ACCESS_LEVEL_DEFAULT_PASSWORD
        );
        $this->data['submit_update_user'] = array(
            'name' => 'submit_update_user',
            'id' => 'submit_update_user',
            'type' => 'submit',
            'value' => 'Edit User',
        );
        $current_user_info = array();
        $current_user_info_array = $this->admin_access_level_library->get_user_info()->result_array();
        if(!empty($current_user_info_array))
        {
            $current_user_info = $current_user_info_array[0];
        }
        $this->data['current_user_info'] = $current_user_info;
        $this->data['user_id'] = $user_id;
        $this->data['message'] = $this->session->flashdata('message');
        $this->template->load(ADMIN_DASHBOARD_TEMPLATE, "admin/access_level/edit_user", $this->data);
    }
    
    public function delete_user($user_id)
    {
        $this->admin_access_level_library->delete_user($user_id);
        redirect('admin/access_level/show_users','refresh');
    }
    
    public function get_access_level_items($access_level_mapping = array())
    {
        $accesss_map = $this->get_access_map();
        
        $result['overview_view'] = array(
            'name' => $accesss_map['overview_view_map_id'],
            'id' => $accesss_map['overview_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['overview_view_map_id'], $access_level_mapping))
        {
            $result['overview_view']['checked'] = 'checked';
        }        
        $result['overview_access'] = array(
            'name' => $accesss_map['overview_access_map_id'],
            'id' => $accesss_map['overview_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['overview_access_map_id'], $access_level_mapping))
        {
            $result['overview_access']['checked'] = 'checked';
        }
        $result['overview_write'] = array(
            'name' => $accesss_map['overview_write_map_id'],
            'id' => $accesss_map['overview_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['overview_write_map_id'], $access_level_mapping))
        {
            $result['overview_write']['checked'] = 'checked';
        }
	$result['overview_approve'] = array(
            'name' => $accesss_map['overview_approve_map_id'],
            'id' => $accesss_map['overview_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['overview_approve_map_id'], $access_level_mapping))
        {
            $result['overview_approve']['checked'] = 'checked';
        }
	$result['overview_edit'] = array(
            'name' => $accesss_map['overview_edit_map_id'],
            'id' => $accesss_map['overview_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['overview_edit_map_id'], $access_level_mapping))
        {
            $result['overview_edit']['checked'] = 'checked';
        }
	$result['overview_delete'] = array(
            'name' => $accesss_map['overview_delete_map_id'],
            'id' => $accesss_map['overview_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['overview_delete_map_id'], $access_level_mapping))
        {
            $result['overview_delete']['checked'] = 'checked';
        }
	$result['overview_configuration'] = array(
            'name' => $accesss_map['overview_configuration_map_id'],
            'id' => $accesss_map['overview_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['overview_configuration_map_id'], $access_level_mapping))
        {
            $result['overview_configuration']['checked'] = 'checked';
        }
        $result['overview_writing'] = array(
            'name' => $accesss_map['overview_writing_map_id'],
            'id' => $accesss_map['overview_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['overview_writing_map_id'], $access_level_mapping))
        {
            $result['overview_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        $result['user_overview_view'] = array(
            'name' => $accesss_map['user_overview_view_map_id'],
            'id' => $accesss_map['user_overview_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_overview_view_map_id'], $access_level_mapping))
        {
            $result['user_overview_view']['checked'] = 'checked';
        }        
        $result['user_overview_access'] = array(
            'name' => $accesss_map['user_overview_access_map_id'],
            'id' => $accesss_map['user_overview_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_overview_access_map_id'], $access_level_mapping))
        {
            $result['user_overview_access']['checked'] = 'checked';
        }
        $result['user_overview_write'] = array(
            'name' => $accesss_map['user_overview_write_map_id'],
            'id' => $accesss_map['user_overview_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_overview_write_map_id'], $access_level_mapping))
        {
            $result['user_overview_write']['checked'] = 'checked';
        }
        $result['user_overview_approve'] = array(
            'name' => $accesss_map['user_overview_approve_map_id'],
            'id' => $accesss_map['user_overview_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_overview_approve_map_id'], $access_level_mapping))
        {
            $result['user_overview_approve']['checked'] = 'checked';
        }
        $result['user_overview_edit'] = array(
            'name' => $accesss_map['user_overview_edit_map_id'],
            'id' => $accesss_map['user_overview_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_overview_edit_map_id'], $access_level_mapping))
        {
            $result['user_overview_edit']['checked'] = 'checked';
        }
        $result['user_overview_delete'] = array(
            'name' => $accesss_map['user_overview_delete_map_id'],
            'id' => $accesss_map['user_overview_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_overview_delete_map_id'], $access_level_mapping))
        {
            $result['user_overview_delete']['checked'] = 'checked';
        }
        $result['user_overview_configuration'] = array(
            'name' => $accesss_map['user_overview_configuration_map_id'],
            'id' => $accesss_map['user_overview_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_overview_configuration_map_id'], $access_level_mapping))
        {
            $result['user_overview_configuration']['checked'] = 'checked';
        }
        $result['user_overview_writing'] = array(
            'name' => $accesss_map['user_overview_writing_map_id'],
            'id' => $accesss_map['user_overview_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_overview_writing_map_id'], $access_level_mapping))
        {
            $result['user_overview_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        $result['user_manage_view'] = array(
            'name' => $accesss_map['user_manage_view_map_id'],
            'id' => $accesss_map['user_manage_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_manage_view_map_id'], $access_level_mapping))
        {
            $result['user_manage_view']['checked'] = 'checked';
        }        
        $result['user_manage_access'] = array(
            'name' => $accesss_map['user_manage_access_map_id'],
            'id' => $accesss_map['user_manage_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_manage_access_map_id'], $access_level_mapping))
        {
            $result['user_manage_access']['checked'] = 'checked';
        }
        $result['user_manage_write'] = array(
            'name' => $accesss_map['user_manage_write_map_id'],
            'id' => $accesss_map['user_manage_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_manage_write_map_id'], $access_level_mapping))
        {
            $result['user_manage_write']['checked'] = 'checked';
        }
	$result['user_manage_approve'] = array(
            'name' => $accesss_map['user_manage_approve_map_id'],
            'id' => $accesss_map['user_manage_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_manage_approve_map_id'], $access_level_mapping))
        {
            $result['user_manage_approve']['checked'] = 'checked';
        }
	$result['user_manage_edit'] = array(
            'name' => $accesss_map['user_manage_edit_map_id'],
            'id' => $accesss_map['user_manage_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_manage_edit_map_id'], $access_level_mapping))
        {
            $result['user_manage_edit']['checked'] = 'checked';
        }
	$result['user_manage_delete'] = array(
            'name' => $accesss_map['user_manage_delete_map_id'],
            'id' => $accesss_map['user_manage_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_manage_delete_map_id'], $access_level_mapping))
        {
            $result['user_manage_delete']['checked'] = 'checked';
        }
	$result['user_manage_configuration'] = array(
            'name' => $accesss_map['user_manage_configuration_map_id'],
            'id' => $accesss_map['user_manage_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_manage_configuration_map_id'], $access_level_mapping))
        {
            $result['user_manage_configuration']['checked'] = 'checked';
        }
        $result['user_manage_writing'] = array(
            'name' => $accesss_map['user_manage_writing_map_id'],
            'id' => $accesss_map['user_manage_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_manage_writing_map_id'], $access_level_mapping))
        {
            $result['user_manage_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        //xstream_banter checkbox
        $result['xstream_banter_view'] = array(
            'name' => $accesss_map['xstream_banter_view_map_id'],
            'id' => $accesss_map['xstream_banter_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['xstream_banter_view_map_id'], $access_level_mapping))
        {
            $result['xstream_banter_view']['checked'] = 'checked';
        }        
        $result['xstream_banter_access'] = array(
            'name' => $accesss_map['xstream_banter_access_map_id'],
            'id' => $accesss_map['xstream_banter_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['xstream_banter_access_map_id'], $access_level_mapping))
        {
            $result['xstream_banter_access']['checked'] = 'checked';
        }
        $result['xstream_banter_write'] = array(
            'name' => $accesss_map['xstream_banter_write_map_id'],
            'id' => $accesss_map['xstream_banter_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['xstream_banter_write_map_id'], $access_level_mapping))
        {
            $result['xstream_banter_write']['checked'] = 'checked';
        }
	$result['xstream_banter_approve'] = array(
            'name' => $accesss_map['xstream_banter_approve_map_id'],
            'id' => $accesss_map['xstream_banter_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['xstream_banter_approve_map_id'], $access_level_mapping))
        {
            $result['xstream_banter_approve']['checked'] = 'checked';
        }
	$result['xstream_banter_edit'] = array(
            'name' => $accesss_map['xstream_banter_edit_map_id'],
            'id' => $accesss_map['xstream_banter_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['xstream_banter_edit_map_id'], $access_level_mapping))
        {
            $result['xstream_banter_edit']['checked'] = 'checked';
        }
	$result['xstream_banter_delete'] = array(
            'name' => $accesss_map['xstream_banter_delete_map_id'],
            'id' => $accesss_map['xstream_banter_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['xstream_banter_delete_map_id'], $access_level_mapping))
        {
            $result['xstream_banter_delete']['checked'] = 'checked';
        }
	$result['xstream_banter_configuration'] = array(
            'name' => $accesss_map['xstream_banter_configuration_map_id'],
            'id' => $accesss_map['xstream_banter_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['xstream_banter_configuration_map_id'], $access_level_mapping))
        {
            $result['xstream_banter_configuration']['checked'] = 'checked';
        }
        $result['xstream_banter_writing'] = array(
            'name' => $accesss_map['xstream_banter_writing_map_id'],
            'id' => $accesss_map['xstream_banter_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['xstream_banter_writing_map_id'], $access_level_mapping))
        {
            $result['xstream_banter_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        //Healthy Recipe checkbox
        $result['healthy_recipes_view'] = array(
            'name' => $accesss_map['healthy_recipes_view_map_id'],
            'id' => $accesss_map['healthy_recipes_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['healthy_recipes_view_map_id'], $access_level_mapping))
        {
            $result['healthy_recipes_view']['checked'] = 'checked';
        }        
        $result['healthy_recipes_access'] = array(
            'name' => $accesss_map['healthy_recipes_access_map_id'],
            'id' => $accesss_map['healthy_recipes_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['healthy_recipes_access_map_id'], $access_level_mapping))
        {
            $result['healthy_recipes_access']['checked'] = 'checked';
        }
        $result['healthy_recipes_write'] = array(
            'name' => $accesss_map['healthy_recipes_write_map_id'],
            'id' => $accesss_map['healthy_recipes_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['healthy_recipes_write_map_id'], $access_level_mapping))
        {
            $result['healthy_recipes_write']['checked'] = 'checked';
        }
	$result['healthy_recipes_approve'] = array(
            'name' => $accesss_map['healthy_recipes_approve_map_id'],
            'id' => $accesss_map['healthy_recipes_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['healthy_recipes_approve_map_id'], $access_level_mapping))
        {
            $result['healthy_recipes_approve']['checked'] = 'checked';
        }
	$result['healthy_recipes_edit'] = array(
            'name' => $accesss_map['healthy_recipes_edit_map_id'],
            'id' => $accesss_map['healthy_recipes_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['healthy_recipes_edit_map_id'], $access_level_mapping))
        {
            $result['healthy_recipes_edit']['checked'] = 'checked';
        }
	$result['healthy_recipes_delete'] = array(
            'name' => $accesss_map['healthy_recipes_delete_map_id'],
            'id' => $accesss_map['healthy_recipes_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['healthy_recipes_delete_map_id'], $access_level_mapping))
        {
            $result['healthy_recipes_delete']['checked'] = 'checked';
        }
	$result['healthy_recipes_configuration'] = array(
            'name' => $accesss_map['healthy_recipes_configuration_map_id'],
            'id' => $accesss_map['healthy_recipes_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['healthy_recipes_configuration_map_id'], $access_level_mapping))
        {
            $result['healthy_recipes_configuration']['checked'] = 'checked';
        }
        $result['healthy_recipes_writing'] = array(
            'name' => $accesss_map['healthy_recipes_writing_map_id'],
            'id' => $accesss_map['healthy_recipes_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['healthy_recipes_writing_map_id'], $access_level_mapping))
        {
            $result['healthy_recipes_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        //Service Directory checkbox
        $result['service_directory_view'] = array(
            'name' => $accesss_map['service_directory_view_map_id'],
            'id' => $accesss_map['service_directory_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['service_directory_view_map_id'], $access_level_mapping))
        {
            $result['service_directory_view']['checked'] = 'checked';
        }        
        $result['service_directory_access'] = array(
            'name' => $accesss_map['service_directory_access_map_id'],
            'id' => $accesss_map['service_directory_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['service_directory_access_map_id'], $access_level_mapping))
        {
            $result['service_directory_access']['checked'] = 'checked';
        }
        $result['service_directory_write'] = array(
            'name' => $accesss_map['service_directory_write_map_id'],
            'id' => $accesss_map['service_directory_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['service_directory_write_map_id'], $access_level_mapping))
        {
            $result['service_directory_write']['checked'] = 'checked';
        }
	$result['service_directory_approve'] = array(
            'name' => $accesss_map['service_directory_approve_map_id'],
            'id' => $accesss_map['service_directory_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['service_directory_approve_map_id'], $access_level_mapping))
        {
            $result['service_directory_approve']['checked'] = 'checked';
        }
	$result['service_directory_edit'] = array(
            'name' => $accesss_map['service_directory_edit_map_id'],
            'id' => $accesss_map['service_directory_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['service_directory_edit_map_id'], $access_level_mapping))
        {
            $result['service_directory_edit']['checked'] = 'checked';
        }
	$result['service_directory_delete'] = array(
            'name' => $accesss_map['service_directory_delete_map_id'],
            'id' => $accesss_map['service_directory_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['service_directory_delete_map_id'], $access_level_mapping))
        {
            $result['service_directory_delete']['checked'] = 'checked';
        }
	$result['service_directory_configuration'] = array(
            'name' => $accesss_map['service_directory_configuration_map_id'],
            'id' => $accesss_map['service_directory_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['service_directory_configuration_map_id'], $access_level_mapping))
        {
            $result['service_directory_configuration']['checked'] = 'checked';
        }
        $result['service_directory_writing'] = array(
            'name' => $accesss_map['service_directory_writing_map_id'],
            'id' => $accesss_map['service_directory_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['service_directory_writing_map_id'], $access_level_mapping))
        {
            $result['service_directory_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        //News checkbox
        $result['news_view'] = array(
            'name' => $accesss_map['news_view_map_id'],
            'id' => $accesss_map['news_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['news_view_map_id'], $access_level_mapping))
        {
            $result['news_view']['checked'] = 'checked';
        }        
        $result['news_access'] = array(
            'name' => $accesss_map['news_access_map_id'],
            'id' => $accesss_map['news_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['news_access_map_id'], $access_level_mapping))
        {
            $result['news_access']['checked'] = 'checked';
        }
        $result['news_write'] = array(
            'name' => $accesss_map['news_write_map_id'],
            'id' => $accesss_map['news_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['news_write_map_id'], $access_level_mapping))
        {
            $result['news_write']['checked'] = 'checked';
        }
	$result['news_approve'] = array(
            'name' => $accesss_map['news_approve_map_id'],
            'id' => $accesss_map['news_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['news_approve_map_id'], $access_level_mapping))
        {
            $result['news_approve']['checked'] = 'checked';
        }
	$result['news_edit'] = array(
            'name' => $accesss_map['news_edit_map_id'],
            'id' => $accesss_map['news_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['news_edit_map_id'], $access_level_mapping))
        {
            $result['news_edit']['checked'] = 'checked';
        }
	$result['news_delete'] = array(
            'name' => $accesss_map['news_delete_map_id'],
            'id' => $accesss_map['news_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['news_delete_map_id'], $access_level_mapping))
        {
            $result['news_delete']['checked'] = 'checked';
        }
	$result['news_configuration'] = array(
            'name' => $accesss_map['news_configuration_map_id'],
            'id' => $accesss_map['news_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['news_configuration_map_id'], $access_level_mapping))
        {
            $result['news_configuration']['checked'] = 'checked';
        }
        $result['news_writing'] = array(
            'name' => $accesss_map['news_writing_map_id'],
            'id' => $accesss_map['news_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['news_writing_map_id'], $access_level_mapping))
        {
            $result['news_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        //Blogs checkbox
        $result['blogs_view'] = array(
            'name' => $accesss_map['blogs_view_map_id'],
            'id' => $accesss_map['blogs_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['blogs_view_map_id'], $access_level_mapping))
        {
            $result['blogs_view']['checked'] = 'checked';
        }        
        $result['blogs_access'] = array(
            'name' => $accesss_map['blogs_access_map_id'],
            'id' => $accesss_map['blogs_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['blogs_access_map_id'], $access_level_mapping))
        {
            $result['blogs_access']['checked'] = 'checked';
        }
        $result['blogs_write'] = array(
            'name' => $accesss_map['blogs_write_map_id'],
            'id' => $accesss_map['blogs_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['blogs_write_map_id'], $access_level_mapping))
        {
            $result['blogs_write']['checked'] = 'checked';
        }
	$result['blogs_approve'] = array(
            'name' => $accesss_map['blogs_approve_map_id'],
            'id' => $accesss_map['blogs_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['blogs_approve_map_id'], $access_level_mapping))
        {
            $result['blogs_approve']['checked'] = 'checked';
        }
	$result['blogs_edit'] = array(
            'name' => $accesss_map['blogs_edit_map_id'],
            'id' => $accesss_map['blogs_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['blogs_edit_map_id'], $access_level_mapping))
        {
            $result['blogs_edit']['checked'] = 'checked';
        }
	$result['blogs_delete'] = array(
            'name' => $accesss_map['blogs_delete_map_id'],
            'id' => $accesss_map['blogs_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['blogs_delete_map_id'], $access_level_mapping))
        {
            $result['blogs_delete']['checked'] = 'checked';
        }
	$result['blogs_configuration'] = array(
            'name' => $accesss_map['blogs_configuration_map_id'],
            'id' => $accesss_map['blogs_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['blogs_configuration_map_id'], $access_level_mapping))
        {
            $result['blogs_configuration']['checked'] = 'checked';
        }
        $result['blogs_writing'] = array(
            'name' => $accesss_map['blogs_writing_map_id'],
            'id' => $accesss_map['blogs_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['blogs_writing_map_id'], $access_level_mapping))
        {
            $result['blogs_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        //BMI calculator checkbox
        $result['bmi_calculator_view'] = array(
            'name' => $accesss_map['bmi_calculator_view_map_id'],
            'id' => $accesss_map['bmi_calculator_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['bmi_calculator_view_map_id'], $access_level_mapping))
        {
            $result['bmi_calculator_view']['checked'] = 'checked';
        }        
        $result['bmi_calculator_access'] = array(
            'name' => $accesss_map['bmi_calculator_access_map_id'],
            'id' => $accesss_map['bmi_calculator_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['bmi_calculator_access_map_id'], $access_level_mapping))
        {
            $result['bmi_calculator_access']['checked'] = 'checked';
        }
        $result['bmi_calculator_write'] = array(
            'name' => $accesss_map['bmi_calculator_write_map_id'],
            'id' => $accesss_map['bmi_calculator_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['bmi_calculator_write_map_id'], $access_level_mapping))
        {
            $result['bmi_calculator_write']['checked'] = 'checked';
        }
	$result['bmi_calculator_approve'] = array(
            'name' => $accesss_map['bmi_calculator_approve_map_id'],
            'id' => $accesss_map['bmi_calculator_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['bmi_calculator_approve_map_id'], $access_level_mapping))
        {
            $result['bmi_calculator_approve']['checked'] = 'checked';
        }
	$result['bmi_calculator_edit'] = array(
            'name' => $accesss_map['bmi_calculator_edit_map_id'],
            'id' => $accesss_map['bmi_calculator_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['bmi_calculator_edit_map_id'], $access_level_mapping))
        {
            $result['bmi_calculator_edit']['checked'] = 'checked';
        }
	$result['bmi_calculator_delete'] = array(
            'name' => $accesss_map['bmi_calculator_delete_map_id'],
            'id' => $accesss_map['bmi_calculator_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['bmi_calculator_delete_map_id'], $access_level_mapping))
        {
            $result['bmi_calculator_delete']['checked'] = 'checked';
        }
	$result['bmi_calculator_configuration'] = array(
            'name' => $accesss_map['bmi_calculator_configuration_map_id'],
            'id' => $accesss_map['bmi_calculator_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['bmi_calculator_configuration_map_id'], $access_level_mapping))
        {
            $result['bmi_calculator_configuration']['checked'] = 'checked';
        }
        $result['bmi_calculator_writing'] = array(
            'name' => $accesss_map['bmi_calculator_writing_map_id'],
            'id' => $accesss_map['bmi_calculator_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['bmi_calculator_writing_map_id'], $access_level_mapping))
        {
            $result['bmi_calculator_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        //Photography checkbox
        $result['photography_view'] = array(
            'name' => $accesss_map['photography_view_map_id'],
            'id' => $accesss_map['photography_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['photography_view_map_id'], $access_level_mapping))
        {
            $result['photography_view']['checked'] = 'checked';
        }        
        $result['photography_access'] = array(
            'name' => $accesss_map['photography_access_map_id'],
            'id' => $accesss_map['photography_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['photography_access_map_id'], $access_level_mapping))
        {
            $result['photography_access']['checked'] = 'checked';
        }
        $result['photography_write'] = array(
            'name' => $accesss_map['photography_write_map_id'],
            'id' => $accesss_map['photography_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['photography_write_map_id'], $access_level_mapping))
        {
            $result['photography_write']['checked'] = 'checked';
        }
	$result['photography_approve'] = array(
            'name' => $accesss_map['photography_approve_map_id'],
            'id' => $accesss_map['photography_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['photography_approve_map_id'], $access_level_mapping))
        {
            $result['photography_approve']['checked'] = 'checked';
        }
	$result['photography_edit'] = array(
            'name' => $accesss_map['photography_edit_map_id'],
            'id' => $accesss_map['photography_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['photography_edit_map_id'], $access_level_mapping))
        {
            $result['photography_edit']['checked'] = 'checked';
        }
	$result['photography_delete'] = array(
            'name' => $accesss_map['photography_delete_map_id'],
            'id' => $accesss_map['photography_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['photography_delete_map_id'], $access_level_mapping))
        {
            $result['photography_delete']['checked'] = 'checked';
        }
	$result['photography_configuration'] = array(
            'name' => $accesss_map['photography_configuration_map_id'],
            'id' => $accesss_map['photography_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['photography_configuration_map_id'], $access_level_mapping))
        {
            $result['photography_configuration']['checked'] = 'checked';
        }
        $result['photography_writing'] = array(
            'name' => $accesss_map['photography_writing_map_id'],
            'id' => $accesss_map['photography_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['photography_writing_map_id'], $access_level_mapping))
        {
            $result['photography_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        //Business Profile checkbox
        $result['business_profile_view'] = array(
            'name' => $accesss_map['business_profile_view_map_id'],
            'id' => $accesss_map['business_profile_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['business_profile_view_map_id'], $access_level_mapping))
        {
            $result['business_profile_view']['checked'] = 'checked';
        }        
        $result['business_profile_access'] = array(
            'name' => $accesss_map['business_profile_access_map_id'],
            'id' => $accesss_map['business_profile_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['business_profile_access_map_id'], $access_level_mapping))
        {
            $result['business_profile_access']['checked'] = 'checked';
        }
        $result['business_profile_write'] = array(
            'name' => $accesss_map['business_profile_write_map_id'],
            'id' => $accesss_map['business_profile_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['business_profile_write_map_id'], $access_level_mapping))
        {
            $result['business_profile_write']['checked'] = 'checked';
        }
	$result['business_profile_approve'] = array(
            'name' => $accesss_map['business_profile_approve_map_id'],
            'id' => $accesss_map['business_profile_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['business_profile_approve_map_id'], $access_level_mapping))
        {
            $result['business_profile_approve']['checked'] = 'checked';
        }
	$result['business_profile_edit'] = array(
            'name' => $accesss_map['business_profile_edit_map_id'],
            'id' => $accesss_map['business_profile_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['business_profile_edit_map_id'], $access_level_mapping))
        {
            $result['business_profile_edit']['checked'] = 'checked';
        }
	$result['business_profile_delete'] = array(
            'name' => $accesss_map['business_profile_delete_map_id'],
            'id' => $accesss_map['business_profile_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['business_profile_delete_map_id'], $access_level_mapping))
        {
            $result['business_profile_delete']['checked'] = 'checked';
        }
	$result['business_profile_configuration'] = array(
            'name' => $accesss_map['business_profile_configuration_map_id'],
            'id' => $accesss_map['business_profile_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['business_profile_configuration_map_id'], $access_level_mapping))
        {
            $result['business_profile_configuration']['checked'] = 'checked';
        }
        $result['business_profile_writing'] = array(
            'name' => $accesss_map['business_profile_writing_map_id'],
            'id' => $accesss_map['business_profile_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['business_profile_writing_map_id'], $access_level_mapping))
        {
            $result['business_profile_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        //visitor pages checkbox
        $result['visitor_page_view'] = array(
            'name' => $accesss_map['visitor_page_view_map_id'],
            'id' => $accesss_map['visitor_page_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_page_view_map_id'], $access_level_mapping))
        {
            $result['visitor_page_view']['checked'] = 'checked';
        }        
        $result['visitor_page_access'] = array(
            'name' => $accesss_map['visitor_page_access_map_id'],
            'id' => $accesss_map['visitor_page_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_page_access_map_id'], $access_level_mapping))
        {
            $result['visitor_page_access']['checked'] = 'checked';
        }
        $result['visitor_page_write'] = array(
            'name' => $accesss_map['visitor_page_write_map_id'],
            'id' => $accesss_map['visitor_page_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_page_write_map_id'], $access_level_mapping))
        {
            $result['visitor_page_write']['checked'] = 'checked';
        }
	$result['visitor_page_approve'] = array(
            'name' => $accesss_map['visitor_page_approve_map_id'],
            'id' => $accesss_map['visitor_page_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_page_approve_map_id'], $access_level_mapping))
        {
            $result['visitor_page_approve']['checked'] = 'checked';
        }
	$result['visitor_page_edit'] = array(
            'name' => $accesss_map['visitor_page_edit_map_id'],
            'id' => $accesss_map['visitor_page_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_page_edit_map_id'], $access_level_mapping))
        {
            $result['visitor_page_edit']['checked'] = 'checked';
        }
	$result['visitor_page_delete'] = array(
            'name' => $accesss_map['visitor_page_delete_map_id'],
            'id' => $accesss_map['visitor_page_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_page_delete_map_id'], $access_level_mapping))
        {
            $result['visitor_page_delete']['checked'] = 'checked';
        }
	$result['visitor_page_configuration'] = array(
            'name' => $accesss_map['visitor_page_configuration_map_id'],
            'id' => $accesss_map['visitor_page_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_page_configuration_map_id'], $access_level_mapping))
        {
            $result['visitor_page_configuration']['checked'] = 'checked';
        }
        $result['visitor_page_writing'] = array(
            'name' => $accesss_map['visitor_page_writing_map_id'],
            'id' => $accesss_map['visitor_page_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_page_writing_map_id'], $access_level_mapping))
        {
            $result['visitor_page_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        //visitor Applications checkbox
        $result['visitor_applications_view'] = array(
            'name' => $accesss_map['visitor_applications_view_map_id'],
            'id' => $accesss_map['visitor_applications_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_applications_view_map_id'], $access_level_mapping))
        {
            $result['visitor_applications_view']['checked'] = 'checked';
        }        
        $result['visitor_applications_access'] = array(
            'name' => $accesss_map['visitor_applications_access_map_id'],
            'id' => $accesss_map['visitor_applications_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_applications_access_map_id'], $access_level_mapping))
        {
            $result['visitor_applications_access']['checked'] = 'checked';
        }
        $result['visitor_applications_write'] = array(
            'name' => $accesss_map['visitor_applications_write_map_id'],
            'id' => $accesss_map['visitor_applications_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_applications_write_map_id'], $access_level_mapping))
        {
            $result['visitor_applications_write']['checked'] = 'checked';
        }
	$result['visitor_applications_approve'] = array(
            'name' => $accesss_map['visitor_applications_approve_map_id'],
            'id' => $accesss_map['visitor_applications_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_applications_approve_map_id'], $access_level_mapping))
        {
            $result['visitor_applications_approve']['checked'] = 'checked';
        }
	$result['visitor_applications_edit'] = array(
            'name' => $accesss_map['visitor_applications_edit_map_id'],
            'id' => $accesss_map['visitor_applications_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_applications_edit_map_id'], $access_level_mapping))
        {
            $result['visitor_applications_edit']['checked'] = 'checked';
        }
	$result['visitor_applications_delete'] = array(
            'name' => $accesss_map['visitor_applications_delete_map_id'],
            'id' => $accesss_map['visitor_applications_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_applications_delete_map_id'], $access_level_mapping))
        {
            $result['visitor_applications_delete']['checked'] = 'checked';
        }
	$result['visitor_applications_configuration'] = array(
            'name' => $accesss_map['visitor_applications_configuration_map_id'],
            'id' => $accesss_map['visitor_applications_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_applications_configuration_map_id'], $access_level_mapping))
        {
            $result['visitor_applications_configuration']['checked'] = 'checked';
        }
        $result['visitor_applications_writing'] = array(
            'name' => $accesss_map['visitor_applications_writing_map_id'],
            'id' => $accesss_map['visitor_applications_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_applications_writing_map_id'], $access_level_mapping))
        {
            $result['visitor_applications_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        //visitor business_profile checkbox
        $result['visitor_business_profile_view'] = array(
            'name' => $accesss_map['visitor_business_profile_view_map_id'],
            'id' => $accesss_map['visitor_business_profile_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_business_profile_view_map_id'], $access_level_mapping))
        {
            $result['visitor_business_profile_view']['checked'] = 'checked';
        }        
        $result['visitor_business_profile_access'] = array(
            'name' => $accesss_map['visitor_business_profile_access_map_id'],
            'id' => $accesss_map['visitor_business_profile_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_business_profile_access_map_id'], $access_level_mapping))
        {
            $result['visitor_business_profile_access']['checked'] = 'checked';
        }
        $result['visitor_business_profile_write'] = array(
            'name' => $accesss_map['visitor_business_profile_write_map_id'],
            'id' => $accesss_map['visitor_business_profile_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_business_profile_write_map_id'], $access_level_mapping))
        {
            $result['visitor_business_profile_write']['checked'] = 'checked';
        }
	$result['visitor_business_profile_approve'] = array(
            'name' => $accesss_map['visitor_business_profile_approve_map_id'],
            'id' => $accesss_map['visitor_business_profile_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_business_profile_approve_map_id'], $access_level_mapping))
        {
            $result['visitor_business_profile_approve']['checked'] = 'checked';
        }
	$result['visitor_business_profile_edit'] = array(
            'name' => $accesss_map['visitor_business_profile_edit_map_id'],
            'id' => $accesss_map['visitor_business_profile_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_business_profile_edit_map_id'], $access_level_mapping))
        {
            $result['visitor_business_profile_edit']['checked'] = 'checked';
        }
	$result['visitor_business_profile_delete'] = array(
            'name' => $accesss_map['visitor_business_profile_delete_map_id'],
            'id' => $accesss_map['visitor_business_profile_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_business_profile_delete_map_id'], $access_level_mapping))
        {
            $result['visitor_business_profile_delete']['checked'] = 'checked';
        }
	$result['visitor_business_profile_configuration'] = array(
            'name' => $accesss_map['visitor_business_profile_configuration_map_id'],
            'id' => $accesss_map['visitor_business_profile_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_business_profile_configuration_map_id'], $access_level_mapping))
        {
            $result['visitor_business_profile_configuration']['checked'] = 'checked';
        }
        $result['visitor_business_profile_writing'] = array(
            'name' => $accesss_map['visitor_business_profile_writing_map_id'],
            'id' => $accesss_map['visitor_business_profile_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_business_profile_writing_map_id'], $access_level_mapping))
        {
            $result['visitor_business_profile_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        //visitor log checkbox
        $result['log_view'] = array(
            'name' => $accesss_map['log_view_map_id'],
            'id' => $accesss_map['log_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['log_view_map_id'], $access_level_mapping))
        {
            $result['log_view']['checked'] = 'checked';
        }        
        $result['log_access'] = array(
            'name' => $accesss_map['log_access_map_id'],
            'id' => $accesss_map['log_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['log_access_map_id'], $access_level_mapping))
        {
            $result['log_access']['checked'] = 'checked';
        }
        $result['log_write'] = array(
            'name' => $accesss_map['log_write_map_id'],
            'id' => $accesss_map['log_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['log_write_map_id'], $access_level_mapping))
        {
            $result['log_write']['checked'] = 'checked';
        }
	$result['log_approve'] = array(
            'name' => $accesss_map['log_approve_map_id'],
            'id' => $accesss_map['log_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['log_approve_map_id'], $access_level_mapping))
        {
            $result['log_approve']['checked'] = 'checked';
        }
	$result['log_edit'] = array(
            'name' => $accesss_map['log_edit_map_id'],
            'id' => $accesss_map['log_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['log_edit_map_id'], $access_level_mapping))
        {
            $result['log_edit']['checked'] = 'checked';
        }
	$result['log_delete'] = array(
            'name' => $accesss_map['log_delete_map_id'],
            'id' => $accesss_map['log_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['log_delete_map_id'], $access_level_mapping))
        {
            $result['log_delete']['checked'] = 'checked';
        }
	$result['log_configuration'] = array(
            'name' => $accesss_map['log_configuration_map_id'],
            'id' => $accesss_map['log_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['log_configuration_map_id'], $access_level_mapping))
        {
            $result['log_configuration']['checked'] = 'checked';
        }
        $result['log_writing'] = array(
            'name' => $accesss_map['log_writing_map_id'],
            'id' => $accesss_map['log_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['log_writing_map_id'], $access_level_mapping))
        {
            $result['log_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//        
        //Footer about us checkbox
        $result['about_us_view'] = array(
            'name' => $accesss_map['about_us_view_map_id'],
            'id' => $accesss_map['about_us_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['about_us_view_map_id'], $access_level_mapping))
        {
            $result['about_us_view']['checked'] = 'checked';
        }        
        $result['about_us_access'] = array(
            'name' => $accesss_map['about_us_access_map_id'],
            'id' => $accesss_map['about_us_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['about_us_access_map_id'], $access_level_mapping))
        {
            $result['about_us_access']['checked'] = 'checked';
        }
        $result['about_us_write'] = array(
            'name' => $accesss_map['about_us_write_map_id'],
            'id' => $accesss_map['about_us_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['about_us_write_map_id'], $access_level_mapping))
        {
            $result['about_us_write']['checked'] = 'checked';
        }
	$result['about_us_approve'] = array(
            'name' => $accesss_map['about_us_approve_map_id'],
            'id' => $accesss_map['about_us_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['about_us_approve_map_id'], $access_level_mapping))
        {
            $result['about_us_approve']['checked'] = 'checked';
        }
	$result['about_us_edit'] = array(
            'name' => $accesss_map['about_us_edit_map_id'],
            'id' => $accesss_map['about_us_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['about_us_edit_map_id'], $access_level_mapping))
        {
            $result['about_us_edit']['checked'] = 'checked';
        }
	$result['about_us_delete'] = array(
            'name' => $accesss_map['about_us_delete_map_id'],
            'id' => $accesss_map['about_us_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['about_us_delete_map_id'], $access_level_mapping))
        {
            $result['about_us_delete']['checked'] = 'checked';
        }
	$result['about_us_configuration'] = array(
            'name' => $accesss_map['about_us_configuration_map_id'],
            'id' => $accesss_map['about_us_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['about_us_configuration_map_id'], $access_level_mapping))
        {
            $result['about_us_configuration']['checked'] = 'checked';
        }
        $result['about_us_writing'] = array(
            'name' => $accesss_map['about_us_writing_map_id'],
            'id' => $accesss_map['about_us_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['about_us_writing_map_id'], $access_level_mapping))
        {
            $result['about_us_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        //Footer Contact us checkbox
        $result['contact_us_view'] = array(
            'name' => $accesss_map['contact_us_view_map_id'],
            'id' => $accesss_map['contact_us_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['contact_us_view_map_id'], $access_level_mapping))
        {
            $result['contact_us_view']['checked'] = 'checked';
        }        
        $result['contact_us_access'] = array(
            'name' => $accesss_map['contact_us_access_map_id'],
            'id' => $accesss_map['contact_us_access_map_id'],
            'type' => 'checkbox'
        );        
        if(array_key_exists($accesss_map['contact_us_access_map_id'], $access_level_mapping))
        {
            $result['contact_us_access']['checked'] = 'checked';
        }
        $result['contact_us_write'] = array(
            'name' => $accesss_map['contact_us_write_map_id'],
            'id' => $accesss_map['contact_us_write_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['contact_us_write_map_id'], $access_level_mapping))
        {
            $result['contact_us_write']['checked'] = 'checked';
        }
	$result['contact_us_approve'] = array(
            'name' => $accesss_map['contact_us_approve_map_id'],
            'id' => $accesss_map['contact_us_approve_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['contact_us_approve_map_id'], $access_level_mapping))
        {
            $result['contact_us_approve']['checked'] = 'checked';
        }
	$result['contact_us_edit'] = array(
            'name' => $accesss_map['contact_us_edit_map_id'],
            'id' => $accesss_map['contact_us_edit_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['contact_us_edit_map_id'], $access_level_mapping))
        {
            $result['contact_us_edit']['checked'] = 'checked';
        }
	$result['contact_us_delete'] = array(
            'name' => $accesss_map['contact_us_delete_map_id'],
            'id' => $accesss_map['contact_us_delete_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['contact_us_delete_map_id'], $access_level_mapping))
        {
            $result['contact_us_delete']['checked'] = 'checked';
        }
	$result['contact_us_configuration'] = array(
            'name' => $accesss_map['contact_us_configuration_map_id'],
            'id' => $accesss_map['contact_us_configuration_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['contact_us_configuration_map_id'], $access_level_mapping))
        {
            $result['contact_us_configuration']['checked'] = 'checked';
        }
        $result['contact_us_writing'] = array(
            'name' => $accesss_map['contact_us_writing_map_id'],
            'id' => $accesss_map['contact_us_writing_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['contact_us_writing_map_id'], $access_level_mapping))
        {
            $result['contact_us_writing']['checked'] = 'checked';
        }
        //--------------------------------------------------------------------------//
        return $result;
    }
    
    public function get_access_map()
    {
        $accesss_map = array();
        $accesss_map['overview_view_map_id'] = ADMIN_ACCESS_LEVEL_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['overview_access_map_id'] = ADMIN_ACCESS_LEVEL_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['overview_write_map_id'] = ADMIN_ACCESS_LEVEL_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['overview_approve_map_id'] = ADMIN_ACCESS_LEVEL_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['overview_edit_map_id'] = ADMIN_ACCESS_LEVEL_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['overview_delete_map_id'] = ADMIN_ACCESS_LEVEL_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['overview_configuration_map_id'] = ADMIN_ACCESS_LEVEL_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['overview_writing_map_id'] = ADMIN_ACCESS_LEVEL_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['user_overview_view_map_id'] = ADMIN_ACCESS_LEVEL_USERS_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['user_overview_access_map_id'] = ADMIN_ACCESS_LEVEL_USERS_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['user_overview_write_map_id'] = ADMIN_ACCESS_LEVEL_USERS_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['user_overview_approve_map_id'] = ADMIN_ACCESS_LEVEL_USERS_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['user_overview_edit_map_id'] = ADMIN_ACCESS_LEVEL_USERS_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['user_overview_delete_map_id'] = ADMIN_ACCESS_LEVEL_USERS_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['user_overview_configuration_map_id'] = ADMIN_ACCESS_LEVEL_USERS_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['user_overview_writing_map_id'] = ADMIN_ACCESS_LEVEL_USERS_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['user_manage_view_map_id'] = ADMIN_ACCESS_LEVEL_USERS_USER_MANAGE_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['user_manage_access_map_id'] = ADMIN_ACCESS_LEVEL_USERS_USER_MANAGE_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['user_manage_write_map_id'] = ADMIN_ACCESS_LEVEL_USERS_USER_MANAGE_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['user_manage_approve_map_id'] = ADMIN_ACCESS_LEVEL_USERS_USER_MANAGE_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['user_manage_edit_map_id'] = ADMIN_ACCESS_LEVEL_USERS_USER_MANAGE_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['user_manage_delete_map_id'] = ADMIN_ACCESS_LEVEL_USERS_USER_MANAGE_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['user_manage_configuration_map_id'] = ADMIN_ACCESS_LEVEL_USERS_USER_MANAGE_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['user_manage_writing_map_id'] = ADMIN_ACCESS_LEVEL_USERS_USER_MANAGE_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['xstream_banter_view_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_XSTREAM_BANTER_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['xstream_banter_access_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_XSTREAM_BANTER_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['xstream_banter_write_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_XSTREAM_BANTER_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['xstream_banter_approve_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_XSTREAM_BANTER_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['xstream_banter_edit_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_XSTREAM_BANTER_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['xstream_banter_delete_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_XSTREAM_BANTER_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['xstream_banter_configuration_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_XSTREAM_BANTER_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['xstream_banter_writing_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_XSTREAM_BANTER_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['healthy_recipes_view_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['healthy_recipes_access_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['healthy_recipes_write_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['healthy_recipes_approve_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['healthy_recipes_edit_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['healthy_recipes_delete_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['healthy_recipes_configuration_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['healthy_recipes_writing_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['service_directory_view_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['service_directory_access_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['service_directory_write_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['service_directory_approve_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['service_directory_edit_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['service_directory_delete_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['service_directory_configuration_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['service_directory_writing_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['news_view_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['news_access_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['news_write_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['news_approve_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['news_edit_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['news_delete_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['news_configuration_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['news_writing_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['blogs_view_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['blogs_access_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['blogs_write_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['blogs_approve_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['blogs_edit_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['blogs_delete_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['blogs_configuration_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['blogs_writing_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['bmi_calculator_view_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['bmi_calculator_access_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['bmi_calculator_write_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['bmi_calculator_approve_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['bmi_calculator_edit_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['bmi_calculator_delete_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['bmi_calculator_configuration_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['bmi_calculator_writing_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['photography_view_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['photography_access_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['photography_write_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['photography_approve_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['photography_edit_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['photography_delete_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['photography_configuration_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['photography_writing_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['business_profile_view_map_id'] = ADMIN_ACCESS_LEVEL_BUSINESS_PROFILES_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['business_profile_access_map_id'] = ADMIN_ACCESS_LEVEL_BUSINESS_PROFILES_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['business_profile_write_map_id'] = ADMIN_ACCESS_LEVEL_BUSINESS_PROFILES_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['business_profile_approve_map_id'] = ADMIN_ACCESS_LEVEL_BUSINESS_PROFILES_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['business_profile_edit_map_id'] = ADMIN_ACCESS_LEVEL_BUSINESS_PROFILES_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['business_profile_delete_map_id'] = ADMIN_ACCESS_LEVEL_BUSINESS_PROFILES_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['business_profile_configuration_map_id'] = ADMIN_ACCESS_LEVEL_BUSINESS_PROFILES_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['business_profile_writing_map_id'] = ADMIN_ACCESS_LEVEL_BUSINESS_PROFILES_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['visitor_page_view_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_PAGES_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['visitor_page_access_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_PAGES_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['visitor_page_write_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_PAGES_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['visitor_page_approve_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_PAGES_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['visitor_page_edit_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_PAGES_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['visitor_page_delete_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_PAGES_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['visitor_page_configuration_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_PAGES_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['visitor_page_writing_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_PAGES_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['visitor_applications_view_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_APPLICATIONS_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['visitor_applications_access_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_APPLICATIONS_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['visitor_applications_write_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_APPLICATIONS_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['visitor_applications_approve_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_APPLICATIONS_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['visitor_applications_edit_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_APPLICATIONS_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['visitor_applications_delete_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_APPLICATIONS_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['visitor_applications_configuration_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_APPLICATIONS_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['visitor_applications_writing_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_APPLICATIONS_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['visitor_business_profile_view_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_BUSINESS_PROFILE_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['visitor_business_profile_access_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_BUSINESS_PROFILE_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['visitor_business_profile_write_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_BUSINESS_PROFILE_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['visitor_business_profile_approve_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_BUSINESS_PROFILE_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['visitor_business_profile_edit_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_BUSINESS_PROFILE_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['visitor_business_profile_delete_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_BUSINESS_PROFILE_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['visitor_business_profile_configuration_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_BUSINESS_PROFILE_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['visitor_business_profile_writing_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_BUSINESS_PROFILE_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['log_view_map_id'] = ADMIN_ACCESS_LEVEL_LOG_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['log_access_map_id'] = ADMIN_ACCESS_LEVEL_LOG_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['log_write_map_id'] = ADMIN_ACCESS_LEVEL_LOG_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['log_approve_map_id'] = ADMIN_ACCESS_LEVEL_LOG_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['log_edit_map_id'] = ADMIN_ACCESS_LEVEL_LOG_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['log_delete_map_id'] = ADMIN_ACCESS_LEVEL_LOG_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['log_configuration_map_id'] = ADMIN_ACCESS_LEVEL_LOG_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['log_writing_map_id'] = ADMIN_ACCESS_LEVEL_LOG_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['about_us_view_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_ABOUT_US_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['about_us_access_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_ABOUT_US_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['about_us_write_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_ABOUT_US_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['about_us_approve_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_ABOUT_US_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['about_us_edit_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_ABOUT_US_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['about_us_delete_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_ABOUT_US_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['about_us_configuration_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_ABOUT_US_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['about_us_writing_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_ABOUT_US_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        $accesss_map['contact_us_view_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_CONTACT_US_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['contact_us_access_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_CONTACT_US_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        $accesss_map['contact_us_write_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_CONTACT_US_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE;
        $accesss_map['contact_us_approve_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_CONTACT_US_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE;
        $accesss_map['contact_us_edit_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_CONTACT_US_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT;
        $accesss_map['contact_us_delete_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_CONTACT_US_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE;
        $accesss_map['contact_us_configuration_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_CONTACT_US_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION;
        $accesss_map['contact_us_writing_map_id'] = ADMIN_ACCESS_LEVEL_FOOTER_CONTACT_US_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING;
        //--------------------------------------------------------------------------//
        return $accesss_map;
    }
    
    public function access_level_input_process($form_post_array)
    {
        $accesss_map = $this->get_access_map();
        $access_level_mapping = array();
        if(array_key_exists($accesss_map['overview_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['overview_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['overview_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['overview_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['overview_write_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['overview_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['overview_approve_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['overview_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['overview_edit_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['overview_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['overview_delete_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['overview_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['overview_configuration_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['overview_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['overview_writing_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['overview_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['user_overview_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['user_overview_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_overview_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['user_overview_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_overview_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['user_overview_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_overview_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['user_overview_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_overview_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['user_overview_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_overview_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['user_overview_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_overview_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['user_overview_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_overview_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['user_overview_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['user_manage_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['user_manage_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_manage_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['user_manage_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_manage_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['user_manage_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_manage_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['user_manage_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_manage_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['user_manage_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_manage_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['user_manage_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_manage_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['user_manage_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_manage_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['user_manage_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['xstream_banter_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['xstream_banter_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['xstream_banter_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['xstream_banter_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['xstream_banter_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['xstream_banter_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['xstream_banter_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['xstream_banter_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['xstream_banter_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['xstream_banter_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['xstream_banter_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['xstream_banter_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['xstream_banter_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['xstream_banter_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['xstream_banter_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['xstream_banter_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['healthy_recipes_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['healthy_recipes_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['healthy_recipes_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['healthy_recipes_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['healthy_recipes_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['healthy_recipes_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['healthy_recipes_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['healthy_recipes_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['healthy_recipes_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['healthy_recipes_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['healthy_recipes_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['healthy_recipes_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['healthy_recipes_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['healthy_recipes_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['healthy_recipes_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['healthy_recipes_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['service_directory_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['service_directory_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['service_directory_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['service_directory_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['service_directory_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['service_directory_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['service_directory_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['service_directory_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['service_directory_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['service_directory_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['service_directory_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['service_directory_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['service_directory_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['service_directory_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['service_directory_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['service_directory_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['news_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['news_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['news_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['news_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['news_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['news_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['news_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['news_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['news_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['news_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['news_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['news_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['news_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['news_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['news_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['news_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['blogs_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['blogs_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['blogs_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['blogs_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['blogs_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['blogs_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['blogs_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['blogs_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['blogs_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['blogs_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['blogs_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['blogs_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['blogs_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['blogs_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['blogs_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['blogs_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['bmi_calculator_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['bmi_calculator_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['bmi_calculator_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['bmi_calculator_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['bmi_calculator_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['bmi_calculator_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['bmi_calculator_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['bmi_calculator_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['bmi_calculator_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['bmi_calculator_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['bmi_calculator_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['bmi_calculator_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['bmi_calculator_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['bmi_calculator_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['bmi_calculator_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['bmi_calculator_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['photography_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['photography_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['photography_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['photography_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['photography_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['photography_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['photography_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['photography_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['photography_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['photography_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['photography_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['photography_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['photography_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['photography_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['photography_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['photography_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['business_profile_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['business_profile_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['business_profile_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['business_profile_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['business_profile_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['business_profile_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['business_profile_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['business_profile_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['business_profile_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['business_profile_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['business_profile_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['business_profile_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['business_profile_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['business_profile_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['business_profile_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['business_profile_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['visitor_page_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['visitor_page_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_page_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['visitor_page_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_page_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_page_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_page_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_page_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_page_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_page_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_page_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_page_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_page_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_page_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_page_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_page_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['visitor_applications_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['visitor_applications_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_applications_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['visitor_applications_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_applications_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_applications_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_applications_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_applications_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_applications_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_applications_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_applications_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_applications_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_applications_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_applications_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_applications_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_applications_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['visitor_business_profile_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['visitor_business_profile_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_business_profile_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['visitor_business_profile_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_business_profile_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_business_profile_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_business_profile_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_business_profile_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_business_profile_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_business_profile_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_business_profile_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_business_profile_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_business_profile_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_business_profile_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_business_profile_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['visitor_business_profile_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['log_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['log_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['log_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['log_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['log_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['log_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['log_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['log_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['log_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['log_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['log_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['log_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['log_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['log_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['log_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['log_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['about_us_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['about_us_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['about_us_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['about_us_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['about_us_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['about_us_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['about_us_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['about_us_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['about_us_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['about_us_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['about_us_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['about_us_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['about_us_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['about_us_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['about_us_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['about_us_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        if(array_key_exists($accesss_map['contact_us_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['contact_us_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['contact_us_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['contact_us_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['contact_us_write_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['contact_us_write_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['contact_us_approve_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['contact_us_approve_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['contact_us_edit_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['contact_us_edit_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['contact_us_delete_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['contact_us_delete_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['contact_us_configuration_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['contact_us_configuration_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['contact_us_writing_map_id'], $form_post_array))
        {
                $access_level_mapping[$accesss_map['contact_us_writing_map_id']] = 1;
        }
        //--------------------------------------------------------------------------//
        return $access_level_mapping;
    }
    
    /*
     * This method will crate a new access level
     */
    public function create_access_level()
    {
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('access_level', 'Access Level Name', 'xss_clean|required');
        $this->data['message'] = '';
        if ($this->input->post('submit_create_access_level')) 
        {            
            if($this->form_validation->run() == true)
            {
                $additional_data = array(
                    'name' => $this->input->post('access_level'),
                    'description' => $this->input->post('access_level')
                );                
                $group_id = $this->admin_access_level_library->create_group($additional_data);
                if( $group_id !== FALSE )
                {
                    $this->session->set_flashdata('message', $this->admin_access_level_library->messages());
                    redirect('admin/access_level/create_access_level','refresh');
                }
                else
                {
                    $this->data['message'] = $this->admin_access_level_library->errors();
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
        
        $current_user_info = array();
        $current_user_info_array = $this->admin_access_level_library->get_user_info()->result_array();
        if(!empty($current_user_info_array))
        {
            $current_user_info = $current_user_info_array[0];
        }
        $this->data['current_user_info'] = $current_user_info;
        
        
        $this->data['access_level'] = array(
            'name' => 'access_level',
            'id' => 'access_level',
            'type' => 'text',
            'value' => ''
        );        
        $this->data['submit_create_access_level'] = array(
            'name' => 'submit_create_access_level',
            'id' => 'submit_create_access_level',
            'type' => 'submit',
            'value' => 'Create Access Level',
        );        
        $this->template->load(ADMIN_DASHBOARD_TEMPLATE, "admin/access_level/create_access_level", $this->data);
    }
}