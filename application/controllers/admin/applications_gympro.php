<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Applications_gympro extends CI_Controller{
    public $tmpl = '';
    public $user_group_array = array();
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('org/admin/application/admin_gympro_library.php');
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
        $price = $this->input->post('price');
        $total_user = $this->input->post('total_user');
        $additional_data = array(
            'title' => $title,
            'price' => $price,
            'total_user' => $total_user,
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
        $price = $this->input->post('price');
        $total_user = $this->input->post('total_user');
        $additional_data = array(
            'title' => $title,
            'price' => $price,
            'total_user' => $total_user
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
        $title = $this->input->post('title');
        $total_user = $this->input->post('total_user');
        $additional_data = array(
            'title' => $title,
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
        $title = $this->input->post('title');
        $additional_data = array(
            'title' => $title
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
}

