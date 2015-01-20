<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Login_attempt extends CI_Controller{
    public $tmpl = '';
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        
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
        $login_attempt_list[] = array(
            'id' => 1,
            'ip_address' => '127.0.0.1',
            'login' => 'bdlions@gmail.com',
            'time' => '21-01-2015 10:00AM'
        );
        $login_attempt_list[] = array(
            'id' => 2,
            'ip_address' => '127.0.0.1',
            'login' => 'bdlions@gmail.com',
            'time' => '21-01-2015 10:01AM'
        );
        $login_attempt_list[] = array(
            'id' => 3,
            'ip_address' => '127.0.0.1',
            'login' => 'bdlions@gmail.com',
            'time' => '21-01-2015 10:02AM'
        );
        $this->data['login_attempt_list'] = $login_attempt_list;
        $this->template->load($this->tmpl, "admin/login_attempt/index", $this->data);
    }
    
    /*
     * Ajax call
     * This method will delete login attempt
     * @Author Nazmul on 20th January 2015
     */
    public function delete_login_attempt()
    {
        
    }
}