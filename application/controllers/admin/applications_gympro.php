<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Applications_gympro extends Admin_Controller{
    public $tmpl = '';
    public $user_group_array = array();
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('org/admin/access_level/admin_access_level_library');
        $this->load->library('org/admin/application/admin_gympro_library');
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
            
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_GYMPRO_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->data['allow_view'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_GYMPRO_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS, $access_level_mapping))
            {
                $this->data['allow_access'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_GYMPRO_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE, $access_level_mapping))
            {
                $this->data['allow_write'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_GYMPRO_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE, $access_level_mapping))
            {
                $this->data['allow_approve'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_GYMPRO_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT, $access_level_mapping))
            {
                $this->data['allow_edit'] = TRUE;
            }if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_GYMPRO_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE, $access_level_mapping))
            {
                $this->data['allow_delete'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_GYMPRO_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION, $access_level_mapping))
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
        $this->template->load($this->tmpl, "admin/applications/gympro/index", $this->data);
    }    
    
    
    
    
    // ----------------------------------- ACCOUNT TYPE ---------------------------//

    public function manage_account_types()
    {
        $this->data['account_types_list'] = $this->admin_gympro_library->get_all_account_types()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_account_types", $this->data);
    }
    public function get_account_types_info()
    {
        $result['account_types_info'] = array();
        $account_types_id = $this->input->post('id');
        $account_types_info_array = $this->admin_gympro_library->get_account_types_info($account_types_id)->result_array();
        if(!empty($account_types_info_array))
        {
            $result['account_types_info'] = $account_types_info_array[0];
        }
        echo json_encode($result);
    }
    public function delete_account_types()
    {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->admin_gympro_library->delete_account_types($delete_id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function update_account_types()
    {
        $result = array();
        $id = $this->input->post('id');
        $title = $this->input->post('title');
//        $price = $this->input->post('price');
//        $total_user = $this->input->post('total_user');
        $additional_data = array(
            'title' => $title,
//            'price' => $price,
//            'total_user' => $total_user,
            'modified_on' => now()
        );
        if($this->admin_gympro_library->update_account_types($id, $additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function create_account_types()
    {
        $result = array();
        $title = $this->input->post('title');
//        $price = $this->input->post('price');
//        $total_user = $this->input->post('total_user');
        $additional_data = array(
            'title' => $title,
//            'price' => $price,
//            'total_user' => $total_user
        );
        if($this->admin_gympro_library->create_account_types($additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    // ----------------------------------- Users ---------------------------//
    public function manage_users()
    {
        $this->data['user_list'] = $this->admin_gympro_library->get_all_users()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_users", $this->data);
    }
    public function get_preferences_info()
    {
        $result['preferences_info'] = array();
        $preferences_id = $this->input->post('id');
        $preferences_info_array = $this->admin_gympro_library->get_preferences_info($preferences_id)->result_array();
        if(!empty($preferences_info_array))
        {
            $result['preferences_info'] = $preferences_info_array[0];
        }
        echo json_encode($result);
    }
    public function delete_preferences()
    {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->admin_gympro_library->delete_preferences($delete_id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function update_preferences()
    {
        $result = array();
        $id = $this->input->post('id');
        $client_id = $this->input->post('client_id');
        $height_unit_id = $this->input->post('height_unit_id');
        $weight_unit_id = $this->input->post('weight_unit_id');
        $girth_unit_id = $this->input->post('girth_unit_id');
        $time_zone_id = $this->input->post('time_zone_id');
        $hourly_rate_id = $this->input->post('hourly_rate_id');
        $currency_id = $this->input->post('currency_id');
        $additional_data = array(
            'client_id' => $client_id,
            'height_unit_id' => $height_unit_id,
            'weight_unit_id' => $weight_unit_id,
            'girth_unit_id' => $girth_unit_id,
            'time_zone_id' => $time_zone_id,
            'hourly_rate_id' => $hourly_rate_id,
            'currency_id' => $currency_id,
            'modified_on' => now()
        );
        if($this->admin_gympro_library->update_preferences($id, $additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function create_preferences()
    {
        $result = array();
        $client_id = $this->input->post('client_id');
        $height_unit_id = $this->input->post('height_unit_id');
        $weight_unit_id = $this->input->post('weight_unit_id');
        $girth_unit_id = $this->input->post('girth_unit_id');
        $weight_unit_id = $this->input->post('weight_unit_id');
        $time_zone_id = $this->input->post('time_zone_id');
        $currency_id = $this->input->post('currency_id');
        $additional_data = array(
            'client_id' => $client_id,
            'height_unit_id' => $height_unit_id,
            'weight_unit_id' => $weight_unit_id,
            'girth_unit_id' => $girth_unit_id,
            'time_zone_id' => $time_zone_id,
            'hourly_rate_id' => $hourly_rate_id,
            'currency_id' => $currency_id,
        );
        if($this->admin_gympro_library->create_preferences($additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    
    //-----------------------------------Client Statuses--------------------//
    public function manage_client_statuses() {
        $this->data['data_list'] = $this->admin_gympro_library->get_all_client_statuses()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_client_statuses", $this->data);
    }

    public function get_client_statuses_info() {
        $result['data_info'] = array();
        $data_id = $this->input->post('id');
        $data_info_array = $this->admin_gympro_library->get_client_statuses_info($data_id)->result_array();
        if (!empty($data_info_array)) {
            $result['data_info'] = $data_info_array[0];
        }
        echo json_encode($result);
    }

    public function delete_client_statuses() {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if ($this->admin_gympro_library->delete_client_statuses($delete_id)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    public function update_client_statuses() {
        $result = array();
        $id = $this->input->post('id');
        $additional_data = array(
            'title' => $this->input->post('input_update_a')
        );        
        if ($this->admin_gympro_library->update_client_statuses($id, $additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    public function create_client_statuses() {
        $result = array();
        $additional_data = array(
            'title' => $this->input->post('input_a'),
        );
        if ($this->admin_gympro_library->create_client_statuses($additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    


    
    
    // ----------------------------------- Clients -------------------------------//

    public function manage_clients()
    {
        $this->data['clients_list'] = $this->admin_gympro_library->get_all_clients()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_clients", $this->data);
    }
    public function get_clients_info()
    {
        $result['clients_info'] = array();
        $clients_id = $this->input->post('id');
        $clients_info_array = $this->admin_gympro_library->get_clients_info($clients_id)->result_array();
        if(!empty($clients_info_array))
        {
            $result['clients_info'] = $clients_info_array[0];
        }
        echo json_encode($result);
    }
    public function delete_clients()
    {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->admin_gympro_library->delete_clients($delete_id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function update_clients()
    {
        $result = array();
        $id = $this->input->post('id');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $additional_data = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'modified_on' => now()
        );
        if($this->admin_gympro_library->update_clients($id, $additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function create_clients()
    {
        $result = array();
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $additional_data = array(
            'first_name' => $first_name,
            'last_name' => $last_name
        );
        if($this->admin_gympro_library->create_clients($additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    
       
    // ----------------------------------- health questions -------------------------------//
    public function manage_health_questions()
    {
        $this->data['health_questions_list'] = $this->admin_gympro_library->get_all_health_questions()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_health_questions", $this->data);
    }
    public function get_health_questions_info()
    {
        $result['health_questions_info'] = array();
        $health_questions_id = $this->input->post('id');
        $health_questions_info_array = $this->admin_gympro_library->get_health_questions_info($health_questions_id)->result_array();
        if(!empty($health_questions_info_array))
        {
            $result['health_questions_info'] = $health_questions_info_array[0];
        }
        echo json_encode($result);
    }
    public function delete_health_questions()
    {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->admin_gympro_library->delete_health_questions($delete_id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function update_health_questions()
    {
        $result = array();
        $id = $this->input->post('id');
        $additional_data = array(
            'title' => $this->input->post('title'),
            'show_additional_info' => $this->input->post('show_additional_info'),
            'modified_on' => now()
        );
        if($this->admin_gympro_library->update_health_questions($id, $additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function create_health_questions()
    {
        $result = array();
        $additional_data = array(
            'title' => $this->input->post('title'),
            'show_additional_info' => $this->input->post('show_additional_info'),
        );
        if($this->admin_gympro_library->create_health_questions($additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    
    // ----------------------------------- height unit types ---------------------------//
    public function manage_height_unit_types()
    {
        $this->data['height_unit_types_list'] = $this->admin_gympro_library->get_all_height_unit_types()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_height_unit_types", $this->data);
    }
    public function get_height_unit_types_info()
    {
        $result['height_unit_types_info'] = array();
        $height_unit_types_id = $this->input->post('id');
        $height_unit_types_info_array = $this->admin_gympro_library->get_height_unit_types_info($height_unit_types_id)->result_array();
        if(!empty($height_unit_types_info_array))
        {
            $result['height_unit_types_info'] = $height_unit_types_info_array[0];
        }
        echo json_encode($result);
    }
    public function delete_height_unit_types()
    {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->admin_gympro_library->delete_height_unit_types($delete_id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function update_height_unit_types()
    {
        $result = array();
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $additional_data = array(
            'title' => $title,
            'modified_on' => now()
        );
        if($this->admin_gympro_library->update_height_unit_types($id, $additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function create_height_unit_types()
    {
        $result = array();
        $title = $this->input->post('title');
        $additional_data = array(
            'title' => $title,
        );
        if($this->admin_gympro_library->create_height_unit_types($additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    
    
    // -----------------------------------  weight unit types ---------------------------//
    public function manage_weight_unit_types()
    {
        $this->data['weight_unit_types_list'] = $this->admin_gympro_library->get_all_weight_unit_types()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_weight_unit_types", $this->data);
    }
    public function get_weight_unit_types_info()
    {
        $result['weight_unit_types_info'] = array();
        $weight_unit_types_id = $this->input->post('id');
        $weight_unit_types_info_array = $this->admin_gympro_library->get_weight_unit_types_info($weight_unit_types_id)->result_array();
        if(!empty($weight_unit_types_info_array))
        {
            $result['weight_unit_types_info'] = $weight_unit_types_info_array[0];
        }
        echo json_encode($result);
    }
    public function delete_weight_unit_types()
    {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->admin_gympro_library->delete_weight_unit_types($delete_id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function update_weight_unit_types()
    {
        $result = array();
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $additional_data = array(
            'title' => $title,
            'modified_on' => now()
        );
        if($this->admin_gympro_library->update_weight_unit_types($id, $additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function create_weight_unit_types()
    {
        $result = array();
        $title = $this->input->post('title');
        $additional_data = array(
            'title' => $title
        );
        if($this->admin_gympro_library->create_weight_unit_types($additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    
    // ----------------------------------- girth unit types ---------------------------//
    public function manage_girth_unit_types()
    {
        $this->data['girth_unit_types_list'] = $this->admin_gympro_library->get_all_girth_unit_types()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_girth_unit_types", $this->data);
    }
    public function get_girth_unit_types_info()
    {
        $result['girth_unit_types_info'] = array();
        $girth_unit_types_id = $this->input->post('id');
        $girth_unit_types_info_array = $this->admin_gympro_library->get_girth_unit_types_info($girth_unit_types_id)->result_array();
        if(!empty($girth_unit_types_info_array))
        {
            $result['girth_unit_types_info'] = $girth_unit_types_info_array[0];
        }
        echo json_encode($result);
    }
    public function delete_girth_unit_types()
    {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->admin_gympro_library->delete_girth_unit_types($delete_id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function update_girth_unit_types()
    {
        $result = array();
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $additional_data = array(
            'title' => $title,
            'modified_on' => now()
        );
        if($this->admin_gympro_library->update_girth_unit_types($id, $additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function create_girth_unit_types()
    {
        $result = array();
        $title = $this->input->post('title');
        $additional_data = array(
            'title' => $title,
        );
        if($this->admin_gympro_library->create_girth_unit_types($additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    
    
    // ----------------------------------- TIME ZONES ---------------------------//
    public function manage_time_zones()
    {
        $this->data['time_zones_list'] = $this->admin_gympro_library->get_all_time_zones()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_time_zones", $this->data);
    }
    public function get_time_zones_info()
    {
        $result['time_zones_info'] = array();
        $time_zones_id = $this->input->post('id');
        $time_zones_info_array = $this->admin_gympro_library->get_time_zones_info($time_zones_id)->result_array();
        if(!empty($time_zones_info_array))
        {
            $result['time_zones_info'] = $time_zones_info_array[0];
        }
        echo json_encode($result);
    }
    public function delete_time_zones()
    {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->admin_gympro_library->delete_time_zones($delete_id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function update_time_zones()
    {
        $result = array();
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $price = $this->input->post('price');
        $total_user = $this->input->post('total_user');
        $additional_data = array(
            'title' => $title,
            'modified_on' => now()
        );
        if($this->admin_gympro_library->update_time_zones($id, $additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function create_time_zones()
    {
        $result = array();
        $title = $this->input->post('title');
        $price = $this->input->post('price');
        $total_user = $this->input->post('total_user');
        $additional_data = array(
            'title' => $title,
        );
        if($this->admin_gympro_library->create_time_zones($additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    
    // ----------------------------------- Hourly Rates ---------------------------//
    public function manage_hourly_rates()
    {
        $this->data['hourly_rates_list'] = $this->admin_gympro_library->get_all_hourly_rates()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_hourly_rates", $this->data);
    }
    public function get_hourly_rates_info()
    {
        $result['hourly_rates_info'] = array();
        $hourly_rates_id = $this->input->post('id');
        $hourly_rates_info_array = $this->admin_gympro_library->get_hourly_rates_info($hourly_rates_id)->result_array();
        if(!empty($hourly_rates_info_array))
        {
            $result['hourly_rates_info'] = $hourly_rates_info_array[0];
        }
        echo json_encode($result);
    }
    public function delete_hourly_rates()
    {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->admin_gympro_library->delete_hourly_rates($delete_id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function update_hourly_rates()
    {
        $result = array();
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $additional_data = array(
            'title' => $title,
            'modified_on' => now()
        );
        if($this->admin_gympro_library->update_hourly_rates($id, $additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function create_hourly_rates()
    {
        $result = array();
        $title = $this->input->post('title');
        $additional_data = array(
            'title' => $title,
        );
        if($this->admin_gympro_library->create_hourly_rates($additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    
    // ----------------------------------- Currencies ---------------------------//
    public function manage_currencies()
    {
        $this->data['currencies_list'] = $this->admin_gympro_library->get_all_currencies()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_currencies", $this->data);
    }
    public function get_currencies_info()
    {
        $result['currencies_info'] = array();
        $currencies_id = $this->input->post('id');
        $currencies_info_array = $this->admin_gympro_library->get_currencies_info($currencies_id)->result_array();
        if(!empty($currencies_info_array))
        {
            $result['currencies_info'] = $currencies_info_array[0];
        }
        echo json_encode($result);
    }
    public function delete_currencies()
    {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->admin_gympro_library->delete_currencies($delete_id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function update_currencies()
    {
        $result = array();
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $additional_data = array(
            'title' => $title,
            'modified_on' => now()
        );
        if($this->admin_gympro_library->update_currencies($id, $additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function create_currencies()
    {
        $result = array();
        $title = $this->input->post('title');
        $additional_data = array(
            'title' => $title,
        );
        if($this->admin_gympro_library->create_currencies($additional_data))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    //------------------------------------------Program Module---------------------------//
    public function manage_programs()
    {
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_programs", $this->data);
    }
    
    //--------------------------------------------Review-----------------------
    public function manage_reviews() {
        $this->data['data_list'] = $this->admin_gympro_library->get_all_reviews()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_reviews", $this->data);
    }

    public function get_reviews_info() {
        $result['data_info'] = array();
        $data_id = $this->input->post('id');
        $data_info_array = $this->admin_gympro_library->get_reviews_info($data_id)->result_array();
        if (!empty($data_info_array)) {
            $result['data_info'] = $data_info_array[0];
        }
        echo json_encode($result);
    }

    public function delete_reviews() {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if ($this->admin_gympro_library->delete_reviews($delete_id)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    public function update_reviews() {
        $result = array();
        $id = $this->input->post('id');
        $additional_data = array(
            'title' => $this->input->post('input_update_a')
        );
        if ($this->admin_gympro_library->update_reviews($id, $additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    public function create_reviews() {
        $result = array();
        $additional_data = array(
            'title' => $this->input->post('input_a'),
        );
        if ($this->admin_gympro_library->create_reviews($additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    /*
     * This method will display all exercise categories
     * @author nazmul hasan on 5th November 2015
     */
    public function manage_exercise_categories()
    {
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['exercise_category_list'] = $this->admin_gympro_library->get_all_exercise_categories()->result_array();
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_exercise_categories", $this->data);
    }
    /*
     * This method will create a new exercise category
     * @author nazmul hasan on 5th November 2015
     */
    public function create_exercise_category()
    {
        $message = "";
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('title', 'Exercise Category Title', 'xss_clean|required');
        if ($this->input->post('submit_create_exercise_category'))
        {            
            if($this->form_validation->run() == true)
            {
                $additional_data = array(
                    'title' => $this->input->post('title'),
                    'type_id' => $this->input->post('exercise_type_list')
                );
                if($this->admin_gympro_model->create_exercise_category_info($additional_data))
                {
                    $this->session->set_flashdata('message', $this->admin_gympro_model->messages());
                    redirect('admin/applications_gympro/manage_exercise_categories','refresh');
                }
                else
                {
                    $message = $this->admin_gympro_model->errors();
                }
            }
            else
            {
                $message = validation_errors();
            }            
        }
        else
        {
            $message = $this->session->flashdata('message'); 
        }
        
        $exercise_type_list = array();
        $exercise_type_list_array = $this->admin_gympro_model->get_all_exercise_types()->result_array();
        foreach($exercise_type_list_array as $exercise_type_info)
        {
            $exercise_type_list[$exercise_type_info['exercise_type_id']] = $exercise_type_info['title'];
        }
        $this->data['exercise_type_list'] = $exercise_type_list;
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text'
        );
        $this->data['submit_create_exercise_category'] = array(
            'name' => 'submit_create_exercise_category',
            'id' => 'submit_create_exercise_category',
            'type' => 'submit',
            'value' => 'Create',
        );
        $this->data['message'] = $message;
        $this->template->load($this->tmpl, "admin/applications/gympro/create_exercise_category", $this->data);
    }
    /*
     * This method will update exercise category info
     * @param $category_id, exercise category id
     * @author nazmul hasan on 5th November 2015
     */
    public function update_exercise_category($category_id = 0)
    {
        if($category_id == 0)
        {
            redirect('admin/applications_gympro/manage_exercise_categories','refresh');
        }
        $message = "";
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('title', 'Exercise Category Title', 'xss_clean|required');
        if ($this->input->post('submit_update_exercise_category'))
        {            
            if($this->form_validation->run() == true)
            {
                $additional_data = array(
                    'title' => $this->input->post('title'),
                    'type_id' => $this->input->post('exercise_type_list')
                );
                if($this->admin_gympro_model->update_exercise_category_info($category_id, $additional_data))
                {
                    $this->session->set_flashdata('message', $this->admin_gympro_model->messages());
                    redirect('admin/applications_gympro/manage_exercise_categories','refresh');
                }
                else
                {
                    $message = $this->admin_gympro_model->errors();
                }
            }
            else
            {
                $message = validation_errors();
            }            
        }
        else
        {
            $message = $this->session->flashdata('message'); 
        }
        
        $exercise_type_list = array();
        $exercise_type_list_array = $this->admin_gympro_model->get_all_exercise_types()->result_array();
        foreach($exercise_type_list_array as $exercise_type_info)
        {
            $exercise_type_list[$exercise_type_info['exercise_type_id']] = $exercise_type_info['title'];
        }
        $this->data['exercise_type_list'] = $exercise_type_list;
        
        $exercise_category_info = array();
        $exercise_category_info_array = $this->admin_gympro_model->get_exercise_category_info($category_id)->result_array();
        if(!empty($exercise_category_info_array))
        {
            $exercise_category_info = $exercise_category_info_array[0];
        }
        else
        {
            redirect('admin/applications_gympro/manage_exercise_categories','refresh');
        }
        $this->data['exercise_category_info'] = $exercise_category_info;
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => $exercise_category_info['title'],
        );
        $this->data['submit_update_exercise_category'] = array(
            'name' => 'submit_update_exercise_category',
            'id' => 'submit_update_exercise_category',
            'type' => 'submit',
            'value' => 'Update',
        );
        $this->data['exercise_category_info'] = $exercise_category_info;
        $this->data['message'] = $message;
        $this->template->load($this->tmpl, "admin/applications/gympro/update_exercise_category", $this->data);
    }
    /*
     * Ajax call
     * This method will delete exercise category
     * @author nazmul hasan on 5th November 2015
     */
    public function delete_exercise_category()
    {
        $category_id = $this->input->post('category_id');
        $this->admin_gympro_model->delete_exercise_category($category_id);
        $response = array(
            'message' => "Exercise category is deleted successfully"
        );
        echo json_encode($response);
    }
    public function manage_exercise_subcategories($exercise_category_id = 0)
    {
        $this->data['exercise_subcategory_list'] = $this->admin_gympro_library->get_all_exercise_subcategories($exercise_category_id)->result_array();
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_exercise_subcategories", $this->data);
    }
    //------------------------------------------ Assessment Module ----------------------//
    public function manage_assessments()
    {
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_assessments", $this->data);
    }
    
//    ========================================reasses Module===========================
    
	public function manage_reassess() {
        $this->data['data_list'] = $this->admin_gympro_library->get_all_reassess()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_reassess", $this->data);
    }

    public function delete_reassess() {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if ($this->admin_gympro_library->delete_reassess($delete_id)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    public function create_reassess() {
        $result = array();
        $additional_data = array(
            'title' => $this->input->post('input_a'),
        );
        if ($this->admin_gympro_library->create_reassess($additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
 
    public function get_reassess_info() {
        $result['data_info'] = array();
        $data_id = $this->input->post('id');
        $data_info_array = $this->admin_gympro_library->get_reassess_info($data_id)->result_array();
        if (!empty($data_info_array)) {
            $result['data_info'] = $data_info_array[0];
        }
        echo json_encode($result);
    }

    public function update_reassess() {
        $result = array();
        $id = $this->input->post('id');
        $additional_data = array(
            'title' => $this->input->post('input_update_a')
        );
        if ($this->admin_gympro_library->update_reassess($id, $additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    //-------------------------------------------Nutrition-------------------------------//
    public function manage_nutritions()
    {
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_nutritions", $this->data);
    }
    //-------------------------------------------Meal Time-------------------------------//
    
	public function manage_meal_times() {
        $this->data['data_list'] = $this->admin_gympro_library->get_all_meal_times()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_meal_times", $this->data);
    }

    public function delete_meal_times() {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if ($this->admin_gympro_library->delete_meal_times($delete_id)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    public function create_meal_times() {
        $result = array();
        $additional_data = array(
            'title' => $this->input->post('input_a'),
        );
        if ($this->admin_gympro_library->create_meal_times($additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
 
    public function get_meal_times_info() {
        $result['data_info'] = array();
        $data_id = $this->input->post('id');
        $data_info_array = $this->admin_gympro_library->get_meal_times_info($data_id)->result_array();
        if (!empty($data_info_array)) {
            $result['data_info'] = $data_info_array[0];
        }
        echo json_encode($result);
    }

    public function update_meal_times() {
        $result = array();
        $id = $this->input->post('id');
        $additional_data = array(
            'title' => $this->input->post('input_update_a')
        );
        if ($this->admin_gympro_library->update_meal_times($id, $additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    //-------------------------------------------Workout-------------------------------//
    
	public function manage_workouts() {
        $this->data['data_list'] = $this->admin_gympro_library->get_all_workouts()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_workouts", $this->data);
    }

    public function delete_workouts() {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if ($this->admin_gympro_library->delete_workouts($delete_id)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    public function create_workouts() {
        $result = array();
        $additional_data = array(
            'title' => $this->input->post('input_a'),
        );
        if ($this->admin_gympro_library->create_workouts($additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
 
    public function get_workouts_info() {
        $result['data_info'] = array();
        $data_id = $this->input->post('id');
        $data_info_array = $this->admin_gympro_library->get_workouts_info($data_id)->result_array();
        if (!empty($data_info_array)) {
            $result['data_info'] = $data_info_array[0];
        }
        echo json_encode($result);
    }

    public function update_workouts() {
        $result = array();
        $id = $this->input->post('id');
        $additional_data = array(
            'title' => $this->input->post('input_update_a')
        );
        if ($this->admin_gympro_library->update_workouts($id, $additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
// ----------------------------------- Session Module ----------------------------------------//
    /*
     * This method will show session home page of admin panel
     * @Author Nazmul on 22nd January 2015
     */
    public function manage_sessions()
    {
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/session/index", $this->data);
    }
    
    // -------------------------------- Session repeat Module ----------------------------//
   
    
    /*
     * From submit
     * @Author Rashida on 7th february 2015
     * this method create session repeat
     */
    
    public function create_session_repeat()
    {
        $this->data['message'] = '';
        $this->form_validation->set_rules('title', 'Title', 'xss_clean|required');
        if($this->input->post('create_repeat_button'))
        {
            if ($this->form_validation->run() == true) 
            {
                $data = array(
                    'title' => $this->input->post('title'),
                );
                $repeat_id = $this->admin_gympro_library->create_session_repeat($data);
                if($repeat_id!=FALSE)
                {
                    $this->data['message'] = $this->admin_gympro_library->messages();
                }
                else
                {
                    $this->data['message'] = $this->admin_gympro_library->messages();
                }
            }
            else
            {
                $this->data['message'] = validation_errors();
            }
        }
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text'
        );
         $this->data['create_repeat_button'] = array(
            'name' => 'create_repeat_button',
            'id' => 'create_repeat_button',
            'type' => 'submit',
            'value' => 'Submit'
        );
     $this->template->load($this->tmpl,'admin/applications/gympro/session/create_repeat',$this->data);   
    }
    
    /*
     * @Author Rashida on 7th february 2015
     * this method return session all repeats
     */
    
    public function session_repeat_list()
    {
        $this->data['message'] = '';
        $session_repeat_list = array();
        $session_repeat_list_array = $this->admin_gympro_library->get_all_session_repeats()->result_array();
        if(!empty($session_repeat_list_array))
        {
          $session_repeat_list= $session_repeat_list_array; 
        }
        $this->data['session_repeat_list'] = $session_repeat_list;
        $this->template->load($this->tmpl, "admin/applications/gympro/session/repeat_list", $this->data);
    }
    
    /*
     * @Author Rashida on 7th february 2015
     * this method return session repeat by repeat id
     */
    
    public function get_session_repeat_info() 
    {
        $result['repeat_info'] = array();
        $repeat_id = $this->input->post('repeat_id');
        $repeat_info_array = $this->admin_gympro_library->get_session_repeat_info($repeat_id)->result_array();
        if (!empty($repeat_info_array)) {
            $result['repeat_info'] = $repeat_info_array[0];
        }
        echo json_encode($result);
    }
    
     /*
     * Ajax call
     * @Author Rashida on 7th february 2015
     * this method update a session repeat
     */
    
    public function update_session_repeat() 
    {
        $result = array();
        $repeat_id = $this->input->post('repeat_id');
        $additional_data = array(
            'title' => $this->input->post('repeat_title')
        );
        if ($this->admin_gympro_library->update_session_repeat($repeat_id, $additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
     /*
     * Ajax call
     * @Author Rashida on 7th february 2015
     * this method delete a session repeat
     */
    
    public function delete_session_repeat()
    {
        $result = array();
        $repeat = $this->input->post('repeat_id');
        if($this->admin_gympro_library->delete_session_repeat($repeat))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    
    
    // -------------------------------- Session Type Module ----------------------------//
    
    
    /*
     * From Submit
     * @Author Rashida on 7th february 2015
     * this method create session type
     */
    public function create_session_type()
    {
        $this->data['message'] = '';
        $this->form_validation->set_rules('title', 'Title', 'xss_clean|required');
        if($this->input->post('create_type_button'))
        {
            if ($this->form_validation->run() == true) 
            {
                $data = array(
                    'title' => $this->input->post('title'),
                );
                $type_id = $this->admin_gympro_library->create_session_type($data);
                if($type_id!=FALSE)
                {
                    $this->data['message'] = $this->admin_gympro_library->messages();
                }
                else
                {
                    $this->data['message'] = $this->admin_gympro_library->messages();
                }
            }
            else
            {
                $this->data['message'] = validation_errors();
            }
        }
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text'
        );
         $this->data['create_type_button'] = array(
            'name' => 'create_type_button',
            'id' => 'create_type_button',
            'type' => 'submit',
            'value' => 'Submit'
        );
     $this->template->load($this->tmpl,'admin/applications/gympro/session/create_type',$this->data);   
    }
    
     /*
     * @Author Rashida on 7th february 2015
     * this method return session all types
     */
    
    public function session_type_list()
    {
        $this->data['message'] = '';
        $session_type_list = array();
        $session_type_list_array = $this->admin_gympro_library->get_all_session_types()->result_array();
        if(!empty($session_type_list_array))
        {
          $session_type_list= $session_type_list_array; 
        }
        $this->data['session_type_list'] = $session_type_list;
        $this->template->load($this->tmpl, "admin/applications/gympro/session/type_list", $this->data);
    }
    
     /*
     * @Author Rashida on 7th february 2015
     * this method return session type by repeat id 
     */
    
    public function get_session_type_info() 
    {
        $result['type_info'] = array();
        $type_id = $this->input->post('type_id');
        $type_info_array = $this->admin_gympro_library->get_session_type_info($type_id)->result_array();
        if (!empty($type_info_array)) {
            $result['type_info'] = $type_info_array[0];
        }
        echo json_encode($result);
    }
    
     /*
     * Ajax call
     * @Author Rashida on 7th february 2015
     * this method update a session type 
     */
    public function update_session_type()
    {
        $result = array();
        $type_id = $this->input->post('type_id');
        $additional_data = array(
            'title' => $this->input->post('type_title')
        );
        if ($this->admin_gympro_library->update_session_type($type_id, $additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    /*
     * Ajax call
     * @Author Rashida on 7th february 2015
     * this method delete a sessiopn type 
     */
    
    public function delete_session_type()
    {
        $result = array();
        $type_id = $this->input->post('type_id');
        if($this->admin_gympro_library->delete_session_type($type_id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
   // -------------------------------- Session Time Module ----------------------------//
    
    /*
     * From submit
     * @Author Rashida on 7th february 2015
     * this method create session time 
     */
    
    public function create_session_time()
    {
        $this->data['message'] = '';
        $this->form_validation->set_rules('title', 'Title', 'xss_clean|required');
        if($this->input->post('create_time_button'))
        {
            if ($this->form_validation->run() == true) 
            {
                $data = array(
                    'title' => $this->input->post('title'),
                    'title_24' => $this->input->post('title_24'),
                );
                $time_id = $this->admin_gympro_library->create_session_time($data);
                if($time_id!=FALSE)
                {
                    $this->data['message'] = $this->admin_gympro_library->messages();
                }
                else
                {
                    $this->data['message'] = $this->admin_gympro_library->messages();
                }
            }
            else
            {
                $this->data['message'] = validation_errors();
            }
        }
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text'
        );
        $this->data['title_24'] = array(
            'name' => 'title_24',
            'id' => 'title_24',
            'type' => 'text'
        );
         $this->data['create_time_button'] = array(
            'name' => 'create_time_button',
            'id' => 'create_time_button',
            'type' => 'submit',
             'value' => 'Submit'
        );
     $this->template->load($this->tmpl,'admin/applications/gympro/session/create_time', $this->data);   
    }
    
    /*
     * @Author Rashida on 7th february 2015
     * this method return session all times
     */
    
    public function session_time_list()
    {
        $this->data['message'] = '';
        $session_time_list = array();
        $session_time_list_array = $this->admin_gympro_library->get_all_session_times()->result_array();
        if(!empty($session_time_list_array))
        {
          $session_time_list= $session_time_list_array; 
        }
        $this->data['session_time_list'] = $session_time_list;
        $this->template->load($this->tmpl, "admin/applications/gympro/session/time_list", $this->data);
    }
    
     /*
     * @Author Rashida on 7th february 2015
     * this method return session time by time id
     */
    
    public function get_session_time_info() 
    {
        $result['time_info'] = array();
        $time_id = $this->input->post('time_id');
        $time_info_array = $this->admin_gympro_library->get_session_time_info($time_id)->result_array();
        if (!empty($time_info_array)) {
            $result['time_info'] = $time_info_array[0];
        }
        echo json_encode($result);
    }
    
     /*
     *Ajax call
     * @Author Rashida on 7th february 2015
     * this method update a session time
     */
    public function update_session_time() 
    {
        $result = array();
        $time_id = $this->input->post('time_id');
        $additional_data = array(
            'title' => $this->input->post('input_update_title'),
            'title_24' => $this->input->post('input_update_title_24')
        );
        if ($this->admin_gympro_library->update_session_time($time_id, $additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    
    /*
     *Ajax call
     * @Author Rashida on 7th february 2015
     * this method delete a session time
     */
    
    public function delete_session_time()
    {
        $result = array();
        $time_id = $this->input->post('time_id');
        if($this->admin_gympro_library->delete_session_time($time_id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    // -------------------------------- Session Cost Module ----------------------------//
    
    /*
     *From submit 
     * @Author Rashida on 7th february 2015
     * this method create session cost
     */
    
    public function create_session_cost()
    {
        $this->data['message'] = '';
        $this->form_validation->set_rules('title', 'Title', 'xss_clean|required');
        if($this->input->post('create_cost_button'))
        {
            if ($this->form_validation->run() == true) 
            {
                $data = array(
                    'title' => $this->input->post('title'),
                );
                $cost_id = $this->admin_gympro_library->create_session_cost($data);
                if($cost_id!=FALSE)
                {
                    $this->data['message'] = $this->admin_gympro_library->messages();
                }
                else
                {
                    $this->data['message'] = $this->admin_gympro_library->messages();
                }
            }
            else
            {
                $this->data['message'] = validation_errors();
            }
        }
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text'
        );
         $this->data['create_cost_button'] = array(
            'name' => 'create_cost_button',
            'id' => 'create_cost_button',
            'type' => 'submit',
             'value' => 'Submit'
        );
     $this->template->load($this->tmpl,'admin/applications/gympro/session/create_cost', $this->data);   
    }
    
     /*
     * @Author Rashida on 7th february 2015
     * this method return session all costs
     */
    
    public function session_cost_list()
    {
        $this->data['message'] = '';
        $session_cost_list = array();
        $session_cost_list_array = $this->admin_gympro_library->get_all_session_costs()->result_array();
        if(!empty($session_cost_list_array))
        {
          $session_cost_list= $session_cost_list_array; 
        }
        $this->data['session_cost_list'] = $session_cost_list;
        $this->template->load($this->tmpl, "admin/applications/gympro/session/cost_list", $this->data);
    }
    
     /*
     * @Author Rashida on 7th february 2015
     * this method return session cost by cost id 
     */
    
    public function get_session_cost_info() 
    {
        $result['cost_info'] = array();
        $cost_id = $this->input->post('cost_id');
        $cost_info_array = $this->admin_gympro_library->get_session_cost_info($cost_id)->result_array();
        if (!empty($cost_info_array)) {
            $result['cost_info'] = $cost_info_array[0];
        }
        echo json_encode($result);
    }
    
     /*
     *Ajax call 
     * @Author Rashida on 7th february 2015
     * this method update a session cost 
     */
    
    public function update_session_cost()
    {
        $result = array();
        $cost_id = $this->input->post('cost_id');
        $additional_data = array(
            'title' => $this->input->post('cost_title')
        );
        if ($this->admin_gympro_library->update_session_cost($cost_id, $additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    /*
     * Ajax call
     * @Author Rashida on 7th february 2015
     * this method delete a session cost 
     */
    
    public function delete_session_cost()
    {
        $result = array();
        $cost_id = $this->input->post('cost_id');
        if($this->admin_gympro_library->delete_session_cost($cost_id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    // -------------------------------- Session Status  Module ----------------------------//
    
    /*
     * form submit
     * @Author Rashida on 7th february 2015
     * this method create session ststus 
     */
    
    public function create_session_status()
    {
        $this->data['message'] = '';
        $this->form_validation->set_rules('title', 'Title', 'xss_clean|required');
        if($this->input->post('create_status_button'))
        {
            if ($this->form_validation->run() == true) 
            {
                $data = array(
                    'title' => $this->input->post('title'),
                );
                $status_id = $this->admin_gympro_library->create_session_status($data);
                if($status_id!=FALSE)
                {
                    $this->data['message'] = $this->admin_gympro_library->messages();
                }
                else
                {
                    $this->data['message'] = $this->admin_gympro_library->messages();
                }
            }
            else
            {
                $this->data['message'] = validation_errors();
            }
        }
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text'
        );
         $this->data['create_status_button'] = array(
            'name' => 'create_status_button',
            'id' => 'create_status_button',
            'type' => 'submit',
             'value' => 'Submit'
        );
     $this->template->load($this->tmpl,'admin/applications/gympro/session/create_status', $this->data);   
    }
    
    /*
     * @Author Rashida on 7th february 2015
     * this method return session all statuses
     */
    
    public function session_status_list()
    {
        $this->data['message'] = '';
        $session_status_list = array();
        $session_status_list_array = $this->admin_gympro_library->get_all_session_statuses()->result_array();
        if(!empty($session_status_list_array))
        {
          $session_status_list= $session_status_list_array; 
        }
        $this->data['session_status_list'] = $session_status_list;
        $this->template->load($this->tmpl, "admin/applications/gympro/session/status_list", $this->data);
    }
    
    /*
     * @Author Rashida on 7th february 2015
     * this method return session status by status id
     */
    public function get_session_status_info()
    {
        $result['status_info'] = array();
        $status_id = $this->input->post('status_id');
        $status_info_array = $this->admin_gympro_library->get_session_status_info($status_id)->result_array();
        if (!empty($status_info_array)) {
            $result['status_info'] = $status_info_array[0];
        }
        echo json_encode($result);
    }
    
    /*
     * Ajax call
     * @Author Rashida on 7th february 2015
     * this method update a session status
     */
    
    public function update_session_status() 
    {
        $result = array();
        $status_id = $this->input->post('status_id');
        $additional_data = array(
            'title' => $this->input->post('status_title')
        );
        if ($this->admin_gympro_library->update_session_status($status_id, $additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    /*
     * Ajax call
     * @Author Rashida on 7th february 2015
     * this method delete a session status
     */
    
    public function delete_session_status()
    {
        $result = array();
        $status_id = $this->input->post('status_id');
        if($this->admin_gympro_library->delete_session_status($status_id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    
    
    
    
    
    
    
   
    
    
    
    
    
    
//====================================TEMPLATE=========================================
/*

	public function manage_module_name() {
        $this->data['data_list'] = $this->admin_gympro_library->get_all_module_name()->result_array();
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_module_name", $this->data);
    }

    public function delete_module_name() {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if ($this->admin_gympro_library->delete_module_name($delete_id)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    public function create_module_name() {
        $result = array();
        $additional_data = array(
            'title' => $this->input->post('input_a'),
        );
        if ($this->admin_gympro_library->create_module_name($additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
 
    public function get_module_name_info() {
        $result['data_info'] = array();
        $data_id = $this->input->post('id');
        $data_info_array = $this->admin_gympro_library->get_module_name_info($data_id)->result_array();
        if (!empty($data_info_array)) {
            $result['data_info'] = $data_info_array[0];
        }
        echo json_encode($result);
    }

    public function update_module_name() {
        $result = array();
        $id = $this->input->post('id');
        $additional_data = array(
            'title' => $this->input->post('input_update_a')
        );
        if ($this->admin_gympro_library->update_module_name($id, $additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

*/
}
