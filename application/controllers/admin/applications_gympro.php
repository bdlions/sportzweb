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
    
    
    
    
    
    
    public function manage_exercise_categories()
    {
        $this->data['exercise_category_list'] = $this->admin_gympro_library->get_all_exercise_categories()->result_array();
        $this->template->load($this->tmpl, "admin/applications/gympro/manage_exercise_categories", $this->data);
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
    
    // -------------------------------- Session Module ----------------------------//
    /*
     * This method will show session home page of admin panel
     * @Author Nazmul on 22nd January 2015
     */
    public function manage_sessions()
    {
        $this->data['message'] = '';
        $this->template->load($this->tmpl, "admin/applications/gympro/session/index", $this->data);
    }
    /*
     * This method will show session repeat list
     * @Author Nazmul on 22nd January 2015
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
    public function get_repeat_info() {
        $result['data_info'] = array();
        $data_id = $this->input->post('id');
        $data_info_array = $this->admin_gympro_library->get_repeat_info($data_id)->result_array();
        if (!empty($data_info_array)) {
            $result['data_info'] = $data_info_array[0];
        }
        echo json_encode($result);
    }
    public function update_repeat() {
        $result = array();
        $id = $this->input->post('id');
        $additional_data = array(
            'title' => $this->input->post('input_update_a')
        );
        if ($this->admin_gympro_library->update_repeat($id, $additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function delete_session_repeat()
    {
        $result = array();
        $id = $this->input->post('id');
        if($this->admin_gympro_library->delete_session_repeat($id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    /*
     * This method will show session type list
     * @Author Nazmul on 22nd January 2015
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
    public function get_type_info() {
        $result['data_info'] = array();
        $data_id = $this->input->post('id');
        $data_info_array = $this->admin_gympro_library->get_type_info($data_id)->result_array();
        if (!empty($data_info_array)) {
            $result['data_info'] = $data_info_array[0];
        }
        echo json_encode($result);
    }
    public function update_type() {
        $result = array();
        $id = $this->input->post('id');
        $additional_data = array(
            'title' => $this->input->post('input_update_a')
        );
        if ($this->admin_gympro_library->update_type($id, $additional_data)) {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        } else {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    public function delete_session_type()
    {
        $result = array();
        $id = $this->input->post('id');
        if($this->admin_gympro_library->delete_session_type($id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    /*
     * This method will show session time list
     * @Author Nazmul on 22nd January 2015
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
    public function delete_session_time()
    {
        $result = array();
        $id = $this->input->post('id');
        if($this->admin_gympro_library->delete_session_time($id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    /*
     * This method will show session cost list
     * @Author Nazmul on 22nd January 2015
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
    public function delete_session_cost()
    {
        $result = array();
        $id = $this->input->post('id');
        if($this->admin_gympro_library->delete_session_cost($id))
        {
            $result['message'] = $this->admin_gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    /*
     * This method will show session status list
     * @Author Nazmul on 22nd January 2015
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
    public function delete_session_status()
    {
        $result = array();
        $id = $this->input->post('id');
        if($this->admin_gympro_library->delete_session_status($id))
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
