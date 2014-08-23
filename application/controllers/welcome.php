<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('follower');
        $this->load->library('likes');
        $this->load->library('shares');
        $this->load->library("org/utility/utils");
        $this->load->helper('url');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    public function index() {
        //$this->template->load("templates/profile_setting_tmpl", "business_man/album/add_photo");
        //$this->data['followers'] = $this->follower->get_followers();
        //$this->template->load("templates/member_tmpl", "welcome_message", $this->data);
        //$this->load->view("maptest");
        $query = $this->db->select("*")
                          ->where("id", "2")
                          ->from("users");
        
                
    }
    public function test(){
        //$this->template->load("nonmember/templates/tmpl1", "");
        //print_r($this->follower->get_followers(2));
        //print_r($this->shares->share_status(3,5));
        //print_r($this->ion_auth->get_users(array(2)));
        $this->load->view("welcome_message");
    }
    
    public function test1()
    {
        //$now = now();
        $user_info = $this->ion_auth->get_user_info();
        echo(unix_to_human(1394128850));
        echo($this->utils->get_unix_to_human_local(1394128850, $user_info));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */