<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Login_attempt extends CI_Controller{
    public $tmpl = '';
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('org/admin/admin_login_attemtps_library');
        $this->load->helper('url');
        $this->load->library('org/utility/Utils');
        
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }
        $this->tmpl = ADMIN_DASHBOARD_TEMPLATE;
    }
    
    /*
     * This method will load wrong login attempts list
     * @Author Nazmul on 20th January 2015
     */
    function index()
    {
        $this->data['message'] = '';
        $login_attempt_list = array();
        $login_attempts = array();
        $login_attempt_list_array = $this->admin_login_attemtps_library->get_all_login_attempts()->result_array();
        if(!empty($login_attempt_list_array))
        {
            $login_attempt_list = $login_attempt_list_array; 
        }
        foreach ($login_attempt_list as $value) {
            $value['time'] = $this->utils->get_unix_to_human_date($value['time'], 1);
            $login_attempts[] = $value;
        }
        $this->data['login_attempt_list'] = $login_attempts;
        $this->template->load($this->tmpl, "admin/login_attempt/index", $this->data);
    }
    
    /*
     * Ajax call
     * This method will delete login attempt
     * @Author Nazmul on 20th January 2015
     */
    public function delete_login_attempt()
    {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->admin_login_attemtps_library->delete_login_attempt($delete_id))
        {
            $result['message'] = $this->admin_login_attemtps_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_login_attemtps_library->errors_alert();
        }
        echo json_encode($result);
    }
}